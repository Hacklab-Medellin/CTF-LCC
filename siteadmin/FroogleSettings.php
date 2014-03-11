<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @19-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordsettings_froogle { //settings_froogle Class @2-8AA33C3C

//Variables @2-052F1B76

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

    var $UpdateAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @2-9DFA6E52
    function clsRecordsettings_froogle()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssettings_froogleDataSource();
        $this->UpdateAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "settings_froogle";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ftp_url = new clsControl(ccsTextBox, "ftp_url", "ftp_url", ccsText, "", CCGetRequestParam("ftp_url", $Method));
            $this->ftpusername = new clsControl(ccsTextBox, "ftpusername", "ftpusername", ccsText, "", CCGetRequestParam("ftpusername", $Method));
            $this->ftppassword = new clsControl(ccsTextBox, "ftppassword", "ftppassword", ccsText, "", CCGetRequestParam("ftppassword", $Method));
            $this->frooglefile = new clsControl(ccsTextBox, "frooglefile", "frooglefile", ccsText, "", CCGetRequestParam("frooglefile", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
            $this->set_id = new clsControl(ccsHidden, "set_id", "set_id", ccsInteger, "", CCGetRequestParam("set_id", $Method));
            $this->set_id->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-90EC5D36
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlset_id"] = CCGetFromGet("set_id", "");
    }
//End Initialize Method

//Validate Method @2-B53FD624
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->ftp_url->Validate() && $Validation);
        $Validation = ($this->ftpusername->Validate() && $Validation);
        $Validation = ($this->ftppassword->Validate() && $Validation);
        $Validation = ($this->frooglefile->Validate() && $Validation);
        $Validation = ($this->set_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-8A36197A
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!$this->FormSubmitted)
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Cancel";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "FroogleSettings.php?" . CCGetQueryString("QueryString", Array("Update","Cancel","ccsForm"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "FroogleSettings.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//UpdateRow Method @2-98EE5E89
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->ftp_url->SetValue($this->ftp_url->GetValue());
        $this->ds->ftpusername->SetValue($this->ftpusername->GetValue());
        $this->ds->ftppassword->SetValue($this->ftppassword->GetValue());
        $this->ds->frooglefile->SetValue($this->frooglefile->GetValue());
        $this->ds->set_id->SetValue($this->set_id->GetValue());
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

//Show Method @2-F7075CB8
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
                    echo "Error in Record settings_froogle";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->ftp_url->SetValue($this->ds->ftp_url->GetValue());
                        $this->ftpusername->SetValue($this->ds->ftpusername->GetValue());
                        $this->ftppassword->SetValue($this->ds->ftppassword->GetValue());
                        $this->frooglefile->SetValue($this->ds->frooglefile->GetValue());
                        $this->set_id->SetValue($this->ds->set_id->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        if(!$this->FormSubmitted)
        {
        }

        if($this->FormSubmitted) {
            $Error .= $this->ftp_url->Errors->ToString();
            $Error .= $this->ftpusername->Errors->ToString();
            $Error .= $this->ftppassword->Errors->ToString();
            $Error .= $this->frooglefile->Errors->ToString();
            $Error .= $this->set_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->ftp_url->Show();
        $this->ftpusername->Show();
        $this->ftppassword->Show();
        $this->frooglefile->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $this->set_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End settings_froogle Class @2-FCB6E20C

class clssettings_froogleDataSource extends clsDBDBNetConnect {  //settings_froogleDataSource Class @2-FC1AE975

//DataSource Variables @2-B2C50C61
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $ftp_url;
    var $ftpusername;
    var $ftppassword;
    var $frooglefile;
    var $set_id;
//End DataSource Variables

//Class_Initialize Event @2-E22AFF89
    function clssettings_froogleDataSource()
    {
        $this->Initialize();
        $this->ftp_url = new clsField("ftp_url", ccsText, "");
        $this->ftpusername = new clsField("ftpusername", ccsText, "");
        $this->ftppassword = new clsField("ftppassword", ccsText, "");
        $this->frooglefile = new clsField("frooglefile", ccsText, "");
        $this->set_id = new clsField("set_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-D221C61F
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlset_id", ccsInteger, "", "", $this->Parameters["urlset_id"], 1);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`set_id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-194CA9E3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM settings_froogle";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-AFB2C4CC
    function SetValues()
    {
        $this->ftp_url->SetDBValue($this->f("ftp_url"));
        $this->ftpusername->SetDBValue($this->f("ftpusername"));
        $this->ftppassword->SetDBValue($this->f("ftppassword"));
        $this->frooglefile->SetDBValue($this->f("frooglefile"));
        $this->set_id->SetDBValue($this->f("set_id"));
    }
//End SetValues Method

//Update Method @2-27849922
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `settings_froogle` SET "
             . "`ftp_url`=" . $this->ToSQL($this->ftp_url->GetDBValue(), $this->ftp_url->DataType) . ", "
             . "`ftpusername`=" . $this->ToSQL($this->ftpusername->GetDBValue(), $this->ftpusername->DataType) . ", "
             . "`ftppassword`=" . $this->ToSQL($this->ftppassword->GetDBValue(), $this->ftppassword->DataType) . ", "
             . "`frooglefile`=" . $this->ToSQL($this->frooglefile->GetDBValue(), $this->frooglefile->DataType) . ", "
             . "`set_id`=" . $this->ToSQL($this->set_id->GetDBValue(), $this->set_id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End settings_froogleDataSource Class @2-FCB6E20C

//Include Page implementation @20-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-DC96FBA6
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

$FileName = "FroogleSettings.php";
$Redirect = "";
$TemplateFileName = "Themes/FroogleSettings.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-2BF8985F
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$settings_froogle = new clsRecordsettings_froogle();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$settings_froogle->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-2EE3B7BF
$Header->Operations();
$settings_froogle->Operation();
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

//Show Page @1-E893ACB4
$Header->Show("Header");
$settings_froogle->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page



?>
