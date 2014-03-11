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

$FileName = "ReIndex.php";
$Redirect = "";
$TemplateFileName = "Themes/ReIndex.html";
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

if ($_POST["truncate"]){
	$db = new clsDBDBNetConnect;
	$query = "TRUNCATE TABLE `listing_index`";
	$db->query($query);
	header("Location: ReIndex.php?truncatedone=1");
	exit;
}
	

$options = "";
$db = new clsDBNetConnect;
$query = "Select `ItemNum`, `title`, `itemID` from items where status = 1 order by `title` asc";
$db->query($query);
$i = 0;
while ($db->next_record()){
	$i++;
	$options .= "<option value=\"" . $db->f("ItemNum") . "\">" . $i . " - " . $db->f("ItemNum") . " - " . $db->f("title") . "</option>\n";
}
$Tpl->setVar("item_Options", $options);
if ($_POST["truncatedone"])
	$Tpl->setVar("complete", "<br><b>Indexing database deleted, users will not be able to search the site until the index has been recreated</b><br>");

if ($_REQUEST["Submit"]){
	if (is_array($_REQUEST["ItemNum"])){
		if (in_array("Alllistings", $_REQUEST["ItemNum"]))
			$_REQUEST["ItemNum"] = "Alllistings";
	}
	if ($_REQUEST["ItemNum"] == "Alllistings"){
		$db2 = new clsDBDBNetConnect;
		if (!$_REQUEST["itemID"])
			$itemID = 0;
		else
			$itemID = $_REQUEST["itemID"];
		$pageterms = 0;
		$totalterms = $_REQUEST["totalterms"];
		if ($_REQUEST["fields"] == "All" && $totalterms < 1)
			$query = "TRUNCATE TABLE `listing_index`";
		elseif ($_REQUEST["fields"] == "Allcust" && $totalterms < 1)
			$query = "delete from `listing_index` where `field_type` = 'dd' or `field_type` = 'ta' or `field_type` = 'tb'";
		elseif ($_REQUEST["fields"] == "CustTA" && $totalterms < 1)
			$query = "delete from `listing_index` where `field_type` = 'ta'";
		elseif ($_REQUEST["fields"] == "CustTB" && $totalterms < 1)
			$query = "delete from `listing_index` where `field_type` = 'tb'";
		elseif ($_REQUEST["fields"] == "CustDD" && $totalterms < 1)
			$query = "delete from `listing_index` where `field_type` = 'dd'";
		elseif ($_REQUEST["fields"] == "Main" && $totalterms < 1)
			$query = "delete from `listing_index` where `field_type` = 'main'";
		$db->query($query);
		$query = "select ItemNum, itemID from items where `status` = 1 and itemID > '" . $itemID . "' ORDER BY `itemID` ASC";
		$db->query($query);
		while ($db->next_record()){
			if ($_REQUEST["fields"] == "All"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$a = index_listing($db->f("ItemNum"));
				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($db->f("ItemNum"), $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($db->f("ItemNum"), $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($db->f("ItemNum"), $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $a + $b + $c + $d;
				$totalterms = $totalterms + $a + $b + $c + $d;
			}
			elseif ($_REQUEST["fields"] == "Allcust"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($db2->f("ItemNum"), $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($db2->f("ItemNum"), $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($db2->f("ItemNum"), $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $b + $c + $d;
				$totalterms = $totalterms + $b + $c + $d;
			}
			elseif ($_REQUEST["fields"] == "CustTA"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($db2->f("ItemNum"), $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$pageterms = $pageterms + $c;
				$totalterms = $totalterms + $c;
			}
			elseif ($_REQUEST["fields"] == "CustTB"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($db2->f("ItemNum"), $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $d;
				$totalterms = $totalterms + $d;
			}
			elseif ($_REQUEST["fields"] == "CustDD"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $db->f("ItemNum") . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($db2->f("ItemNum"), $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$pageterms = $pageterms + $b;
				$totalterms = $totalterms + $b;
			}
			elseif ($_REQUEST["fields"] == "Main"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;
				
				$a = index_listing($db->f("ItemNum"));
				$pageterms = $pageterms + $a;
				$totalterms = $totalterms + $a;
			}
			if ($pageterms > $_REQUEST["perpage"]){
				header("Location: ReIndex.php?Submit=1&totalterms=" . $totalterms . "&ItemNum=Alllistings&itemID=" . $db->f("itemID") . "&fields=" . $_REQUEST["fields"] . "&perpage=" . $_REQUEST["perpage"]);
				exit;
			}	
		}
	}
	elseif (is_array($_POST["ItemNum"]) && !in_array("Alllistings", $_POST["ItemNum"])){
		foreach ($_POST["ItemNum"] AS $ItemNum){
			$query = "";
			$db2 = new clsDBDBNetConnect;
			if ($_POST["fields"] == "All" && $totalterms < 1)
				$query = "delete from `listing_index` where `ItemNum` = '" . $ItemNum . "'";
			elseif ($_POST["fields"] == "Allcust" && $totalterms < 1)
				$query = "delete from `listing_index` where (`field_type` = 'dd' or `field_type` = 'ta' or `field_type` = 'tb') and `ItemNum` = '" . $ItemNum . "'";
			elseif ($_POST["fields"] == "CustTA" && $totalterms < 1)
				$query = "delete from `listing_index` where `field_type` = 'ta'  and `ItemNum` = '" . $ItemNum . "'";
			elseif ($_POST["fields"] == "CustTB" && $totalterms < 1)
				$query = "delete from `listing_index` where `field_type` = 'tb' and `ItemNum` = '" . $ItemNum . "'";
			elseif ($_POST["fields"] == "CustDD" && $totalterms < 1)
				$query = "delete from `listing_index` where `field_type` = 'dd' and `ItemNum` = '" . $ItemNum . "'";
			elseif ($_POST["fields"] == "Main" && $totalterms < 1)
				$query = "delete from `listing_index` where `field_type` = 'main' and `ItemNum` = '" . $ItemNum . "'";
			$db2->query($query);
			if ($_POST["fields"] == "All"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$a = index_listing($ItemNum);
				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($ItemNum, $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($ItemNum, $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($ItemNum, $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $a + $b + $c + $d;
				$totalterms = $totalterms + $a + $b + $c + $d;
			}
			elseif ($_POST["fields"] == "Allcust"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($ItemNum, $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($ItemNum, $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($ItemNum, $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $b + $c + $d;
				$totalterms = $totalterms + $b + $c + $d;
			}
			elseif ($_POST["fields"] == "CustTA"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$query = "select * from `custom_textarea_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$cc = index_listing($ItemNum, $db2->f("value"), "ta", $db2->f("field_id"));
					$c = $c + $cc;
				}
				$pageterms = $pageterms + $c;
				$totalterms = $totalterms + $c;
			}
			elseif ($_POST["fields"] == "CustTB"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$query = "select * from `custom_textbox_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$dd = index_listing($ItemNum, $db2->f("value"), "tb", $db2->f("field_id"));
					$d = $d + $dd;
				}
				$pageterms = $pageterms + $d;
				$totalterms = $totalterms + $d;
			}
			elseif ($_POST["fields"] == "CustDD"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$query = "select * from `custom_dropdown_values` where `ItemNum` = '" . $ItemNum . "'";
				$db2->query($query);
				while ($db2->next_record()){
					$bb = index_listing($ItemNum, $db2->f("option_id"), "dd", $db2->f("field_id"), $db2->f("option_id"));
					$b = $b + $bb;
				}
				$pageterms = $pageterms + $b;
				$totalterms = $totalterms + $b;
			}
			elseif ($_POST["fields"] == "Main"){
				$a = 0;
				$b = 0;
				$c = 0;
				$d = 0;

				$a = index_listing($ItemNum);
				$pageterms = $pageterms + $a;
				$totalterms = $totalterms + $a;
			}
		}
	}
	$Tpl->SetVar("complete", "<br><b>Indexing Complete:  " . $totalterms . " Terms added to the Search Index</b><br>");
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



?>
