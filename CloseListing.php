<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Closing Listing";
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

Class clsRecorditems { //items Class @4-505305D9

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

//Class_Initialize Event @4-C368A3BF
    function clsRecorditems()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->InsertAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "items";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "Num", ccsInteger, "", CCGetRequestParam("ItemNum", $Method));
            $this->ItemNum->Required = true;
            $this->title = new clsControl(ccsLabel, "title", "Title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->category = new clsControl(ccsLabel, "category", "category", ccsInteger, "", CCGetRequestParam("category", $Method));
            $this->end_reason = new clsControl(ccsTextBox, "end_reason", "End Reason", ccsText, "", CCGetRequestParam("end_reason", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
            $this->status = new clsControl(ccsHidden, "status", "Status", ccsInteger, "", CCGetRequestParam("status", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-9A10BCFA
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlItemNum"] = CCGetFromGet("ItemNum", "");
        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
    }
//End Initialize Method

//Validate Method @4-B3498ADB
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->ItemNum->Validate() && $Validation);
        $Validation = ($this->category->Validate() && $Validation);
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->end_reason->Validate() && $Validation);
        $Validation = ($this->status->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-EB2A28E8
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

//UpdateRow Method @4-A6CC3400
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->ItemNum->SetValue($this->ItemNum->GetValue());
        $this->ds->category->SetValue($this->category->GetValue());
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->end_reason->SetValue($this->end_reason->GetValue());
        $this->ds->status->SetValue(2);
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

//Show Method @4-E7B22BDB
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
                    echo "Error in Record items";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                    $this->category->SetValue($this->ds->category->GetValue());
                    $this->title->SetValue($this->ds->title->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->end_reason->SetValue($this->ds->end_reason->GetValue());
                        $this->status->SetValue($this->ds->status->GetValue());
                        $this->category->SetValue($this->ds->category->GetValue());
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
            $Error .= $this->ItemNum->Errors->ToString();
            $Error .= $this->category->Errors->ToString();
            $Error .= $this->title->Errors->ToString();
            $Error .= $this->end_reason->Errors->ToString();
            $Error .= $this->status->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->ItemNum->Show();
        $this->category->Show();
        $this->title->Show();
        $this->end_reason->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $this->status->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//Variables @4-FA6E2BB8
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $ItemNum;
    var $title;
    var $end_reason;
    var $status;
    var $category;
//End Variables

//Class_Initialize Event @4-2D72659C
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->end_reason = new clsField("end_reason", ccsText, "");
        $this->status = new clsField("status", ccsInteger, "");
        $this->category = new clsField("category", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @4-775ACC3A
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItemNum", ccsInteger, "", "", $this->Parameters["urlItemNum"], "");
        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ItemNum", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->wp->Criterion[3] = "status='1'";
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-2B286CE7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-9BD0CB53
    function SetValues()
    {
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->title->SetDBValue($this->f("title"));
        $this->end_reason->SetDBValue($this->f("end_reason"));
        $this->status->SetDBValue($this->f("status"));
        $this->category->SetDBValue($this->f("category"));
    }
//End SetValues Method

//Update Method @4-8FBBA53B
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE items SET " .
            "end_reason=" . $this->ToSQL($this->end_reason->DBValue, $this->end_reason->DataType) . ", " .
            "status=" . $this->ToSQL($this->status->DBValue, $this->status->DataType) .
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
        $this->query("delete from listing_index where `ItemNum` = '" . $this->wp->GetDBValue("1") . "'");
        $SQL = "SELECT `category` from items where `ItemNum` = '" . $this->wp->GetDBValue("1") . "'";
        $this->query($SQL);
        if ($this->next_record()){
	        subtract_catcounts($this->f("category"));
        }
    }
//End Update Method

} //End itemsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-2AB00AB1
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

$FileName = "CloseListing.php";
$Redirect = "";
$TemplateFileName = "templates/CloseListing.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-E4D2660F

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$items = new clsRecorditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$items->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-249DA85C
$Header->Operations();
$items->Operation();
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

//Show Page @1-F9F38336
$Header->Show("Header");
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>