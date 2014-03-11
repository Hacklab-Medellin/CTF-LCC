<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

$admingroup = 0;
$admingroup = test_admin_group();

// Save the 'Edit-in-place' changes made by Admin
if ($_POST["SaveChanges"] && $admingroup){
	$db = new clsDBNetConnect;
	if ($_POST["descriptionEdit"])
		$db->query("update items set `description` = '" . mysql_escape_string($_POST["descriptionEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["added_descriptionEdit"])
		$db->query("update items set `added_description` = '" . mysql_escape_string($_POST["added_descriptionEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["titleEdit"])
		$db->query("update items set `title` = '" . mysql_escape_string($_POST["titleEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["quantityEdit"])
		$db->query("update items set `quantity` = '" . mysql_escape_string($_POST["quantityEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["city_townEdit"])
		$db->query("update items set `city_town` = '" . mysql_escape_string($_POST["city_townEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["state_provinceEdit"])
		$db->query("update items set `state_province` = '" . mysql_escape_string($_POST["state_provinceEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["asking_priceEdit"])
		$db->query("update items set `asking_price` = '" . mysql_escape_string($_POST["asking_priceEdit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["ship1Edit"])
		$db->query("update items set `ship1` = '" . mysql_escape_string($_POST["ship1Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["shipfee1Edit"])
		$db->query("update items set `shipfee1` = '" . mysql_escape_string($_POST["shipfee1Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["ship2Edit"])
		$db->query("update items set `ship2` = '" . mysql_escape_string($_POST["ship2Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["shipfee2Edit"])
		$db->query("update items set `shipfee2` = '" . mysql_escape_string($_POST["shipfee2Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["ship3Edit"])
		$db->query("update items set `ship3` = '" . mysql_escape_string($_POST["ship3Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["shipfee3Edit"])
		$db->query("update items set `shipfee3` = '" . mysql_escape_string($_POST["shipfee3Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["ship4Edit"])
		$db->query("update items set `ship4` = '" . mysql_escape_string($_POST["ship4Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["shipfee4Edit"])
		$db->query("update items set `shipfee4` = '" . mysql_escape_string($_POST["shipfee4Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["ship5Edit"])
		$db->query("update items set `ship5` = '" . mysql_escape_string($_POST["ship5Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($_POST["shipfee5Edit"])
		$db->query("update items set `shipfee5` = '" . mysql_escape_string($_POST["shipfee5Edit"]) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	foreach ($_POST as $key=>$value){
		if (rtrim(current(explode("_", $key))) == "tb"){
			if ($value) {
				$keyarray = explode("_", $key);
				end($keyarray);
				$db->query("update custom_textbox_values set `value` = '" . mysql_escape_string($value) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "' and `field_id` = '" . prev($keyarray) . "'");
				end($keyarray);
				index_listing($_GET["ItemNum"], $value, "tb", prev($keyarray));
			}
		}
		
		if (rtrim(current(explode("_", $key))) == "ta"){
			if ($value) {
				$keyarray = explode("_", $key);
				end($keyarray);
				$db->query("update custom_textarea_values set `value` = '" . mysql_escape_string($value) . "' where `ItemNum` = '" . $_GET["ItemNum"] . "' and `field_id` = '" . prev($keyarray) . "'");
				end($keyarray);
				index_listing($_GET["ItemNum"], $value, "ta", prev($keyarray));
			}
		}
	}
	index_listing($ItemNum);
	header("Location: ViewItem.php?" . CCGetQueryString("QueryString", array()));
}

// Move Item to another category on Admin's orders
if ($_POST["saveMoveCats"] && $admingroup){
	$db = new clsDBNetConnect;
	$db->query("select `category` from items where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	if ($db->next_record()){
		subtract_catcounts($db->f("category"));
	}
	$db->query("update items set `category` = '" . $_POST["movecategory"] . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'");
	add_catcounts($_POST["movecategory"]);
	header("Location: ViewItem.php?" . CCGetQueryString("QueryString", array()));
}

if ($_GET["approved"] && $admingroup) {
	$ItemNum = $_GET["ItemNum"];
	$db = new clsDBNetConnect;
	$query = "select * from `items` where `ItemNum` = '" . $_GET["ItemNum"] . "' and `status` = '99'";
	$db->query($query);
	if ($db->next_record()){
		$close = $db->f("close");
		$category = $db->f("category");
		$query = "select * from `lookup_listing_dates` where `date_id` = '" . $close . "'";
		$db->query($query);
		if ($db->next_record()){
			$closes = $db->f("days");
			$closes = 86400 * $closes;
			$closes = $closes + time();
			index_listing($ItemNum);
			$db = new clsDBNetConnect;
			$query = "Select * from custom_textarea_values where `ItemNum` = $ItemNum";
			$db->query($query);
			while ($db->next_record()){
				index_listing($ItemNum, $db->f("value"), "ta", $db->f("field_id"));
			}
			$query = "Select * from custom_textbox_values where `ItemNum` = $ItemNum";
			$db->query($query);
			while ($db->next_record()){
				index_listing($ItemNum, $db->f("value"), "tb", $db->f("field_id"));
			}
			$query = "Select * from custom_dropdown_values where `ItemNum` = $ItemNum";
			$db->query($query);
			while ($db->next_record()){
				index_listing($ItemNum, $db->f("option_id"), "dd", $db->f("field_id"), $db->f("option_id"));
			}
			add_catcounts($category);
			$query = "update `items` set `status` = '1', `closes` = '" . $closes . "' where `ItemNum` = '" . $_GET["ItemNum"] . "'";
			$db->query($query);
			
		}
	}
	header("Location:ViewItem.php?ItemNum=$ItemNum");
}

// Make sure Item Number exists
if ($_GET["ItemNum"]){
	$db = new CLSDBNetConnect;
	$query = "select user_id from items where ItemNum = " . $_GET["ItemNum"];
	$db->query($query);
	if (!$db->next_record()){
		Print "<b>Item Number not Found</b><br>This item is not on the system, if you are trying to access it from a saved link, bookmark or 'Wishlist' entry then the Item has been deleted by the seller or has been cleaned out by the system.  Please update your link to reflect this.<br><a href=\"myaccount.php\">Click here to go to your account</a><br><a href=\"index.php\">Click here to return to the Home Page</a>";
		exit;
	}
}

// Check if the user it logged in and if this Item is in a "members only" category
if (!CCGetUserID() && !CCGetFromGet("PreviewNum", "") && !$admingroup){
	$db = new CLSDBNetConnect;
	$query = "select c.cat_id from categories c, items i where i.ItemNum = " . $_GET["ItemNum"] . " and c.cat_id=i.category and (c.member != 1 or c.member IS NULL)";
	$db->query($query);
	if (!$db->next_record())
		CCSecurityRedirect("1;2", "login.php", "ViewItem.php", CCGetQueryString("QueryString", ""));
}

//End Include Common Files
$page="Viewing Item #" . CCGetFromGet("ItemNum", "");
if (CCGetFromGet("PreviewNum", ""))
$page="Previewing Item Preview #" . CCGetFromGet("PreviewNum", "");
global $REMOTE_ADDR;
global $now;
$ip=$REMOTE_ADDR;
$timeout = $now["timeout"];
$db1 = new clsDBNetConnect;
$db2 = new clsDBNetConnect;
$db3 = new clsDBNetConnect;
$db4 = new clsDBNetConnect;
$db5 = new clsDBNetConnect;
$times = time();

$SQL1 = "DELETE FROM online WHERE datet < $times";
$SQL2 = "SELECT * FROM online WHERE ip='$ip'";
$SQL3 = "UPDATE online SET datet=$times + $timeout, page='$page', user='" . CCGetUserName() . "' WHERE ip='$ip'";
$SQL4 = "INSERT INTO online (ip, datet, user, page) VALUES ('$ip', $times+$timeout,'". CCGetUserName() . "', '$page')";
$SQL5 = "SELECT * FROM online";

$db1->query($SQL1);
$db2->query($SQL2);
if($db2->next_record()){
        $db3->query($SQL3);
} else {
        $db4->query($SQL4);
}

$db5->query($SQL5);
$usersonline = $db5->num_rows();
unset($db1);
unset($db2);
unset($db3);
unset($db4);
unset($db5);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecorditems { //items Class @4-505305D9

//Variables @4-90DA4C9A

    // Public variables
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $FormSubmitted;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @4-8DF367BD
    function clsRecorditems()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "items";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->description = new clsControl(ccsLabel, "description", "Description", ccsMemo, "", CCGetRequestParam("description", $Method));
            $this->description->HTML = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @4-BA324CC7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlItemNum"] = CCGetFromGet("ItemNum", "");
        if (CCGetFromGet("PreviewNum", ""))
        $this->ds->Parameters["urlItemNum"] = CCGetFromGet("PreviewNum", "");
    }
//End Initialize Method

//Validate Method @4-C651947E
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->description->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-BE5576CD
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        $Redirect = "ViewItem.php?" . CCGetQueryString("QueryString", Array("ccsForm"));
    }
//End Operation Method

//Show Method @4-517BC01E
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $editorCSS;
        global $admingroup;
        global $joinJS;
        
        $Error = "";

        if(!$this->Visible)
            return;

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record items";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->description->SetValue($this->ds->description->GetValue());
                    if(!$this->FormSubmitted)
                    {
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->description->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->description->Show();
        if ($admingroup){
        	$editorCSS .= "\n#descriptionView {\n
border: 1px solid #fff;\n
padding: top:8px;\n
width: 100%;\n
max-width: 100%;\n
valign: center;\n
}\n
\n
#descriptionView:hover {\n
	background-color: #ffcccc;\n
	border-color: #ccc;\n
}\n
#descriptionEdit {\n
	width: 100%;\n
	border: 1px solid #fff;\n
	padding: 1px;\n
	background-color: #eeeeee;\n
	valign: center;\n
}\n";
        	$joinJS .= "join(\"description\", true)\n";
        	$desc = "\n<DIV id=\"descriptionView\">\n" . $this->ds->description->GetValue() . "\n</div>\n" . "<textarea id=\"descriptionEdit\" class=\"inplace\" tabindex=\"1\" name=\"descriptionEdit\"></textarea>\n";
        	$Tpl->setVar("description", $desc);
        	$Tpl->setVar("joinJS", $joinJS);
        	$Tpl->setVar("editorCSS", $editorCSS);
        }
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//Variables @4-CBFCAEBD
    var $CCSEvents = "";
    var $CCSEventResult;

    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $description;
//End Variables

//Class_Initialize Event @4-8FDFEA78
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->description = new clsField("description", ccsMemo, "");

    }
//End Class_Initialize Event

//Prepare Method @4-4B9A9D50
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItemNum", ccsInteger, "", "", $this->Parameters["urlItemNum"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ItemNum", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-2B286CE7
    function Open()
    {
    	$table = "items";
    	if (CCGetFromGet("PreviewNum", ""))
    	$table = "items_preview";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM $table";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-2B073CD9
    function SetValues()
    {
        $this->description->SetDBValue($this->f("description"));
    }
//End SetValues Method

} //End itemsDataSource Class @4-FCB6E20C

Class clsRecordemails { //emails Class @8-ACB218B9

//Variables @8-24EC06F7

    // Public variables
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $FormSubmitted;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $ReadAllowed;
    var $InsertAllowed;
    var $UpdateAllowed;
    var $DeleteAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @8-5E96CD10
    function clsRecordemails()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsemailsDataSource();
        $this->ReadAllowed = false;
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "emails";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->message = new clsControl(ccsTextArea, "message", "Message", ccsMemo, "", CCGetRequestParam("message", $Method));
            $this->Insert = new clsButton("Insert");
            $this->item_id = new clsControl(ccsHidden, "item_id", "Item Id", ccsInteger, "", CCGetRequestParam("item_id", $Method));
            $this->to_user_id = new clsControl(ccsHidden, "to_user_id", "To User Id", ccsInteger, "", CCGetRequestParam("to_user_id", $Method));
            $this->from_user_id = new clsControl(ccsHidden, "from_user_id", "From User Id", ccsInteger, "", CCGetRequestParam("from_user_id", $Method));
            $this->emaildate = new clsControl(ccsHidden, "emaildate", "date", ccsInteger, "", CCGetRequestParam("emaildate", $Method));
            $this->subject = new clsControl(ccsHidden, "subject", "Subject", ccsText, "", CCGetRequestParam("subject", $Method));
            if(!$this->FormSubmitted) {
                if(!strlen($this->from_user_id->GetValue()))
                    $this->from_user_id->SetValue(CCGetUserID());
                if(!strlen($this->emaildate->GetValue()))
                    $this->emaildate->SetValue(time());
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @8-EDF229C2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlemail_id"] = CCGetFromGet("email_id", "");
    }
//End Initialize Method

//Validate Method @8-A3100271
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->message->Validate() && $Validation);
        $Validation = ($this->item_id->Validate() && $Validation);
        $Validation = ($this->to_user_id->Validate() && $Validation);
        $Validation = ($this->from_user_id->Validate() && $Validation);
        $Validation = ($this->emaildate->Validate() && $Validation);
        $Validation = ($this->subject->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @8-4FFC51D1
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = "Insert";
            if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            }
        }
        $Redirect = "ViewItem.php?" . CCGetQueryString("QueryString", Array("Insert","ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @8-0FCE7D84
    function InsertRow()
    {
        global $EP;
                global $now;
                $db2 = new clsDBNetConnect;
                $db2->connect();

                $EP["EMAIL:AAQ_TO_SELLER_ID"] = $this->to_user_id->GetValue();
                $EP["EMAIL:AAQ_TO_SELLER_USERNAME"] = CCDLookUp("user_login", "users" , "user_id='" . $this->to_user_id->GetValue() . "'", $db2);
                $EP["EMAIL:AAQ_MESSAGE"] = $this->message->GetValue();
                $EP["EMAIL:AAQ_FROM_BUYER_ID"] = CCGetUserID();
                $EP["EMAIL:AAQ_FROM_BUYER_USERNAME"] = CCGetUserLogin();
                $EP["EMAIL:AAQ_TITLE"] = CCDLookUp("title", "items" , "ItemNum='" . $this->item_id->GetValue() . "'", $db2);
                $EP["EMAIL:AAQ_ITEM_NUMBER"] = $this->item_id->GetValue();
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        /*
        $this->ds->message->SetValue($newmessage);
        $this->ds->item_id->SetValue($this->item_id->GetValue());
        $this->ds->to_user_id->SetValue($this->to_user_id->GetValue());
        $this->ds->from_user_id->SetValue(CCGetUserID());
        $this->ds->emaildate->SetValue(time());
        $this->ds->subject->SetValue($newsubject);
        $this->ds->Insert();
        */
        mailout("AskAQuestion", 0, $this->to_user_id->GetValue(), CCGetUserID(), time(), $EP);
        //$this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Insert Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End InsertRow Method

//Show Method @8-3F09BAB5
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode && $this->ReadAllowed)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record emails";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->message->SetValue($this->ds->message->GetValue());
                        $this->item_id->SetValue($this->ds->item_id->GetValue());
                        $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());
                        $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());
                        $this->emaildate->SetValue($this->ds->emaildate->GetValue());
                        $this->subject->SetValue($this->ds->subject->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->message->Errors->ToString();
            $Error .= $this->item_id->Errors->ToString();
            $Error .= $this->to_user_id->Errors->ToString();
            $Error .= $this->from_user_id->Errors->ToString();
            $Error .= $this->emaildate->Errors->ToString();
            $Error .= $this->subject->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->message->Show();
        $this->Insert->Show();
        $this->item_id->Show();
        $this->to_user_id->Show();
        $this->from_user_id->Show();
        $this->emaildate->Show();
        $this->subject->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End emails Class @8-FCB6E20C

class clsemailsDataSource extends clsDBNetConnect {  //emailsDataSource Class @8-48567F33

//Variables @8-9065654D
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $message;
    var $item_id;
    var $to_user_id;
    var $from_user_id;
    var $emaildate;
    var $subject;
//End Variables

//Class_Initialize Event @8-D8102B3B
    function clsemailsDataSource()
    {
        $this->Initialize();
        $this->message = new clsField("message", ccsMemo, "");
        $this->item_id = new clsField("item_id", ccsInteger, "");
        $this->to_user_id = new clsField("to_user_id", ccsInteger, "");
        $this->from_user_id = new clsField("from_user_id", ccsInteger, "");
        $this->emaildate = new clsField("emaildate", ccsInteger, "");
        $this->subject = new clsField("subject", ccsText, "");

    }
//End Class_Initialize Event

//Prepare Method @8-9C05E373
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlemail_id", ccsInteger, "", "", $this->Parameters["urlemail_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @8-2A9A8869
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM emails";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @8-1416F40D
    function SetValues()
    {
        $this->message->SetDBValue($this->f("message"));
        $this->item_id->SetDBValue($this->f("item_id"));
        $this->to_user_id->SetDBValue($this->f("to_user_id"));
        $this->from_user_id->SetDBValue($this->f("from_user_id"));
        $this->emaildate->SetDBValue($this->f("emaildate"));
        $this->subject->SetDBValue($this->f("subject"));
    }
//End SetValues Method

//Insert Method @8-1D4C0F30
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO emails(" .
            "message, " .
            "item_id, " .
            "to_user_id, " .
            "from_user_id, " .
            "emaildate, " .
            "subject" .
        ") VALUES (" .
            $this->ToSQL($this->message->DBValue, $this->message->DataType) . ", " .
            $this->ToSQL($this->item_id->DBValue, $this->item_id->DataType) . ", " .
            $this->ToSQL($this->to_user_id->DBValue, $this->to_user_id->DataType) . ", " .
            $this->ToSQL($this->from_user_id->DBValue, $this->from_user_id->DataType) . ", " .
            $this->ToSQL($this->emaildate->DBValue, $this->emaildate->DataType) . ", " .
            $this->ToSQL($this->subject->DBValue, $this->subject->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End emailsDataSource Class @8-FCB6E20C

Class clsRecordemails1 { //emails1 Class @17-AD525986

//Variables @17-24EC06F7

    // Public variables
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $FormSubmitted;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $ReadAllowed;
    var $InsertAllowed;
    var $UpdateAllowed;
    var $DeleteAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @17-A9C735C1
    function clsRecordemails1()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsemails1DataSource();
        $this->ReadAllowed = false;
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        $this->Visible = (CCSecurityAccessCheck("1;2") == "success");
        if($this->Visible)
        {
            $this->ReadAllowed = CCUserInGroups(CCGetGroupID(), "1;2");
            $this->InsertAllowed = CCUserInGroups(CCGetGroupID(), "1;2");
            $this->ComponentName = "emails1";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->subject = new clsControl(ccsTextBox, "subject", "Amount", ccsText, "", CCGetRequestParam("subject", $Method));
            $this->subject->Required = true;
            $this->message = new clsControl(ccsTextArea, "message", "Message", ccsMemo, "", CCGetRequestParam("message", $Method));
            $this->Insert = new clsButton("Insert");
            $this->item_id = new clsControl(ccsHidden, "item_id", "Item Id", ccsInteger, "", CCGetRequestParam("item_id", $Method));
            $this->to_user_id = new clsControl(ccsHidden, "to_user_id", "To User Id", ccsInteger, "", CCGetRequestParam("to_user_id", $Method));
            $this->from_user_id = new clsControl(ccsHidden, "from_user_id", "From User Id", ccsInteger, "", CCGetRequestParam("from_user_id", $Method));
            $this->emaildate = new clsControl(ccsHidden, "emaildate", "date", ccsInteger, "", CCGetRequestParam("emaildate", $Method));
            if(!$this->FormSubmitted) {
                if(!strlen($this->subject->GetValue()))
                    $this->subject->SetValue(0.00);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @17-EDF229C2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlemail_id"] = CCGetFromGet("email_id", "");
    }
//End Initialize Method

//Validate Method @17-28E177EE
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->subject->Validate() && $Validation);
        $Validation = ($this->message->Validate() && $Validation);
        //$Validation = ($this->item_id->Validate() && $Validation);
        //$Validation = ($this->to_user_id->Validate() && $Validation);
        //$Validation = ($this->from_user_id->Validate() && $Validation);
        //$Validation = ($this->emaildate->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @17-4FFC51D1
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = "Insert";
            if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            }
        }
        $Redirect = "ViewItem.php?" . CCGetQueryString("QueryString", Array("Insert","ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "Insert" && $this->InsertAllowed) {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @17-A1B04EE2
    function InsertRow()
    {
        global $EP;
                global $now;

                $db2 = new clsDBNetConnect;
                $db2->connect();
                $EP["EMAIL:MAO_TO_SELLER_ID"] = $this->to_user_id->GetValue();
                $EP["EMAIL:MAO_TO_SELLER_USERNAME"] = CCDLookUp("user_login", "users" , "user_id='" . $this->to_user_id->GetValue() . "'", $db2);
                $EP["EMAIL:MAO_MESSAGE"] = $this->message->GetValue();
                $EP["EMAIL:MAO_FROM_BUYER_ID"] = CCGetUserID();
                $EP["EMAIL:MAO_FROM_BUYER_USERNAME"] = CCGetUserLogin();
                $EP["EMAIL:MAO_ITEM_NUMBER"] = $this->item_id->GetValue();
                $EP["EMAIL:MAO_TITLE"] = CCDLookUp("title", "items" , "ItemNum='" . $this->item_id->GetValue() . "'", $db2);
                $EP["EMAIL:MAO_AMOUNT"] = $this->subject->GetValue();

                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        /*
        $this->ds->subject->SetValue($newsubject);
        $this->ds->message->SetValue($newmessage);
        $this->ds->item_id->SetValue($this->item_id->GetValue());
        $this->ds->to_user_id->SetValue($this->to_user_id->GetValue());
        $this->ds->from_user_id->SetValue(CCGetUserID());
        $this->ds->emaildate->SetValue(time());
        $this->ds->Insert();
        */
        mailout("MakeAnOffer", 0, $this->to_user_id->GetValue(), CCGetUserID(), time(), $EP);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Insert Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End InsertRow Method

//Show Method @17-F4EB142E
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode && $this->ReadAllowed)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record emails1";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->subject->SetValue($this->ds->subject->GetValue());
                        $this->message->SetValue($this->ds->message->GetValue());
                        $this->item_id->SetValue($this->ds->item_id->GetValue());
                        $this->to_user_id->SetValue($this->ds->to_user_id->GetValue());
                        $this->from_user_id->SetValue($this->ds->from_user_id->GetValue());
                        $this->emaildate->SetValue($this->ds->emaildate->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->subject->Errors->ToString();
            $Error .= $this->message->Errors->ToString();
            $Error .= $this->item_id->Errors->ToString();
            $Error .= $this->to_user_id->Errors->ToString();
            $Error .= $this->from_user_id->Errors->ToString();
            $Error .= $this->emaildate->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode && $this->InsertAllowed;
        $this->subject->Show();
        $this->message->Show();
        $this->Insert->Show();
        $this->item_id->Show();
        $this->to_user_id->Show();
        $this->from_user_id->Show();
        $this->emaildate->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End emails1 Class @17-FCB6E20C

class clsemails1DataSource extends clsDBNetConnect {  //emails1DataSource Class @17-ACB3BA51

//Variables @17-B105FB1E
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $subject;
    var $message;
    var $item_id;
    var $to_user_id;
    var $from_user_id;
    var $emaildate;
//End Variables

//Class_Initialize Event @17-30860884
    function clsemails1DataSource()
    {
        $this->Initialize();
        $this->subject = new clsField("subject", ccsText, "");
        $this->message = new clsField("message", ccsMemo, "");
        $this->item_id = new clsField("item_id", ccsInteger, "");
        $this->to_user_id = new clsField("to_user_id", ccsInteger, "");
        $this->from_user_id = new clsField("from_user_id", ccsInteger, "");
        $this->emaildate = new clsField("emaildate", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @17-9C05E373
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlemail_id", ccsInteger, "", "", $this->Parameters["urlemail_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "email_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @17-2A9A8869
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM emails";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @17-CF1D1A7C
    function SetValues()
    {
        $this->subject->SetDBValue($this->f("subject"));
        $this->message->SetDBValue($this->f("message"));
        $this->item_id->SetDBValue($this->f("item_id"));
        $this->to_user_id->SetDBValue($this->f("to_user_id"));
        $this->from_user_id->SetDBValue($this->f("from_user_id"));
        $this->emaildate->SetDBValue($this->f("emaildate"));
    }
//End SetValues Method

//Insert Method @17-613991C0
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO emails(" .
            "subject, " .
            "message, " .
            "item_id, " .
            "to_user_id, " .
            "from_user_id, " .
            "emaildate" .
        ") VALUES (" .
            $this->ToSQL($this->subject->DBValue, $this->subject->DataType) . ", " .
            $this->ToSQL($this->message->DBValue, $this->message->DataType) . ", " .
            $this->ToSQL($this->item_id->DBValue, $this->item_id->DataType) . ", " .
            $this->ToSQL($this->to_user_id->DBValue, $this->to_user_id->DataType) . ", " .
            $this->ToSQL($this->from_user_id->DBValue, $this->from_user_id->DataType) . ", " .
            $this->ToSQL($this->emaildate->DBValue, $this->emaildate->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End emails1DataSource Class @17-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-22FC6F40
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
if ($_GET["prev"])
	$file = "temp_templates/" . $_GET["prev"] . ".html";
else {
	if (CCGetFromGet("ItemNum", ""))
		$file = GetItemTemlate(CCGetFromGet("ItemNum",""));
	if (CCGetFromGet("PreviewNum", ""))
		$file = GetItemTemlate(CCGetFromGet("PreviewNum",""), "Preview");
}
$FileName = "ViewItem.php";
$Redirect = "";
$TemplateFileName = $file;
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-0E7F659A

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$items = new clsRecorditems();
$emails = new clsRecordemails();
$emails1 = new clsRecordemails1();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$items->Initialize();
$emails->Initialize();
$emails1->Initialize();

// Events
include("./ViewItem_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-0E06C94F
$Header->Operations();
$items->Operation();
$emails->Operation();
$emails1->Operation();
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
//include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-6B7496A9
$Header->Show("Header");
$items->Show();
$emails->Show();
$emails1->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page
if ($file != "templates/ViewItem.html")
unlink($file);
//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>

