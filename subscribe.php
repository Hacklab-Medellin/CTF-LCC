<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

CCSecurityRedirect("1;2", "login.php", "subscribe.php", CCGetQueryString("QueryString", ""));

//End Include Common Files
$page="Subscribing";
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
Class clsRecordcharges1 { //charges1 Class @4-386271B0

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

//Class_Initialize Event @4-1A1CDCB5
    function clsRecordcharges1()
    {

        global $FileName;
        global $ttlcal;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clscharges1DataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "charges1";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->charge = new clsControl(ccsTextBox, "charge", "Amount", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("charge", $Method));
            $this->charge->Required = true;
            $this->FirstName = new clsControl(ccsTextBox, "FirstName", "First Name", ccsText, "", CCGetRequestParam("FirstName", $Method));
            $this->FirstName->Required = true;
            $this->LastName = new clsControl(ccsTextBox, "LastName", "Last Name", ccsText, "", CCGetRequestParam("LastName", $Method));
            $this->LastName->Required = true;
            $this->CCNumber = new clsControl(ccsTextBox, "CCNumber", "Credit Card Number", ccsText, "", CCGetRequestParam("CCNumber", $Method));
            $this->CCNumber->Required = true;
            $this->ExpDate = new clsControl(ccsTextBox, "ExpDate", "Expiration Date", ccsText, "", CCGetRequestParam("ExpDate", $Method));
            $this->ExpDate->Required = true;
            $this->CardCode = new clsControl(ccsTextBox, "CardCode", "Card Code (CVV2)", ccsText, "", CCGetRequestParam("CardCode", $Method));
            $this->CardCode->Required = true;
            $this->Insert = new clsButton("Insert");
            $this->Cancel = new clsButton("Cancel");
            $this->user_id = new clsControl(ccsHidden, "user_id", "User Id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->date = new clsControl(ccsHidden, "date", "Date", ccsInteger, "", CCGetRequestParam("date", $Method));
            $this->cause = new clsControl(ccsHidden, "cause", "Cause", ccsMemo, "", CCGetRequestParam("cause", $Method));
            if(!$this->FormSubmitted) {
                if(!strlen($this->charge->GetValue()))
                    $this->charge->SetValue($ttlcal);
                if(!strlen($this->ExpDate->GetValue()))
                    $this->ExpDate->SetValue("MM/YYYY");
            }
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

//Validate Method @4-2B045C35
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //if($this->charge->GetValue() < 1) {
        //    $this->charge->Errors->addError("You must deposit atleast 1.00");
        //        print "You must deposit atleast 1.00";
        //        }
                $Validation = ($this->charge->Validate() && $Validation);
        $Validation = ($this->FirstName->Validate() && $Validation);
        $Validation = ($this->LastName->Validate() && $Validation);
        //$Validation = ($this->CCNumber->Validate() && $Validation);
        //$Validation = ($this->ExpDate->Validate() && $Validation);
        //$Validation = ($this->CardCode->Validate() && $Validation);
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->date->Validate() && $Validation);
        //$Validation = ($this->cause->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-903571D3
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
        $Redirect = "PaymentConfirmed.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));
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

//InsertRow Method @4-D3C3764F
    function InsertRow()
    {
        global $finalamount;
        global $charges;
        global $EP;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->charge->SetValue($finalamount);
        $this->ds->FirstName->SetValue($this->FirstName->GetValue());
        $this->ds->LastName->SetValue($this->LastName->GetValue());
        $this->ds->CCNumber->SetValue($this->CCNumber->GetValue());
        $this->ds->ExpDate->SetValue($this->ExpDate->GetValue());
        $this->ds->CardCode->SetValue($this->CardCode->GetValue());
        $this->ds->user_id->SetValue(CCGetUserID());
        $this->ds->date->SetValue(time());
        $this->ds->cause->SetValue("Credit Card Payment--Subscription");
        $this->ds->Insert();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");
        $lookdb = new clsDBNetConnect;
        $lookdb->connect();
        $lookdb->query("SELECT * FROM users WHERE user_login='" . CCGetUserLogin() . "'");
                if($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "ID" => $lookdb->f("user_id"),
                        "last" => $lookdb->f("last_name"),
                        "email" => $lookdb->f("email"),
                        "address" => $lookdb->f("address1"),
                        "address2" => $lookdb->f("address2"),
                        "state" => $lookdb->f("state_id"),
                        "zip" => $lookdb->f("zip"),
                        "city" => $lookdb->f("city"),
                        "phonedy" => $lookdb->f("phone_day"),
                        "phoneevn" => $lookdb->f("phone_evn"),
                        "fax" => $lookdb->f("fax"),
                        "ip" => $lookdb->f("ip_insert"),
                        "date_created" => $lookdb->f("date_created"),
                        );
                }
                $EP["EMAIL:PAYMENT_SUBJECT"] = "Credit Card Deposit";
                $EP["EMAIL:PAYMENT_AMOUNT"] = $charges["currency"] . $finalamount;
                $EP["EMAIL:CURRENT_USERNAME"] = CCGetUserLogin();
                $EP["EMAIL:CURRENT_USERID"] = $ld["ID"];
                $EP["EMAIL:CURRENT_USER_FIRST_NAME"] = $ld["first"];
                $EP["EMAIL:CURRENT_USER_LAST_NAME"] = $ld["last"];
                $EP["EMAIL:CURRENT_USER_EMAIL"] = $ld["email"];
                $EP["EMAIL:CURRENT_USER_ADDRESS"] = $ld["address"];
                $EP["EMAIL:CURRENT_USER_ADDRESS2"] = $ld["address2"];
                $EP["EMAIL:CURRENT_USER_STATE"] = $ld["state"];
                $EP["EMAIL:CURRENT_USER_CITY"] = $ld["city"];
                $EP["EMAIL:CURRENT_USER_ZIP"] = $ld["zip"];
                $EP["EMAIL:CURRENT_USER_DAY_PHONE"] = $ld["phonedy"];
                $EP["EMAIL:CURRENT_USER_EVN_PHONE"] = $ld["phoneevn"];
                $EP["EMAIL:CURRENT_USER_FAX"] = $ld["fax"];
                $EP["EMAIL:CURRENT_USER_IP"] = getenv("REMOTE_ADDR");
                $EP["EMAIL:CURRENT_USER__REGISTERED_IP"] = $ld["ip"];
                $EP["EMAIL:CURRENT_USER_DATE_SIGNEDUP"] = date("F j, Y, g:i a", $ld["date_created"]);

            mailout("NewSubscribe", $now["notifyads"], $payer_id, 1000000000, time(), $EP);

        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Insert Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End InsertRow Method

//Show Method @4-7A814808
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
                    echo "Error in Record charges1";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->charge->SetValue($ttlcal);
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->date->SetValue($this->ds->date->GetValue());
                        $this->cause->SetValue($this->ds->cause->GetValue());
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
            $Error .= $this->charge->Errors->ToString();
            $Error .= $this->FirstName->Errors->ToString();
            $Error .= $this->LastName->Errors->ToString();
            $Error .= $this->CCNumber->Errors->ToString();
            $Error .= $this->ExpDate->Errors->ToString();
            $Error .= $this->CardCode->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->date->Errors->ToString();
            $Error .= $this->cause->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->charge->Show();
        $this->FirstName->Show();
        $this->LastName->Show();
        $this->CCNumber->Show();
        $this->ExpDate->Show();
        $this->CardCode->Show();
        $this->Insert->Show();
        $this->Cancel->Show();
        $this->user_id->Show();
        $this->date->Show();
        $this->cause->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges1 Class @4-FCB6E20C

class clscharges1DataSource extends clsDBNetConnect {  //charges1DataSource Class @4-2C64D7E3

//Variables @4-8452207F
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $charge;
    var $FirstName;
    var $LastName;
    var $CCNumber;
    var $ExpDate;
    var $CardCode;
    var $user_id;
    var $date;
    var $cause;
//End Variables

//Class_Initialize Event @4-DBE398D2
    function clscharges1DataSource()
    {
        $this->Initialize();
        $this->charge = new clsField("charge", ccsFloat, "");
        $this->FirstName = new clsField("FirstName", ccsText, "");
        $this->LastName = new clsField("LastName", ccsText, "");
        $this->CCNumber = new clsField("CCNumber", ccsText, "");
        $this->ExpDate = new clsField("ExpDate", ccsText, "");
        $this->CardCode = new clsField("CardCode", ccsText, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->date = new clsField("date", ccsInteger, "");
        $this->cause = new clsField("cause", ccsMemo, "");

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

//SetValues Method @4-663199F0
    function SetValues()
    {
        $this->charge->SetDBValue($this->f("charge"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->date->SetDBValue($this->f("date"));
        $this->cause->SetDBValue($this->f("cause"));
    }
//End SetValues Method

//Insert Method @4-5D0AE922
    function Insert()
    {
    	$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO charges(" .
            "user_id, " .
            "date, " .
            "cause, " .
            "charge" .
        ") VALUES (" .
            $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            $this->ToSQL($this->date->DBValue, $this->date->DataType) . ", " .
                        $this->ToSQL($this->cause->DBValue, $this->cause->DataType) . ", " .
            $this->ToSQL($this->charge->DBValue, $this->charge->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        //$this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
}
//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-49274B25
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

$FileName = "subscribe.php";
$Redirect = "";
$TemplateFileName = "templates/subscribe.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-DBA4AC3D

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$charges1 = new clsRecordcharges1();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();

// Events
include("./subscribe_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-351F985C
$Header->Operations();
$charges1->Operation();
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
buildpage($_GET["id"]);

global $accounting;

$db = new clsDBNetConnect;
$query = "select * from subscription_plans where `id`='" . $_GET["id"] . "'";
$db->query($query);
if ($db->next_record()){
	if ($accounting["authorize_on"] == 0 || !$db->f("authnet")){
        $charges1->Visible = false;
	}
}
//Show Page @1-A025E414
$Header->Show("Header");
$charges1->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
