<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

$admingroup = 0;
$admingroup = test_admin_group();

if ($_POST["SaveChanges"] && $admingroup){
	$db = new clsDBNetConnect;
	foreach ($_POST as $key=>$value){
		if (rtrim(current(explode("_", $key))) == "cat"){
			if ($value) {
				$keyarray = explode("_", $key);
				$db->query("update categories set `name` = '" . mysql_escape_string(html_entity_decode($value)) . "' where `cat_id` = '" . $keyarray[1] . "'");
			}
		}
	}
	$order = explode("|",$_POST["order"]);
	$i = 0;
	while ($order[$i]){
		$x = $i + 1;
		$db->query("update categories set `weight` = '" . $x . "' where `cat_id` = '" . $order[$i] . "'");
		$i++;
	}
	header("Location: ViewCat.php?" . CCGetQueryString("QueryString", array()));
}

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
        	if (strstr($temp[0], "s_user_id") && $temp[1]){
        		$username = new clsDBNetConnect;
        		$query = "select `user_id` from users where `user_login` = '" . mysql_escape_string($temp[1]) . "'";
        		$username->query($query);
        		if ($username->next_record()){
        			$terms[$temp[0]] = $username->f("user_id");
        			$_GET["s_user_id"] = $temp[1];
        		}
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

if ($_POST["saveAddCats"] && $admingroup && $_POST["addcategory"]){
	$db = new clsDBNetConnect;
	$newcats = explode(";", $_POST["addcategory"]);
	$i = 0;
	while ($newcats[$i]){
		$newcats[$i] = trim($newcats[$i]);
		if (strlen($newcats[$i]) > 0)
			$db->query("insert into `categories` set `name` = '" . mysql_escape_string($newcats[$i]) . "', `sub_cat_id` = '" . $_GET["CatID"] . "'");
		$i++;
	}
	header("Location: ViewCat.php?" . CCGetQueryString("QueryString", array()));
}

$itemcatcounts = get_catcounts($_GET["CatID"]);
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
$page="Viewing Listings";
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
unset($db1);unset($db2);unset($db3);unset($db4);unset($db5);unset($SQL1);unset($SQL2);unset($SQL3);unset($SQL4);unset($SQL5);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecorditemsSearch { //itemsSearch Class @40-187A0E52

//Variables @40-90DA4C9A

    // Public variables
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $FormSubmitted;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @40-CA1E29CF
    function clsRecorditemsSearch()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "itemsSearch";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_title = new clsControl(ccsTextBox, "s_title", "s_title", ccsText, "", CCGetRequestParam("s_title", $Method));
            $this->s_description = new clsControl(ccsTextBox, "s_description", "s_description", ccsMemo, "", CCGetRequestParam("s_description", $Method));
            $this->CatID = new clsControl(ccsCheckBox, "CatID", "CatID", ccsInteger, "", CCGetRequestParam("CatID", $Method));
            $this->CatID->CheckedValue = 1;
            $this->CatID->UncheckedValue = 0;
            $this->DoSearch = new clsButton("DoSearch");
        }
    }
//End Class_Initialize Event

//Validate Method @40-54A6BF9F
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_title->Validate() && $Validation);
        $Validation = ($this->s_description->Validate() && $Validation);
        $Validation = ($this->CatID->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @40-10587EFF
    function Operation()
    {
        global $Redirect;

        $this->EditMode = false;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = "DoSearch";
            if(strlen(CCGetParam("DoSearch", ""))) {
                $this->PressedButton = "DoSearch";
            }
        }
        $Redirect = "search.php?DoSearch=Search&ccsForm=itemsSearch&GetOutside=1&" . CCGetQueryString("Form", Array("ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "DoSearch") {
                if(!CCGetEvent($this->DoSearch->CCSEvents, "OnClick")) {
                    $Redirect = "";
                } else {
                    $Redirect = "search.php?DoSearch=Search&ccsForm=itemsSearch&GetOutside=1&" . CCGetQueryString("Form", Array(""));
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @40-A1114EB3
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if(!$this->FormSubmitted)
        {
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->s_title->Errors->ToString();
            $Error .= $this->s_description->Errors->ToString();
            $Error .= $this->CatID->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->SetVar("cat_id_in", $_GET["CatID"]);
        $this->s_title->Show();
        $this->s_description->Show();
        $this->CatID->Show();
        $this->DoSearch->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End itemsSearch Class @40-FCB6E20C

class clsGridcategories { //categories class @46-3B8F933E

//Variables @46-9AD3C4FA

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
//End Variables

//Class_Initialize Event @46-5895D9BF
    function clsGridcategories()
    {
        global $FileName;
        $this->ComponentName = "categories";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscategoriesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->cat_id = new clsControl(ccsLabel, "cat_id", "cat_id", ccsInteger, "", CCGetRequestParam("cat_id", ccsGet));
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet));
    }
//End Class_Initialize Event

//Initialize Method @46-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @46-A18922D0
    function Show()
    {
        global $Tpl;
        global $itemcatcounts;
        
        global $admingroup;
        if(!$this->Visible) return;
        
                if ($admingroup){
        	$EditCSS = "
<link rel=\"stylesheet\" type=\"text/css\" href=\"./edit-inplace/lists.css\"/>
<style type=\"text/css\"><!--

.view:hover {
	background-color: #ffffcc;
}
.view, .inplace {
	font-size: 10px;
	font-family: sans-serif;
}

.inplace {
	position: absolute;
	visibility: hidden;
	z-index: 10000;
}
.inplace {
	background-color: #ffffcc;
}

#categorylists td {
	width: 9em;
	margin-right: 20px; 
	padding: 0px 20px;
	vertical-align: top;
}
#categorylists th {
	vertical-align: bottom;
	font-weight: normal;
	font-size: 10px;
	padding-top: 20px;
}
#categorylists td.caption {
	font-size: 12px;
	text-align: center;
}
#categorylists li {
	padding: 0px;
	min-height: 1em;
	width: 120px;
}
#categorylists li .view {
	vertical-align: middle;
	padding: 2px;
}
#categorylists input.inplace {
	width: 120px;
	max-width: 120px;
}

/* BugFix: Firefox: avoid bottom margin on draggable elements */
#categorylists #cat_li, #categorylists { margin-top: -2px; }
#categorylists #cat_li li, #categorylists { margin-top: 4px; }

#categorylists #cat_li li { cursor: default; }
#categorylists #cat_li .handle,
{
	float: right;
	background-image: url(./edit-inplace/handle.png);
	background-repeat: repeat-y;
	width: 7px;
	height: 20px;
}
#categorylists #cat_li li .view {
	cursor: text;
}
#categorylists #cat_liEditors input.inplace, #categorylists {
	width: 104px;
	max-width: 104px;
}
#categorylists #cat_liEditors>input.inplace, #categorylists {
	width: 111px;
	max-width: 111px;
}

.inplace {
	margin: 0px;
	padding-left: 1px;
}
.handle {
	cursor: move;
}
.inspector {
	font-size: 11px;
}
--></style>
";
        	$EditJS = "window.onload = function() {
	dragsort.makeListSortable(document.getElementById(\"cat_li\"), setHandle)\n";
        	$OpenEditListEditor = "<form name=\"categories\" action=\"ViewCat.php?" . CCGetQueryString("QueryString", array()) . "\" method=\"POST\"><input class=\"inspector\" type=\"submit\" value=\"Save Changes\" name=\"SaveChanges\" onclick=\"return saveOrder('cat_li')\"/><div id=\"cat_liEditors\"><input type=\"hidden\" name=\"order\" value=\"\" id=\"catorder\">";
        	$OpenEditList = "<ul id=\"cat_li\" class=\"sortable boxy\">";
        }

        $ShownRecords = 0;

        $this->ds->Parameters["urlCatID"] = CCGetFromGet("CatID", "");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
            	if ($admingroup){
            		   	$this->ds->SetValues();
                		$Tpl->block_path = $GridBlock . "/EditRow";
                		$this->cat_id->SetValue($this->ds->cat_id->GetValue());
                		$this->name->SetValue($this->ds->name->GetValue());
                		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                		$this->cat_id->Show();
                		$this->name->Show();
                		$Tpl->SetVar("Count", "(" . $itemcatcounts[$this->ds->cat_id->GetValue()] . ")");
                		$Tpl->SetVar("","");
                		$OpenEditListEditor .= "<input id=\"cat_" . $this->ds->cat_id->GetValue() . "_Edit\" name=\"cat_" . $this->ds->cat_id->GetValue() . "_Edit\" class=\"inplace\" tabindex=\"10\"/>";
                		$EditJS .= "join(\"cat_" . $this->ds->cat_id->GetValue() . "_\", true)\n";
                		$Tpl->block_path = $GridBlock;
                		$Tpl->parse("EditRow", true);
                		$ShownRecords++;
                		$is_next_record = $this->ds->next_record();
            		} else {
                    	$this->ds->SetValues();
                		$Tpl->block_path = $GridBlock . "/Row";
                		$this->cat_id->SetValue($this->ds->cat_id->GetValue() . "&" . CCGetQueryString("QueryString", array("CatID","s_title","DoSearch","s_ItemNum","s_user_id","s_title","s_description","s_asking_min","s_asking_max","s_quantity","s_city_town","s_state_province","search_id","refreshresults")));
                		$this->name->SetValue($this->ds->name->GetValue());
                		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                		//$Tpl->SetVar("Count", "(" . CatCount($this->ds->cat_id->GetValue()) . ")");
                		$Tpl->SetVar("Count", "(" . $itemcatcounts[$this->ds->cat_id->GetValue()] . ")");
                		$this->cat_id->Show();
                		$this->name->Show();
                		$Tpl->block_path = $GridBlock;
                		$Tpl->parse("Row", true);
                		$ShownRecords++;
                		$is_next_record = $this->ds->next_record();
            		}
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
		if ($admingroup){
			$Tpl->SetVar("OpenEditList",$OpenEditList);
			$Tpl->SetVar("CloseEditList","</ul>");
			$Tpl->SetVar("OpenEditListEditor",$OpenEditListEditor . "</div></form>");
        	$Tpl->SetVar("EditCSS",$EditCSS);
        	$Tpl->SetVar("EditJS",$EditJS . "\n}");
		}
        $Tpl->parse("", false);
        $Tpl->block_path = "";
//Print " Build Side Cats = " . stopwatch($startpage) . "  ";
    }
//End Show Method

} //End categories Class @46-FCB6E20C

class clscategoriesDataSource extends clsDBNetConnect {  //categoriesDataSource Class @46-FD2FF1B0

//Variables @46-8F8275DA
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $cat_id;
    var $name;
//End Variables

//Class_Initialize Event @46-0FD0B5D8
    function clscategoriesDataSource()
    {
        $this->Initialize();
        $this->cat_id = new clsField("cat_id", ccsInteger, "");
        $this->name = new clsField("name", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @46-217A5C7E
    function SetOrder($SorterName, $SorterDirection)
    {
       $this->Order = "weight, name";
       $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_name" => array("name", "")));
    }
//End SetOrder Method

//Prepare Method @46-D871FF4E
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlCatID", ccsInteger, "", "", $_GET["CatID"], 1);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "sub_cat_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @46-87D4B51E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM categories";
        $this->SQL = "SELECT *  " .
        "FROM categories";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @46-0632F0F7
    function SetValues()
    {
        $this->cat_id->SetDBValue($this->f("cat_id"));
        $this->name->SetDBValue($this->f("name"));
    }
//End SetValues Method

} //End categoriesDataSource Class @46-FCB6E20C

class clsGriditems { //items class @4-DDF99D24

//Variables @4-9DA56C47

    // Public variables
    
    var $Sorter_title;
    var $Sorter_started;
    var $Sorter_location;
    var $Sorter_asking_price;
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

//Class_Initialize Event @4-9E569F9C

    function clsGriditems()
    {
        global $FileName;
                global $now;

        $this->ComponentName = "items";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = $now["pagentrys"];
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->SorterName = CCGetParam("itemsOrder", "");
        $this->SorterDirection = CCGetParam("itemsDir", "");

        $this->bold = new clsControl(ccsLabel, "bold", "bold", ccsInteger, "", CCGetRequestParam("bold", ccsGet));
        $this->bold->HTML = true;
        $this->bold2 = new clsControl(ccsLabel, "bold2", "bold2", ccsText, "", CCGetRequestParam("bold2", ccsGet));
        $this->bold2->HTML = true;
        $this->background = new clsControl(ccsLabel, "background", "background", ccsInteger, "", CCGetRequestParam("background", ccsGet));
        $this->background->HTML = true;
        $this->image_preview = new clsControl(ccsLabel, "image_preview", "image_preview", ccsInteger, "", CCGetRequestParam("image_preview", ccsGet));
                $this->image_preview->HTML = true;
        $this->image_one = new clsControl(ccsLabel, "image_one", "image_one", ccsText, "", CCGetRequestParam("image_one", ccsGet));
                $this->image_one->HTML = true;
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->make_offer = new clsControl(ccsLabel, "make_offer", "make_offer", ccsInteger, "", CCGetRequestParam("make_offer", ccsGet));
        $this->make_offer->HTML = true;
        $this->city_town = new clsControl(ccsLabel, "city_town", "city_town", ccsText, "", CCGetRequestParam("city_town", ccsGet));
        $this->state_province = new clsControl(ccsLabel, "state_province", "state_province", ccsText, "", CCGetRequestParam("state_province", ccsGet));
        $this->asking_price = new clsControl(ccsLabel, "asking_price", "asking_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", ccsGet));
        $this->started = new clsControl(ccsLabel, "started", "started", ccsInteger, "", CCGetRequestParam("started", ccsGet));
        $this->gallerylink = new clsControl(ccsLink, "gallerylink", "gallerylink", ccsText, "", CCGetRequestParam("gallerylink", ccsGet));
        $this->gallerylink->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
        $this->gallerylink->Page = "gallery.php";
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_started = new clsSorter($this->ComponentName, "Sorter_started", $FileName);
        $this->Sorter_asking_price = new clsSorter($this->ComponentName, "Sorter_asking_price", $FileName);
        $this->Sorter_location = new clsSorter($this->ComponentName, "Sorter_location", $FileName);
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

//Show Method @4-B28B5156
    function Show()
    {
    	global $startpage;
        global $Tpl;
        global $now;
        global $terms;
        if(!$this->Visible) return;

        $ShownRecords = 0;
        $featcount = 0;

        $this->ds->Parameters["urls_title"] = CCGetFromGet("s_title", "");
        $this->ds->Parameters["urls_description"] = CCGetFromGet("s_description", "");
        $this->ds->Parameters["urlShowFeatured"] = CCGetFromGet("ShowFeatured", "");
        if(CCGetFromGet("CatID", "") || $terms["CatID"]){
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
                if($_GET["s_user_id"]){
                        $userfind = $_GET["s_user_id"];
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
        $uncount = 0;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";

                                $this->image_one->SetValue("");
                                if($this->ds->cat_featured->GetValue() == 1 && ($featcount == 0)) {
                                        $Tpl->SetVar("beginFeat", "<tr><td class=\"feat\" height=\"27\" colspan=\"6\">&nbsp;&nbsp;Featured Items</td></tr>");
                                        $featcount++;
                                }
                                if($this->ds->cat_featured->GetValue() < 1 && ($featcount == 1)) {
                                        $this->image_one->SetValue("<tr class=\"wtbk\"><td colspan=\"6\">&nbsp;</td><tr><td class=\"feat\" height=\"27\" colspan=\"6\">&nbsp;&nbsp;End of Featured Items</td></tr>");
                                        $featuredcounter++;
                                        $featcount++;

                                }
                                if($this->ds->cat_featured->GetValue() == 1)
                                {
                                  $uncount++;
                                }
                                if($this->ds->bold->GetValue() == 1){
                                        $this->bold2->SetValue("</b>");
                        $this->bold->SetValue("<b>");
                                } else {
                                        $this->bold2->SetValue("");
                        $this->bold->SetValue("");
                                }
                if($this->ds->background->GetValue() == 1){
                                        $this->background->SetValue("bgcolor=\"#FFFFC0\"");
                                }else{
                                        $this->background->SetValue("class=\"wtbk\"");
                                }
                                if($this->ds->image_preview->GetValue() == 1 && $this->ds->image_one->GetValue() != ""){
                                    if ($now["has_gd"])
                                        $this->image_preview->SetValue("<table bgcolor=\"#000000\" border=\"0\" width=\"78\" height=\"75\" cellspacing=\"1\" cellpadding=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\" border=0><img src=\"imageresizer.php?heightsize=75&widthsize=75&filename=". $this->ds->image_one->GetValue()."\" border=0 /></a></td></tr></table>");
                                    else
                                        $this->image_preview->SetValue("<table bgcolor=\"#000000\" border=\"0\" width=\"78\" height=\"75\" cellspacing=\"1\" cellpadding=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\" border=0>" . thumbnail($this->ds->image_one->GetValue(),75,75,0,0) . "</a></td></tr></table>");
                                } elseif($this->ds->image_one->GetValue() != ""){
                                        $this->image_preview->SetValue("<img src=\"images/apic.gif\">");
                                } else {
                                        $this->image_preview->SetValue("");
                                }
                                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                if($this->ds->make_offer->GetValue() == 1){
                                        $this->make_offer->SetValue("&nbsp;<font color=#ff0000>(Make Offer)</font>");
                                } else {
                                        $this->make_offer->SetValue("");
                                }
                                if($this->ds->city_town->GetValue() != ""){
                        $this->city_town->SetValue($this->ds->city_town->GetValue() . ", ");
                } else {
                                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                                }
                                $this->state_province->SetValue($this->ds->state_province->GetValue());
                $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                $theday = getdate($this->ds->started->GetValue());
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->started->SetValue($enddate);
                                unset($newdate);
                                unset($theday);
                                unset($lastofyear);
                                unset($enddate);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->bold->Show();
                $this->bold2->Show();
                $this->background->Show();
                $this->image_preview->Show();
                                $this->image_one->Show();
                $this->ItemNum->Show();
                $this->title->Show();
                $this->make_offer->Show();
                $this->city_town->Show();
                $this->state_province->Show();
                $this->asking_price->Show();
                $this->started->Show();

                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->SetVar("CloseFeat", "<tr class=\"wtbk\"><td class=\"feat\" colspan=\"6\">End of Featured Items</td></tr>");
            $Tpl->parse("NoRecords", false);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->gallerylink->Show();
        $this->Sorter_title->Show();
        $this->Sorter_started->Show();
        $this->Sorter_asking_price->Show();
        $this->Sorter_location->Show();
        $this->Navigator->Show();
        if($uncount == 1)
        {
        $Tpl->SetVar("CloseFeat2", "<tr class=\"wtbk\"><td colspan=\"6\">&nbsp;</td></tr><tr><td class=\"feat\" colspan=\"6\">End of Featured Items</td></tr>");
        }
        $Tpl->parse("", false);
        $Tpl->block_path = "";
//Print stopwatch($startpage);
    }
//End Show Method



} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//Variables @4-B95100AA
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $image_one;
    var $background;
    var $image_preview;
    var $ItemNum;
    var $bold;
    var $title;
    var $make_offer;
    var $city_town;
    var $state_province;
    var $asking_price;
    var $started;
//End Variables

//Class_Initialize Event @4-23F7FF01
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->image_one = new clsField("image_one", ccsText, "");
        $this->background = new clsField("background", ccsInteger, "");
        $this->image_preview = new clsField("image_preview", ccsInteger, "");
        $this->cat_featured = new clsField("cat_featured", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->bold = new clsField("bold", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->make_offer = new clsField("make_offer", ccsInteger, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state_province = new clsField("state_province", ccsText, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->started = new clsField("started", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-CD06A131
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "cat_featured desc, started desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_title" => array("cat_featured desc, title", ""),
            "Sorter_started" => array("cat_featured desc, started", ""),
			"Sorter_asking_price" => array("cat_featured desc, asking_price", ""),
			"Sorter_location" => array("cat_featured desc, state_province " . $SorterDirection . ", city_town", "")));
    }
//End SetOrder Method

//Prepare Method @4-51CF56E0
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
    			$username = new clsDBNetConnect;
        		$query = "select `user_id` from users where `user_login` = '" . mysql_escape_string($temp[1]) . "'";
        		$username->query($query);
        		if ($username->next_record()){
        			$terms[$temp[0]] = $username->f("user_id");
        			$_GET["s_user_id"] = $username->f("user_id");
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
        		if ($terms["s_asking_min"])
        			$this->wp->Criterion[7] = "`asking_price` >= '" . $terms["s_asking_min"] . "'";
        		if ($terms["s_asking_max"])
        			$this->wp->Criterion[8] = "`asking_price` <= '" . $terms["s_asking_max"] . "'";
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
               	} elseif(!$terms[CatID] && !CCGetFromGet("CatID","")) {
                       $this->wp->Criterion[14] = $this->wp->Operation(opEqual, "category", $this->wp->GetDBValue("14"), $this->wp->GetDBValue("14"));
               	}
        	}
        	$this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]), $this->wp->Criterion[6]), $this->wp->Criterion[7]), $this->wp->Criterion[8]), $this->wp->Criterion[9]), $this->wp->Criterion[10]), $this->wp->Criterion[11]), $this->wp->Criterion[12]), $this->wp->Criterion[13]), $this->wp->Criterion[14]);
        	$this->Where = $this->wp->AssembledWhere . $addedwhere . $shownew;
    	}
    	elseif ($savedresults && !$shownew) {
    		$this->Where = $savedresults;
    	}
               // Uncomment Below to Debug
               //print "<hr>" . $this->Where;
               
        }
//End Prepare Method

//Open Method @4-368AA817
    function Open()
    {
        global $Tpl;
        global $terms;
        global $savedresults;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM items";
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        //print CCBuildSQL($this->SQL, $this->Where, $this->Order);
        if (($terms && !$savedresults) || ($terms && $_GET["refreshresults"])){
        	$db = new clsDBNetConnect;
        	$db->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        	$resultstring = "";
        	while($db->next_record()){
        		$resultstring .= $db->f("ItemNum") . " ::!:!: " . $db->f("title") . " :!:!:: ";
        	}
        	$db->query("update search_history set `results` = '" . mysql_escape_string($resultstring) . "' where `id` = '" . $_GET["search_id"] . "'");
        }
                $Tpl->SetVar("Results", $this->nf());
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-79E41A72
    function SetValues()
    {
        $this->image_one->SetDBValue($this->f("image_one"));
        $this->background->SetDBValue($this->f("background"));
        $this->image_preview->SetDBValue($this->f("image_preview"));
        $this->cat_featured->SetDBValue($this->f("cat_featured"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->bold->SetDBValue($this->f("bold"));
        $this->title->SetDBValue($this->f("title"));
        $this->make_offer->SetDBValue($this->f("make_offer"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state_province->SetDBValue($this->f("state_province"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->started->SetDBValue($this->f("started"));
    }
//End SetValues Method

} //End itemsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-F4925B03
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
	$file = GetStorefrontTemplate(CCGetFromGet("CatID",""));
else
	$file = "templates/ViewCat.html";
if ($file == "templates/ViewCat.html" && CCGetFromGet("CatID",""))
	$file = GetCatTemlate(CCGetFromGet("CatID",""));
$FileName = "ViewCat.php";
$Redirect = "";
$TemplateFileName = $file;
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-95636333

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$itemsSearch = new clsRecorditemsSearch();
$categories = new clsGridcategories();
$items = new clsGriditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$categories->Initialize();
$items->Initialize();

// Events
include("./ViewCat_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-B06FCBC8
$Header->Operations();
$itemsSearch->Operation();
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
//include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

$Tpl->SetVar("QueryString", CCGetQueryString("QueryString", array()));

//Show Page @1-7E62AA77
$Header->Show("Header");
$itemsSearch->Show();
$categories->Show();
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page
if ($file != "templates/ViewCat.html")
unlink($file);
//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
