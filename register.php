<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");



//End Include Common Files

$page="Registering...";

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

include("./Header.php");

//End Include Page implementation



Class clsRecordusers { //users Class @4-811DFF64



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



//Class_Initialize Event @4-4D6706BC

    function clsRecordusers()

    {



        global $FileName;

        $this->Visible = true;

        $this->Errors = new clsErrors();

        $this->ds = new clsusersDataSource();

        $this->UpdateAllowed = false;

        $this->DeleteAllowed = false;

        if($this->Visible)

        {

            $this->ComponentName = "users";

            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);

            $CCSForm = CCGetFromGet("ccsForm", "");

            $this->FormSubmitted = ($CCSForm == $this->ComponentName);

            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

            $this->user_login = new clsControl(ccsTextBox, "user_login", " Login", ccsText, "", CCGetRequestParam("user_login", $Method));

            $this->user_login->Required = true;

            $this->email = new clsControl(ccsTextBox, "email", "Email", ccsText, "", CCGetRequestParam("email", $Method));

            $this->email->Required = true;

            $this->first_name = new clsControl(ccsTextBox, "first_name", "First Name", ccsText, "", CCGetRequestParam("first_name", $Method));

            $this->first_name->Required = true;

            $this->last_name = new clsControl(ccsTextBox, "last_name", "Last Name", ccsText, "", CCGetRequestParam("last_name", $Method));

            $this->last_name->Required = true;

            $this->address1 = new clsControl(ccsTextBox, "address1", "Address1", ccsText, "", CCGetRequestParam("address1", $Method));

            $this->address1->Required = true;

            $this->address2 = new clsControl(ccsTextBox, "address2", "Address2", ccsText, "", CCGetRequestParam("address2", $Method));

            $this->city = new clsControl(ccsTextBox, "city", "City", ccsText, "", CCGetRequestParam("city", $Method));

            $this->city->Required = true;

            $this->state_id = new clsControl(ccsTextBox, "state_id", "State", ccsText, "", CCGetRequestParam("state_id", $Method));

            $this->state_id->Required = true;

            $this->zip = new clsControl(ccsTextBox, "zip", "Zip", ccsText, "", CCGetRequestParam("zip", $Method));

            $this->zip->Required = true;

            $this->country_id = new clsControl(ccsListBox, "country_id", "Country Id", ccsInteger, "", CCGetRequestParam("country_id", $Method));

            $this->country_id_ds = new clsDBNetConnect();

            $this->country_id_ds->SQL = "SELECT *  " .

"FROM lookup_countries";

            $country_id_values = CCGetListValues($this->country_id_ds, $this->country_id_ds->SQL, $this->country_id_ds->Where, $this->country_id_ds->Order, "country_id", "country_desc");

            $this->country_id->Values = $country_id_values;

            $this->country_id->Required = true;

            $this->phone_day = new clsControl(ccsTextBox, "phone_day", "Phone Day", ccsText, "", CCGetRequestParam("phone_day", $Method));

            $this->phone_evn = new clsControl(ccsTextBox, "phone_evn", "Phone Evn", ccsText, "", CCGetRequestParam("phone_evn", $Method));

            $this->fax = new clsControl(ccsTextBox, "fax", "Fax", ccsText, "", CCGetRequestParam("fax", $Method));

            $this->age = new clsControl(ccsListBox, "age", "Age", ccsInteger, "", CCGetRequestParam("age", $Method));

            $this->age_ds = new clsDBNetConnect();

            $this->age_ds->SQL = "SELECT *  " .

"FROM lookup_ages";

            $age_values = CCGetListValues($this->age_ds, $this->age_ds->SQL, $this->age_ds->Where, $this->age_ds->Order, "age_id", "age_desc");

            $this->age->Values = $age_values;

			global $now;

			if ($now["bounceout"])

		$this->age->Required = true;

			

            $this->gender = new clsControl(ccsListBox, "gender", "Gender", ccsInteger, "", CCGetRequestParam("gender", $Method));

            $this->gender_ds = new clsDBNetConnect();

            $this->gender_ds->SQL = "SELECT *  " .

"FROM lookup_genders";

            $gender_values = CCGetListValues($this->gender_ds, $this->gender_ds->SQL, $this->gender_ds->Where, $this->gender_ds->Order, "gender_id", "gender_desc");

            $this->gender->Values = $gender_values;

            $this->education = new clsControl(ccsListBox, "education", "Education", ccsInteger, "", CCGetRequestParam("education", $Method));

            $this->education_ds = new clsDBNetConnect();

            $this->education_ds->SQL = "SELECT *  " .

"FROM lookup_educations";

            $education_values = CCGetListValues($this->education_ds, $this->education_ds->SQL, $this->education_ds->Where, $this->education_ds->Order, "education_id", "education_desc");

            $this->education->Values = $education_values;

            $this->income = new clsControl(ccsListBox, "income", "Income", ccsInteger, "", CCGetRequestParam("income", $Method));

            $this->income_ds = new clsDBNetConnect();

            $this->income_ds->SQL = "SELECT *  " .

"FROM lookup_incomes";

            $income_values = CCGetListValues($this->income_ds, $this->income_ds->SQL, $this->income_ds->Where, $this->income_ds->Order, "income_id", "income_desc");

            $this->income->Values = $income_values;

            $this->newsletter = new clsControl(ccsListBox, "newsletter", "Newsletter", ccsInteger, "", CCGetRequestParam("newsletter", $Method));

            $newsletter_values = array(array("0", "No Thanks"), array("1", "Yes Please"));

            $this->newsletter->Values = $newsletter_values;

            $this->agreement_id = new clsControl(ccsCheckBox, "agreement_id", "The Terms & Agreement", ccsInteger, "", CCGetRequestParam("agreement_id", $Method));







            $this->agreement_id->Required = true;

            $this->agreement_id->CheckedValue = 1;

            $this->agreement_id->UncheckedValue = 0;

            $this->Insert = new clsButton("Insert");

            $this->user_password = new clsControl(ccsHidden, "user_password", " Password", ccsText, "", CCGetRequestParam("user_password", $Method));

            $this->user_password->Required = true;

            $this->date_created = new clsControl(ccsHidden, "date_created", "Date Created", ccsInteger, "", CCGetRequestParam("date_created", $Method));

            $this->ip_insert = new clsControl(ccsHidden, "ip_insert", "Ip Insert", ccsText, "", CCGetRequestParam("ip_insert", $Method));

            $this->ip_update = new clsControl(ccsHidden, "ip_update", "Ip Update", ccsText, "", CCGetRequestParam("ip_update", $Method));

            $this->status = new clsControl(ccsHidden, "status", "Status", ccsInteger, "", CCGetRequestParam("status", $Method));

            if(!$this->FormSubmitted) {

                if(!strlen($this->age->GetValue()))

                    $this->age->SetValue(0);

                if(!strlen($this->gender->GetValue()))

                    $this->gender->SetValue(0);

                if(!strlen($this->education->GetValue()))

                    $this->education->SetValue(0);

                if(!strlen($this->income->GetValue()))

                    $this->income->SetValue(0);

                if(!strlen($this->newsletter->GetValue()))

                    $this->newsletter->SetValue(1);

            }

        }

    }

//End Class_Initialize Event



//Initialize Method @4-C016A25E

    function Initialize()

    {



        if(!$this->Visible)

            return;



        $this->ds->Parameters["urluser_id"] = CCGetFromGet("user_id", "");

    }

//End Initialize Method



//Validate Method @4-97B30139

    function Validate()

    {

        global $now;

        $Validation = true;

        $Where = "";

        $ckdb = new clsDBNetConnect;

        $ckdb->connect();

        if($this->EditMode)

            $Where = " AND NOT (" . $this->ds->Where . ")";

        if(CCDLookUp("COUNT(*)", "users", "user_login=" . $this->ds->ToSQL($this->user_login->GetValue(), $this->user_login->DataType) . $Where, $this->ds) > 0)

            $this->user_login->Errors->addError("The Username <b>\"" . $this->user_login->GetValue() . "\"</b> is already taken.");

        if(CCDLookUp("COUNT(*)", "users", "email=" . $this->ds->ToSQL($this->email->GetValue(), $this->email->DataType) . $Where, $this->ds) > 0)

            $this->email->Errors->addError("The Email Address <b>\"" . $this->email->GetValue() . "\"</b> is in use by another member.");







        if($now["bounceout"] == 1)

        {

		if($this->age->GetValue() == $now["bouceout_id"])

		{

			header("location: ./index.php");

			exit;

		}

        }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");



        $Validation = ($this->user_login->Validate() && $Validation);

        $Validation = ($this->email->Validate() && $Validation);

        $Validation = ($this->first_name->Validate() && $Validation);

        $Validation = ($this->last_name->Validate() && $Validation);

        $Validation = ($this->address1->Validate() && $Validation);

        $Validation = ($this->address2->Validate() && $Validation);

        $Validation = ($this->city->Validate() && $Validation);

        $Validation = ($this->state_id->Validate() && $Validation);

        $Validation = ($this->zip->Validate() && $Validation);

        $Validation = ($this->country_id->Validate() && $Validation);

        $Validation = ($this->phone_day->Validate() && $Validation);

        $Validation = ($this->phone_evn->Validate() && $Validation);

        $Validation = ($this->fax->Validate() && $Validation);

        $Validation = ($this->age->Validate() && $Validation);

        //$Validation = ($this->gender->Validate() && $Validation);

        //$Validation = ($this->education->Validate() && $Validation);

        //$Validation = ($this->income->Validate() && $Validation);

        //$Validation = ($this->newsletter->Validate() && $Validation);

        //$Validation = ($this->newstype->Validate() && $Validation);

        $Validation = ($this->agreement_id->Validate() && $Validation);

        //$Validation = ($this->user_password->Validate() && $Validation);

        //$Validation = ($this->date_created->Validate() && $Validation);

        //$Validation = ($this->ip_insert->Validate() && $Validation);

        //$Validation = ($this->ip_update->Validate() && $Validation);

        //$Validation = ($this->status->Validate() && $Validation);



        return (($this->Errors->Count() == 0) && $Validation);

    }

//End Validate Method



//Operation Method @4-9BC51AEF

    function Operation()

    {

        global $Redirect;



        $this->ds->Prepare();

        $this->EditMode = $this->ds->AllParametersSet;

        if(!($this->Visible && $this->FormSubmitted))

            return;



        if($this->FormSubmitted) {

            $this->PressedButton = "Insert";

            if(strlen(CCGetParam("Insert", ""))) {

                $this->PressedButton = "Insert";

            }

        }

        $Redirect = "registrationcomplete.php?" . CCGetQueryString("Form", Array("Insert","ccsForm"));

        if($this->Validate()) {

            if($this->PressedButton == "Insert") {

                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {

                    $Redirect = "";

                }

            }

        } else {

            $Redirect = "";

        }

    }

//End Operation Method



//InsertRow Method @4-D3B72F8D

    function InsertRow()

    {

        GLOBAL $NewPass;

        GLOBAL $_SERVER;



                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");

        $this->ds->user_login->SetValue($this->user_login->GetValue());

        $this->ds->email->SetValue($this->email->GetValue());

        $this->ds->first_name->SetValue($this->first_name->GetValue());

        $this->ds->last_name->SetValue($this->last_name->GetValue());

        $this->ds->address1->SetValue($this->address1->GetValue());

        $this->ds->address2->SetValue($this->address2->GetValue());

        $this->ds->city->SetValue($this->city->GetValue());

        $this->ds->state_id->SetValue($this->state_id->GetValue());

        $this->ds->zip->SetValue($this->zip->GetValue());

        $this->ds->country_id->SetValue($this->country_id->GetValue());

        $this->ds->phone_day->SetValue($this->phone_day->GetValue());

        $this->ds->phone_evn->SetValue($this->phone_evn->GetValue());

        $this->ds->fax->SetValue($this->fax->GetValue());

		

        $this->ds->age->SetValue($this->age->GetValue());

        $this->ds->gender->SetValue($this->gender->GetValue());

        $this->ds->education->SetValue($this->education->GetValue());

        $this->ds->income->SetValue($this->income->GetValue());

        $this->ds->newsletter->SetValue($this->newsletter->GetValue());

        $this->ds->agreement_id->SetValue($this->agreement_id->GetValue());

        $this->ds->status->SetValue($this->status->GetValue());

        $this->ds->user_password->SetValue(SecurePass());

        $NewPass = $this->ds->user_password->Value;

        $this->ds->date_created->SetValue(time());

        $this->ds->ip_insert->SetValue($_SERVER["REMOTE_ADDR"]);

                $this->ds->ip_update->SetValue($_SERVER["REMOTE_ADDR"]);

        $this->ds->status->SetValue(1);

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



//Show Method @4-236DDAF2

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

                    echo "Error in Record users";

                }

                else if($this->ds->next_record())

                {

                    $this->ds->SetValues();

                    if(!$this->FormSubmitted)

                    {

                        $this->user_login->SetValue($this->ds->user_login->GetValue());

                        $this->email->SetValue($this->ds->email->GetValue());

                        $this->first_name->SetValue($this->ds->first_name->GetValue());

                        $this->last_name->SetValue($this->ds->last_name->GetValue());

                        $this->address1->SetValue($this->ds->address1->GetValue());

                        $this->address2->SetValue($this->ds->address2->GetValue());

                        $this->city->SetValue($this->ds->city->GetValue());

                        $this->state_id->SetValue($this->ds->state_id->GetValue());

                        $this->zip->SetValue($this->ds->zip->GetValue());

                        $this->country_id->SetValue($this->ds->country_id->GetValue());

                        $this->phone_day->SetValue($this->ds->phone_day->GetValue());

                        $this->phone_evn->SetValue($this->ds->phone_evn->GetValue());

                        $this->fax->SetValue($this->ds->fax->GetValue());

						

                        $this->age->SetValue($this->ds->age->GetValue());

                        $this->gender->SetValue($this->ds->gender->GetValue());

                        $this->education->SetValue($this->ds->education->GetValue());

                        $this->income->SetValue($this->ds->income->GetValue());

                        $this->newsletter->SetValue($this->ds->newsletter->GetValue());

                        $this->agreement_id->SetValue($this->ds->agreement_id->GetValue());

                        $this->user_password->SetValue($this->ds->user_password->GetValue());

                        $this->date_created->SetValue($this->ds->date_created->GetValue());

                        $this->ip_insert->SetValue($this->ds->ip_insert->GetValue());

                        $this->ip_update->SetValue($this->ds->ip_update->GetValue());

                        $this->status->SetValue($this->ds->status->GetValue());

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

            $Error .= $this->user_login->Errors->ToString();

            $Error .= $this->email->Errors->ToString();

            $Error .= $this->first_name->Errors->ToString();

            $Error .= $this->last_name->Errors->ToString();

            $Error .= $this->address1->Errors->ToString();

            $Error .= $this->address2->Errors->ToString();

            $Error .= $this->city->Errors->ToString();

            $Error .= $this->state_id->Errors->ToString();

            $Error .= $this->zip->Errors->ToString();

            $Error .= $this->country_id->Errors->ToString();

            $Error .= $this->phone_day->Errors->ToString();

            $Error .= $this->phone_evn->Errors->ToString();

            $Error .= $this->fax->Errors->ToString();

			

            $Error .= $this->age->Errors->ToString();

            $Error .= $this->gender->Errors->ToString();

            $Error .= $this->education->Errors->ToString();

            $Error .= $this->income->Errors->ToString();

            $Error .= $this->newsletter->Errors->ToString();

            $Error .= $this->agreement_id->Errors->ToString();

            $Error .= $this->user_password->Errors->ToString();

            $Error .= $this->date_created->Errors->ToString();

            $Error .= $this->ip_insert->Errors->ToString();

            $Error .= $this->ip_update->Errors->ToString();

            $Error .= $this->status->Errors->ToString();

            $Error .= $this->Errors->ToString();

            $Error .= $this->ds->Errors->ToString();

            $Tpl->SetVar("Error", $Error);

            $Tpl->Parse("Error", false);

        }

        $Tpl->SetVar("Action", $this->HTMLFormAction);

        $this->Insert->Visible = !$this->EditMode;

        $this->user_login->Show();

        $this->email->Show();

        $this->first_name->Show();

        $this->last_name->Show();

        $this->address1->Show();

        $this->address2->Show();

        $this->city->Show();

        $this->state_id->Show();

        $this->zip->Show();

        $this->country_id->Show();

        $this->phone_day->Show();

        $this->phone_evn->Show();

        $this->fax->Show();

		

        $this->age->Show();

        $this->gender->Show();

        $this->education->Show();

        $this->income->Show();

        $this->newsletter->Show();

        $this->agreement_id->Show();

        $this->Insert->Show();

        $this->user_password->Show();

        $this->date_created->Show();

        $this->ip_insert->Show();

        $this->ip_update->Show();

        $this->status->Show();

        $Tpl->parse("", false);

        $Tpl->block_path = "";

    }

//End Show Method



} //End users Class @4-FCB6E20C



class clsusersDataSource extends clsDBNetConnect {  //usersDataSource Class @4-B3FBEB6D



//Variables @4-E7DEC5BA

    var $CCSEvents = "";

    var $CCSEventResult;



    var $InsertParameters;

    var $wp;

    var $AllParametersSet;



    // Datasource fields

    var $user_login;

    var $email;

    var $first_name;

    var $last_name;

    var $address1;

    var $address2;

    var $city;

    var $state_id;

    var $zip;

    var $country_id;

    var $phone_day;

    var $phone_evn;

    var $fax;

	

    var $age;

    var $gender;

    var $education;

    var $income;

    var $newsletter;

    var $agreement_id;

    var $user_password;

    var $date_created;

    var $ip_insert;

    var $ip_update;

    var $status;

//End Variables



//Class_Initialize Event @4-9F42335A

    function clsusersDataSource()

    {

        $this->Initialize();

        $this->user_login = new clsField("user_login", ccsText, "");

        $this->email = new clsField("email", ccsText, "");

        $this->first_name = new clsField("first_name", ccsText, "");

        $this->last_name = new clsField("last_name", ccsText, "");

        $this->address1 = new clsField("address1", ccsText, "");

        $this->address2 = new clsField("address2", ccsText, "");

        $this->city = new clsField("city", ccsText, "");

        $this->state_id = new clsField("state_id", ccsText, "");

        $this->zip = new clsField("zip", ccsText, "");

        $this->country_id = new clsField("country_id", ccsInteger, "");

        $this->phone_day = new clsField("phone_day", ccsText, "");

        $this->phone_evn = new clsField("phone_evn", ccsText, "");

        $this->fax = new clsField("fax", ccsText, "");

		

        $this->age = new clsField("age", ccsInteger, "");

        $this->gender = new clsField("gender", ccsInteger, "");

        $this->education = new clsField("education", ccsInteger, "");

        $this->income = new clsField("income", ccsInteger, "");

        $this->newsletter = new clsField("newsletter", ccsInteger, "");

        $this->agreement_id = new clsField("agreement_id", ccsInteger, "");

        $this->user_password = new clsField("user_password", ccsText, "");

        $this->date_created = new clsField("date_created", ccsInteger, "");

        $this->ip_insert = new clsField("ip_insert", ccsText, "");

        $this->ip_update = new clsField("ip_update", ccsText, "");

        $this->status = new clsField("status", ccsInteger, "");



    }

//End Class_Initialize Event



//Prepare Method @4-3B0878A8

    function Prepare()

    {

        $this->wp = new clsSQLParameters();

        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "");

        $this->AllParametersSet = $this->wp->AllParamsSet();

        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));

        $this->wp->AssembledWhere = $this->wp->Criterion[1];

        $this->Where = $this->wp->AssembledWhere;

    }

//End Prepare Method



//Open Method @4-DC1AA46D

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



//SetValues Method @4-99BD6FDD

    function SetValues()

    {

        $this->user_login->SetDBValue($this->f("user_login"));

        $this->email->SetDBValue($this->f("email"));

        $this->first_name->SetDBValue($this->f("first_name"));

        $this->last_name->SetDBValue($this->f("last_name"));

        $this->address1->SetDBValue($this->f("address1"));

        $this->address2->SetDBValue($this->f("address2"));

        $this->city->SetDBValue($this->f("city"));

        $this->state_id->SetDBValue($this->f("state_id"));

        $this->zip->SetDBValue($this->f("zip"));

        $this->country_id->SetDBValue($this->f("country_id"));

        $this->phone_day->SetDBValue($this->f("phone_day"));

        $this->phone_evn->SetDBValue($this->f("phone_evn"));

        $this->fax->SetDBValue($this->f("fax"));

		

        $this->age->SetDBValue($this->f("age"));

        $this->gender->SetDBValue($this->f("gender"));

        $this->education->SetDBValue($this->f("education"));

        $this->income->SetDBValue($this->f("income"));

        $this->newsletter->SetDBValue($this->f("newsletter"));

        $this->agreement_id->SetDBValue($this->f("agreement_id"));

        $this->user_password->SetDBValue($this->f("user_password"));

        $this->date_created->SetDBValue($this->f("date_created"));

        $this->ip_insert->SetDBValue($this->f("ip_insert"));

        $this->ip_update->SetDBValue($this->f("ip_update"));

        $this->status->SetDBValue($this->f("status"));

    }

//End SetValues Method



//Insert Method @4-B9A4F019

    function Insert()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");

        $SQL = "INSERT INTO users(" .

            "user_login, " .

            "email, " .

            "first_name, " .

            "last_name, " .

            "address1, " .

            "address2, " .

            "city, " .

            "state_id, " .

            "zip, " .

            "country_id, " .

            "phone_day, " .

            "phone_evn, " .

            "fax, " .

		"age, " .

            "gender, " .

            "education, " .

            "income, " .

            "newsletter, " .

            "agreement_id, " .

            "user_password, " .

            "date_created, " .

            "ip_insert, " .

            "ip_update, " .

            "status" .

        ") VALUES (" .

            $this->ToSQL($this->user_login->DBValue, $this->user_login->DataType) . ", " .

            $this->ToSQL($this->email->DBValue, $this->email->DataType) . ", " .

            $this->ToSQL($this->first_name->DBValue, $this->first_name->DataType) . ", " .

            $this->ToSQL($this->last_name->DBValue, $this->last_name->DataType) . ", " .

            $this->ToSQL($this->address1->DBValue, $this->address1->DataType) . ", " .

            $this->ToSQL($this->address2->DBValue, $this->address2->DataType) . ", " .

            $this->ToSQL($this->city->DBValue, $this->city->DataType) . ", " .

            $this->ToSQL($this->state_id->DBValue, $this->state_id->DataType) . ", " .

            $this->ToSQL($this->zip->DBValue, $this->zip->DataType) . ", " .

            $this->ToSQL($this->country_id->DBValue, $this->country_id->DataType) . ", " .

            $this->ToSQL($this->phone_day->DBValue, $this->phone_day->DataType) . ", " .

            $this->ToSQL($this->phone_evn->DBValue, $this->phone_evn->DataType) . ", " .

            $this->ToSQL($this->fax->DBValue, $this->fax->DataType) . ", " .

		$this->ToSQL($this->age->DBValue, $this->age->DataType) . ", " .

            $this->ToSQL($this->gender->DBValue, $this->gender->DataType) . ", " .

            $this->ToSQL($this->education->DBValue, $this->education->DataType) . ", " .

            $this->ToSQL($this->income->DBValue, $this->income->DataType) . ", " .

            $this->ToSQL($this->newsletter->DBValue, $this->newsletter->DataType) . ", " .

            $this->ToSQL($this->agreement_id->DBValue, $this->agreement_id->DataType) . ", " .

            $this->ToSQL($this->user_password->DBValue, $this->user_password->DataType) . ", " .

            $this->ToSQL($this->date_created->DBValue, $this->date_created->DataType) . ", " .

            $this->ToSQL($this->ip_insert->DBValue, $this->ip_insert->DataType) . ", " .

            $this->ToSQL($this->ip_update->DBValue, $this->ip_update->DataType) . ", " .

            $this->ToSQL($this->status->DBValue, $this->status->DataType) .

        ")";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

		$new_id = mysql_insert_id();

		$query = "insert into groups_users (`user_id`,`group_id`) values ('" . $new_id . "', '1')";

		$group = new clsDBNetConnect;

		$group->query($query);

    }

//End Insert Method



} //End usersDataSource Class @4-FCB6E20C



//Include Page implementation @3-353B2997

include("./Footer.php");

//End Include Page implementation



//Initialize Page @1-0339229D

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



$FileName = "register.php";

$Redirect = "";

$TemplateFileName = "templates/register.html";

$BlockToParse = "main";

$PathToRoot = "./";

//End Initialize Page



//Initialize Objects @1-92FF94A7



// Controls

$Header = new clsHeader();

$Header->BindEvents();

$Header->TemplatePath = "./";

$Header->Initialize();

$users = new clsRecordusers();

$Footer = new clsFooter();

$Footer->BindEvents();

$Footer->TemplatePath = "./";

$Footer->Initialize();

$users->Initialize();



// Events

include("./register_events.php");

BindEvents();



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
include './Lang/lang_class.php';
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

