<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Viewing Account Summary";
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

class clsGridcharges { //charges class @4-7C16A55D

//Variables @4-2B31ACE1

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
    var $Sorter_date;
    var $Sorter_charge;
    var $Sorter_cause;
    var $Navigator;
//End Variables

//Class_Initialize Event @4-32FF1A3A
    function clsGridcharges()
    {
        global $FileName;
        $this->ComponentName = "charges";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clschargesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("chargesOrder", "");
        $this->SorterDirection = CCGetParam("chargesDir", "");

        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->charge = new clsControl(ccsLabel, "charge", "charge", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("charge", ccsGet));
        $this->charge->HTML = true;
        $this->cause = new clsControl(ccsLabel, "cause", "cause", ccsMemo, "", CCGetRequestParam("cause", ccsGet));
        $this->cause->HTML = true;
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
        $this->Sorter_charge = new clsSorter($this->ComponentName, "Sorter_charge", $FileName);
        $this->Sorter_cause = new clsSorter($this->ComponentName, "Sorter_cause", $FileName);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @4-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @4-0FC01D50
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
                if(CCGetFromGet("Days", "") && is_numeric(CCGetFromGet("Days", ""))){
                        $todayis = time();
                        $unday = getdate($todayis);
                        $dateend = mktime(0,0,0,$unday["mon"],($unday["mday"] - CCGetFromGet("Days", "")),$unday["year"]);
                } else {
                        $todayis = time();
                        $unday = getdate($todayis);
                        $dateend = mktime(0,0,0,$unday["mon"],($unday["mday"] - 30),$unday["year"]);
                }
                $this->ds->Parameters["urlDays"] = $dateend;
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
                $days=2;
                                $twodays = $this->ds->date->GetValue();
                                $theday = getdate($twodays);
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->date->SetValue($enddate);
                /*
                                $this->status->SetValue($this->ds->status->GetValue());
                                if($this->ds->status->GetValue() == "PENDING"){
                                        $this->status->SetValue("<font color=\"#FF0000\"><b>PENDING</b></font>");
                }
                                if($this->ds->statusamount->GetValue() <= 0){
                                        $this->statusamount->SetValue(0.00);
                } else {
                                        $this->statusamount->SetValue($this->ds->statusamount->GetValue());
                                }
                                */
                                if($this->ds->charge->GetValue() < 0){
                                        $Tpl->SetVar("color", "#FF0000");
                                }
                                if($this->ds->charge->GetValue() > 0){
                                        $Tpl->SetVar("color", "#00FF11");
                                }
                                if($this->ds->charge->GetValue() == 0){
                                        $Tpl->SetVar("color", "#000000");
                                }
                                $this->charge->SetValue($this->ds->charge->GetValue());

                                $this->cause->SetValue($this->ds->cause->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->date->Show();
                //$this->status->Show();
                //$this->statusamount->Show();
                $this->charge->Show();
                $this->cause->Show();
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
        $this->Sorter_date->Show();
        //$this->Sorter_status->Show();
        //$this->Sorter_statusamount->Show();
        $this->Sorter_charge->Show();
        $this->Sorter_cause->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @4-FCB6E20C

class clschargesDataSource extends clsDBNetConnect {  //chargesDataSource Class @4-FA5C06A6

//Variables @4-1EC97F20
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $date;
    var $charge;
    var $cause;
//End Variables

//Class_Initialize Event @4-4C9EB234
    function clschargesDataSource()
    {
        $this->Initialize();
        $this->date = new clsField("date", ccsText, "");
        $this->charge = new clsField("charge", ccsFloat, "");
        $this->cause = new clsField("cause", ccsMemo, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-522B2D38
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_date" => array("date", ""),
            "Sorter_charge" => array("charge", ""),
            "Sorter_cause" => array("cause", "")));
    }
//End SetOrder Method

//Prepare Method @4-AC518859
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->AddParameter("2", "urlDays", ccsInteger, "", "", $this->Parameters["urlDays"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opGreaterThanOrEqual, "date", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-8F321946
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM charges";
        $this->SQL = "SELECT *  " .
        "FROM charges";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-FAD4FC8D
    function SetValues()
    {
        $this->date->SetDBValue($this->f("date"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->cause->SetDBValue($this->f("cause"));
    }
//End SetValues Method

} //End chargesDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-09733F49
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

$FileName = "AccountSummary.php";
$Redirect = "";
$TemplateFileName = "templates/AccountSummary.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-055029C2

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$charges = new clsGridcharges();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$charges->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-351F985C
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

//Show Page @1-533D058C
$Header->Show("Header");
$charges->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>