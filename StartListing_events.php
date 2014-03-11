<?php
//BindEvents Method @1-5151720C
function BindEvents()
{
    global $charges;
    $charges->CCSEvents["AfterInsert"] = "charges_AfterInsert";
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

function charges_AfterInsert() { //charges_AfterInsert @4-B46BA208

//Custom Code @13-2A29BDB7
if (CCGetSession("RecentItemNum"))
	$ItemNum = CCGetSession("RecentItemNum");
startlistingnow($ItemNum, CCGetUserID());

} //Close charges_AfterInsert @4-FCB6E20C

function Page_BeforeShow() { //Page_BeforeShow @1-66DC429C

//Custom Code @12-2A29BDB7
global $Tpl;
        global $now;
        global $accounting;
        global $charges;
        global $images;
        global $ttldis;
        global $usertotal;
        global $ttlcal;
        global $item_token;
        
        $db = new clsDBNetConnect;
        $query = "select tokens from users where user_id=" . CCGetUserID();
        $db->query($query);
        if ($db->next_record()){
        	if ($db->f("tokens") > 0 && !$item_token){
        		$Tpl->SetVar("tokens","<br><br>You Currently have " . $db->f("tokens") . " 'Free Listing Tokens' in your account.  <br><a href=\"StartListing.php?usetoken=1\">Click Here to use one token and make this listing free!</a>");
        	}
        }
                $Tpl->SetVar("ChargeListing", $ttldis);
        $Tpl->SetVar("UserTotal", pricepad($usertotal));
        $finaltotal = $usertotal - $ttlcal;
        $Tpl->SetVar("UserTotalFinal", pricepad($finaltotal));
//End Custom Code

} //Close Page_BeforeShow @1-FCB6E20C

function startlistingnow($ItemNum, $UserID){
	            global $now;
                global $EP;
                global $regcharges;
                CCSetSession("ItemNum", $ItemNum);
                $db = new clsDBNetConnect;
                $db->connect();
                $whereif = "ItemNum='" . $ItemNum . "'";
                $days = CCDLookUp("close","items",$whereif,$db);
				$dayslk = CCDLookUp("days","lookup_listing_dates","date_id='" . $days . "'",$db);
                $dayscal = (86400 * $dayslk) + time();
                $approval = groupApprovalSpec();
                if (($approval["required"] && $now["approv_priority"]) || ($approval["required"] && !$now["approv_priority"] && !$approval["notrequired"]))
                	$stat = 99;
                else
                	$stat = 1;
                $sql = "select `acct_credit_used` from items where ItemNum = '" . $ItemNum . "'";
                $db->query($sql);
                if ($db->next_record()){
                	if ($db->f("acct_credit_used") > 0){
                		$sql = "insert into `charges` (`user_id`, `date`, `charge`, `cause`) Values ('" . $UserID . "', '" . time() . "', '-" . $db->f("acct_credit_used") . "', 'Account Credit Used to Start Item Number: " . $ItemNum . "')";
                		$db->query($sql);
                	}
                }
                $sql = "UPDATE items SET status='" . $stat . "', started=" . time() . ", closes=" . $dayscal . " WHERE ItemNum='" . $ItemNum . "'";
                $db->query($sql);
                $sql = "select * from used_coupons where ItemNum = '" . $ItemNum . "'";
                $db->query($sql);
                if ($db->next_record()) {
                	$sql = "UPDATE used_coupons SET `used`='1' WHERE ItemNum='" . $ItemNum . "'";
					$db->query($sql);
				}
				$sql = "select * from used_tokens where ItemNum = '" . $ItemNum . "'";
                $db->query($sql);
                if ($db->next_record()) {
                	$sql = "UPDATE used_tokens SET `date`='" . time() . "' WHERE ItemNum='" . $ItemNum . "'";
					$db->query($sql);
				}
                unset($db);
                unset($sql);
                CCSetSession("RecentItemNum", "");
                $lookdb = new clsDBNetConnect;
                $lookdb->connect();
                $lookdb->query("SELECT * FROM users WHERE user_id='" . $UserID . "'");
                if($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "ID" => $lookdb->f("user_id"),
                        "user_password" => $lookdb->f("user_password"),
                        "last" => $lookdb->f("last_name"),
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
                        "date_created" => $lookdb->f("date_created")
                        );
                }
                $nb = new clsDBNetConnect;
                $nb->connect();
                $nb->query("SELECT * FROM items WHERE " . $whereif);
                if($nb->next_record())
                {
                        $ls = array(
                        "itemID" => $nb->f("itemID"),
                        "ItemNum" => $nb->f("ItemNum"),
                        "category" => $nb->f("category"),
                        "title" => $nb->f("title"),
                        "started" => $nb->f("started"),
                        "close" => $nb->f("close"),
                        "closes" => $nb->f("closes"),
                        "bold" => $nb->f("bold"),
                        "background" => $nb->f("background"),
                        "cat_featured" => $nb->f("cat_featured"),
                        "home_featured" => $nb->f("home_featured"),
                        "gallery_featured" => $nb->f("gallery_featured"),
                        "image_preview" => $nb->f("image_preview"),
                        "slide_show" => $nb->f("slide_show"),
                        "counter" => $nb->f("counter"),
                        "make_offer" => $nb->f("make_offer"),
                        "image_one" => $nb->f("image_one"),
                        "image_two" => $nb->f("image_two"),
                        "image_three" => $nb->f("image_three"),
                        "image_four" => $nb->f("image_four"),
                        "image_five" => $nb->f("image_five"),
                        "asking_price" => $nb->f("asking_price"),
                        "quantity" => $nb->f("quantity"),
                        "city" => $nb->f("city_town"),
                        "state" => $nb->f("state_province")
                        );

                }
        $lbold = pode($ls["bold"], $regcharges["bold_fee"]);
        $lhome = pode($ls["home_featured"], $regcharges["home_fee"]);
        $lback = pode($ls["background"], $regcharges["high_fee"]);
        $lcat = pode($ls["cat_featured"], $regcharges["cat_fee"]);
        $lgal = pode($ls["gallery_featured"], $regcharges["gallery_fee"]);
        $lipre = pode($ls["image_preview"], $regcharges["image_pre_fee"]);
        $lslide = pode($ls["slide_show"], $regcharges["slide_fee"]);
        $lcount = pode($ls["counter"], $regcharges["counter_fee"]);
        $li1 = podeimg($ls["image_one"], $regcharges["upload_fee"]);
        $li2 = podeimg($ls["image_two"], $regcharges["upload_fee"]);
        $li3 = podeimg($ls["image_three"], $regcharges["upload_fee"]);
        $li4 = podeimg($ls["image_four"], $regcharges["upload_fee"]);
        $li5 = podeimg($ls["image_five"], $regcharges["upload_fee"]);
        if($ls["make_offer"]==1)
        {
                $make = "Make Offer";
        }
        if($ls["make_offer"]==0)
        {
                $make = "";
        }
        $gf1 = new clsDBNetConnect;
        $gf1->connect();
        $gf2 = new clsDBNetConnect;
        $gf2->connect();
	  $gf3 = new clsDBNetConnect;
	  $gf3->connect();
        $EP["EMAIL:AD_ITEM_NUMBER"] = $ls["ItemNum"];
        $EP["EMAIL:AD_CATEGORY_ID"] = $ls["category"];
        $EP["EMAIL:AD_CATEGORY"] = CCDLookUp("name", "categories","cat_id='" . $ls["category"] . "'", $gf1);
        $EP["EMAIL:AD_TITLE"] = $ls["title"];
        $EP["EMAIL:AD_STARTED"] = date("F j, Y, g:i a", $ls["started"]);
        $EP["EMAIL:AD_CLOSES"] = date("F j, Y, g:i a", $ls["closes"]);
        $EP["EMAIL:AD_DAYS_RUNNING"] = CCDLookUp("days", "lookup_listing_dates", "date_id='" . $ls["close"] . "'", $gf2);
        $EP["EMAIL:AD_BOLD_CHARGE"] = $lbold;
        $EP["EMAIL:AD_HIGHLIGHTED_CHARGE"] = $lback;
        $EP["EMAIL:AD_CATEGORY_FEATURED_CHARGE"] = $lcat;
        $EP["EMAIL:AD_GALLERY_CHARGE"] = $lgal;
        $EP["EMAIL:AD_IMAGE_PREVIEW_CHARGE"] = $lipre;
        $EP["EMAIL:AD_HOME_PAGE_CHARGE"] = $lhome;
        $EP["EMAIL:AD_SLIDE_SHOW_CHARGE"] = $lslide;
        $EP["EMAIL:AD_COUNTER_CHARGE"] = $lcount;
	  $EP["EMAIL:AD_DAYS_FEE"] = CCDLookUp("fee", "lookup_listing_dates", "date_id='" . $ls["close"] . "'", $gf3);
        $EP["EMAIL:AD_IMAGE_ONE_CHARGE"] = $li1;
        $EP["EMAIL:AD_IMAGE_TWO_CHARGE"] = $li2;
        $EP["EMAIL:AD_IMAGE_THREE_CHARGE"] = $li3;
        $EP["EMAIL:AD_IMAGE_FOUR_CHARGE"] = $li4;
        $EP["EMAIL:AD_IMAGE_FIVE_CHARGE"] = $li5;
        $EP["EMAIL:AD_MAKE_OFFER"] = $make;
        $EP["EMAIL:AD_ASKING_PRICE"] = $ls["asking_price"];
        $EP["EMAIL:AD_QUANTITY"] = $ls["quantity"];
        $EP["EMAIL:AD_CITY"] = $ls["city"];
        $EP["EMAIL:AD_STATE_PROVINCE"] = $ls["state"];
        $EP["EMAIL:CURRENT_USERNAME"] = CCGetUserLogin();
        $EP["EMAIL:CURRENT_USERID"] = $ld["ID"];
        $EP["EMAIL:CURRENT_USER_PASSWORD"] = $ld["user_password"];
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
        if ($stat == 99){
        	mailout("NewListingApproval", $now["notifyads"], $ld["ID"], 1000000000, time(), $EP);
        }
        else{
        	mailout("NewListing", $now["notifyads"], $ld["ID"], 1000000000, time(), $EP);
        	index_listing($ItemNum);
        	$db = new clsDBNetConnect;
        	$query = "Select * from custom_textarea_values where `ItemNum` = $ItemNum";
        	$db->query($query);
        	while ($db->next_record()){
        		index_listing($ItemNum, $db->f("value"), "ta", $db->f("field_id"));
        	}
        	$query = "Select * from custom_textbox_values where `ItemNum` = $ItemNum";
        	$db->query($query);
        	while ($db->next_record()){
        		index_listing($ItemNum, $db->f("value"), "tb", $db->f("field_id"));
        	}
        	$query = "Select * from custom_dropdown_values where `ItemNum` = $ItemNum";
        	$db->query($query);
        	while ($db->next_record()){
        		index_listing($ItemNum, $db->f("option_id"), "dd", $db->f("field_id"), $db->f("option_id"));
        	}
        	add_catcounts($ls["category"]);
        }
		//End Custom Code
		return $stat;
	}

?>