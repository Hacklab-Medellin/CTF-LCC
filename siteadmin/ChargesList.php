<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files

//Include Page implementation @25-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridcharges { //charges class @10-7C16A55D

//Variables @10-7175D2B3

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
    var $Sorter_user_id;
    var $Sorter_date;
    var $Sorter_charge;
    var $Navigator;
//End Variables

//Class_Initialize Event @10-9B3325C4
    function clsGridcharges()
    {
        global $FileName;
        $this->ComponentName = "charges";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clschargesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("chargesOrder", "");
        $this->SorterDirection = CCGetParam("chargesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->user_id = new clsControl(ccsLabel, "user_id", "user_id", ccsInteger, "", CCGetRequestParam("user_id", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsInteger, "", CCGetRequestParam("date", ccsGet));
        $this->charge = new clsControl(ccsLabel, "charge", "charge", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("charge", ccsGet));
        $this->Sorter_user_id = new clsSorter($this->ComponentName, "Sorter_user_id", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
        $this->Sorter_charge = new clsSorter($this->ComponentName, "Sorter_charge", $FileName);
        $this->charges_Insert = new clsControl(ccsLink, "charges_Insert", "charges_Insert", ccsText, "", CCGetRequestParam("charges_Insert", ccsGet));
        $this->charges_Insert->Parameters = CCGetQueryString("QueryString", Array("charge_id", "ccsForm"));
        $this->charges_Insert->Page = "AddCharge.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @10-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @10-01332460
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["urls_user_id"] = CCGetFromGet("s_user_id", "");
        $this->ds->Parameters["urls_date"] = CCGetFromGet("s_date", "");
        $this->ds->Parameters["urls_charge"] = CCGetFromGet("s_charge", "");
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
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "charge_id", $this->ds->f("charge_id"));
                $this->Detail->Page = "ChargesMaintanence.php";
                $this->user_id->SetValue(GetUserNameID($this->ds->user_id->GetValue()));
                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                $this->charge->SetValue($this->ds->charge->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->user_id->Show();
                $this->date->Show();
                $this->charge->Show();
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
        $this->Sorter_user_id->Show();
        $this->Sorter_date->Show();
        $this->Sorter_charge->Show();
        $this->charges_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @10-FCB6E20C

class clschargesDataSource extends clsDBDBNetConnect {  //chargesDataSource Class @10-8045203E

//Variables @10-00D68E7A
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $user_id;
    var $date;
    var $charge;
//End Variables

//Class_Initialize Event @10-E1B868B8
    function clschargesDataSource()
    {
        $this->Initialize();
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->date = new clsField("date", ccsInteger, "");
        $this->charge = new clsField("charge", ccsFloat, "");

    }
//End Class_Initialize Event

//SetOrder Method @10-6F085FDA
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_user_id" => array("user_id", ""),
            "Sorter_date" => array("date", ""),
            "Sorter_charge" => array("charge", "")));
    }
//End SetOrder Method

//Prepare Method @10-83DC06C7
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urls_user_id", ccsInteger, "", "", $this->Parameters["urls_user_id"], "");
        $this->wp->AddParameter("2", "urls_date", ccsInteger, "", "", $this->Parameters["urls_date"], "");
        $this->wp->AddParameter("3", "urls_charge", ccsFloat, "", "", $this->Parameters["urls_charge"], "");
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsInteger));
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsFloat));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @10-8F321946
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

//SetValues Method @10-573DAB4F
    function SetValues()
    {
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->date->SetDBValue($this->f("date"));
        $this->charge->SetDBValue($this->f("charge"));
    }
//End SetValues Method

} //End chargesDataSource Class @10-FCB6E20C

//Include Page implementation @26-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-38458CFF
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

$FileName = "ChargesList.php";
$Redirect = "";
$TemplateFileName = "Themes/ChargesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-055029C2

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$charges = new clsGridcharges();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
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