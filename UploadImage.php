<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

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

//End Include Common Files
//Initialize Page @1-1826E861
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

$FileName = "UploadImage.php";
$Redirect = "";
$TemplateFileName = "templates/UploadImage.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-4A98D8DC
if (!$valid)
CCSecurityRedirect("1;2", "AccessDenied.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-C2EC4521

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

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
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-6C7D9FD3
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page

?>
<html>
<head>
<title>UploadImage</title>
<link rel="stylesheet" type="text/css" href="templates/images/Style.css">
<script language="JavaScript">
<!--
function pageLoad()
{
document.imbox.stbox.value = "Loading...";
document.imbox.submit();
}
// -->
</script>
</head>
<body bgcolor="#ffffff" text="#000000" link="#000000" vlink="#000000" alink="#999999">



<?

require("fileupload.class");
//global $now["uploadurl"];
$path = $now["uploadurl"];
$upload_file_name = "userfile";
$acceptable_file_types = "image/png|image/jpeg|image/gif|image/jpg|image/pjpeg";
$default_extension = "";

// MODE: if your are attempting to upload
// a file with the same name as another file in the
// $path directory
//
// OPTIONS:
//   1 = overwrite mode
//   2 = create new with incremental extention
//   3 = do nothing if exists, highest protection

        $mode = 2;
//$path = $now["uploadurl"];
$my_uploader = new uploader;

$images_set = new clsDBNetConnect;
$query = "select * from settings_images";
$images_set->query($query);
$images_set->next_record();

// OPTIONAL: set the max filesize of uploadable files in bytes
$my_uploader->max_filesize($images["maxupload"]);

// OPTIONAL: if you're uploading images, you can set the max pixel dimensions
$my_uploader->max_image_size($images_set->f("maxuploadwidth"), $images_set->f("maxuploadheight")); // max_image_size($width, $height)
// UPLOAD the file
if ($my_uploader->upload($upload_file_name, $acceptable_file_types, $default_extension)) {
        $success = $my_uploader->save_file($path, $mode);
}

        if ($success) {
                // Successful upload!
                $file_name = $my_uploader->file['name']; // The name of the file uploaded
                print "<HTML>\n";
                print "<HEAD>\n";
                print "<TITLE>Loading....</TITLE>\n";
                print "<META HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=UploadImageDone.php?which=" . $which . "&img=" . $path . $file_name . "&h=75&w=75&mode=0\">\n";
                print "</HEAD>\n";
                print "<BODY>\n";
                print "<b>Loading Image....</b>\n";
                print "</BODY>\n";
                print "</HTML>\n";

                //print_file($path . $file_name, $my_uploader->file["type"], 2);

        } else {
                // ERROR uploading...
                 if($my_uploader->errors) {
                        while(list($key, $var) = each($my_uploader->errors)) {
                                echo $var . "<br>";
                        }
                 }
         }

#--------------------------------#
# HTML FORM
#--------------------------------#
if(!isset($subm)){
	global $valid;
?>
 

  
	<form name="imbox" enctype="multipart/form-data" action="<? echo $PHP_SELF; ?>" method="POST">
                Upload this file:<br>
                <input name="userfile" type="file"><input type="hidden" name="adminkey" value="<? echo $valid; ?>">
                <input type="hidden" name="which" value="<? echo $which; ?>">
                <br><br>
                <input type="button" name="subm" value="Send Image" onClick="javascript: pageLoad();">
		    <input type="text" size="10" name="stbox">
        </form>
        <hr>




<?
        if ($acceptable_file_types) {
                print("<b>JPG</b>, <b>GIF</b> and <b>PNG</b> files are only allowed\n");
        }

}

#--------------------------------#
# EXTRA DISPLAY FUNCTION
#--------------------------------#
        function print_file($file, $type) {
                if($file) {
                        if(ereg("image", $type)) {
                                echo "<img src=\"" . $file . "\" border=\"0\" alt=\"\">";
                        } else {
                                $userfile = fopen($file, "r");
                                while(!feof($userfile)) {
                                        $line = fgets($userfile, 255);
                                        echo $line;
                                }
                        }
                }
        }
?>


</body>
</html>
