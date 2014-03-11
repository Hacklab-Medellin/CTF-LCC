<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @12-DC989187
include(RelativePath . "/Header.php");
//End Include Page implementation

class clsGridlookup_states { //lookup_states class @2-83BE6ADB

//Variables @2-6913345A

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
    var $Sorter_state_id;
    var $Sorter_state_desc;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-78858447
    function clsGridlookup_states()
    {
        global $FileName;
        $this->ComponentName = "lookup_states";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_statesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_statesOrder", "");
        $this->SorterDirection = CCGetParam("lookup_statesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->state_id = new clsControl(ccsLabel, "state_id", "state_id", ccsText, "", CCGetRequestParam("state_id", ccsGet));
        $this->state_desc = new clsControl(ccsLabel, "state_desc", "state_desc", ccsText, "", CCGetRequestParam("state_desc", ccsGet));
        $this->Sorter_state_id = new clsSorter($this->ComponentName, "Sorter_state_id", $FileName);
        $this->Sorter_state_desc = new clsSorter($this->ComponentName, "Sorter_state_desc", $FileName);
        $this->lookup_states_Insert = new clsControl(ccsLink, "lookup_states_Insert", "lookup_states_Insert", ccsText, "", CCGetRequestParam("lookup_states_Insert", ccsGet));
        $this->lookup_states_Insert->Parameters = CCGetQueryString("QueryString", Array("state_id", "ccsForm"));
        $this->lookup_states_Insert->Page = "StatesEdit.php";
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

//Show Method @2-69D298F2
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "state_id", $this->ds->f("state_id"));
                $this->Detail->Page = "StatesEdit.php";
                $this->state_id->SetValue($this->ds->state_id->GetValue());
                $this->state_desc->SetValue($this->ds->state_desc->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->state_id->Show();
                $this->state_desc->Show();
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
        $this->Sorter_state_id->Show();
        $this->Sorter_state_desc->Show();
        $this->lookup_states_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_states Class @2-FCB6E20C

class clslookup_statesDataSource extends clsDBDBNetConnect {  //lookup_statesDataSource Class @2-1615DF81

//Variables @2-1F96D4B9
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $state_id;
    var $state_desc;
//End Variables

//Class_Initialize Event @2-08230DA9
    function clslookup_statesDataSource()
    {
        $this->Initialize();
        $this->state_id = new clsField("state_id", ccsText, "");
        $this->state_desc = new clsField("state_desc", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-8CE34CC6
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_state_id" => array("state_id", ""), 
            "Sorter_state_desc" => array("state_desc", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-C97E5499
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_states";
        $this->SQL = "SELECT *  " .
        "FROM lookup_states";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-BFD66B79
    function SetValues()
    {
        $this->state_id->SetDBValue($this->f("state_id"));
        $this->state_desc->SetDBValue($this->f("state_desc"));
    }
//End SetValues Method

} //End lookup_statesDataSource Class @2-FCB6E20C

//Include Page implementation @13-B991DFB8
include(RelativePath . "/Footer.php");
//End Include Page implementation

//Initialize Page @1-F3EC8A8B
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

$FileName = "StatesList.php";
$Redirect = "";
$TemplateFileName = "Themes/StatesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-34B34F19
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_states = new clsGridlookup_states();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_states->Initialize();

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

//Show Page @1-C5E0B6BC
$Header->Show("Header");
$lookup_states->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
