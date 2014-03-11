<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @33-503267A8
include("./Header.php");
//End Include Page implementation

$admins = new clsDBNetConnect;
$admins->query("select * from administrators");
if ($admins->next_record()){
    $key = md5($admins->f("username") . "AdMin kkkkkey" . $admins->f("password"));
}

if ($_GET["delete"] && $_GET["adminkey"] == $key){
	$db = new clsDBNetConnect;
	$query = "select * from items where ItemNum = " . $_GET["delete"];
	$db->query($query);
	if ($db->next_record()){
		if ($db->f("image_one"))
		    unlink("../" . $db->f("image_one"));
        if ($db->f("image_two"))
		    unlink("../" . $db->f("image_two"));
        if ($db->f("image_three"))
		    unlink("../" . $db->f("image_three"));
        if ($db->f("image_four"))
		    unlink("../" . $db->f("image_four"));
        if ($db->f("image_five"))
		    unlink("../" . $db->f("image_five"));
	}
	if ($db->f("status") == 1)
		subtract_catcounts($db->f("category"));
	$query = "delete from items where ItemNum = " . $_GET["delete"];
	$db->query($query);
	$query = "delete from custom_dropdown_values where ItemNum = " . $_GET["delete"];
	$db->query($query);
	$query = "delete from custom_textbox_values where ItemNum = " . $_GET["delete"];
	$db->query($query);
	$query = "delete from custom_textarea_values where ItemNum = " . $_GET["delete"];
	$db->query($query);
}

class clsGriditems { //items class @12-DDF99D24

//Variables @12-EAD8F07D

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
    var $Sorter_ItemNum;
    var $Sorter_title;
    var $Sorter_user_id;
    var $Sorter_status;
    var $Sorter_started;
    var $Navigator;
//End Variables

//Class_Initialize Event @12-94589A44
    function clsGriditems()
    {
        global $FileName;
        global $key;
        
        $this->ComponentName = "items";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("itemsOrder", "");
        $this->SorterDirection = CCGetParam("itemsDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsText, "", CCGetRequestParam("user_id", ccsGet));
        $this->status = new clsControl(ccsLabel, "status", "status", ccsText, "", CCGetRequestParam("status", ccsGet));
        $this->started = new clsControl(ccsLabel, "started", "started", ccsText, "", CCGetRequestParam("started", ccsGet));
        $this->Sorter_ItemNum = new clsSorter($this->ComponentName, "Sorter_ItemNum", $FileName);
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_user_id = new clsSorter($this->ComponentName, "Sorter_user_id", $FileName);
        $this->Sorter_status = new clsSorter($this->ComponentName, "Sorter_status", $FileName);
        $this->Sorter_started = new clsSorter($this->ComponentName, "Sorter_started", $FileName);
        $this->items_Insert = new clsControl(ccsLink, "items_Insert", "items_Insert", ccsText, "", CCGetRequestParam("items_Insert", ccsGet));
        $this->items_Insert->Parameters = CCGetQueryString("QueryString", Array("itemID", "ccsForm"));
        $this->items_Insert->Page = "../catlist.php?adminkey=" . $key;
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @12-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @12-774AC51B
    function Show()
    {
        global $Tpl;
        global $key;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["urls_title"] = CCGetFromGet("s_title", "");
        $this->ds->Parameters["urls_ItemNum"] = CCGetFromGet("s_ItemNum", "");
        $this->ds->Parameters["urls_city_town"] = CCGetFromGet("s_city_town", "");
        $this->ds->Parameters["urls_state_province"] = CCGetFromGet("s_state_province", "");
        $this->ds->Parameters["urls_status"] = CCGetFromGet("s_status", "");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                $this->Detail->Parameters = CCGetQueryString("QueryString", Array("ccsForm","ItemNum","Item_Number","finalcat","adminkey"));
                //$this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "itemID", $this->ds->f("itemID"));
                $this->Detail->Page = "../catlist.php?adminkey=" . $key . "&Item_Number=" . $this->ds->ItemNum->GetValue();
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                $this->user_id->SetValue(GetUserNameID($this->ds->user_id->GetValue()));
                $this->status->SetValue(GetItemStatus($this->ds->status->GetValue()));
                $this->started->SetValue(date("F j, Y, g:i a", $this->ds->started->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
				$Tpl->setVar("adminkey", $key);
				//$this->Detail->Show();
                $this->ItemNum->Show();
                $this->title->Show();
                $this->user_id->Show();
                $this->status->Show();
                $this->started->Show();
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
		$Tpl->setVar("adminkey", $key);
        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_ItemNum->Show();
        $this->Sorter_title->Show();
        $this->Sorter_user_id->Show();
        $this->Sorter_status->Show();
        $this->Sorter_started->Show();
        $this->items_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @12-FCB6E20C

class clsitemsDataSource extends clsDBDBNetConnect {  //itemsDataSource Class @12-90839405

//DataSource Variables @12-1949FC16
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $ItemNum;
    var $title;
    var $user_id;
    var $status;
    var $started;
//End DataSource Variables

//Class_Initialize Event @12-739E059E
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->user_id = new clsField("user_id", ccsText, "");
        $this->status = new clsField("status", ccsText, "");
        $this->started = new clsField("started", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @12-4DFAC322
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "ItemNum, title, status, started";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_ItemNum" => array("ItemNum", ""), 
            "Sorter_title" => array("title", ""), 
            "Sorter_user_id" => array("user_id", ""), 
            "Sorter_status" => array("status", ""), 
            "Sorter_started" => array("started", "")));
    }
//End SetOrder Method

//Prepare Method @12-224254FC
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urls_title", ccsText, "", "", $this->Parameters["urls_title"], "");
        $this->wp->AddParameter("2", "urls_ItemNum", ccsInteger, "", "", $this->Parameters["urls_ItemNum"], "");
        $this->wp->AddParameter("3", "urls_city_town", ccsText, "", "", $this->Parameters["urls_city_town"], "");
        $this->wp->AddParameter("4", "urls_state_province", ccsText, "", "", $this->Parameters["urls_state_province"], "");
        $this->wp->AddParameter("5", "urls_status", ccsInteger, "", "", $this->Parameters["urls_status"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opContains, "`title`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText));
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "`ItemNum`", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "`city_town`", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText));
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "`state_province`", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText));
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "`status`", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsInteger));
        $this->Where = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]);
    }
//End Prepare Method

//Open Method @12-368AA817
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
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @12-FCED49C3
    function SetValues()
    {
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->title->SetDBValue($this->f("title"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->status->SetDBValue($this->f("status"));
        $this->started->SetDBValue($this->f("started"));
    }
//End SetValues Method

} //End itemsDataSource Class @12-FCB6E20C

//Include Page implementation @34-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-4491C9BD
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

$FileName = "ItemsList.php";
$Redirect = "";
$TemplateFileName = "Themes/ItemsList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-9EBE738D
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$items = new clsGriditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$items->Initialize();

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
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-F9F38336
$Header->Show("Header");
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


//DEL      function SetOrder($SorterName, $SorterDirection)
//DEL      {
//DEL          $this->Order = "started DESC";
//DEL          $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
//DEL              array("Sorter_ItemNum" => array("ItemNum", ""), 
//DEL              "Sorter_title" => array("title", ""), 
//DEL              "Sorter_user_id" => array("user_id", ""),
//DEL              "Sorter_status" => array("status", ""),
//DEL              "Sorter_started" => array("started", "")));
//DEL      }



?>
