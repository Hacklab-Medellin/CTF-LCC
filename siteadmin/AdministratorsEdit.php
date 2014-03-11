<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @18-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordadministrators { //administrators Class @2-1C3534F7

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

//Class_Initialize Event @2-B0E43CF9
    function clsRecordadministrators()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsadministratorsDataSource();
        if($this->Visible)
        {
            $this->ComponentName = "administrators";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->username = new clsControl(ccsTextBox, "username", "username", ccsText, "", CCGetRequestParam("username", $Method));
            $this->password = new clsControl(ccsTextBox, "password", "password", ccsText, "", CCGetRequestParam("password", $Method));
            $this->level = new clsControl(ccsListBox, "level", "level", ccsInteger, "", CCGetRequestParam("level", $Method));
            $level_values = array(array("1", "Support"), array("2", "Site Manager"), array("3", "System Administrator"));
            $this->level->Values = $level_values;
            $this->level->Required = true;
            $this->firstname = new clsControl(ccsTextBox, "firstname", "firstname", ccsText, "", CCGetRequestParam("firstname", $Method));
            $this->lastname = new clsControl(ccsTextBox, "lastname", "lastname", ccsText, "", CCGetRequestParam("lastname", $Method));
            $this->address = new clsControl(ccsTextArea, "address", "address", ccsMemo, "", CCGetRequestParam("address", $Method));
            $this->phone = new clsControl(ccsTextBox, "phone", "phone", ccsText, "", CCGetRequestParam("phone", $Method));
            $this->pager = new clsControl(ccsTextBox, "pager", "pager", ccsText, "", CCGetRequestParam("pager", $Method));
            $this->cell = new clsControl(ccsTextBox, "cell", "cell", ccsText, "", CCGetRequestParam("cell", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->admin_id = new clsControl(ccsHidden, "admin_id", "admin_id", ccsInteger, "", CCGetRequestParam("admin_id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-919C0490
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urladmin_id"] = CCGetFromGet("admin_id", "");
    }
//End Initialize Method

//Validate Method @2-07A3361A
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->username->Validate() && $Validation);
        $Validation = ($this->password->Validate() && $Validation);
        $Validation = ($this->level->Validate() && $Validation);
        $Validation = ($this->firstname->Validate() && $Validation);
        $Validation = ($this->lastname->Validate() && $Validation);
        $Validation = ($this->address->Validate() && $Validation);
        $Validation = ($this->phone->Validate() && $Validation);
        $Validation = ($this->pager->Validate() && $Validation);
        $Validation = ($this->cell->Validate() && $Validation);
        $Validation = ($this->admin_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-81615B1B
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
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
        $Redirect = "AdministratorsList.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
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
            } else if($this->PressedButton == "Cancel") {
                if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                    $Redirect = "";
                } else {
                    $Redirect = "AdministratorsList.php?" . CCGetQueryString("QueryString", array("ccsForm"));
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @2-EF470ED6
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->username->SetValue($this->username->GetValue());
        $this->ds->password->SetValue($this->password->GetValue());
        $this->ds->level->SetValue($this->level->GetValue());
        $this->ds->firstname->SetValue($this->firstname->GetValue());
        $this->ds->lastname->SetValue($this->lastname->GetValue());
        $this->ds->address->SetValue($this->address->GetValue());
        $this->ds->phone->SetValue($this->phone->GetValue());
        $this->ds->pager->SetValue($this->pager->GetValue());
        $this->ds->cell->SetValue($this->cell->GetValue());
        $this->ds->admin_id->SetValue($this->admin_id->GetValue());
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

//UpdateRow Method @2-E237B7C6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->username->SetValue($this->username->GetValue());
        $this->ds->password->SetValue($this->password->GetValue());
        $this->ds->level->SetValue($this->level->GetValue());
        $this->ds->firstname->SetValue($this->firstname->GetValue());
        $this->ds->lastname->SetValue($this->lastname->GetValue());
        $this->ds->address->SetValue($this->address->GetValue());
        $this->ds->phone->SetValue($this->phone->GetValue());
        $this->ds->pager->SetValue($this->pager->GetValue());
        $this->ds->cell->SetValue($this->cell->GetValue());
        $this->ds->admin_id->SetValue($this->admin_id->GetValue());
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

//Show Method @2-812FD6D3
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
                    echo "Error in Record administrators";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->username->SetValue($this->ds->username->GetValue());
                        $this->password->SetValue($this->ds->password->GetValue());
                        $this->level->SetValue($this->ds->level->GetValue());
                        $this->firstname->SetValue($this->ds->firstname->GetValue());
                        $this->lastname->SetValue($this->ds->lastname->GetValue());
                        $this->address->SetValue($this->ds->address->GetValue());
                        $this->phone->SetValue($this->ds->phone->GetValue());
                        $this->pager->SetValue($this->ds->pager->GetValue());
                        $this->cell->SetValue($this->ds->cell->GetValue());
                        $this->admin_id->SetValue($this->ds->admin_id->GetValue());
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
            $Error .= $this->username->Errors->ToString();
            $Error .= $this->password->Errors->ToString();
            $Error .= $this->level->Errors->ToString();
            $Error .= $this->firstname->Errors->ToString();
            $Error .= $this->lastname->Errors->ToString();
            $Error .= $this->address->Errors->ToString();
            $Error .= $this->phone->Errors->ToString();
            $Error .= $this->pager->Errors->ToString();
            $Error .= $this->cell->Errors->ToString();
            $Error .= $this->admin_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->username->Show();
        $this->password->Show();
        $this->level->Show();
        $this->firstname->Show();
        $this->lastname->Show();
        $this->address->Show();
        $this->phone->Show();
        $this->pager->Show();
        $this->cell->Show();
        $this->Insert->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
        $this->admin_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End administrators Class @2-FCB6E20C

class clsadministratorsDataSource extends clsDBDBNetConnect {  //administratorsDataSource Class @2-15647FE2

//Variables @2-90322A0B
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $username;
    var $password;
    var $level;
    var $firstname;
    var $lastname;
    var $address;
    var $phone;
    var $pager;
    var $cell;
    var $admin_id;
//End Variables

//Class_Initialize Event @2-769F66D0
    function clsadministratorsDataSource()
    {
        $this->Initialize();
        $this->username = new clsField("username", ccsText, "");
        $this->password = new clsField("password", ccsText, "");
        $this->level = new clsField("level", ccsInteger, "");
        $this->firstname = new clsField("firstname", ccsText, "");
        $this->lastname = new clsField("lastname", ccsText, "");
        $this->address = new clsField("address", ccsMemo, "");
        $this->phone = new clsField("phone", ccsText, "");
        $this->pager = new clsField("pager", ccsText, "");
        $this->cell = new clsField("cell", ccsText, "");
        $this->admin_id = new clsField("admin_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-C6307B66
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urladmin_id", ccsInteger, "", "", $this->Parameters["urladmin_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "admin_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @2-0F89117B
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM administrators";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-D19776C3
    function SetValues()
    {
        $this->username->SetDBValue($this->f("username"));
        $this->password->SetDBValue($this->f("password"));
        $this->level->SetDBValue($this->f("level"));
        $this->firstname->SetDBValue($this->f("firstname"));
        $this->lastname->SetDBValue($this->f("lastname"));
        $this->address->SetDBValue($this->f("address"));
        $this->phone->SetDBValue($this->f("phone"));
        $this->pager->SetDBValue($this->f("pager"));
        $this->cell->SetDBValue($this->f("cell"));
        $this->admin_id->SetDBValue($this->f("admin_id"));
    }
//End SetValues Method

//Delete Method @2-27FBA6A9
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM administrators WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

//Update Method @2-75893A89
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE administrators SET " .
            "username=" . $this->ToSQL($this->username->DBValue, $this->username->DataType) . ", " . 
            "password=" . $this->ToSQL($this->password->DBValue, $this->password->DataType) . ", " . 
            "level=" . $this->ToSQL($this->level->DBValue, $this->level->DataType) . ", " . 
            "firstname=" . $this->ToSQL($this->firstname->DBValue, $this->firstname->DataType) . ", " . 
            "lastname=" . $this->ToSQL($this->lastname->DBValue, $this->lastname->DataType) . ", " . 
            "address=" . $this->ToSQL($this->address->DBValue, $this->address->DataType) . ", " . 
            "phone=" . $this->ToSQL($this->phone->DBValue, $this->phone->DataType) . ", " . 
            "pager=" . $this->ToSQL($this->pager->DBValue, $this->pager->DataType) . ", " . 
            "cell=" . $this->ToSQL($this->cell->DBValue, $this->cell->DataType) . ", " . 
            "admin_id=" . $this->ToSQL($this->admin_id->DBValue, $this->admin_id->DataType) . 
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

//Insert Method @2-18324361
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO administrators(" . 
            "username, " . 
            "password, " . 
            "level, " . 
            "firstname, " . 
            "lastname, " . 
            "address, " . 
            "phone, " . 
            "pager, " . 
            "cell, " . 
            "admin_id" . 
        ") VALUES (" . 
            $this->ToSQL($this->username->DBValue, $this->username->DataType) . ", " . 
            $this->ToSQL($this->password->DBValue, $this->password->DataType) . ", " . 
            $this->ToSQL($this->level->DBValue, $this->level->DataType) . ", " . 
            $this->ToSQL($this->firstname->DBValue, $this->firstname->DataType) . ", " . 
            $this->ToSQL($this->lastname->DBValue, $this->lastname->DataType) . ", " . 
            $this->ToSQL($this->address->DBValue, $this->address->DataType) . ", " . 
            $this->ToSQL($this->phone->DBValue, $this->phone->DataType) . ", " . 
            $this->ToSQL($this->pager->DBValue, $this->pager->DataType) . ", " . 
            $this->ToSQL($this->cell->DBValue, $this->cell->DataType) . ", " . 
            $this->ToSQL($this->admin_id->DBValue, $this->admin_id->DataType) . 
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End administratorsDataSource Class @2-FCB6E20C

//Include Page implementation @19-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-5D041A81
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

$FileName = "AdministratorsEdit.php";
$Redirect = "";
$TemplateFileName = "Themes/AdministratorsEdit.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-45830F0C

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$administrators = new clsRecordadministrators();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$administrators->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-125BCA2C
$Header->Operations();
$administrators->Operation();
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

//Show Page @1-A378DD76
$Header->Show("Header");
$administrators->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
