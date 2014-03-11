<?
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
$FindAll = new clsDBNetConnect;
$FindAll->connect();
$FindSQL = "SELECT * FROM items WHERE closes<'" . time() . "' AND status='1'";
$FindAll->query($FindSQL);
$Closer = new clsDBNetConnect;
$Closer->connect();
while($FindAll->next_record())
{
    $Closer->query("UPDATE items SET status='2' WHERE itemID='" . $FindAll->f("itemID") . "'");
}
$old = new clsDBNetConnect;
$old->connect();
$oldtime = time() - (86400 * 30);
$sql = "SELECT * FROM items WHERE closes <'" . $oldtime . "' AND status!='1'";
$old->query($sql);
$del = new clsDBNetConnect;
$del->connect();
while($old->next_record())
{
     @unlink($old->f("image_one"));
     @unlink($old->f("image_two"));
     @unlink($old->f("image_three"));
     @unlink($old->f("image_four"));
     @unlink($old->f("image_five"));
     $del->query("DELETE FROM items WHERE itemID='" . $old->f("itemID") . "'");
     $del->query("DELETE FROM custom_textarea_values WHERE ItemNum='" . $old->f("ItemNum") . "'");
     $del->query("DELETE FROM custom_textbox_values WHERE ItemNum='" . $old->f("ItemNum") . "'");
     $del->query("DELETE FROM custom_dropdown_values WHERE ItemNum='" . $old->f("ItemNum") . "'");
     $del->query("DELETE FROM listing_index WHERE ItemNum='" . $old->f("ItemNum") . "'");
}

echo "<body onload='javascript:window.close();'>";

?>
