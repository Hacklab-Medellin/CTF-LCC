<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));

//End Include Common Files
$page="Rating Another User";
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

$FileName = "RateUser.php";
$Redirect = "";
$TemplateFileName = "templates/RateUser.html";
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
if ($_GET["id"] && !$_GET["submit"]){
	$db = new clsDBNetConnect;
	$query = "select * from feedback where `counter` = '" . $_GET["id"] . "'";
	$db->query($query);
	if (!$db->next_record()){
		$query = "select * from feedback where id = '" . $_GET["id"] . "' and being_rated = '" . CCGetUserID() . "'";
		$db->query($query);
		if ($db->next_record()){
			if ($db->f("rating") == 1)
			    $ratetext = "Positive";
	        if ($db->f("rating") == 0)
			    $ratetext = "Neutral";
	        if ($db->f("rating") == -1)
			    $ratetext = "Negative";
			$Tpl->SetBlockVar("rate", "");
			$Tpl->setVar("ItemNum", $db->f("ItemNum"));
			$Tpl->setVar("usercomment", stripslashes($db->f("comment")));
			$Tpl->setVar("rated_you", $ratetext);
			$Tpl->setVar("id", $db->f("id"));
			$query = "select * from purchases where id = '" . $db->f("purchase_id") . "'";
			$db->query($query);
			$db->next_record();
			$Tpl->setVar("title", $db->f("title"));
			$Tpl->Parse("counter", True);
		}
		else {
			$Tpl->Parse("Error", True);
		}
	}
	else {
		$Tpl->Parse("Error", True);
	}
}
elseif($_POST["id"] && $_POST["submit"]){
	$db = new clsDBNetConnect;
	$query = "select * from feedback where `counter` = '" . $_POST["id"] . "'";
	$db->query($query);
	if (!$db->next_record()){
		$query = "insert into feedback (`counter`, `being_rated`, `comment`, `date`) values ('" . $_POST["id"] . "', '" . CCGetUserID() . "', '" . mysql_escape_string($_POST["comment"]) . "', '" . time() . "')";
		$db->query($query);
		header("Location: Feedback.php?user_id=" . CCGetUserID());
	}
	else {
		$Tpl->Parse("Error", True);
	}
}
elseif($_GET["purchase_id"] && $_GET["ItemNum"] && !$_GET["submit"]){
	$db = new clsDBNetConnect;
	$query = "select * from feedback where `ItemNum` = '" . $_GET["ItemNum"] . "' and `purchase_id` = '" . $_GET["purchase_id"] . "' and `doing_rating` = '" . CCGetUserID() . "'";
	$db->query($query);
	if (!$db->next_record()){
		$query = "select * from purchases where `ItemNum` = '" . $_GET["ItemNum"] . "' and `id` = '" . $_GET["purchase_id"] . "' and (`buyer` = '" . CCGetUserID() . "' or `user_id` = '" . CCGetUserID() . "')";
		$db->query($query);
		if ($db->next_record()){
			$Tpl->SetBlockVar("rate", "");
			$Tpl->setVar("ItemNum", $db->f("ItemNum"));
			$Tpl->setVar("title", $db->f("title"));
			$Tpl->setVar("purchase_id", $db->f("id"));
			$Tpl->Parse("rate", True);
		}
		else {
			$Tpl->Parse("Error", True);
		}
	}
    else {
		$Tpl->Parse("Error", True);
	}
}
elseif ($_POST["purchase_id"] && $_POST["ItemNum"] && $_POST["submit"]){
	$db = new clsDBNetConnect;
	$db->query("select * from purchases where `ItemNum` = '" . $_POST["ItemNum"] . "' and `id` = '" . $_POST["purchase_id"] . "' and (`buyer` = '" . CCGetUserID() . "' or `user_id` = '" . CCGetUserID() . "')");
	if ($db->next_record()){
		if ($db->f("buyer") == CCGetUserID()) {
			$being_rated = $db->f("user_id");
			$buysell = 0;
		} else {
		    $being_rated = $db->f("buyer");
		    $buysell = 1;
		}
		$query = "insert into feedback (`purchase_id`, `ItemNum`, `being_rated`, `doing_rating`, `rating`, `comment`, `buysell`, `date`) values ('" . $db->f("id") . "', '" . $db->f("ItemNum") . "', '" . $being_rated . "', '" . CCGetUserID() . "', '" . $_POST["rating"] . "', '" . mysql_escape_string($_POST["comment"]) . "', '" . $buysell . "', '" . time() . "')";
		$db->query($query);
		header("Location: PurchaseHistory.php");
	}
	else {
		$Tpl->Parse("Error", True);
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
