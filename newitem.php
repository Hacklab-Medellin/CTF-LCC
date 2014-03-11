<?php
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
	
	if (!check_cat_permission($_REQUEST["finalcat"])){
	    Print "You do not have access to this category<br>";
	    Print "<a href=\"myaccount.php\">Return to MyAccount</a>";
	    exit;
	}
	
	$catID = $_REQUEST["finalcat"];
	
	if (CCGetSession("RecentPreviewItem"))
		$_GET["Item_Number"] = CCGetSession("RecentPreviewItem");
//End Include Common Files
$page = "Creating a new listing";
if(CCGetFromGet("Item_Number", "")) {
        $page = "Editing Item #" . CCGetFromGet("Item_Number", "");
}
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
include("./Headeru.php");
//End Include Page implementation

function getparents($CatID){
	$cats = "(";
	$db = new clsDBNetConnect;
	$query = "select * from categories where cat_id='" .$CatID . "'";
	$db->query($query);
    $db->next_record();
    $cats .= "cat_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")){
    	$cats .= " or ";
    	$sub = $db->f("sub_cat_id");
    	$query = "select * from categories where cat_id=$sub";
    	$db->query($query);
    	$db->next_record();
    	$cats .= "cat_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")){
    		$cats .= " or ";
    		$sub = $db->f("sub_cat_id");
    		$query = "select * from categories where cat_id=$sub";
    		$db->query($query);
    		$db->next_record();
    		$cats .= "cat_id=" . $db->f("cat_id");
    		if ($db->f("sub_cat_id")){
    			$cats .= " or ";
    			$sub = $db->f("sub_cat_id");
    			$query = "select * from categories where cat_id=$sub";
    			$db->query($query);
    			$db->next_record();
    			$cats .= "cat_id=" . $db->f("cat_id");
    			if ($db->f("sub_cat_id")){
    				$cats .= " or ";
    				$sub = $db->f("sub_cat_id");
    				$query = "select * from categories where cat_id=$sub";
    				$db->query($query);
    				$db->next_record();
    				$cats .= "cat_id=" . $db->f("cat_id") . ")";
    			} else{
    		    	$cats .= ")";
    			}
    		} else{
    		    $cats .= ")";
    		}
    	} else{
    		$cats .= ")";
    	}
    } else{
    	$cats .= ")";
    }
    $query = "select * from lookup_listing_dates where $cats ORDER BY cat_id DESC limit 1";
    $db->query($query);
	if ($db->next_record())
	    $cat = $db->f("cat_id");
    else
        $cat = 1;

	return $cat;
}

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

//Class_Initialize Event @4-C610F581
    function clsRecorditems()
    {

        global $FileName;
        global $valid;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        if($this->Visible)
        {
            $this->ComponentName = "items";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", array("Preview")), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->category = new clsControl(ccsTextBox, "category", "Category", ccsInteger, "", CCGetRequestParam("category", $Method));
            $this->category->Required = true;
            $this->title = new clsControl(ccsTextBox, "title", "Title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->title->Required = true;
            $this->item_paypal = new clsControl(ccsTextBox, "item_paypal", "item_paypal", ccsText, "", CCGetRequestParam("item_paypal", $Method));
            $this->quantity = new clsControl(ccsTextBox, "quantity", "Quantity", ccsInteger, "", CCGetRequestParam("quantity", $Method));
            $this->ship1 = new clsControl(ccsTextBox, "ship1", "Shipping 1", ccsText, "", CCGetRequestParam("ship1", $Method));
            $this->shipfee1 = new clsControl(ccsTextBox, "shipfee1", "Shipping Fee 1", ccsFloat, "", CCGetRequestParam("shipfee1", $Method));
            $this->ship2 = new clsControl(ccsTextBox, "ship2", "Shipping 2", ccsText, "", CCGetRequestParam("ship2", $Method));
            $this->shipfee2 = new clsControl(ccsTextBox, "shipfee2", "Shipping Fee 2", ccsFloat, "", CCGetRequestParam("shipfee2", $Method));
            $this->ship3 = new clsControl(ccsTextBox, "ship3", "Shipping 3", ccsText, "", CCGetRequestParam("ship3", $Method));
            $this->shipfee3 = new clsControl(ccsTextBox, "shipfee3", "Shipping Fee 3", ccsFloat, "", CCGetRequestParam("shipfee3", $Method));
            $this->ship4 = new clsControl(ccsTextBox, "ship4", "Shipping 4", ccsText, "", CCGetRequestParam("ship4", $Method));
            $this->shipfee4 = new clsControl(ccsTextBox, "shipfee4", "Shipping Fee 4", ccsFloat, "", CCGetRequestParam("shipfee4", $Method));
            $this->ship5 = new clsControl(ccsTextBox, "ship5", "Shipping 5", ccsText, "", CCGetRequestParam("ship5", $Method));
            $this->shipfee5 = new clsControl(ccsTextBox, "shipfee5", "Shipping Fee 5", ccsFloat, "", CCGetRequestParam("shipfee5", $Method));
            $this->asking_price = new clsControl(ccsTextBox, "asking_price", "Asking Price", ccsFloat, "", CCGetRequestParam("asking_price", $Method));
            $this->make_offer = new clsControl(ccsCheckBox, "make_offer", "Make Offer", ccsInteger, "", CCGetRequestParam("make_offer", $Method));
            $this->make_offer->CheckedValue = 1;
            $this->make_offer->UncheckedValue = 0;
            $this->description = new clsControl(ccsTextArea, "description", "Description", ccsMemo, "", CCGetRequestParam("description", $Method));
            $this->image_preview = new clsControl(ccsCheckBox, "image_preview", "Image Preview", ccsInteger, "", CCGetRequestParam("image_preview", $Method));
            $this->image_preview->CheckedValue = 1;
            $this->image_preview->UncheckedValue = 0;
            $this->slide_show = new clsControl(ccsCheckBox, "slide_show", "Slide Show", ccsInteger, "", CCGetRequestParam("slide_show", $Method));
            $this->slide_show->CheckedValue = 1;
            $this->slide_show->UncheckedValue = 0;
            $this->city_town = new clsControl(ccsTextBox, "city_town", "City Town", ccsText, "", CCGetRequestParam("city_town", $Method));
            $this->state_province = new clsControl(ccsTextBox, "state_province", "State", ccsText, "", CCGetRequestParam("state_province", $Method));
		$this->country = new clsControl(ccsListBox, "country", "Country Id", ccsInteger, "", CCGetRequestParam("country", $Method));
            $this->country_ds = new clsDBNetConnect();
            $this->country_ds->SQL = "SELECT *  " .
"FROM lookup_countries";
            $country_values = CCGetListValues($this->country_ds, $this->country_ds->SQL, $this->country_ds->Where, $this->country_ds->Order, "country_id", "country_desc");
            $this->country->Values = $country_values;
            if ($valid) {
            	$this->fakeuser = new clsControl(ccsListBox, "fakeuser", "Fake User Id", ccsInteger, "", CCGetRequestParam("fakeuser", $Method));
            	$this->fakeuser_ds = new clsDBNetConnect();
            	$this->fakeuser_ds->SQL = "SELECT *  " .
				"FROM users";
            	$fakeuser_values = CCGetListValues($this->fakeuser_ds, $this->fakeuser_ds->SQL, $this->fakeuser_ds->Where, $this->fakeuser_ds->Order, "user_id", "user_login");
            	$this->fakeuser->Values = $fakeuser_values;
            	$this->startnow = new clsControl(ccsListBox, "startnow", "startnow", ccsInteger, "", CCGetRequestParam("startnow", $Method));
            	$startnow_values = array(array("0", "No"), array("1", "Yes"));
            	$this->startnow->Values = $startnow_values;
            	$this->addtime = new clsControl(ccsListBox, "addtime", "addtime", ccsInteger, "", CCGetRequestParam("addtime", $Method));
            	$addtime_values = array(array("0", "No"), array("1", "Yes"));
            	$this->addtime->Values = $addtime_values;
            }
//$this->close = new clsControl(ccsListBox, "close", "Close", ccsInteger, "", CCGetRequestParam("close", $Method));
//            $this->close_ds = new clsDBNetConnect();
//            $this->close_ds->SQL = "SELECT *  " .
//"FROM lookup_listing_dates";
//            $country_values = CCGetListValues($this->country_ds, $this->country_ds->SQL, $this->country_ds->Where, $this->country_ds->Order, "date_id", "days");
//            $this->country->Values = $country_values;
            $this->close = new clsControl(ccsListBox, "close", "Close", ccsInteger, "", CCGetRequestParam("close", $Method));
            $this->close_ds = new clsDBNetConnect();
            $closestCat = getparents($_GET["finalcat"]);
            if (!$closestCat)
            	$closestCat = 1;
            $this->close_ds->SQL = "SELECT *  " .
"FROM lookup_listing_dates where cat_id=" . $closestCat;
            $close_values = CCGetListValues($this->close_ds, $this->close_ds->SQL, $this->close_ds->Where, $this->close_ds->Order, "date_id", "days");
            $this->close->Values = $close_values;
            $this->home_featured = new clsControl(ccsListBox, "home_featured", "Home Featured", ccsInteger, "", CCGetRequestParam("home_featured", $Method));
            $home_featured_values = array(array("0", "No"), array("1", "Yes"));
            $this->home_featured->Values = $home_featured_values;
            $this->gallery_featured = new clsControl(ccsListBox, "gallery_featured", "Gallery Featured", ccsInteger, "", CCGetRequestParam("gallery_featured", $Method));
            $gallery_featured_values = array(array("0", "No"), array("1", "Yes"));
            $this->gallery_featured->Values = $gallery_featured_values;
            $this->cat_featured = new clsControl(ccsListBox, "cat_featured", "Cat Featured", ccsInteger, "", CCGetRequestParam("cat_featured", $Method));
            $cat_featured_values = array(array("0", "No"), array("1", "Yes"));
            $this->cat_featured->Values = $cat_featured_values;
            $this->bold = new clsControl(ccsListBox, "bold", "Bold", ccsInteger, "", CCGetRequestParam("bold", $Method));
            $bold_values = array(array("0", "No"), array("1", "Yes"));
            $this->bold->Values = $bold_values;
            $this->background = new clsControl(ccsListBox, "background", "Background", ccsInteger, "", CCGetRequestParam("background", $Method));
            $background_values = array(array("0", "No"), array("1", "Yes"));
            $this->background->Values = $background_values;
            $this->counter = new clsControl(ccsListBox, "counter", "Counter", ccsInteger, "", CCGetRequestParam("counter", $Method));
            $counter_values = array(array("0", "No"), array("1", "Yes"));
            $this->counter->Values = $counter_values;
            $this->ItemNum = new clsControl(ccsHidden, "ItemNum", "Num", ccsInteger, "", CCGetRequestParam("ItemNum", $Method));
            $this->ItemNum->Required = true;
            $this->user_id = new clsControl(ccsHidden, "user_id", "User Id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->closes = new clsControl(ccsHidden, "closes", "Closes on", ccsInteger, "", CCGetRequestParam("closes", $Method));
		$this->started = new clsControl(ccsHidden, "started", "Started on", ccsInteger, "", CCGetRequestParam("started", $Method));
            $this->status = new clsControl(ccsHidden, "status", "Status", ccsInteger, "", CCGetRequestParam("status", $Method));
            $this->image_five = new clsControl(ccsHidden, "image_five", "Image Five", ccsText, "", CCGetRequestParam("image_five", $Method));
            $this->image_four = new clsControl(ccsHidden, "image_four", "Image Four", ccsText, "", CCGetRequestParam("image_four", $Method));
            $this->image_three = new clsControl(ccsHidden, "image_three", "Image Three", ccsText, "", CCGetRequestParam("image_three", $Method));
            $this->image_two = new clsControl(ccsHidden, "image_two", "Image Two", ccsText, "", CCGetRequestParam("image_two", $Method));
            $this->image_one = new clsControl(ccsHidden, "image_one", "Image One", ccsText, "", CCGetRequestParam("image_one", $Method));
			$this->Update = new clsButton("Update");
            $this->Insert = new clsButton("Insert");
            $this->Preview = new clsButton("Preview");
        }
    }
//End Class_Initialize Event

//Initialize Method @4-1F11F9B2
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlItem_Number"] = CCGetFromGet("Item_Number", "");
        if (CCGetSession("RecentPreviewItem"))
        	$this->ds->Parameters["urlItem_Number"] = CCGetSession("RecentPreviewItem");
        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
    }
//End Initialize Method

//Validate Method @4-D39A4E74
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        $Validation = ($this->category->Validate() && $Validation);
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->item_paypal->Validate() && $Validation);
        $Validation = ($this->quantity->Validate() && $Validation);
        $Validation = ($this->ship1->Validate() && $Validation);
        $Validation = ($this->shipfee1->Validate() && $Validation);
        $Validation = ($this->ship2->Validate() && $Validation);
        $Validation = ($this->shipfee2->Validate() && $Validation);
        $Validation = ($this->ship3->Validate() && $Validation);
        $Validation = ($this->shipfee3->Validate() && $Validation);
        $Validation = ($this->ship4->Validate() && $Validation);
        $Validation = ($this->shipfee4->Validate() && $Validation);
        $Validation = ($this->ship5->Validate() && $Validation);
        $Validation = ($this->shipfee5->Validate() && $Validation);
        $Validation = ($this->asking_price->Validate() && $Validation);
        $Validation = ($this->make_offer->Validate() && $Validation);
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->image_preview->Validate() && $Validation);
        $Validation = ($this->slide_show->Validate() && $Validation);
        $Validation = ($this->city_town->Validate() && $Validation);
        $Validation = ($this->state_province->Validate() && $Validation);
        $Validation = ($this->close->Validate() && $Validation);
        $Validation = ($this->home_featured->Validate() && $Validation);
        $Validation = ($this->gallery_featured->Validate() && $Validation);
        $Validation = ($this->cat_featured->Validate() && $Validation);
        $Validation = ($this->bold->Validate() && $Validation);
        $Validation = ($this->background->Validate() && $Validation);
        $Validation = ($this->counter->Validate() && $Validation);
        //$Validation = ($this->ItemNum->Validate() && $Validation);
        //$Validation = ($this->user_id->Validate() && $Validation);
        //$Validation = ($this->status->Validate() && $Validation);
        $Validation = ($this->image_five->Validate() && $Validation);
        $Validation = ($this->image_four->Validate() && $Validation);
        $Validation = ($this->image_three->Validate() && $Validation);
        $Validation = ($this->image_two->Validate() && $Validation);
        $Validation = ($this->image_one->Validate() && $Validation);

        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-2599275F
    function Operation()
    {
        global $Redirect;
        global $valid;
        global $finalItemNum;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Insert";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            } else if(strlen(CCGetParam("Preview", ""))) {
                $this->PressedButton = "Preview";
            }
        }
        if (!$valid){
        	$Redirect = "StartListing.php?" . CCGetQueryString("QueryString", Array("Update","Insert","ccsForm","Preview"));
        if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                } else {
                    $Redirect = "StartListing.php?" . CCGetQueryString("QueryString", array("ccsForm","Preview"));
                }
            } else if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Preview") {
                if(!CCGetEvent($this->Preview->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                } else {
                	CCSetSession("RecentPreviewItem", $finalItemNum);
                    $Redirect = "ViewItem.php?PreviewNum=" . $finalItemNum;
                }
            }
        } else {
            $Redirect = "";
        }
       }else{
       	$Redirect = "siteadmin/ItemsList.php?" . CCGetQueryString("QueryString", Array("Update","Insert","ccsForm","Preview"));
        if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                } else {
                    $Redirect = "siteadmin/ItemsList.php?" . CCGetQueryString("QueryString", array("ccsForm","Preview"));
                }
            } else if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Preview") {
                if(!CCGetEvent($this->PrevUpdate->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                } else {
                    $Redirect = "ViewItem.php?PreviewNum=" . $finalItemNum;
                }
            }
        } else {
            $Redirect = "";
        }
       }
    }
//End Operation Method

//InsertRow Method @4-24DEA945
    function InsertRow()
    {
        global $finalItemNum;
        global $closes;
        global $valid;
        
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        $this->ds->category->SetValue($this->category->GetValue());
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->item_paypal->SetValue($this->item_paypal->GetValue());
        $this->ds->quantity->SetValue($this->quantity->GetValue());
        $this->ds->ship1->SetValue($this->ship1->GetValue());
        $this->ds->shipfee1->SetValue($this->shipfee1->GetValue());
        $this->ds->ship2->SetValue($this->ship2->GetValue());
        $this->ds->shipfee2->SetValue($this->shipfee2->GetValue());
        $this->ds->ship3->SetValue($this->ship3->GetValue());
        $this->ds->shipfee3->SetValue($this->shipfee3->GetValue());
        $this->ds->ship4->SetValue($this->ship4->GetValue());
        $this->ds->shipfee4->SetValue($this->shipfee4->GetValue());
        $this->ds->ship5->SetValue($this->ship5->GetValue());
        $this->ds->shipfee5->SetValue($this->shipfee5->GetValue());
        if($this->asking_price->GetValue() == NULL)
	  {
		$Asking = 0.00;
	  }
	  elseif($this->asking_price->GetValue() == 0)
	  {
		$Asking = 0.00;
	  }
        else
	  {
		$Asking = $this->asking_price->GetValue();
	  }
	  $this->ds->asking_price->SetValue($Asking);
        $this->ds->make_offer->SetValue($this->make_offer->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->image_preview->SetValue($this->image_preview->GetValue());
        $this->ds->slide_show->SetValue($this->slide_show->GetValue());
        $this->ds->city_town->SetValue($this->city_town->GetValue());
        $this->ds->state_province->SetValue($this->state_province->GetValue());
	  $this->ds->country->SetValue($this->country->GetValue());
	    if ($valid) {
		$this->ds->fakeuser->SetValue($this->fakeuser->GetValue());
		$this->ds->startnow->SetValue($this->startnow->GetValue());
		$this->ds->addtime->SetValue($this->addtime->GetValue());
		}
        $tempdb = new clsDBNetConnect;
        $tempdb->connect();
        $this->ds->close->SetValue($this->close->GetValue());
        $this->ds->closes->SetValue((86400 * CCDLookUp("days","lookup_listing_dates","date_id='" . $this->close->GetValue() . "'",$tempdb)) + time());
        $this->ds->started->SetValue(time());
	  $this->ds->home_featured->SetValue($this->home_featured->GetValue());
        $this->ds->gallery_featured->SetValue($this->gallery_featured->GetValue());
        $this->ds->cat_featured->SetValue($this->cat_featured->GetValue());
        $this->ds->bold->SetValue($this->bold->GetValue());
        $this->ds->background->SetValue($this->background->GetValue());
        $this->ds->counter->SetValue($this->counter->GetValue());
//        srand((double) microtime() * 1000000);
//        $randfin = date("md") . rand();
        list($usec, $sec) = explode(" ",microtime());
        $randfin =  substr_replace(substr($sec, 2), substr($usec, 2, 5), 0, 4);
        $this->ds->ItemNum->SetValue($randfin);
                $finalItemNum = $randfin;
        if ($_POST["ItemNum"]){
        	$finalItemNum = $_POST["ItemNum"];
        	$this->ds->ItemNum->SetValue($_POST["ItemNum"]);
        }
        if (CCGetSession("RecentPreviewItem"))
        	$finalItemNum = CCGetSession("RecentPreviewItem");
        CCSetSession("RecentItemNum", $finalItemNum);
        if (!$valid)
        $this->ds->user_id->SetValue(CCGetUserID());
        else
        $this->ds->user_id->SetValue($this->fakeuser->GetValue());
        $this->ds->status->SetValue(0);
        $this->ds->image_five->SetValue($this->image_five->GetValue());
        $this->ds->image_four->SetValue($this->image_four->GetValue());
        $this->ds->image_three->SetValue($this->image_three->GetValue());
        $this->ds->image_two->SetValue($this->image_two->GetValue());
        $this->ds->image_one->SetValue($this->image_one->GetValue());
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

//UpdateRow Method @4-AF12D6C4
    function UpdateRow()
    {
        global $closes;
        global $valid;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->category->SetValue($this->category->GetValue());
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->item_paypal->SetValue($this->item_paypal->GetValue());
        $this->ds->quantity->SetValue($this->quantity->GetValue());
        $this->ds->ship1->SetValue($this->ship1->GetValue());
        $this->ds->shipfee1->SetValue($this->shipfee1->GetValue());
        $this->ds->ship2->SetValue($this->ship2->GetValue());
        $this->ds->shipfee2->SetValue($this->shipfee2->GetValue());
        $this->ds->ship3->SetValue($this->ship3->GetValue());
        $this->ds->shipfee3->SetValue($this->shipfee3->GetValue());
        $this->ds->ship4->SetValue($this->ship4->GetValue());
        $this->ds->shipfee4->SetValue($this->shipfee4->GetValue());
        $this->ds->ship5->SetValue($this->ship5->GetValue());
        $this->ds->shipfee5->SetValue($this->shipfee5->GetValue());
        if($this->asking_price->GetValue() == NULL)
	  {
		$Asking = 0.00;
	  }
	  elseif($this->asking_price->GetValue() == 0)
	  {
		$Asking = 0.00;
	  }
        else
	  {
		$Asking = $this->asking_price->GetValue();
	  }
	  $this->ds->asking_price->SetValue($Asking);
        $this->ds->make_offer->SetValue($this->make_offer->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->image_preview->SetValue($this->image_preview->GetValue());
        $this->ds->slide_show->SetValue($this->slide_show->GetValue());
        $this->ds->city_town->SetValue($this->city_town->GetValue());
        $this->ds->state_province->SetValue($this->state_province->GetValue());
	  $this->ds->country->SetValue($this->country->GetValue());
	    if ($valid) {
	    $this->ds->fakeuser->SetValue($this->fakeuser->GetValue());
	    $this->ds->startnow->SetValue($this->startnow->GetValue());
	    $this->ds->addtime->SetValue($this->addtime->GetValue());
	    }
        $tempdb = new clsDBNetConnect;
        $tempdb->connect();
        $this->ds->close->SetValue($this->close->GetValue());
        $this->ds->closes->SetValue((86400 * CCDLookUp("days","lookup_listing_dates","date_id='" . $this->close->GetValue() . "'",$tempdb)) + time());
        $this->ds->started->SetValue(time());
	  $this->ds->home_featured->SetValue($this->home_featured->GetValue());
        $this->ds->gallery_featured->SetValue($this->gallery_featured->GetValue());
        $this->ds->cat_featured->SetValue($this->cat_featured->GetValue());
        $this->ds->bold->SetValue($this->bold->GetValue());
        $this->ds->background->SetValue($this->background->GetValue());
        $this->ds->counter->SetValue($this->counter->GetValue());
        $this->ds->ItemNum->SetValue($this->ItemNum->GetValue());
        CCSetSession("RecentItemNum", $this->ItemNum->GetValue());
        if (!$valid)
        $this->ds->user_id->SetValue(CCGetUserID());
        else
        $this->ds->user_id->SetValue($this->fakeuser->GetValue());
        $this->ds->status->SetValue(0);
        $this->ds->image_five->SetValue($this->image_five->GetValue());
        $this->ds->image_four->SetValue($this->image_four->GetValue());
        $this->ds->image_three->SetValue($this->image_three->GetValue());
        $this->ds->image_two->SetValue($this->image_two->GetValue());
        $this->ds->image_one->SetValue($this->image_one->GetValue());
        $this->ds->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Update Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End UpdateRow Method

//DeleteRow Method @4-A9D87FED
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");
        $this->ds->Delete();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete");
        if($this->ds->Errors->Count())
        {
            echo "Error in Record " . ComponentName . " / Delete Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End DeleteRow Method

//Show Method @4-29D73ED9
    function Show()
    {
        global $Tpl;
        global $FileName;
        global $valid;

        $Error = "";
        $finalcat = CCGetFromGet("finalcat", "");
        $Tpl->SetVar("category",$finalcat);
		$Tpl->SetVar("cat_name",$cat_name);

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
                    if(!$this->FormSubmitted)
                    {
                        $this->category->SetValue($this->ds->category->GetValue());
                        $this->title->SetValue($this->ds->title->GetValue());
                        $this->item_paypal->SetValue($this->ds->item_paypal->GetValue());
                        $this->quantity->SetValue($this->ds->quantity->GetValue());
                        $this->ship1->SetValue($this->ds->ship1->GetValue());
                        $this->shipfee1->SetValue($this->ds->shipfee1->GetValue());
                        $this->ship2->SetValue($this->ds->ship2->GetValue());
                        $this->shipfee2->SetValue($this->ds->shipfee2->GetValue());
                        $this->ship3->SetValue($this->ds->ship3->GetValue());
                        $this->shipfee3->SetValue($this->ds->shipfee3->GetValue());
                        $this->ship4->SetValue($this->ds->ship4->GetValue());
                        $this->shipfee4->SetValue($this->ds->shipfee4->GetValue());
                        $this->ship5->SetValue($this->ds->ship5->GetValue());
                        $this->shipfee5->SetValue($this->ds->shipfee5->GetValue());
                        $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                        $this->make_offer->SetValue($this->ds->make_offer->GetValue());
                        $this->description->SetValue($this->ds->description->GetValue());
                        $this->image_preview->SetValue($this->ds->image_preview->GetValue());
                        $this->slide_show->SetValue($this->ds->slide_show->GetValue());
                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                        $this->state_province->SetValue($this->ds->state_province->GetValue());
				$this->country->SetValue($this->ds->country->GetValue());
				        if ($valid){
				        $this->fakeuser->SetValue($this->ds->fakeuser->GetValue());
				        $this->startnow->SetValue($this->ds->startnow->GetValue());
				        $this->addtime->SetValue($this->ds->addtime->GetValue());
				        }
                        $this->close->SetValue($this->ds->close->GetValue());
                        $this->closes->SetValue($this->ds->closes->GetValue());
                        $this->started->SetValue($this->ds->started->GetValue());
				$this->home_featured->SetValue($this->ds->home_featured->GetValue());
                        $this->gallery_featured->SetValue($this->ds->gallery_featured->GetValue());
                        $this->cat_featured->SetValue($this->ds->cat_featured->GetValue());
                        $this->bold->SetValue($this->ds->bold->GetValue());
                        $this->background->SetValue($this->ds->background->GetValue());
                        $this->counter->SetValue($this->ds->counter->GetValue());
                        $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->status->SetValue($this->ds->status->GetValue());
                        $this->image_five->SetValue($this->ds->image_five->GetValue());
                        $this->image_four->SetValue($this->ds->image_four->GetValue());
                        $this->image_three->SetValue($this->ds->image_three->GetValue());
                        $this->image_two->SetValue($this->ds->image_two->GetValue());
                        $this->image_one->SetValue($this->ds->image_one->GetValue());
                        $catname = new clsDBNetConnect;
                        $catname->query("select name from categories where cat_id = '" . $_REQUEST["finalcat"] . "'");
                        if ($catname->next_record())
                            $Tpl->setVar("cat_name", $catname->f("name"));

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
            $Error .= $this->category->Errors->ToString();
            $Error .= $this->title->Errors->ToString();
            $Error .= $this->item_paypal->Errors->ToString();
            $Error .= $this->quantity->Errors->ToString();
            $Error .= $this->ship1->Errors->ToString();
            $Error .= $this->shipfee1->Errors->ToString();
            $Error .= $this->ship2->Errors->ToString();
            $Error .= $this->shipfee2->Errors->ToString();
            $Error .= $this->ship3->Errors->ToString();
            $Error .= $this->shipfee3->Errors->ToString();
            $Error .= $this->ship4->Errors->ToString();
            $Error .= $this->shipfee4->Errors->ToString();
            $Error .= $this->ship5->Errors->ToString();
            $Error .= $this->shipfee5->Errors->ToString();
            $Error .= $this->asking_price->Errors->ToString();
            $Error .= $this->make_offer->Errors->ToString();
            $Error .= $this->description->Errors->ToString();
            $Error .= $this->image_preview->Errors->ToString();
            $Error .= $this->slide_show->Errors->ToString();
            $Error .= $this->city_town->Errors->ToString();
            $Error .= $this->state_province->Errors->ToString();
		$Error .= $this->country->Errors->ToString();
		    if ($valid){
		    $Error .= $this->fakeuser->Errors->ToString();
		    $Error .= $this->startnow->Errors->ToString();
		    $Error .= $this->addtime->Errors->ToString();
		    }
            $Error .= $this->close->Errors->ToString();
            $Error .= $this->home_featured->Errors->ToString();
            $Error .= $this->gallery_featured->Errors->ToString();
            $Error .= $this->cat_featured->Errors->ToString();
            $Error .= $this->bold->Errors->ToString();
            $Error .= $this->background->Errors->ToString();
            $Error .= $this->counter->Errors->ToString();
            $Error .= $this->ItemNum->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->status->Errors->ToString();
            $Error .= $this->image_five->Errors->ToString();
            $Error .= $this->image_four->Errors->ToString();
            $Error .= $this->image_three->Errors->ToString();
            $Error .= $this->image_two->Errors->ToString();
            $Error .= $this->image_one->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $db = new clsDBNetConnect;
        $query = "select `ItemNum` from `items` where `ItemNum` = '" . $this->ds->ItemNum->GetValue() . "'";
        $db->query($query);
        if ($db->next_record()){
        	$this->Update->Visible = 1;
        	$this->Insert->Visible = 0;
        }
        else{
        	$this->Insert->Visible = 1;
        	$this->Update->Visible = 0;
        }
        $this->Preview->Visible = 1;

        $this->title->Show();
        $this->item_paypal->Show();
        $this->quantity->Show();
        $this->ship1->Show();
        $this->shipfee1->Show();
        $this->ship2->Show();
        $this->shipfee2->Show();
        $this->ship3->Show();
        $this->shipfee3->Show();
        $this->ship4->Show();
        $this->shipfee4->Show();
		$this->ship5->Show();
        $this->shipfee5->Show();
        $this->asking_price->Show();
        $this->make_offer->Show();
        $this->description->Show();
        $this->image_preview->Show();
        $this->slide_show->Show();
        $this->city_town->Show();
        $this->state_province->Show();
	  $this->country->Show();
	    if ($valid) {
	    	$Tpl->SetBlockVar("admin", "");
	    	$this->fakeuser->Show();
	    	$this->startnow->Show();
	    	$this->addtime->Show();
	    	$Tpl->setVar("adminkey", $valid);
			$Tpl->parse("admin", "");
		}
        $this->close->Show();
        $this->closes->Show();
	  $this->started->Show();
        $this->home_featured->Show();
        $this->gallery_featured->Show();
        $this->cat_featured->Show();
        $this->bold->Show();
        $this->background->Show();
        $this->counter->Show();
        $this->ItemNum->Show();
        $this->user_id->Show();
        $this->status->Show();
        $this->image_five->Show();
        $this->image_four->Show();
        $this->image_three->Show();
        $this->image_two->Show();
        $this->image_one->Show();
        $db = new clsDBNetConnect();
        $db->query("select name from categories where cat_id = '" . $finalcat . "'");
        $db->next_record();
        $Tpl->SetVar("cat_name",$db->f("name"));
        $this->Update->Show();
        $this->Insert->Show();
        $this->Preview->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items Class @4-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @4-585CFEF7

//Variables @4-8C128320
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $category;
    var $title;
    var $item_paypal;
    var $quantity;
    var $ship1;
    var $shipfee1;
    var $ship2;
    var $shipfee2;
    var $ship3;
    var $shipfee3;
    var $ship4;
    var $shipfee4;
    var $ship5;
    var $shipfee5;
    var $asking_price;
    var $make_offer;
    var $description;
    var $image_preview;
    var $slide_show;
    var $city_town;
    var $state_province;
    var $country;
    var $fakeuser;
    var $close;
    var $closes;
    var $started;
    var $home_featured;
    var $gallery_featured;
    var $cat_featured;
    var $bold;
    var $background;
    var $counter;
    var $ItemNum;
    var $user_id;
    var $status;
    var $image_five;
    var $image_four;
    var $image_three;
    var $image_two;
    var $image_one;
//End Variables

//Class_Initialize Event @4-AAAC0E7E
    function clsitemsDataSource()
    {
    	global $valid;
        $this->Initialize();
        $this->category = new clsField("category", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->item_paypal = new clsField("item_paypal", ccsText, "");
        $this->quantity = new clsField("quantity", ccsInteger, "");
        $this->ship1 = new clsField("ship1", ccsText, "");
        $this->shipfee1 = new clsField("shipfee1", ccsFloat, "");
        $this->ship2 = new clsField("ship2", ccsText, "");
        $this->shipfee2 = new clsField("shipfee2", ccsFloat, "");
        $this->ship3 = new clsField("ship3", ccsText, "");
        $this->shipfee3 = new clsField("shipfee3", ccsFloat, "");
        $this->ship4 = new clsField("ship4", ccsText, "");
        $this->shipfee4 = new clsField("shipfee4", ccsFloat, "");
        $this->ship5 = new clsField("ship5", ccsText, "");
        $this->shipfee5 = new clsField("shipfee5", ccsFloat, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->make_offer = new clsField("make_offer", ccsInteger, "");
        $this->description = new clsField("description", ccsMemo, "");
        $this->image_preview = new clsField("image_preview", ccsInteger, "");
        $this->slide_show = new clsField("slide_show", ccsInteger, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state_province = new clsField("state_province", ccsText, "");
	  $this->country = new clsField("country", ccsInteger, "");
	    if ($valid){
		$this->fakeuser = new clsField("fakeuser", ccsInteger, "");
		$this->startnow = new clsField("startnow", ccsInteger, "");
		$this->addtime = new clsField("addtime", ccsInteger, "");
		}
        $this->close = new clsField("close", ccsInteger, "");
        $this->closes = new clsField("closes", ccsInteger, "");
	  $this->started = new clsField("started", ccsInteger, "");
        $this->home_featured = new clsField("home_featured", ccsInteger, "");
        $this->gallery_featured = new clsField("gallery_featured", ccsInteger, "");
        $this->cat_featured = new clsField("cat_featured", ccsInteger, "");
        $this->bold = new clsField("bold", ccsInteger, "");
        $this->background = new clsField("background", ccsInteger, "");
        $this->counter = new clsField("counter", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->status = new clsField("status", ccsInteger, "");
        $this->image_five = new clsField("image_five", ccsText, "");
        $this->image_four = new clsField("image_four", ccsText, "");
        $this->image_three = new clsField("image_three", ccsText, "");
        $this->image_two = new clsField("image_two", ccsText, "");
        $this->image_one = new clsField("image_one", ccsText, "");

    }
//End Class_Initialize Event

//Prepare Method @4-1889F58B
    function Prepare()
    {
    	global $valid;
    	if (!$valid){
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItem_Number", ccsInteger, "", "", $this->Parameters["urlItem_Number"], "");
        $this->wp->AddParameter("3", "sesUserID", ccsInteger, "", "", $this->Parameters["sesUserID"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ItemNum", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->Criterion[2] = "(status='0' OR status='2')";
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "user_id", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]);
        $this->Where = $this->wp->AssembledWhere;
       }
       else {
       	$this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItem_Number", ccsInteger, "", "", $this->Parameters["urlItem_Number"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "ItemNum", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
       }
	  //print $this->Where;
    }
//End Prepare Method

//Open Method @4-2B286CE7
    function Open()
    {
    	$table = "items";
    	if (CCGetSession("RecentPreviewItem"))
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

//SetValues Method @4-395104C4
    function SetValues()
    {
    	global $valid;
        $this->category->SetDBValue($this->f("category"));
        $this->title->SetDBValue($this->f("title"));
        $this->item_paypal->SetDBValue($this->f("item_paypal"));
        $this->quantity->SetDBValue($this->f("quantity"));
        $this->ship1->SetDBValue($this->f("ship1"));
        $this->shipfee1->SetDBValue($this->f("shipfee1"));
        $this->ship2->SetDBValue($this->f("ship2"));
        $this->shipfee2->SetDBValue($this->f("shipfee2"));
        $this->ship3->SetDBValue($this->f("ship3"));
        $this->shipfee3->SetDBValue($this->f("shipfee3"));
        $this->ship4->SetDBValue($this->f("ship4"));
        $this->shipfee4->SetDBValue($this->f("shipfee4"));
        $this->ship5->SetDBValue($this->f("ship5"));
        $this->shipfee5->SetDBValue($this->f("shipfee5"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->make_offer->SetDBValue($this->f("make_offer"));
        $this->description->SetDBValue($this->f("description"));
        $this->image_preview->SetDBValue($this->f("image_preview"));
        $this->slide_show->SetDBValue($this->f("slide_show"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state_province->SetDBValue($this->f("state_province"));
	  $this->country->SetDBValue($this->f("country"));
	    if ($valid)
	    $this->fakeuser->SetDBValue($this->f("user_id"));
        $this->close->SetDBValue($this->f("close"));
        $this->closes->SetDBValue($this->f("closes"));
	  $this->started->SetDBValue($this->f("started"));
        $this->home_featured->SetDBValue($this->f("home_featured"));
        $this->gallery_featured->SetDBValue($this->f("gallery_featured"));
        $this->cat_featured->SetDBValue($this->f("cat_featured"));
        $this->bold->SetDBValue($this->f("bold"));
        $this->background->SetDBValue($this->f("background"));
        $this->counter->SetDBValue($this->f("counter"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->status->SetDBValue($this->f("status"));
        $this->image_five->SetDBValue($this->f("image_five"));
        $this->image_four->SetDBValue($this->f("image_four"));
        $this->image_three->SetDBValue($this->f("image_three"));
        $this->image_two->SetDBValue($this->f("image_two"));
        $this->image_one->SetDBValue($this->f("image_one"));
    }
//End SetValues Method

//Delete Method @4-7645C25D
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM items WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

//Update Method @4-3F776267
    function Update()
    {
    	global $valid;
        global $closes;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $ItemNum = $this->ItemNum->DBValue;
        if (CCGetSession("RecentPreviewItem"))
        	$ItemNum = CCGetSession("RecentPreviewItem");
        if (!$valid){
        $SQL = "UPDATE items SET " .
            "category=" . $this->ToSQL($this->category->DBValue, $this->category->DataType) . ", " .
            "title=" . $this->ToSQL($this->title->DBValue, $this->title->DataType) . ", " .
            "item_paypal=" . $this->ToSQL($this->item_paypal->DBValue, $this->item_paypal->DataType) . ", " .
            "quantity=" . $this->ToSQL($this->quantity->DBValue, $this->quantity->DataType) . ", " .
            "ship1=" . $this->ToSQL($this->ship1->DBValue, $this->ship1->DataType) . ", " .
            "shipfee1=" . $this->ToSQL($this->shipfee1->DBValue, $this->shipfee1->DataType) . ", " .
            "ship2=" . $this->ToSQL($this->ship2->DBValue, $this->ship2->DataType) . ", " .
            "shipfee2=" . $this->ToSQL($this->shipfee2->DBValue, $this->shipfee2->DataType) . ", " .
            "ship3=" . $this->ToSQL($this->ship3->DBValue, $this->ship3->DataType) . ", " .
            "shipfee3=" . $this->ToSQL($this->shipfee3->DBValue, $this->shipfee3->DataType) . ", " .
            "ship4=" . $this->ToSQL($this->ship4->DBValue, $this->ship4->DataType) . ", " .
            "shipfee4=" . $this->ToSQL($this->shipfee4->DBValue, $this->shipfee4->DataType) . ", " .
            "ship5=" . $this->ToSQL($this->ship5->DBValue, $this->ship5->DataType) . ", " .
            "shipfee5=" . $this->ToSQL($this->shipfee5->DBValue, $this->shipfee5->DataType) . ", " .
            "asking_price=" . $this->ToSQL($this->asking_price->DBValue, $this->asking_price->DataType) . ", " .
            "make_offer=" . $this->ToSQL($this->make_offer->DBValue, $this->make_offer->DataType) . ", " .
            "description=" . $this->ToSQL($this->description->DBValue, $this->description->DataType) . ", " .
            "image_preview=" . $this->ToSQL($this->image_preview->DBValue, $this->image_preview->DataType) . ", " .
            "slide_show=" . $this->ToSQL($this->slide_show->DBValue, $this->slide_show->DataType) . ", " .
            "city_town=" . $this->ToSQL($this->city_town->DBValue, $this->city_town->DataType) . ", " .
            "state_province=" . $this->ToSQL($this->state_province->DBValue, $this->state_province->DataType) . ", " .
		"country=" . $this->ToSQL($this->country->DBValue, $this->country->DataType) . ", " .
            "close=" . $this->ToSQL($this->close->DBValue, $this->close->DataType) . ", " .
            "closes=" . $this->ToSQL($this->closes->DBValue, $this->closes->DataType) . ", " .
		"started=" . $this->ToSQL($this->started->DBValue, $this->started->DataType) . ", " .
            "end_reason='', " .
            "home_featured=" . $this->ToSQL($this->home_featured->DBValue, $this->home_featured->DataType) . ", " .
            "gallery_featured=" . $this->ToSQL($this->gallery_featured->DBValue, $this->gallery_featured->DataType) . ", " .
            "cat_featured=" . $this->ToSQL($this->cat_featured->DBValue, $this->cat_featured->DataType) . ", " .
            "bold=" . $this->ToSQL($this->bold->DBValue, $this->bold->DataType) . ", " .
            "background=" . $this->ToSQL($this->background->DBValue, $this->background->DataType) . ", " .
            "counter=" . $this->ToSQL($this->counter->DBValue, $this->counter->DataType) . ", " .
            "ItemNum=" . $this->ToSQL($this->ItemNum->DBValue, $this->ItemNum->DataType) . ", " .
            "user_id=" . $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            "status=" . $this->ToSQL($this->status->DBValue, $this->status->DataType) . ", " .
            "image_five=" . $this->ToSQL($this->image_five->DBValue, $this->image_five->DataType) . ", " .
            "image_four=" . $this->ToSQL($this->image_four->DBValue, $this->image_four->DataType) . ", " .
            "image_three=" . $this->ToSQL($this->image_three->DBValue, $this->image_three->DataType) . ", " .
            "image_two=" . $this->ToSQL($this->image_two->DBValue, $this->image_two->DataType) . ", " .
            "image_one=" . $this->ToSQL($this->image_one->DBValue, $this->image_one->DataType) .
            " WHERE " . $this->Where;
        }else{
        	$days = new clsDBNetConnect;
       		$days->query("select * from lookup_listing_dates where date_id = '" . $this->close->DBValue . "'");
       		$closes = $this->closes->GetValue();
       		if ($days->next_record()){
	       		if ($this->addtime->DBValue == 1){
	       			if ($closes > time())
	       				$closes = ($closes+(86400*$days->f("days")));
					else
	       				$closes = (time()+(86400*$days->f("days")));
    	   		}
       		}
       		$start = 0;
       		if ($this->startnow->DBValue == 1){
	       		$start = 1;
	       	}
        	$SQL = "UPDATE items SET " .
            "category=" . $this->ToSQL($this->category->DBValue, $this->category->DataType) . ", " .
            "title=" . $this->ToSQL($this->title->DBValue, $this->title->DataType) . ", " .
            "item_paypal=" . $this->ToSQL($this->item_paypal->DBValue, $this->item_paypal->DataType) . ", " .
            "quantity=" . $this->ToSQL($this->quantity->DBValue, $this->quantity->DataType) . ", " .
            "ship1=" . $this->ToSQL($this->ship1->DBValue, $this->ship1->DataType) . ", " .
            "shipfee1=" . $this->ToSQL($this->shipfee1->DBValue, $this->shipfee1->DataType) . ", " .
            "ship2=" . $this->ToSQL($this->ship2->DBValue, $this->ship2->DataType) . ", " .
            "shipfee2=" . $this->ToSQL($this->shipfee2->DBValue, $this->shipfee2->DataType) . ", " .
            "ship3=" . $this->ToSQL($this->ship3->DBValue, $this->ship3->DataType) . ", " .
            "shipfee3=" . $this->ToSQL($this->shipfee3->DBValue, $this->shipfee3->DataType) . ", " .
            "ship4=" . $this->ToSQL($this->ship4->DBValue, $this->ship4->DataType) . ", " .
            "shipfee4=" . $this->ToSQL($this->shipfee4->DBValue, $this->shipfee4->DataType) . ", " .
            "ship5=" . $this->ToSQL($this->ship5->DBValue, $this->ship5->DataType) . ", " .
            "shipfee5=" . $this->ToSQL($this->shipfee5->DBValue, $this->shipfee5->DataType) . ", " .
            "asking_price=" . $this->ToSQL($this->asking_price->DBValue, $this->asking_price->DataType) . ", " .
            "make_offer=" . $this->ToSQL($this->make_offer->DBValue, $this->make_offer->DataType) . ", " .
            "description=" . $this->ToSQL($this->description->DBValue, $this->description->DataType) . ", " .
            "image_preview=" . $this->ToSQL($this->image_preview->DBValue, $this->image_preview->DataType) . ", " .
            "slide_show=" . $this->ToSQL($this->slide_show->DBValue, $this->slide_show->DataType) . ", " .
            "city_town=" . $this->ToSQL($this->city_town->DBValue, $this->city_town->DataType) . ", " .
            "state_province=" . $this->ToSQL($this->state_province->DBValue, $this->state_province->DataType) . ", " .
		"country=" . $this->ToSQL($this->country->DBValue, $this->country->DataType) . ", " .
            "close=" . $this->ToSQL($this->close->DBValue, $this->close->DataType) . ", " .
            "closes=" . $this->ToSQL($closes, $this->closes->DataType) . ", " .
		"started=" . $this->ToSQL($this->started->DBValue, $this->started->DataType) . ", " .
            "end_reason='', " .
            "home_featured=" . $this->ToSQL($this->home_featured->DBValue, $this->home_featured->DataType) . ", " .
            "gallery_featured=" . $this->ToSQL($this->gallery_featured->DBValue, $this->gallery_featured->DataType) . ", " .
            "cat_featured=" . $this->ToSQL($this->cat_featured->DBValue, $this->cat_featured->DataType) . ", " .
            "bold=" . $this->ToSQL($this->bold->DBValue, $this->bold->DataType) . ", " .
            "background=" . $this->ToSQL($this->background->DBValue, $this->background->DataType) . ", " .
            "counter=" . $this->ToSQL($this->counter->DBValue, $this->counter->DataType) . ", " .
            "ItemNum=" . $this->ToSQL($this->ItemNum->DBValue, $this->ItemNum->DataType) . ", " .
            "user_id=" . $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            "status=" . $this->ToSQL($start, $this->status->DataType) . ", " .
            "image_five=" . $this->ToSQL($this->image_five->DBValue, $this->image_five->DataType) . ", " .
            "image_four=" . $this->ToSQL($this->image_four->DBValue, $this->image_four->DataType) . ", " .
            "image_three=" . $this->ToSQL($this->image_three->DBValue, $this->image_three->DataType) . ", " .
            "image_two=" . $this->ToSQL($this->image_two->DBValue, $this->image_two->DataType) . ", " .
            "image_one=" . $this->ToSQL($this->image_one->DBValue, $this->image_one->DataType) .
            " WHERE " . $this->Where;
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
            
////////////////////////////////////
//Enter/Update custom fields into the DB
////////////////////////////////////

		Global $_POST;

//Text Area Values
		$values = "";
        if(stristr(implode(",", array_keys($_POST)), "custtxt_area")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custtxt_area"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "select * from custom_textarea_values where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$db->query($query);
			if (!$db->next_record())
			    $query = "insert into custom_textarea_values(`field_id`, `ItemNum`, `value`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			else
				$query = "update custom_textarea_values set `value` = '" . mysql_escape_string($_POST[$values[$i]]) . "' where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$i++;
			$db->query($query);
		}

//Text Box Values
		$values = "";
		reset($_POST);
		if(stristr(implode(",", array_keys($_POST)), "custtxt_box")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custtxt_box"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "select * from custom_textbox_values where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$db->query($query);
			if (!$db->next_record())
			    $query = "insert into custom_textbox_values(`field_id`, `ItemNum`, `value`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			else
				$query = "update custom_textbox_values set `value` = '" . mysql_escape_string($_POST[$values[$i]]) . "' where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$i++;
			$db->query($query);
		}

//Dropdown Box Values
		$values = "";
		reset($_POST);
		if(stristr(implode(",", array_keys($_POST)), "custddbox")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custddbox"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "select * from custom_dropdown_values where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$db->query($query);
			if (!$db->next_record())
			    $query = "insert into custom_dropdown_values(`field_id`, `ItemNum`, `option_id`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			else
				$query = "update custom_dropdown_values set `option_id` = '" . mysql_escape_string($_POST[$values[$i]]) . "' where `field_id` = '" . end(explode("::", $values[$i])) . "' and `ItemNum` = '" . $this->ItemNum->DBValue . "'";
			$i++;
			$db->query($query);
		}
		
		if ($valid && $start == 1) {
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
        }

    }
//End Update Method

//Insert Method @4-A69F3FEA
    function Insert()
    {
		global $valid;
		if (strlen(CCGetParam("Preview", "")))
			$table = "items_preview";
		else 
			$table = "items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
        $ItemNum = $this->ItemNum->DBValue;
        if (!$valid){
        $SQL = "INSERT INTO $table(" .
            "category, " .
            "title, " .
            "item_paypal, " .
            "quantity, " .
            "ship1, " .
            "shipfee1, " .
            "ship2, " .
            "shipfee2, " .
            "ship3, " .
            "shipfee3, " .
            "ship4, " .
            "shipfee4, " .
            "ship5, " .
            "shipfee5, " .
            "asking_price, " .
            "make_offer, " .
            "description, " .
            "image_preview, " .
            "slide_show, " .
            "city_town, " .
            "state_province, " .
		"country, " .
            "close, " .
            "closes, " .
		"started, " .
            "home_featured, " .
            "gallery_featured, " .
            "cat_featured, " .
            "bold, " .
            "background, " .
            "counter, " .
            "ItemNum, " .
            "user_id, " .
            "status, " .
            "image_five, " .
            "image_four, " .
            "image_three, " .
            "image_two, " .
            "image_one" .
        ") VALUES (" .
            $this->ToSQL($this->category->DBValue, $this->category->DataType) . ", " .
            $this->ToSQL($this->title->DBValue, $this->title->DataType) . ", " .
            $this->ToSQL($this->item_paypal->DBValue, $this->item_paypal->DataType) . ", " .
            $this->ToSQL($this->quantity->DBValue, $this->quantity->DataType) . ", " .
            $this->ToSQL($this->ship1->DBValue, $this->ship1->DataType) . ", " .
            $this->ToSQL($this->shipfee1->DBValue, $this->shipfee1->DataType) . ", " .
            $this->ToSQL($this->ship2->DBValue, $this->ship2->DataType) . ", " .
            $this->ToSQL($this->shipfee2->DBValue, $this->shipfee2->DataType) . ", " .
            $this->ToSQL($this->ship3->DBValue, $this->ship3->DataType) . ", " .
            $this->ToSQL($this->shipfee3->DBValue, $this->shipfee3->DataType) . ", " .
            $this->ToSQL($this->ship4->DBValue, $this->ship4->DataType) . ", " .
            $this->ToSQL($this->shipfee4->DBValue, $this->shipfee4->DataType) . ", " .
            $this->ToSQL($this->ship5->DBValue, $this->ship5->DataType) . ", " .
            $this->ToSQL($this->shipfee5->DBValue, $this->shipfee5->DataType) . ", " .
            $this->ToSQL($this->asking_price->DBValue, $this->asking_price->DataType) . ", " .
            $this->ToSQL($this->make_offer->DBValue, $this->make_offer->DataType) . ", " .
            $this->ToSQL($this->description->DBValue, $this->description->DataType) . ", " .
            $this->ToSQL($this->image_preview->DBValue, $this->image_preview->DataType) . ", " .
            $this->ToSQL($this->slide_show->DBValue, $this->slide_show->DataType) . ", " .
            $this->ToSQL($this->city_town->DBValue, $this->city_town->DataType) . ", " .
            $this->ToSQL($this->state_province->DBValue, $this->state_province->DataType) . ", " .
		$this->ToSQL($this->country->DBValue, $this->country->DataType) . ", " .
            $this->ToSQL($this->close->DBValue, $this->close->DataType) . ", " .
            $this->ToSQL($this->closes->DBValue, $this->closes->DataType) . ", " .
            $this->ToSQL($this->started->DBValue, $this->started->DataType) . ", " .
            $this->ToSQL($this->home_featured->DBValue, $this->home_featured->DataType) . ", " .
            $this->ToSQL($this->gallery_featured->DBValue, $this->gallery_featured->DataType) . ", " .
            $this->ToSQL($this->cat_featured->DBValue, $this->cat_featured->DataType) . ", " .
            $this->ToSQL($this->bold->DBValue, $this->bold->DataType) . ", " .
            $this->ToSQL($this->background->DBValue, $this->background->DataType) . ", " .
            $this->ToSQL($this->counter->DBValue, $this->counter->DataType) . ", " .
            $this->ToSQL($this->ItemNum->DBValue, $this->ItemNum->DataType) . ", " .
            $this->ToSQL($this->user_id->DBValue, $this->user_id->DataType) . ", " .
            $this->ToSQL($this->status->DBValue, $this->status->DataType) . ", " .
            $this->ToSQL($this->image_five->DBValue, $this->image_five->DataType) . ", " .
            $this->ToSQL($this->image_four->DBValue, $this->image_four->DataType) . ", " .
            $this->ToSQL($this->image_three->DBValue, $this->image_three->DataType) . ", " .
            $this->ToSQL($this->image_two->DBValue, $this->image_two->DataType) . ", " .
            $this->ToSQL($this->image_one->DBValue, $this->image_one->DataType) .
        ")";
       } else {
       	$days = new clsDBNetConnect;
       	$days->query("select * from lookup_listing_dates where date_id = '" . $this->close->DBValue . "'");
       	$closes = time();
       	if ($days->next_record()){
       		if ($this->addtime->DBValue == 1){
       			$closes = (time()+(86400*$days->f("days")));
       		}
       	}
       	$start = 0;
       	if ($this->startnow->DBValue == 1){
       		$start = 1;
       		add_catcounts($this->category->DBValue);
       	}
       	$SQL = "INSERT INTO $table(" .
            "category, " .
            "title, " .
            "item_paypal, " .
            "quantity, " .
            "ship1, " .
            "shipfee1, " .
            "ship2, " .
            "shipfee2, " .
            "ship3, " .
            "shipfee3, " .
            "ship4, " .
            "shipfee4, " .
            "ship5, " .
            "shipfee5, " .
            "asking_price, " .
            "make_offer, " .
            "description, " .
            "image_preview, " .
            "slide_show, " .
            "city_town, " .
            "state_province, " .
		"country, " .
            "close, " .
            "closes, " .
		"started, " .
            "home_featured, " .
            "gallery_featured, " .
            "cat_featured, " .
            "bold, " .
            "background, " .
            "counter, " .
            "ItemNum, " .
            "user_id, " .
            "status, " .
            "image_five, " .
            "image_four, " .
            "image_three, " .
            "image_two, " .
            "image_one" .
        ") VALUES (" .
            $this->ToSQL($this->category->DBValue, $this->category->DataType) . ", " .
            $this->ToSQL($this->title->DBValue, $this->title->DataType) . ", " .
            $this->ToSQL($this->item_paypal->DBValue, $this->item_paypal->DataType) . ", " .
            $this->ToSQL($this->quantity->DBValue, $this->quantity->DataType) . ", " .
            $this->ToSQL($this->ship1->DBValue, $this->ship1->DataType) . ", " .
            $this->ToSQL($this->shipfee1->DBValue, $this->shipfee1->DataType) . ", " .
            $this->ToSQL($this->ship2->DBValue, $this->ship2->DataType) . ", " .
            $this->ToSQL($this->shipfee2->DBValue, $this->shipfee2->DataType) . ", " .
            $this->ToSQL($this->ship3->DBValue, $this->ship3->DataType) . ", " .
            $this->ToSQL($this->shipfee3->DBValue, $this->shipfee3->DataType) . ", " .
            $this->ToSQL($this->ship4->DBValue, $this->ship4->DataType) . ", " .
            $this->ToSQL($this->shipfee4->DBValue, $this->shipfee4->DataType) . ", " .
            $this->ToSQL($this->ship5->DBValue, $this->ship5->DataType) . ", " .
            $this->ToSQL($this->shipfee5->DBValue, $this->shipfee5->DataType) . ", " .
            $this->ToSQL($this->asking_price->DBValue, $this->asking_price->DataType) . ", " .
            $this->ToSQL($this->make_offer->DBValue, $this->make_offer->DataType) . ", " .
            $this->ToSQL($this->description->DBValue, $this->description->DataType) . ", " .
            $this->ToSQL($this->image_preview->DBValue, $this->image_preview->DataType) . ", " .
            $this->ToSQL($this->slide_show->DBValue, $this->slide_show->DataType) . ", " .
            $this->ToSQL($this->city_town->DBValue, $this->city_town->DataType) . ", " .
            $this->ToSQL($this->state_province->DBValue, $this->state_province->DataType) . ", " .
		$this->ToSQL($this->country->DBValue, $this->country->DataType) . ", " .
            $this->ToSQL($this->close->DBValue, $this->close->DataType) . ", " .
            $this->ToSQL($closes, $this->closes->DataType) . ", " .
            $this->ToSQL($this->started->DBValue, $this->started->DataType) . ", " .
            $this->ToSQL($this->home_featured->DBValue, $this->home_featured->DataType) . ", " .
            $this->ToSQL($this->gallery_featured->DBValue, $this->gallery_featured->DataType) . ", " .
            $this->ToSQL($this->cat_featured->DBValue, $this->cat_featured->DataType) . ", " .
            $this->ToSQL($this->bold->DBValue, $this->bold->DataType) . ", " .
            $this->ToSQL($this->background->DBValue, $this->background->DataType) . ", " .
            $this->ToSQL($this->counter->DBValue, $this->counter->DataType) . ", " .
            $this->ToSQL($this->ItemNum->DBValue, $this->ItemNum->DataType) . ", " .
            $this->ToSQL($this->fakeuser->DBValue, $this->fakeuser->DataType) . ", " .
            $this->ToSQL($start, $this->status->DataType) . ", " .
            $this->ToSQL($this->image_five->DBValue, $this->image_five->DataType) . ", " .
            $this->ToSQL($this->image_four->DBValue, $this->image_four->DataType) . ", " .
            $this->ToSQL($this->image_three->DBValue, $this->image_three->DataType) . ", " .
            $this->ToSQL($this->image_two->DBValue, $this->image_two->DataType) . ", " .
            $this->ToSQL($this->image_one->DBValue, $this->image_one->DataType) .
        ")";
        
       }
       //print $SQL;
       //exit;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());

////////////////////////////////////
//Enter custom fields into the DB
////////////////////////////////////

		Global $_POST;

//Text Area Values
		reset($_POST);
		$values = "";
        if(stristr(implode(",", array_keys($_POST)), "custtxt_area")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custtxt_area"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "insert into custom_textarea_values(`field_id`, `ItemNum`, `value`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			$i++;
			$db->query($query);
		}
		
//Text Box Values
		reset($_POST);
		$values = "";
		if(stristr(implode(",", array_keys($_POST)), "custtxt_box")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custtxt_box"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "insert into custom_textbox_values(`field_id`, `ItemNum`, `value`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			$i++;
			$db->query($query);
		}

//Dropdown Box Values
		reset($_POST);
		$values = "";
		if(stristr(implode(",", array_keys($_POST)), "custddbox")){
			while (list ($key, $val) = each ($_POST)) {
   				if (stristr($key, "custddbox"))
					$values[] = $key;
			}
		}
		$db = new clsDBNetConnect;
		$i = 0;
		while ($values[$i]) {
			$query = "insert into custom_dropdown_values(`field_id`, `ItemNum`, `option_id`) values ('" . end(explode("::", $values[$i])) . "', '" . $this->ItemNum->DBValue . "', '" . mysql_escape_string($_POST[$values[$i]]) . "')";
			$i++;
			$db->query($query);
		}
		
		if ($valid && $start == 1) {
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
        	add_catcounts($this->category->DBValue);
        }

    }
//End Insert Method

} //End itemsDataSource Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-712050C3
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
else
$file = GetNewItemTemlate($catID);
$FileName = "newitem.php";
$Redirect = "";
$TemplateFileName = $file;
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
global $valid;
if (!$valid)
CCSecurityRedirect("1;2", "login.php", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-000973AD

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$items = new clsRecorditems();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$items->Initialize();

// Events
include("./newitem_events.php");
BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-249DA85C
$Header->Operations();
$items->Operation();
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

//Show Page @1-F9F38336
$Header->Show("Header");
$items->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page
if ($file != "templates/newitem.html")
unlink($file);
//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
if (CCGetSession("RecentPreviewItem")){
	$db = new clsDBNetConnect;
	$db->query("delete from `custom_textarea_values` where `ItemNum` = '" . CCGetSession("RecentPreviewItem") . "'");
	$db->query("delete from `custom_textbox_values` where `ItemNum` = '" . CCGetSession("RecentPreviewItem") . "'");
	$db->query("delete from `custom_dropdown_values` where `ItemNum` = '" . CCGetSession("RecentPreviewItem") . "'");
	$db->query("delete from `items_preview` where `ItemNum` = '" . CCGetSession("RecentPreviewItem") . "'");
	CCSetSession("RecentPreviewItem", "");
	unset($db);
}
//End Unload Page

?>