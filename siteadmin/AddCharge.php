<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files

//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordcharges { //charges Class @4-23D0AC71

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

//Class_Initialize Event @4-AE13AF33
    function clsRecordcharges()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clschargesDataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "charges";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->user_id = new clsControl(ccsListBox, "user_id", "User Id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->user_id_ds = new clsDBDBNetConnect();
            $this->user_id_ds->SQL = "SELECT *  FROM users ORDER BY user_login ASC";
            $user_id_values = CCGetListValues($this->user_id_ds, $this->user_id_ds->SQL, $this->user_id_ds->Where, $this->user_id_ds->Order, "user_id", "user_login");
            $this->user_id->Values = $user_id_values;
            $this->charge = new clsControl(ccsTextBox, "charge", "charge", ccsFloat, "", CCGetRequestParam("charge", $Method));
            $this->cause = new clsControl(ccsTextArea, "cause", "Cause", ccsMemo, "", CCGetRequestParam("cause", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Cancel = new clsButton("Cancel");
            $this->date = new clsControl(ccsHidden, "date", "Date", ccsInteger, "", CCGetRequestParam("date", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-AF91F9DE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlcharge_id"] = CCGetFromGet("charge_id", "");
    }
//End Initialize Method

//Validate Method @4-3D164112
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->charge->Validate() && $Validation);
        //$Validation = ($this->cause->Validate() && $Validation);
        //$Validation = ($this->date->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-F0532B86
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
        $Redirect = "ChargesList.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));
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

//InsertRow Method @4-367B2C3B
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->charge->SetValue($this->charge->GetValue());
        $this->ds->cause->SetValue($this->cause->GetValue());
        $this->ds->date->SetValue(time());
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

//Show Method @4-81C208BC
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
                    echo "Error in Record charges";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->charge->SetValue($this->ds->charge->GetValue());
                        $this->cause->SetValue($this->ds->cause->GetValue());
                        $this->date->SetValue($this->ds->date->GetValue());
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
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->charge->Errors->ToString();
            $Error .= $this->cause->Errors->ToString();
            $Error .= $this->date->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->user_id->Show();
        $this->charge->Show();
        $this->cause->Show();
        $this->Insert->Show();
        $this->Cancel->Show();
        $this->date->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @4-FCB6E20C

class clschargesDataSource extends clsDBDBNetConnect {  //chargesDataSource Class @4-8045203E

//Variables @4-37B377FC
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $user_id;
    var $charge;
    var $cause;
    var $date;
//End Variables

//Class_Initialize Event @4-9A6BCB09
    function clschargesDataSource()
    {
        $this->Initialize();
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->charge = new clsField("charge", ccsFloat, "");
        $this->cause = new clsField("cause", ccsMemo, "");
        $this->date = new clsField("date", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @4-7FAE8833
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlcharge_id", ccsInteger, "", "", $this->Parameters["urlcharge_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "charge_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-09BFC025
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM charges";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-0721CA89
    function SetValues()
    {
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->cause->SetDBValue($this->f("cause"));
        $this->date->SetDBValue($this->f("date"));
    }
//End SetValues Method

//Insert Method @4-79594998
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO charges(" .
            "user_id, " .
            "charge, " .
            "cause, " .
            "date" .
        ") VALUES (" .
            $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            $this->ToSQL($this->charge->DBValue, $this->charge->DataType) . ", " .
            $this->ToSQL($this->cause->DBValue, $this->cause->DataType) . ", " .
            $this->ToSQL($this->date->DBValue, $this->date->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End chargesDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-1F7A8DF1
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

$FileName = "AddCharge.php";
$Redirect = "";
$TemplateFileName = "Themes/AddCharge.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-A8039FF0

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$charges = new clsRecordcharges();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$charges->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-6C5BA476
$Header->Operations();
$charges->Operation();
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

//Show Page @1-533D058C
$Header->Show("Header");
$charges->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
