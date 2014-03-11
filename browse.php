<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
//End Include Common Files

$page="Browsing Categories";
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
unset($db1);
unset($db2);
unset($db3);
unset($db4);
unset($db5);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

class clsGridcategories { //categories class @4-3B8F933E

//Variables @4-9AD3C4FA

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
//End Variables

//Class_Initialize Event @4-2B9DD648
    function clsGridcategories()
    {
        global $FileName;
        $this->ComponentName = "categories";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscategoriesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->cat_id = new clsControl(ccsLabel, "cat_id", "cat_id", ccsInteger, "", CCGetRequestParam("cat_id", ccsGet));
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet));
        $this->subs = new clsControl(ccsLabel, "subs", "subs", ccsText, "", CCGetRequestParam("subs", ccsGet));
        $this->subs->HTML = true;
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
//Show Method @4-7894473E
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;
                $CounterItems = 1;
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
                  $Tpl->SetVar("breaker", "");
                                if(($CounterItems % 4) == 0) {
                                    $Tpl->SetVar("breaker", "</tr><tr>");
                                }
                                $CounterItems++;
                                $catdb1 = new clsDBNetConnect;
                        $catdb1->connect();
                        $newSQL1 = "SELECT cat_id, name FROM categories WHERE sub_cat_id='" . $this->ds->cat_id->GetValue() . "'";
                        $incat = "";
                        $catdb1->query($newSQL1);
                        while($catdb1->next_record()){
                                $incat .= "<br>&nbsp;<img src=images/browse_bullet.gif>&nbsp;<a href='ViewCat.php?CatID=" . $catdb1->f(0) . "'>" . $catdb1->f(1) . "</a>&nbsp;";
                                $catdb2 = new clsDBNetConnect;
                                $catdb2->connect();
                                $newSQL2 = "SELECT cat_id, name FROM categories WHERE sub_cat_id='" . $catdb1->f(0) . "'";
                                $catdb2->query($newSQL2);
                                while($catdb2->next_record()){
                                        $incat .= "<br>&nbsp;<img src=images/browse_bullet.gif><img src=images/browse_bullet.gif>&nbsp;<a href='ViewCat.php?CatID=" . $catdb2->f(0) . "'>" . $catdb2->f(1) . "</a>&nbsp;";
                                        $catdb3 = new clsDBNetConnect;
                                        $catdb3->connect();
                                        $newSQL3 = "SELECT cat_id, name FROM categories WHERE sub_cat_id='" . $catdb2->f(0) . "'";
                                        $catdb3->query($newSQL3);
                                        while($catdb3->next_record()){
                                                $incat .= "<br>&nbsp;<img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif>&nbsp;<a href='ViewCat.php?CatID=" . $catdb3->f(0) . "'>" . $catdb3->f(1) . "</a>&nbsp;";
                                                $catdb4 = new clsDBNetConnect;
                                                $catdb4->connect();
                                                $newSQL4 = "SELECT cat_id, name FROM categories WHERE sub_cat_id='" . $catdb3->f(0) . "'";
                                                $catdb4->query($newSQL4);
                                                while($catdb4->next_record()){
                                                        $incat .= "<br>&nbsp;<img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif>&nbsp;<a href='ViewCat.php?CatID=" . $catdb4->f(0) . "'>" . $catdb4->f(1) . "</a>&nbsp;";
                                                        $catdb5 = new clsDBNetConnect;
                                                        $catdb5->connect();
                                                        $newSQL5 = "SELECT cat_id, name FROM categories WHERE sub_cat_id='" . $catdb4->f(0) . "'";
                                                        $catdb5->query($newSQL5);
                                                        while($catdb5->next_record()){
                                                                $incat .= "<br>&nbsp;<img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif><img src=images/browse_bullet.gif>&nbsp;<a href='ViewCat.php?CatID=" . $catdb5->f(0) . "'>" . $catdb5->f(1) . "</a>&nbsp;";
                                                }
                                        }
                                }
                        }
                }
                                $this->cat_id->SetValue($this->ds->cat_id->GetValue());
                $this->name->SetValue($this->ds->name->GetValue() . " (" . CatCount($this->ds->cat_id->GetValue()) . ")");
                $this->subs->SetValue($incat);
                                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $Tpl->SetVar("Count", "");
                $this->cat_id->Show();
                $this->name->Show();
                $this->subs->Show();
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

        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End categories Class @4-FCB6E20C

class clscategoriesDataSource extends clsDBNetConnect {  //categoriesDataSource Class @4-FD2FF1B0

//Variables @4-8F8275DA
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $cat_id;
    var $name;
//End Variables

//Class_Initialize Event @4-0FD0B5D8
    function clscategoriesDataSource()
    {
        $this->Initialize();
        $this->cat_id = new clsField("cat_id", ccsInteger, "");
        $this->name = new clsField("name", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-217A5C7E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "weight, name";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_name" => array("name", "")));
    }
//End SetOrder Method

//Prepare Method @4-9ADE1968
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->Criterion[1] = "sub_cat_id='1'";
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-87D4B51E
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

//SetValues Method @4-0632F0F7
    function SetValues()
    {
        $this->cat_id->SetDBValue($this->f("cat_id"));
        $this->name->SetDBValue($this->f("name"));
    }
//End SetValues Method

} //End categoriesDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-8553DFC6
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

$FileName = "browse.php";
$Redirect = "";
$TemplateFileName = "templates/browse.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-6C1B5C97

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$categories = new clsGridcategories();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
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
include './Lang/lang_class.php';
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
