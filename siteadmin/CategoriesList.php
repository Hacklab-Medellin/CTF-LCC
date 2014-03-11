<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @10-DC989187
include(RelativePath . "/Header.php");
//End Include Page implementation

class clsGridcategories { //categories class @12-3B8F933E

//Variables @12-84B8966C

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
    var $Sorter_name;
    var $Navigator;
//End Variables

//Class_Initialize Event @12-C74DF1D8
    function clsGridcategories()
    {
        global $FileName;
        $this->ComponentName = "categories";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscategoriesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("categoriesOrder", "");
        $this->SorterDirection = CCGetParam("categoriesDir", "");

        $this->Go = new clsControl(ccsLink, "Go", "Go", ccsText, "", CCGetRequestParam("Go", ccsGet));
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet));
        $this->weight = new clsControl(ccsLabel, "weight", "weight", ccsInteger, "", CCGetRequestParam("weight", ccsGet));
        $this->Edit = new clsControl(ccsLink, "Edit", "Edit", ccsText, "", CCGetRequestParam("Edit", ccsGet));
        $this->Sorter_name = new clsSorter($this->ComponentName, "Sorter_name", $FileName);
        $this->AddNew = new clsControl(ccsLink, "AddNew", "AddNew", ccsInteger, "", CCGetRequestParam("AddNew", ccsGet));
        $this->AddNew->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
        if((!CCGetFromGet("SUBID","")) || (CCGetFromGet("SUBID","") == "")) {
			$this->AddNew->Parameters = CCAddParam($this->AddNew->Parameters, "SUBID", 1);
		}else{
			$this->AddNew->Parameters = CCAddParam($this->AddNew->Parameters, "SUBID", CCGetFromGet("SUBID", ""));
		}
        $this->AddNew->Page = "CategoriesMaintanence.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @12-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @12-A1361C89
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["urlSUBID"] = CCGetFromGet("SUBID", "");
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
                $this->Go->SetValue($this->ds->Go->GetValue());
                $this->Go->Parameters = CCGetQueryString("QueryString", Array("ccsForm", "cat_id", "SUBID","categoriesPage"));
                $this->Go->Parameters = CCAddParam($this->Go->Parameters, "SUBID", $this->ds->f("cat_id"));
                $this->Go->Page = "CategoriesList.php";
                $this->name->SetValue($this->ds->name->GetValue());
                $this->weight->SetValue($this->ds->weight->GetValue());
                $this->Edit->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));
                $this->Edit->Parameters = CCAddParam($this->Edit->Parameters, "cat_id", $this->ds->f("cat_id"));
                $this->Edit->Page = "CategoriesMaintanence.php";
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Go->Show();
                $this->name->Show();
                $this->weight->Show();
                $this->Edit->Show();
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

        $findout = "";
		if((CCGetFromGet("SUBID","") != 1) && (CCGetFromGet("SUBID","") != ""))
		{
			$dr = new clsDBNetConnect;
			$dr->connect();
			$loc = CCGetFromGet("SUBID","");
			$find = CCDLookUp("sub_cat_id", "categories", "cat_id='" . $loc . "'", $dr);
			$findout = "<a href=\"CategoriesList.php?SUBID=" . $find . "\">Back Up One</a>";
			unset($dr);
		}
		$Tpl->SetVar("GoBack", $findout);
        $this->AddNew->SetValue(1);
        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_name->Show();
        $this->AddNew->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End categories Class @12-FCB6E20C

class clscategoriesDataSource extends clsDBDBNetConnect {  //categoriesDataSource Class @12-BF04F525

//Variables @12-B29DB787
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $Go;
    var $name;
    var $weight;
//End Variables

//Class_Initialize Event @12-D9EC1E2E
    function clscategoriesDataSource()
    {
        $this->Initialize();
        $this->Go = new clsField("Go", ccsText, "");
        $this->name = new clsField("name", ccsText, "");
        $this->weight = new clsField("weight", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @12-4DAAD63E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "weight, name";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_name" => array("name", "")));
    }
//End SetOrder Method

//Prepare Method @12-14BCDA91
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlSUBID", ccsInteger, "", "", $this->Parameters["urlSUBID"], 1);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "sub_cat_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @12-87D4B51E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM categories";
        $this->SQL = "SELECT *  " .
        "FROM categories";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @12-7E51BB4A
    function SetValues()
    {
        $this->Go->SetDBValue($this->f("sub_cat_id"));
        $this->name->SetDBValue($this->f("name"));
        $this->weight->SetDBValue($this->f("weight"));
    }
//End SetValues Method

} //End categoriesDataSource Class @12-FCB6E20C

//Include Page implementation @11-B991DFB8
include(RelativePath . "/Footer.php");
//End Include Page implementation

//Initialize Page @1-D83FE622
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

$FileName = "CategoriesList.php";
$Redirect = "";
$TemplateFileName = "Themes/CategoriesList.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-62DCC73C
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$categories = new clsGridcategories();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$categories->Initialize();

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

//Show Page @1-0396759A
$Header->Show("Header");
$categories->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
