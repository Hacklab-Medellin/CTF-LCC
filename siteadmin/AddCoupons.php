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

Class clsRecordcoupons { //coupons Class @4-23D0AC71

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
    function clsRecordcoupons()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clscouponsDataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "coupons";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->id = new clsControl(ccsListBox, "id", "User Id", ccsInteger, "", CCGetRequestParam("id", $Method));
            $this->discount = new clsControl(ccsTextBox, "discount", "discount", ccsFloat, "", CCGetRequestParam("discount", $Method));
            $this->code = new clsControl(ccsTextBox, "code", "code", ccsText, "", CCGetRequestParam("code", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Cancel = new clsButton("Cancel");
            $this->start = new clsControl(ccsTextBox, "start", "Start", ccsText, "", CCGetRequestParam("start", $Method));
            $this->end = new clsControl(ccsTextBox, "end", "End", ccsText, "", CCGetRequestParam("end", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-AF91F9DE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlid"] = CCGetFromGet("id", "");
    }
//End Initialize Method

//Validate Method @4-3D164112
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //$Validation = ($this->id->Validate() && $Validation);
        //$Validation = ($this->discount->Validate() && $Validation);
        //$Validation = ($this->code->Validate() && $Validation);
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
        $Redirect = "CouponsList.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));
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
        $this->ds->id->SetValue($this->id->GetValue());
        $this->ds->discount->SetValue($this->discount->GetValue());
        $this->ds->code->SetValue($this->code->GetValue());
        $this->ds->start->SetValue($this->start->GetValue());
        $this->ds->end->SetValue($this->end->GetValue());
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
                    echo "Error in Record coupons";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->id->SetValue($this->ds->id->GetValue());
                        $this->discount->SetValue($this->ds->discount->GetValue());
                        $this->code->SetValue($this->ds->code->GetValue());
                        $this->start->SetValue($this->ds->start->GetValue());
                        $this->end->SetValue($this->ds->end->GetValue());
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
            $Error .= $this->id->Errors->ToString();
            $Error .= $this->discount->Errors->ToString();
            $Error .= $this->code->Errors->ToString();
            $Error .= $this->start->Errors->ToString();
            $Error .= $this->end->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->id->Show();
        $this->discount->Show();
        $this->code->Show();
        $this->Insert->Show();
        $this->Cancel->Show();
        $this->start->Show();
        $this->end->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End coupons Class @4-FCB6E20C

class clscouponsDataSource extends clsDBDBNetConnect {  //couponsDataSource Class @4-8045203E

//Variables @4-37B377FC
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $id;
    var $discount;
    var $code;
    var $start;
    var $end;
//End Variables

//Class_Initialize Event @4-9A6BCB09
    function clscouponsDataSource()
    {
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        $this->discount = new clsField("discount", ccsFloat, "");
        $this->code = new clsField("code", ccsText, "");
        $this->start = new clsField("start", ccsText, "");
        $this->end = new clsField("end", ccsText, "");

    }
//End Class_Initialize Event

//Prepare Method @4-7FAE8833
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-09BFC025
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM coupons";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-0721CA89
    function SetValues()
    {
        $this->id->SetDBValue($this->f("id"));
        $this->discount->SetDBValue(($this->f("discount")*100));
        $this->code->SetDBValue($this->f("code"));
        $this->start->SetDBValue(date("m/d/Y", $this->f("start")));
        $this->end->SetDBValue(date("m/d/Y", $this->f("end")));
    }
//End SetValues Method

//Insert Method @4-79594998
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO coupons(" .
            "`id`, " .
            "`discount`, " .
            "`code`, " .
            "`start`, " .
            "`end`" .
        ") VALUES (" .
            $this->ToSQL($this->id->DBValue, $this->id->DataType) . ", " .
            $this->ToSQL(($this->discount->DBValue/100), $this->discount->DataType) . ", " .
            $this->ToSQL($this->code->DBValue, $this->code->DataType) . ", " .
            $this->ToSQL(strtotime($this->start->DBValue), $this->start->DataType) . ", " .
            $this->ToSQL(strtotime($this->end->DBValue), $this->end->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End couponsDataSource Class @4-FCB6E20C

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

$FileName = "AddCoupons.php";
$Redirect = "";
$TemplateFileName = "Themes/AddCoupons.html";
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
$coupons = new clsRecordcoupons();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$coupons->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-6C5BA476
$Header->Operations();
$coupons->Operation();
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
$coupons->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
