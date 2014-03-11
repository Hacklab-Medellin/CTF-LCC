<?php
//BindEvents Method @1-DBBB8D4A
function BindEvents()
{
    global $items;
    $items->CCSEvents["BeforeShow"] = "items_BeforeShow";
    global $emails;
    $emails->CCSEvents["AfterInsert"] = "emails_AfterInsert";
}
//End BindEvents Method

function items_BeforeShow() { //items_BeforeShow @4-10DCF469

//Custom Code @7-2A29BDB7
global $Tpl;
global $itemvars;
global $items;
global $newvars;
global $currency;
global $emails1;
global $joinJS;
global $admingroup;
global $editorCSS;

global $PHP_SELF;if(CCGetFromGet("ItemNum", "") || CCGetFromGet("PreviewNum", "")){
$db = new clsDBNetConnect;
$db->connect();
$SQL = "SELECT * FROM items WHERE ItemNum=" . CCGetFromGet("ItemNum", "");
if (CCGetFromGet("PreviewNum", ""))
$SQL = "SELECT * FROM items_preview WHERE ItemNum=" . CCGetFromGet("PreviewNum", "");
$db->query($SQL);
$Result = $db->next_record();
if($Result)
{
        $itemvars = array(
        "ItemNum" => $db->f(ItemNum),
        "category" => $db->f(category),
        "user_id" => $db->f(user_id),
        "title" => $db->f(title),
        "status" => $db->f(status),
        "end_reason" => $db->f(end_reason),
        "started" => $db->f(started),
        "closes" => $db->f(closes),
        "image_preview" => $db->f(image_preview),
        "slide_show" => $db->f(slide_show),
        "counter" => $db->f(counter),
	  "added_description" => $db->f("added_description"),
	  "dateadded" => $db->f("dateadded"),
        "make_offer" => $db->f(make_offer),
        "image_one" => $db->f(image_one),
        "image_two" => $db->f(image_two),
        "image_three" => $db->f(image_three),
        "image_four" => $db->f(image_four),
        "image_five" => $db->f(image_five),
        "asking_price" => $db->f(asking_price),
        "quantity" => $db->f(quantity),
        "city_town" => $db->f(city_town),
        "state_province" => $db->f(state_province),
	  "country" => $db->f("country"),
	  "ship1" => $db->f("ship1"),
	  "shipfee1" => $db->f("shipfee1"),
	  "ship2" => $db->f("ship2"),
	  "shipfee2" => $db->f("shipfee2"),
	  "ship3" => $db->f("ship3"),
	  "shipfee3" => $db->f("shipfee3"),
	  "ship4" => $db->f("ship4"),
	  "shipfee4" => $db->f("shipfee4"),
	  "ship5" => $db->f("ship5"),
	  "shipfee5" => $db->f("shipfee5"),
	  "item_paypal" => $db->f("item_paypal"),
        "hits" => $db->f(hits)
        );
        if(!CCGetUserID())
        {
        $mustbe = "<table class=\"ct\" width=\"80%\" cellspacing=\"1\" cellpadding=\"1\">

        <tr>

          <td bgcolor=\"#ffffff\" align=\"middle\" valign=\"bottom\">
            <form method=\"post\" action=\"login.php?ret_link=" . $_SERVER["REQUEST_URI"] . "&type=notLogged&ccsForm=Login\" name=\"Login\">

              <font class=\"fhf\">Login To Ask A Question</font>

              <table cellpadding=\"5\" cellspacing=\"1\" class=\"ft\">
                <tr>

                  <td></td>

                </tr>

                <tr>

                  <td align=\"right\"><b>Username:</b>&nbsp;</td>

                  <td align=\"left\"><input name=\"login\" value=\"\" maxlength=\"100\" class=\"input\">&nbsp;</td>

                </tr>

                <tr>

                  <td align=\"right\"><b>Password:</b>&nbsp;</td>

                  <td align=\"left\"><input type=\"password\" name=\"password\" value=\"\" maxlength=\"100\" class=\"input\">&nbsp;<a href=\"login.php\">Forgot Password</a></td>

                </tr>

                <tr>

                  <td align=\"middle\" colspan=\"2\">

                    <input name=\"DoLogin\" type=\"submit\" value=\"Login\" class=\"button\">&nbsp;</td>

                </tr>

                <tr>

                   <td align=\"middle\" colspan=\"2\">

                   New Users:&nbsp;<a href=\"register.php\">Register</a>

                   </td>

                </tr>

              </table>

            </form>

           </td>

        </tr>

      </table>";
        }
        if((!CCGetUserID()) && ($itemvars["make_offer"]==1))
        {
        $mustbeoffer = "<b>You must be logged in to make an offer</b>";
        }
        if((CCGetUserID()) && ($itemvars["status"]==1) && $itemvars["item_paypal"] != "")
        {
            $Tpl->SetVar("item_paypal", "&nbsp;&nbsp;<a href=\"confirm.php?what=buynowPayPal&ItemNum=" . $itemvars["ItemNum"] . "\"><B>Buy Now</b></a>");
        }
        if((!CCGetUserID()) && ($itemvars["make_offer"]==1) && ($itemvars["status"]==1) && $itemvars["item_paypal"] == "")
        {
        	$Tpl->SetVar("makeoffer", "&nbsp;&nbsp;<a href=\"login.php?ret_link=ViewItem.php?ItemNum=" . $itemvars["ItemNum"] . "&type=notLogged\">Login to Make an Offer<a>");
        	$Tpl->SetVar("item_paypal", "");
        }
        if((!CCGetUserID()) && ($itemvars["make_offer"]==1) && ($itemvars["status"]==1) && $itemvars["item_paypal"] != "")
        {
        	$Tpl->SetVar("makeoffer", "&nbsp;&nbsp;<a href=\"login.php?ret_link=ViewItem.php?ItemNum=" . $itemvars["ItemNum"] . "&type=notLogged\">Login to Buy this Item Or Make an Offer<a>");
        	$Tpl->SetVar("item_paypal", "");
       	}
        $Tpl->SetVar("NotLogged", $mustbe);
        $Tpl->SetVar("NotLogged2", $mustbeoffer);
        $ldb = new clsDBNetConnect;
		$ldb->connect();
		$ldb2 = new clsDBNetConnect;
		$ldb2->connect();
		$ldb3 = new clsDBNetConnect;
		$ldb3->connect();
		$ldb4 = new clsDBNetConnect;
		$ldb4->connect();
		$ldb5 = new clsDBNetConnect;
		$ldb5->connect();
		$ldb->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $itemvars["category"]);
		if($ldb->next_record())
		{
			$newvars["catlist"] = "<a href=\"ViewCat.php?CatID=" . $ldb->f("cat_id") . "\">" . $ldb->f("name") . "</a>";
			$ldb2->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb->f("sub_cat_id"));
			if($ldb2->next_record())
			{
				$newvars["catlist"] = "<a href=\"ViewCat.php?CatID=" . $ldb2->f("cat_id") . "\">" . $ldb2->f("name") . "</a> > " . $newvars["catlist"];
				$ldb3->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb2->f("sub_cat_id"));
				if($ldb3->next_record())
				{
					$newvars["catlist"] = "<a href=\"ViewCat.php?CatID=" . $ldb3->f("cat_id") . "\">" . $ldb3->f("name") . "</a> > " . $newvars["catlist"];
					$ldb4->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb3->f("sub_cat_id"));
					if($ldb4->next_record())
					{
						$newvars["catlist"] = "<a href=\"ViewCat.php?CatID=" . $ldb4->f("cat_id") . "\">" . $ldb4->f("name") . "</a> > " . $newvars["catlist"];
						$ldb5->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb4->f("sub_cat_id"));
						if($ldb5->next_record())
						{
							$newvars["catlist"] = "<a href=\"ViewCat.php?CatID=" . $ldb5->f("cat_id") . "\">" . $ldb5->f("name") . "</a> > " . $newvars["catlist"];
				
						}
					}
				}
			}
		}
		
		$newvars["category"] = CCDLookUP("name", "categories", "cat_id=" . $itemvars["category"], $db);
        $newvars["categoryid"] = CCDLookUP("sub_cat_id", "categories", "cat_id=" . $itemvars["category"], $db);
        $newvars["categoryparent"] = CCDLookUP("name", "categories", "cat_id=" . $newvars["categoryid"], $db);

        if($newvars["categoryparent"]) {
                $newvars["categoryparent"] = "<a href=\"ViewCat.php?CatID=" . $newvars["categoryid"] . "\">" . $newvars["categoryparent"] . "</a> >> ";
        }
		$newvars["sellerid"] = $itemvars["user_id"];
        $newvars["seller"] = CCDLookUP("user_login", "users", "user_id=" . $itemvars["user_id"], $db);
        if($itemvars["status"] == 1){
                $newvars["status"] = "Open";
        }
        if($itemvars["status"] == 2){
                $newvars["status"] = "Closed";
        }
        if($itemvars["status"] == 0){
                $newvars["status"] = "This Item has not been started yet";
        }
        $newvars["preview_image"] = "<img src=\"images/blank.jpg\">";
        $newvars["cellbreaker2"] = "";
        $newvars["cellbreaker1"] = "</td><td class=\"data\">";
        //if(itemvars["image_preview"] == 1){
                if($itemvars["image_five"] != ""){
                        $newvars["preview_image"] = thumbnail($itemvars["image_five"],225,225,0,0);
                        $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                        $newvars["cellbreaker1"] = "";
                                                $newvars["imageFive"] = "<tr><td align=\"center\"><img src=\"" . $itemvars["image_five"] . "\"></td></tr>";
                }
                if($itemvars["image_four"] != ""){
                        $newvars["preview_image"] = thumbnail($itemvars["image_four"],225,225,0,0);
                        $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                        $newvars["cellbreaker1"] = "";
                                                $newvars["imageFour"] = "<tr><td align=\"center\"><img src=\"" . $itemvars["image_four"] . "\"></td></tr>";
                }
                if($itemvars["image_three"] != ""){
                        $newvars["preview_image"] = thumbnail($itemvars["image_three"],225,225,0,0);
                        $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                        $newvars["cellbreaker1"] = "";
                                                $newvars["imageThree"] = "<tr><td align=\"center\"><img src=\"" . $itemvars["image_three"] . "\"></td></tr>";
                }
                if($itemvars["image_two"] != ""){
                        $newvars["preview_image"] = thumbnail($itemvars["image_two"],225,225,0,0);
                        $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                        $newvars["cellbreaker1"] = "";
                                                $newvars["imageTwo"] = "<tr><td align=\"center\"><img src=\"" . $itemvars["image_two"] . "\"></td></tr>";
                }
                if($itemvars["image_one"] != ""){
                        $newvars["preview_image"] = thumbnail($itemvars["image_one"],225,225,0,0);
                        $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                        $newvars["cellbreaker1"] = "";
                                                $newvars["imageOne"] = "<tr><td align=\"center\"><img src=\"" . $itemvars["image_one"] . "\"></td></tr>";
                }
        //}

                        $javafirst = 0;
                $javalast = 0;
                if($itemvars["image_five"] != ""){
                        $imreturn = thumbnail($itemvars["image_five"],225,225,0,1);
                                                $imreturn2 = thumbnail($itemvars["image_five"],100,100,0,1);
                                                $imreturn3 = thumbnail($itemvars["image_five"],350,350,0,1);
                        $sone = explode("^",$imreturn);
                                                $sone2 = explode("^",$imreturn2);
                                                $sone3 = explode("^",$imreturn3);
                        if($javalast == 0) {
                                $endatt = "\n";
                                $javalast = 1;
                        }
                        elseif ($javalast == 1) {
                                $endatt = ",\n";
                        }
                        $newvars["slidesrc"] = "\"$sone[0]\"" . $endatt . $newvars["slidesrc"];
                        $newvars["slideht"] = "\"$sone[1]\"" . $endatt  . $newvars["slideht"];
                        $newvars["slidewt"] = "\"$sone[2]\"" . $endatt  . $newvars["slidewt"];
                                                $newvars["slideht2"] = "\"$sone2[1]\"" . $endatt  . $newvars["slideht2"];
                        $newvars["slidewt2"] = "\"$sone2[2]\"" . $endatt  . $newvars["slidewt2"];
                                                $newvars["slideht3"] = "\"$sone3[1]\"" . $endatt  . $newvars["slideht3"];
                        $newvars["slidewt3"] = "\"$sone3[2]\"" . $endatt  . $newvars["slidewt3"];
                        unset($imreturn);
                        unset($sone);
                }
                if($itemvars["image_four"] != ""){
                        $imreturn = thumbnail($itemvars["image_four"],225,225,0,1);
                                                $imreturn2 = thumbnail($itemvars["image_four"],100,100,0,1);
                                                $imreturn3 = thumbnail($itemvars["image_four"],350,350,0,1);
                        $sone = explode("^",$imreturn);
                                                $sone2 = explode("^",$imreturn2);
                                                $sone3 = explode("^",$imreturn3);
                        if($javalast == 0) {
                                $endatt = "\n";
                                $javalast = 1;
                        }
                        elseif ($javalast == 1) {
                                $endatt = ",\n";
                        }
                        $newvars["slidesrc"] = "\"$sone[0]\"" . $endatt . $newvars["slidesrc"];
                        $newvars["slideht"] = "\"$sone[1]\"" . $endatt  . $newvars["slideht"];
                        $newvars["slidewt"] = "\"$sone[2]\"" . $endatt  . $newvars["slidewt"];
                                                $newvars["slideht2"] = "\"$sone2[1]\"" . $endatt  . $newvars["slideht2"];
                        $newvars["slidewt2"] = "\"$sone2[2]\"" . $endatt  . $newvars["slidewt2"];
                                                $newvars["slideht3"] = "\"$sone3[1]\"" . $endatt  . $newvars["slideht3"];
                        $newvars["slidewt3"] = "\"$sone3[2]\"" . $endatt  . $newvars["slidewt3"];
                        unset($imreturn);
                        unset($sone);
                }
                if($itemvars["image_three"] != ""){
                        $imreturn = thumbnail($itemvars["image_three"],225,225,0,1);
                                                $imreturn2 = thumbnail($itemvars["image_three"],100,100,0,1);
                                                $imreturn3 = thumbnail($itemvars["image_three"],350,350,0,1);
                        $sone = explode("^",$imreturn);
                                                $sone2 = explode("^",$imreturn2);
                                                $sone3 = explode("^",$imreturn3);
                        if($javalast == 0) {
                                $endatt = "\n";
                                $javalast = 1;
                        }
                        elseif ($javalast == 1) {
                                $endatt = ",\n";
                        }
                        $newvars["slidesrc"] = "\"$sone[0]\"" . $endatt . $newvars["slidesrc"];
                        $newvars["slideht"] = "\"$sone[1]\"" . $endatt  . $newvars["slideht"];
                        $newvars["slidewt"] = "\"$sone[2]\"" . $endatt  . $newvars["slidewt"];
                                                $newvars["slideht2"] = "\"$sone2[1]\"" . $endatt  . $newvars["slideht2"];
                        $newvars["slidewt2"] = "\"$sone2[2]\"" . $endatt  . $newvars["slidewt2"];
                                                $newvars["slideht3"] = "\"$sone3[1]\"" . $endatt  . $newvars["slideht3"];
                        $newvars["slidewt3"] = "\"$sone3[2]\"" . $endatt  . $newvars["slidewt3"];
                        unset($imreturn);
                        unset($sone);
                }
                if($itemvars["image_two"] != ""){
                        $imreturn = thumbnail($itemvars["image_two"],225,225,0,1);
                                                $imreturn2 = thumbnail($itemvars["image_two"],100,100,0,1);
                                                $imreturn3 = thumbnail($itemvars["image_two"],350,350,0,1);
                        $sone = explode("^",$imreturn);
                                                $sone2 = explode("^",$imreturn2);
                                                $sone3 = explode("^",$imreturn3);
                        if($javalast == 0) {
                                $endatt = "\n";
                                $javalast = 1;
                        }
                        elseif ($javalast == 1) {
                                $endatt = ",\n";
                        }
                        $newvars["slidesrc"] = "\"$sone[0]\"" . $endatt . $newvars["slidesrc"];
                        $newvars["slideht"] = "\"$sone[1]\"" . $endatt  . $newvars["slideht"];
                        $newvars["slidewt"] = "\"$sone[2]\"" . $endatt  . $newvars["slidewt"];
                                                $newvars["slideht2"] = "\"$sone2[1]\"" . $endatt  . $newvars["slideht2"];
                        $newvars["slidewt2"] = "\"$sone2[2]\"" . $endatt  . $newvars["slidewt2"];
                                                $newvars["slideht3"] = "\"$sone3[1]\"" . $endatt  . $newvars["slideht3"];
                        $newvars["slidewt3"] = "\"$sone3[2]\"" . $endatt  . $newvars["slidewt3"];
                        unset($imreturn);
                        unset($sone);
                }
                if($itemvars["image_one"] != ""){
                        $imreturn = thumbnail($itemvars["image_one"],225,225,0,1);
                                                $imreturn2 = thumbnail($itemvars["image_one"],100,100,0,1);
                                                $imreturn3 = thumbnail($itemvars["image_one"],350,350,0,1);
                        $sone = explode("^",$imreturn);
                                                $sone2 = explode("^",$imreturn2);
                                                $sone3 = explode("^",$imreturn3);
                        if($javalast == 0) {
                                $endatt = "\n";
                                $javalast = 1;
                        }
                        elseif ($javalast == 1) {
                                $endatt = ",\n";
                        }
                        $newvars["slidesrc"] = "\"$sone[0]\"" . $endatt . $newvars["slidesrc"];
                        $newvars["slideht"] = "\"$sone[1]\"" . $endatt  . $newvars["slideht"];
                        $newvars["slidewt"] = "\"$sone[2]\"" . $endatt  . $newvars["slidewt"];
                                                $newvars["slideht2"] = "\"$sone2[1]\"" . $endatt  . $newvars["slideht2"];
                        $newvars["slidewt2"] = "\"$sone2[2]\"" . $endatt  . $newvars["slidewt2"];
                                                $newvars["slideht3"] = "\"$sone3[1]\"" . $endatt  . $newvars["slideht3"];
                        $newvars["slidewt3"] = "\"$sone3[2]\"" . $endatt  . $newvars["slidewt3"];
                        unset($imreturn);
                        unset($sone);
                }
        if($itemvars["slide_show"] == 1){
                $sliderun = "1";
                $newvars["cellbreaker2"] = "</td><td class=\"data\">";
                $newvars["cellbreaker1"] = "";
                $newvars["preview_image"] = "<table width=\"235\" align=\"center\" valign=\"middle\" class=\"ct\" height=\"235\" border=\"1\"><tr><td align=\"center\" valign=\"middle\" class=\"ltdt\">" . $newvars["preview_image"] . "
</td></tr>
</table>
<table class=\"ct\" width=\"235\"><tr bgcolor=\"#FFFFFF\">
<td align=\"center\" width=\"33%\"><a href=\"javascript:chgImg(-1)\"><img src=\"images/prev.gif\" border=\"0\"></a></td>
<td align=\"center\" width=\"33%\"><a href=\"javascript:auto()\"><img src=\"images/play.gif\" border=\"0\"></a></td>
<td align=\"center\" width=\"33%\"><a href=\"javascript:chgImg(1)\"><img src=\"images/next.gif\" border=\"0\"></a></td>
</tr>
</table>";
                }elseif($itemvars["image_preview"] == 1){
                        $sliderun = "0";
                        $newvars["preview_image"] = "<table width=\"235\" align=\"center\" valign=\"middle\" class=\"ct\" height=\"235\" border=\"1\"><tr><td align=\"center\" valign=\"middle\" class=\"ltdt\">" . $newvars["preview_image"] . "
</td></tr>
</table>
<table width=\"235\"><tr>
<td align=\"right\"></td>
<td align=\"center\"></td>
<td align=\"left\"></td>
</tr>
</table>";
                }else{
			$sliderun="0";
			$newvars["preview_image"] = "<img src=\"images/blank.jpg\">";
			}
         $theday = getdate($itemvars["started"]);
        $startdate = $theday["weekday"] . ", " . $theday["month"] . " " . $theday["mday"] . ", " . $theday["year"];
        $newvars["started"] = $startdate;
        unset($theday);
        $theday = getdate($itemvars["closes"]);
        $enddate = $theday["weekday"] . ", " . $theday["month"] . " " . $theday["mday"] . ", " . $theday["year"];
        $newvars["closes"] = $enddate;
        if($itemvars["city_town"] != "") {
                $newvars["city_town"] = $itemvars["city_town"] . ", ";
        }
                if($itemvars["make_offer"] == 0 || $itemvars["make_offer"] == "" || $itemvars["make_offer"] == NULL) {
        $emails1->Visible = false;
                }
$newvars["thiscat"] = "<a href=\"ViewCat.php?CatID=" . $itemvars["category"] . "\">" . $newvars["category"] . "</a>";
$hits = "";
if($itemvars["counter"]==1)
{
	$hits = $itemvars["hits"];
}
if($itemvars["dateadded"] != "" AND $itemvars["added_description"] != "")
{
	$newvars["dateadded"] = "<b>On " . date("F j, Y", $itemvars["dateadded"]) . ", " . $newvars["seller"] . " added:";
}
if($itemvars["country"] != "")
{
	$cnt = new clsDBNetConnect;
	$cnt->connect();
	$countryi = CCDLookUP("country_desc", "lookup_countries", "country_id=" . $itemvars["country"], $cnt);
}

//*********************************//
//Get Custom Category template Vars//
//*********************************//

$cats = "(";
$db = new clsDBNetConnect;
$query = "select * from categories where cat_id='" .$itemvars["category"] . "'";
$db->query($query);
$db->next_record();
$cats .= "cat_id=" . $db->f("cat_id");
if ($db->f("sub_cat_id")>0){
    $cats .= " or ";
    $sub = $db->f("sub_cat_id");
    $query = "select * from categories where cat_id=$sub";
    $db->query($query);
    $db->next_record();
    $cats .= "cat_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")>0){
    	$cats .= " or ";
    	$sub = $db->f("sub_cat_id");
    	$query = "select * from categories where cat_id=$sub";
    	$db->query($query);
    	$db->next_record();
    	$cats .= "cat_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")>0){
    		$cats .= " or ";
    		$sub = $db->f("sub_cat_id");
    		$query = "select * from categories where cat_id=$sub";
    		$db->query($query);
    		$db->next_record();
    		$cats .= "cat_id=" . $db->f("cat_id");
    		if ($db->f("sub_cat_id")>0){
    			$cats .= " or ";
    			$sub = $db->f("sub_cat_id");
    			$query = "select * from categories where cat_id=$sub";
    			$db->query($query);
    			$db->next_record();
    			$cats .= "cat_id=" . $db->f("cat_id");
    			if ($db->f("sub_cat_id")>0){
    				$cats .= " or ";
    				$sub = $db->f("sub_cat_id");
    				$query = "select * from categories where cat_id=$sub";
    				$db->query($query);
    				$db->next_record();
    				$cats .= "cat_id=" . $db->f("cat_id");
    				if ($db->f("sub_cat_id")>0){
    					$cats .= " or ";
    					$sub = $db->f("sub_cat_id");
    					$query = "select * from categories where cat_id=$sub";
    					$db->query($query);
    					$db->next_record();
    					$cats .= "cat_id=" . $db->f("cat_id");
    				} else{
    					$cats .= ")";
    				}
    			} else{
    				$cats .= ")";
    			}
    		} else{
    			$cats .= ")";
    		}
    	} else{
    		$cats .= ")";
    	}
    } else{
    	$cats .= ")";
    }
} else{
    $cats .= ")";
}

/////////////////////////////////
//Send Custom TextArea Plugins //
/////////////////////////////////
$custtxt = new clsDBNetConnect;
$query = "select * from custom_textarea where $cats";
$custtxt->query($query);
$queryfields = "(";
$count = 0;
while ($custtxt->next_record()){
	If ($count > 0)
	    $queryfields .= " or ";
	$queryfields .= "field_id='" . $custtxt->f("id") . "'";
	$fields[$custtxt->f("id")]=$custtxt->f("template_var");
	$count++;
}
$queryfields .= ") and";
if ($queryfields != "() and"){
	$query = "select * from custom_textarea_values where $queryfields ItemNum=" . $itemvars["ItemNum"];
	$custtxt->query($query);
	while ($custtxt->next_record()){
				
		
		
		//AdminEdit	abilities section
		if ($admingroup){
			$editorCSS .= "\n#ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
			$joinJS .= "join(\"ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_\", true)\n";
			$Tpl->SetVar($fields[$custtxt->f("field_id")], "\n<DIV id=\"ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View\">\n" . stripslashes($custtxt->f("value")) . "\n</div>\n" . "<textarea id=\"ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit\" class=\"inplace\" tabindex=\"1\" name=\"ta_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit\"></textarea>\n");
		}else{
		
		
		
			$Tpl->SetVar($fields[$custtxt->f("field_id")], stripslashes($custtxt->f("value")));
		}
	}
}

/////////////////////////////////
//Send Custom TextBox Plugins  //
/////////////////////////////////
$fields = "";

$custtxt = new clsDBNetConnect;
$query = "select * from custom_textbox where $cats";
$custtxt->query($query);
$queryfields = "(";
$count = 0;
while ($custtxt->next_record()){
	If ($count > 0)
	    $queryfields .= " or ";
	$queryfields .= "field_id='" . $custtxt->f("id") . "'";
	$fields[$custtxt->f("id")]=$custtxt->f("template_var");
	$count++;
}
$queryfields .= ") and";
if ($queryfields != "() and"){
	$query = "select * from custom_textbox_values where $queryfields ItemNum=" . $itemvars["ItemNum"];
	$custtxt->query($query);
	while ($custtxt->next_record()){
		
		
		
		//AdminEdit	abilities section
		if ($admingroup){
			$editorCSS .= "\n#tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
			$joinJS .= "join(\"tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_\", true)\n";
			$Tpl->SetVar($fields[$custtxt->f("field_id")], "\n<DIV id=\"tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_View\">\n" . stripslashes($custtxt->f("value")) . "\n</div>\n" . "<textarea id=\"tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit\" class=\"inplace\" tabindex=\"1\" name=\"tb_" . $fields[$custtxt->f("field_id")] . "_" . $custtxt->f("field_id") . "_Edit\"></textarea>\n");
		}else{
		
		
		
			$Tpl->SetVar($fields[$custtxt->f("field_id")], stripslashes($custtxt->f("value")));
		}
	}
}
//////////////////////////////////
//Send Custom DropDown Plugins  //
//////////////////////////////////
$fields = "";

$custtxt = new clsDBNetConnect;
$query = "select * from custom_dropdown where $cats";
$custtxt->query($query);
$queryfields = "(";
$count = 0;
while ($custtxt->next_record()){
	If ($count > 0)
	    $queryfields .= " or ";
	$queryfields .= "field_id='" . $custtxt->f("id") . "'";
	$fields[$custtxt->f("id")]=$custtxt->f("template_var");
	$count++;
}
$queryfields .= ")";
if ($queryfields != "()"){
	$query = "select * from custom_dropdown_options where $queryfields";
	$custtxt->query($query);
	while ($custtxt->next_record()){
		$value[$custtxt->f("id")] = $custtxt->f("option");
	}
	$queryfields .= " and";

	$query = "select * from custom_dropdown_values where $queryfields ItemNum=" . $itemvars["ItemNum"];
	$custtxt->query($query);
	while ($custtxt->next_record()){
		$Tpl->SetVar($fields[$custtxt->f("field_id")], stripslashes($value[$custtxt->f("option_id")]));
	}
}
if ($itemvars["ship1"]) {
	$Tpl->SetBlockVar("shipping", "");
	$i = 1;
	$ship = "";
	while ($itemvars["ship$i"]){
		$ship .= "			<tr>\n";
      	
      	//ADMIN EDIT ABILITY SECTION
      	if ($admingroup){
	        $editorCSS .= "\n#ship" . $i . "View {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#ship" . $i . "View:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#ship" . $i . "Edit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
			$editorCSS .= "\n#shipfee" . $i . "View {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#shipfee" . $i . "View:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#shipfee" . $i . "Edit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
			        
			$joinJS .= "join(\"shipfee" . $i . "\", true)\n";
			$joinJS .= "join(\"ship" . $i . "\", true)\n";
			$ship .= "				<td width=\"20%\">";
			$ship .= "\n<DIV id=\"ship" . $i . "View\">\n" . $itemvars["ship$i"] . "\n</div>\n" . "<textarea id=\"ship" . $i . "Edit\" class=\"inplace\" tabindex=\"1\" name=\"ship" . $i . "Edit\"></textarea>\n";
			$ship .= "</td>\n";
			$ship .= "				<td width=\"80%\">";
			$ship .= "\n<DIV id=\"shipfee" . $i . "View\">\n" . $itemvars["shipfee$i"] . "\n</div>\n" . "<textarea id=\"shipfee" . $i . "Edit\" class=\"inplace\" tabindex=\"1\" name=\"shipfee" . $i . "Edit\"></textarea>\n";
			$ship .= "</td>\n";
		} 
		else{
			
		///NOT ADMIN EDITABLE
		
			$ship .= "				<td width=\"20%\">" . $itemvars["ship$i"] . "</td>\n";
			$ship .= "				<td width=\"80%\">" . $itemvars["shipfee$i"] . "</td>\n";
		}
		
      	$ship .= "			</tr>\n";
      	
      	$i++;
    }
    $Tpl->setVar("shippingoptions", $ship);
    $Tpl->parse("shipping", "");
}

$subsc_memb = subscription_membership($newvars["sellerid"], "icontext", "&nbsp;&nbsp;");

if ($_GET["PreviewNum"]){
	$Tpl->setblockvar("Preview", "");
	$Tpl->setvar("finalcat", $itemvars["category"]);
	$Tpl->setvar("ItemNum", $itemvars["ItemNum"]);
	$Tpl->parse("Preview", True);
}

if ($admingroup){
	
//Title AdminEdit 
	$editorCSS .= "\n.inspector {
	font-size: 11px;
}
\n#titleView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#titleView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#titleEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"title\", true)\n";
	$itemvars["title2"] = "\n<DIV id=\"titleView\">\n" . $itemvars["title"] . "\n</div>\n" . "<textarea id=\"titleEdit\" class=\"inplace\" tabindex=\"1\" name=\"titleEdit\"></textarea>\n";
	
	
//Added Description AdminEdit
	if ($itemvars["added_description"]){
		$editorCSS .= "\n#added_descriptionView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#added_descriptionView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#added_descriptionEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"added_description\", true)\n";
	$itemvars["added_description"] = "\n<DIV id=\"added_descriptionView\">\n" . $itemvars["added_description"] . "\n</div>\n" . "<textarea id=\"added_descriptionEdit\" class=\"inplace\" tabindex=\"1\" name=\"added_descriptionEdit\"></textarea>\n";
	}
	
	
//Asking Price AdminEdit	
	$editorCSS .= "\n#asking_priceView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#asking_priceView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#asking_priceEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"asking_price\", true)\n";
	$itemvars["asking_price"] = "\n<DIV id=\"asking_priceView\">\n" . $itemvars["asking_price"] . "\n</div>\n" . "<textarea id=\"asking_priceEdit\" class=\"inplace\" tabindex=\"1\" name=\"asking_priceEdit\"></textarea>\n";

	
//City_Town AdminEdit	
	$editorCSS .= "\n#city_townView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#city_townView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#city_townEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"city_town\", true)\n";
	$newvars["city_town"] = "\n<DIV id=\"city_townView\">\n" . $itemvars["city_town"] . "\n</div>\n" . "<textarea id=\"city_townEdit\" class=\"inplace\" tabindex=\"1\" name=\"city_townEdit\"></textarea>\n";

	
//State_Province AdminEdit	
	$editorCSS .= "\n#state_provinceView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#state_provinceView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#state_provinceEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"state_province\", true)\n";
	$itemvars["state_province"] = "\n<DIV id=\"state_provinceView\">\n" . $itemvars["state_province"] . "\n</div>\n" . "<textarea id=\"state_provinceEdit\" class=\"inplace\" tabindex=\"1\" name=\"state_provinceEdit\"></textarea>\n";

	
//quantity AdminEdit	
	$editorCSS .= "\n#quantityView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 500px;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#quantityView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#quantityEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
	$joinJS .= "join(\"quantity\", true)\n";
	$itemvars["quantity"] = "\n<DIV id=\"quantityView\">\n" . $itemvars["quantity"] . "\n</div>\n" . "<textarea id=\"quantityEdit\" class=\"inplace\" tabindex=\"1\" name=\"quantityEdit\"></textarea>\n";

	
	$catoptions="";
	$catlist = new clsDBNetConnect;
	$catlist->query("select * from categories where sub_cat_id=1");
	while($catlist->next_record()) {
		if ($itemvars["category"]==$catlist->f("cat_id"))
		$selected = " selected";
		$catoptions .= "<option value=\"" . $catlist->f("cat_id") . "\"$selected>" . $catlist->f("name") . "</option>";
		$selected = "";
		$catlist2 = new clsDBNetConnect();
		$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
		while($catlist2->next_record()) {
			if ($itemvars["category"]==$catlist2->f("cat_id"))
			$selected = " selected";
			$catoptions .= "<option value=\"" . $catlist2->f("cat_id") . "\"$selected>--" . $catlist2->f("name") . "</option>";
			$selected = "";
			$catlist3 = new clsDBNetConnect();
			$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
			while($catlist3->next_record()) {
				if ($itemvars["category"]==$catlist3->f("cat_id"))
				$selected = " selected";
				$catoptions .= "<option value=\"" . $catlist3->f("cat_id") . "\"$selected>----" . $catlist3->f("name") . "</option>";
				$selected = "";
				$catlist4 = new clsDBNetConnect();
				$catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
				while($catlist4->next_record()) {
					if ($itemvars["category"]==$catlist4->f("cat_id"))
					$selected = " selected";
					$catoptions .= "<option value=\"" . $catlist4->f("cat_id") . "\"$selected>------" . $catlist4->f("name") . "</option>";
					$selected = "";
					$catlist5 = new clsDBNetConnect();
					$catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
					while($catlist5->next_record()) {
						if ($itemvars["category"]==$catlist5->f("cat_id"))
						$selected = " selected";
						$catoptions .= "<option value=\"" . $catlist5->f("cat_id") . "\"$selected>--------" . $catlist5->f("name") . "</option>";
						$selected = "";
						$catlist6 = new clsDBNetConnect();
						$catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
						while($catlist6->next_record()) {
							if ($itemvars["category"]==$catlist6->f("cat_id"))
							$selected = " selected";
							$catoptions .= "<option value=\"" . $catlist6->f("cat_id") . "\"$selected>----------" . $catlist6->f("name") . "</option>";
							$selected = "";
						}
					}
				}
			}
		}
	}
	
	$QueryString = CCGetQueryString("QueryString", array());
	$AdminMenu= <<<EOD
    
<script>
		function toggleDisplayadminrow() {
			if (document.getElementById) {
				if(document.getElementById("adminrow").style.display=="block") {
					document.getElementById("adminrow").style.display="none";
					document.getElementById("adminrow_icon").src="images/expand.gif";
				}
				else {
					document.getElementById("adminrow").style.display="block";
					document.getElementById("adminrow_icon").src="images/minimize.gif";
				}
			}
		}
	</script>
	<table width="100%" border="0">
	<tr><td>
	<img id="adminrow_icon" src="images/expand.gif" width="16" height="16" onclick="javascript:toggleDisplayadminrow();" onmouseover="javascript:this.style.cursor='hand';"><b> -- Expand FrontEnd Admin Menu</b>
	</td></tr>
	<table id="adminrow" style="display:none;" width="100%">
	<tr><td>
	<form name="AdminMenu" method="POST" action="ViewItem.php?$QueryString">
	Move Item to Categories: <select name="movecategory">$catoptions</select><br>
	<br><input class="inspector" type="submit" value="Move to Selected Category" name="saveMoveCats"/>
	</form>
	Other 'In Place' edits on this page:  Most Fields on this Page can be Double Clicked and Edited.
	<ul><li><b>Edit-In-Place - </b>The majority of the text fields on this page can be edited in place, just double click on them, then click 'Save Changes'<br>
	The 'Title', 'Quantity', 'Asking Price', 'Location', 'Description', 'Added Description', 'Shipping Options', and 'Custom Text Area/Box' fields can be edited here, any other fileds must be edited from the Listings section in siteadmin.</li>
	</ul><hr>
	</td></tr></table>
	</table>
EOD;

	$savebutton = <<<EOD
	<tr>
      <td align="center" colspan="2">
  	  <input type="submit" name="SaveChanges" title="Save Changes" value="Save Changes">
  	  </td>
  	</tr>
EOD;
	if ($itemvars["status"] == 99){
		$approve = <<<EOD
		<tr>
      		<td align="center" colspan="2" bgcolor="lightgrey">
  	  		<a href="ViewItem.php?$QueryString&approved=1">CLICK HERE TO MARK THIS LISTING AS 'APPROVED' AND START IT</a>
  	  		</td>
  		</tr>
EOD;
	}
	$Tpl->SetVar("approve", $approve);
	$Tpl->SetVar("SaveButton", $savebutton);
	$Tpl->SetVar("AdminMenu", $AdminMenu);
}



$Tpl->SetVar("make_offer_form", $outform);
$Tpl->SetVar("added_description", $itemvars["added_description"]);
$Tpl->SetVar("dateadded", $newvars["dateadded"]);
$Tpl->SetVar("title", $itemvars["title"]);
$Tpl->SetVar("title2", $itemvars["title2"]);
$Tpl->SetVar("categoryparent", $newvars["catlist"]);
$Tpl->SetVar("ItemNum", $itemvars["ItemNum"]);
$Tpl->SetVar("category", $newvars["category"]);
$Tpl->SetVar("thiscat", "");
$Tpl->SetVar("askingprice", $itemvars["asking_price"]);
$Tpl->SetVar("quantity", $itemvars["quantity"]);
$Tpl->SetVar("seller", $newvars["seller"]);
$Tpl->SetVar("sellerid", $newvars["sellerid"]);
$Tpl->SetVar("UserRating", "<a href=\"Feedback.php?user_id=" . $newvars["sellerid"] . "\">(" . Getfeedbacktotal($newvars["sellerid"]) . ")</a>");
$Tpl->SetVar("subscriptions", $subsc_memb);
$Tpl->SetVar("end_reason", $itemvars["end_reason"]);
$Tpl->SetVar("started", $newvars["started"]);
$Tpl->SetVar("closes", $newvars["closes"]);
$Tpl->SetVar("initial_image", $newvars["preview_image"]);
$Tpl->SetVar("cellbreaker1", $newvars["cellbreaker1"]);
$Tpl->SetVar("cellbreaker2", $newvars["cellbreaker2"]);
$Tpl->SetVar("city_town", $newvars["city_town"]);
$Tpl->SetVar("state_province", $itemvars["state_province"]);
$Tpl->SetVar("country", $countryi);
$Tpl->SetVar("hits", $hits);
$Tpl->SetVar("status", $newvars["status"]);
$Tpl->SetVar("imageOne", $newvars["imageOne"]);
$Tpl->SetVar("imageTwo", $newvars["imageTwo"]);
$Tpl->SetVar("imageThree", $newvars["imageThree"]);
$Tpl->SetVar("imageFour", $newvars["imageFour"]);
$Tpl->SetVar("imageFive", $newvars["imageFive"]);
$Tpl->SetVar("imgarray", $newvars["slidesrc"]);
$Tpl->SetVar("imgarrayht", $newvars["slideht"]);
$Tpl->SetVar("imgarraywd", $newvars["slidewt"]);
$Tpl->SetVar("imgarrayht2", $newvars["slideht2"]);
$Tpl->SetVar("imgarraywd2", $newvars["slidewt2"]);
$Tpl->SetVar("imgarrayht3", $newvars["slideht3"]);
$Tpl->SetVar("imgarraywd3", $newvars["slidewt3"]);
$Tpl->SetVar("Loader", $sliderun);

//{imageOne}{imageTwo}{imageThree}{imageFour}{imageFive} //HTML Usage
unset($db);
unset($SQL);
unset($Result);

$itemvars["hits"]++;
$db = new clsDBNetConnect;
$db->connect();
if (CCGetFromGet("ItemNum", "")){
	$SQL = "UPDATE items SET hits=" . $itemvars["hits"] . " WHERE ItemNum=" . $itemvars["ItemNum"];
	$db->query($SQL);
}
unset($db);
unset($SQL);
}
}
//End Custom Code

} //Close items_BeforeShow @4-FCB6E20C

function emails_AfterInsert() { //emails_AfterInsert @8-07965C67

//Send Email @31-E1A42D8E
    global $emails;
    $to = $emails->to_user_id->GetText();
    $subject = $emails->subject->GetText();
    $message = $emails->message->GetText();
    $from = $emails->from_user_id->GetText();
    $additional_headers = "From: $from\nReply-To: $from";
    mail ($to, $subject, $message, $additional_headers);
    
//End Send Email

} //Close emails_AfterInsert @8-FCB6E20C
?>
