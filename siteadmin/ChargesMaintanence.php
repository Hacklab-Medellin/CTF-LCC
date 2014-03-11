<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @13-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordcharges { //charges Class @2-23D0AC71

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

//Class_Initialize Event @2-4875488E
    function clsRecordcharges()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clschargesDataSource();
        $this->InsertAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "charges";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->charge_id = new clsControl(ccsLabel, "charge_id", "charge_id", ccsInteger, "", CCGetRequestParam("charge_id", $Method));
            $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsText, "", CCGetRequestParam("user_id", $Method));
            $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", $Method));
            $this->charge = new clsControl(ccsTextBox, "charge", "Charge", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("charge", $Method));
            $this->cause = new clsControl(ccsTextArea, "cause", "cause", ccsMemo, "", CCGetRequestParam("cause", $Method));
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
        }
    }
//End Class_Initialize Event

//Initialize Method @2-AF91F9DE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlcharge_id"] = CCGetFromGet("charge_id", "");
    }
//End Initialize Method

//Validate Method @2-F7732B46
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //$Validation = ($this->charge_id->Validate() && $Validation);
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->date->Validate() && $Validation);
        //$Validation = ($this->charge->Validate() && $Validation);
        //$Validation = ($this->cause->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-578A57D6
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
            } else if(strlen(CCGetParam("Delete", ""))) {
                $this->PressedButton = "Delete";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "ChargesList.php?" . CCGetQueryString("QueryString", Array("Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            } else {
                $Redirect = "ChargesList.php?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "ChargesList.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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

//UpdateRow Method @2-8641F65F
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->charge_id->SetValue($this->charge_id->GetValue());
        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->date->SetValue($this->date->GetValue());
        $this->ds->charge->SetValue($this->charge->GetValue());
        $this->ds->cause->SetValue($this->cause->GetValue());
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

//DeleteRow Method @2-A9D87FED
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");
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

//Show Method @2-E3D6ADF8
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
                    echo "Error in Record charges";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->charge_id->SetValue($this->ds->charge_id->GetValue());
                    $this->user_id->SetValue(GetUserNameID($this->ds->user_id->GetValue()));
                    if(!$this->FormSubmitted)
                    {
                        $twodays = $this->ds->date->GetValue();
						$theday = getdate($twodays);
						$lastofyear = substr($theday["year"],-2);
						$enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
						$this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                        $this->charge->SetValue($this->ds->charge->GetValue());
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
            $Error .= $this->charge_id->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->date->Errors->ToString();
            $Error .= $this->charge->Errors->ToString();
            $Error .= $this->cause->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->charge_id->Show();
        $this->user_id->Show();
        $this->date->Show();
        $this->charge->Show();
        $this->cause->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
		$Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @2-FCB6E20C

class clschargesDataSource extends clsDBDBNetConnect {  //chargesDataSource Class @2-8045203E

//Variables @2-06916A98
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $charge_id;
    var $user_id;
    var $date;
    var $charge;
    var $cause;
//End Variables

//Class_Initialize Event @2-E6247CAF
    function clschargesDataSource()
    {
        $this->Initialize();
        $this->charge_id = new clsField("charge_id", ccsInteger, "");
        $this->user_id = new clsField("user_id", ccsText, "");
        $this->date = new clsField("date", ccsText, "");
        $this->charge = new clsField("charge", ccsFloat, "");
        $this->cause = new clsField("cause", ccsMemo, "");

    }
//End Class_Initialize Event

//Prepare Method @2-7FAE8833
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

//Open Method @2-09BFC025
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

//SetValues Method @2-21222A76
    function SetValues()
    {
        $this->charge_id->SetDBValue($this->f("charge_id"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->date->SetDBValue($this->f("date"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->cause->SetDBValue($this->f("cause"));
    }
//End SetValues Method

//Delete Method @2-F0FA3EAD
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM charges WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

//Update Method @2-8502C6F8
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE charges SET " .
            "charge=" . $this->ToSQL($this->charge->DBValue, $this->charge->DataType) . ", " . 
            "cause=" . $this->ToSQL($this->cause->DBValue, $this->cause->DataType) . 
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End chargesDataSource Class @2-FCB6E20C

//Include Page implementation @14-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-5940AE83
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

$FileName = "ChargesMaintanence.php";
$Redirect = "";
$TemplateFileName = "Themes/ChargesMaintanence.html";
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
$charges = new clsRecordcharges();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$charges->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-6C5BA476
$Header->Operations();
$charges->Operation();
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
$charges->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
