<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Viewing Circled Items";
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
include("./Headeru.php");
//End Include Page implementation

Class clsRecordwatchlist { //watchlist Class @4-9EFC8B06

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

//Class_Initialize Event @4-33D2964B
    function clsRecordwatchlist()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clswatchlistDataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "watchlist";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ItemTitle = new clsControl(ccsTextBox, "ItemTitle", "Item Title", ccsText, "", CCGetRequestParam("ItemTitle", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Cancel = new clsButton("Cancel");
            $this->itemID = new clsControl(ccsHidden, "itemID", "Item ID", ccsText, "", CCGetRequestParam("itemID", $Method));
            $this->user_id = new clsControl(ccsHidden, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-0C596816
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlwatch_id"] = CCGetFromGet("watch_id", "");
    }
//End Initialize Method

//Validate Method @4-00C85EEC
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->ItemTitle->Validate() && $Validation);
        $Validation = ($this->itemID->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-162BAF5C
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = "Insert";
            if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "ViewItem.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @4-381BB824
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->ItemTitle->SetValue($this->ItemTitle->GetValue());
        $this->ds->itemID->SetValue($this->itemID->GetValue());
        $this->ds->user_id->SetValue(CCGetUserID());
        $this->ds->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Insert Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End InsertRow Method

//Show Method @4-C32D259D
    function Show()
    {
        global $Tpl;
        global $FileName;
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
                    echo "Error in Record watchlist";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $lookupdb = new clsDBNetConnect;
                                                $lookupdb->connect();
                                                if(CCGetFromGet("ItemNum", "")){
                                                        $newtitle = CCDLookUp("title","items","ItemNum='" . CCGetFromGet("ItemNum", "") . "'",$lookupdb);
                                                }
                                                $this->ItemTitle->SetValue($newtitle);
                        $this->itemID->SetValue(CCGetFromGet("ItemNum", ""));
                        $this->user_id->SetValue(CCGetUserID());
                                                unset($lookupdb);
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->ItemTitle->Errors->ToString();
            $Error .= $this->itemID->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $lookupdb = new clsDBNetConnect;
                $lookupdb->connect();
                if(CCGetFromGet("ItemNum", "")){
                        $newtitle = CCDLookUp("title","items","ItemNum='" . CCGetFromGet("ItemNum", "") . "'",$lookupdb);
                }
                $this->ItemTitle->SetValue($newtitle);
        $this->itemID->SetValue(CCGetFromGet("ItemNum", ""));
        $this->user_id->SetValue(CCGetUserID());
                unset($lookupdb);
                $this->ItemTitle->Show();
        $this->Insert->Show();
        $this->Cancel->Show();
        $this->itemID->Show();
        $this->user_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End watchlist Class @4-FCB6E20C

class clswatchlistDataSource extends clsDBNetConnect {  //watchlistDataSource Class @4-FEADDC50

//Variables @4-18BD08BC
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $ItemTitle;
    var $itemID;
    var $user_id;
//End Variables

//Class_Initialize Event @4-86D27B73
    function clswatchlistDataSource()
    {
        $this->Initialize();
        $this->ItemTitle = new clsField("ItemTitle", ccsText, "");
        $this->itemID = new clsField("itemID", ccsText, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @4-BF0DB611
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlwatch_id", ccsInteger, "", "", $this->Parameters["urlwatch_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "watch_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-A43DCDCA
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM watchlist";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-60B533F9
    function SetValues()
    {
        $this->ItemTitle->SetDBValue($this->f("ItemTitle"));
        $this->itemID->SetDBValue($this->f("itemID"));
        $this->user_id->SetDBValue($this->f("user_id"));
    }
//End SetValues Method

//Insert Method @4-BD49619D
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO watchlist(" .
            "ItemTitle, " .
            "itemID, " .
            "user_id" .
        ") VALUES (" .
            $this->ToSQL($this->ItemTitle->DBValue, $this->ItemTitle->DataType) . ", " .
            $this->ToSQL($this->itemID->DBValue, $this->itemID->DataType) . ", " .
            $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End watchlistDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-999C9550
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

$FileName = "circleditems.php";
$Redirect = "";
$TemplateFileName = "templates/circleditems.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-CC40F54E

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$watchlist = new clsRecordwatchlist();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$watchlist->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-D0328A92
$Header->Operations();
$watchlist->Operation();
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

//Show Page @1-A9EAC172
$Header->Show("Header");
$watchlist->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>