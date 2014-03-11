<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
$dir = "temp";
$removeImage = @unlink("./$imagename");
if ($removeImage) {
$out = "<HTML>\n";
        $out .= "<HEAD>\n";
        $out .= "<script language=\"JavaScript\">\n";
        $out .= "<!--\n";
        $out .= "function newDone() {\n";
        $out .= "opener.RemoveImage" . $ID . "();\n";
        //$out .= "opener.document.images[\"$which\"].src = \"$img\";\n";
        //$out .= "opener.document.items.$whichhid.value = \"$img\";\n";
        //$out .= "opener.document.images[\"$which\"].height = $nh;\n";
        //$out .= "opener.document.images[\"$which\"].width = $nw;\n";
        $out .= "window.close();\n";
        $out .= "}\n";
        $out .= "// -->\n";
        $out .= "</script>\n";
        $out .= "</HEAD>\n";
        $out .= "<BODY onLoad=\"newDone()\">\n";
        $out .= "</BODY>\n";
        $out .= "</HTML>\n";
print $out;
} else {
print "<b>No File to Remove</b>";
}

 ?>