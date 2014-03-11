<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Viewing Purchases";
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

class clsGridpurchase1 { //purchase1 class @36-6F333C80

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
    var $Sorter_title;
    var $Sorter_date;
    var $Navigator;
//End Variables

//Class_Initialize Event @36-E5D1A85D
    function clsGridpurchase1()
    {
        global $FileName;
        $this->ComponentName = "purchase1";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clspurchase1DataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("purchase1Order", "");
        $this->SorterDirection = CCGetParam("purchase1Dir", "");

        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->date->HTML = true;
        $this->buyer = new clsControl(ccsLabel, "buyer", "buyer", ccsText, "", CCGetRequestParam("buyer", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->amt_received = new clsControl(ccsLabel, "amt_received", "amt_received", ccsFloat, "", CCGetRequestParam("amt_received", ccsGet));
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
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
                $this->title->SetValue($this->ds->title->GetValue());
                $User_id = $this->ds->buyer->GetValue();
                $twodays = $this->ds->date->GetValue();
                                $theday = getdate($twodays);
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                if(($this->ds->buyer->GetValue() != "") && (is_numeric($this->ds->buyer->GetValue())) && ($this->ds->buyer->GetValue() != 1000000000)){
                                        $lookupdb = new clsDBNetConnect;
                                        $lookupdb->connect();
                                        $thename = CCDLookUp("user_login","users","user_id='" . $this->ds->buyer->GetValue() . "'",$lookupdb);
                                        $this->buyer->SetValue($thename);
                                        unset($lookupdb);
                                } else {
                                        $this->buyer->SetValue($now["sitename"]);
                                }
                $this->id->SetValue($this->ds->id->GetValue());
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->amt_received->SetValue($this->ds->amt_received->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->title->Show();
                $this->date->Show();
                $this->buyer->Show();
                $this->id->Show();
                $this->ItemNum->Show();
                $this->amt_received->Show();
                $db = new clsDBNetConnect;
                $query = "select * from feedback where `purchase_id` = '" . $this->ds->id->GetValue() . "' and `doing_rating` = '" . CCGetUserID() . "'";
                //print $query;
                $db->query($query);
                if (!$db->next_record()){
                	$Tpl->setVar("feedbacklink", "<a href=\"RateUser.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "&purchase_id=" . $this->ds->id->GetValue() . "\">Leave Feedback</a>");
                }
                else {
                	$Tpl->setVar("feedbacklink", "<a href=\"Feedback.php?user_id=" . $User_id . "\">View This User's Feedback</a>");
                }
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
        $this->Sorter_title->Show();
        $this->Sorter_date->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End purchase1 Class @36-FCB6E20C

class clspurchase1DataSource extends clsDBNetConnect {  //purchase1DataSource Class @36-48567F33

//Variables @36-2F5B7AB2
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $title;
    var $date;
    var $buyer;
    var $id;
    var $ItemNum;
    var $amt_received;
//End Variables

//Class_Initialize Event @36-4B038FD2
    function clspurchase1DataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->date = new clsField("date", ccsText, "");
        $this->buyer = new clsField("buyer", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->amt_received = new clsField("amt_received", ccsFloat, "");
        $this->id = new clsField("id", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @36-C2E9613F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_title" => array("title", ""),
            "Sorter_date" => array("date", "")));
    }
//End SetOrder Method

//Prepare Method @36-EC0ED421
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @36-56E05C87
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM purchases";
        $this->SQL = "SELECT *  " .
        "FROM purchases";
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
        $this->title->SetDBValue($this->f("title"));
        $this->date->SetDBValue($this->f("date"));
        $this->buyer->SetDBValue($this->f("buyer"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->amt_received->SetDBValue($this->f("amt_received"));
        $this->id->SetDBValue($this->f("id"));
    }
//End SetValues Method

} //End purchase1DataSource Class @36-FCB6E20C
class clsGridpurchase2 { //purchase2 class @36-6F333C80

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
    var $Sorter_title;
    var $Sorter_date;
    var $Navigator;
//End Variables

//Class_Initialize Event @36-E5D1A85D
	function clsGridpurchase2()
    {
        global $FileName;
        $this->ComponentName = "purchase2";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clspurchase2DataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("purchase2Order", "");
        $this->SorterDirection = CCGetParam("purchase2Dir", "");

        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->date->HTML = true;
        $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsText, "", CCGetRequestParam("user_id", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->amt_received = new clsControl(ccsLabel, "amt_received", "amt_received", ccsFloat, "", CCGetRequestParam("amt_received", ccsGet));
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
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
                    $User_id = $this->ds->user_id->GetValue();
                $Tpl->block_path = $GridBlock . "/Row";
                $this->title->SetValue($this->ds->title->GetValue());
                $twodays = $this->ds->date->GetValue();
                                $theday = getdate($twodays);
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                if(($this->ds->user_id->GetValue() != "") && (is_numeric($this->ds->user_id->GetValue())) && ($this->ds->user_id->GetValue() != 1000000000)){
                                        $lookupdb = new clsDBNetConnect;
                                        $lookupdb->connect();
                                        $thename = CCDLookUp("user_login","users","user_id='" . $this->ds->user_id->GetValue() . "'",$lookupdb);
                                        $this->user_id->SetValue($thename);
                                        unset($lookupdb);
                                } else {
                                        $this->user_id->SetValue($now["sitename"]);
                                }
                $this->id->SetValue($this->ds->id->GetValue());
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->amt_received->SetValue($this->ds->amt_received->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->title->Show();
                $this->date->Show();
                $this->user_id->Show();
                $this->id->Show();
                $this->ItemNum->Show();
                $this->amt_received->Show();
                $db = new clsDBNetConnect;
                $db->query("select * from feedback where `purchase_id` = '" . $this->ds->id->GetValue() . "' and `doing_rating` = '" . CCGetUserID() . "'");
                if (!$db->next_record()){
                	$Tpl->setVar("feedbacklink", "<a href=\"RateUser.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "&purchase_id=" . $this->ds->id->GetValue() . "\">Leave Feedback</a>");
                }
                else {
                	$Tpl->setVar("feedbacklink", "<a href=\"Feedback.php?user_id=" . $User_id . "\">View This User's Feedback</a>");
                }
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
        $this->Sorter_title->Show();
        $this->Sorter_date->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End purchase2 Class @36-FCB6E20C

class clspurchase2DataSource extends clsDBNetConnect {  //purchase2DataSource Class @36-48567F33

//Variables @36-2F5B7AB2
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $title;
    var $date;
    var $user_id;
    var $id;
    var $ItemNum;
    var $amt_received;
//End Variables

//Class_Initialize Event @36-4B038FD2
    function clspurchase2DataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->date = new clsField("date", ccsText, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->amt_received = new clsField("amt_received", ccsFloat, "");
        $this->id = new clsField("id", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @36-C2E9613F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_title" => array("title", ""),
            "Sorter_date" => array("date", "")));
    }
//End SetOrder Method

//Prepare Method @36-EC0ED421
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "buyer", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @36-56E05C87
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM purchases";
        $this->SQL = "SELECT *  " .
        "FROM purchases";
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
        $this->title->SetDBValue($this->f("title"));
        $this->date->SetDBValue($this->f("date"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->amt_received->SetDBValue($this->f("amt_received"));
        $this->id->SetDBValue($this->f("id"));
    }
//End SetValues Method

} //End purchase2DataSource Class @36-FCB6E20C


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

$FileName = "PurchaseHistory.php";
$Redirect = "";
$TemplateFileName = "templates/PurchaseHistory.html";
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
$purchase1 = new clsGridpurchase1();
$purchase2 = new clsGridpurchase2();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$purchase1->Initialize();
$purchase2->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-9D3C7E64
$Header->Operations();
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

//Show Page @1-BE2A4A0B
$Header->Show("Header");
$purchase1->Show();
$purchase2->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
