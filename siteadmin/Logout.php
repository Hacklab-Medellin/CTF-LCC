<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-6C53E12A
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

$FileName = "Logout.php";
$Redirect = "";
$TemplateFileName = "Themes/Logout.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-6ADD3475
CCSecurityRedirect("1;2;3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-E2C69410

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();

// Events
include("./Logout_events.php");
BindEvents();

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

//Show Page @1-A025E414
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
