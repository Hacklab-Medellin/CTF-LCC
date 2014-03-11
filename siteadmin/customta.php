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
$field_id = $_GET["field"];
$db = new clsDBNetConnect;

if ($field_id && !$_POST["field"]){
	$query = "select * from custom_textarea where `id`='" . $field_id . "'";
	$db->query($query);
	if ($db->next_record()){
		$_POST["name"] = $db->f("name");
		$_POST["template_var"] = $db->f("template_var");
		$_POST["description"] = $db->f("description");
		$_POST["cat"] = $db->f("cat_id");
		$_POST["field"] = $db->f("id");
		$_POST["searchable"] = $db->f("searchable");
	}
}

if ($_GET["action"]=="delete"){
	$error = "Are you sure you want to delete the following item?  This will also delete any data stored for these fields for all currently listed items.<br>Click \"Delete\" if you really wish to delete this field.";
	$deletebutton = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class=\"ItechClsButton\" type=\"submit\" value=\"Confirm Delete\" name=\"deleteconf\">";
}

if ($_POST["deleteconf"] && $_POST["field"]){
	$query = "delete from custom_textarea where `id`='" . $_POST["field"] . "'";
	$db->query($query);
	$query = "select * from custom_textarea where `cat_id`='" . $_POST["cat"] . "'";
	$db->query($query);
	if ($db->next_record()){
		$query = "";
	}
	else {
		$query = "select * from custom_textbox where `cat_id`='" . $_POST["cat"] . "'";
		$db->query($query);
		if ($db->next_record()){
			$query = "";
		}
		else{
			$query = "select * from custom_dropdown where `cat_id`='" . $_POST["cat"] . "'";
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
	$query = "delete from custom_textarea_values where field_id = " . $_POST["field"];
	$db->query($query);

	$_POST["name"] = "";
	$_POST["template_var"] = "";
	$_POST["description"] = "";
	$_POST["cat"] = "";
	$_REQUEST["field"] = "";
	$_POST["searchable"] = "";
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
    if (stristr($_POST["template_var"], "{") || stristr($_POST["template_var"], "}") || stristr($_POST["template_var"], "!") || stristr($_POST["template_var"], "?") || stristr($_POST["template_var"], "=") || stristr($_POST["template_var"], "|") ||stristr($_POST["template_var"], "\\") || stristr($_POST["template_var"], "/") || stristr($_POST["template_var"], "\"") ||stristr($_POST["template_var"], "\'") ||stristr($_POST["template_var"], "*"))
		$error .= "Invalid Character(s) In Template Variable Field<br>";

    if ($cats == "()")
		$special_cats = "";
	else
	    $special_cats = " and " . $cats;

	if ($_POST["field"])
	    $query = "select * from custom_textbox tb, custom_textarea ta, custom_dropdown dd where ((tb.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "tb.cat_id", $special_cats) . " and tb.id != '" . $_POST["field"] . "') or (ta.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "ta.cat_id", $special_cats) . " and ta.id != '" . $_POST["field"] . "') or (dd.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "dd.cat_id", $special_cats) . " and ta.id != '" . $_POST["field"] . "'))";
	else
		$query = "select * from custom_textbox tb, custom_textarea ta, custom_dropdown dd where ((tb.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "tb.cat_id", $special_cats) . ") or (ta.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "ta.cat_id", $special_cats) . ") or (dd.template_var = '" . mysql_escape_string($_POST["template_var"]) . "'" . str_replace("cat_id", "dd.cat_id", $special_cats) . ")) and ta.id != '" . $_POST["field"] . "'";
	$db->query($query);
	if ($db->next_record()){
		$error .= "Template Variable Already Exists in the System, Please Choose a Unique One<br>";
	}
	else {
		if (!$_POST["field"] && !$error){
			$query = "insert into custom_textarea (`cat_id`, `name`, `template_var`, `description`, `searchable`) values ('" . mysql_escape_string($_POST["cat"]) . "', '" . mysql_escape_string($_POST["name"]) . "', '" . mysql_escape_string($_POST["template_var"]) . "', '" . mysql_escape_string($_POST["description"]) . "', '" . mysql_escape_string($_POST["searchable"]) . "')";
			$db->query("select * from category_details where cat_id = '" . $_POST["cat"] . "'");
			if ($db->next_record())
			    $db->query("update category_details set `field` = '1' where cat_id = '" . $_POST["cat"] . "'");
			else
			    $db->query("insert into category_details (`cat_id`, `field`) values ('" . $_POST["cat"] . "', '1')");
		} elseif ($_POST["field"] && !$error) {
		    $query = "update custom_textarea set `cat_id` = '" . mysql_escape_string($_POST["cat"]) . "', `name` = '" . mysql_escape_string($_POST["name"]) . "', `template_var` = '" . mysql_escape_string($_POST["template_var"]) . "', `description` = '" . mysql_escape_string($_POST["description"]) . "', `searchable` = '" . mysql_escape_string($_POST["searchable"]) . "' where `id` = " . $_POST["field"];
		}
		$db->query($query);
	}
	if (!$error){
		$_POST["name"] = "";
		$_POST["template_var"] = "";
		$_POST["description"] = "";
		$_POST["cat"] = "";
		$_REQUEST["field"] = "";
		$_POST["searchable"] = "";
	}
}

    if ($cats == "()")
    	$query = "select * from custom_textarea where id=0";
    else
		$query = "select * from custom_textarea where $cats";
 	$db->query($query);
    while($db->next_record()){
		$inherited .= "<a class=ItechClsDataLink href=\"customta.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . $db->f("name") . "  ---Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customta.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "&action=delete\">---!Delete!---</a><br>\n";
	}
	$query = "select * from custom_textarea where cat_id = '" . $CatID . "'";
	$db->query($query);
	while($db->next_record()){
		$thiscat .= "<a class=ItechClsDataLink href=\"customta.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . $db->f("name") . "  ---Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class=ItechClsDataLink href=\"customta.php?cat=" . $db->f("cat_id") . "&field=" . $db->f("id") . "&action=delete\">---!Delete!---</a><br>\n";
	}
	if ($inherited)
		$inherited = "<font class=ItechClsFormHeaderFont>Inherited Custom Text Area Fields</font><br><br>\n" . $inherited;
	else
	    $inherited = "<font class=ItechClsFormHeaderFont>Inherited Custom Text Area Fields</font><br><br>\n" . "<a class=ItechClsDataLink href=\"javascript:void(0);\">&nbsp;&nbsp;&nbsp;None<br>";
	if ($thiscat)
		$thiscat = "<br><a class=ItechClsDataLink href=\"customta.php?cat=$cat\"><font class=ItechClsFormHeaderFont>This Category's Custom Text Area Fields</font>  ---Add New</a><br><br>\n" . $thiscat;
	else
	    $thiscat = "<br><a class=ItechClsDataLink href=\"customta.php?cat=$cat\"><font class=ItechClsFormHeaderFont>This Category's Custom Text Area Fields</font>  ---Add New</a><br><br>\n" . "<a class=ItechClsDataLink href=\"javascript:void(0);\">&nbsp;&nbsp;&nbsp;None";


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

$FileName = "customta.php";
$Redirect = "";
$TemplateFileName = "Themes/customta.html";
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
$Tpl->setVar("inherited",$inherited);
$Tpl->setVar("thiscat",$thiscat);
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
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
