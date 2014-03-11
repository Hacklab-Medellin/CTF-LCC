<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//Include Page implementation @20-503267A8
include("./Header.php");
//End Include Page implementation


//Include Page implementation @21-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-2282A51C
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

$FileName = "FroogleSubmit.php";
$Redirect = "";
$TemplateFileName = "Themes/FroogleSubmit.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-7302B87D
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-332FBF3C
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


if ($_GET["generate"]){
	print "Generating...<br>";
	$catlist = new clsDBNetConnect;
	$catlist->query("select * from categories where sub_cat_id=1");
	while($catlist->next_record()) {
		$cats[$catlist->f("cat_id")] = $catlist->f("name");
		$catlist2 = new clsDBNetConnect();
		$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
		while($catlist2->next_record()) {
			$cats[$catlist2->f("cat_id")] = $cats[$catlist->f("cat_id")] . " > " . $catlist2->f("name");
			$catlist3 = new clsDBNetConnect();
			$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
			while($catlist3->next_record()) {
				$cats[$catlist3->f("cat_id")] = $cats[$catlist2->f("cat_id")] . " > " . $catlist3->f("name");
				$catlist4 = new clsDBNetConnect();
				$catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
				while($catlist4->next_record()) {
					$cats[$catlist4->f("cat_id")] = $cats[$catlist3->f("cat_id")] . " > " . $catlist4->f("name");
					$catlist5 = new clsDBNetConnect();
					$catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
					while($catlist5->next_record()) {
						$cats[$catlist5->f("cat_id")] = $cats[$catlist4->f("cat_id")] . " > " . $catlist5->f("name");
						$catlist6 = new clsDBNetConnect();
						$catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
						while($catlist6->next_record()) {
							$cats[$catlist6->f("cat_id")] = $cats[$catlist5->f("cat_id")] . " > " . $catlist6->f("name");
						}
					}
				}
			}
		}
	}

	$db = new clsDBNetConnect;

	$query = "select * from `settings_general` where `set_id` = '1'";
	$db->query($query);
	if ($db->next_record()){
		$url = $db->f("homeurl");
	}

	$query = "select * from `settings_froogle` where `set_id` = '1'";
	$db->query($query);
	if ($db->next_record()){
		$frooglefilename = $db->f("frooglefile");
		$ftp_url = $db->f("ftp_url");
		$ftpusername = $db->f("ftpusername");
		$ftppassword = $db->f("ftppassword");
		$submitdate = $db->f("submit_date");
	}

	$frooglefile = fopen("../uploads/" . $frooglefilename . ".txt", 'w');

	$query = "select * from `custom_textarea_values`";
	$db->query($query);
	$custta = '';
	while ($db->next_record()){
		$custta[$db->f("ItemNum")] = $custta[$db->f("ItemNum")] . " " . $db->f("value");
	}

	$query = "select * from `custom_textbox_values`";
	$db->query($query);
	$custtb = '';
	while ($db->next_record()){
		$custtb[$db->f("ItemNum")] = $custtb[$db->f("ItemNum")] . " " . $db->f("value");
	}

	fwrite($frooglefile, "product_url" . chr(9) . "name" . chr(9) . "description"  . chr(9) . "image_url" . chr(9) . "category" . chr(9) . "price" . chr(9) . "offer_id" . chr(10));

	$query = "select `title`, `description`, `added_description`, `asking_price`, `ItemNum`, `image_one`, `category` from `items` where `status`='1'";
	$db->query($query);
	$title = '';
	$desc = '';
	$price = '';
	while ($db->next_record()){
		$title[$db->f("ItemNum")] = $title[$db->f("ItemNum")] . " " . $db->f("title");
		$desc[$db->f("ItemNum")] = $desc[$db->f("ItemNum")] . " " . $db->f("description");
		$price[$db->f("ItemNum")] = $price[$db->f("ItemNum")] . " " . $db->f("asking_price");
		$added_desc[$db->f("ItemNum")] = $added_desc[$db->f("ItemNum")] . " " . $db->f("added_description");
		if($db->f("image_one") && $db->f("image_one") != "NULL")
		$image1 = $url . $db->f("image_one");
		else
		$image1 = "";
		fwrite($frooglefile, $url . "ViewItem.php?ItemNum=" . $db->f("ItemNum") . chr(9) . froogle_process($db->f("title")) . chr(9) . froogle_process($db->f("description") . " " . $db->f("added_description") . " " . $custta[$db->f("ItemNum")] . " " . $custtb[$db->f("ItemNum")]) . chr(9) . $image1 . chr(9) . froogle_process($cats[$db->f("category")]) . chr(9) . $db->f("asking_price") . chr(9) . $db->f("ItemNum") . chr(10));
	}

	fclose($frooglefile);
	
	if ($_GET["send"]){
		print "Sending...<br>";
		$ftp = ftp_connect($ftp_url) or die("Couldn't connect to $ftp_url");
		$login_result = ftp_login($ftp, $ftpusername, $ftppassword);
		if (!$login_result) { 
       		echo "FTP connection has failed!<br>";
       		echo "Attempted to connect to $ftp_url for user $ftpusername <br>"; 
       		echo "Please double check your login information here and on your Froogle Merchant account and try again later.  <a href=\"FroogleSubmit.php\">BACK</a>";
       		exit; 
   		}
   		
   		$upload = ftp_put($ftp, $frooglefilename . ".txt", "../uploads/" . $frooglefilename . ".txt", FTP_ASCII); 
   		if (!$upload) { 
       		echo "Froogle FTP transfer has failed!<br>";
       		echo "Please double check your login information here and on your Froogle Merchant account and try again later.  <a href=\"FroogleSubmit.php\">BACK</a>";
       		exit;
   		}
   		
		ftp_close($ftp);
		header("Location:FroogleSubmit.php");
		exit;
   }

} else {
	
	$db = new clsDBNetConnect;
	$query = "Select * from `settings_froogle` where `set_id` = '1'";
	$db->query($query);
	if ($db->next_record()) {
		$filename = $db->f("frooglefile");
		if ($db->f("frooglefile") != "" && $db->f("frooglefile") != "NULL"){
			$lastdate = $db->f("submit_date");
			if ($lastdate != "" && $lastdate != "0" && $lastdate != "NULL"){
				$fileurl = "<a href=\"../uploads/" . $filename . ".txt\">Right Click and \"Save As\"</a>";
				$mostrecentdate = date("F j, Y", $lastdate);
				$query = "select count(ItemNum) from `items` where `status` = 1 and `started` > $lastdate";
				$db->query($query);
				if ($db->next_record()){
					$count = $db->f("count(ItemNum)");
					if ($count == 0) {
						$error = "Feed Submitted Successfully"; 
					} else {
						$error = $count . " Items Started Since Your Last Submitted Feed.";
					}
				}
			} else {
				$error = "Awaiting First Submit";
				$mostrecentdate = "Never";
				$fileurl = "Not Yet Created";
			}
		} else {
			$fileurl = "Never Created";
			$error = "You first need to setup your Froogle Merchant Account and enter it's information into the \"Froole Settings\" page";
			$mostrecentdate = "Never";
		}
		$Tpl->SetVar("Error", $error);
		$Tpl->SetVar("lastsubmit", $mostrecentdate);
		$Tpl->SetVar("fileurl", $fileurl);
	}
}


//Show Page @1-7EF9F867
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

function froogle_process($text = ""){
	if ($text){
		$text = strip_tags(html_entity_decode($text));
		$text = str_replace("\n", " ", $text);
		$text = str_replace(chr(27), " ", $text);
		$text = str_replace(chr(9), " ", $text);
		$text = str_replace(chr(10), " ", $text);
		$text = str_replace(chr(11), " ", $text);
		$text = str_replace(chr(12), " ", $text);
		$text = str_replace(chr(13), " ", $text);
	}
	return $text;
}
?>
