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

class clsGridsent_newsletters { //sent_newsletters class @2-AEDC019C

//Variables @2-5B583A42

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
    var $Sorter_newsletter_id;
    var $Sorter_datesent;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-716D9BE9
    function clsGridsent_newsletters()
    {
        global $FileName;
        $this->ComponentName = "sent_newsletters";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clssent_newslettersDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("sent_newslettersOrder", "");
        $this->SorterDirection = CCGetParam("sent_newslettersDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->newsletter_id = new clsControl(ccsLabel, "newsletter_id", "newsletter_id", ccsInteger, "", CCGetRequestParam("newsletter_id", ccsGet));
        $this->datesent = new clsControl(ccsLabel, "datesent", "datesent", ccsInteger, "", CCGetRequestParam("datesent", ccsGet));
        $this->Sorter_newsletter_id = new clsSorter($this->ComponentName, "Sorter_newsletter_id", $FileName);
        $this->Sorter_datesent = new clsSorter($this->ComponentName, "Sorter_datesent", $FileName);
        $this->sent_newsletters_Insert = new clsControl(ccsLink, "sent_newsletters_Insert", "sent_newsletters_Insert", ccsText, "", CCGetRequestParam("sent_newsletters_Insert", ccsGet));
        $this->sent_newsletters_Insert->Parameters = CCGetQueryString("QueryString", Array("newsletter_id", "ccsForm"));
        $this->sent_newsletters_Insert->Page = "NewslettersMaintanence.php";
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

//Show Method @2-AE652A64
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "newsletter_id", $this->ds->f("newsletter_id"));
                $this->Detail->Page = "NewslettersMaintanence.php";
                $this->newsletter_id->SetValue($this->ds->newsletter_id->GetValue());
                $this->datesent->SetValue($this->ds->datesent->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->newsletter_id->Show();
                $this->datesent->Show();
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
        $this->Sorter_newsletter_id->Show();
        $this->Sorter_datesent->Show();
        $this->sent_newsletters_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End sent_newsletters Class @2-FCB6E20C

class clssent_newslettersDataSource extends clsDBDBNetConnect {  //sent_newslettersDataSource Class @2-F713C5A9

//Variables @2-7CAAA4CD
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $newsletter_id;
    var $datesent;
//End Variables

//Class_Initialize Event @2-C4B9ACBD
    function clssent_newslettersDataSource()
    {
        $this->Initialize();
        $this->newsletter_id = new clsField("newsletter_id", ccsInteger, "");
        $this->datesent = new clsField("datesent", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-BAC8D1D3
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_newsletter_id" => array("undefined", ""), 
            "Sorter_datesent" => array("undefined", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-4BFCCC5C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM sent_newsletters";
        $this->SQL = "SELECT *  " .
        "FROM sent_newsletters";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-CD2E936E
    function SetValues()
    {
        $this->newsletter_id->SetDBValue($this->f("newsletter_id"));
        $this->datesent->SetDBValue($this->f("datesent"));
    }
//End SetValues Method

} //End sent_newslettersDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-A6A5B662
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

$FileName = "Newsletters.php";
$Redirect = "";
$TemplateFileName = "Themes/Newsletters.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-C9B77883

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$sent_newsletters = new clsGridsent_newsletters();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$sent_newsletters->Initialize();

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

//Show Page @1-2F1986F5
$Header->Show("Header");
$sent_newsletters->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
