<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @36-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecorditems1 { //items1 Class @54-E01CD9C3

//Variables @54-440298FB

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

    var $UpdateAllowed;
    var $DeleteAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @54-B4E77F81
    function clsRecorditems1()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clsitems1DataSource();
        $this->UpdateAllowed = true;
        $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "items1";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ItemNumLabel = new clsControl(ccsLabel, "ItemNumLabel", "ItemNumLabel", ccsInteger, "", CCGetRequestParam("ItemNumLabel", $Method));
            $this->UserIDLabel = new clsControl(ccsLabel, "UserIDLabel", "UserIDLabel", ccsText, "", CCGetRequestParam("UserIDLabel", $Method));
            $this->StartedLabel = new clsControl(ccsLabel, "StartedLabel", "StartedLabel", ccsText, "", CCGetRequestParam("StartedLabel", $Method));
            $this->ClosesLabel = new clsControl(ccsLabel, "ClosesLabel", "ClosesLabel", ccsText, "", CCGetRequestParam("ClosesLabel", $Method));
            $this->title = new clsControl(ccsTextBox, "title", "Title", ccsText, "", CCGetRequestParam("title", $Method));
            $this->status = new clsControl(ccsListBox, "status", "Status", ccsInteger, "", CCGetRequestParam("status", $Method));
            $this->status->DSType = dsListOfValues;
            $this->status->Values = array(array("0", "Not Started"), array("1", "Active Listing"), array("2", "Closed"));
            $this->end_reason = new clsControl(ccsTextBox, "end_reason", "End Reason", ccsText, "", CCGetRequestParam("end_reason", $Method));
            $this->category = new clsControl(ccsListBox, "category", "Category", ccsInteger, "", CCGetRequestParam("category", $Method));
            $this->category->DSType = dsTable;
            list($this->category->BoundColumn, $this->category->TextColumn) = array("cat_id", "name");
            $this->category->ds = new clsDBDBNetConnect();
            $this->category->ds->SQL = "SELECT *  " .
"FROM categories";
            $this->close = new clsControl(ccsListBox, "close", "Close", ccsInteger, "", CCGetRequestParam("close", $Method));
            $this->close->DSType = dsTable;
            list($this->close->BoundColumn, $this->close->TextColumn) = array("date_id", "days");
            $this->close->ds = new clsDBDBNetConnect();
            $this->close->ds->SQL = "SELECT *  " .
"FROM lookup_listing_dates";
            $this->asking_price = new clsControl(ccsTextBox, "asking_price", "Asking Price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", $Method));
            $this->make_offer = new clsControl(ccsCheckBox, "make_offer", "Make Offer", ccsInteger, "", CCGetRequestParam("make_offer", $Method));
            $this->make_offer->CheckedValue = 1;
            $this->make_offer->UncheckedValue = 0;
            $this->quantity = new clsControl(ccsTextBox, "quantity", "Quantity", ccsInteger, "", CCGetRequestParam("quantity", $Method));
            $this->city_town = new clsControl(ccsTextBox, "city_town", "City Town", ccsText, "", CCGetRequestParam("city_town", $Method));
            $this->state = new clsControl(ccsTextBox, "state", "State Province", ccsText, "", CCGetRequestParam("state", $Method));
            $this->country = new clsControl(ccsListBox, "country", "Country", ccsInteger, "", CCGetRequestParam("country", $Method));
            $this->country->DSType = dsTable;
            list($this->country->BoundColumn, $this->country->TextColumn) = array("country_id", "country_desc");
            $this->country->ds = new clsDBDBNetConnect();
            $this->country->ds->SQL = "SELECT *  " .
"FROM lookup_countries";
            $this->description = new clsControl(ccsTextArea, "description", "Description", ccsMemo, "", CCGetRequestParam("description", $Method));
            $this->dateadded = new clsControl(ccsTextBox, "dateadded", "Dateadded", ccsText, "", CCGetRequestParam("dateadded", $Method));
            $this->added_description = new clsControl(ccsTextArea, "added_description", "Added Description", ccsMemo, "", CCGetRequestParam("added_description", $Method));
            $this->image_one = new clsControl(ccsTextBox, "image_one", "Image One", ccsText, "", CCGetRequestParam("image_one", $Method));
            $this->image_two = new clsControl(ccsTextBox, "image_two", "Image Two", ccsText, "", CCGetRequestParam("image_two", $Method));
            $this->image_three = new clsControl(ccsTextBox, "image_three", "Image Three", ccsText, "", CCGetRequestParam("image_three", $Method));
            $this->image_four = new clsControl(ccsTextBox, "image_four", "Image Four", ccsText, "", CCGetRequestParam("image_four", $Method));
            $this->image_five = new clsControl(ccsTextBox, "image_five", "Image Five", ccsText, "", CCGetRequestParam("image_five", $Method));
            $this->bold = new clsControl(ccsCheckBox, "bold", "Bold", ccsInteger, "", CCGetRequestParam("bold", $Method));
            $this->bold->CheckedValue = 1;
            $this->bold->UncheckedValue = 0;
            $this->background = new clsControl(ccsCheckBox, "background", "Background", ccsInteger, "", CCGetRequestParam("background", $Method));
            $this->background->CheckedValue = 1;
            $this->background->UncheckedValue = 0;
            $this->cat_featured = new clsControl(ccsCheckBox, "cat_featured", "Cat Featured", ccsInteger, "", CCGetRequestParam("cat_featured", $Method));
            $this->cat_featured->CheckedValue = 1;
            $this->cat_featured->UncheckedValue = 0;
            $this->home_featured = new clsControl(ccsCheckBox, "home_featured", "Home Featured", ccsInteger, "", CCGetRequestParam("home_featured", $Method));
            $this->home_featured->CheckedValue = 1;
            $this->home_featured->UncheckedValue = 0;
            $this->gallery_featured = new clsControl(ccsCheckBox, "gallery_featured", "Gallery Featured", ccsInteger, "", CCGetRequestParam("gallery_featured", $Method));
            $this->gallery_featured->CheckedValue = 1;
            $this->gallery_featured->UncheckedValue = 0;
            $this->image_preview = new clsControl(ccsCheckBox, "image_preview", "Image Preview", ccsInteger, "", CCGetRequestParam("image_preview", $Method));
            $this->image_preview->CheckedValue = 1;
            $this->image_preview->UncheckedValue = 0;
            $this->slide_show = new clsControl(ccsCheckBox, "slide_show", "Slide Show", ccsInteger, "", CCGetRequestParam("slide_show", $Method));
            $this->slide_show->CheckedValue = 1;
            $this->slide_show->UncheckedValue = 0;
            $this->counter = new clsControl(ccsCheckBox, "counter", "Counter", ccsInteger, "", CCGetRequestParam("counter", $Method));
            $this->counter->CheckedValue = 1;
            $this->counter->UncheckedValue = 0;
            $this->hits = new clsControl(ccsTextBox, "hits", "Hits", ccsInteger, "", CCGetRequestParam("hits", $Method));
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->user_id = new clsControl(ccsHidden, "user_id", "User Id", ccsInteger, "", CCGetRequestParam("user_id", $Method));
            $this->started = new clsControl(ccsHidden, "started", "Started", ccsInteger, "", CCGetRequestParam("started", $Method));
            $this->closes = new clsControl(ccsHidden, "closes", "Closes", ccsInteger, "", CCGetRequestParam("closes", $Method));
            $this->ItemNum = new clsControl(ccsHidden, "ItemNum", "Item Number", ccsInteger, "", CCGetRequestParam("ItemNum", $Method));
            if(!$this->FormSubmitted) {
                if(!strlen($this->asking_price->Value) && $this->asking_price->Value !== false)
                    $this->asking_price->SetValue(0.00);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @54-BA324CC7
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlItemNum"] = CCGetFromGet("ItemNum", "");
    }
//End Initialize Method

//Validate Method @54-DDD50A69
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->ItemNumLabel->Validate() && $Validation);
        $Validation = ($this->UserIDLabel->Validate() && $Validation);
        $Validation = ($this->StartedLabel->Validate() && $Validation);
        $Validation = ($this->ClosesLabel->Validate() && $Validation);
        $Validation = ($this->title->Validate() && $Validation);
        $Validation = ($this->status->Validate() && $Validation);
        $Validation = ($this->end_reason->Validate() && $Validation);
        $Validation = ($this->category->Validate() && $Validation);
        $Validation = ($this->close->Validate() && $Validation);
        $Validation = ($this->asking_price->Validate() && $Validation);
        $Validation = ($this->make_offer->Validate() && $Validation);
        $Validation = ($this->quantity->Validate() && $Validation);
        $Validation = ($this->city_town->Validate() && $Validation);
        $Validation = ($this->state->Validate() && $Validation);
        $Validation = ($this->country->Validate() && $Validation);
        $Validation = ($this->description->Validate() && $Validation);
        $Validation = ($this->dateadded->Validate() && $Validation);
        $Validation = ($this->added_description->Validate() && $Validation);
        $Validation = ($this->image_one->Validate() && $Validation);
        $Validation = ($this->image_two->Validate() && $Validation);
        $Validation = ($this->image_three->Validate() && $Validation);
        $Validation = ($this->image_four->Validate() && $Validation);
        $Validation = ($this->image_five->Validate() && $Validation);
        $Validation = ($this->bold->Validate() && $Validation);
        $Validation = ($this->background->Validate() && $Validation);
        $Validation = ($this->cat_featured->Validate() && $Validation);
        $Validation = ($this->home_featured->Validate() && $Validation);
        $Validation = ($this->gallery_featured->Validate() && $Validation);
        $Validation = ($this->image_preview->Validate() && $Validation);
        $Validation = ($this->slide_show->Validate() && $Validation);
        $Validation = ($this->counter->Validate() && $Validation);
        $Validation = ($this->hits->Validate() && $Validation);
        $Validation = ($this->user_id->Validate() && $Validation);
        $Validation = ($this->started->Validate() && $Validation);
        $Validation = ($this->closes->Validate() && $Validation);
        $Validation = ($this->ItemNum->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @54-56F5E8DA
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!$this->FormSubmitted)
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Cancel";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Delete", ""))) {
                $this->PressedButton = "Delete";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "ItemsList.php";
        if($this->PressedButton == "Delete") {
            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                $Redirect = "";
            }
        } else if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//UpdateRow Method @54-48D76668
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        //$this->ds->ItemNumLabel->SetValue($this->ItemNumLabel->GetValue());
        //$this->ds->UserIDLabel->SetValue($this->UserIDLabel->GetValue());
        //$this->ds->StartedLabel->SetValue($this->StartedLabel->GetValue());
        //$this->ds->ClosesLabel->SetValue($this->ClosesLabel->GetValue());
        $this->ds->title->SetValue($this->title->GetValue());
        $this->ds->status->SetValue($this->status->GetValue());
        $this->ds->end_reason->SetValue($this->end_reason->GetValue());
        $this->ds->category->SetValue($this->category->GetValue());
        $this->ds->close->SetValue($this->close->GetValue());
        $this->ds->asking_price->SetValue($this->asking_price->GetValue());
        $this->ds->make_offer->SetValue($this->make_offer->GetValue());
        $this->ds->quantity->SetValue($this->quantity->GetValue());
        $this->ds->city_town->SetValue($this->city_town->GetValue());
        $this->ds->state->SetValue($this->state->GetValue());
        $this->ds->country->SetValue($this->country->GetValue());
        $this->ds->description->SetValue($this->description->GetValue());
        $this->ds->dateadded->SetValue($this->dateadded->GetValue());
        $this->ds->added_description->SetValue($this->added_description->GetValue());
        $this->ds->image_one->SetValue($this->image_one->GetValue());
        $this->ds->image_two->SetValue($this->image_two->GetValue());
        $this->ds->image_three->SetValue($this->image_three->GetValue());
        $this->ds->image_four->SetValue($this->image_four->GetValue());
        $this->ds->image_five->SetValue($this->image_five->GetValue());
        $this->ds->bold->SetValue($this->bold->GetValue());
        $this->ds->background->SetValue($this->background->GetValue());
        $this->ds->cat_featured->SetValue($this->cat_featured->GetValue());
        $this->ds->home_featured->SetValue($this->home_featured->GetValue());
        $this->ds->gallery_featured->SetValue($this->gallery_featured->GetValue());
        $this->ds->image_preview->SetValue($this->image_preview->GetValue());
        $this->ds->slide_show->SetValue($this->slide_show->GetValue());
        $this->ds->counter->SetValue($this->counter->GetValue());
        $this->ds->hits->SetValue($this->hits->GetValue());
        $this->ds->user_id->SetValue($this->user_id->GetValue());
        $this->ds->started->SetValue($this->started->GetValue());
        $this->ds->closes->SetValue($this->closes->GetValue());
        $ld = new clsDBDBNetConnect;
		$ld->connect();
		if($this->close->GetValue() != 979)
		{
			$thedays = CCDLookUp("days", "lookup_listing_dates", "date_id='" . $this->close->GetValue() . "'", $ld);
			$this->ds->closes->SetValue((86400 * $thedays) + time());
        }
		if($this->close->GetValue() == 979)
		{
			$this->ds->closes->SetValue($this->ds->closes->GetValue());
		}
		unset($ld);
		$this->ds->ItemNum->SetValue($this->ItemNum->GetValue());
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




//DeleteRow Method @54-6A43D177
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");
        if(!$this->DeleteAllowed) return false;
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

//Show Method @54-4ED498BC
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->status->Prepare();
        $this->category->Prepare();
        $this->close->Prepare();
        $this->country->Prepare();

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record items1";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    $this->ItemNumLabel->SetValue($this->ds->ItemNumLabel->GetValue());
                    $this->UserIDLabel->SetValue(GetUserNameID($this->ds->UserIDLabel->GetValue()));
                    $this->StartedLabel->SetValue(date("F j, Y, g:i a", $this->ds->StartedLabel->GetValue()));
                    $this->ClosesLabel->SetValue(date("F j, Y, g:i a", $this->ds->ClosesLabel->GetValue()));
                    if(!$this->FormSubmitted)
                    {
                        $this->title->SetValue($this->ds->title->GetValue());
                        $this->status->SetValue($this->ds->status->GetValue());
                        $this->end_reason->SetValue($this->ds->end_reason->GetValue());
                        $this->category->SetValue($this->ds->category->GetValue());
                        $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                        $this->make_offer->SetValue($this->ds->make_offer->GetValue());
                        $this->quantity->SetValue($this->ds->quantity->GetValue());
                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                        $this->state->SetValue($this->ds->state->GetValue());
                        $this->country->SetValue($this->ds->country->GetValue());
                        $this->description->SetValue($this->ds->description->GetValue());
                        $this->dateadded->SetValue($this->ds->dateadded->GetValue());
                        $this->added_description->SetValue($this->ds->added_description->GetValue());
                        $this->image_one->SetValue($this->ds->image_one->GetValue());
                        $this->image_two->SetValue($this->ds->image_two->GetValue());
                        $this->image_three->SetValue($this->ds->image_three->GetValue());
                        $this->image_four->SetValue($this->ds->image_four->GetValue());
                        $this->image_five->SetValue($this->ds->image_five->GetValue());
                        $this->bold->SetValue($this->ds->bold->GetValue());
                        $this->background->SetValue($this->ds->background->GetValue());
                        $this->cat_featured->SetValue($this->ds->cat_featured->GetValue());
                        $this->home_featured->SetValue($this->ds->home_featured->GetValue());
                        $this->gallery_featured->SetValue($this->ds->gallery_featured->GetValue());
                        $this->image_preview->SetValue($this->ds->image_preview->GetValue());
                        $this->slide_show->SetValue($this->ds->slide_show->GetValue());
                        $this->counter->SetValue($this->ds->counter->GetValue());
                        $this->hits->SetValue($this->ds->hits->GetValue());
                        $this->user_id->SetValue($this->ds->user_id->GetValue());
                        $this->started->SetValue($this->ds->started->GetValue());
                        $this->closes->SetValue($this->ds->closes->GetValue());
                        $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        if(!$this->FormSubmitted)
        {
        }

        if($this->FormSubmitted) {
            $Error .= $this->ItemNumLabel->Errors->ToString();
            $Error .= $this->UserIDLabel->Errors->ToString();
            $Error .= $this->StartedLabel->Errors->ToString();
            $Error .= $this->ClosesLabel->Errors->ToString();
            $Error .= $this->title->Errors->ToString();
            $Error .= $this->status->Errors->ToString();
            $Error .= $this->end_reason->Errors->ToString();
            $Error .= $this->category->Errors->ToString();
            $Error .= $this->close->Errors->ToString();
            $Error .= $this->asking_price->Errors->ToString();
            $Error .= $this->make_offer->Errors->ToString();
            $Error .= $this->quantity->Errors->ToString();
            $Error .= $this->city_town->Errors->ToString();
            $Error .= $this->state->Errors->ToString();
            $Error .= $this->country->Errors->ToString();
            $Error .= $this->description->Errors->ToString();
            $Error .= $this->dateadded->Errors->ToString();
            $Error .= $this->added_description->Errors->ToString();
            $Error .= $this->image_one->Errors->ToString();
            $Error .= $this->image_two->Errors->ToString();
            $Error .= $this->image_three->Errors->ToString();
            $Error .= $this->image_four->Errors->ToString();
            $Error .= $this->image_five->Errors->ToString();
            $Error .= $this->bold->Errors->ToString();
            $Error .= $this->background->Errors->ToString();
            $Error .= $this->cat_featured->Errors->ToString();
            $Error .= $this->home_featured->Errors->ToString();
            $Error .= $this->gallery_featured->Errors->ToString();
            $Error .= $this->image_preview->Errors->ToString();
            $Error .= $this->slide_show->Errors->ToString();
            $Error .= $this->counter->Errors->ToString();
            $Error .= $this->hits->Errors->ToString();
            $Error .= $this->user_id->Errors->ToString();
            $Error .= $this->started->Errors->ToString();
            $Error .= $this->closes->Errors->ToString();
            $Error .= $this->ItemNum->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->Delete->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->ItemNumLabel->Show();
        $this->UserIDLabel->Show();
        $this->StartedLabel->Show();
        $this->ClosesLabel->Show();
        $this->title->Show();
        $this->status->Show();
        $this->end_reason->Show();
        $this->category->Show();
        $this->close->Show();
        $this->asking_price->Show();
        $this->make_offer->Show();
        $this->quantity->Show();
        $this->city_town->Show();
        $this->state->Show();
        $this->country->Show();
        $this->description->Show();
        $this->dateadded->Show();
        $this->added_description->Show();
        $this->image_one->Show();
        $this->image_two->Show();
        $this->image_three->Show();
        $this->image_four->Show();
        $this->image_five->Show();
        $this->bold->Show();
        $this->background->Show();
        $this->cat_featured->Show();
        $this->home_featured->Show();
        $this->gallery_featured->Show();
        $this->image_preview->Show();
        $this->slide_show->Show();
        $this->counter->Show();
        $this->hits->Show();
        $this->Update->Show();
        $this->Delete->Show();
        $this->Cancel->Show();
        $this->user_id->Show();
        $this->started->Show();
        $this->closes->Show();
        $this->ItemNum->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method


} //End items1 Class @54-FCB6E20C

class clsitems1DataSource extends clsDBDBNetConnect {  //items1DataSource Class @54-4D848094

//DataSource Variables @54-BE0F656D
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $ItemNumLabel;
    var $UserIDLabel;
    var $StartedLabel;
    var $ClosesLabel;
    var $title;
    var $status;
    var $end_reason;
    var $category;
    var $close;
    var $asking_price;
    var $make_offer;
    var $quantity;
    var $city_town;
    var $state;
    var $country;
    var $description;
    var $dateadded;
    var $added_description;
    var $image_one;
    var $image_two;
    var $image_three;
    var $image_four;
    var $image_five;
    var $bold;
    var $background;
    var $cat_featured;
    var $home_featured;
    var $gallery_featured;
    var $image_preview;
    var $slide_show;
    var $counter;
    var $hits;
    var $user_id;
    var $started;
    var $closes;
    var $ItemNum;
//End DataSource Variables

//Class_Initialize Event @54-1CAADEE9
    function clsitems1DataSource()
    {
        $this->Initialize();
        $this->ItemNumLabel = new clsField("ItemNumLabel", ccsInteger, "");
        $this->UserIDLabel = new clsField("UserIDLabel", ccsText, "");
        $this->StartedLabel = new clsField("StartedLabel", ccsText, "");
        $this->ClosesLabel = new clsField("ClosesLabel", ccsText, "");
        $this->title = new clsField("title", ccsText, "");
        $this->status = new clsField("status", ccsInteger, "");
        $this->end_reason = new clsField("end_reason", ccsText, "");
        $this->category = new clsField("category", ccsInteger, "");
        $this->close = new clsField("close", ccsInteger, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->make_offer = new clsField("make_offer", ccsInteger, "");
        $this->quantity = new clsField("quantity", ccsInteger, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state = new clsField("state", ccsText, "");
        $this->country = new clsField("country", ccsInteger, "");
        $this->description = new clsField("description", ccsMemo, "");
        $this->dateadded = new clsField("dateadded", ccsText, "");
        $this->added_description = new clsField("added_description", ccsMemo, "");
        $this->image_one = new clsField("image_one", ccsText, "");
        $this->image_two = new clsField("image_two", ccsText, "");
        $this->image_three = new clsField("image_three", ccsText, "");
        $this->image_four = new clsField("image_four", ccsText, "");
        $this->image_five = new clsField("image_five", ccsText, "");
        $this->bold = new clsField("bold", ccsInteger, "");
        $this->background = new clsField("background", ccsInteger, "");
        $this->cat_featured = new clsField("cat_featured", ccsInteger, "");
        $this->home_featured = new clsField("home_featured", ccsInteger, "");
        $this->gallery_featured = new clsField("gallery_featured", ccsInteger, "");
        $this->image_preview = new clsField("image_preview", ccsInteger, "");
        $this->slide_show = new clsField("slide_show", ccsInteger, "");
        $this->counter = new clsField("counter", ccsInteger, "");
        $this->hits = new clsField("hits", ccsInteger, "");
        $this->user_id = new clsField("user_id", ccsInteger, "");
        $this->started = new clsField("started", ccsInteger, "");
        $this->closes = new clsField("closes", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @54-42B21BE4
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlItemNum", ccsInteger, "", "", $this->Parameters["urlItemNum"], "");
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`ItemNum`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @54-2B286CE7
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @54-91B31010
    function SetValues()
    {
        $this->ItemNumLabel->SetDBValue($this->f("ItemNum"));
        $this->UserIDLabel->SetDBValue($this->f("user_id"));
        $this->StartedLabel->SetDBValue($this->f("started"));
        $this->ClosesLabel->SetDBValue($this->f("closes"));
        $this->title->SetDBValue($this->f("title"));
        $this->status->SetDBValue($this->f("status"));
        $this->end_reason->SetDBValue($this->f("end_reason"));
        $this->category->SetDBValue($this->f("category"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->make_offer->SetDBValue($this->f("make_offer"));
        $this->quantity->SetDBValue($this->f("quantity"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state->SetDBValue($this->f("state_province"));
        $this->country->SetDBValue($this->f("country"));
        $this->description->SetDBValue($this->f("description"));
        $this->dateadded->SetDBValue($this->f("dateadded"));
        $this->added_description->SetDBValue($this->f("added_description"));
        $this->image_one->SetDBValue($this->f("image_one"));
        $this->image_two->SetDBValue($this->f("image_two"));
        $this->image_three->SetDBValue($this->f("image_three"));
        $this->image_four->SetDBValue($this->f("image_four"));
        $this->image_five->SetDBValue($this->f("image_five"));
        $this->bold->SetDBValue($this->f("bold"));
        $this->background->SetDBValue($this->f("background"));
        $this->cat_featured->SetDBValue($this->f("cat_featured"));
        $this->home_featured->SetDBValue($this->f("home_featured"));
        $this->gallery_featured->SetDBValue($this->f("gallery_featured"));
        $this->image_preview->SetDBValue($this->f("image_preview"));
        $this->slide_show->SetDBValue($this->f("slide_show"));
        $this->counter->SetDBValue($this->f("counter"));
        $this->hits->SetDBValue($this->f("hits"));
        $this->user_id->SetDBValue($this->f("user_id"));
        $this->started->SetDBValue($this->f("started"));
        $this->closes->SetDBValue($this->f("closes"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
    }
//End SetValues Method

//Update Method @54-FCA94670
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `items` SET "
             . "`title`=" . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
             . "`status`=" . $this->ToSQL($this->status->GetDBValue(), $this->status->DataType) . ", "
             . "`end_reason`=" . $this->ToSQL($this->end_reason->GetDBValue(), $this->end_reason->DataType) . ", "
             . "`category`=" . $this->ToSQL($this->category->GetDBValue(), $this->category->DataType) . ", "
             . "`asking_price`=" . $this->ToSQL($this->asking_price->GetDBValue(), $this->asking_price->DataType) . ", "
             . "`make_offer`=" . $this->ToSQL($this->make_offer->GetDBValue(), $this->make_offer->DataType) . ", "
             . "`quantity`=" . $this->ToSQL($this->quantity->GetDBValue(), $this->quantity->DataType) . ", "
             . "`city_town`=" . $this->ToSQL($this->city_town->GetDBValue(), $this->city_town->DataType) . ", "
             . "`state_province`=" . $this->ToSQL($this->state->GetDBValue(), $this->state->DataType) . ", "
             . "`country`=" . $this->ToSQL($this->country->GetDBValue(), $this->country->DataType) . ", "
             . "`description`=" . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
             //. "`dateadded`=" . $this->ToSQL($this->dateadded->GetDBValue(), $this->dateadded->DataType) . ", "
             . "`added_description`=" . $this->ToSQL($this->added_description->GetDBValue(), $this->added_description->DataType) . ", "
             . "`image_one`=" . $this->ToSQL($this->image_one->GetDBValue(), $this->image_one->DataType) . ", "
             . "`image_two`=" . $this->ToSQL($this->image_two->GetDBValue(), $this->image_two->DataType) . ", "
             . "`image_three`=" . $this->ToSQL($this->image_three->GetDBValue(), $this->image_three->DataType) . ", "
             . "`image_four`=" . $this->ToSQL($this->image_four->GetDBValue(), $this->image_four->DataType) . ", "
             . "`image_five`=" . $this->ToSQL($this->image_five->GetDBValue(), $this->image_five->DataType) . ", "
             . "`bold`=" . $this->ToSQL($this->bold->GetDBValue(), $this->bold->DataType) . ", "
             . "`background`=" . $this->ToSQL($this->background->GetDBValue(), $this->background->DataType) . ", "
             . "`cat_featured`=" . $this->ToSQL($this->cat_featured->GetDBValue(), $this->cat_featured->DataType) . ", "
             . "`home_featured`=" . $this->ToSQL($this->home_featured->GetDBValue(), $this->home_featured->DataType) . ", "
             . "`gallery_featured`=" . $this->ToSQL($this->gallery_featured->GetDBValue(), $this->gallery_featured->DataType) . ", "
             . "`image_preview`=" . $this->ToSQL($this->image_preview->GetDBValue(), $this->image_preview->DataType) . ", "
             . "`slide_show`=" . $this->ToSQL($this->slide_show->GetDBValue(), $this->slide_show->DataType) . ", "
             . "`counter`=" . $this->ToSQL($this->counter->GetDBValue(), $this->counter->DataType) . ", "
             . "`hits`=" . $this->ToSQL($this->hits->GetDBValue(), $this->hits->DataType) . ", "
             . "`user_id`=" . $this->ToSQL($this->user_id->GetDBValue(), $this->user_id->DataType) . ", "
             . "`started`=" . $this->ToSQL($this->started->GetDBValue(), $this->started->DataType) . ", "
             . "`closes`=" . $this->ToSQL($this->closes->GetDBValue(), $this->closes->DataType) . ", "
             . "`ItemNum`=" . $this->ToSQL($this->ItemNum->GetDBValue(), $this->ItemNum->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

//Delete Method @54-AE308ACD
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM `items` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Delete Method

} //End items1DataSource Class @54-FCB6E20C

//Include Page implementation @37-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-84121688
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

$FileName = "ItemsMaintanence.php";
$Redirect = "";
$TemplateFileName = "Themes/ItemsMaintanence.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-5FA77AF9
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$items1 = new clsRecorditems1();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$items1->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-29C3B21D
$Header->Operations();
$items1->Operation();
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
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-F741AF56
$Header->Show("Header");
$items1->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


//DEL      function SetValues()
//DEL      {
//DEL          $this->ItemNumLabel->SetDBValue($this->f("ItemNum"));
//DEL          $this->UserIDLabel->SetDBValue($this->f("user_id"));
//DEL          $this->StartedLabel->SetDBValue($this->f("started"));
//DEL          $this->ClosesLabel->SetDBValue($this->f("closes"));
//DEL          $this->title->SetDBValue($this->f("title"));
//DEL          $this->status->SetDBValue($this->f("status"));
//DEL          $this->end_reason->SetDBValue($this->f("end_reason"));
//DEL          $this->category->SetDBValue($this->f("category"));
//DEL          $this->asking_price->SetDBValue($this->f("asking_price"));
//DEL          $this->make_offer->SetDBValue($this->f("make_offer"));
//DEL          $this->quantity->SetDBValue($this->f("quantity"));
//DEL          $this->city_town->SetDBValue($this->f("city_town"));
//DEL          $this->states->SetDBValue($this->f("state_province"));
//DEL          $this->description->SetDBValue($this->f("description"));
//DEL          $this->dateadded->SetDBValue($this->f("dateadded"));
//DEL          $this->added_description->SetDBValue($this->f("added_description"));
//DEL          $this->image_one->SetDBValue($this->f("image_one"));
//DEL          $this->image_two->SetDBValue($this->f("image_two"));
//DEL          $this->image_three->SetDBValue($this->f("image_three"));
//DEL          $this->image_four->SetDBValue($this->f("image_four"));
//DEL          $this->image_five->SetDBValue($this->f("image_five"));
//DEL          $this->bold->SetDBValue($this->f("bold"));
//DEL          $this->background->SetDBValue($this->f("background"));
//DEL          $this->cat_featured->SetDBValue($this->f("cat_featured"));
//DEL          $this->home_featured->SetDBValue($this->f("home_featured"));
//DEL          $this->gallery_featured->SetDBValue($this->f("gallery_featured"));
//DEL          $this->image_preview->SetDBValue($this->f("image_preview"));
//DEL          $this->slide_show->SetDBValue($this->f("slide_show"));
//DEL          $this->counter->SetDBValue($this->f("counter"));
//DEL          $this->hits->SetDBValue($this->f("hits"));
//DEL          $this->user_id->SetDBValue($this->f("user_id"));
//DEL          $this->started->SetDBValue($this->f("started"));
//DEL          $this->closes->SetDBValue($this->f("closes"));
//DEL          $this->ItemNum->SetDBValue($this->f("ItemNum"));
//DEL      }


//DEL      function Update()
//DEL      {
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
//DEL          $SQL = "UPDATE items SET "
//DEL               . "title=" . $this->ToSQL($this->title->GetDBValue(), $this->title->DataType) . ", "
//DEL               . "status=" . $this->ToSQL($this->status->GetDBValue(), $this->status->DataType) . ", "
//DEL               . "end_reason=" . $this->ToSQL($this->end_reason->GetDBValue(), $this->end_reason->DataType) . ", "
//DEL               . "category=" . $this->ToSQL($this->category->GetDBValue(), $this->category->DataType) . ", "
//DEL               . "asking_price=" . $this->ToSQL($this->asking_price->GetDBValue(), $this->asking_price->DataType) . ", "
//DEL               . "make_offer=" . $this->ToSQL($this->make_offer->GetDBValue(), $this->make_offer->DataType) . ", "
//DEL               . "quantity=" . $this->ToSQL($this->quantity->GetDBValue(), $this->quantity->DataType) . ", "
//DEL               . "city_town=" . $this->ToSQL($this->city_town->GetDBValue(), $this->city_town->DataType) . ", "
//DEL               . "state_province=" . $this->ToSQL($this->states->GetDBValue(), $this->states->DataType) . ", "
//DEL               . "description=" . $this->ToSQL($this->description->GetDBValue(), $this->description->DataType) . ", "
//DEL               . "dateadded=" . $this->ToSQL($this->dateadded->GetDBValue(), $this->dateadded->DataType) . ", "
//DEL               . "added_description=" . $this->ToSQL($this->added_description->GetDBValue(), $this->added_description->DataType) . ", "
//DEL               . "image_one=" . $this->ToSQL($this->image_one->GetDBValue(), $this->image_one->DataType) . ", "
//DEL               . "image_two=" . $this->ToSQL($this->image_two->GetDBValue(), $this->image_two->DataType) . ", "
//DEL               . "image_three=" . $this->ToSQL($this->image_three->GetDBValue(), $this->image_three->DataType) . ", "
//DEL               . "image_four=" . $this->ToSQL($this->image_four->GetDBValue(), $this->image_four->DataType) . ", "
//DEL               . "image_five=" . $this->ToSQL($this->image_five->GetDBValue(), $this->image_five->DataType) . ", "
//DEL               . "bold=" . $this->ToSQL($this->bold->GetDBValue(), $this->bold->DataType) . ", "
//DEL               . "background=" . $this->ToSQL($this->background->GetDBValue(), $this->background->DataType) . ", "
//DEL               . "cat_featured=" . $this->ToSQL($this->cat_featured->GetDBValue(), $this->cat_featured->DataType) . ", "
//DEL               . "home_featured=" . $this->ToSQL($this->home_featured->GetDBValue(), $this->home_featured->DataType) . ", "
//DEL               . "gallery_featured=" . $this->ToSQL($this->gallery_featured->GetDBValue(), $this->gallery_featured->DataType) . ", "
//DEL               . "image_preview=" . $this->ToSQL($this->image_preview->GetDBValue(), $this->image_preview->DataType) . ", "
//DEL               . "slide_show=" . $this->ToSQL($this->slide_show->GetDBValue(), $this->slide_show->DataType) . ", "
//DEL               . "counter=" . $this->ToSQL($this->counter->GetDBValue(), $this->counter->DataType) . ", "
//DEL               . "hits=" . $this->ToSQL($this->hits->GetDBValue(), $this->hits->DataType) . ", "
//DEL               . "user_id=" . $this->ToSQL($this->user_id->GetDBValue(), $this->user_id->DataType) . ", "
//DEL               . "started=" . $this->ToSQL($this->started->GetDBValue(), $this->started->DataType) . ", "
//DEL               . "closes=" . $this->ToSQL($this->closes->GetDBValue(), $this->closes->DataType) . ", "
//DEL               . "ItemNum=" . $this->ToSQL($this->ItemNum->GetDBValue(), $this->ItemNum->DataType);
//DEL          $SQL = CCBuildSQL($SQL, $this->Where, "");
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
//DEL          $this->query($SQL);
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
//DEL          if($this->Errors->Count() > 0)
//DEL              $this->Errors->AddError($this->Errors->ToString());
//DEL      }


//DEL      function Delete()
//DEL      {
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
//DEL          $remi = new clsDBDBNetConnect;
//DEL  		$remi->connect();
//DEL  		$remi->query("SELECT * FROM items WHERE " . $this->Where);
//DEL  		while($remi->next_record())
//DEL  		{
//DEL  			@unlink("../" . $remi->f("image_one"));
//DEL  			@unlink("../" . $remi->f("image_two"));
//DEL  			@unlink("../" . $remi->f("image_three"));
//DEL  			@unlink("../" . $remi->f("image_four"));
//DEL  			@unlink("../" . $remi->f("image_five"));
//DEL  		}
//DEL  		unset($remi);
//DEL  		$SQL = "DELETE FROM items WHERE " . $this->Where;
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
//DEL          $this->query($SQL);
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
//DEL          if($this->Errors->Count() > 0)
//DEL              $this->Errors->AddError($this->Errors->ToString());
//DEL      }



?>
