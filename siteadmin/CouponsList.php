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

class clsGridcoupons { //charges class @10-7C16A55D

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
    var $Sorter_discount;
    var $Sorter_code;
    var $Navigator;
//End Variables

//Class_Initialize Event @10-9B3325C4
    function clsGridcoupons()
    {
        global $FileName;
        $this->ComponentName = "coupons";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscouponsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("couponsOrder", "");
        $this->SorterDirection = CCGetParam("couponsDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->code = new clsControl(ccsLabel, "code", "code", ccsText, "", CCGetRequestParam("code", ccsGet));
        $this->start = new clsControl(ccsLabel, "start", "start", ccsInteger, "", CCGetRequestParam("start", ccsGet));
        $this->end = new clsControl(ccsLabel, "end", "end", ccsInteger, "", CCGetRequestParam("end", ccsGet));
        $this->discount = new clsControl(ccsLabel, "discount", "discount", ccsInteger, "", CCGetRequestParam("discount", ccsGet));
        $this->Sorter_id = new clsSorter($this->ComponentName, "Sorter_id", $FileName);
        $this->Sorter_code = new clsSorter($this->ComponentName, "Sorter_code", $FileName);
        $this->Sorter_start = new clsSorter($this->ComponentName, "Sorter_start", $FileName);
        $this->Sorter_end = new clsSorter($this->ComponentName, "Sorter_end", $FileName);
        $this->Sorter_discount = new clsSorter($this->ComponentName, "Sorter_discount", $FileName);
        $this->coupons_Insert = new clsControl(ccsLink, "coupons_Insert", "coupons_Insert", ccsText, "", CCGetRequestParam("coupons_Insert", ccsGet));
        $this->coupons_Insert->Parameters = CCGetQueryString("QueryString", Array("id", "ccsForm"));
        $this->coupons_Insert->Page = "AddCoupons.php";
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
        $this->ds->Parameters["urls_discount"] = CCGetFromGet("s_discount", "");
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
                $this->Detail->Page = "CouponsMaintanence.php";
                $this->id->SetValue($this->ds->id->GetValue());
                $this->code->SetValue($this->ds->code->GetValue());
                $this->start->SetValue(date("F j, Y, g:i a", $this->ds->start->GetValue()));
                $this->end->SetValue(date("F j, Y, g:i a", $this->ds->end->GetValue()));
                $this->discount->SetValue($this->ds->discount->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->id->Show();
                $this->code->Show();
                $this->start->Show();
                $this->end->Show();
                $this->discount->Show();
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
        $this->Sorter_discount->Show();
        $this->coupons_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @10-FCB6E20C

class clscouponsDataSource extends clsDBDBNetConnect {  //chargesDataSource Class @10-8045203E

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
    var $discount;
//End Variables

//Class_Initialize Event @10-E1B868B8
    function clscouponsDataSource()
    {
        $this->Initialize();
        $this->id = new clsField("id", ccsInteger, "");
        $this->code = new clsField("code", ccsText, "");
        $this->start = new clsField("start", ccsInteger, "");
        $this->end = new clsField("end", ccsInteger, "");
        $this->discount = new clsField("discount", ccsInteger, "");

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
            "Sorter_discount" => array("discount", "")));
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
        $this->wp->AddParameter("3", "urls_discount", ccsFloat, "", "", $this->Parameters["urls_discount"], "");
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
        "FROM coupons";
        $this->SQL = "SELECT *  " .
        "FROM coupons";
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
        $this->discount->SetDBValue(($this->f("discount")*100));
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

$FileName = "CouponsList.php";
$Redirect = "";
$TemplateFileName = "Themes/CouponsList.html";
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
$coupons = new clsGridcoupons();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$coupons->Initialize();

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
$coupons->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
