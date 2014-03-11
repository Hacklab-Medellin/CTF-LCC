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

Class clsRecordgroups { //groups Class @2-BC1592CB

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
    function clsRecordgroups()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsgroupsDataSource();
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "groups";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->title = new clsControl(ccsTextBox, "title", "title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->description = new clsControl(ccsTextArea, "description", "description", ccsMemo, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("description", $Method));
            $this->listing_discount = new clsControl(ccsTextBox, "listing_discount", "listing_discount", ccsInteger, "", CCGetRequestParam("listing_discount", $Method));
            $this->tokens = new clsControl(ccsTextBox, "tokens", "tokens", ccsInteger, "", CCGetRequestParam("tokens", $Method));
            $this->req_approval= new clsControl(ccsListBox, "req_approval", "req_approval", ccsInteger, "", CCGetRequestParam("req_approval", $Method));
            $this->req_approval->DSType = dsListOfValues;
            $this->req_approval->Values = array(array("0", "No"), array("1", "Yes"));
            $this->fe_admin = new clsControl(ccsListBox, "fe_admin", "fe_admin", ccsInteger, "", CCGetRequestParam("fe_admin", $Method));
            $this->fe_admin->DSType = dsListOfValues;
            $this->fe_admin->Values = array(array("0", "No"), array("1", "Yes"));
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->id = new clsControl(ccsHidden, "id", "id", ccsInteger, "", CCGetRequestParam("id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-4795F97A
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlid"] = CCGetFromGet("id", "");
    }
//End Initialize Method

//Validate Method @2-A9485F0A
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->listing_discount->Validate() && $Validation);
        $Validation = ($this->tokens->Validate() && $Validation);
        $Validation = ($this->req_approval->Validate() && $Validation);
        $Validation = ($this->fe_admin->Validate() && $Validation);
        $Validation = ($this->id->Validate() && $Validation);
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
        $Redirect = "Groups.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "Groups.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->listing_discount->SetValue($this->listing_discount->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->req_approval->SetValue($this->req_approval->GetValue());
        $this->ds->fe_admin->SetValue($this->fe_admin->GetValue());
        $this->ds->id->SetValue($this->id->GetValue());
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
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->listing_discount->SetValue($this->listing_discount->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->req_approval->SetValue($this->req_approval->GetValue());
        $this->ds->fe_admin->SetValue($this->fe_admin->GetValue());
        $this->ds->id->SetValue($this->id->GetValue());
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
                    echo "Error in Record groups";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->title->SetValue($this->ds->title->GetValue());
                        $this->description->SetValue($this->ds->description->GetValue());
                        $this->listing_discount->SetValue($this->ds->listing_discount->GetValue());
                        $this->tokens->SetValue($this->ds->tokens->GetValue());
                        $this->req_approval->SetValue($this->ds->req_approval->GetValue());
                        $this->fe_admin->SetValue($this->ds->fe_admin->GetValue());
                        $this->id->SetValue($this->ds->id->GetValue());
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
            $Error .= $this->title->Errors->ToString();
            $Error .= $this->description->Errors->ToString();
            $Error .= $this->listing_discount->Errors->ToString();
            $Error .= $this->tokens->Errors->ToString();
            $Error .= $this->req_approval->Errors->ToString();
            $Error .= $this->fe_admin->Errors->ToString();
            $Error .= $this->id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->title->Show();
        $this->description->Show();
        $this->listing_discount->Show();
        $this->tokens->Show();
        $this->req_approval->Show();
        $this->fe_admin->Show();
        $this->Insert->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
        $this->id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End groups Class @2-FCB6E20C

class clsgroupsDataSource extends clsDBDBNetConnect {  //groupsDataSource Class @2-619FFB46

//DataSource Variables @2-4470F3E1
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $title;
    var $description;
    var $listing_discount;
    var $tokens;
    var $req_approval;
    var $fe_admin;
    var $id;
//End DataSource Variables

//Class_Initialize Event @2-5C914A09
    function clsgroupsDataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->description = new clsField("description", ccsMemo, "");
        $this->listing_discount = new clsField("listing_discount", ccsInteger, "");
        $this->tokens = new clsField("tokens", ccsInteger, "");
        $this->req_approval = new clsField("req_approval", ccsInteger, "");
        $this->fe_admin = new clsField("fe_admin", ccsInteger, "");
        $this->id = new clsField("id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-1B3AF55E
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-6D28333E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM groups";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-555E28E0
    function SetValues()
    {
        $this->title->SetDBValue($this->f("title"));
        $this->description->SetDBValue($this->f("description"));
        $this->listing_discount->SetDBValue(($this->f("listing_discount")*100));
        $this->tokens->SetDBValue($this->f("tokens"));
        $this->req_approval->SetDBValue($this->f("req_approval"));
        $this->fe_admin->SetDBValue($this->f("fe_admin"));
        $this->id->SetDBValue($this->f("id"));
    }
//End SetValues Method

//Insert Method @2-38D454BA
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO `groups` ("
             . "`title`, "
             . "`description`, "
             . "`listing_discount`, "
             . "`tokens`, "
             . "`req_approval`, "
             . "`fe_admin`, "
             . "`id`"
             . ") VALUES ("
             . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
             . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
             . $this->ToSQL(($this->listing_discount->GetDBValue()/100), $this->listing_discount->DataType) . ", "
             . $this->ToSQL(($this->tokens->GetDBValue()), $this->tokens->DataType) . ", "
             . $this->ToSQL(($this->req_approval->GetDBValue()), $this->req_approval->DataType) . ", "
             . $this->ToSQL(($this->fe_admin->GetDBValue()), $this->fe_admin->DataType) . ", "
             . $this->ToSQL($this->id->GetDBValue(), $this->id->DataType)
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
        $SQL = "UPDATE `groups` SET "
             . "`title`=" . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
             . "`description`=" . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
             . "`listing_discount`=" . $this->ToSQL(($this->listing_discount->GetDBValue()/100), $this->listing_discount->DataType) . ", "
             . "`tokens`=" . $this->ToSQL(($this->tokens->GetDBValue()), $this->tokens->DataType) . ", "
             . "`req_approval`=" . $this->ToSQL($this->req_approval->GetDBValue(), $this->req_approval->DataType) . ", "
             . "`fe_admin`=" . $this->ToSQL($this->fe_admin->GetDBValue(), $this->fe_admin->DataType) . ", "
             . "`id`=" . $this->ToSQL($this->id->GetDBValue(), $this->id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
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
        $SQL = "DELETE FROM `groups` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
		$SQL = "DELETE FROM `groups_users` WHERE 'group_id' = '" . $this->Parameters["urlid"] . "'";
		$this->query($SQL);
		$SQL = "DELETE FROM `groups_categories` WHERE 'group_id' = '" . $this->Parameters["urlid"] . "'";
		$this->query($SQL);
    }
//End Delete Method

} //End groupsDataSource Class @2-FCB6E20C

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

$FileName = "GroupsEdit.php";
$Redirect = "";
$TemplateFileName = "Themes/GroupsEdit.html";
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
$groups = new clsRecordgroups();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$groups->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-57FDC199
$Header->Operations();
$groups->Operation();
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
$groups->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page



?>
