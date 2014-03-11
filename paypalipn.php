<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
require("paypal_ipn.php");
//End Include Common Files
$EP = array(
                "EMAIL:SITE_NAME" => $now["sitename"],
                "EMAIL:SITE_EMAIL" => $now["siteemail"],
                "EMAIL:SITE_EMAIL_LINK" => "<a href=\"mailto:" . $now["siteemail"] . "\">" . $now["siteemail"] . "</a>",
                "EMAIL:HOME_URL" => $now["homeurl"],
                "EMAIL:HOME_PAGE_LINK" => "<a href=\"" . $now["homeurl"] . "index.php\">Home</a>",
                "EMAIL:BROWSE_LINK" => "<a href=\"" . $now["homeurl"] . "browse.php\">Browse</a>",
                "EMAIL:SEARCH_LINK" => "<a href=\"" . $now["homeurl"] . "search.php\">Search</a>",
                "EMAIL:MY_ACCOUNT_LINK" => "<a href=\"" . $now["homeurl"] . "myaccount.php\">My Account</a>",
                "EMAIL:PAYMENT_LINK_SSL" => "<a href=\"" . $now["secureurl"] . "MakePayment.php\">Make a Payment</a>",
                "EMAIL:PAYMENT_LINK" => "<a href=\"" . $now["homeurl"] . "MakePayment.php\">Make a Payment</a>",
                "EMAIL:CURRENCY" => $charges["currency"],
                "EMAIL:LISTING_FEE" => $charges["listing_fee"],
                "EMAIL:HOMEPAGE_FEATURED_FEE" => $charges["homepage_fee"],
                "EMAIL:CATEGORY_FEATURED_FEE" => $charges["category_fee"],
                "EMAIL:GALLERY_FEE" => $charges["gallery_fee"],
                "EMAIL:IMAGE_PREVIEW_FEE" => $charges["image_preview_fee"],
                "EMAIL:SLIDE_SHOW_FEE" => $charges["slide_fee"],
                "EMAIL:COUNTER_FEE" => $charges["counter_fee"],
                "EMAIL:BOLD_FEE" => $charges["bold_fee"],
                "EMAIL:BACKGROUND_FEE" => $charges["highlight_fee"],
                "EMAIL:IMAGE_UPLOAD_FEE" => $charges["upload_fee"],
                "EMAIL:CURRENT_TIME" => date("F j, Y, g:i a")
                );
$item_name = $_POST['item_name'];
$receiver_email = $_POST['receiver_email'];
$item_number = $_POST['item_number'];
$invoice = $_POST['invoice'];
$payment_status = $_POST['payment_status'];
$payment_gross = $_POST['mc_gross'];
$txn_id = $_POST['txn_id'];
$payer_email = $_POST['payer_email'];
$payer_id = $_POST['custom'];
// PayPal will send the information through a POST
$paypal_info = $_POST;

$paypal_ipn = new paypal_ipn($paypal_info);

// where to contact us if something goes wrong
$paypal_ipn->error_email = $now["siteemail"];

// We send an identical response back to PayPal for verification
$paypal_ipn->send_response();

// PayPal will tell us whether or not this order is valid.
// This will prevent people from simply running your order script
// manually
if( !$paypal_ipn->is_verified() )
{
        // bad order, someone must have tried to run this script manually
        $paypal_ipn->error_out("Bad order (PayPal says it's invalid)");
}

// payment status
switch( $paypal_ipn->get_payment_status() )
{
        case 'Completed':
                // order is good
        break;

        case 'Pending':
                // money isn't in yet, just quit.
                // paypal will contact this script again when it's ready
                $paypal_ipn->error_out("Pending Payment");
        break;

        case 'Failed':
                // whoops, not enough money
                $paypal_ipn->error_out("Failed Payment");
        break;

        case 'Denied':
                // denied payment by us
                // not sure what causes this one
                $paypal_ipn->error_out("Denied Payment");
        break;

        default:
                // order is no good
                $paypal_ipn->error_out("Unknown Payment Status" . $paypal_ipn->get_payment_status());
        break;

} // end switch



$date = date("D M j G:i:s T Y", time());

$message .= "\n\nThe following info was received from PayPal - $date:\n\n";
@reset($paypal_info);
while( @list($key,$value) = @each($paypal_info) )
{
        $message .= $key . ':' . " \t$value\n";
}
//mail($now["siteemail"], "[$date] PayPal PN " . $payer_id . " and " . $payment_gross, $message);

   $lookdb = new clsDBNetConnect;
   $lookdb->connect();
   if($payer_id) {
          $lookdb->query("SELECT * FROM users WHERE user_id='" . $payer_id . "'");
          if($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "last" => $lookdb->f("last_name"),
                        "user_login" => $lookdb->f("user_login"),
                        "email" => $lookdb->f("email"),
                        "address" => $lookdb->f("address1"),
                        "address2" => $lookdb->f("address2"),
                        "state" => $lookdb->f("state_id"),
                        "zip" => $lookdb->f("zip"),
                        "city" => $lookdb->f("city"),
                        "phonedy" => $lookdb->f("phone_day"),
                        "phoneevn" => $lookdb->f("phone_evn"),
                        "fax" => $lookdb->f("fax"),
                        "ip" => $lookdb->f("ip_insert"),
                        "date_created" => $lookdb->f("date_created"),
                        );
          }
   }
   $EP["EMAIL:PAYMENT_SUBJECT"] = "PayPal Deposit";
   $EP["EMAIL:PAYMENT_AMOUNT"] = $charges["currency"] . $payment_gross;
   $EP["EMAIL:PAYER_EMAIL"] = $payer_email;
   $EP["EMAIL:CURRENT_USERNAME"] = $ld["user_login"];
   $EP["EMAIL:CURRENT_USERID"] = $ld["ID"];
   $EP["EMAIL:CURRENT_USER_FIRST_NAME"] = $ld["first"];
   $EP["EMAIL:CURRENT_USER_LAST_NAME"] = $ld["last"];
   $EP["EMAIL:CURRENT_USER_EMAIL"] = $ld["email"];
   $EP["EMAIL:CURRENT_USER_ADDRESS"] = $ld["address"];
   $EP["EMAIL:CURRENT_USER_ADDRESS2"] = $ld["address2"];
   $EP["EMAIL:CURRENT_USER_STATE"] = $ld["state"];
   $EP["EMAIL:CURRENT_USER_CITY"] = $ld["city"];
   $EP["EMAIL:CURRENT_USER_ZIP"] = $ld["zip"];
   $EP["EMAIL:CURRENT_USER_DAY_PHONE"] = $ld["phonedy"];
   $EP["EMAIL:CURRENT_USER_EVN_PHONE"] = $ld["phoneevn"];
   $EP["EMAIL:CURRENT_USER_FAX"] = $ld["fax"];
   $EP["EMAIL:CURRENT_USER_IP"] = getenv("REMOTE_ADDR");
   $EP["EMAIL:CURRENT_USER__REGISTERED_IP"] = $ld["ip"];
   $EP["EMAIL:CURRENT_USER_DATE_SIGNEDUP"] = date("F j, Y, g:i a", $ld["date_created"]);
   if($receiver_email)
   {
        if(ltrim(end(explode("-", $item_name))) == "BuyNow"){
			$info = explode("-", $payer_id);
			$buyer_id = $info[0];
			$ItemNum = $info[1];
			$shipping = $info[2];
			$buy = new clsDBNetConnect;
			$buy->query("select * from items where ItemNum = '" . $ItemNum . "'");
			if($buy->next_record()){
				if ($shipping != "999999") {
					$shipfee = $buy->f("shipfee" . $shipping);
					$asking_price = $buy->f("asking_price");
					$totalfee = ($shipfee + $asking_price);
					$shippingtext = $buy->f("ship" . $shipping) . ":  $" . $buy->f("shipfee" . $shipping);
				}
				else {
					$shipfee = 0;
					$shippingtext = "No Shipping Specified:  \$0.00";
				    $totalfee = $buy->f("asking_price");
				}
				if ($totalfee == $payment_gross){
					$purchase = new clsDBNetConnect;
					$query = "insert into `purchases` (`ItemNum`, `date`, `title`, `asking`, `amt_received`, `shipping`, `user_id`, `buyer`, `user_paypal`, `buyer_paypal`, `txn_id`) values ('" . $ItemNum . "', '" . time() . "', '" . mysql_escape_string($buy->f("title")) . "', '" . mysql_escape_string($buy->f("asking_price")) . "', '" . $payment_gross . "', '" . mysql_escape_string($shippingtext) . "', '" . mysql_escape_string($buy->f("user_id")) . "', '" . $buyer_id . "', '" . $receiver_email . "', '" . $payer_email . "', '" . $txn_id . "')";
					
					$purchase->query($query);
					$quantity = ($buy->f("quantity")-1);
					$update = new clsDBNetConnect;
					if ($quantity < 1){
						$update->query("update items set status = '2', quantity = '0', end_reason = 'Item Purchased Via Paypal: " . $txn_id . "' where ItemNum = $item_number");
						$update->query("delete from listing_index where `ItemNum` = '" . $item_number . "'");
						subtract_catcounts($buy->f("category"));
					}
					else
					    $update->query("update items set quantity = '" . $quantity . "' where ItemNum = $item_number");
					if ($shipping) {
						$ship_method = $buy->f("ship" . $shipping);
						$ship_fee = $buy->f("shipfee" . $shipping);
					}
					else {
						$ship_method = "No Shipping Method Specified";
						$ship_fee = "No Shipping Fee Specified";
					}
					$item_title = $buy->f("title");
					$seller = new clsDBNetConnect;
					$seller->query("select * from users where user_id = '" . $buy->f("user_id") . "'");
					if ($seller->next_record()) {
						$EP["EMAIL:ITEMTITLE"] = $item_title;
						$EP["EMAIL:ITEMNUM"] = $item_number;
						$EP["EMAIL:SELLER_USERNAME"] = $seller->f("user_login");
						$EP["EMAIL:SELLER_EMAIL"] = $seller->f("email");
						$EP["EMAIL:SELLER_FIRST_NAME"] = $seller->f("first_name");
						$EP["EMAIL:SELLER_LAST_NAME"] = $seller->f("last_name");
						$EP["EMAIL:SHIPPING_METHOD"] = $ship_method;
						$EP["EMAIL:SHIPPING_FEE"] = $ship_fee;
						mailout("UserPurchase", 1, $payer_id, 1000000000, time(), $EP);
                    	mailout("UserPurchase", 1, $buy->f("user_id"), 1000000000, time(), $EP);
                   }
                }
			}
		}
		elseif(ltrim(end(explode("-", $item_name))) == "StartListing"){
			if($payer_id) {
				include("StartListing_events.php");
				$info = explode("-", $payer_id);
				$buyer_id = $info[0];
				$ItemNum = $info[1];
          		$lookdb->query("SELECT * FROM items WHERE ItemNum='" . $ItemNum . "'");
          		if($lookdb->next_record()) {
          			$sum = new clsDBNetConnect;
          			if ($lookdb->f("amt_due") == $payment_gross || $lookdb->f("amt_due") < $payment_gross){
          				if ($lookdb->f("acct_credit_used") > 0){
							$query = "SELECT sum(charge) FROM `charges` WHERE user_id = " . $buyer_id;
							$sum->query($query);
							if ($sum->next_record()){
								if ($sum->f("sum(charge)") >= $lookdb->f("acct_credit_used")){
									$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('-" . $lookdb->f("acct_credit_used") . "', '" . mysql_escape_string($buyer_id) . "', 'Credit Used for Item Number $ItemNum', '" . time() . "')";
									$sum->query($query);
									$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment made for Item Number $ItemNum', '" . time() . "')";
									$sum->query($query);
									$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('-" . $lookdb->f("amt_due") . "', '" . mysql_escape_string($buyer_id) . "', 'Payment used to start Item Number $ItemNum', '" . time() . "')";
									$sum->query($query);
									startlistingnow($ItemNum, $buyer_id);
								}
								else {
									$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment for Item Number $ItemNum  :: Error - Account Credit Amount Invalid - Amount paid has been added to your account, but your listing has not been started', '" . time() . "')";
									$sum->query($query);
									$failed = "Error: Account Credit Amount Invalid - Amount paid has been added to your account, but your listing has not been started";
								}						
							}	
						}
						elseif	($lookdb->f("amt_due") < $payment_gross){
							$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment made for Item Number $ItemNum', '" . time() . "')";
							$sum->query($query);
							$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('-" . $lookdb->f("amt_due") . "', '" . mysql_escape_string($buyer_id) . "', 'Payment used to start Item Number $ItemNum', '" . time() . "')";
							$sum->query($query);
							startlistingnow($ItemNum, $buyer_id);
						}
						else {
							$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment made for Item Number $ItemNum', '" . time() . "')";
							$sum->query($query);
							$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('-" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment used to start Item Number $ItemNum', '" . time() . "')";
							$sum->query($query);
							startlistingnow($ItemNum, $buyer_id);
						}
          			}
          			elseif ($lookdb->f("amt_due") > $payment_gross){
          				$query = "insert into charges (`charge`, `user_id`, `cause`, `date`) values ('" . $payment_gross . "', '" . mysql_escape_string($buyer_id) . "', 'Payment for Item Number $ItemNum  :: Error - The Amount Paid Was Less Than The Amount Due - Amount paid has been added to your account, but your listing has not been started', '" . time() . "')";
						$sum->query($query);
						$failed = "Error: The Amount Paid Was Less Than The Amount Due - Amount paid has been added to your account, but your listing has not been started";
          			}
          		}
   			}	
		}
		elseif(ltrim(end(explode("-", $item_name))) == "Subscription"){
			subscribe($payer_id, $item_number, $payment_gross);
			if($payer_id) {
          		$lookdb->query("SELECT * FROM users WHERE user_id='" . $payer_id . "'");
          		if($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "last" => $lookdb->f("last_name"),
                        "user_login" => $lookdb->f("user_login"),
                        "email" => $lookdb->f("email"),
                        "address" => $lookdb->f("address1"),
                        "address2" => $lookdb->f("address2"),
                        "state" => $lookdb->f("state_id"),
                        "zip" => $lookdb->f("zip"),
                        "city" => $lookdb->f("city"),
                        "phonedy" => $lookdb->f("phone_day"),
                        "phoneevn" => $lookdb->f("phone_evn"),
                        "fax" => $lookdb->f("fax"),
                        "ip" => $lookdb->f("ip_insert"),
                        "date_created" => $lookdb->f("date_created"),
                        );
          		}
   			}
   			$EP["EMAIL:PAYMENT_SUBJECT"] = "PayPal Subscription";
   			$EP["EMAIL:PAYMENT_AMOUNT"] = $charges["currency"] . $payment_gross;
   			$EP["EMAIL:PAYER_EMAIL"] = $payer_email;
   			$EP["EMAIL:CURRENT_USERNAME"] = $ld["user_login"];
   			$EP["EMAIL:CURRENT_USERID"] = $ld["ID"];
   			$EP["EMAIL:CURRENT_USER_FIRST_NAME"] = $ld["first"];
   			$EP["EMAIL:CURRENT_USER_LAST_NAME"] = $ld["last"];
   			$EP["EMAIL:CURRENT_USER_EMAIL"] = $ld["email"];
   			$EP["EMAIL:CURRENT_USER_ADDRESS"] = $ld["address"];
   			$EP["EMAIL:CURRENT_USER_ADDRESS2"] = $ld["address2"];
   			$EP["EMAIL:CURRENT_USER_STATE"] = $ld["state"];
   			$EP["EMAIL:CURRENT_USER_CITY"] = $ld["city"];
   			$EP["EMAIL:CURRENT_USER_ZIP"] = $ld["zip"];
   			$EP["EMAIL:CURRENT_USER_DAY_PHONE"] = $ld["phonedy"];
   			$EP["EMAIL:CURRENT_USER_EVN_PHONE"] = $ld["phoneevn"];
   			$EP["EMAIL:CURRENT_USER_FAX"] = $ld["fax"];
   			$EP["EMAIL:CURRENT_USER_IP"] = getenv("REMOTE_ADDR");
   			$EP["EMAIL:CURRENT_USER__REGISTERED_IP"] = $ld["ip"];
   			$EP["EMAIL:CURRENT_USER_DATE_SIGNEDUP"] = date("F j, Y, g:i a", $ld["date_created"]);
			mailout("NewSubscribe", $now["notifyads"], $payer_id, 1000000000, time(), $EP);
		}
		else{

			if($receiver_email == $accounting["paypal"])
   			{
                mailout("MakePaymentPaypal", 1, $payer_id, 1000000000, time(), $EP);
                $db4 = new clsDBNetConnect;
                $db4->connect();
                $db4->query("INSERT INTO charges (user_id, date, charge, cause) VALUES ('" . $payer_id . "', '" . time() . "', '" . $payment_gross . "', 'PayPal Deposit')");
               }
        }
    }
?>