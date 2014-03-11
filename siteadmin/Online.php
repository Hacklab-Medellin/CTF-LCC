<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files
$db1 = new clsDBDBNetConnect;
$db1->connect();
$times = time();
$SQL1 = "DELETE FROM online WHERE datet < $times";
$db1->query($SQL1);
//Include Page implementation @13-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridonline { //online class @2-AA5BB468

//Variables @2-A73A82D3

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
    var $Sorter_ip;
    var $Sorter_datet;
    var $Sorter_user;
    var $Sorter_page;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-CFFAA1D2
    function clsGridonline()
    {
        global $FileName;
        $this->ComponentName = "online";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsonlineDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("onlineOrder", "");
        $this->SorterDirection = CCGetParam("onlineDir", "");

        $this->ip = new clsControl(ccsLabel, "ip", "ip", ccsText, "", CCGetRequestParam("ip", ccsGet));
        $this->datet = new clsControl(ccsLabel, "datet", "datet", ccsText, "", CCGetRequestParam("datet", ccsGet));
        $this->user = new clsControl(ccsLabel, "user", "user", ccsText, "", CCGetRequestParam("user", ccsGet));
        $this->page = new clsControl(ccsLabel, "page", "page", ccsText, "", CCGetRequestParam("page", ccsGet));
        $this->page->HTML = true;
        $this->Sorter_ip = new clsSorter($this->ComponentName, "Sorter_ip", $FileName);
        $this->Sorter_datet = new clsSorter($this->ComponentName, "Sorter_datet", $FileName);
        $this->Sorter_user = new clsSorter($this->ComponentName, "Sorter_user", $FileName);
        $this->Sorter_page = new clsSorter($this->ComponentName, "Sorter_page", $FileName);
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

//Show Method @2-67EFFE22
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
                $this->ip->SetValue($this->ds->ip->GetValue());
                $twodays = $this->ds->datet->GetValue();
				$theday = getdate($twodays);
				$lastofyear = substr($theday["year"],-2);
				$enddate = $theday["hours"] . ":" . $theday["minutes"] . " " . $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
				$ontime = date("F j, Y, g:i a", $this->ds->datet->GetValue());
				$this->datet->SetValue($ontime);
                $this->user->SetValue($this->ds->user->GetValue());
                $this->page->SetValue($this->ds->page->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->ip->Show();
                $this->datet->Show();
                $this->user->Show();
                $this->page->Show();
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
        $this->Sorter_ip->Show();
        $this->Sorter_datet->Show();
        $this->Sorter_user->Show();
        $this->Sorter_page->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End online Class @2-FCB6E20C

class clsonlineDataSource extends clsDBDBNetConnect {  //onlineDataSource Class @2-ED27E76C

//Variables @2-64108BF7
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $ip;
    var $datet;
    var $user;
    var $page;
//End Variables

//Class_Initialize Event @2-EB04A45A
    function clsonlineDataSource()
    {
        $this->Initialize();
        $this->ip = new clsField("ip", ccsText, "");
        $this->datet = new clsField("datet", ccsText, "");
        $this->user = new clsField("user", ccsText, "");
        $this->page = new clsField("page", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-55667DD3
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_ip" => array("ip", ""), 
            "Sorter_datet" => array("datet", ""), 
            "Sorter_user" => array("user", ""), 
            "Sorter_page" => array("page", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-C696A05D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM online";
        $this->SQL = "SELECT *  " .
        "FROM online";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-E2FB8878
    function SetValues()
    {
        $this->ip->SetDBValue($this->f("ip"));
        $this->datet->SetDBValue($this->f("datet"));
        $this->user->SetDBValue($this->f("user"));
        $this->page->SetDBValue($this->f("page"));
    }
//End SetValues Method

} //End onlineDataSource Class @2-FCB6E20C

//Include Page implementation @14-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-A97E1204
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

$FileName = "Online.php";
$Redirect = "";
$TemplateFileName = "Themes/Online.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-1F7E7A9C

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$online = new clsGridonline();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$online->Initialize();

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

//Show Page @1-74801868
$Header->Show("Header");
$online->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
