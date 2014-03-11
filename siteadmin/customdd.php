<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files

//Include Page implementation @33-503267A8
include("./Header.php");
//End Include Page implementation
$CatID = $_REQUEST["cat"];
$field_id = $_REQUEST["field"];
$option_id = $_REQUEST["option_id"];
$db = new clsDBNetConnect;

$savebutton = "<input class=\"ItechClsButton\" type=\"submit\" value=\"Save\" name=\"submit\">";


if ($field_id && !$_POST["description"] && !$_POST["template_var"] && !$_POST["name"]){
	$query = "select * from custom_dropdown where `id`='" . $field_id . "'";
	$db->query($query);
	if ($db->next_record()){
		$_POST["name"] = $db->f("name");
		$_POST["template_var"] = $db->f("template_var");
		$_POST["description"] = $db->f("description");
		$_POST["cat"] = $db->f("cat_id");
		$_POST["field"] = $db->f("id");
		$_POST["searchable"] = $db->f("searchable");
		$_POST["style"] = $db->f("style");
		$_POST["per_row"] = $db->f("per_row");
	}
}

if ($_GET["action"]=="delete"){
	$error = "Are you sure you want to delete the following item?  This will also delete any data stored for these fields for all currently listed items.<br>Click \"Delete\" if you really wish to delete this field.";
	$deletebutton = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"ItechClsButton\" type=\"submit\" value=\"Confirm Delete\" name=\"deleteconf\">";
}

if ($_GET["action"] == "deleteoption") {
	$error = "Are you sure you want to delete the following Option from this DropDown List?  This will also delete any data stored for this Option for all currently listed items.<br>Click \"Delete\" if you really wish to delete this Option.";
	$deletebutton = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"ItechClsButton\" type=\"submit\" value=\"Confirm Option Delete\" name=\"deleteoptionconf\">";
}

if ($_POST["deleteoptionconf"] && $field_id && $option_id){
	$query = "delete from custom_dropdown_values where `option_id` = '" . $option_id . "' and `field_id` = '" . $field_id . "'";
	$db->query($query);
	$query = "delete from custom_dropdown_options where `id` = '" . $option_id . "' and `field_id` = '" . $field_id . "'";
	$db->query($query);
	$_POST["deleteoptionconf"] = "";
	$option_id = "";
}

if ($_POST["deleteconf"] && $field_id){
	$query = "delete from custom_dropdown where `id`='" . $field_id . "'";
	$db->query($query);
	$query = "select * from custom_dropdown where `cat_id`='" . $_POST["cat"] . "'";
	$db->query($query);
	if ($db->next_record()){
		$query = "";
	}
	else {
		$query = "select * from custom_textarea where `cat_id`='" . $_POST["cat"] . "'";
		$db->query($query);
		if ($db->next_record()){
			$query = "";
		}
		else{
			$query = "select * from custom_textbox where `cat_id`='" . $_POST["cat"] . "'";
			$db->query($query);
			if ($db->next_record()){
				$query = "";
			}
			else{
				$query = "select * from category_details where cat_id = '" . $_POST["cat"] . "'";
				$db->query($query);
				if ($db->next_record()){
					$query = "update category_details set field='0' where cat_id='" . $_POST["cat"] . "'";
					$db->query($query);
				}
			}
		}
	}
	$query = "delete from custom_dropdown_values where field_id = " . $field_id;
	$db->query($query);
	$query = "delete from custom_dropdown_options where field_id = " . $field_id;
	$db->query($query);

	$_POST["name"] = "";
	$_POST["template_var"] = "";
	$_POST["description"] = "";
	$_POST["cat"] = "";
	$_REQUEST["field"] = "";
	$_POST["searchable"] = "";
	$_POST["style"] = "";
	$_POST["per_row"] = "";
}

    $cats = "(";
	$query = "select * from categories where cat_id='" .$CatID . "'";
	$db->query($query);
    $db->next_record();
    $catname = $db->f("name");
    //$cats .= "cat_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")>0){
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
    
if ($_POST["submit"]){
	if (stristr($_POST["template_var"], " ")) {
		$_POST["template_var"] = str_replace(" ", "_", $_POST["template_var"]);
		$error .= "Please Note that all your *Spaces* in the Template Variable have been replaced with *Underscores* and click 'Save' again";
	}
	if (!$_POST["name"])
		$error .= "Name field is blank<br>";
		
	$_POST["name"] = stripslashes($_POST["name"]);
	$_POST["description"] = stripslashes($_POST["description"]);
	if (stristr($_POST["name"], "{") || stristr($_POST["name"], "}") || stristr($_POST["name"], "!") || stristr($_POST["name"], "?") || stristr($_POST["name"], "=") || stristr($_POST["name"], "|") ||stristr($_POST["name"], "\\") || stristr($_POST["name"], "/") || stristr($_POST["name"], "\"") ||stristr($_POST["name"], "\'") ||stristr($_POST["name"], "*"))
		$error .= "Invalid Character In Name Field<br>";
    if (!$_POST["template_var"])
		$error .= "Template Variable field is blank<br>";
    if (stristr($_POST["template_var"], "{") || stristr($_POST["template_var"], "}") || stristr($_POST["template_var"], "!") || stristr($_POST["template_var"], "?") || stristr($_POST["template_var"], "=") || stristr($_POST["template_var"], "|") ||stristr($_POST["template_var"], "\\") || stristr($_POST["template_var"], "/") || stristr($_POST["template_var"], "\"") ||stristr($_POST["template_var"], "\'") ||stristr($_POST["natemplate_varme"], "*"))
		$error .= "Invalid Character(s) In Template Variable Field<br>";

    if ($cats == "()")
		$special_cats = "";
	else
	    $special_cats = " and " . $cats;

	if ($field_id)
	    $query = "select * from custom_textbox tb, custom_textarea ta, custom_dropdown dd where ((tb.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "tb.cat_id", $special_cats) . " and tb.id != '" . $_POST["field"] . "') or (ta.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "ta.cat_id", $special_cats) . " and ta.id != '" . $_POST["field"] . "') or (dd.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "dd.cat_id", $special_cats) . " and dd.id != '" . $_POST["field"] . "'))";
	else
		$query = "select * from custom_textbox tb, custom_textarea ta, custom_dropdown dd where ((tb.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "tb.cat_id", $special_cats) . ") or (ta.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "ta.cat_id", $special_cats) . ") or (dd.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "dd.cat_id", $special_cats) . "))";
	$db->query($query);
	if ($db->next_record()){
		$error .= "Template Variable Already Exists in the System, Please Choose a Unique One<br>";
	}
	else {
		if (!$_POST["field"] && !$error){
			$query = "insert into custom_dropdown (`cat_id`, `name`, `template_var`, `description`, `searchable`, `style`, `per_row`) values ('" . mysql_escape_string($_POST["cat"]) . "', '" . mysql_escape_string($_POST["name"]) . "', '" . mysql_escape_string($_POST["template_var"]) . "', '" . mysql_escape_string($_POST["description"]) . "', '" . mysql_escape_string($_POST["searchable"]) . "', '" . mysql_escape_string($_POST["style"]) . "', '" . mysql_escape_string($_POST["per_row"]) . "')";
			$db->query("select * from category_details where cat_id = '" . $_POST["cat"] . "'");
			if ($db->next_record())
			    $db->query("update category_details set `field` = '1' where cat_id = '" . $_POST["cat"] . "'");
			else {
			    $db->query("insert into category_details (`cat_id`, `field`) values ('" . $_POST["cat"] . "', '1')");
			}
		} elseif ($_POST["field"] && !$error) {
		    $query = "update custom_dropdown set `cat_id` = '" . mysql_escape_string($_POST["cat"]) . "', `name` = '" . mysql_escape_string($_POST["name"]) . "', `template_var` = '" . mysql_escape_string($_POST["template_var"]) . "', `description` = '" . mysql_escape_string($_POST["description"]) . "', `searchable` = '" . mysql_escape_string($_POST["searchable"]) . "', `style` = '" . mysql_escape_string($_POST["style"]) . "', `per_row` = '" . mysql_escape_string($_POST["per_row"]) . "' where `id` = " . $_POST["field"];
		}
		$db->query($query);
		if (!$field_id)
		    $field_id = mysql_insert_id();
	}
	if ($_POST["submit"] == "Save Option and Field Changes" && $_POST["option_name"]){
		$_POST["option_name"] = stripslashes($_POST["option_name"]);
		if (stristr($_POST["name"], "{") || stristr($_POST["name"], "}") || stristr($_POST["name"], "!") || stristr($_POST["name"], "?") || stristr($_POST["name"], "=") || stristr($_POST["name"], "|") ||stristr($_POST["name"], "\\") || stristr($_POST["name"], "/") || stristr($_POST["name"], "\"") ||stristr($_POST["name"], "\'") ||stristr($_POST["name"], "*"))
			$error .= "Invalid Character In Name Field<br>";
	}
	if ($_POST["submit"] == "Save Option and Field Changes" && !$error && $_POST["option_name"]){
		if ($_POST["default"]){
			$query = "update custom_dropdown_options set `default` = '0' where `field_id` = '" . $field_id . "'";
			$db->query($query);
		}
		if ($option_id) {
			$query = "update custom_dropdown_options set `field_id` = '" . mysql_escape_string($field_id) . "',`option` = '" . mysql_escape_string($_POST["option_name"]) . "', `default` = '" . $_POST["default"] . "' where id = '" . $option_id . "'";
			$option_id = "";
		}
		else
		    $query = "insert into custom_dropdown_options (`field_id`, `option`, `default`) values ('" . mysql_escape_string($field_id) . "', '" . mysql_escape_string($_POST["option_name"]) . "', '" . $_POST["default"] . "')";
		$db->query($query);
	}
}

    if ($cats == "()")
    	$query = "select * from custom_dropdown where id=0";
    else
		$query = "select * from custom_dropdown where $cats";



	
	$db->query($query);
	$dropd = new clsDBNetConnect;
	while ($db->next_record()){
		$query = "select * from custom_dropdown_options where field_id=" . $db->f("id");
		$inherited .= "<b><a class=ItechClsDataLink href=\"customdd.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . stripslashes($db->f("name")) . "  ---Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customdd.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "&action=delete\">---!Delete!---</a></b><br>\n";
		$dropd->query($query);
  		$inherited .= "<ul>";
		while ($dropd->next_record()){
			if ($dropd->f("default") == 1)
			    $picked = "   ---Default Option";
			else
			    $picked = "";
			$inherited .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$cat&field=" . $db->f("id") . "&option_id=" . $dropd->f("id") . "\"><li>" . stripslashes($dropd->f("option")) . $picked . "</li></a>\n";
		}
		$inherited .= "</ul>";
	}

	$query = "select * from custom_dropdown where cat_id = '" . $CatID . "'";
	$db->query($query);
	$dropd = new clsDBNetConnect;
	while ($db->next_record()){
		$query = "select * from custom_dropdown_options where field_id=" . $db->f("id");
		$thiscat .= "<b><a class=ItechClsDataLink href=\"customdd.php?cat=$cat&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . stripslashes($db->f("name")) . "  ---Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customdd.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "&action=delete\">---!Delete!---</a></b><br>\n";
		$dropd->query($query);
  		$thiscat .= "<ul>";
		while ($dropd->next_record()){
			if ($dropd->f("default") == 1)
			    $picked = "   ---Default Option";
			else
			    $picked = "";
			$thiscat .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$cat&field=" . $db->f("id") . "&option_id=" . $dropd->f("id") . "\"><li>" . stripslashes($dropd->f("option")) . $picked . "</li></a>\n";
		}
		$thiscat .= "</ul>";
	}
	
	if ($field_id || $_GET["action"] == "deleteoption"){
		$thisfield = "";
		$dropd = new clsDBNetConnect;
		$query = "select * from custom_dropdown_options where field_id=" . $field_id;
		$thisfield .= "<b><a class=ItechClsDataLink href=\"customdd.php?cat=$CatID&field=" . $field_id . "\">&nbsp;&nbsp;&nbsp;Options List:</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customdd.php?cat=" . $CatID . "&field=" . $field_id . "&action=delete\">---!Delete Field!---</a></b><br>\n";
		$dropd->query($query);
	  	$thisfield .= "<ul>";
		while ($dropd->next_record()){
			if ($dropd->f("default") == 1)
			    $picked = "   ---Default Option";
			else
			    $picked = "";
			$thisfield .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$CatID&field=" . $field_id . "&option_id=" . $dropd->f("id") . "\"><li>" . $dropd->f("option") . $picked . "</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customdd.php?cat=" . $CatID . "&field=" . $field_id . "&option_id=" . $dropd->f("id") . "&action=deleteoption\">---!Delete Option!---</a></li>\n";
		}
		$thisfield .= "<br><a class=ItechClsDataLink href=\"customdd.php?cat=" . $cat . "&field=" . $field_id . "\"> >>Add New<< </a></ul>\n";
		if ($option_id){
			$query = "select * from custom_dropdown_options where id = '" . $option_id . "'";
			$dropd->query($query);
			if ($dropd->next_record()){
				$option_name = 	stripslashes($dropd->f("option"));
				if ($dropd->f("default"))
				    $picked = "checked";
				else
				    $picked = "";
			}
			else
				$option_name = "";
		}
		else {
			$option_name = "";
			$option_id = "";
  }
		$addoption = "<p><font class=\"ItechClsTextarea\" color=\"#FFFFFF\">Add/Edit Option:</font><br><input class=\"ItechClsInput\" type=\"text\" name=\"option_name\" value=\"" . $option_name . "\" size=\"20\"><input type=\"hidden\" name=\"field\" value=\"" . $field_id . "\"><input type=\"hidden\" name=\"option_id\" value=\"" . $option_id . "\">&nbsp;&nbsp;<INPUT type=\"checkbox\" value=\"1\" name=\"default\" " . $picked . "><font class=\"ItechClsTextarea\" color=\"#FFFFFF\">&nbsp;Make Default</font></p>";
		$savebutton = "<input class=\"ItechClsButton\" type=\"submit\" value=\"Save Option and Field Changes\" name=\"submit\">";
	}
	
	
	if ($inherited)
		$inherited = "<font class=ItechClsFormHeaderFont>Inherited Custom Drop Down Fields</font><br><br>\n" . $inherited;
	else
	    $inherited = "<font class=ItechClsFormHeaderFont>Inherited Custom Drop Down Fields</font><br><br>\n" . "<a class=ItechClsDataLink href=\"javascript:void(0);\">&nbsp;&nbsp;&nbsp;None<br>";
	if ($thiscat)
		$thiscat = "<br><a class=ItechClsDataLink href=\"customdd.php?cat=$cat\"><font class=ItechClsFormHeaderFont>This Category's Custom Drop Down Fields</font>  ---Add New</a><br><br>\n" . $thiscat;
	else
	    $thiscat = "<br><a class=ItechClsDataLink href=\"customdd.php?cat=$cat\"><font class=ItechClsFormHeaderFont>This Category's Custom Drop Down Fields</font>  ---Add New</a><br><br>\n" . "<a class=ItechClsDataLink href=\"javascript:void(0);\">&nbsp;&nbsp;&nbsp;None";


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

$FileName = "customdd.php";
$Redirect = "";
$TemplateFileName = "Themes/customdd.html";
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

$Tpl->setVar("addoption", $addoption);
$Tpl->setVar("thisfield", $thisfield);
$Tpl->setVar("savebutton", $savebutton);
$Tpl->setVar("inherited", $inherited);
$Tpl->setVar("thiscat", $thiscat);
$Tpl->setVar("name", stripslashes($_POST["name"]));
$Tpl->setVar("template_var", stripslashes($_POST["template_var"]));
$Tpl->setVar("description", stripslashes($_POST["description"]));
$Tpl->setVar("cat", $_REQUEST["cat"]);
$Tpl->setVar("field", $_REQUEST["field"]);
$Tpl->setVar("catname", stripslashes($catname));
$Tpl->setVar("error", $error);
$Tpl->setVar("deletebutton", $deletebutton);
if ($_POST["searchable"])
	$Tpl->setVar("searchablecheck", " checked");
if ($_POST["style"] == "1")
	$Tpl->setVar("style1checked", " selected");
if ($_POST["style"] == "2")
	$Tpl->setVar("style2checked", " selected");
$Tpl->setVar("per_row", $_POST["per_row"]);
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
