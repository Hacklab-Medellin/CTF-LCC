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

Class clsRecordtemplates_emails { //templates_emails Class @2-F0F19809

//Variables @2-90DA4C9A

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

//Class_Initialize Event @2-A19460EE
    function clsRecordtemplates_emails()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clstemplates_emailsDataSource();
        $this->InsertAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "templates_emails";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->template_name = new clsControl(ccsLabel, "template_name", "template_name", ccsText, "", CCGetRequestParam("template_name", $Method));
            $this->email_subject = new clsControl(ccsTextBox, "email_subject", "email_subject", ccsText, "", CCGetRequestParam("email_subject", $Method));
            $this->email_text = new clsControl(ccsTextArea, "email_text", "email_text", ccsMemo, "", CCGetRequestParam("email_text", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
            $this->temp_id = new clsControl(ccsHidden, "temp_id", "temp_id", ccsInteger, "", CCGetRequestParam("temp_id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-7800B270
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urltemp_id"] = CCGetFromGet("temp_id", "");
    }
//End Initialize Method

//Validate Method @2-F3730AD2
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->template_name->Validate() && $Validation);
        $Validation = ($this->email_subject->Validate() && $Validation);
        $Validation = ($this->email_text->Validate() && $Validation);
        $Validation = ($this->temp_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-E9359718
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Cancel";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "TemplatesEmails.php?" . CCGetQueryString("QueryString", Array("Update","Cancel","ccsForm"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "TemplatesEmails.php?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//UpdateRow Method @2-A6ABFEC7
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->template_name->SetValue($this->template_name->GetValue());
        $this->ds->email_subject->SetValue($this->email_subject->GetValue());
        $this->ds->email_text->SetValue($this->email_text->GetValue());
        $this->ds->temp_id->SetValue($this->temp_id->GetValue());
        $this->ds->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Update Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End UpdateRow Method

//Show Method @2-1E1C6F66
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
                    echo "Error in Record templates_emails";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->template_name->SetValue($this->ds->template_name->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->email_subject->SetValue($this->ds->email_subject->GetValue());
                        $this->email_text->SetValue($this->ds->email_text->GetValue());
                        $this->temp_id->SetValue($this->ds->temp_id->GetValue());
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
            $Error .= $this->template_name->Errors->ToString();
            $Error .= $this->email_subject->Errors->ToString();
            $Error .= $this->email_text->Errors->ToString();
            $Error .= $this->temp_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->template_name->Show();
        $this->email_subject->Show();
        $this->email_text->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $this->temp_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End templates_emails Class @2-FCB6E20C

class clstemplates_emailsDataSource extends clsDBDBNetConnect {  //templates_emailsDataSource Class @2-33687083

//Variables @2-C7688605
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $template_name;
    var $email_subject;
    var $email_text;
    var $temp_id;
//End Variables

//Class_Initialize Event @2-4D7E2F74
    function clstemplates_emailsDataSource()
    {
        $this->Initialize();
        $this->template_name = new clsField("template_name", ccsText, "");
        $this->email_subject = new clsField("email_subject", ccsText, "");
        $this->email_text = new clsField("email_text", ccsMemo, "");
        $this->temp_id = new clsField("temp_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-D10780B3
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urltemp_id", ccsInteger, "", "", $this->Parameters["urltemp_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "temp_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @2-3134C070
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM templates_emails";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-4B8A4713
    function SetValues()
    {
        $this->template_name->SetDBValue($this->f("template_name"));
        $this->email_subject->SetDBValue($this->f("email_subject"));
        $this->email_text->SetDBValue($this->f("email_text"));
        $this->temp_id->SetDBValue($this->f("temp_id"));
    }
//End SetValues Method

//Update Method @2-CDB4AAE4
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE templates_emails SET " .
            "email_subject=" . $this->ToSQL($this->email_subject->DBValue, $this->email_subject->DataType) . ", " . 
            "email_text=" . $this->ToSQL($this->email_text->DBValue, $this->email_text->DataType) . ", " . 
            "temp_id=" . $this->ToSQL($this->temp_id->DBValue, $this->temp_id->DataType) . 
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End templates_emailsDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-DB623F12
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

$FileName = "TemplatesEmailsEdit.php";
$Redirect = "";
$TemplateFileName = "Themes/TemplatesEmailsEdit.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-11DE84C9

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$templates_emails = new clsRecordtemplates_emails();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$templates_emails->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-7AF2920F
$Header->Operations();
$templates_emails->Operation();
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

//Show Page @1-AE7EEA61
$Header->Show("Header");
$templates_emails->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
