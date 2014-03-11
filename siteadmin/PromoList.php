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

class clsGridpromo { //charges class @10-7C16A55D

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
    var $Sorter_id;
    var $Sorter_start;
    var $Sorter_end;
    var $Sorter_amount;
    var $Sorter_code;
    var $Navigator;
//End Variables

//Class_Initialize Event @10-9B3325C4
    function clsGridpromo()
    {
        global $FileName;
        $this->ComponentName = "promo";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clspromoDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("promoOrder", "");
        $this->SorterDirection = CCGetParam("promoDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->code = new clsControl(ccsLabel, "code", "code", ccsText, "", CCGetRequestParam("code", ccsGet));
        $this->start = new clsControl(ccsLabel, "start", "start", ccsInteger, "", CCGetRequestParam("start", ccsGet));
        $this->end = new clsControl(ccsLabel, "end", "end", ccsInteger, "", CCGetRequestParam("end", ccsGet));
        $this->amount = new clsControl(ccsLabel, "amount", "amount", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("amount", ccsGet));
        $this->Sorter_id = new clsSorter($this->ComponentName, "Sorter_id", $FileName);
        $this->Sorter_code = new clsSorter($this->ComponentName, "Sorter_code", $FileName);
        $this->Sorter_start = new clsSorter($this->ComponentName, "Sorter_start", $FileName);
        $this->Sorter_end = new clsSorter($this->ComponentName, "Sorter_end", $FileName);
        $this->Sorter_amount = new clsSorter($this->ComponentName, "Sorter_amount", $FileName);
        $this->promo_Insert = new clsControl(ccsLink, "promo_Insert", "promo_Insert", ccsText, "", CCGetRequestParam("promo_Insert", ccsGet));
        $this->promo_Insert->Parameters = CCGetQueryString("QueryString", Array("id", "ccsForm"));
        $this->promo_Insert->Page = "AddPromo.php";
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

        $this->ds->Parameters["urls_id"] = CCGetFromGet("s_id", "");
        $this->ds->Parameters["urls_code"] = CCGetFromGet("s_code", "");
        $this->ds->Parameters["urls_start"] = CCGetFromGet("s_start", "");
        $this->ds->Parameters["urls_end"] = CCGetFromGet("s_end", "");
        $this->ds->Parameters["urls_amount"] = CCGetFromGet("s_amount", "");
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
                $this->Detail->Page = "PromoMaintanence.php";
                $this->id->SetValue($this->ds->id->GetValue());
                $this->code->SetValue($this->ds->code->GetValue());
                $this->start->SetValue(date("F j, Y, g:i a", $this->ds->start->GetValue()));
                $this->end->SetValue(date("F j, Y, g:i a", $this->ds->end->GetValue()));
                $this->amount->SetValue($this->ds->amount->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->id->Show();
                $this->code->Show();
                $this->start->Show();
                $this->end->Show();
                $this->amount->Show();
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
        $this->Sorter_id->Show();
        $this->Sorter_code->Show();
        $this->Sorter_start->Show();
        $this->Sorter_end->Show();
        $this->Sorter_amount->Show();
        $this->promo_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @10-FCB6E20C

class clspromoDataSource extends clsDBDBNetConnect {  //chargesDataSource Class @10-8045203E

//Variables @10-00D68E7A
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $id;
    var $code;
    var $start;
    var $end;
    var $amount;
//End Variables

//Class_Initialize Event @10-E1B868B8
    function clspromoDataSource()
    {
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        $this->code = new clsField("code", ccsText, "");
        $this->start = new clsField("start", ccsInteger, "");
        $this->end = new clsField("end", ccsInteger, "");
        $this->amount = new clsField("amount", ccsFloat, "");

    }
//End Class_Initialize Event

//SetOrder Method @10-6F085FDA
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_id" => array("id", ""),
            "Sorter_code" => array("code", ""),
            "Sorter_start" => array("start", ""),
            "Sorter_end" => array("end", ""),
            "Sorter_amount" => array("amount", "")));
    }
//End SetOrder Method

//Prepare Method @10-83DC06C7
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urls_id", ccsInteger, "", "", $this->Parameters["urls_id"], "");
        $this->wp->AddParameter("1", "urls_code", ccsInteger, "", "", $this->Parameters["urls_code"], "");
        $this->wp->AddParameter("2", "urls_start", ccsInteger, "", "", $this->Parameters["urls_start"], "");
        $this->wp->AddParameter("2", "urls_end", ccsInteger, "", "", $this->Parameters["urls_end"], "");
        $this->wp->AddParameter("3", "urls_amount", ccsFloat, "", "", $this->Parameters["urls_amount"], "");
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
        "FROM promos";
        $this->SQL = "SELECT *  " .
        "FROM promos";
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
        $this->id->SetDBValue($this->f("id"));
        $this->code->SetDBValue($this->f("code"));
        $this->start->SetDBValue($this->f("start"));
        $this->end->SetDBValue($this->f("end"));
        $this->amount->SetDBValue($this->f("amount"));
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

$FileName = "PromoList.php";
$Redirect = "";
$TemplateFileName = "Themes/PromoList.html";
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
$promo = new clsGridpromo();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$promo->Initialize();

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
$promo->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
