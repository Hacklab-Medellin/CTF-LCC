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

$details = new clsDBNetConnect;
$details->query("select * from category_details");
unset($mods);
while ($details->next_record()){
	$mods[$details->f("cat_id")]["field"] = $details->f("field");
    $mods[$details->f("cat_id")]["template"] = $details->f("template");
    $mods[$details->f("cat_id")]["storefront"] = $details->f("storefront");
    $mods[$details->f("cat_id")]["pricing"] = $details->f("pricing");
}
$groups = "";
$details->query("select c.group_id, c.cat_id, g.title from groups_categories c, groups g where c.group_id = g.id");
while ($details->next_record()){
	//print $details->f("cat_id");
	if (isset($groups[$details->f("cat_id")]))
		$groups[$details->f("cat_id")] .= ", " . $details->f("title");
	else
	    $groups[$details->f("cat_id")] = $details->f("title");
}
$cattable = " <table class=\"ft\" border=\"0\" cellspacing=\"0\" width=\"350\">\n";
$cattable .= "  <tr>\n";
$cattable .= "    <TD class=\"ct\" align=\"middle\" width=\"175\"><font size=\"2\">Category Details</font></td>\n";
$cattable .= "    <TD class=\"ct\" align=\"middle\" width=\"105\"><font size=\"2\">Group</font>\n";
$cattable .= "    <font size=\"2\">Membership</font></td>\n";
$cattable .= "  </tr>\n";

$catlist = new clsDBDBNetConnect();
$catlist->query("select * from categories where sub_cat_id=0");
while($catlist->next_record()) {
	$custom_template[0] = "";
	$custom_field = "";
	$custom_pricing = "";
	$thisgroups = "";
	if ($_GET["cat"] == $catlist->f("cat_id"))
		$bgcolor = "#FFFFFF";
	$cattable .= "    <td width=\"225\">";
 	$cattable .= "<font size=\"1\">" . $catlist->f("name") . "</font>";
	if ($mods[$catlist->f("cat_id")]["storefront"] == 1){
		$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
	}
	if ($mods[$catlist->f("cat_id")]["template"] == 1){
		$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
		$custom_template[0] = 1;
	}
	else {
	    $custom_template[0] = 0;
	}
    if ($mods[$catlist->f("cat_id")]["field"] == 1){
        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
        $custom_field = 1;
    }
    if ($mods[$catlist->f("cat_id")]["pricing"] == 1){
        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
        $custom_pricing = 1;
    }
	$cattable .= "    &nbsp;<a href=\"CatDetails.php?cat=" . $catlist->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\" bgcolor=\"$bgcolor\">";
	if (isset($groups[$catlist->f("cat_id")])){
		$cattable .= "<font size=\"1\">" . $groups[$catlist->f("cat_id")] . "</font>";
		$thisgroups = "<font size=\"1\"><i>" . $groups[$catlist->f("cat_id")] . "</i></font>";
	}
	$cattable .= "&nbsp;</td></tr>";

	$catlist2 = new clsDBDBNetConnect();
  	$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
	while($catlist2->next_record()) {
        $custom_template[1] = "";
		$bgcolor = "FFFFFF";
		if ($_GET["cat"] == $catlist2->f("cat_id"))
			$bgcolor = "#FFFF66";
		$cattable .= "    <td width=\"225\">";
 		$cattable .= "<font size=\"1\">--" . $catlist2->f("name") . "</font>";
 		if ($custom_field) {
 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custfield_inherit.gif\">";
		}
		if ($mods[$catlist2->f("cat_id")]["field"] == 1){
	        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
	        $custom_field = 1;
	    }
	    if ($custom_pricing) {
 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing_inherit.gif\">";
		}
		if ($mods[$catlist2->f("cat_id")]["pricing"] == 1){
	        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
	        $custom_pricing = 1;
	    }
	    if (($custom_template[0]) && $mods[$catlist2->f("cat_id")]["template"] != 1){
				$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate_inherit.gif\">";
		}
		elseif ($mods[$catlist2->f("cat_id")]["template"] == 1){
			$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
			$custom_template[1] = 1;
		}
		else {
	    	$custom_template[1] = 0;
	    }
		$cattable .= "    &nbsp;<a href=\"CatDetails.php?cat=" . $catlist2->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\">";
		$cattable .= $thisgroups;
		$cattable .= "&nbsp;</td></tr>";

     	$catlist3 = new clsDBDBNetConnect();
     	$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
        while($catlist3->next_record()) {
        	$custom_template[2] = "";
			$bgcolor = "#CCCCCC";
			if ($_GET["cat"] == $catlist3->f("cat_id"))
				$bgcolor = "#FFFF66";
			$cattable .= "    <td width=\"225\">";
	 		$cattable .= "<font size=\"1\">------" . $catlist3->f("name") . "</font>";
	 		if ($custom_field) {
	 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custfield_inherit.gif\">";
	 		}
	 		if ($mods[$catlist3->f("cat_id")]["field"] == 1){
		        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
		        $custom_field = 1;
		    }
		    if ($custom_pricing) {
	 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing_inherit.gif\">";
	 		}
	 		if ($mods[$catlist3->f("cat_id")]["pricing"] == 1){
		        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
		        $custom_pricing = 1;
		    }
		    if (($custom_template[0] || $custom_template[1]) && $mods[$catlist3->f("cat_id")]["template"] != 1){
				$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate_inherit.gif\">";
			}
			elseif ($mods[$catlist3->f("cat_id")]["template"] == 1){
				$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
				$custom_template[2] = 1;
			}
			else {
	    		$custom_template[2] = 0;
	    	}


			$cattable .= "    <a href=\"CatDetails.php?cat=" . $catlist3->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\">";
			$cattable .= $thisgroups;
			$cattable .= "&nbsp;</td></tr>";

		    $catlist4 = new clsDBDBNetConnect();
        	$catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
			while($catlist4->next_record()) {
				$custom_template[3] = "";
				$bgcolor = "#C0C0C0";
				if ($_GET["cat"] == $catlist4->f("cat_id"))
					$bgcolor = "#FFFF66";
				$cattable .= "    <td width=\"225\">";
	 			$cattable .= "<font size=\"1\">----------" . $catlist4->f("name") . "</font>";
	 			if ($custom_field) {
		 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custfield_inherit.gif\">";
		 		}
		 		if ($mods[$catlist4->f("cat_id")]["field"] == 1){
			        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
			        $custom_field = 1;
			    }
			    if ($custom_pricing) {
		 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing_inherit.gif\">";
		 		}
		 		if ($mods[$catlist4->f("cat_id")]["pricing"] == 1){
			        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
			        $custom_pricing = 1;
			    }
			    if (($custom_template[0] || $custom_template[1] || $custom_template[2]) && $mods[$catlist4->f("cat_id")]["template"] != 1){
					$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate_inherit.gif\">";
				}
				elseif ($mods[$catlist4->f("cat_id")]["template"] == 1){
					$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
					$custom_template[3] = 1;
				}
				else {
	    			$custom_template[3] = 0;
	    		}

				$cattable .= "    <a href=\"CatDetails.php?cat=" . $catlist4->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\">";
				$cattable .= $thisgroups;
				$cattable .= "&nbsp;</td></tr>";

            	$catlist5 = new clsDBDBNetConnect();
            	$catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
              	while($catlist5->next_record()) {
              		$custom_template[4] = "";
					$bgcolor = "#999999";
					if ($_GET["cat"] == $catlist5->f("cat_id"))
						$bgcolor = "#FFFF66";
					$cattable .= "    <td width=\"225\">";
	 				$cattable .= "<font size=\"1\">--------------" . $catlist5->f("name") . "</font>";
	 				if ($custom_field) {
			 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custfield_inherit.gif\">";
			 		}
			 		if ($mods[$catlist5->f("cat_id")]["field"] == 1){
				        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
				        $custom_field = 1;
				    }
				    if ($custom_pricing) {
			 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing_inherit.gif\">";
			 		}
			 		if ($mods[$catlist5->f("cat_id")]["pricing"] == 1){
				        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
				        $custom_pricing = 1;
				    }
				    if (($custom_template[0] || $custom_template[1] ||$custom_template[2] || $custom_template[3]) && $mods[$catlist5->f("cat_id")]["template"] != 1){
						$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate_inherit.gif\">";
					}
					elseif ($mods[$catlist5->f("cat_id")]["template"] == 1){
						$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
						$custom_template[4] = 1;
					}
					else {
	    				$custom_template[4] = 0;
	    			}
					$cattable .= "    <a href=\"CatDetails.php?cat=" . $catlist5->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\">";
					$cattable .= $thisgroups;
					$cattable .= "&nbsp;</td></tr>";
					
					$catlist6 = new clsDBDBNetConnect();
            		$catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
              		while($catlist6->next_record()) {
	              		$custom_template[4] = "";
						$bgcolor = "#808080";
						if ($_GET["cat"] == $catlist6->f("cat_id"))
							$bgcolor = "#FFFFFF";
						$cattable .= "    <td width=\"225\" bgcolor=\"$bgcolor\">";
	 					$cattable .= "<font size=\"1\">------------------" . $catlist6->f("name") . "</font>";
	 					if ($custom_field) {
				 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custfield_inherit.gif\">";
			 			}
			 			if ($mods[$catlist6->f("cat_id")]["field"] == 1){
					        $cattable .= "  <img border=\"0\" src=\"Themes/images/custfield.gif\">";
				        	$custom_field = 1;
				    	}
				    	if ($custom_pricing) {
				 			$cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing_inherit.gif\">";
			 			}
			 			if ($mods[$catlist6->f("cat_id")]["pricing"] == 1){
					        $cattable .= "  <img border=\"0\" src=\"Themes/images/custpricing.gif\">";
				        	$custom_pricing = 1;
				    	}
				    	if (($custom_template[0] || $custom_template[1] ||$custom_template[2] || $custom_template[3]) && $mods[$catlist6->f("cat_id")]["template"] != 1){
							$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate_inherit.gif\">";
						}
						elseif ($mods[$catlist6->f("cat_id")]["template"] == 1){
							$cattable .= "  <img border=\"0\" src=\"Themes/images/custtemplate.gif\">";
							$custom_template[4] = 1;
						}
						else {
		    				$custom_template[4] = 0;
	    				}
						$cattable .= "    <a href=\"CatDetails.php?cat=" . $catlist6->f("cat_id") . "\" border=\"0\"><font color=#ff0000>Edit</font></a></td>\n    <td width=\"125\">";
						$cattable .= $thisgroups;
						$cattable .= "&nbsp;</td></tr>";
					}
				}
			}
		}
	}
}
$cattable .= "</table>";

if ($_GET["cat"]){
	$cattemplate = 0;
	$storefront = 0;
	$galtemplate = 0;
 	$itemtemplate = 0;
	$textarea = 0;
	$textbox = 0;
	$dropdown = 0;
	
	$db = new clsDBNetConnect;
	$query = "select * from templates_cat where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
		$template = 1;
		
	$query = "select * from templates_items where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
		$itemtemplate = 1;
		
	$query = "select sub_cat_id from categories where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("sub_cat_id") == 1){
		$storefront = "allowed";
		$query = "select * from templates_storefront where cat_id = $cat";
		$db->query($query);
		$db->next_record();
		if ($db->f("id"))
		    $storefront = "active";
	}
	
	$query = "select * from templates_gal where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
	    $galtemplate = 1;

    $query = "select * from templates_newitem where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
	    $newitemtemplate = 1;
	    
	$query = "select * from custom_textarea where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
	    $textarea = 1;
	    
	$query = "select * from custom_textbox where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
	    $textbox = 1;
	    
	$query = "select * from custom_dropdown where cat_id = $cat";
	$db->query($query);
	$db->next_record();
	if ($db->f("id"))
	    $dropdown = 1;

	$query = "select * from custom_textarea where cat_id = $cat";
	$db->query($query);
	$ta = "";
	while ($db->next_record()){
		$ta .= "<a class=ItechClsDataLink href=\"customta.php?cat=$cat&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . $db->f("name") . "  ---Edit</a><br>";
	}
	
	$query = "select * from custom_textbox where cat_id = $cat";
	$db->query($query);
	$tb = "";
	while ($db->next_record()){
		$tb .= "<a class=ItechClsDataLink href=\"customtb.php?cat=$cat&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . $db->f("name") . "  ---Edit</a><br>";
	}
	
	$query = "select * from custom_dropdown where cat_id = $cat";
	$db->query($query);
	$dd = "";
	$dropd = new clsDBNetConnect;
	while ($db->next_record()){
		$query = "select * from custom_dropdown_options where field_id=" . $db->f("id");
		$dd .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$cat&field=" . $db->f("id") . "\">&nbsp;&nbsp;&nbsp;" . $db->f("name") . "  ---Edit</a><br>";
		$dropd->query($query);
  		$dd .= "<ul>";
		while ($dropd->next_record()){
			if ($dropd->f("default") == 1)
			    $picked = "   ---Default Option";
			else
			    $picked = "";
			$dd .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$cat&field=" . $db->f("id") . "\"><li>" . $dropd->f("option") . $picked . "</li></a>";
		}
		$dd .= "</ul>";
	}

	$links = "";
	if ($storefront){
		if ($storefront == "allowed")
			$links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=storefront&cat=$cat\">Create a \"StoreFront\" Template</a><br><br>\n";
		if ($storefront == "active")
		    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=storefront&cat=$cat\">Edit this \"StoreFront\" Template</a><br><br>\n";
	}
	if ($template == 1 && $storefront)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewcat&cat=$cat\">Edit this Category's \"ViewCat\" Template (A \"Storefront\" template will over-ride this on this category, but this template will still filter down to all the sub-categories)</a><br><br>\n";
	if ($template == 0 && $storefront)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewcat&cat=$cat\">Create a \"ViewCat\" Template for this Category (A \"Storefront\" template will over-ride this on this category, but this template will still filter down to all the sub-categories)</a><br><br>\n";
	if ($template == 1 && !$storefront)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewcat&cat=$cat\">Edit this Category's \"ViewCat\" Template</a><br><br>\n";
	if ($template == 0 && !$storefront)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewcat&cat=$cat\">Create a \"ViewCat\" Template for this Category</a><br><br>\n";
	if ($galtemplate == 1)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=gallery&cat=$cat\">Edit this Category's Gallery Template</a><br><br>\n";
	if ($galtemplate == 0)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=gallery&cat=$cat\">Create a Gallery Template for this Category</a><br><br>\n";
	if ($itemtemplate == 1)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewitem&cat=$cat\">Edit this Category's Item Page Template</a><br><br>\n";
	if ($itemtemplate == 0)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=viewitem&cat=$cat\">Create an Item Page Template for this Category</a><br><br>\n";
    if ($newitemtemplate == 1)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=newitem&cat=$cat\">Edit this Category's NewItem (Listing Creation) Page Template<br>(This is not required to make your custom fields show up, they will by default automatically show up on the newitem page, this is just if you want to customize the way they are laid out on the newitem page)</a><br><br>\n";
	if ($newitemtemplate == 0)
	    $links .= "<a class=ItechClsDataLink href=\"edittemplates.php?page=newitem&cat=$cat\">Create a NewItem (Listing Creation) Page Template for this Category<br>(This is not required to make your custom fields show up, they will by default automatically show up on the newitem page, this is just if you want to customize the way they are laid out on the newitem page)</a><br><br>\n";
	$links .= "<hr width=\"100%\" size=\"5\" class=ItechClsSeparatorTD>";
	$links .= "<a class=ItechClsDataLink href=\"customta.php?cat=$cat\"><font class=ItechClsFormHeaderFont>Custom Text Area Fields</font>  ---Add New</a><br><br>\n";
	$links .= $ta;
	$links .= "<hr width=\"50%\" class=ItechClsSeparatorTD>";
	$links .= "<a class=ItechClsDataLink href=\"customtb.php?cat=$cat\"><font class=ItechClsFormHeaderFont>Custom Text Box Fields</font>  ---Add New</a><br><br>\n";
	$links .= $tb;
	$links .= "<hr width=\"50%\" class=ItechClsSeparatorTD>";
	$links .= "<a class=ItechClsDataLink href=\"customdd.php?cat=$cat\"><font class=ItechClsFormHeaderFont>Custom DropDown Boxes</font>  ---Add New</a><br><br>\n";
	$links .= $dd;
	$links .= "<hr width=\"100%\" size=\"5\" class=ItechClsSeparatorTD>";
	$links .= "<font class=ItechClsFormHeaderFont>Custom Pricing Structures</font><br><br>\n";
	$links .= "<a class=ItechClsDataLink href=\"Fees.php?cat_id=$cat\">Edit this Category's Listing Features Prices<a><br><br>\n";
	$links .= "<a class=ItechClsDataLink href=\"ListingDates.php?cat_id=$cat\">Edit this Category's Listing Days Values<a><br><br>\n";
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

$FileName = "CatDetails.php";
$Redirect = "";
$TemplateFileName = "Themes/CatDetails.html";
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
$Tpl->setVar("cattable",$cattable);
$Tpl->setVar("catlinks",$links);
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
