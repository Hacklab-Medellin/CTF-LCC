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

$FileName = "CatCount.php";
$Redirect = "";
$TemplateFileName = "Themes/CatCount.html";
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

/*
$options = "";
$db = new clsDBNetConnect;
$query = "Select `ItemNum`, `title` from items where status = 1 order by `title` asc";
$db->query($query);
while ($db->next_record()){
	$options .= "<option value=\"" . $db->f("ItemNum") . "\">" . $db->f("ItemNum") . " - " . $db->f("title") . "</option>\n";
}
$Tpl->setVar("item_Options", $options);

*/


if ($_GET["execute"]){
	
	$itemcats[] = '';
	$keys[] = '';
	$db = new clsDBDBNetConnect;
	$query = "select `category` from items where `status` = '1'";
	$db->query($query);
	while ($db->next_record()){
		if (in_array($db->f("category"), $keys)){
			$itemcats[$db->f("category")]++;
		}
		else {
			$itemcats[$db->f("category")] = 1;
			$keys[] = $db->f("category");
		}
	}
	$itemcats[1] = 0;
		$query = "select * from categories";
		$db->query($query);
		while ($db->next_record()){
			$cats[$db->f("cat_id")][sub_cat_id] = $db->f("sub_cat_id");
			$cats[$db->f("cat_id")][$db->f("sub_cat_id")] = "sub_cat_id";
			$cats[$db->f("cat_id")]["total"] = 0;
		}
		$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '0'";
		$db->query($query);
		while ($db->next_record()){
			$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db->f("cat_id")];
			$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '" . $db->f("cat_id") . "'";
			$db2 = new clsDBDBNetConnect;
			$db2->query($query);
			while ($db2->next_record()){
				$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db2->f("cat_id")];
				$cats[$db2->f("cat_id")]["total"] = $cats[$db2->f("cat_id")]["total"] + $itemcats[$db2->f("cat_id")];
				$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '" . $db2->f("cat_id") . "'";
				$db3 = new clsDBDBNetConnect;
				$db3->query($query);
				while ($db3->next_record()){
					$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db3->f("cat_id")];
					$cats[$db2->f("cat_id")]["total"] = $cats[$db2->f("cat_id")]["total"] + $itemcats[$db3->f("cat_id")];
					$cats[$db3->f("cat_id")]["total"] = $cats[$db3->f("cat_id")]["total"] + $itemcats[$db3->f("cat_id")];
					$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '" . $db3->f("cat_id") . "'";
					$db4 = new clsDBDBNetConnect;
					$db4->query($query);
					while ($db4->next_record()){
						$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db4->f("cat_id")];
						$cats[$db2->f("cat_id")]["total"] = $cats[$db2->f("cat_id")]["total"] + $itemcats[$db4->f("cat_id")];
						$cats[$db3->f("cat_id")]["total"] = $cats[$db3->f("cat_id")]["total"] + $itemcats[$db4->f("cat_id")];
						$cats[$db4->f("cat_id")]["total"] = $cats[$db4->f("cat_id")]["total"] + $itemcats[$db4->f("cat_id")];
						$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '" . $db4->f("cat_id") . "'";
						$db5 = new clsDBDBNetConnect;
						$db5->query($query);
						while ($db5->next_record()){
							$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db5->f("cat_id")];
							$cats[$db2->f("cat_id")]["total"] = $cats[$db2->f("cat_id")]["total"] + $itemcats[$db5->f("cat_id")];
							$cats[$db3->f("cat_id")]["total"] = $cats[$db3->f("cat_id")]["total"] + $itemcats[$db5->f("cat_id")];
							$cats[$db4->f("cat_id")]["total"] = $cats[$db4->f("cat_id")]["total"] + $itemcats[$db5->f("cat_id")];
							$cats[$db5->f("cat_id")]["total"] = $cats[$db5->f("cat_id")]["total"] + $itemcats[$db5->f("cat_id")];
							$query = "select `cat_id`, `sub_cat_id` from categories where `sub_cat_id` = '" . $db5->f("cat_id") . "'";
							$db6 = new clsDBDBNetConnect;
							$db6->query($query);
							while ($db6->next_record()){
								$cats[$db->f("cat_id")]["total"] = $cats[$db->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
								$cats[$db2->f("cat_id")]["total"] = $cats[$db2->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
								$cats[$db3->f("cat_id")]["total"] = $cats[$db3->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
								$cats[$db4->f("cat_id")]["total"] = $cats[$db4->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
								$cats[$db5->f("cat_id")]["total"] = $cats[$db5->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
								$cats[$db6->f("cat_id")]["total"] = $cats[$db6->f("cat_id")]["total"] + $itemcats[$db6->f("cat_id")];
							}
						}
					}
				}
			}
		}
	$query = "update categories set `count` = '0'";
	$db->query($query);
	foreach ($cats AS $key => $value){
		$query = "update categories set `count` = '" . $cats[$key]["total"] . "' where `cat_id` = '" . $key . "'";
		$db->query($query);
	}
	header("Location: CatCount.php?finished=" . $cats[1]["total"]);
}
if (isset($_GET["finished"]))
	$Tpl->SetVar("complete", "<b>Active Listing Recount Complete -- " . $_GET["finished"] . " Items Counted</b><br>");


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