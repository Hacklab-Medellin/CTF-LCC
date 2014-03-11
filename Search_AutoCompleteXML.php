<?php
header('Content-Type: text/xml');

define("RelativePath", ".");
include(RelativePath . "/Common.php");

$db = new clsDBNetConnect;

if ($_GET["action"] == "title") {
	if ($_GET["subcats"] != "Any" && $_GET["subcats"]){
		$cats = "(`category` = '" . str_replace(";", "' or `category` = '", $_GET["subcats"]) . "')";
		$query = "select `title`, `ItemNum` from `items` where `title` LIKE '%" . mysql_escape_string($_GET["title"]) . "%' and $cats and `status` = '1' order by `hits` desc LIMIT 10";
	} 
	else {
		$query = "select `title`, `ItemNum` from `items` where `title` LIKE '%" . mysql_escape_string($_GET["title"]) . "%' and `status` = '1' order by `hits` desc LIMIT 10";
	}
	$db->query($query);
	echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <?
  if ($db->next_record()){
  	$db->seek();
  	while ($db->next_record()){
  		?><result><?php
  		//echo "1";
		echo htmlspecialchars($db->f("title")); ?></result><?		
  	}
  } else {
  	echo "<result>0</result>";
  }

		?>
</response>
		<?
  }

elseif ($_GET["action"] == "ItemNum") {
	if ($_GET["subcats"] != "Any" && $_GET["subcats"]){
		$cats = "(`category` = '" . str_replace(";", "' or `category` = '", $_GET["subcats"]) . "')";
		$query = "select `ItemNum`, `title` from `items` where `ItemNum` LIKE '%" . mysql_escape_string($_GET["ItemNum"]) . "%' and $cats and `status` = '1' order by `hits` desc LIMIT 10";
	} 
	else {
		$query = "select `title`, `ItemNum` from `items` where `ItemNum` LIKE '%" . mysql_escape_string($_GET["ItemNum"]) . "%' and `status` = '1' order by `hits` desc LIMIT 10";
	}
	$db->query($query);
	echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <?
  if ($db->next_record()){
  	$db->seek();
  	while ($db->next_record()){
  		?><result><?php
  		//echo "1";
		echo htmlspecialchars($db->f("ItemNum")); ?></result><?		
  	}
  } else {
  	echo "<result>0</result>";
  }

		?>
</response>
		<?
  }
  
elseif ($_GET["action"] == "user_id") {
	$query = "select `user_login` from `users` where `user_login` LIKE '%" . mysql_escape_string($_GET["user_id"]) . "%' LIMIT 10";
	$db->query($query);
	echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <?
  if ($db->next_record() && $_GET["user_id"]){
  	$db->seek();
  	while ($db->next_record()){
  		?><result><?php
  		//echo "1";
		echo htmlspecialchars($db->f("user_login")); ?></result><?		
  	}
  } else {
  	echo "<result>0</result>";
  }

		?>
</response>
		<?
  }
  
  
  
Else{
	?>
	<?php echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <method>checkEmail</method>
  <result>
  </result>
</response>
		<?
}
?>