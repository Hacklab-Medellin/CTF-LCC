<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Viewing Subscription Plans";
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
unset($db1);unset($db2);unset($db3);unset($db4);unset($db5);unset($SQL1);unset($SQL2);unset($SQL3);unset($SQL4);unset($SQL5);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation
class clsGridsubscriptions { //subscriptions class @4-DDF99D24

//Variables @4-9DA56C47

    // Public variables
    
    var $Sorter_title;
    var $Sorter_date_added;
    var $Sorter_duration;
    var $Sorter_intro_duration;
    var $Sorter_price;
    var $Sorter_intro_price;
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
    var $Navigator;
//End Variables

//Class_Initialize Event @4-9E569F9C

    function clsGridsubscriptions()
    {
        global $FileName;
                global $now;

        $this->ComponentName = "subscriptions";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clssubscriptionsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = $now["pagentrys"];
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->SorterName = CCGetParam("subscriptionsOrder", "");
        $this->SorterDirection = CCGetParam("subscriptionsDir", "");

        $this->icon = new clsControl(ccsLabel, "icon", "icon", ccsText, "", CCGetRequestParam("icon", ccsGet));
                $this->icon->HTML = true;
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->recurring = new clsControl(ccsLabel, "recurring", "recurring", ccsInteger, "", CCGetRequestParam("recurring", ccsGet));
        $this->recurring->HTML = true;
        $this->description = new clsControl(ccsLabel, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet));
        $this->intro_duration = new clsControl(ccsLabel, "intro_duration", "intro_duration", ccsText, "", CCGetRequestParam("intro_duration", ccsGet));
        $this->price = new clsControl(ccsLabel, "price", "price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("price", ccsGet));
        $this->intro_price = new clsControl(ccsLabel, "intro_price", "intro_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("intro_price", ccsGet));
        $this->date_added = new clsControl(ccsLabel, "date_added", "date_added", ccsInteger, "", CCGetRequestParam("date_added", ccsGet));
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_date_added = new clsSorter($this->ComponentName, "Sorter_date_added", $FileName);
        $this->Sorter_price = new clsSorter($this->ComponentName, "Sorter_price", $FileName);
        $this->Sorter_intro_price = new clsSorter($this->ComponentName, "Sorter_intro_price", $FileName);
        $this->Sorter_duration = new clsSorter($this->ComponentName, "Sorter_duration", $FileName);
        $this->Sorter_intro_duration = new clsSorter($this->ComponentName, "Sorter_intro_duration", $FileName);
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

//Show Method @4-B28B5156
    function Show()
    {
        global $Tpl;
        global $now;
        global $regcharges;
        if(!$this->Visible) return;

        $ShownRecords = 0;
        $featcount = 0;

        $this->ds->Parameters["urls_asking_min"] = CCGetFromGet("s_asking_min", "");
        $this->ds->Parameters["urls_asking_max"] = CCGetFromGet("s_asking_max", "");
        $this->ds->Parameters["urls_recurring"] = CCGetFromGet("s_recurring", "");
        $this->ds->Parameters["urls_quantity"] = CCGetFromGet("s_quantity", "");
        $this->ds->Parameters["urls_description"] = CCGetFromGet("s_description", "");
        $this->ds->Parameters["urls_intro_duration"] = CCGetFromGet("s_intro_duration", "");
        $this->ds->Parameters["urls_category"] = CCGetFromGet("s_category", "");
        //$this->ds->Parameters["urlCatID"] = CCGetFromGet("CatID", "");
        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;
        $uncount = 0;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
				$this->id->SetValue($this->ds->id->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                if($this->ds->recurring->GetValue() == 1){
                	$this->recurring->SetValue("<img src=\"images/recurring.gif\">");
                } else {
	                $this->recurring->SetValue("");
                }
                if($this->ds->description->GetValue() != ""){
                	$this->description->SetValue($this->ds->description->GetValue());
                } else {
                	$this->description->SetValue($this->ds->description->GetValue());
	            }
	            if ($this->ds->price->GetValue() == "0"){
            		$url = "ViewSubscriptions.php?subsc_nc=" . $this->ds->id->GetValue();
            	}
            	else {
            		$url = "subscribe.php?id=" . $this->ds->id->GetValue();
            	}
	            if ($this->ds->icon->GetValue())
	            	$this->icon->SetValue("<a href=\"" . $url . "\"><img src=\"images/" . $this->ds->icon->GetValue() . "\" border=\"0\"></a>");
	            else
	            	$this->icon->SetValue("");
                $this->intro_duration->SetValue($this->ds->intro_duration->GetValue());
                $this->price->SetValue($this->ds->price->GetValue());
                $this->intro_price->SetValue($this->ds->intro_price->GetValue());
                $theday = getdate($this->ds->date_added->GetValue());
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->date_added->SetValue($enddate);
                                unset($newdate);
                                unset($theday);
                                unset($lastofyear);
                                unset($enddate);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $Tpl->SetVar("url", $url);
                $this->icon->Show();
                $this->id->Show();
                $this->title->Show();
                $this->recurring->Show();
                $this->description->Show();
                $this->intro_duration->Show();
                $this->price->Show();
                $this->intro_price->Show();
                $this->date_added->Show();
                if ($this->ds->intro_price->GetValue())
                	$Tpl->SetVar("intro_price", $regcharges["currency"] . pricepad($this->ds->intro_price->GetValue()));
                if ($this->ds->price->GetValue())
                	$Tpl->SetVar("price", $regcharges["currency"] . pricepad($this->ds->price->GetValue()));
				if ($this->ds->unlimited->GetValue() == 1)
                	$Tpl->SetVar("duration", "Lifetime");
                elseif ($this->ds->duration->GetValue() == 1)
                	$Tpl->SetVar("duration", $this->ds->duration->GetValue() . " Day");
                else 
                	$Tpl->SetVar("duration", $this->ds->duration->GetValue() . " Days");
                if ($this->ds->intro_duration->GetValue() > 9999)
                	$Tpl->SetVar("intro_duration", "Lifetime");
                elseif ($this->ds->intro_duration->GetValue() == 1)
                	$Tpl->SetVar("intro_duration", $this->ds->intro_duration->GetValue() . " Day");
                elseif ($this->ds->intro_duration->GetValue() == 0)
                	$Tpl->SetVar("intro_duration", $this->ds->intro_duration->GetValue() . "&nbsp;");
                else 
                	$Tpl->SetVar("intro_duration", $this->ds->intro_duration->GetValue() . " Days");
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->SetVar("CloseSubsc", "<tr class=\"wtbk\"><td class=\"feat\" colspan=\"6\">No Subscription Plans Availible or Active</td></tr>");
            $Tpl->parse("NoRecords", false);
        }

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_title->Show();
        $this->Sorter_date_added->Show();
        $this->Sorter_price->Show();
        $this->Sorter_intro_price->Show();
        $this->Sorter_duration->Show();
        $this->Sorter_intro_duration->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method



} //End subscriptions Class @4-FCB6E20C

class clssubscriptionsDataSource extends clsDBNetConnect {  //subscriptionsDataSource Class @4-585CFEF7

//Variables @4-B95100AA
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $icon;
    var $id;
    var $title;
    var $recurring;
    var $description;
    var $intro_duration;
    var $duration;
    var $price;
    var $intro_price;
    var $date_added;
//End Variables

//Class_Initialize Event @4-23F7FF01
    function clssubscriptionsDataSource()
    {
        $this->Initialize();
        $this->icon = new clsField("icon", ccsText, "");;
        $this->id = new clsField("id", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->recurring = new clsField("recurring", ccsInteger, "");
        $this->description = new clsField("description", ccsText, "");
        $this->intro_duration = new clsField("intro_duration", ccsText, "");
        $this->duration = new clsField("duration", ccsText, "");
        $this->unlimited = new clsField("unlimited", ccsText, "");
        $this->price = new clsField("price", ccsFloat, "");
        $this->intro_price = new clsField("intro_price", ccsFloat, "");
        $this->date_added = new clsField("date_added", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-CD06A131
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "Duration desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_title" => array("title", ""),
            "Sorter_date_added" => array("date_added", ""),
			"Sorter_price" => array("price", ""),
			"Sorter_intro_price" => array("intro_price", ""),
			"Sorter_duration" => array("duration", ""),
			"Sorter_intro_duration" => array("intro_duration", "")));
    }
//End SetOrder Method

//Prepare Method @4-51CF56E0
    function Prepare()
    {
        $this->Where = "active = 1";
        }
//End Prepare Method

//Open Method @4-368AA817
    function Open()
    {
                global $Tpl;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM subscription_plans";
        $this->SQL = "SELECT *  " .
        "FROM subscription_plans";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
                $Tpl->SetVar("Results", $this->nf());
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-79E41A72
    function SetValues()
    {
        $this->icon->SetDBValue($this->f("icon"));
        $this->id->SetDBValue($this->f("id"));
        $this->title->SetDBValue($this->f("title"));
        $this->recurring->SetDBValue($this->f("recurring"));
        $this->description->SetDBValue($this->f("description"));
        $this->intro_duration->SetDBValue($this->f("intro_duration"));
        $this->duration->SetDBValue($this->f("duration"));
        $this->unlimited->SetDBValue($this->f("unlimited"));
        $this->price->SetDBValue($this->f("price"));
        $this->intro_price->SetDBValue($this->f("intro_price"));
        $this->date_added->SetDBValue($this->f("date_added"));
    }
//End SetValues Method

} //End subscriptionsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-F4925B03
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
$FileName = "ViewSubscriptions.php";
$Redirect = "";
$TemplateFileName = "templates/ViewSubscriptions.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-95636333

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$subscriptions = new clsGridsubscriptions();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$subscriptions->Initialize();

// Events
//include("./ViewCat_events.php");
//BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-B06FCBC8
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

if ($_GET["subsc_nc"]){
	freesubsc($_GET["subsc_nc"]);
}

function freesubsc($id){
	CCSecurityRedirect("1;2", "login.php", "ViewSubscriptions.php", CCGetQueryString("QueryString", ""));
	$db = new clsDBNetConnect;
	$query = "select * from subscription_plans where id = " . $id . " and price = '0.00'";
	$db->query($query);
	if ($db->next_record()){
		subscribe(CCGetUserID(), $id, "0.00");
	}
	header("Location: myaccount.php");
}

//Show Page @1-7E62AA77
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
