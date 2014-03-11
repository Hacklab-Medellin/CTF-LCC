<?php
function Header_BeforeShow() { //Header_BeforeShow @1-86E61FAE

//Set Tag @2-4EE7CEED
        
		global $ItechclVersion;
		global $DBNetConnect;
        global $Tpl;
        global $now;
        global $accounting;
        global $charges;
                global $regcharges;
        global $images;
        global $design;
                global $PP;
                global $EP;
                global $size;
                
        $admingroup = 0;
		$admingroup = test_admin_group();

        if($size==""){
        $size = "95";
        }
   		$Tpl->SetVar("ItechclVersion", $ItechclVersion);
		$Tpl->SetVar("size", $size);
        $Tpl->SetVar("sitename", $now["sitename"]);
        $Tpl->SetVar("siteemail", $now["siteemail"]);
        $Tpl->SetVar("homeurl", $now["homeurl"]);
        $Tpl->SetVar("secureurl", $now["secureurl"]);
        $Tpl->SetVar("notifyemail", $now["notifyemail"]);
        $Tpl->SetVar("paypal", $accounting["paypal"]);
        $Tpl->SetVar("listing_fee", $regcharges["listing_fee"]);
        $Tpl->SetVar("homepage_fee", $regcharges["home_fee"]);
        $Tpl->SetVar("category_fee", $regcharges["cat_fee"]);
        $Tpl->SetVar("gallery_fee", $regcharges["gallery_fee"]);
        $Tpl->SetVar("image_preview_fee", $regcharges["image_pre_fee"]);
            $Tpl->SetVar("slide_fee", $regcharges["slide_fee"]);
        $Tpl->SetVar("counter_fee", $regcharges["counter_fee"]);
        $Tpl->SetVar("bold_fee", $regcharges["bold_fee"]);
        $Tpl->SetVar("highlight_fee", $regcharges["high_fee"]);
        $Tpl->SetVar("upload_fee", $regcharges["upload_fee"]);
        $Tpl->SetVar("make_offer_image", $images["make_offer_image"]);
        $Tpl->SetVar("currency", $regcharges["currency"]);
        $Tpl->SetVar("currencycode", $regcharges["currencycode"]);
        

                $sql = "SELECT sum(charge) FROM charges WHERE user_id ='" . CCGetUserID() . "'";
                $db = new clsDBNetConnect();
                $db->query($sql);
                $usertotal = 0.00;
                if ($db->next_record()){
                	$usertotal = $db->f("sum(charge)");
                }
                unset($db);
                unset($SQL);
		$Tpl->SetVar("BalanceTotal", CCFormatNumber($usertotal,Array(False, 2, ".", "", False, "", "", 1, True,"")));
                if(CCGetSession("UserLogin")){
                        $UserName = CCGetSession("UserLogin");
                } else {
                        $UserName = "Guest";
                }
                $Tpl->SetVar("UserName", $UserName);
                if(CCGetSession("UserLogin")){
                        $UserNameMenu = "<a href=\"myaccount.php\" class=\"nl\">" . CCGetSession("UserLogin") . "</a>, <a href=\"login.php?Logout=True\"><font color=#0000FF>Logout</font></a>";
                } else {
                        $UserNameMenu = "Guest";
                }
                
                $db = new clsDBNetConnect;
                @$db->query("show tables like \"phpads_zones\"");
                if ($db->next_record()){
	                $db->query("select zoneid from phpads_zones");
	                if (file_exists("phpads/phpadsnew.inc.php")){
	                	while ($db->next_record()){
	            			include ('phpads/phpadsnew.inc.php');
							if (!isset($phpAds_context)) $phpAds_context = array();
	        					$phpAds_raw = view_raw ('zone:' . $db->f("zoneid"), 0, '', '', '0', $phpAds_context);
	        					$Tpl->SetVar("bannerzone" . $db->f("zoneid"), $phpAds_raw['html']);
	        			}
	        		}
				}
				
				if ($admingroup)
					$Tpl->SetVar("adminmode", "<tr><td align=\"center\"><font color=\"red\"><b>Warning:  You are currently logged in as a 'FrontEnd Admin', many elements on the pages my not line up or display properly.<br> Also, any changes made to the site in this mode are non-reversable.</b></font></td></tr>");
        		
                $Tpl->SetVar("UserNameMenu", $UserNameMenu);
                $Tpl->SetVar("pagebody", $design["pagebody"]);
                $Tpl->SetVar("formtable", $design["formtable"]);
                $Tpl->SetVar("formheaderfont", $design["formheaderfont"]);
                $Tpl->SetVar("fieldcationfont", $design["fieldcaptiontd"]);
                $Tpl->SetVar("datatd", $design["datatd"]);
                $Tpl->SetVar("recordseparatortd", $design["recordseparatortd"]);
                $Tpl->SetVar("datafont", $design["datafont"]);
                $Tpl->SetVar("columnfont", $design["columnfont"]);
                $Tpl->SetVar("columntd", $design["columntd"]);

                $Tpl->SetVar("try2", "8");

//End Set Tag

} //Close Header_BeforeShow @1-FCB6E20C
?>
