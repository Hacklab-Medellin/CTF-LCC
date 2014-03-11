<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @18-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridadministrators { //administrators class @2-C61C3458

//Variables @2-E2DE3ED9

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
    var $Sorter_username;
    var $Sorter_level;
    var $Sorter_firstname;
    var $Sorter_lastname;
    var $Sorter_phone;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-C26495EC
    function clsGridadministrators()
    {
        global $FileName;
        $this->ComponentName = "administrators";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsadministratorsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("administratorsOrder", "");
        $this->SorterDirection = CCGetParam("administratorsDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->username = new clsControl(ccsLabel, "username", "username", ccsText, "", CCGetRequestParam("username", ccsGet));
        $this->level = new clsControl(ccsLabel, "level", "level", ccsText, "", CCGetRequestParam("level", ccsGet));
        $this->firstname = new clsControl(ccsLabel, "firstname", "firstname", ccsText, "", CCGetRequestParam("firstname", ccsGet));
        $this->lastname = new clsControl(ccsLabel, "lastname", "lastname", ccsText, "", CCGetRequestParam("lastname", ccsGet));
        $this->phone = new clsControl(ccsLabel, "phone", "phone", ccsText, "", CCGetRequestParam("phone", ccsGet));
        $this->Sorter_username = new clsSorter($this->ComponentName, "Sorter_username", $FileName);
        $this->Sorter_level = new clsSorter($this->ComponentName, "Sorter_level", $FileName);
        $this->Sorter_firstname = new clsSorter($this->ComponentName, "Sorter_firstname", $FileName);
        $this->Sorter_lastname = new clsSorter($this->ComponentName, "Sorter_lastname", $FileName);
        $this->Sorter_phone = new clsSorter($this->ComponentName, "Sorter_phone", $FileName);
        $this->administrators_Insert = new clsControl(ccsLink, "administrators_Insert", "administrators_Insert", ccsText, "", CCGetRequestParam("administrators_Insert", ccsGet));
        $this->administrators_Insert->Parameters = CCGetQueryString("QueryString", Array("admin_id", "ccsForm"));
        $this->administrators_Insert->Page = "AdministratorsEdit.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @2-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @2-0D94CA98
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "admin_id", $this->ds->f("admin_id"));
                $this->Detail->Page = "AdministratorsEdit.php";
                $this->username->SetValue($this->ds->username->GetValue());
                if($this->ds->level->GetValue() == 1) {
					$level = "Support";
				}
				if($this->ds->level->GetValue() == 2) {
					$level = "Site Manager";
				}
				if($this->ds->level->GetValue() == 3) {
					$level = "System Administrator";
				}
				$this->level->SetValue($level);
                $this->firstname->SetValue($this->ds->firstname->GetValue());
                $this->lastname->SetValue($this->ds->lastname->GetValue());
                $this->phone->SetValue($this->ds->phone->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->username->Show();
                $this->level->Show();
                $this->firstname->Show();
                $this->lastname->Show();
                $this->phone->Show();
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
        $this->Sorter_username->Show();
        $this->Sorter_level->Show();
        $this->Sorter_firstname->Show();
        $this->Sorter_lastname->Show();
        $this->Sorter_phone->Show();
        $this->administrators_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End administrators Class @2-FCB6E20C

class clsadministratorsDataSource extends clsDBDBNetConnect {  //administratorsDataSource Class @2-15647FE2

//Variables @2-E1E13EE9
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $username;
    var $level;
    var $firstname;
    var $lastname;
    var $phone;
//End Variables

//Class_Initialize Event @2-B47F2F8A
    function clsadministratorsDataSource()
    {
        $this->Initialize();
        $this->username = new clsField("username", ccsText, "");
        $this->level = new clsField("level", ccsText, "");
        $this->firstname = new clsField("firstname", ccsText, "");
        $this->lastname = new clsField("lastname", ccsText, "");
        $this->phone = new clsField("phone", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-D2C32888
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_username" => array("username", ""), 
            "Sorter_level" => array("level", ""), 
            "Sorter_firstname" => array("firstname", ""), 
            "Sorter_lastname" => array("lastname", ""), 
            "Sorter_phone" => array("phone", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-72F9651F
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM administrators";
        $this->SQL = "SELECT *  " .
        "FROM administrators";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-B573E7FB
    function SetValues()
    {
        $this->username->SetDBValue($this->f("username"));
        $this->level->SetDBValue($this->f("level"));
        $this->firstname->SetDBValue($this->f("firstname"));
        $this->lastname->SetDBValue($this->f("lastname"));
        $this->phone->SetDBValue($this->f("phone"));
    }
//End SetValues Method

} //End administratorsDataSource Class @2-FCB6E20C

//Include Page implementation @19-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-9C122DD3
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

$FileName = "AdministratorsList.php";
$Redirect = "";
$TemplateFileName = "Themes/AdministratorsList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-6F6C4357

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$administrators = new clsGridadministrators();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$administrators->Initialize();

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

//Show Page @1-A378DD76
$Header->Show("Header");
$administrators->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
