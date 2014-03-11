<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Viewing Page -" . CCGetFromGet("name", "");
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

Class clsRecordtemplates_pages { //templates_pages Class @4-887A63F0

//Variables @4-90DA4C9A

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

//Class_Initialize Event @4-F2B8795E
    function clsRecordtemplates_pages()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clstemplates_pagesDataSource();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "templates_pages";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->page_name = new clsControl(ccsLabel, "page_name", "Page Name", ccsText, "", CCGetRequestParam("page_name", $Method));
            $this->page_html = new clsControl(ccsLabel, "page_html", "Page Html", ccsMemo, "", CCGetRequestParam("page_html", $Method));
            $this->page_html->HTML = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @4-28AE6285
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlpage_name"] = CCGetFromGet("name", "");
    }
//End Initialize Method

//Validate Method @4-0B21E9EA
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->page_name->Validate() && $Validation);
        $Validation = ($this->page_html->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-F2FCC5AC
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        $Redirect = "page.php?" . CCGetQueryString("QueryString", Array("ccsForm"));
    }
//End Operation Method

//Show Method @4-3B11EBC4
    function Show()
    {
        global $Tpl;
        global $FileName;
                global $PP;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {

            if($this->Errors->Count() == 0)
            {

                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record templates_pages";
                }
                else if($this->ds->next_record())
                {

                    $this->ds->SetValues();
                    $this->page_name->SetValue($this->ds->page_name->GetValue());
      		    $temppag = "process76PULL*PULL76" . $this->ds->page_html->GetValue();
      
                    $finalpage = ReplacePA($temppag, $PP);
                    $this->page_html->SetValue($finalpage);
                    if(!$this->FormSubmitted)
                    {


                    }
                }
                else
                {
                    $this->EditMode = false;
                    $this->ds->SetValues();
                    $this->page_name->SetValue($this->ds->page_name->GetValue());
                    $temppag = "process76PULL*PULL76" . $this->ds->page_html->GetValue();
                    $finalpage = ReplacePA($temppag, $PP);
                    $this->page_html->SetValue($finalpage);


                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->page_name->Errors->ToString();
            $Error .= $this->page_html->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->page_name->Show();
        $this->page_html->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End templates_pages Class @4-FCB6E20C

class clstemplates_pagesDataSource extends clsDBNetConnect {  //templates_pagesDataSource Class @4-248D0059

//Variables @4-4B1574C7
    var $CCSEvents = "";
    var $CCSEventResult;

    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $page_name;
    var $page_html;
//End Variables

//Class_Initialize Event @4-885B46A0
    function clstemplates_pagesDataSource()
    {
        $this->Initialize();
        $this->page_name = new clsField("page_name", ccsText, "");
        $this->page_html = new clsField("page_html", ccsMemo, "");

    }
//End Class_Initialize Event

//Prepare Method @4-8DFCF594
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlpage_name", ccsText, "", "", $this->Parameters["urlpage_name"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "page_name", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;

    }
//End Prepare Method

//Open Method @4-0DB494E0
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM templates_pages";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-7D56D7AA
    function SetValues()
    {
        $this->page_name->SetDBValue($this->f("page_name"));
        $this->page_html->SetDBValue($this->f("page_html"));
	
    }
//End SetValues Method

} //End templates_pagesDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-ED65ABDA
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

$FileName = "page.php";
$Redirect = "";
$TemplateFileName = "templates/page.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-F96478DA

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$templates_pages = new clsRecordtemplates_pages();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$templates_pages->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-70CF24DE
$Header->Operations();
$templates_pages->Operation();
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