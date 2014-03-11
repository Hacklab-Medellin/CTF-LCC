<?php
define("RelativePath", ".");

include(RelativePath . "/Common.php");

include(RelativePath . "/Template.php");

include(RelativePath . "/Sorter.php");

include(RelativePath . "/Navigator.php");



//End Include Common Files

$page="Reading Email";

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

include("./Headeru.php");

//End Include Page implementation

$NoShow=false;

Class clsRecordemails { //emails Class @4-ACB218B9



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



//Class_Initialize Event @4-04AA17F9

    function clsRecordemails()

    {



        global $FileName;

        $this->Visible = true;

        $this->Errors = new clsErrors();

        $this->ds = new clsemailsDataSource();

        $this->InsertAllowed = false;

        $this->UpdateAllowed = false;

        if($this->Visible)

        {

            $this->ComponentName = "emails";

            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);

            $CCSForm = CCGetFromGet("ccsForm", "");

            $this->FormSubmitted = ($CCSForm == $this->ComponentName);

            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

            $this->from_user_id = new clsControl(ccsLabel, "from_user_id", "From User Id", ccsText, "", CCGetRequestParam("from_user_id", $Method));

            $this->emaildate = new clsControl(ccsLabel, "emaildate", "date", ccsText, "", CCGetRequestParam("emaildate", $Method));

            $this->subject = new clsControl(ccsLabel, "subject", "Subject", ccsText, "", CCGetRequestParam("subject", $Method));

            $this->message = new clsControl(ccsLabel, "message", "Message", ccsMemo, "", CCGetRequestParam("message", $Method));

            $this->message->HTML = true;

            $this->Delete = new clsButton("Delete");

            $this->cancel = new clsButton("cancel");

        }

    }

//End Class_Initialize Event



//Initialize Method @4-C8C3D0AD

    function Initialize()

    {



        if(!$this->Visible)

            return;



        $this->ds->Parameters["urlemail_id"] = CCGetFromGet("email_id", "");

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");

    }

//End Initialize Method



//Validate Method @4-D1BCA33F

    function Validate()

    {

        $Validation = true;

        $Where = "";

        $Validation = ($this->from_user_id->Validate() && $Validation);

        $Validation = ($this->emaildate->Validate() && $Validation);

        $Validation = ($this->subject->Validate() && $Validation);

        $Validation = ($this->message->Validate() && $Validation);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");

        return (($this->Errors->Count() == 0) && $Validation);

    }

//End Validate Method



//Operation Method @4-DFE0C4E2

    function Operation()

    {

        global $Redirect;



        $this->ds->Prepare();

        $this->EditMode = $this->ds->AllParametersSet;

        if(!($this->Visible && $this->FormSubmitted))

            return;



        if($this->FormSubmitted) {

            $this->PressedButton = $this->EditMode ? "Delete" : "cancel";

            if(strlen(CCGetParam("Delete", ""))) {

                $this->PressedButton = "Delete";

            } else if(strlen(CCGetParam("cancel", ""))) {

                $this->PressedButton = "cancel";

            }

        }

        $Redirect = "ReadMail.php?" . CCGetQueryString("QueryString", Array("Delete","cancel","ccsForm"));

        if($this->PressedButton == "Delete") {

            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {

                $Redirect = "";

            } else {

                $Redirect = "myaccount.php?" . CCGetQueryString("QueryString", array("ccsForm"));

            }

        } else if($this->PressedButton == "cancel") {

            if(!CCGetEvent($this->cancel->CCSEvents, "OnClick")) {

                $Redirect = "";

            } else {

                $Redirect = "myaccount.php?" . CCGetQueryString("QueryString", array("ccsForm"));

            }

        } else {

            $Redirect = "";

        }

    }

//End Operation Method



//DeleteRow Method @4-A9D87FED

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



//Show Method @4-FA208D0B

    function Show()

    {

        global $Tpl;

        global $FileName;

                global $carrys;

                global $now;

                global $NoShow;

                global $emails2;

        $Error = "";



        if(!$this->Visible)

            return;



        if(!CCGetFromGet("email_id", "")){

                        $emails2->Visible = false;

                }

                $this->ds->open();

        $RecordBlock = "Record " . $this->ComponentName;

        $Tpl->block_path = $RecordBlock;

        if($this->EditMode)

        {

            if($this->Errors->Count() == 0)

            {

                if($this->ds->Errors->Count() > 0)

                {

                    echo "Error in Record emails";

                }

                else if($this->ds->next_record())

                {

                    $this->ds->SetValues();

                    if(($this->ds->from_user_id->GetValue() != "") && (is_numeric($this->ds->from_user_id->GetValue())) && ($this->ds->from_user_id->GetValue() != 1000000000)){

                        $lookupdb = new clsDBNetConnect;

                        $lookupdb->connect();

                        $thename = CCDLookUp("user_login","users","user_id='" . $this->ds->from_user_id->GetValue() . "'",$lookupdb);

                        $this->from_user_id->SetValue($thename);

                        unset($lookupdb);

                        $NoShow = true;

                                                $emails2->Visible = true;




                        } else {

                        $this->from_user_id->SetValue($now["sitename"]);

                        $NoShow = false;

                        $emails2->Visible = false;

                                        }



                                        $updb = new clsDBNetConnect;

                    $updb->connect();

                    if(CCGetFromGet("email_id", "")){

                        $rawsql = "UPDATE emails SET been_read='1' WHERE email_id='" . CCGetFromGet("email_id", "") . "' AND to_user_id='" . CCGetUserID() . "'";

                        $updb->query($rawsql);

                    }

                    $twodays = $this->ds->emaildate->GetValue();

                    $theday = getdate($twodays);

                    $lastofyear = substr($theday["year"],-2);

                    $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;

                    $this->emaildate->SetValue(date("F j, Y, g:i a", $this->ds->emaildate->GetValue()));

                    $this->subject->SetValue($this->ds->subject->GetValue());

                    $this->message->SetValue(nl2br($this->ds->message->GetValue()));

                    $Tpl->SetVar("ReplyToID", $this->ds->from_user_id->GetValue());

                                        $Tpl->SetVar("SUB", $this->ds->subject->GetValue());

                                        $Tpl->SetVar("TheUser", CCGetUserLogin());

                                        $carrys = array(

                                        "TheDate" => date("m/d/y"),

                                        "TheUser" => CCGetUserLogin(),

                                        "TheSender" => $thename,

                                        "TheSenderID" => $this->ds->from_user_id->GetValue(),

                                        "TheOriDate" => $enddate,

                                        "originalsubject" => $this->ds->subject->GetValue(),

                                        "TheMessage" => $this->ds->message->GetValue(),

                                        "NoShow" => $NoShow,

                                        "sitename" => $now["sitename"]);



                                        if(!$this->FormSubmitted)

                    {

                    }

                }

                else

                {

                    $this->EditMode = false;

                                        $emails2->Visible = false;

                }

            }

        }

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");



        if($this->FormSubmitted) {

            $Error .= $this->from_user_id->Errors->ToString();

            $Error .= $this->emaildate->Errors->ToString();

            $Error .= $this->subject->Errors->ToString();

            $Error .= $this->message->Errors->ToString();

            $Error .= $this->Errors->ToString();

            $Error .= $this->ds->Errors->ToString();

            $Tpl->SetVar("Error", $Error);

            $Tpl->Parse("Error", false);

        }

        $Tpl->SetVar("Action", $this->HTMLFormAction);

        $this->from_user_id->Show();

        $this->emaildate->Show();

        $this->subject->Show();

        $this->message->Show();

        $this->cancel->Show();

        $this->Delete->Show();



        $Tpl->parse("", false);

        $Tpl->block_path = "";

    }

//End Show Method



} //End emails Class @4-FCB6E20C



class clsemailsDataSource extends clsDBNetConnect {  //emailsDataSource Class @4-48567F33



//Variables @4-445C5629

    var $CCSEvents = "";

    var $CCSEventResult;



    var $DeleteParameters;

    var $wp;

    var $AllParametersSet;



    // Datasource fields

    var $from_user_id;

    var $emaildate;

    var $subject;

    var $message;

//End Variables



//Class_Initialize Event @4-4FDFE13B

    function clsemailsDataSource()

    {

        $this->Initialize();

        $this->from_user_id = new clsField("from_user_id", ccsText, "");

        $this->emaildate = new clsField("emaildate", ccsText, "");

        $this->subject = new clsField("subject", ccsText, "");

        $this->message = new clsField("message", ccsMemo, "");



    }

//End Class_Initialize Event



//Prepare Method @4-0F9D2CC0

    function Prepare()

    {

        $this->wp = new clsSQLParameters();

        $this->wp->AddParameter("1", "urlemail_id", ccsInteger, "", "", $this->Parameters["urlemail_id"], "");

        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");

        $this->AllParametersSet = $this->wp->AllParamsSet();

        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));

        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "to_user_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));

        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]);

        $this->Where = $this->wp->AssembledWhere;


    }

//End Prepare Method



//Open Method @4-2A9A8869

    function Open()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");

        $this->SQL = "SELECT *  " .

        "FROM emails";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");

        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");

        $this->MoveToPage($this->AbsolutePage);

    }

//End Open Method



//SetValues Method @4-E50DCA84

    function SetValues()

    {

        $this->from_user_id->SetDBValue($this->f("from_user_id"));

        $this->emaildate->SetDBValue($this->f("emaildate"));

        $this->subject->SetDBValue($this->f("subject"));

        $this->message->SetDBValue($this->f("message"));

    }

//End SetValues Method



//Delete Method @4-D26166F5

    function Delete()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");

        $SQL = "DELETE FROM emails WHERE " . $this->Where;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

    }

//End Delete Method



} //End emailsDataSource Class @4-FCB6E20C



//DEL      function Show()

//DEL      {

//DEL          global $Tpl;

//DEL          global $FileName;

//DEL

//DEL          if(!$this->Visible)

//DEL              return;

//DEL

//DEL          $this->ds->open();

//DEL          $RecordBlock = "Record " . $this->ComponentName;

//DEL          $Tpl->block_path = $RecordBlock;

//DEL          if($this->EditMode)

//DEL          {

//DEL              if($this->Errors->Count() == 0)

//DEL              {

//DEL                  if($this->ds->Errors->Count() > 0)

//DEL                  {

//DEL                      echo "Error in Record emails1";

//DEL                  }

//DEL                  else if($this->ds->next_record())

//DEL                  {

//DEL                      $this->ds->SetValues();

//DEL                      if(!$this->FormSubmitted)

//DEL                      {

//DEL                          $this->subject->SetValue($this->ds->subject->GetValue());

//DEL                          $this->message->SetValue($this->ds->message->GetValue());

//DEL                          $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());

//DEL                          $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());

//DEL                          $this->emaildate->SetValue($this->ds->emaildate->GetValue());

//DEL                          $this->been_read->SetValue($this->ds->been_read->GetValue());

//DEL                      }

//DEL                  }

//DEL                  else

//DEL                  {

//DEL                      $this->EditMode = false;

//DEL                  }

//DEL              }

//DEL          }

//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

//DEL

//DEL          if($this->FormSubmitted) {

//DEL              $Error .= $this->subject->Errors->ToString();

//DEL              $Error .= $this->message->Errors->ToString();

//DEL              $Error .= $this->to_user_id->Errors->ToString();

//DEL              $Error .= $this->from_user_id->Errors->ToString();

//DEL              $Error .= $this->emaildate->Errors->ToString();

//DEL              $Error .= $this->been_read->Errors->ToString();

//DEL              $Error .= $this->Errors->ToString();

//DEL              $Error .= $this->ds->Errors->ToString();

//DEL              $Tpl->SetVar("Error", $Error);

//DEL              $Tpl->Parse("Error", false);

//DEL          }

//DEL          $Tpl->SetVar("Action", $this->HTMLFormAction);

//DEL          $this->Insert->Visible = !$this->EditMode;

//DEL          $this->ds->SetValues();

//DEL                  $this->subject->SetValue($this->ds->subject->GetValue());

//DEL                  $this->message->SetValue($this->ds->message->GetValue());

//DEL                  $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());

//DEL                  $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());

//DEL                                  $this->emaildate->SetValue($this->ds->emaildate->GetValue());

//DEL                                  $this->been_read->SetValue($this->ds->been_read->GetValue());

//DEL                  $this->subject->Show();

//DEL          $this->message->Show();

//DEL          $this->Insert->Show();

//DEL          $this->Cancel->Show();

//DEL          $this->to_user_id->Show();

//DEL          $this->from_user_id->Show();

//DEL          $this->emaildate->Show();

//DEL          $this->been_read->Show();

//DEL          $Tpl->parse("", false);

//DEL          $Tpl->block_path = "";

//DEL      }



Class clsRecordemails2 { //emails2 Class @26-867F0A45



//Variables @26-90DA4C9A



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



//Class_Initialize Event @26-718B3DBF

    function clsRecordemails2()

    {



        global $FileName;

        $this->Visible = true;

        $this->Errors = new clsErrors();

        $this->ds = new clsemails2DataSource();

        $this->UpdateAllowed = false;

        $this->DeleteAllowed = false;

        if($this->Visible)

        {

            $this->ComponentName = "emails2";

            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);

            $CCSForm = CCGetFromGet("ccsForm", "");

            $this->FormSubmitted = ($CCSForm == $this->ComponentName);

            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

            $this->subject = new clsControl(ccsTextBox, "subject", "Subject", ccsText, "", CCGetRequestParam("subject", $Method));

            $this->subject->Required = true;

            $this->message = new clsControl(ccsTextArea, "message", "Message", ccsMemo, "", CCGetRequestParam("message", $Method));

            $this->Insert = new clsButton("Insert");

            $this->Cancel = new clsButton("Cancel");

            $this->to_user_id = new clsControl(ccsHidden, "to_user_id", "To User Id", ccsInteger, "", CCGetRequestParam("to_user_id", $Method));

            $this->from_user_id = new clsControl(ccsHidden, "from_user_id", "From User Id", ccsInteger, "", CCGetRequestParam("from_user_id", $Method));

            $this->emaildate = new clsControl(ccsHidden, "emaildate", "date", ccsInteger, "", CCGetRequestParam("emaildate", $Method));

            $this->been_read = new clsControl(ccsHidden, "been_read", "Been Read", ccsInteger, "", CCGetRequestParam("been_read", $Method));

        }

    }

//End Class_Initialize Event



//Initialize Method @26-EDF229C2

    function Initialize()

    {



        if(!$this->Visible)

            return;



        $this->ds->Parameters["urlemail_id"] = CCGetFromGet("email_id", "");

    }

//End Initialize Method



//Validate Method @26-F62DFE2D

    function Validate()

    {

        $Validation = true;

        $Where = "";

        $Validation = ($this->subject->Validate() && $Validation);

        $Validation = ($this->message->Validate() && $Validation);

        $Validation = ($this->to_user_id->Validate() && $Validation);

        $Validation = ($this->from_user_id->Validate() && $Validation);

        $Validation = ($this->emaildate->Validate() && $Validation);

        $Validation = ($this->been_read->Validate() && $Validation);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");

        return (($this->Errors->Count() == 0) && $Validation);

    }

//End Validate Method



//Operation Method @26-07ADB251

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

            } else if(strlen(CCGetParam("Cancel", ""))) {

                $this->PressedButton = "Cancel";

            }

        }

        $Redirect = "ReadMail.php?" . CCGetQueryString("QueryString", Array("Insert","Cancel","ccsForm"));

        if($this->PressedButton == "Cancel") {

            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {

                $Redirect = "";

            }

        } else if($this->Validate()) {

            if($this->PressedButton == "Insert") {

                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {

                    $Redirect = "";


                } else {

                $Redirect = "myaccount.php?" . CCGetQueryString("QueryString", array("ccsForm"));

                }

            }

        } else {

            $Redirect = "";

        }

    }

//End Operation Method



//InsertRow Method @26-F69E6C2C

    function InsertRow()

    {

        global $EP;

        global $now;

        $db2 = new clsDBNetConnect;

        $EP["EMAIL:REPLY_TO_USER_ID"] = $this->to_user_id->GetValue();

        $EP["EMAIL:REPLY_TO_USERNAME"] = CCDLookUp("user_login", "users" , "user_id='" . $this->to_user_id->GetValue() . "'", $db2);

        $EP["EMAIL:REPLY_MESSAGE"] = $this->message->GetValue();

        $EP["EMAIL:REPLY_FROM_USER_ID"] = CCGetUserID();

        $EP["EMAIL:REPLY_FROM_USERNAME"] = CCGetUserLogin();

        $EP["EMAIL:REPLY_SUBJECT"] = $this->subject->GetValue();

        /*

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");

        $this->ds->subject->SetValue($newsubject);

        $this->ds->message->SetValue($newmessage);

        $this->ds->to_user_id->SetValue($this->to_user_id->GetValue());

        $this->ds->from_user_id->SetValue($CCGetUserID());

        $this->ds->emaildate->SetValue($time());

        $this->ds->been_read->SetValue(0);

        $this->ds->Insert();

        */

        mailout("EmailReply", 0, $this->to_user_id->GetValue(), CCGetUserID(), time(), $EP);

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



//Show Method @26-B2602035

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

                    echo "Error in Record emails2";

                }

                else if($this->ds->next_record())

                {

                    $this->ds->SetValues();

                    if(!$this->FormSubmitted)

                    {

                        $this->subject->SetValue($this->ds->subject->GetValue());

                        $this->message->SetValue($this->ds->message->GetValue());

                        $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());

                        $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());

                        $this->emaildate->SetValue($this->ds->emaildate->GetValue());

                        $this->been_read->SetValue($this->ds->been_read->GetValue());

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

            $Error .= $this->subject->Errors->ToString();

            $Error .= $this->message->Errors->ToString();

            $Error .= $this->to_user_id->Errors->ToString();

            $Error .= $this->from_user_id->Errors->ToString();

            $Error .= $this->emaildate->Errors->ToString();

            $Error .= $this->been_read->Errors->ToString();

            $Error .= $this->Errors->ToString();

            $Error .= $this->ds->Errors->ToString();

            $Tpl->SetVar("Error", $Error);

            $Tpl->Parse("Error", false);

        }

        $Tpl->SetVar("Action", $this->HTMLFormAction);

        $this->Insert->Visible = TRUE;

        $this->subject->Show();

        $this->message->Show();

        $this->Insert->Show();

        $this->Cancel->Show();

        $this->to_user_id->Show();

        $this->from_user_id->Show();

        $this->emaildate->Show();

        $this->been_read->Show();

        $Tpl->parse("", false);

        $Tpl->block_path = "";

    }

//End Show Method



} //End emails2 Class @26-FCB6E20C



class clsemails2DataSource extends clsDBNetConnect {  //emails2DataSource Class @26-C135490B



//Variables @26-69B85AE7

    var $CCSEvents = "";

    var $CCSEventResult;



    var $InsertParameters;

    var $wp;

    var $AllParametersSet;



    // Datasource fields

    var $subject;

    var $message;

    var $to_user_id;

    var $from_user_id;

    var $emaildate;

    var $been_read;

//End Variables



//Class_Initialize Event @26-45198D98

    function clsemails2DataSource()

    {

        $this->Initialize();

        $this->subject = new clsField("subject", ccsText, "");

        $this->message = new clsField("message", ccsMemo, "");

        $this->to_user_id = new clsField("to_user_id", ccsInteger, "");

        $this->from_user_id = new clsField("from_user_id", ccsInteger, "");

        $this->emaildate = new clsField("emaildate", ccsInteger, "");

        $this->been_read = new clsField("been_read", ccsInteger, "");



    }

//End Class_Initialize Event



//Prepare Method @26-9C05E373

    function Prepare()

    {

        $this->wp = new clsSQLParameters();

        $this->wp->AddParameter("1", "urlemail_id", ccsInteger, "", "", $this->Parameters["urlemail_id"], "");

        $this->AllParametersSet = $this->wp->AllParamsSet();

        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));

        $this->wp->AssembledWhere = $this->wp->Criterion[1];

        $this->Where = $this->wp->AssembledWhere;

    }

//End Prepare Method



//Open Method @26-2A9A8869

    function Open()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");

        $this->SQL = "SELECT *  " .

        "FROM emails";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");

        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");

        $this->MoveToPage($this->AbsolutePage);

    }

//End Open Method



//SetValues Method @26-4E048CE6

    function SetValues()

    {

        $this->subject->SetDBValue($this->f("subject"));

        $this->message->SetDBValue($this->f("message"));

        $this->to_user_id->SetDBValue($this->f("to_user_id"));

        $this->from_user_id->SetDBValue($this->f("from_user_id"));

        $this->emaildate->SetDBValue($this->f("emaildate"));

        $this->been_read->SetDBValue($this->f("been_read"));

    }

//End SetValues Method



//Insert Method @26-20A46EF7

    function Insert()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");

        $SQL = "INSERT INTO emails(" .

            "subject, " .

            "message, " .

            "to_user_id, " .

            "from_user_id, " .

            "emaildate, " .

            "been_read" .

        ") VALUES (" .

            $this->ToSQL($this->subject->DBValue, $this->subject->DataType) . ", " .

            $this->ToSQL($this->message->DBValue, $this->message->DataType) . ", " .

            $this->ToSQL($this->to_user_id->DBValue, $this->to_user_id->DataType) . ", " .

            $this->ToSQL($this->from_user_id->DBValue, $this->from_user_id->DataType) . ", " .

            $this->ToSQL($this->emaildate->DBValue, $this->emaildate->DataType) . ", " .

            $this->ToSQL($this->been_read->DBValue, $this->been_read->DataType) .

        ")";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

    }

//End Insert Method



} //End emails2DataSource Class @26-FCB6E20C



//Include Page implementation @3-353B2997

include("./Footer.php");

//End Include Page implementation



//Initialize Page @1-45C8212B

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



$FileName = "ReadMail.php";

$Redirect = "";

$TemplateFileName = "templates/ReadMail.html";

$BlockToParse = "main";

$PathToRoot = "./";

//End Initialize Page



//Authenticate User @1-7FED0150

CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));

//End Authenticate User



//Initialize Objects @1-6351FB46



// Controls

$Header = new clsHeader();

$Header->BindEvents();

$Header->TemplatePath = "./";

$Header->Initialize();

$emails = new clsRecordemails();

$emails2 = new clsRecordemails2();

$Footer = new clsFooter();

$Footer->BindEvents();

$Footer->TemplatePath = "./";

$Footer->Initialize();

$emails->Initialize();

$emails2->Initialize();



$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");

//End Initialize Objects



//Execute Components @1-8BDA3124

$Header->Operations();

$emails->Operation();

$emails2->Operation();

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



//Show Page @1-AA5E943A

$Header->Show("Header");

$emails->Show();

$emails2->Show();

$Footer->Show("Footer");

$Tpl->PParse("main", false);

//End Show Page



//Unload Page @1-AB7622EF

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");

unset($Tpl);

//End Unload Page





?>