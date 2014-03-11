<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//Include Page implementation @20-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordsubscriptions { //subscriptions Class @2-E13CABAE

//Variables @2-052F1B76

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

//Class_Initialize Event @2-377F9405
    function clsRecordsubscriptions()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssubscriptionsDataSource();
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "subscriptions";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", array("cat_id")), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->title = new clsControl(ccsTextBox, "title", "title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->icon = new clsControl(ccsTextBox, "icon", "icon", ccsText, "", CCGetRequestParam("icon", $Method));
            $this->description = new clsControl(ccsTextArea, "description", "Transaction Message", ccsText, "", CCGetRequestParam("description", $Method));
            $this->duration = new clsControl(ccsTextBox, "duration", "duration", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("duration", $Method));
            $this->unlimited = new clsControl(ccsCheckBox, "unlimited", "unlimited", ccsBoolean, "", CCGetRequestParam("unlimited", $Method));
            $this->unlimited->CheckedValue = 1;
            $this->unlimited->UncheckedValue = 0;
            $this->price = new clsControl(ccsTextBox, "price", "price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("price", $Method));
            $this->intro_duration = new clsControl(ccsTextBox, "intro_duration", "intro_duration", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("intro_duration", $Method));
            $this->intro_price = new clsControl(ccsTextBox, "intro_price", "intro_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("intro_price", $Method));
            $this->recurring = new clsControl(ccsCheckBox, "recurring", "recurring", ccsBoolean, "", CCGetRequestParam("recurring", $Method));
            $this->recurring->CheckedValue = 1;
            $this->recurring->UncheckedValue = 0;
            $this->intro = new clsControl(ccsCheckBox, "intro", "intro", ccsBoolean, "", CCGetRequestParam("intro", $Method));
            $this->intro->CheckedValue = 1;
            $this->intro->UncheckedValue = 0;
            $this->paypal = new clsControl(ccsCheckBox, "paypal", "paypal", ccsBoolean, "", CCGetRequestParam("paypal", $Method));
            $this->paypal->CheckedValue = 1;
            $this->paypal->UncheckedValue = 0;
            $this->authnet = new clsControl(ccsCheckBox, "authnet", "authnet", ccsBoolean, "", CCGetRequestParam("authnet", $Method));
            $this->authnet->CheckedValue = 1;
            $this->authnet->UncheckedValue = 0;
            $this->co2 = new clsControl(ccsCheckBox, "co2", "co2", ccsBoolean, "", CCGetRequestParam("co2", $Method));
            $this->co2->CheckedValue = 1;
            $this->co2->UncheckedValue = 0;
            $this->active = new clsControl(ccsCheckBox, "active", "active", ccsBoolean, "", CCGetRequestParam("active", $Method));
            $this->active->CheckedValue = 1;
            $this->active->UncheckedValue = 0;
            $this->group = new clsControl(ccsListBox, "group", "User Group", ccsInteger, "", CCGetRequestParam("group", $Method));
            $this->group->DSType = dsTable;
            list($this->group->BoundColumn, $this->group->TextColumn) = array("id", "title");
            $this->group->ds = new clsDBDBNetConnect();
            $this->group->ds->SQL = "SELECT * FROM groups";
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->id = new clsControl(ccsHidden, "id", "id", ccsInteger, "", CCGetRequestParam("id", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @2-90EC5D36
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlid"] = CCGetFromGet("id", "");
    }
//End Initialize Method

//Validate Method @2-75ACA2D2
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->icon->Validate() && $Validation);
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->duration->Validate() && $Validation);
        $Validation = ($this->unlimited->Validate() && $Validation);
        $Validation = ($this->price->Validate() && $Validation);
        $Validation = ($this->intro_duration->Validate() && $Validation);
        $Validation = ($this->intro_price->Validate() && $Validation);
        $Validation = ($this->recurring->Validate() && $Validation);
        $Validation = ($this->intro->Validate() && $Validation);
        $Validation = ($this->paypal->Validate() && $Validation);
        $Validation = ($this->authnet->Validate() && $Validation);
        $Validation = ($this->co2->Validate() && $Validation);
        $Validation = ($this->active->Validate() && $Validation);
        $Validation = ($this->group->Validate() && $Validation);
        $Validation = ($this->id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-8A36197A
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
        $Redirect = "ListSubscriptions.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","Cancel","ccsForm"));
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "ListSubscriptions.php?" . CCGetQueryString("QueryString", array("ccsForm"));
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
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->icon->SetValue($this->icon->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->duration->SetValue($this->duration->GetValue());
        $this->ds->unlimited->SetValue($this->unlimited->GetValue());
        $this->ds->price->SetValue($this->price->GetValue());
        $this->ds->intro_duration->SetValue($this->intro_duration->GetValue());
        $this->ds->intro_price->SetValue($this->intro_price->GetValue());
        $this->ds->recurring->SetValue($this->recurring->GetValue());
        $this->ds->intro->SetValue($this->intro->GetValue());
        $this->ds->paypal->SetValue($this->paypal->GetValue());
        $this->ds->authnet->SetValue($this->authnet->GetValue());
        $this->ds->co2->SetValue($this->co2->GetValue());
        $this->ds->active->SetValue($this->active->GetValue());
        $this->ds->group->SetValue($this->group->GetValue());
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

//UpdateRow Method @2-D8CC2AA5
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->icon->SetValue($this->icon->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->duration->SetValue($this->duration->GetValue());
        $this->ds->unlimited->SetValue($this->unlimited->GetValue());
        $this->ds->price->SetValue($this->price->GetValue());
        $this->ds->intro_duration->SetValue($this->intro_duration->GetValue());
        $this->ds->intro_price->SetValue($this->intro_price->GetValue());
        $this->ds->recurring->SetValue($this->recurring->GetValue());
        $this->ds->intro->SetValue($this->intro->GetValue());
        $this->ds->paypal->SetValue($this->paypal->GetValue());
        $this->ds->authnet->SetValue($this->authnet->GetValue());
        $this->ds->co2->SetValue($this->co2->GetValue());
        $this->ds->active->SetValue($this->active->GetValue());
        $this->ds->group->SetValue($this->group->GetValue());
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
        if(!$this->DeleteAllowed)
		return false;
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

//Show Method @2-A470E1CF
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;
            
        $this->group->Prepare();
		
        if ($_GET["id"])
        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record subscriptions";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->title->SetValue($this->ds->title->GetValue());
                        $this->icon->SetValue($this->ds->icon->GetValue());
                        $this->description->SetValue($this->ds->description->GetValue());
                        $this->duration->SetValue($this->ds->duration->GetValue());
                        $this->unlimited->SetValue($this->ds->unlimited->GetValue());
                        $this->price->SetValue($this->ds->price->GetValue());
                        $this->intro_duration->SetValue($this->ds->intro_duration->GetValue());
                        $this->intro_price->SetValue($this->ds->intro_price->GetValue());
                        $this->recurring->SetValue($this->ds->recurring->GetValue());
                        $this->intro->SetValue($this->ds->intro->GetValue());
                        $this->paypal->SetValue($this->ds->paypal->GetValue());
                        $this->authnet->SetValue($this->ds->authnet->GetValue());
                        $this->co2->SetValue($this->ds->co2->GetValue());
                        $this->active->SetValue($this->ds->active->GetValue());
                        $this->group->SetValue($this->ds->group->GetValue());
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
            $Error .= $this->icon->Errors->ToString();
            $Error .= $this->description->Errors->ToString();
            $Error .= $this->duration->Errors->ToString();
            $Error .= $this->unlimited->Errors->ToString();
            $Error .= $this->price->Errors->ToString();
            $Error .= $this->intro_duration->Errors->ToString();
            $Error .= $this->intro_price->Errors->ToString();
            $Error .= $this->recurring->Errors->ToString();
            $Error .= $this->intro->Errors->ToString();
            $Error .= $this->paypal->Errors->ToString();
            $Error .= $this->authnet->Errors->ToString();
            $Error .= $this->co2->Errors->ToString();
            $Error .= $this->active->Errors->ToString();
            $Error .= $this->group->Errors->ToString();
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
        $this->icon->Show();
        $this->description->Show();
        $this->duration->Show();
        $this->price->Show();
        $this->intro_duration->Show();
        $this->intro_price->Show();
        $this->unlimited->Show();
        $this->recurring->Show();
        $this->intro->Show();
        $this->paypal->Show();
        $this->authnet->Show();
        $this->co2->Show();
        $this->active->Show();
        $this->group->Show();
        $this->Insert->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
        if ($this->ds->authnet->GetValue() || $this->ds->co2->GetValue()){
        	$Tpl->SetVar("recdisabled", "disabled");
        	$Tpl->SetVar("intdisabled", "disabled");
        	$Tpl->SetVar("int_durdisabled", "disabled");
        	$Tpl->SetVar("int_pridisabled", "disabled");
        }
        elseif ($this->ds->recurring->GetValue()){
        	$Tpl->SetVar("autdisabled", "disabled");
        	$Tpl->SetVar("co2disabled", "disabled");
        }
        else{
        	$Tpl->SetVar("intdisabled", "disabled");
        	$Tpl->SetVar("int_durdisabled", "disabled");
        	$Tpl->SetVar("int_pridisabled", "disabled");
        }
        if ($this->ds->unlimited->GetValue())
        	$Tpl->SetVar("durationdisabled", "disabled");
        $this->id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End subscriptions Class @2-FCB6E20C

class clssubscriptionsDataSource extends clsDBDBNetConnect {  //subscriptionsDataSource Class @2-87020E65

//DataSource Variables @2-93B572B1
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $title;
    var $icon;
    var $description;
    var $duration;
    var $unlimited;
    var $price;
    var $intro_duration;
    var $intro_price;
    var $recurring;
    var $intro;
    var $paypal;
    var $authnet;
    var $co2;
    var $active;
    var $group;
    var $id;
//End DataSource Variables

//Class_Initialize Event @2-87050ECD
    function clssubscriptionsDataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->icon = new clsField("icon", ccsText, "");
        $this->description = new clsField("description", ccsText, "");
        $this->duration = new clsField("duration", ccsFloat, "");
        $this->unlimited = new clsField("unlimited", ccsBoolean, Array(1, 0, ""));
        $this->price = new clsField("price", ccsFloat, "");
        $this->intro_duration = new clsField("intro_duration", ccsFloat, "");
        $this->intro_price = new clsField("intro_price", ccsFloat, "");
        $this->recurring = new clsField("recurring", ccsBoolean, Array(1, 0, ""));
        $this->intro = new clsField("intro", ccsBoolean, Array(1, 0, ""));
        $this->paypal = new clsField("paypal", ccsBoolean, Array(1, 0, ""));
        $this->authnet = new clsField("authnet", ccsBoolean, Array(1, 0, ""));
        $this->co2 = new clsField("co2", ccsBoolean, Array(1, 0, ""));
        $this->active = new clsField("active", ccsBoolean, Array(1, 0, ""));
        $this->group = new clsField("group", ccsInteger, "");
        $this->id = new clsField("id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-D221C61F
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlid", ccsInteger, "", "", $this->Parameters["urlid"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-667FFC8F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM subscription_plans";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where ." ORDER BY `id` DESC LIMIT 1", $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-19E28474
    function SetValues()
    {
        $this->title->SetDBValue($this->f("title"));
        $this->icon->SetDBValue($this->f("icon"));
        $this->description->SetDBValue($this->f("description"));
        $this->duration->SetDBValue($this->f("duration"));
        $this->unlimited->SetDBValue($this->f("unlimited"));
        $this->price->SetDBValue($this->f("price"));
        $this->intro_duration->SetDBValue($this->f("intro_duration"));
        $this->intro_price->SetDBValue($this->f("intro_price"));
        $this->recurring->SetDBValue($this->f("recurring"));
        $this->intro->SetDBValue($this->f("intro"));
        $this->paypal->SetDBValue($this->f("paypal"));
        $this->authnet->SetDBValue($this->f("authnet"));
        $this->co2->SetDBValue($this->f("co2"));
        $this->active->SetDBValue($this->f("active"));
        $this->group->SetDBValue($this->f("group"));
        $this->id->SetDBValue($_GET["id"]);
    }
//End SetValues Method
//Insert Method @2-543151F3
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
             $SQL = "INSERT INTO `subscription_plans` ("
             . "`title`, "
             . "`icon`, "
             . "`description`, "
             . "`duration`, "
             . "`unlimited`, "
             . "`price`, "
             . "`intro_duration`, "
             . "`recurring`, "
             . "`intro`, "
             . "`paypal`, "
             . "`authnet`, "
             . "`co2`, "
             . "`active`, "
             . "`group`, "
             . "`date_added`, "
             . "`intro_price`"
			 . ") values ("
             
             . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
             . $this->ToSQL($this->icon->GetDBValue(), $this->icon->DataType) . ", "
             . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
             . $this->ToSQL($this->duration->GetDBValue(), $this->duration->DataType) . ", "
             . $this->ToSQL($this->unlimited->GetDBValue(), $this->unlimited->DataType) . ", "
             . $this->ToSQL($this->price->GetDBValue(), $this->price->DataType) . ", "
             . $this->ToSQL($this->intro_duration->GetDBValue(), $this->intro_duration->DataType) . ", "
             . $this->ToSQL($this->recurring->GetDBValue(), $this->recurring->DataType) . ", "
             . $this->ToSQL($this->intro->GetDBValue(), $this->intro->DataType) . ", "
             . $this->ToSQL($this->paypal->GetDBValue(), $this->paypal->DataType) . ", "
             . $this->ToSQL($this->authnet->GetDBValue(), $this->authnet->DataType) . ", "
             . $this->ToSQL($this->co2->GetDBValue(), $this->co2->DataType) . ", "
             . $this->ToSQL($this->active->GetDBValue(), $this->active->DataType) . ", "
             . $this->ToSQL($this->group->GetDBValue(), $this->group->DataType) . ", "
             . time() . ", "
             . $this->ToSQL($this->intro_price->GetDBValue(), $this->intro_price->DataType)
			 . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
    
//End Insert Method

//Update Method @2-48201046
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `subscription_plans` SET "
             . "`title`=" . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
             . "`icon`=" . $this->ToSQL($this->icon->GetDBValue(), $this->icon->DataType) . ", "
             . "`description`=" . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
             . "`duration`=" . $this->ToSQL($this->duration->GetDBValue(), $this->duration->DataType) . ", "
             . "`unlimited`=" . $this->ToSQL($this->unlimited->GetDBValue(), $this->unlimited->DataType) . ", "
             . "`price`=" . $this->ToSQL($this->price->GetDBValue(), $this->price->DataType) . ", "
             . "`intro_duration`=" . $this->ToSQL($this->intro_duration->GetDBValue(), $this->intro_duration->DataType) . ", "
             . "`intro_price`=" . $this->ToSQL($this->intro_price->GetDBValue(), $this->intro_price->DataType) . ", "
             . "`recurring`=" . $this->ToSQL($this->recurring->GetDBValue(), $this->recurring->DataType) . ", "
             . "`intro`=" . $this->ToSQL($this->intro->GetDBValue(), $this->intro->DataType) . ", "
             . "`paypal`=" . $this->ToSQL($this->paypal->GetDBValue(), $this->paypal->DataType) . ", "
             . "`authnet`=" . $this->ToSQL($this->authnet->GetDBValue(), $this->authnet->DataType) . ", "
             . "`co2`=" . $this->ToSQL($this->co2->GetDBValue(), $this->co2->DataType) . ", "
             . "`active`=" . $this->ToSQL($this->active->GetDBValue(), $this->active->DataType) . ", "
             . "`group`=" . $this->ToSQL($this->group->GetDBValue(), $this->group->DataType);
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
        $SQL = "DELETE FROM `subscription_plans` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

} //End subscriptionsDataSource Class @2-FCB6E20C

//Include Page implementation @21-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-2282A51C
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

$FileName = "AddSubscription.php";
$Redirect = "";
$TemplateFileName = "Themes/AddSubscription.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-7302B87D
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$subscriptions = new clsRecordsubscriptions();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$subscriptions->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-332FBF3C
$Header->Operations();
$subscriptions->Operation();
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

//Show Page @1-7EF9F867
$Header->Show("Header");
$subscriptions->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page



?>