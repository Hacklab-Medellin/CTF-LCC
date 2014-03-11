<?php
header('Content-Type: text/xml');

define("RelativePath", ".");
include(RelativePath . "/Common.php");

$db = new clsDBNetConnect;

if ($_GET["user_login"]) {
	$query = "select `user_login` from users where `user_login` = '" . mysql_escape_string($_GET["user_login"]) . "'";
	$db->query($query);
	if ($db->next_record())
		$result = "1";
	else 
		$result = "0";
		?>
<?php echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <method>checkName</method>
  <result><?php 
    echo $result; ?>
  </result>
</response>
		<?
}
elseif ($_GET["email"]){
	$query = "select `email` from users where `email` = '" . mysql_escape_string($_GET["email"]) . "'";
	$db->query($query);
	if ($db->next_record())
		$result = "1";
	else 
		$result = "0";
		?>
<?php echo '<?xml version="1.0" encoding="UTF-8"
  standalone="yes"?>'; ?>
<response>
  <method>checkEmail</method>
  <result><?php 
    echo $result; ?>
  </result>
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
    0
  </result>
</response>
		<?
}
?>