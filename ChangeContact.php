<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Changing Contact Information";
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

Class clsRecordusers { //users Class @6-811DFF64

//Variables @6-90DA4C9A

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

//Class_Initialize Event @6-4908EC10
    function clsRecordusers()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsusersDataSource();
        $this->InsertAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "users";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->first_name = new clsControl(ccsLabel, "first_name", "First Name", ccsText, "", CCGetRequestParam("first_name", $Method));
            $this->last_name = new clsControl(ccsLabel, "last_name", "Last Name", ccsText, "", CCGetRequestParam("last_name", $Method));
            $this->address1 = new clsControl(ccsTextBox, "address1", "Address1", ccsText, "", CCGetRequestParam("address1", $Method));
            $this->address2 = new clsControl(ccsTextBox, "address2", "Address2", ccsText, "", CCGetRequestParam("address2", $Method));
            $this->city = new clsControl(ccsTextBox, "city", "City", ccsText, "", CCGetRequestParam("city", $Method));
		$this->state_id = new clsControl(ccsTextBox, "state_id", "State Province", ccsText, "", CCGetRequestParam("state_id", $Method));
            $this->zip = new clsControl(ccsTextBox, "zip", "Zip", ccsText, "", CCGetRequestParam("zip", $Method));
            $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", CCGetRequestParam("country_id", $Method));
            $this->country_id_ds = new clsDBNetConnect();
            $this->country_id_ds->SQL = "SELECT *  " .
"FROM lookup_countries";
            $country_id_values = CCGetListValues($this->country_id_ds, $this->country_id_ds->SQL, $this->country_id_ds->Where, $this->country_id_ds->Order, "country_id", "country_desc");
            $this->country_id->Values = $country_id_values;
            $this->phone_day = new clsControl(ccsTextBox, "phone_day", "Phone Day", ccsText, "", CCGetRequestParam("phone_day", $Method));
            $this->phone_evn = new clsControl(ccsTextBox, "phone_evn", "Phone Evn", ccsText, "", CCGetRequestParam("phone_evn", $Method));
            $this->fax = new clsControl(ccsTextBox, "fax", "Fax", ccsText, "", CCGetRequestParam("fax", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
        }
    }
//End Class_Initialize Event

//Initialize Method @6-537EA73F
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
    }
//End Initialize Method

//Validate Method @6-5129E92E
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->first_name->Validate() && $Validation);
        $Validation = ($this->last_name->Validate() && $Validation);
        $Validation = ($this->address1->Validate() && $Validation);
        $Validation = ($this->address2->Validate() && $Validation);
        $Validation = ($this->city->Validate() && $Validation);
        $Validation = ($this->state_id->Validate() && $Validation);
        $Validation = ($this->zip->Validate() && $Validation);
        $Validation = ($this->country_id->Validate() && $Validation);
        $Validation = ($this->phone_day->Validate() && $Validation);
        $Validation = ($this->phone_evn->Validate() && $Validation);
        $Validation = ($this->fax->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @6-EB2A28E8
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
        $Redirect = "myaccount.php?" . CCGetQueryString("QueryString", Array("Update","Cancel","ccsForm"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
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

//UpdateRow Method @6-446B7CE6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->first_name->SetValue($this->first_name->GetValue());
        $this->ds->last_name->SetValue($this->last_name->GetValue());
        $this->ds->address1->SetValue($this->address1->GetValue());
        $this->ds->address2->SetValue($this->address2->GetValue());
        $this->ds->city->SetValue($this->city->GetValue());
        $this->ds->state_id->SetValue($this->state_id->GetValue());
        $this->ds->zip->SetValue($this->zip->GetValue());
        $this->ds->country_id->SetValue($this->country_id->GetValue());
        $this->ds->phone_day->SetValue($this->phone_day->GetValue());
        $this->ds->phone_evn->SetValue($this->phone_evn->GetValue());
        $this->ds->fax->SetValue($this->fax->GetValue());
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

//Show Method @6-13E12A24
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
                    echo "Error in Record users";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->first_name->SetValue($this->ds->first_name->GetValue());
                    $this->last_name->SetValue($this->ds->last_name->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->address1->SetValue($this->ds->address1->GetValue());
                        $this->address2->SetValue($this->ds->address2->GetValue());
                        $this->city->SetValue($this->ds->city->GetValue());
                        $this->state_id->SetValue($this->ds->state_id->GetValue());
                        $this->zip->SetValue($this->ds->zip->GetValue());
                        $this->country_id->SetValue($this->ds->country_id->GetValue());
                        $this->phone_day->SetValue($this->ds->phone_day->GetValue());
                        $this->phone_evn->SetValue($this->ds->phone_evn->GetValue());
                        $this->fax->SetValue($this->ds->fax->GetValue());
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
            $Error .= $this->first_name->Errors->ToString();
            $Error .= $this->last_name->Errors->ToString();
            $Error .= $this->address1->Errors->ToString();
            $Error .= $this->address2->Errors->ToString();
            $Error .= $this->city->Errors->ToString();
            $Error .= $this->state_id->Errors->ToString();
            $Error .= $this->zip->Errors->ToString();
            $Error .= $this->country_id->Errors->ToString();
            $Error .= $this->phone_day->Errors->ToString();
            $Error .= $this->phone_evn->Errors->ToString();
            $Error .= $this->fax->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->first_name->Show();
        $this->last_name->Show();
        $this->address1->Show();
        $this->address2->Show();
        $this->city->Show();
        $this->state_id->Show();
        $this->zip->Show();
        $this->country_id->Show();
        $this->phone_day->Show();
        $this->phone_evn->Show();
        $this->fax->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End users Class @6-FCB6E20C

class clsusersDataSource extends clsDBNetConnect {  //usersDataSource Class @6-B3FBEB6D

//Variables @6-97B43CBE
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $first_name;
    var $last_name;
    var $address1;
    var $address2;
    var $city;
    var $state_id;
    var $zip;
    var $country_id;
    var $phone_day;
    var $phone_evn;
    var $fax;
//End Variables

//Class_Initialize Event @6-04EFE2FF
    function clsusersDataSource()
    {
        $this->Initialize();
        $this->first_name = new clsField("first_name", ccsText, "");
        $this->last_name = new clsField("last_name", ccsText, "");
        $this->address1 = new clsField("address1", ccsText, "");
        $this->address2 = new clsField("address2", ccsText, "");
        $this->city = new clsField("city", ccsText, "");
        $this->state_id = new clsField("state_id", ccsText, "");
        $this->zip = new clsField("zip", ccsText, "");
        $this->country_id = new clsField("country_id", ccsInteger, "");
        $this->phone_day = new clsField("phone_day", ccsText, "");
        $this->phone_evn = new clsField("phone_evn", ccsText, "");
        $this->fax = new clsField("fax", ccsText, "");

    }
//End Class_Initialize Event

//Prepare Method @6-CA9B5CCE
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @6-DC1AA46D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM users";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @6-5AFED090
    function SetValues()
    {
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->address1->SetDBValue($this->f("address1"));
        $this->address2->SetDBValue($this->f("address2"));
        $this->city->SetDBValue($this->f("city"));
        $this->state_id->SetDBValue($this->f("state_id"));
        $this->zip->SetDBValue($this->f("zip"));
        $this->country_id->SetDBValue($this->f("country_id"));
        $this->phone_day->SetDBValue($this->f("phone_day"));
        $this->phone_evn->SetDBValue($this->f("phone_evn"));
        $this->fax->SetDBValue($this->f("fax"));
    }
//End SetValues Method

//Update Method @6-BD567E4F
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE users SET " .
            "address1=" . $this->ToSQL($this->address1->DBValue, $this->address1->DataType) . ", " .
            "address2=" . $this->ToSQL($this->address2->DBValue, $this->address2->DataType) . ", " .
            "city=" . $this->ToSQL($this->city->DBValue, $this->city->DataType) . ", " .
            "state_id=" . $this->ToSQL($this->state_id->DBValue, $this->state_id->DataType) . ", " .
            "zip=" . $this->ToSQL($this->zip->DBValue, $this->zip->DataType) . ", " .
            "country_id=" . $this->ToSQL($this->country_id->DBValue, $this->country_id->DataType) . ", " .
            "phone_day=" . $this->ToSQL($this->phone_day->DBValue, $this->phone_day->DataType) . ", " .
            "phone_evn=" . $this->ToSQL($this->phone_evn->DBValue, $this->phone_evn->DataType) . ", " .
            "fax=" . $this->ToSQL($this->fax->DBValue, $this->fax->DataType) .
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End usersDataSource Class @6-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-EAF5552B
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

$FileName = "ChangeContact.php";
$Redirect = "";
$TemplateFileName = "templates/ChangeContact.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-3C073C46

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$users = new clsRecordusers();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$users->Initialize();

// Events
include("./ChangeContact_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-AB1E45CE
$Header->Operations();
$users->Operation();
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

//Show Page @1-8D0414C5
$Header->Show("Header");
$users->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>