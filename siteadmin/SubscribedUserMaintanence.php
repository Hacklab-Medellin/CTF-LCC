<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @33-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordusers { //users Class @2-811DFF64

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

//Class_Initialize Event @2-52BCFD40
    function clsRecordusers()
    {
        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsusersDataSource();
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "users";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", $Method));
            $this->user_id = new clsControl(ccsListBox, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->user_id->DSType = dsTable;
            list($this->user_id->BoundColumn, $this->user_id->TextColumn) = array("user_id", "user_login");
            $this->user_id->ds = new clsDBDBNetConnect();
            $this->user_id->ds->SQL = "SELECT *  " .
"FROM users";
//            $this->user_id->Required = true;
            $this->paid = new clsControl(ccsTextBox, "paid", "paid", ccsText, "", CCGetRequestParam("paid", $Method));
            $this->subsc_id = new clsControl(ccsListBox, "subsc_id", "subsc_id", ccsInteger, "", CCGetRequestParam("subsc_id", $Method));
            $this->subsc_id->DSType = dsTable;
            list($this->subsc_id->BoundColumn, $this->subsc_id->TextColumn) = array("id", "title");
            $this->subsc_id->ds = new clsDBDBNetConnect();
            $this->subsc_id->ds->SQL = "SELECT *  " .
"FROM subscription_plans";
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
        }
    }
//End Class_Initialize Event

//Initialize Method @2-C016A25E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlid"] = CCGetFromGet("id", "");
    }
//End Initialize Method

//Validate Method @2-E238E11E
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->id->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $Validation = ($this->paid->Validate() && $Validation);
        $Validation = ($this->subsc_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-2D422814
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
            }
        }
        $Redirect = "ListSubscribedUsers.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","ccsForm","id"));
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
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @2-8DF9A5FB
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        if(!$this->InsertAllowed) return false;
        $this->ds->id->SetValue("");
        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->paid->SetValue($this->paid->GetValue());
        $this->ds->subsc_id->SetValue($this->subsc_id->GetValue());
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




//UpdateRow Method @2-47E2B7B6
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->id->SetValue($this->id->GetValue());
//        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->paid->SetValue($this->paid->GetValue());
//        $this->ds->subsc_id->SetValue($this->subsc_id->GetValue());
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

//Show Method @2-834738D3
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->user_id->Prepare();
        $this->subsc_id->Prepare();

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
                    $this->id->SetValue($this->ds->id->GetValue());
                    $Tpl->setVar("disabled", "disabled");
                    if(!$this->FormSubmitted)
                    {
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->paid->SetValue($this->ds->paid->GetValue());
                        $this->subsc_id->SetValue($this->ds->subsc_id->GetValue());
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
            $Error .= $this->id->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->paid->Errors->ToString();
            $Error .= $this->subsc_id->Errors->ToString();
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
        $this->id->Show();
        $this->user_id->Show();
        $this->paid->Show();
        $this->subsc_id->Show();
        $this->Insert->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method



} //End users Class @2-FCB6E20C

class clsusersDataSource extends clsDBDBNetConnect {  //usersDataSource Class @2-76F0F9D9

//DataSource Variables @2-C4C367C0
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $id;
    var $user_id;
    var $paid;
    var $subsc_id;
//End DataSource Variables

//Class_Initialize Event @2-2A41CF3B
    function clsusersDataSource()
    {
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->paid = new clsField("paid", ccsText, "");
        $this->subsc_id = new clsField("subsc_id", ccsInteger, "");
    }
//End Class_Initialize Event

//Prepare Method @2-4CE37742
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-DC1AA46D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM used_subscriptions";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-D67CC77D
    function SetValues()
    {
        $this->id->SetDBValue($this->f("id"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->paid->SetDBValue($this->f("paid"));
        $this->subsc_id->SetDBValue($this->f("subsc_id"));
    }
//End SetValues Method

//Insert Method @2-543151F3
    function Insert()
    {
    	$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
    	subscribe($this->user_id->GetDBValue(), $this->subsc_id->GetDBValue(), $this->paid->GetDBValue());
	}
//End Insert Method

//Update Method @2-0139ACE1
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `used_subscriptions` SET "
             . "`paid`=" . $this->ToSQL($this->paid->GetDBValue(), $this->paid->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

//Delete Method @2-211B5EBA
    function Delete()
    {
		
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
    	endsubscription($this->Parameters["urlid"]);
    	
    }
//End Delete Method

} //End usersDataSource Class @2-FCB6E20C

//Include Page implementation @34-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-759C2791
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

$FileName = "SubscribedUserMaintanence.php";
$Redirect = "";
$TemplateFileName = "Themes/SubscribedUserMaintanence.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-E3ED6E39
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$users = new clsRecordusers();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$users->Initialize();

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
