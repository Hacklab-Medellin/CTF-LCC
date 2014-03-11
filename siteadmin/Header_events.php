<?php
function Header_BeforeShow() { //Header_BeforeShow @1-86E61FAE





//Custom Code @22-2A29BDB7


		global $now;


		global $accounting;


		global $regcharges;


		global $Tpl;


		include("../Version.php");


		


		$Tpl->SetVar("versions", $ItechclVersion);


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


		$Tpl->SetVar("AdminName", CCGetUserLogin());


//End Custom Code





} //Close Header_BeforeShow @1-FCB6E20C
?>