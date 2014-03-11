<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));

//End Include Common Files
$page="Getting Confirmation";
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
include("./Headeru.php");
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

$FileName = "PurchaseDetails.php";
$Redirect = "";
$TemplateFileName = "templates/PurchaseDetails.html";
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

if ($_GET["id"]){
	$db = new clsDBNetConnect;
	$query = "select * from purchases where id = '" . $_GET["id"] . "'";
	$db->query($query);
	if ($db->next_record()){
		$lookupdb = new clsDBNetConnect;
        $seller = CCDLookUp("user_login","users","user_id='" . $db->f("user_id") . "'",$lookupdb);
        $buyer = CCDLookUp("user_login","users","user_id='" . $db->f("buyer") . "'",$lookupdb);
        
        $Tpl->setVar("date", date("F j, Y, g:i a", $db->f("date")));
		$Tpl->setVar("id",$db->f("id"));
		$Tpl->setVar("ItemNum",$db->f("ItemNum"));
		$Tpl->setVar("title",stripslashes($db->f("title")));
		$Tpl->setVar("asking",$db->f("asking"));
		$Tpl->setVar("amt_received",$db->f("amt_received"));
		$Tpl->setVar("shipping",stripslashes($db->f("shipping")));
		$Tpl->setVar("seller",$seller);
		$Tpl->setVar("buyer",$buyer);
		$Tpl->setVar("seller_paypal",$db->f("user_paypal"));
		$Tpl->setVar("buyer_paypal",$db->f("buyer_paypal"));
		$Tpl->setVar("txn_id",$db->f("txn_id"));
	}
}

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
