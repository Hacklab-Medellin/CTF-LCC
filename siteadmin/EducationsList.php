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

class clsGridlookup_educations { //lookup_educations class @2-6CBA0946

//Variables @2-87A5A715

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
    var $Sorter_education_id;
    var $Sorter_education_desc;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-79D70890
    function clsGridlookup_educations()
    {
        global $FileName;
        $this->ComponentName = "lookup_educations";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_educationsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_educationsOrder", "");
        $this->SorterDirection = CCGetParam("lookup_educationsDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->education_id = new clsControl(ccsLabel, "education_id", "education_id", ccsInteger, "", CCGetRequestParam("education_id", ccsGet));
        $this->education_desc = new clsControl(ccsLabel, "education_desc", "education_desc", ccsText, "", CCGetRequestParam("education_desc", ccsGet));
        $this->Sorter_education_id = new clsSorter($this->ComponentName, "Sorter_education_id", $FileName);
        $this->Sorter_education_desc = new clsSorter($this->ComponentName, "Sorter_education_desc", $FileName);
        $this->lookup_educations_Insert = new clsControl(ccsLink, "lookup_educations_Insert", "lookup_educations_Insert", ccsText, "", CCGetRequestParam("lookup_educations_Insert", ccsGet));
        $this->lookup_educations_Insert->Parameters = CCGetQueryString("QueryString", Array("education_id", "ccsForm"));
        $this->lookup_educations_Insert->Page = "EducationsEdit.php";
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

//Show Method @2-F294B4C8
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;


        $ShownRecords = 0;

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
                $this->Detail->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "education_id", $this->ds->f("education_id"));
                $this->Detail->Page = "EducationsEdit.php";
                $this->education_id->SetValue($this->ds->education_id->GetValue());
                $this->education_desc->SetValue($this->ds->education_desc->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->education_id->Show();
                $this->education_desc->Show();
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
        $this->Sorter_education_id->Show();
        $this->Sorter_education_desc->Show();
        $this->lookup_educations_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_educations Class @2-FCB6E20C

class clslookup_educationsDataSource extends clsDBDBNetConnect {  //lookup_educationsDataSource Class @2-DED931C7

//DataSource Variables @2-64743208
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $education_id;
    var $education_desc;
//End DataSource Variables

//Class_Initialize Event @2-DB419168
    function clslookup_educationsDataSource()
    {
        $this->Initialize();
        $this->education_id = new clsField("education_id", ccsInteger, "");
        $this->education_desc = new clsField("education_desc", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-008F663B
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_education_id" => array("education_id", ""), 
            "Sorter_education_desc" => array("education_desc", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-D10B4E4A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_educations";
        $this->SQL = "SELECT *  " .
        "FROM lookup_educations";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-449E096B
    function SetValues()
    {
        $this->education_id->SetDBValue($this->f("education_id"));
        $this->education_desc->SetDBValue($this->f("education_desc"));
    }
//End SetValues Method

} //End lookup_educationsDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-B52F4E66
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

$FileName = "EducationsList.php";
$Redirect = "";
$TemplateFileName = "Themes/EducationsList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-4789BEF7
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_educations = new clsGridlookup_educations();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_educations->Initialize();

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

//Show Page @1-89181458
$Header->Show("Header");
$lookup_educations->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


//DEL      function SetOrder($SorterName, $SorterDirection)
//DEL      {
//DEL          $this->Order = "";
//DEL          $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
//DEL              array("Sorter_education_id" => array("education_id", ""), 
//DEL              "Sorter_education_desc" => array("education_desc", "")));
//DEL      }



?>
