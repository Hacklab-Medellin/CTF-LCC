<?
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}

function Page_BeforeShow() {
}

function buildcats($box2,$box3,$box4,$box5,$selected2,$selected3,$selected4,$selected5) {
	global $Tpl;
	global $Item_Number;
	$valid = "";
	if ($_REQUEST["adminkey"]) {
		$admin = new clsDBNetConnect;
		$query = "select * from administrators";
		$admin->query($query);
		while ($admin->next_record()){
			$key = md5($admin->f("username") . "AdMin kkkkkey" . $admin->f("password"));
			if ($key == $_REQUEST["adminkey"])
		    	$valid = $key;
		}
	}
	
	if($_REQUEST["Item_Number"]){
		$item = new clsDBNetConnect;
		$item->query("select cat_id, name from categories cat, items i where ItemNum='" . $_REQUEST["Item_Number"] . "' and i.category=cat.cat_id");
		if ($item->next_record()) {
			$keepcat = "<input type=\"submit\" value=\"Continue Without Changing the Category\" name=\"Submit\">";
			$selected1 = $item->f("cat_id");
			$current_cat = $item->f("name");
		}
		if (!$box2){
			$groups = new clsDBNetConnect;
			$sql = "select * from categories where cat_id = '" . $selected1 . "'";
 			$groups->query($sql);
    		$groups->next_record();
    		if ($groups->f("sub_cat_id") > 1) {
    			$cat1 = $groups->f("sub_cat_id");
    			$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";
 				$groups->query($sql);
	    		$groups->next_record();
    			if ($groups->f("sub_cat_id") > 1) {
    				$cat2 = $groups->f("sub_cat_id");
	    			$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";
	 				$groups->query($sql);
	    			$groups->next_record();
	    	    	if ($groups->f("sub_cat_id") > 1) {
		    	    	$cat3 = $groups->f("sub_cat_id");
		    			$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";
	 					$groups->query($sql);
	    				$groups->next_record();
	    				if ($groups->f("sub_cat_id") > 1) {
	    					$cat4 = $groups->f("sub_cat_id");
    						$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";
 							$groups->query($sql);
    						$groups->next_record();
	    	    			if ($groups->f("sub_cat_id") > 1) {
								$cat5 = $groups->f("sub_cat_id");
	    						$sql = "select * from categories where cat_id = '" . $groups->f("sub_cat_id") . "'";
		 						$groups->query($sql);
		    					$groups->next_record();
		    				}
		    			}
		    		}
	    		}
	    	}
	    	if ($selected1 && !$cat1 && !$cat2 && !$cat3 && !$cat4 && !$cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$selected1&adminkey=$valid";
	    	if ($selected1 && $cat1 && !$cat2 && !$cat3 && !$cat4 && !$cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$cat1&box3=1&selected3=$selected1&adminkey=$valid";
	    	if ($selected1 && $cat1 && $cat2 && !$cat3 && !$cat4 && !$cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$cat2&box3=1&selected3=$cat1&box4=1&selected4=$selected1&adminkey=$valid";
	    	if ($selected1 && $cat1 && $cat2 && $cat3 && !$cat4 && !$cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$cat3&box3=1&selected3=$cat2&box4=1&selected4=$cat1&box5=1&selected5=$selected1&adminkey=$valid";
	    	if ($selected1 && $cat1 && $cat2 && $cat3 && $cat4 && !$cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$cat4&box3=1&selected3=$cat3&box4=1&selected4=$cat2&box5=1&selected5=$cat1&box6=1&selected6=$selected1&adminkey=$valid";
	    	if ($selected1 && $cat1 && $cat2 && $cat3 && $cat4 && $cat5)
	    		$urlstring = "Item_Number=" . $_REQUEST["Item_Number"] . "&box2=1&selected2=$cat5&box3=1&selected3=$cat4&box4=1&selected4=$cat3&box5=1&selected5=$cat2&box6=1&selected6=$cat1&box7=1&selected7=$selected1&adminkey=$valid";
			header("Location: catlist.php?" . $urlstring);
		}
	}

	include ("./Config/vars.php");
	$conn=mysql_connect($dbs["DB_HOST"],$dbs["DB_USER"],$dbs["DB_PASS"]);

	if (!$Item_Number && !$valid) {
$jscript = <<<EOD

function loadPage1(list,selected1) {

  location="./catlist.php?box2=1&selected2="+list.options[list.selectedIndex].value;

}
function loadPage2(list,selected1,selected2) {

  location="./catlist.php?box2=1&box3=1&selected2=$selected2&selected3="+list.options[list.selectedIndex].value;

}
function loadPage3(list,selected1,selected2,selected3) {

  location="./catlist.php?box2=1&box3=1&box4=1&selected2=$selected2&selected3=$selected3&selected4="+list.options[list.selectedIndex].value;

}
function loadPage4(list,selected1,selected2,selected3,selected4) {

  location="./catlist.php?box2=1&box3=1&box4=1&box5=1&selected2=$selected2&selected3=$selected3&selected4=$selected4&selected5="+list.options[list.selectedIndex].value;

}
function loadPage5(list,selected1,selected2,selected3,selected4,selected5) {

  location="./newitem.php?finalcat="+list.options[list.selectedIndex].value;

}
EOD;
} elseif ($valid && !$Item_Number) {
$jscript = <<<EOD

function loadPage1(list,selected1) {

  location="./catlist.php?adminkey=$valid&box2=1&selected2="+list.options[list.selectedIndex].value;

}
function loadPage2(list,selected1,selected2) {

  location="./catlist.php?adminkey=$valid&box2=1&box3=1&selected2=$selected2&selected3="+list.options[list.selectedIndex].value;

}
function loadPage3(list,selected1,selected2,selected3) {

  location="./catlist.php?adminkey=$valid&box2=1&box3=1&box4=1&selected2=$selected2&selected3=$selected3&selected4="+list.options[list.selectedIndex].value;

}
function loadPage4(list,selected1,selected2,selected3,selected4) {

  location="./catlist.php?adminkey=$valid&box2=1&box3=1&box4=1&box5=1&selected2=$selected2&selected3=$selected3&selected4=$selected4&selected5="+list.options[list.selectedIndex].value;

}
function loadPage5(list,selected1,selected2,selected3,selected4,selected5) {

  location="./newitem.php?adminkey=$valid&finalcat="+list.options[list.selectedIndex].value;

}
EOD;
} elseif (!$valid && $Item_Number) {
$jscript = <<<EOD

function loadPage1(list,selected1) {

  location="./catlist.php?Item_Number=$Item_Number&box2=1&selected2="+list.options[list.selectedIndex].value;

}
function loadPage2(list,selected1,selected2) {

  location="./catlist.php?Item_Number=$Item_Number&box2=1&box3=1&selected2=$selected2&selected3="+list.options[list.selectedIndex].value;

}
function loadPage3(list,selected1,selected2,selected3) {

  location="./catlist.php?Item_Number=$Item_Number&box2=1&box3=1&box4=1&selected2=$selected2&selected3=$selected3&selected4="+list.options[list.selectedIndex].value;

}
function loadPage4(list,selected1,selected2,selected3,selected4) {

  location="./catlist.php?Item_Number=$Item_Number&box2=1&box3=1&box4=1&box5=1&selected2=$selected2&selected3=$selected3&selected4=$selected4&selected5="+list.options[list.selectedIndex].value;

}
function loadPage5(list,selected1,selected2,selected3,selected4,selected5) {

  location="./newitem.php?Item_Number=$Item_Number&finalcat="+list.options[list.selectedIndex].value;

}
EOD;
} elseif ($valid && $Item_Number) {
$jscript = <<<EOD

function loadPage1(list,selected1) {

  location="./catlist.php?adminkey=$valid&Item_Number=$Item_Number&box2=1&selected2="+list.options[list.selectedIndex].value;

}
function loadPage2(list,selected1,selected2) {

  location="./catlist.php?adminkey=$valid&Item_Number=$Item_Number&box2=1&box3=1&selected2=$selected2&selected3="+list.options[list.selectedIndex].value;

}
function loadPage3(list,selected1,selected2,selected3) {

  location="./catlist.php?adminkey=$valid&Item_Number=$Item_Number&box2=1&box3=1&box4=1&selected2=$selected2&selected3=$selected3&selected4="+list.options[list.selectedIndex].value;

}
function loadPage4(list,selected1,selected2,selected3,selected4) {

  location="./catlist.php?adminkey=$valid&Item_Number=$Item_Number&box2=1&box3=1&box4=1&box5=1&selected2=$selected2&selected3=$selected3&selected4=$selected4&selected5="+list.options[list.selectedIndex].value;

}
function loadPage5(list,selected1,selected2,selected3,selected4,selected5) {

  location="./newitem.php?adminkey=$valid&Item_Number=$Item_Number&finalcat="+list.options[list.selectedIndex].value;

}
EOD;
}
$Tpl->SetVar("jscript",$jscript);
					
					if (!$selected1)
					$selected1=1;
					
					$onchange = "onchange=\"loadPage1(this.form.elements[0],1)\"";
					if ($valid || in_array("SuperUser", groupmemberships()))
					    $sql = "SELECT * from categories where sub_cat_id = 1 ORDER BY `weight`, `name` ASC";
					else
						$sql = "SELECT distinct cat.cat_id, cat.name, cat.sub_cat_id FROM categories cat, groups_users gu, groups_categories gc WHERE gu.user_id = '" . CCGetSession("UserID") . "' and gu.group_id = gc.group_id and gc.cat_id=cat.cat_id and cat.sub_cat_id=1 order by weight, name ASC";
					$groups = new clsDBNetConnect();
        			$groups->connect();
      				$groups->query($sql);
      				$options= "";
           			while ($groups->next_record()){
        			if ($groups->f("cat_id")==1)
						$current_cat = $groups->f("name");
						$id = $groups->f("cat_id");
						$name = $groups->f("name");
						if ($id == $selected2) {
							$options = $options . "<option selected value=\"$id\">$name</option>";
						}
						else {
						$options = $options . "<option value=\"$id\">$name</option>";
						}
					}
					$Tpl->SetVar("onchange1",$onchange);
					$Tpl->SetVar("options1",$options);
					$Tpl->SetVar("current_cat",$current_cat);
					$Tpl->SetVar("button","$keepcat");
					$Tpl->SetVar("adminkey", $valid);
					$Tpl->SetVar("action","newitem.php?Item_Number=$Item_Number&finalcat=$selected1");

				if ($box2 == 1 && check_cat_permission($selected2)) {
					$onchange = "onchange=\"loadPage2(this.form.elements[1],1,$selected2)\"";
					$query = "select * from categories where sub_cat_id = $selected2 ORDER BY `weight`, `name` ASC";
					$result = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.2" . mysql_error());
					$query = "select name from categories where cat_id = $selected2";
					$name = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.2" . mysql_error());
					$name = mysql_fetch_array($name);
					$current_cat = $name["name"];
					$options= "";
					while ($cat = mysql_fetch_array($result)) {
						$id = $cat["cat_id"];
						$name = $cat["name"];
						if ($id == $selected3) {
							$options = $options . "<option selected value=\"$id\">$name</option>";
						}
						else {
						$options = $options . "<option value=\"$id\">$name</option>";
						}
					}
					$Tpl->SetVar("onchange2",$onchange);
					$Tpl->SetVar("options2",$options);
					$Tpl->SetVar("current_cat",$current_cat);
					$Tpl->SetVar("adminkey", $valid);
					$Tpl->SetVar("button","<input type=\"submit\" value=\"Create Item in this Category\" name=\"Submit\">");
					$Tpl->SetVar("action","newitem.php?Item_Number=$Item_Number&finalcat=$selected2");
				}

				if ($box3 == 1 && check_cat_permission($selected3)) {
					$onchange = "onchange=\"loadPage3(this.form.elements[2],1,$selected2,$selected3)\"";
					$query = "select * from categories where sub_cat_id = $selected3 ORDER BY `weight`, `name` ASC";
					$result = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.3" . mysql_error());
					$query = "select name from categories where cat_id = $selected3";
					$name = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.3" . mysql_error());
					$name = mysql_fetch_array($name);
					$current_cat = $name["name"];
					$options= "";
					while ($cat = mysql_fetch_array($result)) {
						$id = $cat["cat_id"];
						$name = $cat["name"];
						if ($id == $selected4) {
							$options = $options . "<option selected value=\"$id\">$name</option>";
						}
						else {
						$options = $options . "<option value=\"$id\">$name</option>";
						}
					}
					$Tpl->SetVar("onchange3",$onchange);
					$Tpl->SetVar("options3",$options);
					$Tpl->SetVar("current_cat",$current_cat);
					$Tpl->SetVar("button","<input type=\"submit\" value=\"Create Item in this Category\" name=\"Submit\">");
					$Tpl->SetVar("action","newitem.php?Item_Number=$Item_Number&finalcat=$selected3");
				}

				if ($box4 == 1 && check_cat_permission($selected4)) {
					$onchange = "onchange=\"loadPage4(this.form.elements[3],1,$selected2,$selected3,$selected4)\"";
					$query = "select * from categories where sub_cat_id = $selected4 ORDER BY `weight`, `name` ASC";
					$result = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.4" . mysql_error());
					$query = "select name from categories where cat_id = $selected4";
					$name = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.4" . mysql_error());
					$name = mysql_fetch_array($name);
					$current_cat = $name["name"];
					$options= "";
					while ($cat = mysql_fetch_array($result)) {
						$id = $cat["cat_id"];
						$name = $cat["name"];
						if ($id == $selected5) {
							$options = $options . "<option selected value=\"$id\">$name</option>";
						}
						else {
						$options = $options . "<option value=\"$id\">$name</option>";
						}
					}
					$Tpl->SetVar("onchange4",$onchange);
					$Tpl->SetVar("options4",$options);
					$Tpl->SetVar("current_cat",$current_cat);
					$Tpl->SetVar("button","<input type=\"submit\" value=\"Create Item in this Category\" name=\"Submit\">");
					$Tpl->SetVar("action","newitem.php?Item_Number=$Item_Number&finalcat=$selected4");
				}
				
				if ($box5 == 1 && check_cat_permission($selected5)) {
					$onchange = "onchange=\"loadPage5(this.form.elements[4],1,$selected2,$selected3,$selected4,$selected5)\"";
					$query = "select * from categories where sub_cat_id = $selected5 ORDER BY `weight`, `name` ASC";
					$result = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.5" . mysql_error());
					$query = "select name from categories where cat_id = $selected5";
					$name = mysql_db_query($dbs["DB_NAME"],$query,$conn) or die ("Error in query: $query.5" . mysql_error());
					$name = mysql_fetch_array($name);
					$current_cat = $name["name"];
					$options= "";
					while ($cat = mysql_fetch_array($result)) {
						$id = $cat["cat_id"];
						$name = $cat["name"];
						$options = $options . "<option value=\"$id\">$name";
					}
					$Tpl->SetVar("onchange5",$onchange);
					$Tpl->SetVar("options5",$options);
					$Tpl->SetVar("current_cat",$current_cat);
					$Tpl->SetVar("button","<input type=\"submit\" value=\"Create Item in this Category\" name=\"Submit\">");
					$Tpl->SetVar("action","newitem.php?Item_Number=$Item_Number&finalcat=$selected5");
				}
}
?>
