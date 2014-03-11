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

Class clsRecordemails { //emails Class @4-ACB218B9

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

//Class_Initialize Event @4-28500540
    function clsRecordemails()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsemailsDataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "emails";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->subject = new clsControl(ccsTextBox, "subject", "Subject", ccsText, "", CCGetRequestParam("subject", $Method));
            $this->message = new clsControl(ccsTextArea, "message", "Message", ccsMemo, "", CCGetRequestParam("message", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Cancel = new clsButton("Cancel");
            $this->to_user_id = new clsControl(ccsHidden, "to_user_id", "To User Id", ccsInteger, "", CCGetRequestParam("to_user_id", $Method));
            $this->from_user_id = new clsControl(ccsHidden, "from_user_id", "From User Id", ccsInteger, "", CCGetRequestParam("from_user_id", $Method));
            $this->emaildate = new clsControl(ccsHidden, "emaildate", "date", ccsInteger, "", CCGetRequestParam("emaildate", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-EDF229C2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlemail_id"] = CCGetFromGet("email_id", "");
    }
//End Initialize Method

//Validate Method @4-AE0C8DEF
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->subject->Validate() && $Validation);
        $Validation = ($this->message->Validate() && $Validation);
        $Validation = ($this->to_user_id->Validate() && $Validation);
        $Validation = ($this->from_user_id->Validate() && $Validation);
        $Validation = ($this->emaildate->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-B013246C
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
        $Redirect = "index.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));
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

//InsertRow Method @4-77BA2EF4
    function InsertRow()
    {
        global $EP;
		global $now;
		global $charges;
		global $accounting;
		$EP = array(
                "EMAIL:SITE_NAME" => $now["sitename"],
                "EMAIL:SITE_EMAIL" => $now["siteemail"],
                "EMAIL:SITE_EMAIL_LINK" => "<a href=\"mailto:" . $now["siteemail"] . "\">" . $now["siteemail"] . "</a>",
                "EMAIL:HOME_URL" => $now["homeurl"],
                "EMAIL:HOME_PAGE_LINK" => "<a href=\"" . $now["homeurl"] . "index.php\">Home</a>",
                "EMAIL:BROWSE_LINK" => "<a href=\"" . $now["homeurl"] . "browse.php\">Browse</a>",
                "EMAIL:SEARCH_LINK" => "<a href=\"" . $now["homeurl"] . "search.php\">Search</a>",
                "EMAIL:MY_ACCOUNT_LINK" => "<a href=\"" . $now["homeurl"] . "myaccount.php\">My Account</a>",
                "EMAIL:PAYMENT_LINK_SSL" => "<a href=\"" . $now["secureurl"] . "MakePayment.php\">Make a Payment</a>",
                "EMAIL:PAYMENT_LINK" => "<a href=\"" . $now["homeurl"] . "MakePayment.php\">Make a Payment</a>",
                "EMAIL:CURRENCY" => $charges["currency"],
                "EMAIL:LISTING_FEE" => $charges["listing_fee"],
                "EMAIL:HOMEPAGE_FEATURED_FEE" => $charges["homepage_fee"],
                "EMAIL:CATEGORY_FEATURED_FEE" => $charges["category_fee"],
                "EMAIL:GALLERY_FEE" => $charges["gallery_fee"],
                "EMAIL:IMAGE_PREVIEW_FEE" => $charges["image_preview_fee"],
                "EMAIL:SLIDE_SHOW_FEE" => $charges["slide_fee"],
                "EMAIL:COUNTER_FEE" => $charges["counter_fee"],
                "EMAIL:BOLD_FEE" => $charges["bold_fee"],
                "EMAIL:BACKGROUND_FEE" => $charges["highlight_fee"],
                "EMAIL:IMAGE_UPLOAD_FEE" => $charges["upload_fee"],
                "EMAIL:CURRENT_TIME" => date("F j, Y, g:i a")
                );

				$lookdb = new clsDBNetConnect;
                $lookdb->connect();
                $lookdb->query("SELECT * FROM users WHERE newsletter='1'");
                while($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "username" => $lookdb->f("user_login"),
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
                           
				$EP["EMAIL:CURRENT_USERNAME"] = $ld["username"];
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
				mailnews($ld["email"], $this->message->GetValue(), $this->subject->GetValue(), $EP);
		}
		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        /*
		$this->ds->subject->SetValue($this->subject->GetValue());
        $this->ds->message->SetValue($this->message->GetValue());
        $this->ds->to_user_id->SetValue($this->to_user_id->GetValue());
        $this->ds->from_user_id->SetValue($this->from_user_id->GetValue());
        $this->ds->emaildate->SetValue($this->emaildate->GetValue());
        $this->ds->Insert();
		*/
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

//Show Method @4-D5844878
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
                    echo "Error in Record emails";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->subject->SetValue($this->ds->subject->GetValue());
                        $this->message->SetValue($this->ds->message->GetValue());
                        $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());
                        $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());
                        $this->emaildate->SetValue($this->ds->emaildate->GetValue());
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
            $Error .= $this->subject->Errors->ToString();
            $Error .= $this->message->Errors->ToString();
            $Error .= $this->to_user_id->Errors->ToString();
            $Error .= $this->from_user_id->Errors->ToString();
            $Error .= $this->emaildate->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->subject->Show();
        $this->message->Show();
        $this->Insert->Show();
        $this->Cancel->Show();
        $this->to_user_id->Show();
        $this->from_user_id->Show();
        $this->emaildate->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End emails Class @4-FCB6E20C

class clsemailsDataSource extends clsDBDBNetConnect {  //emailsDataSource Class @4-A5AA25F3

//Variables @4-C059878A
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $subject;
    var $message;
    var $to_user_id;
    var $from_user_id;
    var $emaildate;
//End Variables

//Class_Initialize Event @4-954CC5AA
    function clsemailsDataSource()
    {
        $this->Initialize();
        $this->subject = new clsField("subject", ccsText, "");
        $this->message = new clsField("message", ccsMemo, "");
        $this->to_user_id = new clsField("to_user_id", ccsInteger, "");
        $this->from_user_id = new clsField("from_user_id", ccsInteger, "");
        $this->emaildate = new clsField("emaildate", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @4-9C05E373
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlemail_id", ccsInteger, "", "", $this->Parameters["urlemail_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-2A9A8869
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM emails";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-3CB7DF8D
    function SetValues()
    {
        $this->subject->SetDBValue($this->f("subject"));
        $this->message->SetDBValue($this->f("message"));
        $this->to_user_id->SetDBValue($this->f("to_user_id"));
        $this->from_user_id->SetDBValue($this->f("from_user_id"));
        $this->emaildate->SetDBValue($this->f("emaildate"));
    }
//End SetValues Method

//Insert Method @4-20E304F0
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO emails(" . 
            "subject, " . 
            "message, " . 
            "to_user_id, " . 
            "from_user_id, " . 
            "emaildate" . 
        ") VALUES (" . 
            $this->ToSQL($this->subject->DBValue, $this->subject->DataType) . ", " . 
            $this->ToSQL($this->message->DBValue, $this->message->DataType) . ", " . 
            $this->ToSQL($this->to_user_id->DBValue, $this->to_user_id->DataType) . ", " . 
            $this->ToSQL($this->from_user_id->DBValue, $this->from_user_id->DataType) . ", " . 
            $this->ToSQL($this->emaildate->DBValue, $this->emaildate->DataType) . 
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End emailsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-95413599
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

$FileName = "SendNewsletter.php";
$Redirect = "";
$TemplateFileName = "Themes/SendNewsletter.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-BB70AA98
CCSecurityRedirect("2;3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-98349396

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$emails = new clsRecordemails();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$emails->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-FAFD6843
$Header->Operations();
$emails->Operation();
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

//Show Page @1-32B79DBC
$Header->Show("Header");
$emails->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
