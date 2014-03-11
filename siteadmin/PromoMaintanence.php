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

Class clsRecordpromo { //promo Class @2-23D0AC71

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
    function clsRecordpromo()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clspromoDataSource();
        $this->InsertAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "promo";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", $Method));
            $this->end = new clsControl(ccsText, "end", "end", ccsText, "", CCGetRequestParam("end", $Method));
            $this->start = new clsControl(ccsText, "start", "start", ccsText, "", CCGetRequestParam("start", $Method));
            $this->amount = new clsControl(ccsTextBox, "amount", "amount", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("amount", $Method));
            $this->group = new clsControl(ccsListBox, "group", "Group", ccsInteger, "", CCGetRequestParam("group", $Method));
            $this->group->DSType = dsTable;
            list($this->group->BoundColumn, $this->group->TextColumn) = array("id", "title");
            $this->group->ds = new clsDBDBNetConnect();
            $this->group->ds->SQL = "SELECT * FROM groups";
            $this->code = new clsControl(ccsTextArea, "code", "code", ccsText, "", CCGetRequestParam("code", $Method));
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

        $this->ds->Parameters["urlid"] = CCGetFromGet("id", "");
    }
//End Initialize Method

//Validate Method @2-F7732B46
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //$Validation = ($this->id->Validate() && $Validation);
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->date->Validate() && $Validation);
        //$Validation = ($this->amount->Validate() && $Validation);
        //$Validation = ($this->code->Validate() && $Validation);
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
        $Redirect = "PromoList.php?" . CCGetQueryString("QueryString", Array("Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            } else {
                $Redirect = "PromoList.php?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "PromoList.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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
        $this->ds->id->SetValue($this->id->GetValue());
        $this->ds->end->SetValue($this->end->GetValue());
        $this->ds->start->SetValue($this->start->GetValue());
        $this->ds->amount->SetValue($this->amount->GetValue());
        $this->ds->group->SetValue($this->group->GetValue());
        $this->ds->code->SetValue($this->code->GetValue());
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

        $this->group->Prepare();
        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record promo";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->id->SetValue($this->ds->id->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $twodays = $this->ds->start->GetValue();
						$theday = getdate($twodays);
						$lastofyear = substr($theday["year"],-2);
						$enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
						$this->start->SetValue(date("m/d/Y", $this->ds->start->GetValue()));
						$this->end->SetValue(date("m/d/Y", $this->ds->end->GetValue()));
                        $this->amount->SetValue($this->ds->amount->GetValue());
                        $this->group->SetValue($this->ds->group->GetValue());
                        $this->code->SetValue($this->ds->code->GetValue());
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
            $Error .= $this->id->Errors->ToString();
            $Error .= $this->end->Errors->ToString();
            $Error .= $this->start->Errors->ToString();
            $Error .= $this->amount->Errors->ToString();
            $Error .= $this->group->Errors->ToString();
            $Error .= $this->code->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->id->Show();
        $this->end->Show();
        $this->start->Show();
        $this->amount->Show();
        $this->group->Show();
        $this->code->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
		$Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End promo Class @2-FCB6E20C

class clspromoDataSource extends clsDBDBNetConnect {  //promoDataSource Class @2-8045203E

//Variables @2-06916A98
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $id;
    var $end;
    var $start;
    var $amount;
    var $group;
    var $code;
//End Variables

//Class_Initialize Event @2-E6247CAF
    function clspromoDataSource()
    {
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        $this->end = new clsField("end", ccsText, "");
        $this->start = new clsField("start", ccsText, "");
        $this->amount = new clsField("amount", ccsFloat, "");
        $this->group = new clsField("group", ccsInteger, "");
        $this->code = new clsField("code", ccsText, "");

    }
//End Class_Initialize Event

//Prepare Method @2-7FAE8833
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @2-09BFC025
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM promos";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-21222A76
    function SetValues()
    {
        $this->id->SetDBValue($this->f("id"));
        $this->end->SetDBValue($this->f("end"));
        $this->start->SetDBValue($this->f("start"));
        $this->amount->SetDBValue($this->f("amount"));
        $this->group->SetDBValue($this->f("group"));
        $this->code->SetDBValue($this->f("code"));
    }
//End SetValues Method

//Delete Method @2-F0FA3EAD
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM promos WHERE " . $this->Where;
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
        $SQL = "UPDATE promos SET " .
            "`amount`=" . $this->ToSQL($this->amount->DBValue, $this->amount->DataType) . ", " .
            "`group`=" . $this->ToSQL($this->group->DBValue, $this->group->DataType) . ", " .
            "`start`=" . $this->ToSQL(strtotime($this->start->DBValue), $this->start->DataType) . ", " .
            "`end`=" . $this->ToSQL(strtotime($this->end->DBValue), $this->end->DataType) . ", " .
            "`code`=" . $this->ToSQL($this->code->DBValue, $this->code->DataType) .
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End promoDataSource Class @2-FCB6E20C

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

$FileName = "PromoMaintanence.php";
$Redirect = "";
$TemplateFileName = "Themes/PromoMaintanence.html";
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
$promo = new clsRecordpromo();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$promo->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-6C5BA476
$Header->Operations();
$promo->Operation();
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
$promo->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
