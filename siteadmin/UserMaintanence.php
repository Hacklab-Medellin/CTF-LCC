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
            $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->status = new clsControl(ccsListBox, "status", "status", ccsInteger, "", CCGetRequestParam("status", $Method));
            $this->status->DSType = dsListOfValues;
            $this->status->Values = array(array("0", "On Hold"), array("1", "Active User"), array("3", "Suspended"));
            $this->user_login = new clsControl(ccsTextBox, "user_login", "user_login", ccsText, "", CCGetRequestParam("user_login", $Method));
            $this->user_login->Required = true;
            $this->user_password = new clsControl(ccsTextBox, "user_password", "user_password", ccsText, "", CCGetRequestParam("user_password", $Method));
            $this->user_password->Required = true;
            $this->first_name = new clsControl(ccsTextBox, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", $Method));
            $this->last_name = new clsControl(ccsTextBox, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", $Method));
            $this->email = new clsControl(ccsTextBox, "email", "email", ccsText, "", CCGetRequestParam("email", $Method));
            $this->address1 = new clsControl(ccsTextBox, "address1", "address1", ccsText, "", CCGetRequestParam("address1", $Method));
            $this->address2 = new clsControl(ccsTextBox, "address2", "address2", ccsText, "", CCGetRequestParam("address2", $Method));
            $this->city = new clsControl(ccsTextBox, "city", "city", ccsText, "", CCGetRequestParam("city", $Method));
            $this->state_id = new clsControl(ccsTextBox, "state_id", "State Province", ccsText, "", CCGetRequestParam("state_id", $Method));
            $this->zip = new clsControl(ccsTextBox, "zip", "zip", ccsText, "", CCGetRequestParam("zip", $Method));
            $this->tokens = new clsControl(ccsTextBox, "tokens", "tokens", ccsInteger, "", CCGetRequestParam("tokens", $Method));
            $this->country_id = new clsControl(ccsListBox, "country_id", "country_id", ccsInteger, "", CCGetRequestParam("country_id", $Method));
            $this->country_id->DSType = dsTable;
            list($this->country_id->BoundColumn, $this->country_id->TextColumn) = array("country_id", "country_desc");
            $this->country_id->ds = new clsDBDBNetConnect();
            $this->country_id->ds->SQL = "SELECT *  " .
"FROM lookup_countries";
            $this->country_id->Required = true;
            $this->phone_day = new clsControl(ccsTextBox, "phone_day", "phone_day", ccsText, "", CCGetRequestParam("phone_day", $Method));
            $this->phone_evn = new clsControl(ccsTextBox, "phone_evn", "phone_evn", ccsText, "", CCGetRequestParam("phone_evn", $Method));
            $this->fax = new clsControl(ccsTextBox, "fax", "fax", ccsText, "", CCGetRequestParam("fax", $Method));
            $this->age = new clsControl(ccsListBox, "age", "age", ccsInteger, "", CCGetRequestParam("age", $Method));
            $this->age->DSType = dsTable;
            list($this->age->BoundColumn, $this->age->TextColumn) = array("age_id", "age_desc");
            $this->age->ds = new clsDBDBNetConnect();
            $this->age->ds->SQL = "SELECT *  " .
"FROM lookup_ages";
            $this->gender = new clsControl(ccsListBox, "gender", "gender", ccsInteger, "", CCGetRequestParam("gender", $Method));
            $this->gender->DSType = dsTable;
            list($this->gender->BoundColumn, $this->gender->TextColumn) = array("gender_id", "gender_desc");
            $this->gender->ds = new clsDBDBNetConnect();
            $this->gender->ds->SQL = "SELECT *  " .
"FROM lookup_genders";
            $this->education = new clsControl(ccsListBox, "education", "education", ccsInteger, "", CCGetRequestParam("education", $Method));
            $this->education->DSType = dsTable;
            list($this->education->BoundColumn, $this->education->TextColumn) = array("education_id", "education_desc");
            $this->education->ds = new clsDBDBNetConnect();
            $this->education->ds->SQL = "SELECT *  " .
"FROM lookup_educations";
            $this->income = new clsControl(ccsListBox, "income", "income", ccsInteger, "", CCGetRequestParam("income", $Method));
            $this->income->DSType = dsTable;
            list($this->income->BoundColumn, $this->income->TextColumn) = array("income_id", "income_desc");
            $this->income->ds = new clsDBDBNetConnect();
            $this->income->ds->SQL = "SELECT *  " .
"FROM lookup_incomes";
            $this->date_created = new clsControl(ccsLabel, "date_created", "date_created", ccsText, "", CCGetRequestParam("date_created", $Method));
            $this->ip_insert = new clsControl(ccsLabel, "ip_insert", "ip_insert", ccsText, "", CCGetRequestParam("ip_insert", $Method));
            $this->ip_update = new clsControl(ccsLabel, "ip_update", "ip_update", ccsText, "", CCGetRequestParam("ip_update", $Method));
            $this->newsletter = new clsControl(ccsListBox, "newsletter", "newsletter", ccsInteger, "", CCGetRequestParam("newsletter", $Method));
            $this->newsletter->DSType = dsListOfValues;
            $this->newsletter->Values = array(array("1", "Subscribed"), array("0", "Unsubscribed"));
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            if(!strlen($this->user_id->Value) && $this->user_id->Value !== false)
                $this->user_id->SetValue("Will be Filled by Computer");
            if(!strlen($this->date_created->Value) && $this->date_created->Value !== false)
                $this->date_created->SetValue("Will Be Filled by Computer");
            if(!strlen($this->ip_insert->Value) && $this->ip_insert->Value !== false)
                $this->ip_insert->SetValue("Will Be Filled by Computer");
            if(!strlen($this->ip_update->Value) && $this->ip_update->Value !== false)
                $this->ip_update->SetValue("Will Be Filled by Computer");
        }
    }
//End Class_Initialize Event

//Initialize Method @2-C016A25E
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urluser_id"] = CCGetFromGet("user_id", "");
    }
//End Initialize Method

//Validate Method @2-E238E11E
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->user_id->Validate() && $Validation);
        $Validation = ($this->status->Validate() && $Validation);
        $Validation = ($this->user_login->Validate() && $Validation);
        $Validation = ($this->user_password->Validate() && $Validation);
        $Validation = ($this->first_name->Validate() && $Validation);
        $Validation = ($this->last_name->Validate() && $Validation);
        $Validation = ($this->email->Validate() && $Validation);
        $Validation = ($this->address1->Validate() && $Validation);
        $Validation = ($this->address2->Validate() && $Validation);
        $Validation = ($this->city->Validate() && $Validation);
        $Validation = ($this->state_id->Validate() && $Validation);
        $Validation = ($this->zip->Validate() && $Validation);
        $Validation = ($this->tokens->Validate() && $Validation);
        $Validation = ($this->country_id->Validate() && $Validation);
        $Validation = ($this->phone_day->Validate() && $Validation);
        $Validation = ($this->phone_evn->Validate() && $Validation);
        $Validation = ($this->fax->Validate() && $Validation);
        $Validation = ($this->age->Validate() && $Validation);
        $Validation = ($this->gender->Validate() && $Validation);
        $Validation = ($this->education->Validate() && $Validation);
        $Validation = ($this->income->Validate() && $Validation);
        $Validation = ($this->date_created->Validate() && $Validation);
        $Validation = ($this->ip_insert->Validate() && $Validation);
        $Validation = ($this->ip_update->Validate() && $Validation);
        $Validation = ($this->newsletter->Validate() && $Validation);
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
        $Redirect = "ListUsers.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","ccsForm","user_id"));
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
        $this->ds->user_id->SetValue("");
        $this->ds->status->SetValue($this->status->GetValue());
        $this->ds->user_login->SetValue($this->user_login->GetValue());
        $this->ds->user_password->SetValue($this->user_password->GetValue());
        $this->ds->first_name->SetValue($this->first_name->GetValue());
        $this->ds->last_name->SetValue($this->last_name->GetValue());
        $this->ds->email->SetValue($this->email->GetValue());
        $this->ds->address1->SetValue($this->address1->GetValue());
        $this->ds->address2->SetValue($this->address2->GetValue());
        $this->ds->city->SetValue($this->city->GetValue());
        $this->ds->state_id->SetValue($this->state_id->GetValue());
        $this->ds->zip->SetValue($this->zip->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->country_id->SetValue($this->country_id->GetValue());
        $this->ds->phone_day->SetValue($this->phone_day->GetValue());
        $this->ds->phone_evn->SetValue($this->phone_evn->GetValue());
        $this->ds->fax->SetValue($this->fax->GetValue());
        $this->ds->age->SetValue($this->age->GetValue());
        $this->ds->gender->SetValue($this->gender->GetValue());
        $this->ds->education->SetValue($this->education->GetValue());
        $this->ds->income->SetValue($this->income->GetValue());
        $this->ds->date_created->SetValue(time());
        $this->ds->ip_insert->SetValue(getenv("REMOTE_ADDR"));
        $this->ds->ip_update->SetValue(getenv("REMOTE_ADDR"));
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
        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->status->SetValue($this->status->GetValue());
        $this->ds->user_login->SetValue($this->user_login->GetValue());
        $this->ds->user_password->SetValue($this->user_password->GetValue());
        $this->ds->first_name->SetValue($this->first_name->GetValue());
        $this->ds->last_name->SetValue($this->last_name->GetValue());
        $this->ds->email->SetValue($this->email->GetValue());
        $this->ds->address1->SetValue($this->address1->GetValue());
        $this->ds->address2->SetValue($this->address2->GetValue());
        $this->ds->city->SetValue($this->city->GetValue());
        $this->ds->state_id->SetValue($this->state_id->GetValue());
        $this->ds->zip->SetValue($this->zip->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->country_id->SetValue($this->country_id->GetValue());
        $this->ds->phone_day->SetValue($this->phone_day->GetValue());
        $this->ds->phone_evn->SetValue($this->phone_evn->GetValue());
        $this->ds->fax->SetValue($this->fax->GetValue());
        $this->ds->age->SetValue($this->age->GetValue());
        $this->ds->gender->SetValue($this->gender->GetValue());
        $this->ds->education->SetValue($this->education->GetValue());
        $this->ds->income->SetValue($this->income->GetValue());
        //$this->ds->date_created->SetValue($this->date_created->GetValue());
        //$this->ds->ip_insert->SetValue($this->ip_insert->GetValue());
        //$this->ds->ip_update->SetValue($this->ip_update->GetValue());
        $this->ds->newsletter->SetValue($this->newsletter->GetValue());
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

        $this->status->Prepare();
        $this->country_id->Prepare();
        $this->age->Prepare();
        $this->gender->Prepare();
        $this->education->Prepare();
        $this->income->Prepare();
        $this->newsletter->Prepare();

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
                    $this->user_id->SetValue($this->ds->user_id->GetValue());
                    $this->date_created->SetValue(date("F j, Y, g:i a", $this->ds->date_created->GetValue()));
                    $this->ip_insert->SetValue($this->ds->ip_insert->GetValue());
                    $this->ip_update->SetValue($this->ds->ip_update->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->status->SetValue($this->ds->status->GetValue());
                        $this->user_login->SetValue($this->ds->user_login->GetValue());
                        $this->user_password->SetValue($this->ds->user_password->GetValue());
                        $this->first_name->SetValue($this->ds->first_name->GetValue());
                        $this->last_name->SetValue($this->ds->last_name->GetValue());
                        $this->email->SetValue($this->ds->email->GetValue());
                        $this->address1->SetValue($this->ds->address1->GetValue());
                        $this->address2->SetValue($this->ds->address2->GetValue());
                        $this->city->SetValue($this->ds->city->GetValue());
                        $this->state_id->SetValue($this->ds->state_id->GetValue());
                        $this->zip->SetValue($this->ds->zip->GetValue());
                        $this->tokens->SetValue($this->ds->tokens->GetValue());
                        $this->country_id->SetValue($this->ds->country_id->GetValue());
                        $this->phone_day->SetValue($this->ds->phone_day->GetValue());
                        $this->phone_evn->SetValue($this->ds->phone_evn->GetValue());
                        $this->fax->SetValue($this->ds->fax->GetValue());
                        $this->age->SetValue($this->ds->age->GetValue());
                        $this->gender->SetValue($this->ds->gender->GetValue());
                        $this->education->SetValue($this->ds->education->GetValue());
                        $this->income->SetValue($this->ds->income->GetValue());
                        $this->newsletter->SetValue($this->ds->newsletter->GetValue());
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
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->status->Errors->ToString();
            $Error .= $this->user_login->Errors->ToString();
            $Error .= $this->user_password->Errors->ToString();
            $Error .= $this->first_name->Errors->ToString();
            $Error .= $this->last_name->Errors->ToString();
            $Error .= $this->email->Errors->ToString();
            $Error .= $this->address1->Errors->ToString();
            $Error .= $this->address2->Errors->ToString();
            $Error .= $this->city->Errors->ToString();
            $Error .= $this->state_id->Errors->ToString();
            $Error .= $this->zip->Errors->ToString();
            $Error .= $this->tokens->Errors->ToString();
            $Error .= $this->country_id->Errors->ToString();
            $Error .= $this->phone_day->Errors->ToString();
            $Error .= $this->phone_evn->Errors->ToString();
            $Error .= $this->fax->Errors->ToString();
            $Error .= $this->age->Errors->ToString();
            $Error .= $this->gender->Errors->ToString();
            $Error .= $this->education->Errors->ToString();
            $Error .= $this->income->Errors->ToString();
            $Error .= $this->date_created->Errors->ToString();
            $Error .= $this->ip_insert->Errors->ToString();
            $Error .= $this->ip_update->Errors->ToString();
            $Error .= $this->newsletter->Errors->ToString();
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
        $this->user_id->Show();
        $this->status->Show();
        $this->user_login->Show();
        $this->user_password->Show();
        $this->first_name->Show();
        $this->last_name->Show();
        $this->email->Show();
        $this->address1->Show();
        $this->address2->Show();
        $this->city->Show();
        $this->state_id->Show();
        $this->zip->Show();
        $this->tokens->Show();
        $this->country_id->Show();
        $this->phone_day->Show();
        $this->phone_evn->Show();
        $this->fax->Show();
        $this->age->Show();
        $this->gender->Show();
        $this->education->Show();
        $this->income->Show();
        $this->date_created->Show();
        $this->ip_insert->Show();
        $this->ip_update->Show();
        $this->newsletter->Show();
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
    var $user_id;
    var $status;
    var $user_login;
    var $user_password;
    var $first_name;
    var $last_name;
    var $email;
    var $address1;
    var $address2;
    var $city;
    var $state_id;
    var $zip;
    var $tokens;
    var $country_id;
    var $phone_day;
    var $phone_evn;
    var $fax;
    var $age;
    var $gender;
    var $education;
    var $income;
    var $date_created;
    var $ip_insert;
    var $ip_update;
    var $newsletter;
//End DataSource Variables

//Class_Initialize Event @2-2A41CF3B
    function clsusersDataSource()
    {
        $this->Initialize();
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->status = new clsField("status", ccsInteger, "");
        $this->user_login = new clsField("user_login", ccsText, "");
        $this->user_password = new clsField("user_password", ccsText, "");
        $this->first_name = new clsField("first_name", ccsText, "");
        $this->last_name = new clsField("last_name", ccsText, "");
        $this->email = new clsField("email", ccsText, "");
        $this->address1 = new clsField("address1", ccsText, "");
        $this->address2 = new clsField("address2", ccsText, "");
        $this->city = new clsField("city", ccsText, "");
        $this->state_id = new clsField("state_id", ccsText, "");
        $this->zip = new clsField("zip", ccsText, "");
        $this->tokens = new clsField("zip", ccsInteger, "");
        $this->country_id = new clsField("country_id", ccsInteger, "");
        $this->phone_day = new clsField("phone_day", ccsText, "");
        $this->phone_evn = new clsField("phone_evn", ccsText, "");
        $this->fax = new clsField("fax", ccsText, "");
        $this->age = new clsField("age", ccsInteger, "");
        $this->gender = new clsField("gender", ccsInteger, "");
        $this->education = new clsField("education", ccsInteger, "");
        $this->income = new clsField("income", ccsInteger, "");
        $this->date_created = new clsField("date_created", ccsText, "");
        $this->ip_insert = new clsField("ip_insert", ccsText, "");
        $this->ip_update = new clsField("ip_update", ccsText, "");
        $this->newsletter = new clsField("newsletter", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-4CE37742
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`user_id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-DC1AA46D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM users";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-D67CC77D
    function SetValues()
    {
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->status->SetDBValue($this->f("status"));
        $this->user_login->SetDBValue($this->f("user_login"));
        $this->user_password->SetDBValue($this->f("user_password"));
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->email->SetDBValue($this->f("email"));
        $this->address1->SetDBValue($this->f("address1"));
        $this->address2->SetDBValue($this->f("address2"));
        $this->city->SetDBValue($this->f("city"));
        $this->state_id->SetDBValue($this->f("state_id"));
        $this->zip->SetDBValue($this->f("zip"));
        $this->tokens->SetDBValue($this->f("tokens"));
        $this->country_id->SetDBValue($this->f("country_id"));
        $this->phone_day->SetDBValue($this->f("phone_day"));
        $this->phone_evn->SetDBValue($this->f("phone_evn"));
        $this->fax->SetDBValue($this->f("fax"));
        $this->age->SetDBValue($this->f("age"));
        $this->gender->SetDBValue($this->f("gender"));
        $this->education->SetDBValue($this->f("education"));
        $this->income->SetDBValue($this->f("income"));
        $this->date_created->SetDBValue($this->f("date_created"));
        $this->ip_insert->SetDBValue($this->f("ip_insert"));
        $this->ip_update->SetDBValue($this->f("ip_update"));
        $this->newsletter->SetDBValue($this->f("newsletter"));
    }
//End SetValues Method

//Insert Method @2-543151F3
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO `users` ("
             . "`status`, "
             . "`user_login`, "
             . "`user_password`, "
             . "`first_name`, "
             . "`last_name`, "
             . "`email`, "
             . "`address1`, "
             . "`address2`, "
             . "`city`, "
             . "`state_id`, "
             . "`zip`, "
             . "`tokens`, "
             . "`country_id`, "
             . "`phone_day`, "
             . "`phone_evn`, "
             . "`fax`, "
             . "`age`, "
             . "`gender`, "
             . "`education`, "
             . "`income`, "
             . "`newsletter`"
             . ") VALUES ("
             . $this->ToSQL($this->status->GetDBValue(), $this->status->DataType) . ", "
             . $this->ToSQL($this->user_login->GetDBValue(), $this->user_login->DataType) . ", "
             . $this->ToSQL($this->user_password->GetDBValue(), $this->user_password->DataType) . ", "
             . $this->ToSQL($this->first_name->GetDBValue(), $this->first_name->DataType) . ", "
             . $this->ToSQL($this->last_name->GetDBValue(), $this->last_name->DataType) . ", "
             . $this->ToSQL($this->email->GetDBValue(), $this->email->DataType) . ", "
             . $this->ToSQL($this->address1->GetDBValue(), $this->address1->DataType) . ", "
             . $this->ToSQL($this->address2->GetDBValue(), $this->address2->DataType) . ", "
             . $this->ToSQL($this->city->GetDBValue(), $this->city->DataType) . ", "
             . $this->ToSQL($this->state_id->GetDBValue(), $this->state_id->DataType) . ", "
             . $this->ToSQL($this->zip->GetDBValue(), $this->zip->DataType) . ", "
             . $this->ToSQL($this->tokens->GetDBValue(), $this->tokens->DataType) . ", "
             . $this->ToSQL($this->country_id->GetDBValue(), $this->country_id->DataType) . ", "
             . $this->ToSQL($this->phone_day->GetDBValue(), $this->phone_day->DataType) . ", "
             . $this->ToSQL($this->phone_evn->GetDBValue(), $this->phone_evn->DataType) . ", "
             . $this->ToSQL($this->fax->GetDBValue(), $this->fax->DataType) . ", "
             . $this->ToSQL($this->age->GetDBValue(), $this->age->DataType) . ", "
             . $this->ToSQL($this->gender->GetDBValue(), $this->gender->DataType) . ", "
             . $this->ToSQL($this->education->GetDBValue(), $this->education->DataType) . ", "
             . $this->ToSQL($this->income->GetDBValue(), $this->income->DataType) . ", "
             . $this->ToSQL($this->newsletter->GetDBValue(), $this->newsletter->DataType)
             . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

//Update Method @2-0139ACE1
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `users` SET "
             . "`status`=" . $this->ToSQL($this->status->GetDBValue(), $this->status->DataType) . ", "
             . "`user_login`=" . $this->ToSQL($this->user_login->GetDBValue(), $this->user_login->DataType) . ", "
             . "`user_password`=" . $this->ToSQL($this->user_password->GetDBValue(), $this->user_password->DataType) . ", "
             . "`first_name`=" . $this->ToSQL($this->first_name->GetDBValue(), $this->first_name->DataType) . ", "
             . "`last_name`=" . $this->ToSQL($this->last_name->GetDBValue(), $this->last_name->DataType) . ", "
             . "`email`=" . $this->ToSQL($this->email->GetDBValue(), $this->email->DataType) . ", "
             . "`address1`=" . $this->ToSQL($this->address1->GetDBValue(), $this->address1->DataType) . ", "
             . "`address2`=" . $this->ToSQL($this->address2->GetDBValue(), $this->address2->DataType) . ", "
             . "`city`=" . $this->ToSQL($this->city->GetDBValue(), $this->city->DataType) . ", "
             . "`state_id`=" . $this->ToSQL($this->state_id->GetDBValue(), $this->state_id->DataType) . ", "
             . "`zip`=" . $this->ToSQL($this->zip->GetDBValue(), $this->zip->DataType) . ", "
             . "`tokens`=" . $this->ToSQL($this->tokens->GetDBValue(), $this->tokens->DataType) . ", "
             . "`country_id`=" . $this->ToSQL($this->country_id->GetDBValue(), $this->country_id->DataType) . ", "
             . "`phone_day`=" . $this->ToSQL($this->phone_day->GetDBValue(), $this->phone_day->DataType) . ", "
             . "`phone_evn`=" . $this->ToSQL($this->phone_evn->GetDBValue(), $this->phone_evn->DataType) . ", "
             . "`fax`=" . $this->ToSQL($this->fax->GetDBValue(), $this->fax->DataType) . ", "
             . "`age`=" . $this->ToSQL($this->age->GetDBValue(), $this->age->DataType) . ", "
             . "`gender`=" . $this->ToSQL($this->gender->GetDBValue(), $this->gender->DataType) . ", "
             . "`education`=" . $this->ToSQL($this->education->GetDBValue(), $this->education->DataType) . ", "
             . "`income`=" . $this->ToSQL($this->income->GetDBValue(), $this->income->DataType) . ", "
             . "`newsletter`=" . $this->ToSQL($this->newsletter->GetDBValue(), $this->newsletter->DataType);
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
        $SQL = "DELETE FROM `users` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
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

$FileName = "UserMaintanence.php";
$Redirect = "";
$TemplateFileName = "Themes/UserMaintanence.html";
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
