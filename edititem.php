<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Adding to Item Description";
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
//End Include Common Files

//Include Page implementation @2-503267A8
include("./Headeru.php");
//End Include Page implementation

Class clsRecorditems { //items Class @4-505305D9

//Variables @4-052F1B76

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

//Class_Initialize Event @4-D337C986
    function clsRecorditems()
    {

        global $FileName;
################
# Begin check users id #
################
$user_id_in = CCGetSession("UserID");
$item_in = CCGetFromGet("ItemNum", ""); // obtains posted item number
$check = new clsDBNetConnect(); // create a new db connection
if(CCDLookUp("ItemNum","items","user_id='" . $user_id_in . "' AND ItemNum='" . $item_in . "'", $check) == $item_in)
{
$this->Visible = true; // belongs to user so show form
}
else
{
$this->Visible = false; // does not belong to user so do not show form
CCSecurityRedirect("3;3", "login.php", $FileName, CCGetQueryString("QueryString", "")); // set illegalgroup and redirect to login page
}
unset($check); // close temp db connection
###############
# End check users id #
###############
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->UpdateAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "items";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", $Method));
            $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->added_description = new clsControl(ccsTextArea, "added_description", "Added Description", ccsMemo, "", CCGetRequestParam("added_description", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
            $this->dateadded = new clsControl(ccsHidden, "dateadded", "Dateadded", ccsText, "", CCGetRequestParam("dateadded", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-A9E1C9D7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlItemNum"] = CCGetFromGet("ItemNum", "");
        $this->ds->Parameters["sesuser_id"] = CCGetSession("UserID");
    }
//End Initialize Method

//Validate Method @4-5C82A025
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->ItemNum->Validate() && $Validation);
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->added_description->Validate() && $Validation);
        $Validation = ($this->dateadded->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-2D3E7740
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
        $Redirect = "ViewOpen.php";
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

//DEL      function InsertRow()
//DEL      {
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
//DEL          if(!$this->InsertAllowed) return false;
//DEL          $this->ds->ItemNum->SetValue($this->ItemNum->GetValue());
//DEL          $this->ds->title->SetValue($this->title->GetValue());
//DEL          $this->ds->added_description->SetValue($this->added_description->GetValue());
//DEL          $this->ds->dateadded->SetValue(time());
//DEL          $this->ds->Insert();
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");
//DEL          if($this->ds->Errors->Count() > 0)
//DEL          {
//DEL              echo "Error in Record " . $this->ComponentName . " / Insert Operation";
//DEL              $this->ds->Errors->Clear();
//DEL              $this->Errors->AddError("Database command error.");
//DEL          }
//DEL          return ($this->Errors->Count() == 0);
//DEL      }


//UpdateRow Method @4-059A415D
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->ItemNum->SetValue($this->ItemNum->GetValue());
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->added_description->SetValue($this->added_description->GetValue());
        $this->ds->dateadded->SetValue(time());
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

//Show Method @4-79154A3F
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
                    $this->title->SetValue($this->ds->title->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->added_description->SetValue($this->ds->added_description->GetValue());
                        $this->dateadded->SetValue($this->ds->dateadded->GetValue());
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
            $Error .= $this->ItemNum->Errors->ToString();
            $Error .= $this->title->Errors->ToString();
            $Error .= $this->added_description->Errors->ToString();
            $Error .= $this->dateadded->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->ItemNum->Show();
        $this->title->Show();
        $this->added_description->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $this->dateadded->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//DataSource Variables @4-E551C182
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $ItemNum;
    var $title;
    var $added_description;
    var $dateadded;
//End DataSource Variables

//Class_Initialize Event @4-38893288
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->added_description = new clsField("added_description", ccsMemo, "");
        $this->dateadded = new clsField("dateadded", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @4-95BC1ADC
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItemNum", ccsInteger, "", "", $this->Parameters["urlItemNum"], "");
        $this->wp->AddParameter("2", "sesuser_id", ccsInteger, "", "", $this->Parameters["sesuser_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`ItemNum`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "`user_id`", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->Where = $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]);
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

//SetValues Method @4-9C08FC30
    function SetValues()
    {
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->title->SetDBValue($this->f("title"));
        $this->added_description->SetDBValue($this->f("added_description"));
        $this->dateadded->SetDBValue($this->f("dateadded"));
    }
//End SetValues Method

//Update Method @4-5E712AA4
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `items` SET "
             . "`added_description`=" . $this->ToSQL($this->added_description->GetDBValue(), $this->added_description->DataType) . ", "
             . "`dateadded`=" . $this->ToSQL($this->dateadded->GetDBValue(), $this->dateadded->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
        index_listing($this->wp->GetDBValue("1"), $this->added_description->GetDBValue(), "add_desc");
    }
//End Update Method

} //End itemsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-C0C99C19
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

$FileName = "edititem.php";
$Redirect = "";
$TemplateFileName = "templates/edititem.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User


//Initialize Objects @1-0352CFE2
$DBNetConnect = new clsDBNetConnect();

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
