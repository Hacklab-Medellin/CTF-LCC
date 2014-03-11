<?php
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Finishing Adding Listing";
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
if ($_GET["PreviewNum"]){
	$db = new clsDBNetConnect;
	$query = "delete from `items` where `ItemNum`='" . $_GET["PreviewNum"] . "'";
	$db->query($query);
	$query = "delete from `listing_index` where `ItemNum`='" . $_GET["PreviewNum"] . "'";
	$db->query($query);
	$query = "INSERT INTO items (
  `ItemNum`,
  `category`,
  `user_id`,
  `title`,
  `status`,
  `end_reason`,
  `started`,
  `close`,
  `closes`,
  `bold`,
  `background`,
  `cat_featured`,
  `home_featured`,
  `gallery_featured`,
  `image_preview`,
  `slide_show`,
  `counter`,
  `make_offer`,
  `image_one`,
  `image_two`,
  `image_three`,
  `image_four`,
  `image_five`,
  `asking_price`,
  `quantity`,
  `city_town`,
  `state_province`,
  `country`,
  `description`,
  `added_description`,
  `dateadded`,
  `item_paypal`,
  `ship1`,
  `shipfee1`,
  `ship2`,
  `shipfee2`,
  `ship3`,
  `shipfee3`,
  `ship4`,
  `shipfee4`,
  `ship5`,
  `shipfee5`) SELECT 
  `ItemNum`,
  `category`,
  `user_id`,
  `title`,
  `status`,
  `end_reason`,
  `started`,
  `close`,
  `closes`,
  `bold`,
  `background`,
  `cat_featured`,
  `home_featured`,
  `gallery_featured`,
  `image_preview`,
  `slide_show`,
  `counter`,
  `make_offer`,
  `image_one`,
  `image_two`,
  `image_three`,
  `image_four`,
  `image_five`,
  `asking_price`,
  `quantity`,
  `city_town`,
  `state_province`,
  `country`,
  `description`,
  `added_description`,
  `dateadded`,
  `item_paypal`,
  `ship1`,
  `shipfee1`,
  `ship2`,
  `shipfee2`,
  `ship3`,
  `shipfee3`,
  `ship4`,
  `shipfee4`,
  `ship5`,
  `shipfee5` from `items_preview` where `ItemNum` = '" . $_GET["PreviewNum"] . "'";
	$db->query($query);
	$query = "delete from `items_preview` where `ItemNum` = '" . $_GET["PreviewNum"] . "'";
	$db->query($query);
	CCSetSession("RecentItemNum", $_GET["PreviewNum"]);
	CCSetSession("RecentPreviewItem", "");
}


if (CCGetSession("RecentItemNum") != ""){
$db = new clsDBNetConnect();
$SQL = "SELECT * FROM items WHERE ItemNum=" . CCGetSession("RecentItemNum");
$db->connect();
$db->query($SQL);
$Result = $db->next_record();
$finalcat = $db->f("category");
$coupon = new clsDBNetConnect();
$SQL = "SELECT * FROM used_coupons WHERE ItemNum=" . CCGetSession("RecentItemNum") . " and `used` IS NULL";
$coupon->query($SQL);
if ($coupon->next_record()){
	$SQL = "SELECT * FROM coupons WHERE id=" . $coupon->f("coupon_id");
	$coupon->query($SQL);
	if ($coupon->next_record()){
		$coupon_percent = $coupon->f("discount");
		$code = $coupon->f("code");
	}
}
if ($_GET["usetoken"]==1 && !$_GET["ccsForm"]){
	$token = new clsDBNetConnect();
	$SQL = "SELECT tokens FROM users WHERE user_id=" . CCGetUserID();
	$token->query($SQL);
	if ($token->next_record()){
		if ($token->f("tokens") > 0){
			$number = $token->f("tokens");
			$number--;
			$SQL = "SELECT * FROM used_tokens WHERE ItemNum=" . CCGetSession("RecentItemNum") . " and `date` IS NULL";
			$token->query($SQL);
			if ($token->next_record()){
				Print "Token already used on this Listing <br>";
				print "<a href=\"StartListing.php\">Return to the Summery Page</a>";
				exit;
			}
			else{
				$SQL = "UPDATE users set tokens = " . $number . " where user_id=" . CCGetUserID();
				$token->query($SQL);
				$SQL = "INSERT INTO used_tokens (`user_id`, `ItemNum`) values ('" . CCGetUserID() . "', '" . CCGetSession("RecentItemNum") . "')";
				$token->query($SQL);
			}
		}
		else {
			print "You don't have any tokens to use... <br>";
			print "<a href=\"StartListing.php\">Return to the Summery Page</a>";
			exit;
		}
	}
}
if ($_GET["removetoken"]==1 && !$_GET["ccsForm"]){
	$token = new clsDBNetConnect();
	$SQL = "SELECT * FROM used_tokens WHERE ItemNum=" . CCGetSession("RecentItemNum") . " and `date` IS NULL";
	$token->query($SQL);
	if ($token->next_record()){
		$SQL = "SELECT tokens FROM users WHERE user_id=" . CCGetUserID();
		$token->query($SQL);
		if ($token->next_record()){
			$number = $token->f("tokens");
			$number++;
			$SQL = "UPDATE users set tokens = " . $number . " where user_id=" . CCGetUserID();
			$token->query($SQL);
			$SQL = "DELETE FROM used_tokens where `user_id` = '" . CCGetUserID() . "' and `ItemNum` = '" . CCGetSession("RecentItemNum") . "'";
			$token->query($SQL);
		}
	}
}
$item_token = 0;
$token = new clsDBNetConnect();
$SQL = "SELECT * FROM used_tokens WHERE ItemNum=" . CCGetSession("RecentItemNum") . " and `date` IS NULL";
$token->query($SQL);
if ($token->next_record()){
	$item_token = 1;
}
if($Result)
{
	$sum = new clsDBNetConnect;
	$query = "SELECT sum(charge) FROM `charges` WHERE user_id = " . CCGetUserID();
	$sum->query($query);
	if ($sum->next_record())
		$usertotal = $sum->f("sum(charge)");
	$acct_credit = "0.00";
	        global $regcharges;
	        $currency = $regcharges["currency"];
        	    $acton = 0;
		    $fdy = new clsDBNetConnect;
		    $fdy->connect;
		    $fdy->query("SELECT * FROM lookup_listing_dates WHERE date_id='" . $db->f("close") . "'");
		    while($fdy->next_record())
		    {
		         $dy = $fdy->f("days");
			   $dyfee = $fdy->f("fee");
			   $acton = $fdy->f("charge_for");
		    }

		    $ttldis = "<b>Item Number:</b> " . $db->f(ItemNum);
                $ttldis .= "<br><b>Listing Fee:</b> " . $currency . $charges["listing_fee"];
                $ttlcal = $charges["listing_fee"];
                if($db->f(bold)==1) {
                        $ttldis .= "<br><b>Bold</b> " . $currency . $charges["bold_fee"];
                        $ttlcal = $ttlcal + $charges["bold_fee"];
                }
		    if($acton == 1)
                {
		    		$ttldis .= "<br><b>Listing Duration Fee:</b> " . $dy . "days " . $currency . $dyfee;
				$ttlcal = $ttlcal + $dyfee;
		    }
                if($db->f(background)==1) {
                        $ttldis .= "<br><b>Highlighted:</b> " . $currency . $charges["high_fee"];
                        $ttlcal = $ttlcal + $charges["high_fee"];
                }
                if($db->f(cat_featured)==1) {
                        $ttldis .= "<br><b>Category Featured:</b> " . $currency . $charges["cat_fee"];
                        $ttlcal = $ttlcal + $charges["cat_fee"];
                }
                if($db->f(home_featured)==1) {
                        $ttldis .= "<br><b>Home Page Featured:</b> " . $currency . $charges["home_fee"];
                        $ttlcal = $ttlcal + $charges["home_fee"];
                }
                if($db->f(gallery_featured)==1) {
                        $ttldis .= "<br><b>Gallery Featured</b> " . $currency . $charges["gallery_fee"];
                        $ttlcal = $ttlcal + $charges["gallery_fee"];
                }
                if($db->f(image_preview)==1) {
                        $ttldis .= "<br><b>Image Preview</b> " . $currency . $charges["image_pre_fee"];
                        $ttlcal = $ttlcal + $charges["image_pre_fee"];
                }
                if($db->f(slide_show)==1) {
                        $ttldis .= "<br><b>Image Slide Show</b> " . $currency . $charges["slide_fee"];
                        $ttlcal = $ttlcal + $charges["slide_fee"];
                }
                if($db->f(counter)==1) {
                        $ttldis .= "<br><b>Counter</b> " . $currency . $charges["counter_fee"];
                        $ttlcal = $ttlcal + $charges["counter_fee"];
                }
                if($db->f(image_one)!="") {
                        $ttldis .= "<br><b>Image Upload</b> " . $currency . $charges["upload_fee"];
                        $ttlcal = $ttlcal + $charges["upload_fee"];
                }
                if($db->f(image_two)!="") {
                        $ttldis .= "<br><b>Image Upload</b> " . $currency . $charges["upload_fee"];
                        $ttlcal = $ttlcal + $charges["upload_fee"];
                }
                if($db->f(image_three)!="") {
                        $ttldis .= "<br><b>Image Upload</b> " . $currency . $charges["upload_fee"];
                        $ttlcal = $ttlcal + $charges["upload_fee"];
                }
                if($db->f(image_four)!="") {
                        $ttldis .= "<br><b>Image Upload</b> " . $currency . $charges["upload_fee"];
                        $ttlcal = $ttlcal + $charges["upload_fee"];
                }
                if($db->f(image_five)!="") {
                        $ttldis .= "<br><b>Image Upload</b> " . $currency . $charges["upload_fee"];
                        $ttlcal = $ttlcal + $charges["upload_fee"];
                }
                $group = GetGroupDiscount($ttlcal);
                if ($group["listing_discount"] > 0) {
                	$ttldis .= "<br><br><b>\"" . $group["title"] . "\" Group Discount: </b>" . $group["listing_discount"] . "%";
                	$ttlcal = $group["total"];
                }
                if ($coupon_percent) {
                	$coupon_disp = $coupon_percent*100;
                	$ttldis .= "<br><br><b>Coupon \"" . $code . "\" Discount: </b>" . $coupon_disp . "%";
                	$discal = round($ttlcal * $coupon_percent, 2);
                	$ttlcal = $ttlcal - $discal;
                }
				if ($usertotal > 0 && $ttlcal > 0 && !$item_token) {
					if($ttlcal-$usertotal > 0){
						$acct_credit = $usertotal;
						$ttlcal = $ttlcal-$usertotal;
						$ttldis .= "<br><br><b>Account Credit Used: </b>-" . pricepad($usertotal);
					}
					else {
						$acct_credit = $ttlcal;
						$ttlcal = "0.00";
						$ttldis .= "<br><br><b>Account Credit Used: </b>-" . pricepad($acct_credit);
					}
				}
                if ($item_token){
                	$ttldis .= "<br><br><b>FREE LISTING TOKEN USED: </b><br><a href=\"StartListing.php?removetoken=1\">Click here to remove this token and add it back to your account</a>";
                	$ttlcal = "0.00";
                }
                $ttlcal = round($ttlcal, 2);
                $ttldis .= "<br><br><b>Total:</b> " . $currency . pricepad($ttlcal);
}
unset($db);
unset($SQL);
unset($Result);
$db = new clsDBNetConnect();
$SQL = "update items set amt_due = $ttlcal, acct_credit_used = $acct_credit where ItemNum=" . CCGetSession("RecentItemNum");
$db->query($SQL);
unset($db);
unset($SQL);
unset($Result);
$dontshow=1;
} else {
$dontshow=0;
}
//Include Page implementation @2-503267A8
include("./Headeru.php");
//End Include Page implementation

Class clsRecordcharges { //charges Class @4-23D0AC71

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

//Class_Initialize Event @4-E4B0FEB5
    function clsRecordcharges()
    {

        global $FileName;
        global $ttlcal;
        global $usertotal;
        global $dontshow;
        $this->Visible = false;
                if(($ttlcal <= 0) && ($dontshow==1)) {
                                $this->Visible = true;
                }
        $this->Errors = new clsErrors();
        $this->ds = new clschargesDataSource();
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "charges";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", Array("PreviewNum")), "ccsForm", $this->ComponentName, "usetoken", "removetoken");
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->cause = new clsControl(ccsLabel, "cause", "Cause", ccsMemo, "", CCGetRequestParam("cause", $Method));
            $this->Insert = new clsButton("Insert");
            $this->user_id = new clsControl(ccsHidden, "user_id", "User Id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->date = new clsControl(ccsHidden, "date", "Date", ccsInteger, "", CCGetRequestParam("date", $Method));
            $this->charge = new clsControl(ccsHidden, "charge", "charge", ccsFloat, "", CCGetRequestParam("charge", $Method));
        }
    }
//End Class_Initialize Event

//Initialize Method @4-AF91F9DE
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlcharge_id"] = CCGetFromGet("charge_id", "");
    }
//End Initialize Method

//Validate Method @4-5D9EC684
    function Validate()
    {
        $Validation = true;
        $Where = "";
        //$Validation = ($this->cause->Validate() && $Validation);
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->date->Validate() && $Validation);
        //$Validation = ($this->charge->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-879E5DF7
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
        $Redirect = "myaccount.php";
        if($this->Validate()) {
            if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//InsertRow Method @4-CC1FC833
    function InsertRow()
    {
        global $ttlcal;
        global $ttldis;
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->user_id->SetValue(CCGetUserID());
        $this->ds->date->SetValue(time());
        $this->ds->charge->SetValue(0 - $ttlcal);
        $this->ds->cause->SetValue($ttldis);
        $this->ds->Insert();
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

//Show Method @4-FE65E765
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
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record charges";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->cause->SetValue($this->ds->cause->GetValue());
                    if(!$this->FormSubmitted)
                    {
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->date->SetValue($this->ds->date->GetValue());
                        $this->charge->SetValue($this->ds->charge->GetValue());
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
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->date->Errors->ToString();
            $Error .= $this->charge->Errors->ToString();
            $Error .= $this->cause->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Insert->Visible = !$this->EditMode;
        $this->Insert->Show();
        $this->user_id->Show();
        $this->date->Show();
        $this->charge->Show();
        $this->cause->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges Class @4-FCB6E20C

class clschargesDataSource extends clsDBNetConnect {  //chargesDataSource Class @4-FA5C06A6

//Variables @4-A2F336A4
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $user_id;
    var $date;
    var $charge;
    var $cause;
//End Variables

//Class_Initialize Event @4-242BD195
    function clschargesDataSource()
    {
        $this->Initialize();
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->date = new clsField("date", ccsInteger, "");
        $this->charge = new clsField("charge", ccsFloat, "");
        $this->cause = new clsField("cause", ccsMemo, "");

    }
//End Class_Initialize Event

//Prepare Method @4-7FAE8833
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlcharge_id", ccsInteger, "", "", $this->Parameters["urlcharge_id"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "charge_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-09BFC025
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM charges";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-B52DBFC3
    function SetValues()
    {
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->date->SetDBValue($this->f("date"));
        $this->charge->SetDBValue($this->f("charge"));
        $this->cause->SetDBValue($this->f("cause"));
    }
//End SetValues Method

//Insert Method @4-B4316922
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $SQL = "INSERT INTO charges(" .
            "user_id, " .
            "date, " .
                        "cause, " .
            "charge" .
        ") VALUES (" .
            $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            $this->ToSQL($this->date->DBValue, $this->date->DataType) . ", " .
                        $this->ToSQL($this->cause->DBValue, $this->cause->DataType) . ", " .
            $this->ToSQL($this->charge->DBValue, $this->charge->DataType) .
        ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Insert Method

} //End chargesDataSource Class @4-FCB6E20C

Class clsRecordcharges1 { //charges1 Class @11-386271B0

//Variables @11-36685894

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
//End Variables

//Class_Initialize Event @11-A3D49235
    function clsRecordcharges1()
    {

        global $FileName;
        global $ttlcal;
        global $usertotal;
        global $dontshow;
        $this->Visible = false;
                if(($ttlcal > 0) && ($dontshow==1)) {
                                $this->Visible = true;
                }
        $this->Errors = new clsErrors();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "charges1";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", Array("PreviewNum")), "ccsForm", $this->ComponentName, "usetoken", "removetoken");
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
        }
    }
//End Class_Initialize Event

//Validate Method @11-7E1FC38C
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @11-C8787856
    function Operation()
    {
        global $Redirect;

        $this->EditMode = false;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        $Redirect = "?" . CCGetQueryString("QueryString", Array("ccsForm", "PreviewNum", "usetoken", "removetoken"));
    }
//End Operation Method

//Show Method @11-5F7359DD
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End charges1 Class @11-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-E230A775
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

$FileName = "StartListing.php";
$Redirect = "";
$TemplateFileName = "templates/StartListing.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-F03D3BAB

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$charges = new clsRecordcharges();
$charges1 = new clsRecordcharges1();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$charges->Initialize();

// Events
include("./StartListing_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-12EAE39F
$Header->Operations();
$charges->Operation();
$charges1->Operation();
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
$Tpl->setVar("ItemNum", CCGetSession("RecentItemNum"));
$Tpl->setVar("finalcat", $finalcat);

//Show Page @1-C99B99CD
$Header->Show("Header");
$charges->Show();
$charges1->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
