<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @10-503267A8
include("./Header.php");
//End Include Page implementation
if (!$_GET["cat_id"])
	$_GET["cat_id"] = 1;
else
	$cat_id = $_GET["cat_id"];

Class clsRecordlookup_listing_dates { //lookup_listing_dates Class @2-BC1592CB

//Variables @2-D65AB00C

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

    var $InsertAllowed;
    var $UpdateAllowed;
    var $DeleteAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @2-1D6627CF
    function clsRecordlookup_listing_dates()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_listing_datesDataSource();
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "lookup_listing_dates";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->days = new clsControl(ccsTextBox, "days", "days", ccsInteger, "", CCGetRequestParam("days", $Method));
            $this->Checkbox1 = new clsControl(ccsCheckBox, "Checkbox1", "Checkbox1", ccsBoolean, "", CCGetRequestParam("Checkbox1", $Method));
            $this->Checkbox1->CheckedValue = 1;
            $this->Checkbox1->UncheckedValue = 0;
            $this->fee = new clsControl(ccsTextBox, "fee", "Fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("fee", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->date_id = new clsControl(ccsHidden, "date_id", "date_id", ccsInteger, "", CCGetRequestParam("date_id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-4795F97A
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urldate_id"] = CCGetFromGet("date_id", "");
    }
//End Initialize Method

//Validate Method @2-A9485F0A
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->days->Validate() && $Validation);
        $Validation = ($this->Checkbox1->Validate() && $Validation);
        $Validation = ($this->fee->Validate() && $Validation);
        $Validation = ($this->date_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-2B2C0CBB
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
            $this->PressedButton = $this->EditMode ? "Update" : "Insert";
            if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            } else if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Delete", ""))) {
                $this->PressedButton = "Delete";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "ListingDates.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "ListingDates.php?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @2-2F231E3B
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        if(!$this->InsertAllowed) return false;
        $this->ds->days->SetValue($this->days->GetValue());
        $this->ds->Checkbox1->SetValue($this->Checkbox1->GetValue());
        $this->ds->fee->SetValue($this->fee->GetValue());
        $this->ds->date_id->SetValue($this->date_id->GetValue());
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

//UpdateRow Method @2-3D60980A
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->days->SetValue($this->days->GetValue());
        $this->ds->Checkbox1->SetValue($this->Checkbox1->GetValue());
        $this->ds->fee->SetValue($this->fee->GetValue());
        $this->ds->date_id->SetValue($this->date_id->GetValue());
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

//DeleteRow Method @2-6A43D177
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");
        if(!$this->DeleteAllowed) return false;
        $this->ds->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete");
        if($this->ds->Errors->Count())
        {
            echo "Error in Record " . ComponentName . " / Delete Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End DeleteRow Method

//Show Method @2-6D38629E
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
                    echo "Error in Record lookup_listing_dates";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->days->SetValue($this->ds->days->GetValue());
                        $this->Checkbox1->SetValue($this->ds->Checkbox1->GetValue());
                        $this->fee->SetValue($this->ds->fee->GetValue());
                        $this->date_id->SetValue($this->ds->date_id->GetValue());
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
            $Error .= $this->days->Errors->ToString();
            $Error .= $this->Checkbox1->Errors->ToString();
            $Error .= $this->fee->Errors->ToString();
            $Error .= $this->date_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("cat_id", $_GET["cat_id"]);
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->days->Show();
        $this->Checkbox1->Show();
        $this->fee->Show();
        $this->Insert->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
        $this->date_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_listing_dates Class @2-FCB6E20C

class clslookup_listing_datesDataSource extends clsDBDBNetConnect {  //lookup_listing_datesDataSource Class @2-619FFB46

//DataSource Variables @2-4470F3E1
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $days;
    var $Checkbox1;
    var $fee;
    var $date_id;
//End DataSource Variables

//Class_Initialize Event @2-5C914A09
    function clslookup_listing_datesDataSource()
    {
        $this->Initialize();
        $this->days = new clsField("days", ccsInteger, "");
        $this->Checkbox1 = new clsField("Checkbox1", ccsBoolean, Array(1, 0, ""));
        $this->fee = new clsField("fee", ccsFloat, "");
        $this->date_id = new clsField("date_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-1B3AF55E
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urldate_id", ccsInteger, "", "", $this->Parameters["urldate_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`date_id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-6D28333E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM lookup_listing_dates";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-555E28E0
    function SetValues()
    {
        $this->days->SetDBValue($this->f("days"));
        $this->Checkbox1->SetDBValue($this->f("charge_for"));
        $this->fee->SetDBValue($this->f("fee"));
        $this->date_id->SetDBValue($this->f("date_id"));
    }
//End SetValues Method

//Insert Method @2-38D454BA
    function Insert()
    {
    	global $cat_id;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO `lookup_listing_dates` ("
             . "`days`, "
             . "`charge_for`, "
             . "`fee`, "
             . "`cat_id`, "
             . "`date_id`"
             . ") VALUES ("
             . $this->ToSQL($this->days->GetDBValue(), $this->days->DataType) . ", "
             . $this->ToSQL($this->Checkbox1->GetDBValue(), $this->Checkbox1->DataType) . ", "
             . $this->ToSQL($this->fee->GetDBValue(), $this->fee->DataType) . ", "
             . $_POST["cat_id"] . ", "
             . $this->ToSQL($this->date_id->GetDBValue(), $this->date_id->DataType)
             . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

//Update Method @2-AF46D9A4
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `lookup_listing_dates` SET "
             . "`days`=" . $this->ToSQL($this->days->GetDBValue(), $this->days->DataType) . ", "
             . "`charge_for`=" . $this->ToSQL($this->Checkbox1->GetDBValue(), $this->Checkbox1->DataType) . ", "
             . "`fee`=" . $this->ToSQL($this->fee->GetDBValue(), $this->fee->DataType) . ", "
             . "`date_id`=" . $this->ToSQL($this->date_id->GetDBValue(), $this->date_id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where . " and cat_id=" . $_POST["cat_id"], "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

//Delete Method @2-BB5A9601
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM `lookup_listing_dates` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

} //End lookup_listing_datesDataSource Class @2-FCB6E20C

//Include Page implementation @11-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-870A1EE5
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

$FileName = "ListingDatesEdit.php";
$Redirect = "";
$TemplateFileName = "Themes/ListingDatesEdit.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-58B471A7
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_listing_dates = new clsRecordlookup_listing_dates();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_listing_dates->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-57FDC199
$Header->Operations();
$lookup_listing_dates->Operation();
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

//Show Page @1-D30AFD57
$Header->Show("Header");
$lookup_listing_dates->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page



?>
