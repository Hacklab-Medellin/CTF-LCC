<?
//Include Common Files @1-5471E0F2
$startpage = getmicrotime();
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

include("./Header.php");
//End Include Page implementation

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-49274B25
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

$FileName = "stest.php";
$Redirect = "";
$TemplateFileName = "templates/stest.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-DBA4AC3D

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();

// Events
	
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

	$db = new clsDBNetConnect;
	$db2 = new clsDBNetConnect;
	$db3 = new clsDBNetConnect;
	//Print "1";
	if (!$_GET["itemID"])
		$itemID = 0;
	else
		$itemID = $_GET["itemID"];
	if (!$_GET["count"])
		$count = 0;
	else
		$count = $_GET["count"];
	if (!$_GET["totalterms"])
		$totalterms = 0;
	else
		$totalterms = $_GET["totalterms"];
	$terms = 0;
	$pageterms = 0;
	$query = "select itemID from items where itemID > '" . $itemID . "' ORDER BY `itemID` ASC";
	//print $query;
	$db->query($query);
	while ($db->next_record()){
		$query = "select * from items where itemID = '". $db->f("itemID") . "'";
		$db2->query($query);
		if ($db2->next_record()){
			$count++;
			$text = strip_tags($db2->f("title") . " " . $db2->f("description") . " " . $db2->f("added_description"));
			$text = str_replace("\n", " ", $text);
			$text = str_replace(",", " ", $text);
			$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);
			$array = explode(" ", $text);
			$terms = 1;
			while (list($key, $value) = each($array)) {
				if (strlen($value) > 0) {
					$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`) values ('" . mysql_escape_string($db2->f("ItemNum")) . "', '" . mysql_escape_string($value) . "', '" . $terms . "', 'main')";
					$db3->query($query);
					$terms++;
					$totalterms++;
					$pageterms++;
				}
			}
			//Print $db2->f("ItemNum") . " = " . $terms . " Terms<br>" . stopwatch() . "<br>";
			if ($pageterms > 10000){
				//print "Trying to redirect! Count= $totalterms";
				//print "Location: listing_index.php?totalterms=" . $totalterms . "&count=" . $count . "&itemID=" . $db->f("itemID");
				//exit;
				header("Location: listing_index.php?totalterms=" . $totalterms . "&count=" . $count . "&itemID=" . $db->f("itemID"));
				exit;
			}
		}
	}
	Print "Total Records Indexed = " . $count . " Items<br>";
	Print "Total Index Terms Added = " . $totalterms . " Terms<br>";
	stopwatch();
//Show Page @1-A025E414
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page
function getmicrotime(){
   list($usec, $sec) = explode(" ",microtime());
   return ((float)$usec + (float)$sec);
   }
function stopwatch() {
    global $Tpl;
    global $startpage;
    
    $endpage = getmicrotime();
    $buildtime = round($endpage - $startpage, 4);
    
    $Tpl->SetVar("stopwatch",$buildtime);
	return $buildtime;
} 

?>
