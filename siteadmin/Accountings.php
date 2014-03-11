<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @13-DC989187
include(RelativePath . "/Header.php");
//End Include Page implementation

Class clsRecordsettings_accounting { //settings_accounting Class @2-5A6B73A8

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

//Class_Initialize Event @2-054700C5
    function clsRecordsettings_accounting()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssettings_accountingDataSource();
        $this->InsertAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "settings_accounting";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->paypal_on = new clsControl(ccsListBox, "paypal_on", "paypal_on", ccsInteger, "", CCGetRequestParam("paypal_on", $Method));
            $paypal_on_values = array(array("0", "OFF"), array("1", "ON"));
            $this->paypal_on->Values = $paypal_on_values;
            $this->paypal = new clsControl(ccsTextBox, "paypal", "paypal", ccsText, "", CCGetRequestParam("paypal", $Method));
            $this->authorizenet_on = new clsControl(ccsListBox, "authorizenet_on", "authorizenet_on", ccsInteger, "", CCGetRequestParam("authorizenet_on", $Method));
            $authorizenet_on_values = array(array("0", "OFF"), array("1", "AuthorizeNet"), array("2", "PlanetPayment"), array("3", "QuickCommerce"));
            $this->authorizenet_on->Values = $authorizenet_on_values;
            $this->authorizenet = new clsControl(ccsTextBox, "authorizenet", "authorizenet", ccsText, "", CCGetRequestParam("authorizenet", $Method));
            $this->authorize_tran_key = new clsControl(ccsTextBox, "authorize_tran_key", "authorize_tran_key", ccsText, "", CCGetRequestParam("authorize_tran_key", $Method));
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
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

//Validate Method @2-655D9467
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->paypal_on->Validate() && $Validation);
        $Validation = ($this->paypal->Validate() && $Validation);
        $Validation = ($this->authorizenet_on->Validate() && $Validation);
        $Validation = ($this->authorize_tran_key->Validate() && $Validation);
        $Validation = ($this->authorizenet->Validate() && $Validation);
        $Validation = ($this->set_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-A47445FF
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Delete";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Delete", ""))) {
                $this->PressedButton = "Delete";
            }
        }
        $Redirect = "index.php?" . CCGetQueryString("QueryString", Array("Update","Delete","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "index.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//UpdateRow Method @2-CBF05704
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->paypal_on->SetValue($this->paypal_on->GetValue());
        $this->ds->paypal->SetValue($this->paypal->GetValue());
        $this->ds->authorizenet_on->SetValue($this->authorizenet_on->GetValue());
        $this->ds->authorizenet->SetValue($this->authorizenet->GetValue());
        $this->ds->authorize_tran_key->SetValue($this->authorize_tran_key->GetValue());
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

//Show Method @2-99D208C1
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
                    echo "Error in Record settings_accounting";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->paypal_on->SetValue($this->ds->paypal_on->GetValue());
                        $this->paypal->SetValue($this->ds->paypal->GetValue());
                        $this->authorizenet_on->SetValue($this->ds->authorizenet_on->GetValue());
                        $this->authorizenet->SetValue($this->ds->authorizenet->GetValue());
                        $this->authorize_tran_key->SetValue($this->ds->authorize_tran_key->GetValue());
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
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->paypal_on->Errors->ToString();
            $Error .= $this->paypal->Errors->ToString();
            $Error .= $this->authorizenet_on->Errors->ToString();
            $Error .= $this->authorizenet->Errors->ToString();
            $Error .= $this->authorize_tran_key->Errors->ToString();
            $Error .= $this->set_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->paypal_on->Show();
        $this->paypal->Show();
        $this->authorizenet_on->Show();
        $this->authorizenet->Show();
        $this->authorize_tran_key->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->set_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End settings_accounting Class @2-FCB6E20C

class clssettings_accountingDataSource extends clsDBDBNetConnect {  //settings_accountingDataSource Class @2-1DAF52F3

//Variables @2-50EF98A3
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $paypal_on;
    var $paypal;
    var $authorizenet_on;
    var $authorizenet;
    var $authorize_tran_key;
    var $set_id;
//End Variables

//Class_Initialize Event @2-8B3319C6
    function clssettings_accountingDataSource()
    {
        $this->Initialize();
        $this->paypal_on = new clsField("paypal_on", ccsInteger, "");
        $this->paypal = new clsField("paypal", ccsText, "");
        $this->authorizenet_on = new clsField("authorizenet_on", ccsInteger, "");
        $this->authorizenet = new clsField("authorizenet", ccsText, "");
        $this->authorize_tran_key = new clsField("authorize_tran_key", ccsText, "");
        $this->set_id = new clsField("set_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-7C7D15F5
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlset_id", ccsInteger, "", "", $this->Parameters["urlset_id"], 1);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "set_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @2-FC3D15BB
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM settings_accounting";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-1B4A33DF
    function SetValues()
    {
        $this->paypal_on->SetDBValue($this->f("paypal_on"));
        $this->paypal->SetDBValue($this->f("paypal"));
        $this->authorizenet_on->SetDBValue($this->f("authorizenet_on"));
        $this->authorizenet->SetDBValue($this->f("authorizenet"));
        $this->authorize_tran_key->SetDBValue($this->f("authorize_tran_key"));
        $this->set_id->SetDBValue($this->f("set_id"));
    }
//End SetValues Method

//Update Method @2-C92B5BD9
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE settings_accounting SET "
             . "paypal_on=" . $this->ToSQL($this->paypal_on->GetDBValue(), $this->paypal_on->DataType) . ", "
             . "paypal=" . $this->ToSQL($this->paypal->GetDBValue(), $this->paypal->DataType) . ", "
             . "authorizenet_on=" . $this->ToSQL($this->authorizenet_on->GetDBValue(), $this->authorizenet_on->DataType) . ", "
             . "authorizenet=" . $this->ToSQL($this->authorizenet->GetDBValue(), $this->authorizenet->DataType) . ", "
             . "authorize_tran_key=" . $this->ToSQL($this->authorize_tran_key->GetDBValue(), $this->authorize_tran_key->DataType) . ", "
             . "set_id=" . $this->ToSQL($this->set_id->GetDBValue(), $this->set_id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End settings_accountingDataSource Class @2-FCB6E20C

//Include Page implementation @14-B991DFB8
include(RelativePath . "/Footer.php");
//End Include Page implementation

//Initialize Page @1-9EDFBD97
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

$FileName = "Accountings.php";
$Redirect = "";
$TemplateFileName = "Themes/Accountings.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-6081CC69
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$settings_accounting = new clsRecordsettings_accounting();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$settings_accounting->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-D3DA916C
$Header->Operations();
$settings_accounting->Operation();
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

//Show Page @1-C3A31430
$Header->Show("Header");
$settings_accounting->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
