<?
include '../Config/vars.php';
$db = mysql_connect("$dbs[DB_HOST]", "$dbs[DB_USER]", "$dbs[DB_PASS]") or die ("Could not connect to the database");
@mysql_select_db("$dbs[DB_NAME]", $db) or die ("Could not select the database");
$Folder = "../Lang/";
      $DirHandle = @opendir($Folder) or die($Folder." could not be opened.");
      while ($Filename1 = readdir($DirHandle))
      {
if(($Filename1!='.')&&($Filename1!='..')&&($Filename1!='lang_class.php')){
$filename = str_replace(".php","",$Filename1);
$lang_query=mysql_query("select * from `languages` where lang_file='$Filename1'", $db);
$lang_ch=mysql_num_rows($lang_query);
if($lang_ch == 0)
{
$lang_entry=mysql_query("INSERT INTO `languages` (`lang_id`, `lang_file`) VALUES ('', '$Filename1')");
}}}
?>