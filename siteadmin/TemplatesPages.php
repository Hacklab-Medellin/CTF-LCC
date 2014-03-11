<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @9-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridtemplates_pages { //templates_pages class @2-CEC9F489

//Variables @2-9DA56C47

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

//Class_Initialize Event @2-45616644
    function clsGridtemplates_pages()
    {
        global $FileName;
        $this->ComponentName = "templates_pages";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clstemplates_pagesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->page_name = new clsControl(ccsLabel, "page_name", "page_name", ccsText, "", CCGetRequestParam("page_name", ccsGet));
        $this->templates_pages_Insert = new clsControl(ccsLink, "templates_pages_Insert", "templates_pages_Insert", ccsText, "", CCGetRequestParam("templates_pages_Insert", ccsGet));
        $this->templates_pages_Insert->Parameters = CCGetQueryString("QueryString", Array("page_id", "ccsForm"));
        $this->templates_pages_Insert->Page = "TemplatesPagesEdit.php";
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

//Show Method @2-B0CB9BF0
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "page_id", $this->ds->f("page_id"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "page_name", $this->ds->f("page_name"));
                $this->Detail->Page = "TemplatesPagesEdit.php";
                $this->page_name->SetValue($this->ds->page_name->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->page_name->Show();
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
        $this->templates_pages_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End templates_pages Class @2-FCB6E20C

class clstemplates_pagesDataSource extends clsDBDBNetConnect {  //templates_pagesDataSource Class @2-FA02A6A8

//Variables @2-71E2AAD1
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $page_name;
//End Variables

//Class_Initialize Event @2-DA05CEE6
    function clstemplates_pagesDataSource()
    {
        $this->Initialize();
        $this->page_name = new clsField("page_name", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-924DAD53
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM templates_pages";
        $this->SQL = "SELECT *  " .
        "FROM templates_pages";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-88B48187
    function SetValues()
    {
        $this->page_name->SetDBValue($this->f("page_name"));
    }
//End SetValues Method

} //End templates_pagesDataSource Class @2-FCB6E20C

//Include Page implementation @10-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-12AE125C
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

$FileName = "TemplatesPages.php";
$Redirect = "";
$TemplateFileName = "Themes/TemplatesPages.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-CD0A44E9

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$templates_pages = new clsGridtemplates_pages();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$templates_pages->Initialize();

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

//Show Page @1-5777846F
$Header->Show("Header");
$templates_pages->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
