<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files
$page="At User Control Panel";
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

if ($_GET["action"] == "delete") {
	$db = new clsDBNetConnect;
 	$query = "delete from emails where to_user_id = '" .  CCGetUserID() . "' and email_id = '" . $_GET["email_id"] . "'";
	$db->query($query);
}

Class clsRecordusercontrol { //usercontrol Class @14-F7E31C50

//Variables @14-90DA4C9A

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

//Class_Initialize Event @14-407F0D38
    function clsRecordusercontrol()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsusercontrolDataSource();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "usercontrol";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->userID = new clsControl(ccsLabel, "userID", "userID", ccsInteger, "", CCGetRequestParam("userID", $Method));
            $this->tokens = new clsControl(ccsLabel, "tokens", "tokens", ccsInteger, "", CCGetRequestParam("tokens", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @14-537EA73F
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
    }
//End Initialize Method

//Validate Method @14-469F60B4
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->userID->Validate() && $Validation);
        $Validation = ($this->tokens->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @14-AF65F1ED
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        $Redirect = "?" . CCGetQueryString("QueryString", Array("ccsForm"));
    }
//End Operation Method

//Show Method @14-81FA80C5
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
                    echo "Error in Record usercontrol";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->userID->SetValue($this->ds->userID->GetValue());
                    $this->tokens->SetValue($this->ds->tokens->GetValue());
                    if(!$this->FormSubmitted)
                    {
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
            $Error .= $this->userID->Errors->ToString();
            $Error .= $this->tokens->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->userID->Show();
        $this->tokens->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End usercontrol Class @14-FCB6E20C

class clsusercontrolDataSource extends clsDBNetConnect {  //usercontrolDataSource Class @14-41EBA2F3

//Variables @14-66A5F5A8
    var $CCSEvents = "";
    var $CCSEventResult;

    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $userID;
    var $tokens;
//End Variables

//Class_Initialize Event @14-D7BE2038
    function clsusercontrolDataSource()
    {
        $this->Initialize();
        $this->userID = new clsField("userID", ccsInteger, "");
        $this->tokens = new clsField("tokens", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @14-CA9B5CCE
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @14-DC1AA46D
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

//SetValues Method @14-0F2FECED
    function SetValues()
    {
        $this->userID->SetDBValue($this->f("user_id"));
        $this->tokens->SetDBValue($this->f("tokens"));
    }
//End SetValues Method

} //End usercontrolDataSource Class @14-FCB6E20C

class clsGridemails { //emails class @36-6F333C80

//Variables @36-8731A4E3

    // Public variables
    var $ComponentName;
    var $Visible; var $Errors;
    var $ds; var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    // Grid Controls
    var $StaticControls; var $RowControls;
    var $Sorter_subject;
    var $Sorter_emaildate;
    var $Navigator;
//End Variables

//Class_Initialize Event @36-E5D1A85D
    function clsGridemails()
    {
        global $FileName;
        $this->ComponentName = "emails";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsemailsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("emailsOrder", "");
        $this->SorterDirection = CCGetParam("emailsDir", "");

        $this->been_read = new clsControl(ccsLabel, "been_read", "been_read", ccsText, "", CCGetRequestParam("been_read", ccsGet));
        $this->been_read->HTML = true;
        $this->subject = new clsControl(ccsLabel, "subject", "subject", ccsText, "", CCGetRequestParam("subject", ccsGet));
        $this->emaildate = new clsControl(ccsLabel, "emaildate", "emaildate", ccsText, "", CCGetRequestParam("emaildate", ccsGet));
        $this->emaildate->HTML = true;
        $this->from_user_id = new clsControl(ccsLabel, "from_user_id", "from_user_id", ccsText, "", CCGetRequestParam("from_user_id", ccsGet));
        $this->email_id = new clsControl(ccsLabel, "email_id", "email_id", ccsInteger, "", CCGetRequestParam("email_id", ccsGet));
        $this->Sorter_subject = new clsSorter($this->ComponentName, "Sorter_subject", $FileName);
        $this->Sorter_emaildate = new clsSorter($this->ComponentName, "Sorter_emaildate", $FileName);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @36-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @36-89453F69
    function Show()
    {
        global $Tpl;
        global $now;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                if($this->ds->been_read->GetValue() == 1){
                                        $this->been_read->SetValue("class=\"ltdt\"");
                                } else {
                                        $this->been_read->SetValue("");
                                }
                $this->subject->SetValue($this->ds->subject->GetValue());
                $twodays = $this->ds->emaildate->GetValue();
                                $theday = getdate($twodays);
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->emaildate->SetValue(date("F j, Y, g:i a", $this->ds->emaildate->GetValue()));
                if(($this->ds->from_user_id->GetValue() != "") && (is_numeric($this->ds->from_user_id->GetValue())) && ($this->ds->from_user_id->GetValue() != 1000000000)){
                                        $lookupdb = new clsDBNetConnect;
                                        $lookupdb->connect();
                                        $thename = CCDLookUp("user_login","users","user_id='" . $this->ds->from_user_id->GetValue() . "'",$lookupdb);
                                        $this->from_user_id->SetValue($thename);
                                        unset($lookupdb);
                                } else {
                                        $this->from_user_id->SetValue($now["sitename"]);
                                }
                $this->email_id->SetValue($this->ds->email_id->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->been_read->Show();
                $this->subject->Show();
                $this->emaildate->Show();
                $this->from_user_id->Show();
                $this->email_id->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_subject->Show();
        $this->Sorter_emaildate->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End emails Class @36-FCB6E20C

class clsemailsDataSource extends clsDBNetConnect {  //emailsDataSource Class @36-48567F33

//Variables @36-2F5B7AB2
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $been_read;
    var $subject;
    var $emaildate;
    var $from_user_id;
    var $email_id;
//End Variables

//Class_Initialize Event @36-4B038FD2
    function clsemailsDataSource()
    {
        $this->Initialize();
        $this->been_read = new clsField("been_read", ccsText, "");
        $this->subject = new clsField("subject", ccsText, "");
        $this->emaildate = new clsField("emaildate", ccsText, "");
        $this->from_user_id = new clsField("from_user_id", ccsInteger, "");
        $this->email_id = new clsField("email_id", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @36-C2E9613F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "emaildate desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_subject" => array("subject", ""),
            "Sorter_emaildate" => array("emaildate", "")));
    }
//End SetOrder Method

//Prepare Method @36-EC0ED421
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "to_user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @36-56E05C87
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM emails";
        $this->SQL = "SELECT *  " .
        "FROM emails";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @36-8C60FE31
    function SetValues()
    {
        $this->been_read->SetDBValue($this->f("been_read"));
        $this->subject->SetDBValue($this->f("subject"));
        $this->emaildate->SetDBValue($this->f("emaildate"));
        $this->from_user_id->SetDBValue($this->f("from_user_id"));
        $this->email_id->SetDBValue($this->f("email_id"));
    }
//End SetValues Method

} //End emailsDataSource Class @36-FCB6E20C

class clsGridwatchlist { //watchlist class @27-DE1107CA

//Variables @27-1D3D99F1

    // Public variables
    var $ComponentName;
    var $Visible; var $Errors;
    var $ds; var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    // Grid Controls
    var $StaticControls; var $RowControls;
    var $Sorter_itemID;
    var $Sorter_ItemTitle;
    var $Navigator;
//End Variables

//Class_Initialize Event @27-7E35DE58
    function clsGridwatchlist()
    {
        global $FileName;
        $this->ComponentName = "watchlist";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clswatchlistDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("watchlistOrder", "");
        $this->SorterDirection = CCGetParam("watchlistDir", "");

        $this->itemID = new clsControl(ccsLabel, "itemID", "itemID", ccsText, "", CCGetRequestParam("itemID", ccsGet));
        $this->ItemTitle = new clsControl(ccsLabel, "ItemTitle", "ItemTitle", ccsText, "", CCGetRequestParam("ItemTitle", ccsGet));
        $this->watch_id = new clsControl(ccsLabel, "watch_id", "watch_id", ccsInteger, "", CCGetRequestParam("watch_id", ccsGet));
        $this->Sorter_itemID = new clsSorter($this->ComponentName, "Sorter_itemID", $FileName);
        $this->Sorter_ItemTitle = new clsSorter($this->ComponentName, "Sorter_ItemTitle", $FileName);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @27-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @27-6A9D2FAE
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                $this->itemID->SetValue($this->ds->itemID->GetValue());
                $this->ItemTitle->SetValue($this->ds->ItemTitle->GetValue());
                $this->watch_id->SetValue($this->ds->watch_id->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->itemID->Show();
                $this->ItemTitle->Show();
                $this->watch_id->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_itemID->Show();
        $this->Sorter_ItemTitle->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End watchlist Class @27-FCB6E20C

class clswatchlistDataSource extends clsDBNetConnect {  //watchlistDataSource Class @27-FEADDC50

//Variables @27-2CB36A47
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $itemID;
    var $ItemTitle;
    var $watch_id;
//End Variables

//Class_Initialize Event @27-847647D4
    function clswatchlistDataSource()
    {
        $this->Initialize();
        $this->itemID = new clsField("itemID", ccsText, "");
        $this->ItemTitle = new clsField("ItemTitle", ccsText, "");
        $this->watch_id = new clsField("watch_id", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @27-600D6FC8
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "watch_id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_itemID" => array("itemID", ""),
            "Sorter_ItemTitle" => array("ItemTitle", "")));
    }
//End SetOrder Method

//Prepare Method @27-A9E5EB8D
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @27-DE8D92D4
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM watchlist";
        $this->SQL = "SELECT *  " .
        "FROM watchlist";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @27-8721B9C5
    function SetValues()
    {
        $this->itemID->SetDBValue($this->f("itemID"));
        $this->ItemTitle->SetDBValue($this->f("ItemTitle"));
        $this->watch_id->SetDBValue($this->f("watch_id"));
    }
//End SetValues Method

} //End watchlistDataSource Class @27-FCB6E20C

class clsGriditems { //items class @17-DDF99D24

//Variables @17-4A3EDCD6

    // Public variables
    var $ComponentName;
    var $Visible; var $Errors;
    var $ds; var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    // Grid Controls
    var $StaticControls; var $RowControls;
    var $Sorter_title;
    var $Sorter_asking_price;
    var $Navigator;
//End Variables

//Class_Initialize Event @17-DBFE63D2
    function clsGriditems()
    {
        global $FileName;
        $this->ComponentName = "items";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("itemsOrder", "");
        $this->SorterDirection = CCGetParam("itemsDir", "");

        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->asking_price = new clsControl(ccsLabel, "asking_price", "asking_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", ccsGet));
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_asking_price = new clsSorter($this->ComponentName, "Sorter_asking_price", $FileName);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @17-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @17-01B5B785
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                $this->title->SetValue($this->ds->title->GetValue());
                $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
        include ("./Config/vars.php");
        $conn=mysql_connect($dbs["DB_HOST"],$dbs["DB_USER"],$dbs["DB_PASS"]);
		$query = "select category from items where ItemNum = " . $this->ds->ItemNum->GetValue();
		$result = mysql_db_query($dbs["DB_NAME"],$query,$conn);
		$result = mysql_fetch_array($result);
		$cat = $result["category"];
		$Tpl->SetVar("finalcat",$cat);
                $this->title->Show();
                $this->asking_price->Show();
                $this->ItemNum->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_title->Show();
        $this->Sorter_asking_price->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @17-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @17-585CFEF7

//Variables @17-1397387B
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $title;
    var $asking_price;
    var $ItemNum;
//End Variables

//Class_Initialize Event @17-A2D16B02
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @17-F9AD28E5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "itemID";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_title" => array("title", ""),
            "Sorter_asking_price" => array("asking_price", "")));
    }
//End SetOrder Method

//Prepare Method @17-4E60AF3B
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = "status='0'";
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @17-368AA817
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM items";
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @17-1FF3D2E8
    function SetValues()
    {
        $this->title->SetDBValue($this->f("title"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
    }
//End SetValues Method

} //End itemsDataSource Class @17-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-375A4A35
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

$FileName = "myaccount.php";
$Redirect = "";
$TemplateFileName = "templates/myaccount.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-B4723FC9

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$usercontrol = new clsRecordusercontrol();
$Logout = new clsControl(ccsLink, "Logout", "Logout", ccsText, "", CCGetRequestParam("Logout", ccsGet));
$Logout->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
$Logout->Parameters = CCAddParam($Logout->Parameters, "Logout", "True");
$Logout->Page = "login.php";
$emails = new clsGridemails();
$watchlist = new clsGridwatchlist();
$items = new clsGriditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$usercontrol->Initialize();
$emails->Initialize();
$watchlist->Initialize();
$items->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-9D3C7E64
$Header->Operations();
$usercontrol->Operation();
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

$subscriptions = subscription_membership(CCGetUserID(), "icontext", "<br><br>", "1");
$Tpl->setVar("subscriptions", $subscriptions);

//Show Page @1-BE2A4A0B
$Header->Show("Header");
$usercontrol->Show();
$Logout->Show();
$emails->Show();
$watchlist->Show();
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>