<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));

if ($_POST["ItemNum"]) {
	global $now;
    global $accounting;
    global $charges;
    global $regcharges;

	$db = new clsDBNetConnect;
	$query = "select * from items where ItemNum = '" . $_POST["ItemNum"] . "'";
	$db->query($query);
	$db->next_record();
	if ($_POST["shipping"] != "999999"){
		$amount = ($db->f("asking_price") + $db->f("shipfee" . $_POST["shipping"]));
	}
	header("Location: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=" . urlencode($db->f("item_paypal")) . "&return=" . urlencode($now["homeurl"]) . "&no_note=1&currency_code=" . $regcharges["currencycode"] . "&notify_url=" . urlencode($now["homeurl"]) . "paypalipn.php&custom=" . urlencode(CCGetUserID() . "-" . $_POST["ItemNum"] . "-" . $_POST["shipping"]) . "&amount=" . $amount . "&item_name=" . urlencode($now["sitename"] . "-BuyNow") . "&item_number=" . $_POST["ItemNum"]);

}

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

$FileName = "confirm.php";
$Redirect = "";
$TemplateFileName = "templates/confirm.html";
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
include("./confirm_events.php");
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
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
if ($what == 'buynowPayPal'){
	buynowPayPal($ItemNum);
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
