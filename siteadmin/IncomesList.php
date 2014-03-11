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

class clsGridlookup_incomes { //lookup_incomes class @2-65BC66D1

//Variables @2-11EAC51C

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
    var $Sorter_income_id;
    var $Sorter_income_desc;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-6C048AB6
    function clsGridlookup_incomes()
    {
        global $FileName;
        $this->ComponentName = "lookup_incomes";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_incomesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_incomesOrder", "");
        $this->SorterDirection = CCGetParam("lookup_incomesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->income_id = new clsControl(ccsLabel, "income_id", "income_id", ccsInteger, "", CCGetRequestParam("income_id", ccsGet));
        $this->income_desc = new clsControl(ccsLabel, "income_desc", "income_desc", ccsText, "", CCGetRequestParam("income_desc", ccsGet));
        $this->Sorter_income_id = new clsSorter($this->ComponentName, "Sorter_income_id", $FileName);
        $this->Sorter_income_desc = new clsSorter($this->ComponentName, "Sorter_income_desc", $FileName);
        $this->lookup_incomes_Insert = new clsControl(ccsLink, "lookup_incomes_Insert", "lookup_incomes_Insert", ccsText, "", CCGetRequestParam("lookup_incomes_Insert", ccsGet));
        $this->lookup_incomes_Insert->Parameters = CCGetQueryString("QueryString", Array("income_id", "ccsForm"));
        $this->lookup_incomes_Insert->Page = "IncomesEdit.php";
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

//Show Method @2-D13A3DA0
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "income_id", $this->ds->f("income_id"));
                $this->Detail->Page = "IncomesEdit.php";
                $this->income_id->SetValue($this->ds->income_id->GetValue());
                $this->income_desc->SetValue($this->ds->income_desc->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->income_id->Show();
                $this->income_desc->Show();
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
        $this->Sorter_income_id->Show();
        $this->Sorter_income_desc->Show();
        $this->lookup_incomes_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_incomes Class @2-FCB6E20C

class clslookup_incomesDataSource extends clsDBDBNetConnect {  //lookup_incomesDataSource Class @2-8749B46E

//Variables @2-9399D822
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $income_id;
    var $income_desc;
//End Variables

//Class_Initialize Event @2-1FF9E0B6
    function clslookup_incomesDataSource()
    {
        $this->Initialize();
        $this->income_id = new clsField("income_id", ccsInteger, "");
        $this->income_desc = new clsField("income_desc", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-5F09E434
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_income_id" => array("income_id", ""), 
            "Sorter_income_desc" => array("income_desc", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-56850EF4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_incomes";
        $this->SQL = "SELECT *  " .
        "FROM lookup_incomes";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-DBA7F35A
    function SetValues()
    {
        $this->income_id->SetDBValue($this->f("income_id"));
        $this->income_desc->SetDBValue($this->f("income_desc"));
    }
//End SetValues Method

} //End lookup_incomesDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-E31B2F1A
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

$FileName = "IncomesList.php";
$Redirect = "";
$TemplateFileName = "Themes/IncomesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-526FE4C5

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_incomes = new clsGridlookup_incomes();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_incomes->Initialize();

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

//Show Page @1-69AB6937
$Header->Show("Header");
$lookup_incomes->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
