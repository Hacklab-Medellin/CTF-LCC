<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files
$admins = new clsDBNetConnect;
$admins->query("select * from administrators");
if ($admins->next_record()){
    $key = md5($admins->f("username") . "AdMin kkkkkey" . $admins->f("password"));
}
//Include Page implementation @33-503267A8
include("./Header.php");
//End Include Page implementation

$cat = $_GET["cat"];

$catdata = new clsDBNetConnect;
$query = "select * from categories where cat_id = $cat";
$catdata->query($query);
$catdata->next_record();

if ($_REQUEST["page"] == "storefront") {
	if ($catdata->f("sub_cat_id") != 1)
	    $_GET["page"] = "viewcat";
	$table = "templates_storefront";
	$file = "ViewCat.html";
	$phppage = "ViewCat.php?catID=" . $_GET["cat"];
	$field = "storefront";
}
if ($_REQUEST["page"] == "viewcat") {
	$table = "templates_cat";
	$file = "ViewCat.html";
	$phppage = "ViewCat.php?catID=" . $_GET["cat"];
	$field = "template";
}
if ($_REQUEST["page"] == "viewitem") {
	$table = "templates_items";
	$file = "ViewItem.html";
	$phppage = "ViewItem.php?catID=" . $_GET["cat"];
	$field = "template";
}
if ($_REQUEST["page"] == "newitem") {
	$table = "templates_newitem";
	$file = "newitem.html";
	$phppage = "newitem.php?finalcat=" . $_GET["cat"] . "&adminkey=" . $key;
	$field = "template";
}
if ($_REQUEST["page"] == "gallery") {
	$table = "templates_gal";
	$file = "gallery.html";
	$phppage = "gallery.php?catID=" . $_GET["cat"];
	$field = "template";
}

$temp = new clsDBNetConnect;
$query = "select * from $table where cat_id = $cat";
$temp->query($query);

if ($file == "ViewItem.html"){
	$output = "<tr><td><hr><TABLE cellSpacing=2 cellPadding=0 bgColor=#ffffff border=0 width=\"100%\">\n";
	$output .= "   <tr>\n";
    $output .= "     <td width=\"100%\" colspan=\"2\" align=\"center\">Custom Template Variables Available for this Category</td></tr>\n";
	$output .= "  <tr>\n";
	$output .= "    <td width=\"15%\"><p class=ItechClsFieldCaptionTD align=\"center\">Field Tile</td>\n";
	$output .= "    <td width=\"85%\"><p class=ItechClsFieldCaptionTD align=\"center\">Template Variable</td>\n";
	$output .= "  </tr>\n";
	$cats = "(";
	$db = new clsDBNetConnect;
	$query = "select * from categories where cat_id='" . $cat . "'";
	$db->query($query);
    $db->next_record();
    $cats .= "cat_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")>0){
    	$cats .= " or ";
    	$sub = $db->f("sub_cat_id");
    	$query = "select * from categories where cat_id=$sub";
    	$db->query($query);
    	$db->next_record();
    	$cats .= "cat_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")>0){
    		$cats .= " or ";
    		$sub = $db->f("sub_cat_id");
    		$query = "select * from categories where cat_id=$sub";
    		$db->query($query);
    		$db->next_record();
    		$cats .= "cat_id=" . $db->f("cat_id");
    		if ($db->f("sub_cat_id")>0){
    			$cats .= " or ";
    			$sub = $db->f("sub_cat_id");
    			$query = "select * from categories where cat_id=$sub";
    			$db->query($query);
    			$db->next_record();
    			$cats .= "cat_id=" . $db->f("cat_id");
    			if ($db->f("sub_cat_id")>0){
    				$cats .= " or ";
    				$sub = $db->f("sub_cat_id");
    				$query = "select * from categories where cat_id=$sub";
    				$db->query($query);
    				$db->next_record();
    				$cats .= "cat_id=" . $db->f("cat_id");
    				if ($db->f("sub_cat_id")>0){
    					$cats .= " or ";
    					$sub = $db->f("sub_cat_id");
    					$query = "select * from categories where cat_id=$sub";
    					$db->query($query);
    					$db->next_record();
    					$cats .= "cat_id=" . $db->f("cat_id");
    					if ($db->f("sub_cat_id")>0){
    						$cats .= " or ";
    						$sub = $db->f("sub_cat_id");
    						$query = "select * from categories where cat_id=$sub";
    						$db->query($query);
    						$db->next_record();
    						$cats .= "cat_id=" . $db->f("cat_id");
    					} else{
		    		    	$cats .= ")";
    					}
    				} else{
	    		    	$cats .= ")";
    				}
    			} else{
    		    	$cats .= ")";
    			}
    		} else{
    		    $cats .= ")";
    		}
    	} else{
    		$cats .= ")";
    	}
    } else{
    	$cats .= ")";
    }
	$query = "select * from custom_textarea where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
		$output .= "    <td width=\"85%\" class=\"ItechClsDataTD\">{" . $db->f("template_var") . "}</td>\n";
		$output .= "  </tr>\n";
	}
	$query = "select * from custom_textbox where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
		$output .= "    <td width=\"85%\" class=\"ItechClsDataTD\">{" . $db->f("template_var") . "}</td>\n";
		$output .= "  </tr>\n";
	}
	$query = "select * from custom_dropdown where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
		$output .= "    <td width=\"85%\" class=\"ItechClsDataTD\">{" . $db->f("template_var") . "}</td>\n";
		$output .= "  </tr>\n";
	}
	$output .= "</table></td></tr>\n";

}

if ($file == "newitem.html"){
	$output = "<tr><td><hr><TABLE cellSpacing=2 cellPadding=0 bgColor=#ffffff border=0 width=\"100%\">\n";
	$output .= "   <tr>\n";
    $output .= "     <td width=\"100%\" colspan=\"4\" align=\"center\">Custom Template Variables Available for this Category</td></tr>\n";
	$output .= "  <tr>\n";
	$output .= "    <td width=\"5%\"><p class=ItechClsFieldCaptionTD align=\"center\">Field Tile</td>\n";
	$output .= "    <td width=\"15%\"><p class=ItechClsFieldCaptionTD align=\"center\">Title Variable</td>\n";
	$output .= "    <td width=\"15%\"><p class=ItechClsFieldCaptionTD align=\"center\">Description Variable</td>\n";
	$output .= "    <td width=\"65%\"><p class=ItechClsFieldCaptionTD align=\"center\">Sample Code with the Variables</td>\n";
	$output .= "  </tr>\n";
	$cats = "(";
	$db = new clsDBNetConnect;
	$query = "select * from categories where cat_id='" . $cat . "'";
	$db->query($query);
    $db->next_record();
    $cats .= "cat_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")>0){
    	$cats .= " or ";
    	$sub = $db->f("sub_cat_id");
    	$query = "select * from categories where cat_id=$sub";
    	$db->query($query);
    	$db->next_record();
    	$cats .= "cat_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")>0){
    		$cats .= " or ";
    		$sub = $db->f("sub_cat_id");
    		$query = "select * from categories where cat_id=$sub";
    		$db->query($query);
    		$db->next_record();
    		$cats .= "cat_id=" . $db->f("cat_id");
    		if ($db->f("sub_cat_id")>0){
    			$cats .= " or ";
    			$sub = $db->f("sub_cat_id");
    			$query = "select * from categories where cat_id=$sub";
    			$db->query($query);
    			$db->next_record();
    			$cats .= "cat_id=" . $db->f("cat_id");
    			if ($db->f("sub_cat_id")>0){
    				$cats .= " or ";
    				$sub = $db->f("sub_cat_id");
    				$query = "select * from categories where cat_id=$sub";
    				$db->query($query);
    				$db->next_record();
    				$cats .= "cat_id=" . $db->f("cat_id");
    				if ($db->f("sub_cat_id")>0){
    					$cats .= " or ";
    					$sub = $db->f("sub_cat_id");
    					$query = "select * from categories where cat_id=$sub";
    					$db->query($query);
    					$db->next_record();
    					$cats .= "cat_id=" . $db->f("cat_id");
    					if ($db->f("sub_cat_id")>0){
    						$cats .= " or ";
    						$sub = $db->f("sub_cat_id");
    						$query = "select * from categories where cat_id=$sub";
    						$db->query($query);
    						$db->next_record();
    						$cats .= "cat_id=" . $db->f("cat_id");
    					} else{
		    		    	$cats .= ")";
    					}
    				} else{
	    		    	$cats .= ")";
    				}
    			} else{
    		    	$cats .= ")";
    			}
    		} else{
    		    $cats .= ")";
    		}
    	} else{
    		$cats .= ")";
    	}
    } else{
    	$cats .= ")";
    }
	$query = "select * from custom_textarea where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"5%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{ta_name_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{ta_description_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"65%\" class=\"ItechClsDataTD\">" . htmlspecialchars("<textarea class=\"textareas\" style=\"WIDTH: 402px; HEIGHT: 238px\" name=\"{ta_var_" . $db->f("id") . "}\" rows=\"12\" cols=\"60\">{ta_value_" . $db->f("id") . "}</textarea>") . "</td>\n";
		$output .= "  </tr>\n";
	}
	$query = "select * from custom_textbox where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"5%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{tb_name_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{tb_description_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"65%\" class=\"ItechClsDataTD\">" . htmlspecialchars("<input class=\"inputs\" value=\"{tb_value_" . $db->f("id") . "}\" name=\"{tb_var_" . $db->f("id") . "}\">") . "</td>\n";
		$output .= "  </tr>\n";
	}
	$query = "select * from custom_dropdown where $cats";
	$db->query($query);
	while ($db->next_record()){
		$output .= "  <tr>\n";
		$output .= "    <td width=\"5%\" class=\"ItechClsDataTD\">" . $db->f("name") . "</td>\n";
  		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{dd_name_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"15%\" class=\"ItechClsDataTD\">{dd_description_" . $db->f("id") . "}</td>\n";
		$output .= "    <td width=\"65%\" class=\"ItechClsDataTD\">" . htmlspecialchars("<select class=\"select\" name=\"{dd_var_" . $db->f("id") . "}\">") . "<br>&nbsp;&nbsp;&nbsp;&nbsp;{dropdown_Options_" . $db->f("id") . "}<br>" . htmlspecialchars("</select>") . "</td>\n";
		$output .= "  </tr>\n";
	}
	$output .= "</table></td></tr>\n";

}

if ($_POST["save"]){
	$save_temp = new clsDBNetConnect;
	if ($temp->next_record()) {
		$query = "update $table set template='" . mysql_escape_string(stripslashes($_POST["page_temp"])) . "', active='" . $_POST["active"] . "', admin_override='" . $_POST["ao"] . "' where cat_id=" . $cat . " and id=" . $temp->f("id");
		$temp->seek();
	}
	else {
		$query = "insert into $table (cat_id, template, active, admin_override) values ('" . $cat . "','" . mysql_escape_string(stripslashes($_POST["page_temp"])) . "', '" . $_POST["active"] . "', '" . $_POST["ao"] . "')";
		$save_temp->query("select * from category_details where cat_id = '" . $cat . "'");
		if ($save_temp->next_record())
		    $save_temp->query("update category_details set $field = '1' where cat_id = '" . $cat . "'");
		else
			$save_temp->query("insert into category_details (cat_id, $field) values ('" . $cat . "', '1')");
	}
	$save_temp->query($query);
	header("Location:CatDetails.php?cat=" . $cat);
}

if ($_POST["delete"]){
	$del_temp = new clsDBNetConnect;
	if ($temp->next_record()) {
		$query = "delete from $table where cat_id=" . $cat . " and id=" . $temp->f("id");
		$temp->seek();
		$del_temp->query($query);
		if ($field != "storefront") {
			$del_temp->query("select id from templates_items where cat_id = '" . $cat . "'");
			if (!$del_temp->next_record()){
				$del_temp->query("select id from templates_cat where cat_id = '" . $cat . "'");
				if (!$del_temp->next_record()){
					$del_temp->query("select id from templates_gal where cat_id = '" . $cat . "'");
					if (!$del_temp->next_record()){
						$del_temp->query("select id from templates_newitem where cat_id = '" . $cat . "'");
						if (!$del_temp->next_record()){
							$del_temp->query("update category_details set `template` = '0' where cat_id='" . $cat . "'");
						}
					}
				}
			}
		} else {
			$del_temp->query("update category_details set `storefront` = '0' where cat_id='" . $cat . "'");
		}
		header("Location:CatDetails.php?cat=" . $cat);
	}
}

if (!$_GET["what"] && $table){
	if ($temp->next_record()) {
		$textareavalue = $temp->f("template");
		$temp->seek();
	}
}

if ($temp->next_record()){
	if ($temp->f("active"))
	    $useractive = "checked";
	if ($temp->f("admin_override"))
	    $adminactive = "checked";
} else {
	$useractive = "checked";
	$adminactive = "checked";
}

if ($_GET["what"] == "default"){
	
	$textareavalue = "";
	$file = "../templates/" . $file;
	$fp = fopen($file, "r");
	
	while ($line=fgets($fp, strlen($fp)))
	{
    	$textareavalue .= $line;
	}
    fclose($fp);
}

if ($_GET["what"] == "upload"){
	
	$textareavalue = "";
	$file = fopen($_FILES['htmlfile']['tmp_name'], "r");
	while ($line = fgets($file, filesize($_FILES['htmlfile']['tmp_name'])))
	{
		$textareavalue .= $line;
	}
	fclose($file);
}

if ($_GET["what"] == "geturl"){

	$textareavalue = "";
	$fileurl = str_replace("http://", "", $_POST["url"]);
	$file = fopen("http://" . $fileurl, "r");
	if ($file) {
		while ($line = fgets($file, strlen($file)))
		{
			$textareavalue .= $line;
		}
	}
	else {
		$error = "<br>HTML file not found at the given URL";
	}
	fclose($file);
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

$FileName = "edittemplates.php";
$Redirect = "";
$TemplateFileName = "Themes/edittemplates.html";
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

if ($_POST["preview"]){
	$name = PreviewTemplate($_GET["page"]);
	$JS = "<SCRIPT LANGUAGE=\"JavaScript\">\n<!--\nwindow.open('../" . $phppage . "&prev=" . $name . "','Ad','toolbar=1,location=0,directories=0,status=1,menubar=1,scrollbars=1,resizable=1,width=800,height=600');\n-->\n</script>";
    $Tpl->setVar("JS", $JS);
}
//Show Page @1-F9F38336
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->setVar("textareavalue",htmlspecialchars($textareavalue));
if ($_POST["page_temp"])
$Tpl->setVar("textareavalue", htmlspecialchars(stripslashes($_POST["page_temp"])));
$Tpl->setVar("cat", $_GET["cat"]);
$Tpl->setVar("page", $_GET["page"]);
$Tpl->setVar("error", $error);
$Tpl->setVar("category", $catdata->f("name"));
$Tpl->setVar("active", $useractive);
$Tpl->setVar("ao", $adminactive);
$Tpl->setVar("templatevars", $output);
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
