<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

if (!$_REQUEST["cat_id"] && !$_REQUEST["set_id"])
	$_GET["cat_id"] = 1;
elseif (!$_REQUEST["cat_id"])
    $_GET["cat_id"] = $_REQUEST["set_id"];
  
//End Include Common Files
function getparents($CatID){
	$cats = "(";
	$db = new clsDBNetConnect;
	$query = "select * from categories where cat_id='" .$CatID . "'";
	$db->query($query);
    $db->next_record();
    $cats .= "set_id=" . $db->f("cat_id");
    if ($db->f("sub_cat_id")){
    	$cats .= " or ";
    	$sub = $db->f("sub_cat_id");
    	$query = "select * from categories where cat_id=$sub";
    	$db->query($query);
    	$db->next_record();
    	$cats .= "set_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")){
    		$cats .= " or ";
    		$sub = $db->f("sub_cat_id");
    		$query = "select * from categories where cat_id=$sub";
    		$db->query($query);
    		$db->next_record();
    		$cats .= "set_id=" . $db->f("cat_id");
    		if ($db->f("sub_cat_id")){
    			$cats .= " or ";
    			$sub = $db->f("sub_cat_id");
    			$query = "select * from categories where cat_id=$sub";
    			$db->query($query);
    			$db->next_record();
    			$cats .= "set_id=" . $db->f("cat_id");
    			if ($db->f("sub_cat_id")){
    				$cats .= " or ";
    				$sub = $db->f("sub_cat_id");
    				$query = "select * from categories where cat_id=$sub";
    				$db->query($query);
    				$db->next_record();
    				$cats .= "set_id=" . $db->f("cat_id");
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
	return $cats;
}


//Include Page implementation @20-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordsettings_charges { //settings_charges Class @2-E13CABAE

//Variables @2-052F1B76

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

	var $InsertAllowed;
    var $UpdateAllowed;
    var $DeleteAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @2-377F9405
    function clsRecordsettings_charges()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssettings_chargesDataSource();
        $this->InsertAllowed = true;
        $this->UpdateAllowed = true;
        if ($cat_id != 1)
            $this->DeleteAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "settings_charges";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", array("cat_id")), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->currency = new clsControl(ccsTextBox, "currency", "currency", ccsText, "", CCGetRequestParam("currency", $Method));
            $this->currencycode = new clsControl(ccsTextBox, "currencycode", "Currency Code", ccsText, "", CCGetRequestParam("currencycode", $Method));
            if ($_GET["cat_id"] == 1)
            $this->currencycode->Required = true;
            else
            $this->currencycode->Required = false;
            $this->NewReg = new clsControl(ccsListBox, "NewReg", "Give Registration Credit", ccsInteger, "", CCGetRequestParam("NewReg", $Method));
            $this->NewReg->DSType = dsListOfValues;
            $this->NewReg->Values = array(array("1", "Yes"), array("0", "No"));
            $this->CreditAmount = new clsControl(ccsTextBox, "CreditAmount", "New Credit Amount", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("CreditAmount", $Method));
            $this->tokens = new clsControl(ccsTextBox, "tokens", "Give Registration Tokens", ccsInteger, "", CCGetRequestParam("tokens", $Method));
            $this->TransactReason = new clsControl(ccsTextArea, "TransactReason", "Transaction Message", ccsText, "", CCGetRequestParam("TransactReason", $Method));
            $this->listing_fee = new clsControl(ccsTextBox, "listing_fee", "listing_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("listing_fee", $Method));
            $this->home_fee = new clsControl(ccsTextBox, "home_fee", "home_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("home_fee", $Method));
            $this->cat_fee = new clsControl(ccsTextBox, "cat_fee", "cat_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("cat_fee", $Method));
            $this->gallery_fee = new clsControl(ccsTextBox, "gallery_fee", "gallery_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("gallery_fee", $Method));
            $this->image_pre_fee = new clsControl(ccsTextBox, "image_pre_fee", "image_pre_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("image_pre_fee", $Method));
            $this->slide_fee = new clsControl(ccsTextBox, "slide_fee", "slide_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("slide_fee", $Method));
            $this->counter_fee = new clsControl(ccsTextBox, "counter_fee", "counter_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("counter_fee", $Method));
            $this->bold_fee = new clsControl(ccsTextBox, "bold_fee", "bold_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("bold_fee", $Method));
            $this->high_fee = new clsControl(ccsTextBox, "high_fee", "high_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("high_fee", $Method));
            $this->upload_fee = new clsControl(ccsTextBox, "upload_fee", "upload_fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("upload_fee", $Method));
            $this->Insert = new clsButton("Insert");
            $this->Update = new clsButton("Update");
            $this->Delete = new clsButton("Delete");
            $this->Cancel = new clsButton("Cancel");
            $this->set_id = new clsControl(ccsHidden, "set_id", "set_id", ccsInteger, "", CCGetRequestParam("set_id", $Method));
            $this->set_id->Required = true;
            if(!$this->FormSubmitted) {
                if(!strlen($this->CreditAmount->Value) && $this->CreditAmount->Value !== false)
                    $this->CreditAmount->SetValue(0.00);
            }
        }
    }
//End Class_Initialize Event

//Initialize Method @2-90EC5D36
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlset_id"] = CCGetFromGet("set_id", "");
    }
//End Initialize Method

//Validate Method @2-75ACA2D2
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->currency->Validate() && $Validation);
        $Validation = ($this->currencycode->Validate() && $Validation);
        $Validation = ($this->NewReg->Validate() && $Validation);
        $Validation = ($this->CreditAmount->Validate() && $Validation);
        $Validation = ($this->tokens->Validate() && $Validation);
        $Validation = ($this->TransactReason->Validate() && $Validation);
        $Validation = ($this->listing_fee->Validate() && $Validation);
        $Validation = ($this->home_fee->Validate() && $Validation);
        $Validation = ($this->cat_fee->Validate() && $Validation);
        $Validation = ($this->gallery_fee->Validate() && $Validation);
        $Validation = ($this->image_pre_fee->Validate() && $Validation);
        $Validation = ($this->slide_fee->Validate() && $Validation);
        $Validation = ($this->counter_fee->Validate() && $Validation);
        $Validation = ($this->bold_fee->Validate() && $Validation);
        $Validation = ($this->high_fee->Validate() && $Validation);
        $Validation = ($this->upload_fee->Validate() && $Validation);
        $Validation = ($this->set_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-8A36197A
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
            $this->PressedButton = $this->EditMode ? "Update" : "Insert";
            if(strlen(CCGetParam("Insert", ""))) {
                $this->PressedButton = "Insert";
            } else if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            } else if(strlen(CCGetParam("Delete", ""))) {
                $this->PressedButton = "Delete";
            }
        }
        if ($cat_id == 1)
        	$Redirect = "index.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Cancel","ccsForm","cat_id","Delete"));
        else
        	$Redirect = "CatDetails.php?cat=" . $_GET["cat_id"] . "&" . CCGetQueryString("QueryString", Array("Insert","Update","Cancel","ccsForm","Delete"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "Fees.php?" . CCGetQueryString("QueryString", array("ccsForm"));
			}
        } else if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
            if($this->PressedButton == "Insert") {
                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {
                    $Redirect = "";
                }
            }
            elseif($this->PressedButton == "Delete") {
            	if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->DeleteRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method
//InsertRow Method @2-8DF9A5FB
    function InsertRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");
        if(!$this->InsertAllowed) return false;
        $this->ds->currency->SetValue($this->currency->GetValue());
        $this->ds->currencycode->SetValue($this->currencycode->GetValue());
        $this->ds->NewReg->SetValue($this->NewReg->GetValue());
        $this->ds->CreditAmount->SetValue($this->CreditAmount->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->TransactReason->SetValue($this->TransactReason->GetValue());
        $this->ds->listing_fee->SetValue($this->listing_fee->GetValue());
        $this->ds->home_fee->SetValue($this->home_fee->GetValue());
        $this->ds->cat_fee->SetValue($this->cat_fee->GetValue());
        $this->ds->gallery_fee->SetValue($this->gallery_fee->GetValue());
        $this->ds->image_pre_fee->SetValue($this->image_pre_fee->GetValue());
        $this->ds->slide_fee->SetValue($this->slide_fee->GetValue());
        $this->ds->counter_fee->SetValue($this->counter_fee->GetValue());
        $this->ds->bold_fee->SetValue($this->bold_fee->GetValue());
        $this->ds->high_fee->SetValue($this->high_fee->GetValue());
        $this->ds->upload_fee->SetValue($this->upload_fee->GetValue());
        $this->ds->set_id->SetValue($this->set_id->GetValue());
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

//UpdateRow Method @2-D8CC2AA5
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->currency->SetValue($this->currency->GetValue());
        $this->ds->currencycode->SetValue($this->currencycode->GetValue());
        $this->ds->NewReg->SetValue($this->NewReg->GetValue());
        $this->ds->CreditAmount->SetValue($this->CreditAmount->GetValue());
        $this->ds->tokens->SetValue($this->tokens->GetValue());
        $this->ds->TransactReason->SetValue($this->TransactReason->GetValue());
        $this->ds->listing_fee->SetValue($this->listing_fee->GetValue());
        $this->ds->home_fee->SetValue($this->home_fee->GetValue());
        $this->ds->cat_fee->SetValue($this->cat_fee->GetValue());
        $this->ds->gallery_fee->SetValue($this->gallery_fee->GetValue());
        $this->ds->image_pre_fee->SetValue($this->image_pre_fee->GetValue());
        $this->ds->slide_fee->SetValue($this->slide_fee->GetValue());
        $this->ds->counter_fee->SetValue($this->counter_fee->GetValue());
        $this->ds->bold_fee->SetValue($this->bold_fee->GetValue());
        $this->ds->high_fee->SetValue($this->high_fee->GetValue());
        $this->ds->upload_fee->SetValue($this->upload_fee->GetValue());
        $this->ds->set_id->SetValue($this->set_id->GetValue());
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

//DeleteRow Method @2-6A43D177
    function DeleteRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");
        if(!$this->DeleteAllowed)
		return false;
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

//Show Method @2-A470E1CF
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->NewReg->Prepare();

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record settings_charges";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->currency->SetValue($this->ds->currency->GetValue());
                        $this->currencycode->SetValue($this->ds->currencycode->GetValue());
                        $this->NewReg->SetValue($this->ds->NewReg->GetValue());
                        $this->CreditAmount->SetValue($this->ds->CreditAmount->GetValue());
                        $this->tokens->SetValue($this->ds->tokens->GetValue());
                        $this->TransactReason->SetValue($this->ds->TransactReason->GetValue());
                        $this->listing_fee->SetValue($this->ds->listing_fee->GetValue());
                        $this->home_fee->SetValue($this->ds->home_fee->GetValue());
                        $this->cat_fee->SetValue($this->ds->cat_fee->GetValue());
                        $this->gallery_fee->SetValue($this->ds->gallery_fee->GetValue());
                        $this->image_pre_fee->SetValue($this->ds->image_pre_fee->GetValue());
                        $this->slide_fee->SetValue($this->ds->slide_fee->GetValue());
                        $this->counter_fee->SetValue($this->ds->counter_fee->GetValue());
                        $this->bold_fee->SetValue($this->ds->bold_fee->GetValue());
                        $this->high_fee->SetValue($this->ds->high_fee->GetValue());
                        $this->upload_fee->SetValue($this->ds->upload_fee->GetValue());
                        $this->set_id->SetValue($this->ds->set_id->GetValue());
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
            $Error .= $this->currency->Errors->ToString();
            $Error .= $this->currencycode->Errors->ToString();
            $Error .= $this->NewReg->Errors->ToString();
            $Error .= $this->CreditAmount->Errors->ToString();
            $Error .= $this->tokens->Errors->ToString();
            $Error .= $this->TransactReason->Errors->ToString();
            $Error .= $this->listing_fee->Errors->ToString();
            $Error .= $this->home_fee->Errors->ToString();
            $Error .= $this->cat_fee->Errors->ToString();
            $Error .= $this->gallery_fee->Errors->ToString();
            $Error .= $this->image_pre_fee->Errors->ToString();
            $Error .= $this->slide_fee->Errors->ToString();
            $Error .= $this->counter_fee->Errors->ToString();
            $Error .= $this->bold_fee->Errors->ToString();
            $Error .= $this->high_fee->Errors->ToString();
            $Error .= $this->upload_fee->Errors->ToString();
            $Error .= $this->set_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        
        $cat = $_GET["cat_id"];
        $catoptions="";
		$catlist = new clsDBDBNetConnect();
		$catlist->query("select * from categories where cat_id=1");
  		while($catlist->next_record()) {
      		if ($cat==$catlist->f("cat_id"))
          		$selected = " selected";
  		$catoptions .= "<option value=\"" . $catlist->f("cat_id") . "\"$selected>" . $catlist->f("name") . "</option>";
  		$selected = "";
  		$catlist2 = new clsDBDBNetConnect();
  		$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
     		while($catlist2->next_record()) {
		               if ($cat==$catlist2->f("cat_id"))
		               $selected = " selected";
     		$catoptions .= "<option value=\"" . $catlist2->f("cat_id") . "\"$selected>&nbsp;" . $catlist2->f("name") . "</option>";
     		$selected = "";
     		$catlist3 = new clsDBDBNetConnect();
     		$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
        		while($catlist3->next_record()) {
		                  if ($cat==$catlist3->f("cat_id"))
		                  $selected = " selected";
		        $catoptions .= "<option value=\"" . $catlist3->f("cat_id") . "\"$selected>&nbsp;&nbsp;" . $catlist3->f("name") . "</option>";
		        $selected = "";
		        $catlist4 = new clsDBDBNetConnect();
		        $catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
		           while($catlist4->next_record()) {
		                     if ($cat==$catlist4->f("cat_id"))
		                     $selected = " selected";
		           $catoptions .= "<option value=\"" . $catlist4->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;" . $catlist4->f("name") . "</option>";
		           $selected = "";
		           $catlist5 = new clsDBDBNetConnect();
		           $catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
		              while($catlist5->next_record()) {
		                        if ($cat==$catlist5->f("cat_id"))
		                        $selected = " selected";
		              $catoptions .= "<option value=\"" . $catlist5->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;&nbsp;" . $catlist5->f("name") . "</option>";
		              $selected = "";
        		      $catlist6 = new clsDBDBNetConnect();
              		  $catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
                 	  while($catlist6->next_record()) {
                           if ($cat==$catlist6->f("cat_id"))
                           $selected = " selected";
                 		  $catoptions .= "<option value=\"" . $catlist6->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $catlist6->f("name") . "</option>";
                 	  	  $selected = "";
                 	  }
              		}
           		}
        	}
     	}
  	}
  	
        $Tpl->SetVar("Action", $this->HTMLFormAction);
		$dbcon = new clsDBNetConnect;
		$query = "select * from settings_charges where set_id=" . $_GET["cat_id"];
		$dbcon->query($query);
		if ($dbcon->next_record()) {
        	$this->Insert->Visible = 0;
        	$this->Update->Visible = 1;
        	if ($_GET["cat_id"] != 1 && $_GET["cat_id"])
        		$this->Delete->Visible = 1;
       	}
       	else {
       		$this->Insert->Visible = 1;
        	$this->Update->Visible = 0;
        	$this->Delete->Visible = 0;
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->currency->Show();
        $this->currencycode->Show();
        $this->NewReg->Show();
        $this->CreditAmount->Show();
        $this->tokens->Show();
        $this->TransactReason->Show();
        $this->listing_fee->Show();
        $this->home_fee->Show();
        $this->cat_fee->Show();
        $this->gallery_fee->Show();
        $this->image_pre_fee->Show();
        $this->slide_fee->Show();
        $this->counter_fee->Show();
        $this->bold_fee->Show();
        $this->high_fee->Show();
        $this->upload_fee->Show();
        $this->Insert->Show();
        $this->Update->Show();
        if ($_GET["cat_id"] != 1 && $_GET["cat_id"])
        $this->Delete->Show();
        $this->Cancel->Show();
        $this->set_id->Show();
        if ($cat != 1)
            $Tpl->SetVar("disabled", "disabled");
        $Tpl->SetVar("CatOptions", $catoptions);
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End settings_charges Class @2-FCB6E20C

class clssettings_chargesDataSource extends clsDBDBNetConnect {  //settings_chargesDataSource Class @2-87020E65

//DataSource Variables @2-93B572B1
    var $CCSEvents = "";
    var $CCSEventResult;

    var $InsertParameters;
    var $UpdateParameters;
    var $DeleteParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $currency;
    var $currencycode;
    var $NewReg;
    var $CreditAmount;
    var $tokens;
    var $TransactReason;
    var $listing_fee;
    var $home_fee;
    var $cat_fee;
    var $gallery_fee;
    var $image_pre_fee;
    var $slide_fee;
    var $counter_fee;
    var $bold_fee;
    var $high_fee;
    var $upload_fee;
    var $set_id;
//End DataSource Variables

//Class_Initialize Event @2-87050ECD
    function clssettings_chargesDataSource()
    {
        $this->Initialize();
        $this->currency = new clsField("currency", ccsText, "");
        $this->currencycode = new clsField("currencycode", ccsText, "");
        $this->NewReg = new clsField("NewReg", ccsInteger, "");
        $this->CreditAmount = new clsField("CreditAmount", ccsFloat, "");
        $this->tokens = new clsField("tokens", ccsInteger, "");
        $this->TransactReason = new clsField("TransactReason", ccsText, "");
        $this->listing_fee = new clsField("listing_fee", ccsFloat, "");
        $this->home_fee = new clsField("home_fee", ccsFloat, "");
        $this->cat_fee = new clsField("cat_fee", ccsFloat, "");
        $this->gallery_fee = new clsField("gallery_fee", ccsFloat, "");
        $this->image_pre_fee = new clsField("image_pre_fee", ccsFloat, "");
        $this->slide_fee = new clsField("slide_fee", ccsFloat, "");
        $this->counter_fee = new clsField("counter_fee", ccsFloat, "");
        $this->bold_fee = new clsField("bold_fee", ccsFloat, "");
        $this->high_fee = new clsField("high_fee", ccsFloat, "");
        $this->upload_fee = new clsField("upload_fee", ccsFloat, "");
        $this->set_id = new clsField("set_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-D221C61F
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlset_id", ccsInteger, "", "", $this->Parameters["urlset_id"], 1);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`set_id`", $_GET["cat_id"], $this->ToSQL($_GET["cat_id"], ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-667FFC8F
    function Open()
    {
    	$addwhere = getparents($_GET["cat_id"]);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM settings_charges";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $addwhere . " ORDER BY set_id DESC LIMIT 1", $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-19E28474
    function SetValues()
    {
        $this->currency->SetDBValue($this->f("currency"));
        $this->currencycode->SetDBValue($this->f("currencycode"));
        $this->NewReg->SetDBValue($this->f("newregon"));
        $this->CreditAmount->SetDBValue($this->f("newregcredit"));
        $this->tokens->SetDBValue($this->f("tokens"));
        $this->TransactReason->SetDBValue($this->f("newregreason"));
        $this->listing_fee->SetDBValue($this->f("listing_fee"));
        $this->home_fee->SetDBValue($this->f("home_fee"));
        $this->cat_fee->SetDBValue($this->f("cat_fee"));
        $this->gallery_fee->SetDBValue($this->f("gallery_fee"));
        $this->image_pre_fee->SetDBValue($this->f("image_pre_fee"));
        $this->slide_fee->SetDBValue($this->f("slide_fee"));
        $this->counter_fee->SetDBValue($this->f("counter_fee"));
        $this->bold_fee->SetDBValue($this->f("bold_fee"));
        $this->high_fee->SetDBValue($this->f("high_fee"));
        $this->upload_fee->SetDBValue($this->f("upload_fee"));
        $this->set_id->SetDBValue($_GET["cat_id"]);
    }
//End SetValues Method
//Insert Method @2-543151F3
    function Insert()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");
             $SQL = "INSERT INTO `settings_charges` ("
             . "`currency`, "
             . "`currencycode`, "
             . "`newregon`, "
             . "`newregcredit`, "
             . "`tokens`, "
             . "`newregreason`, "
             . "`listing_fee`, "
             . "`home_fee`, "
             . "`cat_fee`, "
             . "`gallery_fee`, "
             . "`image_pre_fee`, "
             . "`slide_fee`, "
             . "`counter_fee`, "
             . "`bold_fee`, "
             . "`high_fee`, "
			 . "`upload_fee`, "
             . "`set_id`"
			 . ") values ("
             
             . $this->ToSQL($this->currency->GetDBValue(), $this->currency->DataType) . ", "
             . $this->ToSQL($this->currencycode->GetDBValue(), $this->currencycode->DataType) . ", "
             . $this->ToSQL($this->NewReg->GetDBValue(), $this->NewReg->DataType) . ", "
             . $this->ToSQL($this->CreditAmount->GetDBValue(), $this->CreditAmount->DataType) . ", "
             . $this->ToSQL($this->tokens->GetDBValue(), $this->tokens->DataType) . ", "
             . $this->ToSQL($this->TransactReason->GetDBValue(), $this->TransactReason->DataType) . ", "
             . $this->ToSQL($this->listing_fee->GetDBValue(), $this->listing_fee->DataType) . ", "
             . $this->ToSQL($this->home_fee->GetDBValue(), $this->home_fee->DataType) . ", "
             . $this->ToSQL($this->cat_fee->GetDBValue(), $this->cat_fee->DataType) . ", "
             . $this->ToSQL($this->gallery_fee->GetDBValue(), $this->gallery_fee->DataType) . ", "
             . $this->ToSQL($this->image_pre_fee->GetDBValue(), $this->image_pre_fee->DataType) . ", "
             . $this->ToSQL($this->slide_fee->GetDBValue(), $this->slide_fee->DataType) . ", "
             . $this->ToSQL($this->counter_fee->GetDBValue(), $this->counter_fee->DataType) . ", "
             . $this->ToSQL($this->bold_fee->GetDBValue(), $this->bold_fee->DataType) . ", "
             . $this->ToSQL($this->high_fee->GetDBValue(), $this->high_fee->DataType) . ", "
             . $this->ToSQL($this->upload_fee->GetDBValue(), $this->upload_fee->DataType) . ", "
             . $this->ToSQL($this->set_id->GetDBValue(), $this->set_id->DataType)
			 . ")";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
        if ($_GET["cat_id"] && $_GET["cat_id"] != 1) {
			$db = new clsDBNetConnect;
			$query = "select * from category_details where cat_id = '" . $_GET["cat_id"] . "'";
			$db->query($query);
			if ($db->next_record()){
				$db->query("update category_details set pricing = '1' where cat_id = '" . $_GET["cat_id"] . "'");
			}
			else {
				$db->query("insert into category_details (`cat_id`, `pricing`) values ('" . $_GET["cat_id"] . "', '1')");
			}
		}
    }
    
//End Insert Method

//Update Method @2-48201046
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `settings_charges` SET "
             . "`currency`=" . $this->ToSQL($this->currency->GetDBValue(), $this->currency->DataType) . ", "
             . "`currencycode`=" . $this->ToSQL($this->currencycode->GetDBValue(), $this->currencycode->DataType) . ", "
             . "`newregon`=" . $this->ToSQL($this->NewReg->GetDBValue(), $this->NewReg->DataType) . ", "
             . "`newregcredit`=" . $this->ToSQL($this->CreditAmount->GetDBValue(), $this->CreditAmount->DataType) . ", "
             . "`tokens`=" . $this->ToSQL($this->tokens->GetDBValue(), $this->tokens->DataType) . ", "
             . "`newregreason`=" . $this->ToSQL($this->TransactReason->GetDBValue(), $this->TransactReason->DataType) . ", "
             . "`listing_fee`=" . $this->ToSQL($this->listing_fee->GetDBValue(), $this->listing_fee->DataType) . ", "
             . "`home_fee`=" . $this->ToSQL($this->home_fee->GetDBValue(), $this->home_fee->DataType) . ", "
             . "`cat_fee`=" . $this->ToSQL($this->cat_fee->GetDBValue(), $this->cat_fee->DataType) . ", "
             . "`gallery_fee`=" . $this->ToSQL($this->gallery_fee->GetDBValue(), $this->gallery_fee->DataType) . ", "
             . "`image_pre_fee`=" . $this->ToSQL($this->image_pre_fee->GetDBValue(), $this->image_pre_fee->DataType) . ", "
             . "`slide_fee`=" . $this->ToSQL($this->slide_fee->GetDBValue(), $this->slide_fee->DataType) . ", "
             . "`counter_fee`=" . $this->ToSQL($this->counter_fee->GetDBValue(), $this->counter_fee->DataType) . ", "
             . "`bold_fee`=" . $this->ToSQL($this->bold_fee->GetDBValue(), $this->bold_fee->DataType) . ", "
             . "`high_fee`=" . $this->ToSQL($this->high_fee->GetDBValue(), $this->high_fee->DataType) . ", "
             . "`upload_fee`=" . $this->ToSQL($this->upload_fee->GetDBValue(), $this->upload_fee->DataType) . ", "
             . "`set_id`=" . $this->ToSQL($this->set_id->GetDBValue(), $this->set_id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

//Delete Method @2-BB5A9601
    function Delete()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");
        $SQL = "DELETE FROM `settings_charges` WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
		if ($_GET["cat_id"] && $_GET["cat_id"] != 1) {
			$db = new clsDBNetConnect;
			$query = "select * from category_details where cat_id = '" . $_GET["cat_id"] . "'";
			$db->query($query);
			if ($db->next_record()){
				$query = "select * from lookup_listing_dates where cat_id = '" . $_GET["cat_id"] . "'";
				$db->query($query);
				if (!$db->next_record()) {
				    $db->query("update category_details set pricing = '0' where cat_id = '" . $_GET["cat_id"] . "'");
				}
			}
		}

    }
//End Delete Method

} //End settings_chargesDataSource Class @2-FCB6E20C

//Include Page implementation @21-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-2282A51C
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

$FileName = "Fees.php";
$Redirect = "";
$TemplateFileName = "Themes/Fees.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-7302B87D
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$settings_charges = new clsRecordsettings_charges();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$settings_charges->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-332FBF3C
$Header->Operations();
$settings_charges->Operation();
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

//Show Page @1-7EF9F867
$Header->Show("Header");
$settings_charges->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page



?>
