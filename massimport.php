<?
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

include("./Header.php");
//End Include Page implementation

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-49274B25
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

$FileName = "stest.php";
$Redirect = "";
$TemplateFileName = "templates/stest.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-DBA4AC3D

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();

// Events
	
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
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

	$db = new clsDBNetConnect;
	
//	require("items.txt");
	$import = fread(fopen("items.txt", 'r'), filesize("items.txt"));
	$rows = explode("::!!::", $import);
	$x = 1;
	while ($x < 100){
		$i = 0;
	
		while ($rows[$i]){
			$fields = explode(" ;;!!;; ", $rows[$i]);
			//print_r($fields);
			$ItemNum = $fields[1] + $x;
			$query = "INSERT INTO items (`ItemNum`, `category`, `sub_category`, `user_id`, `title`, `status`, `end_reason`, `started`, `close`, `closes`, `bold`, `background`, `cat_featured`, `home_featured`, `gallery_featured`, `image_preview`, `slide_show`, `counter`, `make_offer`, `image_one`, `image_two`, `image_three`, `image_four`, `image_five`, `asking_price`, `quantity`, `city_town`, `state_province`, `country`, `description`, `added_description`, `dateadded`, `charges_incurred`, `totalcharges`, `hits`, `item_paypal`, `ship1`, `shipfee1`, `ship2`, `shipfee2`, `ship3`, `shipfee3`, `ship4`, `shipfee4`, `ship5`, `shipfee5`, `acct_credit_used`, `amt_due`, `notified`) VALUES ('" . $ItemNum . "', '" . $fields[2] . "', '" . $fields[3] . "', '" . $fields[4] . "', '" . mysql_escape_string($fields[5]) . "', '" . $fields[6] . "', '" . mysql_escape_string($fields[7]) . "', '" . $fields[8] . "', '" . $fields[9] . "', '" . $fields[10] . "', '" . $fields[11] . "', '" . $fields[12] . "', '" . $fields[13] . "', '" . $fields[14] . "', '" . $fields[15] . "', '" . $fields[16] . "', '" . $fields[17] . "', '" . $fields[18] . "', '" . $fields[19] . "', '" . mysql_escape_string($fields[21]) . "', '" . mysql_escape_string($fields[22]) . "', '" . mysql_escape_string($fields[23]) . "', '" . mysql_escape_string($fields[24]) . "', '" . mysql_escape_string($fields[25]) . "', '" . $fields[26] . "', '" . $fields[27] . "', '" . mysql_escape_string($fields[28]) . "', '" . mysql_escape_string($fields[29]) . "', '" . mysql_escape_string($fields[30]) . "', '" . mysql_escape_string($fields[31]) . "', '" . mysql_escape_string($fields[32]) . "', '" . $fields[33] . "', '" . $fields[34] . "', '" . $fields[35] . "', '" . mysql_escape_string($fields[36]) . "', '" . $fields[37] . "', '" . $fields[38] . "', '" . $fields[39] . "', '" . $fields[40] . "', '" . $fields[41] . "', '" . $fields[42] . "', '" . $fields[43] . "', '" . $fields[44] . "', '" . $fields[45] . "', '" . $fields[46] . "', '" . $fields[47] . "', '" . $fields[48] . "', '" . $fields[49] . "', '" . $fields[50] . "')";
			$db->query($query);
			$i++;
		}
		$x++;
	}
	//Print "import = ";
	//print $import;
	
//Show Page @1-A025E414
$Header->Show("Header");
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
