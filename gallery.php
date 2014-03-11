<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

$terms = "";
$savedresults = "";
$shownew = "";
if ($_GET["search_id"]){
  	$db = new clsDBNetConnect;
   	$query = "select * from search_history where `id` = '" . $_GET["search_id"] . "'";
   	$db->query($query);
   	if ($db->next_record()){
  		$array = explode(" :!:!:: ", $db->f("value"));
   		$i = 0;
   		//print_r($array);
   		while ($array[$i]){
			$temp = explode(" ::!:!: ", $array[$i]);
    		$terms[$temp[0]] = $temp[1];
        	$i++;
        	if (strstr($temp[0], "custtxt_area::")){
        		if ($temp[1])
        			$custtxt_area[ltrim(end(explode("::", $temp[0])))] = $temp[1];
        	}
        	if (strstr($temp[0], "custtxt_box::")){
        		if ($temp[1])
        			$custtxt_box[ltrim(end(explode("::", $temp[0])))] = $temp[1];
        	}
        	if (strstr($temp[0], "custddbox::")){
        		if ($temp[1])
        			$custddbox[ltrim(end(explode("::", $temp[0])))] = $temp[1];
        	}
        	if (strstr($temp[0], "CatID")){
        		if ($temp[1])
        			$_GET["CatID"] = $temp[1];
        			$_GET["s_CatID"] = $temp[1];
        	}
		}
		if ($db->f("results") && !$_GET["refreshresults"]){
			$savedresults = "(";
			$array = explode(" :!:!:: ", $db->f("results"));
   			$i = 0;
   			//print_r($array);
   			while ($array[$i]){
				$temp = explode(" ::!:!: ", $array[$i]);
    			$savedresults .= "ItemNum = " . $temp[0];
        		$i++;
        		if ($array[$i])
        			$savedresults .= " or ";
        		else
        			$savedresults .= ")";
			}
			if ($_GET["shownew"] == 1 && $savedresults != "("){
				$shownew = str_replace("=", "!=", $savedresults);
				$shownew = str_replace("or", "and", $shownew);
				$shownew = " and " . $shownew;
			}
		}
	}
}

if (!CCGetUserID() && $_GET["CatID"]){
	$db = new CLSDBNetConnect;
	$query = "select * from categories where cat_id=" . $_GET["CatID"];
	$db->query($query);
	if ($db->next_record()){
		if ($db->f("member") == 1)
		CCSecurityRedirect("1;2", "login.php", "ViewCat.php", CCGetQueryString("QueryString", ""));
	}
}


//End Include Common Files
$page="Viewing the Gallery";
global $REMOTE_ADDR;
global $now;
$ip=$REMOTE_ADDR;
$timeout = $now["timeout"];
$db1 = new clsDBNetConnect;
$db2 = new clsDBNetConnect;
$db3 = new clsDBNetConnect;
$db4 = new clsDBNetConnect;
$db5 = new clsDBNetConnect;
$times = time();

$SQL1 = "DELETE FROM online WHERE datet < $times";
$SQL2 = "SELECT * FROM online WHERE ip='$ip'";
$SQL3 = "UPDATE online SET datet=$times + $timeout, page='$page', user='" . CCGetUserName() . "' WHERE ip='$ip'";
$SQL4 = "INSERT INTO online (ip, datet, user, page) VALUES ('$ip', $times+$timeout,'". CCGetUserName() . "', '$page')";
$SQL5 = "SELECT * FROM online";

$db1->query($SQL1);
$db2->query($SQL2);
if($db2->next_record()){
        $db3->query($SQL3);
} else {
        $db4->query($SQL4);
}

$db5->query($SQL5);
$usersonline = $db5->num_rows();
unset($db1);
unset($db2);
unset($db3);
unset($db4);
unset($db5);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

class clsGriditems { //items class @4-DDF99D24

//Variables @4-9DA56C47

    // Public variables
    var $ComponentName;
    var $Visible; var $Errors;
    var $ds; var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    // Grid Controls
    var $StaticControls; var $RowControls;
    var $Navigator;
//End Variables

//Class_Initialize Event @4-FB512734
    function clsGriditems()
    {
        global $FileName;
        $this->ComponentName = "items";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 16;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->image_one = new clsControl(ccsLabel, "image_one", "image_one", ccsText, "", CCGetRequestParam("image_one", ccsGet));
        $this->image_one->HTML = true;
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->make_offer = new clsControl(ccsLabel, "make_offer", "make_offer", ccsInteger, "", CCGetRequestParam("make_offer", ccsGet));
        $this->make_offer->HTML = true;
        $this->asking_price = new clsControl(ccsLabel, "asking_price", "asking_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", ccsGet));
        $this->started = new clsControl(ccsLabel, "started", "started", ccsInteger, "", CCGetRequestParam("started", ccsGet));
        $this->city_town = new clsControl(ccsLabel, "city_town", "city_town", ccsText, "", CCGetRequestParam("city_town", ccsGet));
        $this->state_province = new clsControl(ccsLabel, "state_province", "state_province", ccsText, "", CCGetRequestParam("state_province", ccsGet));
        $this->itemslink = new clsControl(ccsLink, "itemslink", "itemslink", ccsText, "", CCGetRequestParam("itemslink", ccsGet));
        $this->itemslink->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
        $this->itemslink->Page = "ViewCat.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @4-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @4-08599B42
    function Show()
    {
        global $Tpl;
        global $now;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["urls_title"] = CCGetFromGet("s_title", "");
        $this->ds->Parameters["urls_description"] = CCGetFromGet("s_description", "");
        $this->ds->Parameters["urlShowFeatured"] = CCGetFromGet("ShowFeatured", "");
        if(CCGetFromGet("CatID", "")){
                $catdb1 = new clsDBNetConnect;
                $catdb1->connect();
                $newSQL1 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . CCGetFromGet("CatID", "") . "'";
                $incat = "'" . CCGetFromGet("CatID", "") . "'";
                if ($terms["CatID"]) {
                	$newSQL1 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $terms["CatID"] . "'";
                	$incat = "'" . $terms["CatID"] . "'";
                }
                $catdb1->query($newSQL1);
                while($catdb1->next_record()){
                        $incat .= " OR category='" . $catdb1->f(0) . "'";
                        $catdb2 = new clsDBNetConnect;
                        $catdb2->connect();
                        $newSQL2 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";
                        $catdb2->query($newSQL2);
                        while($catdb2->next_record()){
                                $incat .= " OR category='" . $catdb2->f(0) . "'";
                                $catdb3 = new clsDBNetConnect;
                                $catdb3->connect();
                                $newSQL3 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb2->f(0) . "'";
                                $catdb3->query($newSQL3);
                                while($catdb3->next_record()){
                                        $incat .= " OR category='" . $catdb3->f(0) . "'";
                                        $catdb4 = new clsDBNetConnect;
                                        $catdb4->connect();
                                        $newSQL4 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb3->f(0) . "'";
                                        $catdb4->query($newSQL4);
                                        while($catdb4->next_record()){
                                                $incat .= " OR category='" . $catdb4->f(0) . "'";
                                                $catdb5 = new clsDBNetConnect;
                                                $catdb5->connect();
                                                $newSQL5 = "SELECT cat_id FROM categories WHERE sub_cat_id='" . $catdb4->f(0) . "'";
                                                $catdb5->query($newSQL5);
                                                while($catdb5->next_record()){
                                                        $incat .= " OR category='" . $catdb5->f(0) . "'";
                                                }
                                        }
                                }
                        }
                }
                }
                //print $incat;
                $this->ds->Parameters["urlCatID"] = $incat; //CCGetFromGet("CatID", "");
                $this->ds->Parameters["urls_ItemNum"] = CCGetFromGet("s_ItemNum", "");
                if(CCGetFromGet("s_user_id", "")){
                        $userfind = CCGetFromGet("s_user_id", "");
                        $findDB = new clsDBNetConnect;
                        $GetUser = CCDlookUP("user_id","users","user_login='" . $userfind . "'",$findDB);
                        if($GetUser == NULL){
                                $GetUser = 1000000000000;
                        }
                }
                if(CCGetFromGet("User_ID", "")){
                        $GetUser = CCGetFromGet("User_ID", "");
                }
                $this->ds->Parameters["urls_user_id"] = $GetUser;
        $this->ds->Parameters["urls_asking_min"] = CCGetFromGet("s_asking_min", "");
        $this->ds->Parameters["urls_asking_max"] = CCGetFromGet("s_asking_max", "");
        $this->ds->Parameters["urls_make_offer"] = CCGetFromGet("s_make_offer", "");
        $this->ds->Parameters["urls_quantity"] = CCGetFromGet("s_quantity", "");
        $this->ds->Parameters["urls_city_town"] = CCGetFromGet("s_city_town", "");
        $this->ds->Parameters["urls_state_province"] = CCGetFromGet("s_state_province", "");
        $this->ds->Parameters["urls_category"] = CCGetFromGet("s_category", "");
        //$this->ds->Parameters["urlCatID"] = CCGetFromGet("CatID", "");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        $CounterItems = 1;
                if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                $Tpl->SetVar("breaker", "");
                                if(($CounterItems % 4) == 0) {
                                    $Tpl->SetVar("breaker", "</tr><tr>");
                                }
                                $CounterItems++;
                                if($this->ds->image_one->GetValue() != ""){
                                	if ($now["has_gd"])
                                	    $this->image_one->SetValue("<table bgcolor=\"#000000\" border=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\"><img src=\"imageresizer.php?heightsize=75&widthsize=75&filename=". $this->ds->image_one->GetValue()."\" border=0 /></a></td></tr></table>");
									else
                                        $this->image_one->SetValue("<table bgcolor=\"#000000\" border=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\">" . thumbnail($this->ds->image_one->GetValue(),75,75,0,0) . "</a></td></tr></table>");
                                }
                                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                if($this->ds->make_offer->GetValue() == 1){
                                        $this->make_offer->SetValue("<BR><font color=#ff0000>(Make Offer)</font>");
                                } else {
                                        $this->make_offer->SetValue("");
                                }
                $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                $theday = getdate($this->ds->started->GetValue());
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->started->SetValue($enddate);
                if($this->ds->city_town->GetValue() != ""){
                        $this->city_town->SetValue($this->ds->city_town->GetValue() . ", ");
                } else {
                                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                                }
                $this->state_province->SetValue($this->ds->state_province->GetValue());

                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->image_one->Show();
                $this->ItemNum->Show();
                $this->title->Show();
                $this->make_offer->Show();
                $this->asking_price->Show();
                $this->started->Show();
                $this->city_town->Show();
                $this->state_province->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->itemslink->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method



} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//Variables @4-DAF817C3
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $image_one;
    var $ItemNum;
    var $title;
    var $make_offer;
    var $asking_price;
    var $started;
    var $city_town;
    var $state_province;
//End Variables

//Class_Initialize Event @4-28856087
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->image_one = new clsField("image_one", ccsText, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->make_offer = new clsField("make_offer", ccsInteger, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->started = new clsField("started", ccsInteger, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state_province = new clsField("state_province", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-0B1C05C8
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "started desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            "");
    }
//End SetOrder Method

//Prepare Method @4-F7ECADCE
    function Prepare()
    {
    	global $terms;
    	global $savedresults;
    	global $shownew;
    	global $custtxt_box;
    	global $custtxt_area;
    	global $custddbox;
    	
    	if (!$savedresults || ($savedresults && $shownew) || $shownew){
			if ($_GET["s_indexsearch"]){
	    		$addedwhere = index_search($_GET["s_indexsearch"]);
    			if (strlen($addedwhere) > 5)
	    			$addedwhere = " and (" . $addedwhere . ")";
    			else 
	    			$addedwhere = " and (ItemNum = -1)";
    		}
        	$this->wp = new clsSQLParameters();
        	$this->wp->AddParameter("1", "urls_title", ccsText, "", "", $this->Parameters["urls_title"], "");
        	$this->wp->AddParameter("2", "urls_description", ccsMemo, "", "", $this->Parameters["urls_description"], "");
        	$this->wp->AddParameter("4", "urlShowFeatured", ccsInteger, "", "", $this->Parameters["urlShowFeatured"], "");
        	$this->wp->AddParameter("5", "urls_ItemNum", ccsInteger, "", "", $this->Parameters["urls_ItemNum"], "");
        	$this->wp->AddParameter("6", "urls_user_id", ccsInteger, "", "", $this->Parameters["urls_user_id"], "");
        	$this->wp->AddParameter("7", "urls_asking_min", ccsFloat, "", "", $this->Parameters["urls_asking_min"], "");
        	$this->wp->AddParameter("8", "urls_asking_max", ccsFloat, "", "", $this->Parameters["urls_asking_max"], "");
        	$this->wp->AddParameter("9", "urls_make_offer", ccsInteger, "", "", $this->Parameters["urls_make_offer"], "");
        	$this->wp->AddParameter("10", "urls_quantity", ccsInteger, "", "", $this->Parameters["urls_quantity"], "");
        	$this->wp->AddParameter("11", "urls_city_town", ccsText, "", "", $this->Parameters["urls_city_town"], "");
        	$this->wp->AddParameter("12", "urls_state_province", ccsText, "", "", $this->Parameters["urls_state_province"], "");
        	$this->wp->AddParameter("13", "urls_category", ccsInteger, "", "", $this->Parameters["urls_category"], "");
        	$this->wp->AddParameter("14", "urlCatID", ccsText, "", "", $this->Parameters["urlCatID"], "");
        	$this->wp->Criterion[1] = $this->wp->Operation(opContains, "title", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText));
        	$this->wp->Criterion[2] = $this->wp->Operation(opContains, "description", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsMemo));
        	$this->wp->Criterion[3] = "status='1'";
        	$this->wp->Criterion[4] = $this->wp->Operation(opEqual, "home_featured", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger));
        	$this->wp->Criterion[5] = $this->wp->Operation(opEqual, "ItemNum", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger));
        	$this->wp->Criterion[6] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsInteger));
        	$this->wp->Criterion[7] = $this->wp->Operation(opGreaterThanOrEqual, "asking_price", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsFloat));
        	$this->wp->Criterion[8] = $this->wp->Operation(opLessThanOrEqual, "asking_price", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsFloat));
        	$this->wp->Criterion[9] = $this->wp->Operation(opEqual, "make_offer", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsInteger));
        	$this->wp->Criterion[10] = $this->wp->Operation(opGreaterThanOrEqual, "quantity", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsInteger));
        	$this->wp->Criterion[11] = $this->wp->Operation(opContains, "city_town", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsText));
        	$this->wp->Criterion[12] = $this->wp->Operation(opContains, "state_province", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsText));
        	$this->wp->Criterion[13] = $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsInteger));
        	if(CCGetFromGet("CatID","")){
                        	$this->wp->Criterion[14] = "(" . $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("14"), $this->wp->GetDBValue("14")) . ")";
                	} else {
                        	$this->wp->Criterion[14] = $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("14"), $this->wp->GetDBValue("14"));
                	}
                	$this->wp->Criterion[15] = "gallery_featured='1'";
        	if ($terms){				
				if ($terms["s_indexsearch"]){
    				$addedwhere = index_search($terms["s_indexsearch"]);
    				if (strlen($addedwhere) > 5)
	    				$addedwhere = " and (" . $addedwhere . ")";
    				else 
	    				$addedwhere = " and (ItemNum = -1)";
    			}
    			if (is_array($custtxt_area) && $addedwhere != " and (ItemNum = -1)"){
    				$i = 0;
    				$keys = array_keys($custtxt_area);
    				foreach ($custtxt_area as $val){
    					$addedwhere = searchcustom($val, "ta", $keys[$i], $addedwhere);
    					$i++;
    					if (strlen($addedwhere) > 5)
    						$addedwhere = " and (" . $addedwhere . ")";
    					else
    						$addedwhere = " and (ItemNum = -1)";
    				}
    			}
    			if (is_array($custtxt_box) && $addedwhere != " and (ItemNum = -1)"){
    				$i = 0;
    				$keys = array_keys($custtxt_box);
    				foreach ($custtxt_box as $val){
    					$addedwhere = searchcustom($val, "tb", $keys[$i], $addedwhere);
    					$i++;
    					if (strlen($addedwhere) > 5)
    						$addedwhere = " and (" . $addedwhere . ")";
    					else
    						$addedwhere = " and (ItemNum = -1)";
    				}
    			}
    			if (is_array($custddbox) && $addedwhere != " and (ItemNum = -1)"){
    				$i = 0;
    				$keys = array_keys($custddbox);
    				foreach ($custddbox as $val){
    					$addedwhere = searchcustom($val, "dd", $keys[$i], $addedwhere);
    					$i++;
    					if (strlen($addedwhere) > 5)
    						$addedwhere = " and (" . $addedwhere . ")";
    					else
    						$addedwhere = " and (ItemNum = -1)";
    				}
    			}
    			
				
				if ($terms["s_title"])
					$this->wp->Criterion[1] = "`title` like '%" . $terms["s_title"] . "%'";
				if ($terms["s_description"])
        			$this->wp->Criterion[2] = "`description` like '%" . $terms["s_description"] . "%'";
        		$this->wp->Criterion[3] = "status='1'";
        		$this->wp->Criterion[4] = $this->wp->Operation(opEqual, "home_featured", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsInteger));
        		if ($terms["s_ItemNum"])
        			$this->wp->Criterion[5] = "`ItemNum` = '" . $terms["s_ItemNum"] . "'";
        		if ($terms["s_user_id"])
        			$this->wp->Criterion[6] = "`user_id` = '" . $terms["s_user_id"] . "'";
        		if ($terms["s_asking_price"])
        			$this->wp->Criterion[7] = "`asking_price` >= '" . $terms["s_asking_price"] . "'";
        		if ($terms["s_asking_price"])
        			$this->wp->Criterion[8] = "`asking_price` <= '" . $terms["s_asking_price"] . "'";
        		if ($terms["s_make_offer"])
        			$this->wp->Criterion[9] = "`make_offer` = '" . $terms["s_make_offer"] . "'";
        		if ($terms["s_quantity"])
        			$this->wp->Criterion[10] = "`quantity` >= '" . $terms["s_quantity"] . "'";
        		if ($terms["s_city_town"])
        			$this->wp->Criterion[11] = "`city_town` like '%" . $terms["s_city_town"] . "%'";
        		if ($terms["s_state_province"])
        			$this->wp->Criterion[12] = "`state_province` like '%" . $terms["s_state_province"] . "%'";
        		//if ($terms["s_CatID"])
        		//$this->wp->Criterion[13] = "`category` = '" . $terms["s_CatID"] . "'";
        		if($terms["CatID"]){
                       $this->wp->Criterion[14] = "(" . $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("14"), $this->wp->GetDBValue("14")) . ")";
               	} else {
                       $this->wp->Criterion[14] = $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("14"), $this->wp->GetDBValue("14"));
               	}
               	$this->wp->Criterion[15] = "gallery='1'";
        	}
        	$this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]), $this->wp->Criterion[6]), $this->wp->Criterion[7]), $this->wp->Criterion[8]), $this->wp->Criterion[9]), $this->wp->Criterion[10]), $this->wp->Criterion[11]), $this->wp->Criterion[12]), $this->wp->Criterion[13]), $this->wp->Criterion[14]), $this->wp->Criterion[15]);
        	$this->Where = $this->wp->AssembledWhere . $addedwhere . $shownew;
    	}
    	elseif ($savedresults && !$shownew) {
    		$this->Where = $savedresults;
    	}
               // Uncomment Below to Debug
               //print $this->Where;
               
	}
//End Prepare Method

//Open Method @4-368AA817
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM items";
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        if (($terms && !$savedresults) || ($terms && $_GET["refreshresults"])){
        	$db = new clsDBNetConnect;
        	$db->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        	$resultstring = "";
        	while($db->next_record()){
        		$resultstring .= $db->f("ItemNum") . " ::!:!: " . $db->f("title") . " :!:!:: ";
        	}
        	$db->query("update search_history set `results` = '" . mysql_escape_string($resultstring) . "' where `id` = '" . $_GET["search_id"] . "'");
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-F585FF4D
    function SetValues()
    {
        $this->image_one->SetDBValue($this->f("image_one"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->title->SetDBValue($this->f("title"));
        $this->make_offer->SetDBValue($this->f("make_offer"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->started->SetDBValue($this->f("started"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state_province->SetDBValue($this->f("state_province"));
    }
//End SetValues Method

} //End itemsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-B4813547
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";
if ($_GET["prev"])
	$file = "temp_templates/" . $_GET["prev"] . ".html";
elseif (CCGetFromGet("CatID",""))
$file = GetGalTemlate(CCGetFromGet("CatID",""));
else
$file = "templates/gallery.html";
$FileName = "gallery.php";
$Redirect = "";
$TemplateFileName = $file;
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-8E923392

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$items = new clsGriditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$items->Initialize();

// Events
include("./gallery_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-351F985C
$Header->Operations();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-BEB91355
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
    header("Location: " . $Redirect);
    exit;
}
//End Go to destination page

//Initialize HTML Template @1-A0111C9D
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView");
$Tpl = new clsTemplate();
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-F9F38336
$Header->Show("Header");
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page
if ($file != "templates/gallery.html")
unlink($file);
//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
