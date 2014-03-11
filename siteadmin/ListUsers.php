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

class clsGridusers { //users class @27-0CB76799

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
    var $Sorter_first_name;
    var $Sorter_last_name;
    var $Sorter_user_login;
    var $Sorter_email;
    var $Sorter_state_id;
    var $Sorter_city;
    var $Sorter_date_created;
    var $Navigator;
//End Variables

//Class_Initialize Event @27-0AB91495
    function clsGridusers()
    {
        global $FileName;
        $this->ComponentName = "users";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsusersDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("usersOrder", "");
        $this->SorterDirection = CCGetParam("usersDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->first_name = new clsControl(ccsLabel, "first_name", "first_name", ccsText, "", CCGetRequestParam("first_name", ccsGet));
        $this->last_name = new clsControl(ccsLabel, "last_name", "last_name", ccsText, "", CCGetRequestParam("last_name", ccsGet));
        $this->user_login = new clsControl(ccsLabel, "user_login", "user_login", ccsText, "", CCGetRequestParam("user_login", ccsGet));
        $this->email = new clsControl(ccsLabel, "email", "email", ccsText, "", CCGetRequestParam("email", ccsGet));
        $this->email->HTML = true;
        $this->state_id = new clsControl(ccsLabel, "state_id", "state_id", ccsText, "", CCGetRequestParam("state_id", ccsGet));
        $this->city = new clsControl(ccsLabel, "city", "city", ccsText, "", CCGetRequestParam("city", ccsGet));
        $this->date_created = new clsControl(ccsLabel, "date_created", "date_created", ccsInteger, "", CCGetRequestParam("date_created", ccsGet));
        $this->Sorter_first_name = new clsSorter($this->ComponentName, "Sorter_first_name", $FileName);
        $this->Sorter_last_name = new clsSorter($this->ComponentName, "Sorter_last_name", $FileName);
        $this->Sorter_user_login = new clsSorter($this->ComponentName, "Sorter_user_login", $FileName);
        $this->Sorter_email = new clsSorter($this->ComponentName, "Sorter_email", $FileName);
        $this->Sorter_state_id = new clsSorter($this->ComponentName, "Sorter_state_id", $FileName);
        $this->Sorter_city = new clsSorter($this->ComponentName, "Sorter_city", $FileName);
        $this->Sorter_date_created = new clsSorter($this->ComponentName, "Sorter_date_created", $FileName);
        $this->users_Insert = new clsControl(ccsLink, "users_Insert", "users_Insert", ccsText, "", CCGetRequestParam("users_Insert", ccsGet));
        $this->users_Insert->Parameters = CCGetQueryString("QueryString", Array("user_id", "ccsForm"));
        $this->users_Insert->Page = "UserMaintanence.php";
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
        $this->ds->Parameters["urlfirst_name"] = CCGetFromGet("first_name", "");
        $this->ds->Parameters["urllast_name"] = CCGetFromGet("last_name", "");
        $this->ds->Parameters["urluser_login"] = CCGetFromGet("user_login", "");
        $this->ds->Parameters["urlemail"] = CCGetFromGet("email", "");
        $this->ds->Parameters["urlstate_id"] = CCGetFromGet("state_id", "");
        $this->ds->Parameters["urlcity"] = CCGetFromGet("city", "");
        $this->ds->Parameters["urldate_created"] = CCGetFromGet("date_created", "");
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "user_id", $this->ds->f("user_id"));
                $this->Detail->Page = "UserMaintanence.php";
                $this->first_name->SetValue($this->ds->first_name->GetValue());
                $this->last_name->SetValue($this->ds->last_name->GetValue());
                $this->user_login->SetValue($this->ds->user_login->GetValue());
                $this->email->SetValue($this->ds->email->GetValue());
                $this->state_id->SetValue($this->ds->state_id->GetValue());
                $this->city->SetValue($this->ds->city->GetValue());
                $this->date_created->SetValue(date("F j, Y, g:i a", $this->ds->date_created->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->first_name->Show();
                $this->last_name->Show();
                $this->user_login->Show();
                $this->email->Show();
                $this->state_id->Show();
                $this->city->Show();
                $this->date_created->Show();
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
        $this->Sorter_first_name->Show();
        $this->Sorter_last_name->Show();
        $this->Sorter_user_login->Show();
        $this->Sorter_email->Show();
        $this->Sorter_state_id->Show();
        $this->Sorter_city->Show();
        $this->Sorter_date_created->Show();
        $this->users_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End users Class @27-FCB6E20C

class clsusersDataSource extends clsDBDBNetConnect {  //usersDataSource Class @27-76F0F9D9

//Variables @27-15432E00
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $first_name;
    var $last_name;
    var $user_login;
    var $email;
    var $state_id;
    var $city;
    var $date_created;
//End Variables

//Class_Initialize Event @27-9A3578FA
    function clsusersDataSource()
    {
        $this->Initialize();
        $this->first_name = new clsField("first_name", ccsText, "");
        $this->last_name = new clsField("last_name", ccsText, "");
        $this->user_login = new clsField("user_login", ccsText, "");
        $this->email = new clsField("email", ccsText, "");
        $this->state_id = new clsField("state_id", ccsText, "");
        $this->city = new clsField("city", ccsText, "");
        $this->date_created = new clsField("date_created", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @27-E81C15F9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date_created desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_first_name" => array("first_name", ""), 
            "Sorter_last_name" => array("last_name", ""), 
            "Sorter_user_login" => array("user_login", ""), 
            "Sorter_email" => array("email", ""), 
            "Sorter_state_id" => array("state_id", ""), 
            "Sorter_city" => array("city", ""), 
            "Sorter_date_created" => array("date_created", "")));
    }
//End SetOrder Method

//Prepare Method @27-6FE06659
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "");
        $this->wp->AddParameter("2", "urlfirst_name", ccsText, "", "", $this->Parameters["urlfirst_name"], "");
        $this->wp->AddParameter("3", "urllast_name", ccsText, "", "", $this->Parameters["urllast_name"], "");
        $this->wp->AddParameter("4", "urluser_login", ccsText, "", "", $this->Parameters["urluser_login"], "");
        $this->wp->AddParameter("5", "urlemail", ccsText, "", "", $this->Parameters["urlemail"], "");
        $this->wp->AddParameter("6", "urlstate_id", ccsText, "", "", $this->Parameters["urlstate_id"], "");
        $this->wp->AddParameter("7", "urlcity", ccsText, "", "", $this->Parameters["urlcity"], "");
        $this->wp->AddParameter("8", "urldate_created", ccsInteger, "", "", $this->Parameters["urldate_created"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "first_name", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText));
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "last_name", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText));
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "user_login", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText));
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "email", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText));
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "state_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText));
        $this->wp->Criterion[7] = $this->wp->Operation(opContains, "city", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsText));
        $this->wp->Criterion[8] = $this->wp->Operation(opEqual, "date_created", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]), $this->wp->Criterion[6]), $this->wp->Criterion[7]), $this->wp->Criterion[8]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @27-28C412B2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM users";
        $this->SQL = "SELECT *  " .
        "FROM users";
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
        $this->first_name->SetDBValue($this->f("first_name"));
        $this->last_name->SetDBValue($this->f("last_name"));
        $this->user_login->SetDBValue($this->f("user_login"));
        $this->email->SetDBValue($this->f("email"));
        $this->state_id->SetDBValue($this->f("state_id"));
        $this->city->SetDBValue($this->f("city"));
        $this->date_created->SetDBValue($this->f("date_created"));
    }
//End SetValues Method

} //End usersDataSource Class @27-FCB6E20C

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

$FileName = "ListUsers.php";
$Redirect = "";
$TemplateFileName = "Themes/ListUsers.html";
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
$users = new clsGridusers();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$users->Initialize();

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
$users->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
