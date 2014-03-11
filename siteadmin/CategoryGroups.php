<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files

if (!$_REQUEST["selected"])
	$selected = 1;
else
	$selected = $_REQUEST["selected"];

//Include Page implementation @33-503267A8
include("./Header.php");
//End Include Page implementation
if ($selected) {

	$groupid = new clsDBDBNetConnect();
	$groupid->query("select * from groups where id = " . $selected);
	$groupid->next_record();
	$name = stripslashes($groupid->f("title"));
	$description = stripslashes($groupid->f("description"));

	if ($Add && $notingroup) {
		$i = 0;
		$usersgroups = new clsDBDBNetConnect();
		While ($notingroup[$i]) {
			$usersgroups->query("insert into groups_categories (`cat_id`, `group_id`) values ('" . $notingroup[$i] . "', '" . $selected . "')");
            $i++;
		}
	}

	if ($Remove && $ingroup) {
		$i = 0;
		$usersgroups = new clsDBDBNetConnect();
		While ($ingroup[$i]) {
			$usersgroups->query("DELETE FROM groups_categories where `cat_id` = '" . $ingroup[$i] . "' and `group_id` = '" . $selected . "'");
            $i++;
		}
	}
	
	$inoptions = "";
	$catingroup = "";
	$ingroupdata = new clsDBDBNetConnect();
	$ingroupdata->query("SELECT cat.name, cat.cat_id FROM groups_categories AS cg LEFT JOIN categories AS cat USING (cat_id) WHERE cg.group_id = '" . $groupid->f("id") . "' ORDER BY name ASC");
	while ($ingroupdata->next_record()){
		$inoptions .= "<option value=\"" . $ingroupdata->f("cat_id") . "\">" . $ingroupdata->f("name") . "</option>\n";
		$catingroup[] = $ingroupdata->f("cat_id");
	}
	if ($catingroup)
	    $extra = "AND cat.cat_id NOT IN ('" . implode("','", $catingroup) . "')";
	else
	    $extra = "";
	$notinoptions = "";
	$notingroupdata = new clsDBDBNetConnect();
	$notingroupdata->query("SELECT distinct cat.name, cat.cat_id FROM categories AS cat LEFT JOIN groups_categories AS cg USING ( cat_id ) WHERE (cg.group_id NOT IN ( '" . $groupid->f("id") . "' ) OR cg.group_id IS NULL) and cat.sub_cat_id=1 $extra ORDER BY name ASC");
	while ($notingroupdata->next_record()){
		$notinoptions .= "<option value=\"" . $notingroupdata->f("cat_id") . "\">" . $notingroupdata->f("name") . "</option>\n";
	}


}

$groups = new clsDBDBNetConnect();
$groups->query("select * from `groups` ORDER BY `id` ASC");
$groupoptions = "";
while ($groups->next_record()){
	if ($groups->f("id") != $selected)
	$groupoptions .= "<option value=\"" . $groups->f("id") . "\">" . $groups->f("id") . " -- " . $groups->f("title") . "</option>\n";
	else
	$groupoptions .= "<option value=\"" . $groups->f("id") . "\" selected>" . $groups->f("id") . " -- " . $groups->f("title") . "</option>\n";
}

//Include Page implementation @34-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-4491C9BD
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

$FileName = "CategoryGroups.php";
$Redirect = "";
$TemplateFileName = "Themes/CategoryGroups.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-9EBE738D
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

//Show Page @1-F9F38336
$Header->Show("Header");
$Footer->Show("Footer");

$Tpl->SetVar("GroupOptions", $groupoptions);
$Tpl->SetVar("NotInGroup", $notinoptions);
$Tpl->SetVar("InGroup", $inoptions);
$Tpl->SetVar("selected", $selected);
$Tpl->SetVar("GroupName", $name);
$Tpl->SetVar("GroupDesc", $description);
$Tpl->SetVar("GroupNameTitle", "<font class=\"ItechClsFormHeaderFont\">The \"" . $name . "\" Group Has Access to These Categories</font>");
$Tpl->PParse("main", false);

//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
