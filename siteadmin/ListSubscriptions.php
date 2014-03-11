<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @69-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridsubscription_plans { //subscription_plans class @27-0CB76799

//Variables @27-D02BF080

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
    var $Sorter_description;
    var $Sorter_group;
    var $Sorter_duration;
    var $Sorter_price;
    var $Sorter_recurring;
    var $Sorter_date_added;
    var $Navigator;
//End Variables

//Class_Initialize Event @27-0AB91495
    function clsGridsubscription_plans()
    {
        global $FileName;
        $this->ComponentName = "subscription_plans";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clssubscription_plansDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("subscription_plansOrder", "");
        $this->SorterDirection = CCGetParam("subscription_plansDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->description = new clsControl(ccsLabel, "description", "description", ccsText, "", CCGetRequestParam("description", ccsGet));
        $this->group = new clsControl(ccsLabel, "group", "group", ccsText, "", CCGetRequestParam("group", ccsGet));
        $this->duration = new clsControl(ccsLabel, "duration", "duration", ccsText, "", CCGetRequestParam("duration", ccsGet));
        $this->duration->HTML = true;
        $this->price = new clsControl(ccsLabel, "price", "price", ccsText, "", CCGetRequestParam("price", ccsGet));
        $this->recurring = new clsControl(ccsLabel, "recurring", "recurring", ccsText, "", CCGetRequestParam("recurring", ccsGet));
        $this->date_added = new clsControl(ccsLabel, "date_added", "date_added", ccsInteger, "", CCGetRequestParam("date_added", ccsGet));
        $this->Sorter_title = new clsSorter($this->ComponentName, "Sorter_title", $FileName);
        $this->Sorter_description = new clsSorter($this->ComponentName, "Sorter_description", $FileName);
        $this->Sorter_group = new clsSorter($this->ComponentName, "Sorter_group", $FileName);
        $this->Sorter_duration = new clsSorter($this->ComponentName, "Sorter_duration", $FileName);
        $this->Sorter_price = new clsSorter($this->ComponentName, "Sorter_price", $FileName);
        $this->Sorter_recurring = new clsSorter($this->ComponentName, "Sorter_recurring", $FileName);
        $this->Sorter_date_added = new clsSorter($this->ComponentName, "Sorter_date_added", $FileName);
        $this->subscription_plans_Insert = new clsControl(ccsLink, "subscription_plans_Insert", "subscription_plans_Insert", ccsText, "", CCGetRequestParam("subscription_plans_Insert", ccsGet));
        $this->subscription_plans_Insert->Parameters = CCGetQueryString("QueryString", Array("id", "ccsForm"));
        $this->subscription_plans_Insert->Page = "AddSubscription.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
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

//Show Method @27-7FB8181B
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["urluser_id"] = CCGetFromGet("user_id", "");
        $this->ds->Parameters["urltitle"] = CCGetFromGet("title", "");
        $this->ds->Parameters["urldescription"] = CCGetFromGet("description", "");
        $this->ds->Parameters["urlgroup"] = CCGetFromGet("group", "");
        $this->ds->Parameters["urlduration"] = CCGetFromGet("duration", "");
        $this->ds->Parameters["urlprice"] = CCGetFromGet("price", "");
        $this->ds->Parameters["urlrecurring"] = CCGetFromGet("recurring", "");
        $this->ds->Parameters["urldate_added"] = CCGetFromGet("date_added", "");
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
                $this->Detail->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "id", $this->ds->f("id"));
                $this->Detail->Page = "AddSubscription.php";
                $this->title->SetValue($this->ds->title->GetValue());
                $this->description->SetValue($this->ds->description->GetValue());
                $this->group->SetValue($this->ds->group->GetValue());
                $this->duration->SetValue($this->ds->duration->GetValue());
                $this->price->SetValue($this->ds->price->GetValue());
                $this->recurring->SetValue($this->ds->recurring->GetValue());
                $this->date_added->SetValue(date("F j, Y, g:i a", $this->ds->date_added->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->title->Show();
                $this->description->Show();
                $this->group->Show();
                $db = new clsDBNetConnect;
                $query = "select title from groups where id = " . $this->ds->group->GetValue();
                $db->query($query);
                if ($db->next_record())
                	$Tpl->setVar("group", $db->f("title"));
                $this->duration->Show();
                $this->price->Show();
                $this->recurring->Show();
                if ($this->ds->recurring->GetValue() == 1)
                	$Tpl->SetVar("recurring", "Yes");
                if ($this->ds->recurring->GetValue() == 0)
                	$Tpl->SetVar("recurring", "No");
                if ($this->ds->unlimited->GetValue() == 1)
                	$Tpl->SetVar("duration", "Unlimited");
                $this->date_added->Show();
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
        $this->Sorter_description->Show();
        $this->Sorter_group->Show();
        $this->Sorter_duration->Show();
        $this->Sorter_price->Show();
        $this->Sorter_recurring->Show();
        $this->Sorter_date_added->Show();
        $this->subscription_plans_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End subscription_plans Class @27-FCB6E20C

class clssubscription_plansDataSource extends clsDBDBNetConnect {  //subscription_plansDataSource Class @27-76F0F9D9

//Variables @27-15432E00
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $title;
    var $description;
    var $group;
    var $duration;
    var $price;
    var $recurring;
    var $date_added;
//End Variables

//Class_Initialize Event @27-9A3578FA
    function clssubscription_plansDataSource()
    {
        $this->Initialize();
        $this->title = new clsField("title", ccsText, "");
        $this->description = new clsField("description", ccsText, "");
        $this->group = new clsField("group", ccsText, "");
        $this->duration = new clsField("duration", ccsText, "");
        $this->unlimited = new clsField("unlimited", ccsText, "");
        $this->price = new clsField("price", ccsText, "");
        $this->recurring = new clsField("recurring", ccsText, "");
        $this->date_added = new clsField("date_added", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @27-E81C15F9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date_added desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_title" => array("title", ""), 
            "Sorter_description" => array("description", ""), 
            "Sorter_group" => array("group", ""), 
            "Sorter_duration" => array("duration", ""), 
            "Sorter_price" => array("price", ""), 
            "Sorter_recurring" => array("recurring", ""), 
            "Sorter_date_added" => array("date_added", "")));
    }
//End SetOrder Method

//Prepare Method @27-6FE06659
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "");
        $this->wp->AddParameter("2", "urltitle", ccsText, "", "", $this->Parameters["urltitle"], "");
        $this->wp->AddParameter("3", "urldescription", ccsText, "", "", $this->Parameters["urldescription"], "");
        $this->wp->AddParameter("4", "urlgroup", ccsText, "", "", $this->Parameters["urlgroup"], "");
        $this->wp->AddParameter("5", "urlduration", ccsText, "", "", $this->Parameters["urlduration"], "");
        $this->wp->AddParameter("6", "urlprice", ccsText, "", "", $this->Parameters["urlprice"], "");
        $this->wp->AddParameter("7", "urlrecurring", ccsText, "", "", $this->Parameters["urlrecurring"], "");
        $this->wp->AddParameter("8", "urldate_added", ccsInteger, "", "", $this->Parameters["urldate_added"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "title", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText));
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "description", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText));
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "group", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText));
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "duration", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText));
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "price", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText));
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "recurring", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText));
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "date_added", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]), $this->wp->Criterion[6]), $this->wp->Criterion[7]), $this->wp->Criterion[8]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @27-28C412B2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM subscription_plans";
        $this->SQL = "SELECT *  " .
        "FROM subscription_plans";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @27-97F908DB
    function SetValues()
    {
        $this->title->SetDBValue($this->f("title"));
        $this->description->SetDBValue($this->f("description"));
        $this->group->SetDBValue($this->f("group"));
        $this->duration->SetDBValue($this->f("duration"));
        $this->unlimited->SetDBValue($this->f("unlimited"));
        $this->price->SetDBValue($this->f("price"));
        $this->recurring->SetDBValue($this->f("recurring"));
        $this->date_added->SetDBValue($this->f("date_added"));
    }
//End SetValues Method

} //End subscription_plansDataSource Class @27-FCB6E20C

//Include Page implementation @70-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-48A88FF0
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

$FileName = "ListSubscriptions.php";
$Redirect = "";
$TemplateFileName = "Themes/ListSubscriptions.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-5A59F09E

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$subscription_plans = new clsGridsubscription_plans();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$subscription_plans->Initialize();

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
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-8D0414C5
$Header->Show("Header");
$subscription_plans->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
