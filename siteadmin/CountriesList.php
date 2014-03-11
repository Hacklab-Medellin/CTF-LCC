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

class clsGridlookup_countries { //lookup_countries class @2-7D115323

//Variables @2-08275FED

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
    var $Sorter_country_id;
    var $Sorter_country_desc;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-73229150
    function clsGridlookup_countries()
    {
        global $FileName;
        $this->ComponentName = "lookup_countries";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_countriesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_countriesOrder", "");
        $this->SorterDirection = CCGetParam("lookup_countriesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->country_id = new clsControl(ccsLabel, "country_id", "country_id", ccsInteger, "", CCGetRequestParam("country_id", ccsGet));
        $this->country_desc = new clsControl(ccsLabel, "country_desc", "country_desc", ccsText, "", CCGetRequestParam("country_desc", ccsGet));
        $this->Sorter_country_id = new clsSorter($this->ComponentName, "Sorter_country_id", $FileName);
        $this->Sorter_country_desc = new clsSorter($this->ComponentName, "Sorter_country_desc", $FileName);
        $this->lookup_countries_Insert = new clsControl(ccsLink, "lookup_countries_Insert", "lookup_countries_Insert", ccsText, "", CCGetRequestParam("lookup_countries_Insert", ccsGet));
        $this->lookup_countries_Insert->Parameters = CCGetQueryString("QueryString", Array("country_id", "ccsForm"));
        $this->lookup_countries_Insert->Page = "CountriesEdit.php";
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

//Show Method @2-C231A4C9
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "country_id", $this->ds->f("country_id"));
                $this->Detail->Page = "CountriesEdit.php";
                $this->country_id->SetValue($this->ds->country_id->GetValue());
                $this->country_desc->SetValue($this->ds->country_desc->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->country_id->Show();
                $this->country_desc->Show();
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
        $this->Sorter_country_id->Show();
        $this->Sorter_country_desc->Show();
        $this->lookup_countries_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_countries Class @2-FCB6E20C

class clslookup_countriesDataSource extends clsDBDBNetConnect {  //lookup_countriesDataSource Class @2-1A902665

//Variables @2-1CE48B4C
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $country_id;
    var $country_desc;
//End Variables

//Class_Initialize Event @2-46819AC2
    function clslookup_countriesDataSource()
    {
        $this->Initialize();
        $this->country_id = new clsField("country_id", ccsInteger, "");
        $this->country_desc = new clsField("country_desc", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-53003717
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_country_id" => array("country_id", ""), 
            "Sorter_country_desc" => array("country_desc", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-D18598C5
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_countries";
        $this->SQL = "SELECT *  " .
        "FROM lookup_countries";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-67561D01
    function SetValues()
    {
        $this->country_id->SetDBValue($this->f("country_id"));
        $this->country_desc->SetDBValue($this->f("country_desc"));
    }
//End SetValues Method

} //End lookup_countriesDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-BD3E0637
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

$FileName = "CountriesList.php";
$Redirect = "";
$TemplateFileName = "Themes/CountriesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-D7123FF8

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_countries = new clsGridlookup_countries();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_countries->Initialize();

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

//Show Page @1-A1828728
$Header->Show("Header");
$lookup_countries->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
