<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @12-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridlookup_ages { //lookup_ages class @2-BDD0DAE2

//Variables @2-B24A41E1

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
    var $Sorter_age_id;
    var $Sorter_age_desc;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-5D44B89D
    function clsGridlookup_ages()
    {
        global $FileName;
        $this->ComponentName = "lookup_ages";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_agesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_agesOrder", "");
        $this->SorterDirection = CCGetParam("lookup_agesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->age_id = new clsControl(ccsLabel, "age_id", "age_id", ccsInteger, "", CCGetRequestParam("age_id", ccsGet));
        $this->age_desc = new clsControl(ccsLabel, "age_desc", "age_desc", ccsText, "", CCGetRequestParam("age_desc", ccsGet));
        $this->Sorter_age_id = new clsSorter($this->ComponentName, "Sorter_age_id", $FileName);
        $this->Sorter_age_desc = new clsSorter($this->ComponentName, "Sorter_age_desc", $FileName);
        $this->lookup_ages_Insert = new clsControl(ccsLink, "lookup_ages_Insert", "lookup_ages_Insert", ccsText, "", CCGetRequestParam("lookup_ages_Insert", ccsGet));
        $this->lookup_ages_Insert->Parameters = CCGetQueryString("QueryString", Array("age_id", "ccsForm"));
        $this->lookup_ages_Insert->Page = "AgesEdit.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @2-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @2-2D845685
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

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
                $this->Detail->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "age_id", $this->ds->f("age_id"));
                $this->Detail->Page = "AgesEdit.php";
                $this->age_id->SetValue($this->ds->age_id->GetValue());
                $this->age_desc->SetValue($this->ds->age_desc->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->age_id->Show();
                $this->age_desc->Show();
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
        $this->Sorter_age_id->Show();
        $this->Sorter_age_desc->Show();
        $this->lookup_ages_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_ages Class @2-FCB6E20C

class clslookup_agesDataSource extends clsDBDBNetConnect {  //lookup_agesDataSource Class @2-2C28DB35

//Variables @2-48C92BDC
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $age_id;
    var $age_desc;
//End Variables

//Class_Initialize Event @2-E685BE4A
    function clslookup_agesDataSource()
    {
        $this->Initialize();
        $this->age_id = new clsField("age_id", ccsInteger, "");
        $this->age_desc = new clsField("age_desc", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-45F246B6
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_age_id" => array("age_id", ""), 
            "Sorter_age_desc" => array("age_desc", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-FF5E9500
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_ages";
        $this->SQL = "SELECT *  " .
        "FROM lookup_ages";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-6CB0AEF1
    function SetValues()
    {
        $this->age_id->SetDBValue($this->f("age_id"));
        $this->age_desc->SetDBValue($this->f("age_desc"));
    }
//End SetValues Method

} //End lookup_agesDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-31DC6462
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

$FileName = "AgesList.php";
$Redirect = "";
$TemplateFileName = "Themes/AgesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-26215D4D

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_ages = new clsGridlookup_ages();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_ages->Initialize();

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

//Show Page @1-36843302
$Header->Show("Header");
$lookup_ages->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
