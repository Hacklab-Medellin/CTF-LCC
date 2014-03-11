<?php
require_once("./authorizenet.class.php");
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
    global $charges1;
    $charges1->charge->CCSEvents["OnValidate"] = "charges1_charge_OnValidate";
}

function Page_BeforeShow() {

    global $Tpl;
   
}

function charges1_charge_OnValidate() { //charges1_charge_OnValidate @10-D55FB1E0

//Custom Code @22-2A29BDB7
global $charges1;
global $accounting;
global $regcharges;
global $finalamount;
$dba = new clsDBNetConnect;
$dba->connect();
$dba->query("SELECT * FROM users WHERE user_id='" . CCGetUserID() . "'");
$dbL = new clsDBNetConnect;
$dbL->connect();
while($dba->next_record())
{
      $clook = $dba->f("country_id");
      $city = $dba->f("city");
      $state = $dba->f("state_id");
      $addr = $dba->f("address1");
      $zip = $dba->f("zip");
      $usid = $dba->f("user_id");
      $email = $dba->f("email");
      $country = CCDLookUp("country_desc", "lookup_countries", "country_id='" . $clook . "'", $dbL);
}
$payment_config = array("method"=>"cc","login"=>$accounting["authorize"],"tran_key"=>$accounting["authorize_tran_key"], "currency_code"=>$regcharges["currencycode"]); 
$customer_info = array("first_name"=>$charges1->FirstName->GetValue(),
		       "last_name"=>$charges1->LastName->GetValue(),
	               "address"=>$addr,
                       "city"=>$city,
                       "state"=>$state,
                       "zip"=>$zip,
                       "country"=>$country,
                       "cust_id"=>$usid,
                       "email"=>$email);
$credit_card_info = array("card_num"=>$charges1->CCNumber->GetValue(), 
			  "exp_date"=>$charges1->ExpDate->GetValue(), 
			  "card_code"=>$charges1->CardCode->GetValue(),
			  "charge_type"=>"AUTH_CAPTURE");

$payment =& new payment_authorizenet($payment_config);
$payment->setCustomerIP($_SERVER["REMOTE_ADDR"]);
$payment->enableCustomerEmails(TRUE);
$payment->addCustomerInfo($customer_info, "billing");
$result = $payment->doPayment(rand(), "Classified Ad Listing Fee", $charges1->charge->GetValue(), "no", $credit_card_info);

if(!$result) {
	$result_code = $payment->response_code;    // 2 = declined, 3 = error
	if($result_code == 2){
        	$charges1->charge->Errors->addError("The Card has been declined. Please make sure the Name, CC Number, and Expiration date are correct.");
	}
	if($result_code == 3){
        	$charges1->charge->Errors->addError("There was an error trying to process your card. Please make sure the Name, CC Number, and Expiration date are correct.");
	}
}

$finalamount = $payment->x_amount;

//End Custom Code

} //Close charges1_charge_OnValidate @10-FCB6E20C

function charges_AfterInsert() { //charges_AfterInsert @4-B46BA208

//Custom Code @13-2A29BDB7
                global $now;
                global $EP;
                global $regcharges;
                global $Tpl;
                
                subscribe(CCGetUserID(), $_REQUEST["id"], $this->charge->DBValue);
                
        		mailout("NewSubscribe", $now["notifyads"], CCGetUserID(), 1000000000, time(), $EP);
//End Custom Code

} //Close charges_AfterInsert @4-FCB6E20C

function buildpage($id){
	global $Tpl;
	global $now;
	global $accounting;
	global $regcharges;
	
	$db = new clsDBNetConnect;
	$query = "select * from subscription_plans where id = " . $id;
	$db->query($query);
	if ($db->next_record()){
		$id = $db->f("id");
		$title = $db->f("title");
		$description = $db->f("description");
		$group = $db->f("group");
		$duration = $db->f("duration");
		$unlimited = $db->f("unlimited");
		$price = $db->f("price");
		$recurring = $db->f("recurring");
		if ($recurring == 1)
			$recurring = "Yes";
		else
			$recurring = "No";
		if ($unlimited)
			$duration = 9999;
		$intro = $db->f("intro");
		$intro_duration = $db->f("intro_duration");
		$intro_price = $db->f("intro_price");
		$paypal = $db->f("paypal");
		$authnet = $db->f("authnet");
		$co2 = $db->f("co2");
		$active = $db->f("active");
		$icon = $db->f("icon");
		$date_added = $db->f("date_added");
		if ($active) {
			if ($paypal && $recurring == "No"){
				$paypallink = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=" . urlencode($accounting["paypal"]) . "&return=" . urlencode($now["homeurl"]) . "&no_note=1&currency_code=" . $regcharges["currencycode"] . "&notify_url=" . urlencode($now["homeurl"]) . "paypalipn.php&custom=" . CCGetUserID() . "&amount=" . $price . "&item_name=" . urlencode($now["sitename"] . "-Subscription") . "&item_number=" . $id;
				$Tpl->SetBlockVar("PayPal", "");
				$Tpl->setVar("paypallink",$paypallink);
				$Tpl->Parse("PayPal", True);
			}
			if ($paypal && $recurring == "Yes"){
				$days = $duration;
				$duration2 = "&p3=" . $days . "&t3=D";
    			if ($days > 90 && $days < 730 && $days != 365 && $days != 730 && $db->f("recurring") == 1){
    				$days = round($days/30,0);
    				$duration2 = "&p3=" . $days . "&t3=M";
    			} elseif ($days > 730 && $db->f("recurring") == 1 || $days == 365 || $days == 730){
    				$days = round($days/365,0);
    				$duration2 = "&p3=" . $days . "&t3=Y";
    			}
    	
		    	$rdays = $intro_duration;
		    	if ($rdays)
		    		$intro_duration2 = "&p1=" . $rdays . "&t1=D";
		    	if ($rdays > 90 && $rdays < 730 && $rdays != 365 && $rdays != 730 && $db->f("recurring") == 1){
    				$rdays = round($rdays/30,0);
    				$intro_duration2 = "&p1=" . $rdays . "&t1=M";
    			} elseif ($rdays > 730 && $db->f("recurring") == 1 || $rdays == 365 || $rdays == 730){
    				$rdays = round($rdays/365,0);
    				$intro_duration2 = "&p1=" . $rdays . "&t1=Y";
    			}
				$paypallink = "https://www.paypal.com/cgi-bin/webscr?cmd=_xclick-subscriptions&business=" . urlencode($accounting["paypal"]) . "&return=" . urlencode($now["homeurl"]) . "&no_note=1&currency_code=" . $regcharges["currencycode"] . "&notify_url=" . urlencode($now["homeurl"]) . "paypalipn.php&custom=" . CCGetUserID() . "&amount=" . $intro_price . "&item_name=" . urlencode($now["sitename"] . "-Subscription") . "&item_number=" . $id . "&a1=" . $intro_price . $intro_duration2 . "&a3=" . $price . $duration2;
				if ($intro){
					$Tpl->SetBlockVar("intro", "");
					$Tpl->setVar("currency",$regcharges["currency"]);
					$Tpl->setVar("intro_price",$intro_price);
					$Tpl->setVar("intro_duration",$intro_duration);
					$Tpl->Parse("intro", True);
				}
				$Tpl->SetBlockVar("PayPal", "");
				$Tpl->setVar("paypallink",$paypallink);
				$Tpl->Parse("PayPal", True);
			}
			if ($co2){
				
			}
			if ($authnet && $paypal){
				$Tpl->SetBlockVar("or", "");
				$Tpl->Parse("or", True);
			}
			$Tpl->setVar("id",$id);
			$Tpl->setVar("title",$title);
			$Tpl->setVar("description",$description);
			$Tpl->setVar("price",$price);
			if ($unlimited)
				$duration = "Unlimited";
			$Tpl->setVar("duration",$duration);
			$Tpl->setVar("recurring",$recurring);
			$Tpl->setVar("intro_duration",$intro_duration);
			$Tpl->setVar("date_added",$date_added);
			$Tpl->setVar("icon",$icon);
		}
	}
}
?>