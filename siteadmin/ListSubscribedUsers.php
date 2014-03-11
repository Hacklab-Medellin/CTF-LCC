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
    var $Sorter_expires;
    var $Sorter_active;
    var $Sorter_user_id;
    var $Sorter_email;
    var $Sorter_paid;
    var $Sorter_subsc_id;
    var $Sorter_date;
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
        $this->expires = new clsControl(ccsLabel, "expires", "expires", ccsText, "", CCGetRequestParam("expires", ccsGet));
        $this->active = new clsControl(ccsLabel, "active", "active", ccsText, "", CCGetRequestParam("active", ccsGet));
        $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsText, "", CCGetRequestParam("user_id", ccsGet));
        $this->email = new clsControl(ccsLabel, "email", "email", ccsText, "", CCGetRequestParam("email", ccsGet));
        $this->email->HTML = true;
        $this->paid = new clsControl(ccsLabel, "paid", "paid", ccsText, "", CCGetRequestParam("paid", ccsGet));
        $this->subsc_id = new clsControl(ccsLabel, "subsc_id", "subsc_id", ccsText, "", CCGetRequestParam("subsc_id", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsInteger, "", CCGetRequestParam("date", ccsGet));
        $this->Sorter_expires = new clsSorter($this->ComponentName, "Sorter_expires", $FileName);
        $this->Sorter_active = new clsSorter($this->ComponentName, "Sorter_active", $FileName);
        $this->Sorter_user_id = new clsSorter($this->ComponentName, "Sorter_user_id", $FileName);
        $this->Sorter_email = new clsSorter($this->ComponentName, "Sorter_email", $FileName);
        $this->Sorter_paid = new clsSorter($this->ComponentName, "Sorter_paid", $FileName);
        $this->Sorter_subsc_id = new clsSorter($this->ComponentName, "Sorter_subsc_id", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
        $this->users_Insert = new clsControl(ccsLink, "users_Insert", "users_Insert", ccsText, "", CCGetRequestParam("users_Insert", ccsGet));
        $this->users_Insert->Parameters = CCGetQueryString("QueryString", Array("user_id", "ccsForm"));
        $this->users_Insert->Page = "SubscribedUserMaintanence.php";
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
        $this->ds->Parameters["urlexpires"] = CCGetFromGet("expires", "");
        $this->ds->Parameters["urlactive"] = CCGetFromGet("active", "");
        $this->ds->Parameters["urluser_id"] = CCGetFromGet("user_id", "");
        $this->ds->Parameters["urlemail"] = CCGetFromGet("email", "");
        $this->ds->Parameters["urlpaid"] = CCGetFromGet("paid", "");
        $this->ds->Parameters["urlsubsc_id"] = CCGetFromGet("subsc_id", "");
        $this->ds->Parameters["urldate"] = CCGetFromGet("date", "");
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
                $this->Detail->Page = "SubscribedUserMaintanence.php";
                $this->expires->SetValue(date("F j, Y, g:i a", $this->ds->expires->GetValue()));
                if ($this->ds->active->GetValue() == 1)
                	$this->active->SetValue("Yes");
                else
                	$this->active->SetValue("No");
                $this->user_id->SetValue($this->ds->user_id->GetValue());
                $this->email->SetValue($this->ds->email->GetValue());
                $this->paid->SetValue($this->ds->paid->GetValue());
                $this->subsc_id->SetValue($this->ds->subsc_id->GetValue());
                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->expires->Show();
                $this->active->Show();
                $this->user_id->Show();
                $this->email->Show();
                $this->paid->Show();
                $this->subsc_id->Show();
                $this->date->Show();
                $db = new clsDBNetConnect;
                $query = "select user_login, email from users where user_id = " . $this->ds->user_id->GetValue();
                $db->query($query);
                if ($db->next_record()){
                	$Tpl->setVar("username", $db->f("user_login"));
                	$Tpl->setVar("email", $db->f("email"));
                }
                $query = "select title from subscription_plans where id = " . $this->ds->subsc_id->GetValue();
                $db->query($query);
                if ($db->next_record()){
                	$Tpl->setVar("subscription", $db->f("title"));
                }
                if ($this->ds->expires->GetValue() == 9999999999)
                	$Tpl->setVar("expires", "Never");
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
        $this->Sorter_expires->Show();
        $this->Sorter_active->Show();
        $this->Sorter_user_id->Show();
        $this->Sorter_email->Show();
        $this->Sorter_paid->Show();
        $this->Sorter_subsc_id->Show();
        $this->Sorter_date->Show();
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
    var $expires;
    var $active;
    var $user_id;
    var $email;
    var $paid;
    var $subsc_id;
    var $date;
//End Variables

//Class_Initialize Event @27-9A3578FA
    function clsusersDataSource()
    {
        $this->Initialize();
        $this->expires = new clsField("expires", ccsText, "");
        $this->active = new clsField("active", ccsText, "");
        $this->user_id = new clsField("user_id", ccsText, "");
        $this->email = new clsField("email", ccsText, "");
        $this->paid = new clsField("paid", ccsText, "");
        $this->subsc_id = new clsField("subsc_id", ccsText, "");
        $this->date = new clsField("date", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @27-E81C15F9
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_expires" => array("expires", ""), 
            "Sorter_active" => array("active", ""), 
            "Sorter_user_id" => array("user_id", ""), 
            "Sorter_email" => array("email", ""), 
            "Sorter_paid" => array("paid", ""), 
            "Sorter_subsc_id" => array("subsc_id", ""), 
            "Sorter_date" => array("date", "")));
    }
//End SetOrder Method

//Prepare Method @27-6FE06659
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urluser_id", ccsInteger, "", "", $this->Parameters["urluser_id"], "");
        $this->wp->AddParameter("2", "urlexpires", ccsText, "", "", $this->Parameters["urlexpires"], "");
        $this->wp->AddParameter("3", "urluser_id", ccsText, "", "", $this->Parameters["urluser_id"], "");
        $this->wp->AddParameter("4", "urlemail", ccsText, "", "", $this->Parameters["urlemail"], "");
        $this->wp->AddParameter("5", "urlpaid", ccsText, "", "", $this->Parameters["urlpaid"], "");
        $this->wp->AddParameter("6", "urlsubsc_id", ccsText, "", "", $this->Parameters["urlsubsc_id"], "");
        $this->wp->AddParameter("7", "urldate", ccsInteger, "", "", $this->Parameters["urldate"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opContains, "expires", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText));
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "user_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText));
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "email", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText));
        $this->wp->Criterion[5] = $this->wp->Operation(opContains, "paid", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsText));
        $this->wp->Criterion[6] = $this->wp->Operation(opContains, "subsc_id", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsText));
        $this->wp->Criterion[7] = $this->wp->Operation(opEqual, "date", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]), $this->wp->Criterion[4]), $this->wp->Criterion[5]), $this->wp->Criterion[6]), $this->wp->Criterion[7]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @27-28C412B2
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM used_subscriptions";
        $this->SQL = "SELECT *  " .
        "FROM used_subscriptions";
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
        $this->expires->SetDBValue($this->f("expires"));
        $this->active->SetDBValue($this->f("active"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->email->SetDBValue($this->f("email"));
        $this->paid->SetDBValue($this->f("paid"));
        $this->subsc_id->SetDBValue($this->f("subsc_id"));
        $this->date->SetDBValue($this->f("date"));
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

$FileName = "ListSubscribedUsers.php";
$Redirect = "";
$TemplateFileName = "Themes/ListSubscribedUsers.html";
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
