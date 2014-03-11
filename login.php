<?php
include("Common.php");
define("RelativePath", ".");

include(RelativePath . "/Template.php");

include(RelativePath . "/Sorter.php");

include(RelativePath . "/Navigator.php");







//End Include Common Files



$page="Logging In...";



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



//Include Page implementation @7-503267A8



include("./Header.php");



//End Include Page implementation







Class clsRecordLogin { //Login Class @2-426E3B84







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







//Class_Initialize Event @2-9A07FF18



    function clsRecordLogin()



    {







        global $FileName;



        $this->Visible = true;



        $this->Errors = new clsErrors();



        $this->InsertAllowed = false;



        $this->UpdateAllowed = false;



        $this->DeleteAllowed = false;



        if($this->Visible)



        {



            $this->ComponentName = "Login";



            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);



            $CCSForm = CCGetFromGet("ccsForm", "");



            $this->FormSubmitted = ($CCSForm == $this->ComponentName);



            $Method = $this->FormSubmitted ? ccsPost : ccsGet;



            $this->login = new clsControl(ccsTextBox, "login", "login", ccsText, "", CCGetRequestParam("login", $Method));



            $this->login->Required = true;



            $this->password = new clsControl(ccsTextBox, "password", "password", ccsText, "", CCGetRequestParam("password", $Method));



            $this->password->Required = true;



            $this->DoLogin = new clsButton("DoLogin");



        }



    }



//End Class_Initialize Event







//Validate Method @2-FCD4B6B1



    function Validate()



    {



        $Validation = true;



        $Where = "";



        $Validation = ($this->login->Validate() && $Validation);



        $Validation = ($this->password->Validate() && $Validation);



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");



        return (($this->Errors->Count() == 0) && $Validation);



    }



//End Validate Method







//Operation Method @2-B1A67E69



    function Operation()



    {



        global $Redirect;







        $this->EditMode = false;



        if(!($this->Visible && $this->FormSubmitted))



            return;







        if($this->FormSubmitted) {



            $this->PressedButton = "DoLogin";



            if(strlen(CCGetParam("DoLogin", ""))) {



                $this->PressedButton = "DoLogin";



            }



        }



        $Redirect = "myaccount.php";



        if($this->Validate()) {



            if($this->PressedButton == "DoLogin") {



                if(!CCGetEvent($this->DoLogin->CCSEvents, "OnClick")) {



                    $Redirect = "";



                }



            }



        } else {



            $Redirect = "";



        }



    }



//End Operation Method







//Show Method @2-D5BA3979



    function Show()



    {



        global $Tpl;



        global $FileName;



        $Error = "";







        if(!$this->Visible)



            return;







        $RecordBlock = "Record " . $this->ComponentName;



        $Tpl->block_path = $RecordBlock;



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");







        if($this->FormSubmitted) {



            $Error .= $this->login->Errors->ToString();



            $Error .= $this->password->Errors->ToString();



            $Error .= $this->Errors->ToString();



            $Tpl->SetVar("Error", $Error);



            $Tpl->Parse("Error", false);



        }



        $Tpl->SetVar("Action", $this->HTMLFormAction);



        $this->login->Show();



        $this->password->Show();



        $this->DoLogin->Show();



        $Tpl->parse("", false);



        $Tpl->block_path = "";



    }



//End Show Method







} //End Login Class @2-FCB6E20C







Class clsRecordforgottenpasswo { //forgottenpasswo Class @10-F5D005A2







//Variables @10-90DA4C9A







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







//Class_Initialize Event @10-10E9F2B9



    function clsRecordforgottenpasswo()



    {







        global $FileName;



        $this->Visible = true;



        $this->Errors = new clsErrors();



        $this->ds = new clsforgottenpasswoDataSource();



        $this->UpdateAllowed = false;



        $this->DeleteAllowed = false;



        if($this->Visible)



        {



            $this->ComponentName = "forgottenpasswo";



            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);



            $CCSForm = CCGetFromGet("ccsForm", "");



            $this->FormSubmitted = ($CCSForm == $this->ComponentName);



            $Method = $this->FormSubmitted ? ccsPost : ccsGet;



            $this->user_email = new clsControl(ccsTextBox, "user_email", "Email Address", ccsText, "", CCGetRequestParam("user_email", $Method));



            $this->user_email->Required = true;



            $this->Insert = new clsButton("Insert");



            $this->user_login = new clsControl(ccsHidden, "user_login", "User Login", ccsText, "", CCGetRequestParam("user_login", $Method));



            $this->ip_request = new clsControl(ccsHidden, "ip_request", "Ip Request", ccsText, "", CCGetRequestParam("ip_request", $Method));



            $this->date = new clsControl(ccsHidden, "date", "Date", ccsInteger, "", CCGetRequestParam("date", $Method));



        }



    }



//End Class_Initialize Event







//Initialize Method @10-3E63A070



    function Initialize()



    {







        if(!$this->Visible)



            return;







        $this->ds->Parameters["urlforgot_id"] = CCGetFromGet("forgot_id", "");



    }



//End Initialize Method







//Validate Method @10-43B565E7



    function Validate()



    {



        $Validation = true;



        $Where = "";



        $Validation = ($this->user_email->Validate() && $Validation);



        $Validation = ($this->user_login->Validate() && $Validation);



        $Validation = ($this->ip_request->Validate() && $Validation);



        $Validation = ($this->date->Validate() && $Validation);



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");



        return (($this->Errors->Count() == 0) && $Validation);



    }



//End Validate Method







//Operation Method @10-F7F0ADDA



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



        $Redirect = "login.php?" . CCGetQueryString("QueryString", Array("Insert","ccsForm"));



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







//InsertRow Method @10-6D99F8D2



    function InsertRow()



    {



        global $EP;



                global $now;



                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");



                $lookdb = new clsDBNetConnect;



                $lookdb->connect();



                $lookdb->query("SELECT * FROM users WHERE email='" . $this->user_email->GetValue() . "'");



                if($lookdb->next_record()) {



                        $ld = array(



                        "first" => $lookdb->f("first_name"),



                        "username" => $lookdb->f("user_login"),



                        "user_password" => $lookdb->f("user_password"),



                        "ID" => $lookdb->f("user_id"),



                        "last" => $lookdb->f("last_name"),



                        "email" => $lookdb->f("email"),



                        "address" => $lookdb->f("address1"),



                        "address2" => $lookdb->f("address2"),



                        "state" => $lookdb->f("state_id"),



                        "zip" => $lookdb->f("zip"),



                        "city" => $lookdb->f("city"),



                        "phonedy" => $lookdb->f("phone_day"),



                        "phoneevn" => $lookdb->f("phone_evn"),



                        "fax" => $lookdb->f("fax"),



                        "ip" => $lookdb->f("ip_insert"),



                        "date_created" => $lookdb->f("date_created")



                        );



                }



                $EP["EMAIL:CURRENT_USERNAME"] = $ld["username"];



                $EP["EMAIL:CURRENT_USERID"] = $ld["ID"];



                $EP["EMAIL:CURRENT_USER_PASSWORD"] = $ld["user_password"];



                $EP["EMAIL:CURRENT_USER_FIRST_NAME"] = $ld["first"];



                $EP["EMAIL:CURRENT_USER_LAST_NAME"] = $ld["last"];



                $EP["EMAIL:CURRENT_USER_EMAIL"] = $ld["email"];



                $EP["EMAIL:CURRENT_USER_ADDRESS"] = $ld["address"];



                $EP["EMAIL:CURRENT_USER_ADDRESS2"] = $ld["address2"];



                $EP["EMAIL:CURRENT_USER_STATE"] = $ld["state"];



                $EP["EMAIL:CURRENT_USER_CITY"] = $ld["city"];



                $EP["EMAIL:CURRENT_USER_ZIP"] = $ld["zip"];



                $EP["EMAIL:CURRENT_USER_DAY_PHONE"] = $ld["phonedy"];



                $EP["EMAIL:CURRENT_USER_EVN_PHONE"] = $ld["phoneevn"];



                $EP["EMAIL:CURRENT_USER_FAX"] = $ld["fax"];



                $EP["EMAIL:CURRENT_USER_IP"] = getenv("REMOTE_ADDR");



                $EP["EMAIL:CURRENT_USER__REGISTERED_IP"] = $ld["ip"];



                $EP["EMAIL:CURRENT_USER_DATE_SIGNEDUP"] = date("F j, Y, g:i a", $ld["date_created"]);







        $this->ds->user_email->SetValue($this->user_email->GetValue());



        $this->ds->user_login->SetValue($ld["username"]);



        $this->ds->ip_request->SetValue(getenv("REMOTE_ADDR"));



        $this->ds->date->SetValue(time());



        $this->ds->Insert();



        mailout("ForgotPassword", 0, $ld["ID"], 1000000000,time(), $EP);



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







//Show Method @10-20A15082



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



                    echo "Error in Record forgottenpasswo";



                }



                else if($this->ds->next_record())



                {



                    $this->ds->SetValues();



                    if(!$this->FormSubmitted)



                    {



                        $this->user_email->SetValue($this->ds->user_email->GetValue());



                        $this->user_login->SetValue($this->ds->user_login->GetValue());



                        $this->ip_request->SetValue($this->ds->ip_request->GetValue());



                        $this->date->SetValue($this->ds->date->GetValue());



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



            $Error .= $this->user_email->Errors->ToString();



            $Error .= $this->user_login->Errors->ToString();



            $Error .= $this->ip_request->Errors->ToString();



            $Error .= $this->date->Errors->ToString();



            $Error .= $this->Errors->ToString();



            $Error .= $this->ds->Errors->ToString();



            $Tpl->SetVar("Error", $Error);



            $Tpl->Parse("Error", false);



        }



        $Tpl->SetVar("Action", $this->HTMLFormAction);



        $this->Insert->Visible = !$this->EditMode;



        $this->user_email->Show();



        $this->Insert->Show();



        $this->user_login->Show();



        $this->ip_request->Show();



        $this->date->Show();



        $Tpl->parse("", false);



        $Tpl->block_path = "";



    }



//End Show Method







} //End forgottenpasswo Class @10-FCB6E20C







class clsforgottenpasswoDataSource extends clsDBNetConnect {  //forgottenpasswoDataSource Class @10-7670130D







//Variables @10-B65435DB



    var $CCSEvents = "";



    var $CCSEventResult;







    var $InsertParameters;



    var $wp;



    var $AllParametersSet;







    // Datasource fields



    var $user_email;



    var $user_login;



    var $ip_request;



    var $date;



//End Variables







//Class_Initialize Event @10-39C38F19



    function clsforgottenpasswoDataSource()



    {



        $this->Initialize();



        $this->user_email = new clsField("user_email", ccsText, "");



        $this->user_login = new clsField("user_login", ccsText, "");



        $this->ip_request = new clsField("ip_request", ccsText, "");



        $this->date = new clsField("date", ccsInteger, "");







    }



//End Class_Initialize Event







//Prepare Method @10-F0558325



    function Prepare()



    {



        $this->wp = new clsSQLParameters();



        $this->wp->AddParameter("1", "urlforgot_id", ccsInteger, "", "", $this->Parameters["urlforgot_id"], "");



        $this->AllParametersSet = $this->wp->AllParamsSet();



        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "forgot_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));



        $this->wp->AssembledWhere = $this->wp->Criterion[1];



        $this->Where = $this->wp->AssembledWhere;



    }



//End Prepare Method







//Open Method @10-831401C0



    function Open()



    {



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");



        $this->SQL = "SELECT *  " .



        "FROM forgottenpasswords";



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");



        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");



        $this->MoveToPage($this->AbsolutePage);



    }



//End Open Method







//SetValues Method @10-33A40C91



    function SetValues()



    {



        $this->user_email->SetDBValue($this->f("user_email"));



        $this->user_login->SetDBValue($this->f("user_login"));



        $this->ip_request->SetDBValue($this->f("ip_request"));



        $this->date->SetDBValue($this->f("date"));



    }



//End SetValues Method







//Insert Method @10-5203E2D5



    function Insert()



    {



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");



        $SQL = "INSERT INTO forgottenpasswords(" .



            "user_email, " .



            "user_login, " .



            "ip_request, " .



            "date" .



        ") VALUES (" .



            $this->ToSQL($this->user_email->DBValue, $this->user_email->DataType) . ", " .



            $this->ToSQL($this->user_login->DBValue, $this->user_login->DataType) . ", " .



            $this->ToSQL($this->ip_request->DBValue, $this->ip_request->DataType) . ", " .



            $this->ToSQL($this->date->DBValue, $this->date->DataType) .



        ")";



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");



        $this->query($SQL);



        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");



        if($this->Errors->Count() > 0)



            $this->Errors->AddError($this->Errors->ToString());



    }



//End Insert Method







} //End forgottenpasswoDataSource Class @10-FCB6E20C







//Include Page implementation @8-353B2997



include("./Footer.php");



//End Include Page implementation







//Initialize Page @1-780DB2EB



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







$FileName = "login.php";



$Redirect = "";



$TemplateFileName = "templates/login.html";



$BlockToParse = "main";



$PathToRoot = "./";



//End Initialize Page







//Initialize Objects @1-D6E80857







// Controls



$Header = new clsHeader();



$Header->BindEvents();



$Header->TemplatePath = "./";



$Header->Initialize();



$Login = new clsRecordLogin();



$forgottenpasswo = new clsRecordforgottenpasswo();



$Footer = new clsFooter();



$Footer->BindEvents();



$Footer->TemplatePath = "./";



$Footer->Initialize();



$forgottenpasswo->Initialize();







// Events



include("./login_events.php");



BindEvents();







$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");



//End Initialize Objects







//Execute Components @1-7A619BFD



$Header->Operations();



$Login->Operation();



$forgottenpasswo->Operation();



$Footer->Operations();



//End Execute Components







//Go to destination page @1-BEB91355



if($Redirect)



{



    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");



    header("Location:$Redirect");



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







//Show Page @1-98DF5EBB



$Header->Show("Header");



$Login->Show();



$forgottenpasswo->Show();



$Footer->Show("Footer");



$Tpl->PParse("main", false);



//End Show Page







//Unload Page @1-AB7622EF



$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");



unset($Tpl);



//End Unload Page











?>