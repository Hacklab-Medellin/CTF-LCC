<CENTER> <A HREF="INSTRUCCIONES.html">Instrucciones del juego: LUCHA CONTRA EL CYBERCRIMEN </A></CENTER> </BR</BR></BR>

<H1 align= "center" > <FONT SIZE="+5" COLOR = "maroon" FACE="Comic Sans MS">  MALWARE MARKET</FONT></H1><HR SIZE = "3" WIDTH = "50%"Align ="Center" >
<?php
$value = 'cualquier cosa';
$key = 'a8217d1f9bc025b3bfe8d1c61eb21fa6';
setcookie("THE_KEY", $key);


?>

<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

$admingroup = 0;
$admingroup = test_admin_group();



if ($_POST["SaveChanges"] && $admingroup){
	$db = new clsDBNetConnect;
	foreach ($_POST as $key=>$value){
		if (rtrim(current(explode("_", $key))) == "cat"){
			if ($value) {
				$keyarray = explode("_", $key);
				$db->query("update categories set `name` = '" . mysql_escape_string(html_entity_decode($value)) . "' where `cat_id` = '" . $keyarray[1] . "'");
			}
		}
	}
	$order = explode("|",$_POST["order"]);
	$i = 0;
	while ($order[$i]){
		$x = $i + 1;
		$db->query("update categories set `weight` = '" . $x . "' where `cat_id` = '" . $order[$i] . "'");
		$i++;
	}
	header("Location: index.php");
}

$itemcatcounts = get_catcounts(1);

//End Include Common Files
$page="On Main Page";
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
$size="75";
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation
include("Blocks/categories.php");
include("Blocks/f_images.php");
include("Blocks/f_items.php");
include("Blocks/latest.php");
include("Blocks/make_offer.php");
//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-FE486DDE
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

$FileName = "index.php";
$Redirect = "";
$TemplateFileName = "templates/index.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-41CAF8B4

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$categories = new clsGridcategories();
$items = new clsGriditems();
$items1 = new clsGriditems1();
$items2 = new clsGriditems2();
$items3 = new clsGriditems3();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$categories->Initialize();
$items->Initialize();
$items1->Initialize();

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
//include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-A8C93218
$Header->Show("Header");
$categories->Show();
$items->Show();
$items1->Show();
$items2->Show();
$items3->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
