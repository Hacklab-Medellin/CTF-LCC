<?php
//BindEvents Method @1-C2818FBD

function BindEvents()

{

    global $itemsSearch;

    $itemsSearch->CCSEvents["BeforeShow"] = "itemsSearch_BeforeShow";

}

//End BindEvents Method



function itemsSearch_BeforeShow() { //itemsSearch_BeforeShow @40-1F0E9553



//Set Tag @50-4DFC98E7

    global $Tpl;
    global $admingroup;

    $Tpl->SetVar("cat_id_in", $_GET["CatID"]);
	if($_GET["CatID"])
	{
	$ldb = new clsDBNetConnect;
		$ldb->connect();
		$ldb2 = new clsDBNetConnect;
		$ldb2->connect();
		$ldb3 = new clsDBNetConnect;
		$ldb3->connect();
		$ldb4 = new clsDBNetConnect;
		$ldb4->connect();
		$ldb5 = new clsDBNetConnect;
		$ldb5->connect();
		$ldb->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $_GET["CatID"]);
		if($ldb->next_record())
		{
			$newvars["catlist"] = "<a class=\"cats\" href=\"ViewCat.php?CatID=" . $ldb->f("cat_id") . "\">" . $ldb->f("name") . "</a>";
			$ldb2->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb->f("sub_cat_id"));
			if($ldb2->next_record())
			{
				$newvars["catlist"] = "<a class=\"cats\" href=\"ViewCat.php?CatID=" . $ldb2->f("cat_id") . "\">" . $ldb2->f("name") . "</a> > " . $newvars["catlist"];
				$ldb3->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb2->f("sub_cat_id"));
				if($ldb3->next_record())
				{
					$newvars["catlist"] = "<a class=\"cats\" href=\"ViewCat.php?CatID=" . $ldb3->f("cat_id") . "\">" . $ldb3->f("name") . "</a> > " . $newvars["catlist"];
					$ldb4->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb3->f("sub_cat_id"));
					if($ldb4->next_record())
					{
						$newvars["catlist"] = "<a class=\"cats\" href=\"ViewCat.php?CatID=" . $ldb4->f("cat_id") . "\">" . $ldb4->f("name") . "</a> > " . $newvars["catlist"];
						$ldb5->query("SELECT name, sub_cat_id, cat_id FROM categories WHERE cat_id=" . $ldb4->f("sub_cat_id"));
						if($ldb5->next_record())
						{
							$newvars["catlist"] = "<a class=\"cats\" href=\"ViewCat.php?CatID=" . $ldb5->f("cat_id") . "\">" . $ldb5->f("name") . "</a> > " . $newvars["catlist"];
							$maxdepth = TRUE;
				
						}
					}
				}
			}
		}
	}
		$Tpl->SetVar("catlist", $newvars["catlist"]);
		
		
		
		if ($admingroup && !$maxdepth){
			$QueryString = CCGetQueryString("QueryString", array());
			$AdminMenu= <<<EOD
    
<script>
		function toggleDisplayadminrow() {
			if (document.getElementById) {
				if(document.getElementById("adminrow").style.display=="block") {
					document.getElementById("adminrow").style.display="none";
					document.getElementById("adminrow_icon").src="images/expand.gif";
				}
				else {
					document.getElementById("adminrow").style.display="block";
					document.getElementById("adminrow_icon").src="images/minimize.gif";
				}
			}
		}
	</script>
	<table width="100%" border="0">
	<tr><td>
	<img id="adminrow_icon" src="images/expand.gif" width="16" height="16" onclick="javascript:toggleDisplayadminrow();" onmouseover="javascript:this.style.cursor='hand';"><b> -- Expand FrontEnd Admin Menu</b>
	</td></tr>
	<table id="adminrow" style="display:none;" width="100%">
	<tr><td>
	<form name="AdminMenu" method="POST" action="ViewCat.php?$QueryString">
	Add Sub-Categories: <input type="text" size="80" name="addcategory"><br>(Add as many categories as you like, seperated by a semi-colon, cat1;cat2;cat3)
	<br><input class="inspector" type="submit" value="Save New Categories" name="saveAddCats"/>
	</form>
	Other 'In Place' edits on this page:  The items in the Category List can be renamed and reordered.
	<ul><li><b>Rename Categories - </b>You can rename the subcategories within this category by double clicking their name in the category list on the left side, then clicking "Save Changes" after all your edits are finished</li>
	<li><b>Reorder Categories - </b>You can change the order in which the subcategories are displayed in this category by grabbing the "handle" beside each one and dragging it to where you want it in the list on the left side of the page.  Then click  "Save Changes" after all your edits are finished</li></ul>
	</td></tr></table>
	</table>
EOD;

			$Tpl->SetVar("AdminMenu", $AdminMenu);
}

//End Set Tag



} //Close itemsSearch_BeforeShow @40-FCB6E20C





?>