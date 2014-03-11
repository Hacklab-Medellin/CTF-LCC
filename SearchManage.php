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

if ($_GET["delete"]) {
	$db = new clsDBNetConnect;
 	$query = "delete from search_history where user_id = '" .  CCGetUserID() . "' and id = '" . $_GET["delete"] . "'";
	$db->query($query);
}

if ($_GET["save"]) {
	$db = new clsDBNetConnect;
 	$query = "update search_history set `save` = '1' where user_id = '" .  CCGetUserID() . "' and id = '" . $_GET["save"] . "'";
	$db->query($query);
}

if ($_POST["save_sched"]) {
	$nextrun = 86400 * $_POST["frequency"];
	$nextrun = $nextrun + time();
	if ($_POST["sched"])
		$sched = 1;
	else
		$sched = 0;
	$db = new clsDBNetConnect;
 	$query = "update search_history set `sched` = '$sched', `frequency` = '" . $_POST["frequency"] . "', `nextrun` = $nextrun  where user_id = '" .  CCGetUserID() . "' and id = '" . $_POST["id"] . "'";
	$db->query($query);
}

class clsGridsearch { //search class @17-DDF99D24

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
    var $Sorter_value;
    var $Sorter_results;
    var $Sorter_date;
    var $Navigator;
//End Variables

//Class_Initialize Event @17-DBFE63D2
    function clsGridsearch()
    {
        global $FileName;
        $this->ComponentName = "search";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clssearchDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("searchOrder", "");
        if (!$this->SorterName)
        	$this->SorterName = "Sorter_date";
        $this->SorterDirection = CCGetParam("searchDir", "");
        if (!$this->SorterDirection)
        	$this->SorterDirection = "desc";

        $this->value = new clsControl(ccsLabel, "value", "value", ccsText, "", CCGetRequestParam("value", ccsGet));
        $this->sched = new clsControl(ccsLabel, "sched", "sched", ccsText, "", CCGetRequestParam("sched", ccsGet));
        $this->frequency = new clsControl(ccsLabel, "frequency", "frequency", ccsText, "", CCGetRequestParam("frequency", ccsGet));
        $this->results = new clsControl(ccsLabel, "results", "results", ccsText, "", CCGetRequestParam("results", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->Sorter_value = new clsSorter($this->ComponentName, "Sorter_value", $FileName);
        $this->Sorter_results = new clsSorter($this->ComponentName, "Sorter_results", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
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
                $this->value->SetValue($this->ds->value->GetValue());
                $this->sched->SetValue($this->ds->sched->GetValue());
                $this->frequency->SetValue($this->ds->frequency->GetValue());
                $this->results->SetValue($this->ds->results->GetValue());
                $this->id->SetValue($this->ds->id->GetValue());
                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->value->Show();
                $this->sched->Show();
                $this->frequency->Show();
                $this->results->Show();
                $this->id->Show();
                $this->date->Show();
                
                if ($this->ds->sched->GetValue() == "1"){
                	$notes = "<b>Scheduling set to run this search every " . $this->ds->frequency->GetValue() . " day(s)</b>";
                	$Tpl->SetVar("notes", $notes);
                }
                else 
                	$Tpl->SetVar("notes", "");
                if ($this->ds->sched->GetValue() == "1"){
                	$Tpl->SetVar("sched", "checked");
                }
                else
                	$Tpl->SetVar("sched", "");
                
                $array = explode(" :!:!:: ", $this->ds->value->GetValue());
   				$i = 0;
   				$output = "";
   				while ($array[$i]){
					$temp = explode(" ::!:!: ", $array[$i]);
					if ($temp[1] != "")
    					$output .= "<b>" . $temp[0] . "</b> = <i>\"" . $temp[1] . "\"</i><hr width=\"25\" align=\"left\">";
        			$i++;
				}
                $Tpl->SetVar("summery", $output);
                
                $array = explode(" :!:!:: ", $this->ds->results->GetValue());
                $i = 0;
				$output = "";
				while ($array[$i]){
					$temp = explode(" ::!:!: ", $array[$i]);
					if ($temp[1] != "")
    					$output .= "<a href=\"ViewItem.php?ItemNum=" . $temp[0] . "\"><b>" . $temp[1] . "</b>: <i>ItemNumber-" . $temp[0] . "</i><hr width=\"25\" align=\"left\">";
        			$i++;
				}
                $Tpl->SetVar("results", $output);
                $Tpl->SetVar("count", $i);
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_value->Show();
        $this->Sorter_results->Show();
        $this->Sorter_date->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End search Class @17-FCB6E20C

class clssearchDataSource extends clsDBNetConnect {  //searchDataSource Class @17-585CFEF7

//Variables @17-1397387B
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $value;
    var $results;
    var $id;
    var $date;
    var $sched;
    var $frequency;
//End Variables

//Class_Initialize Event @17-A2D16B02
    function clssearchDataSource()
    {
        $this->Initialize();
        $this->value = new clsField("value", ccsText, "");
        $this->sched = new clsField("sched", ccsInteger, "");
        $this->frequency = new clsField("frequency", ccsInteger, "");
        $this->results = new clsField("results", ccsText, "");
        $this->id = new clsField("id", ccsInteger, "");
        $this->date = new clsField("date", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @17-F9AD28E5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_date" => array("date", ""),
            "Sorter_value" => array("value", ""),
            "Sorter_results" => array("results", "")));
    }
//End SetOrder Method

//Prepare Method @17-4E60AF3B
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = "save IS NOT NULL";
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
        "FROM search_history";
        $this->SQL = "SELECT *  " .
        "FROM search_history";
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
        $this->value->SetDBValue($this->f("value"));
        $this->sched->SetDBValue($this->f("sched"));
        $this->frequency->SetDBValue($this->f("frequency"));
        $this->results->SetDBValue($this->f("results"));
        $this->id->SetDBValue($this->f("id"));
        $this->date->SetDBValue($this->f("date"));
    }
//End SetValues Method

} //End searchDataSource Class @17-FCB6E20C

class clsGridsearch1 { //search1 class @17-DDF99D24

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
    var $Sorter_value;
    var $Sorter_results;
    var $Sorter_date;
    var $Navigator;
//End Variables

//Class_Initialize Event @17-DBFE63D2
    function clsGridsearch1()
    {
        global $FileName;
        $this->ComponentName = "search1";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clssearch1DataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("search1Order", "");
        if (!$this->SorterName)
        	$this->SorterName = "Sorter_date";
        $this->SorterDirection = CCGetParam("search1Dir", "");
        if (!$this->SorterDirection)
        	$this->SorterDirection = "desc";

        $this->value = new clsControl(ccsLabel, "value", "value", ccsText, "", CCGetRequestParam("value", ccsGet));
        $this->results = new clsControl(ccsLabel, "results", "results", ccsText, "", CCGetRequestParam("results", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->Sorter_value = new clsSorter($this->ComponentName, "Sorter_value", $FileName);
        $this->Sorter_results = new clsSorter($this->ComponentName, "Sorter_results", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
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
                $this->value->SetValue($this->ds->value->GetValue());
                $this->results->SetValue($this->ds->results->GetValue());
                $this->id->SetValue($this->ds->id->GetValue());
                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->value->Show();
                $this->results->Show();
                $this->id->Show();
                $this->date->Show();
                
                $array = explode(" :!:!:: ", $this->ds->value->GetValue());
   				$i = 0;
   				$output = "";
   				while ($array[$i]){
					$temp = explode(" ::!:!: ", $array[$i]);
					if ($temp[1] != "")
    					$output .= "<b>" . $temp[0] . "</b> = <i>\"" . $temp[1] . "\"</i><hr width=\"25\" align=\"left\">";
        			$i++;
				}
                $Tpl->SetVar("summery", $output);
                
                $array = explode(" :!:!:: ", $this->ds->results->GetValue());
                $i = 0;
				$output = "";
				while ($array[$i]){
					$temp = explode(" ::!:!: ", $array[$i]);
					if ($temp[1] != "")
    					$output .= "<a href=\"ViewItem.php?ItemNum=" . $temp[0] . "\"><b>" . $temp[1] . "</b>: <i>ItemNumber-" . $temp[0] . "</i><hr width=\"25\" align=\"left\">";
        			$i++;
				}
                $Tpl->SetVar("results", $output);
                $Tpl->SetVar("count", $i);
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_value->Show();
        $this->Sorter_results->Show();
        $this->Sorter_date->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End search1 Class @17-FCB6E20C

class clssearch1DataSource extends clsDBNetConnect {  //search1DataSource Class @17-585CFEF7

//Variables @17-1397387B
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $value;
    var $results;
    var $id;
    var $date;
//End Variables

//Class_Initialize Event @17-A2D16B02
    function clssearch1DataSource()
    {
        $this->Initialize();
        $this->value = new clsField("value", ccsText, "");
        $this->results = new clsField("results", ccsText, "");
        $this->id = new clsField("id", ccsInteger, "");
        $this->date = new clsField("date", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @17-F9AD28E5
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_date" => array("date", ""),
            "Sorter_value" => array("value", ""),
            "Sorter_results" => array("results", "")));
    }
//End SetOrder Method

//Prepare Method @17-4E60AF3B
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("2", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->wp->Criterion[1] = "save IS NULL";
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
        "FROM search_history";
        $this->SQL = "SELECT *  " .
        "FROM search_history";
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
        $this->value->SetDBValue($this->f("value"));
        $this->results->SetDBValue($this->f("results"));
        $this->id->SetDBValue($this->f("id"));
        $this->date->SetDBValue($this->f("date"));
    }
//End SetValues Method

} //End search1DataSource Class @17-FCB6E20C

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

$FileName = "SearchManage.php";
$Redirect = "";
$TemplateFileName = "templates/SearchManage.html";
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
$search = new clsGridsearch();
$search1 = new clsGridsearch1();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$search->Initialize();
$search1->Initialize();

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
$search->Show();
$search1->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>