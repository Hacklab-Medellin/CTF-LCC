<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

//End Include Common Files
$page="Searching...";
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

Class clsRecorditemsSearch { //itemsSearch Class @4-187A0E52

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

//Class_Initialize Event @4-DF97A96E
    function clsRecorditemsSearch()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->InsertAllowed = false;
        $this->UpdateAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "itemsSearch";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->s_ItemNum = new clsControl(ccsTextBox, "s_ItemNum", "s_ItemNum", ccsInteger, "", CCGetRequestParam("s_ItemNum", $Method));
            $this->s_user_id = new clsControl(ccsTextBox, "s_user_id", "s_user_id", ccsText, "", CCGetRequestParam("s_user_id", $Method));
            $this->s_title = new clsControl(ccsTextBox, "s_title", "s_title", ccsText, "", CCGetRequestParam("s_title", $Method));
            $this->s_indexsearch = new clsControl(ccsTextBox, "s_indexsearch", "s_indexsearch", ccsText, "", CCGetRequestParam("s_indexsearch", $Method));
            $this->s_description = new clsControl(ccsTextBox, "s_description", "s_description", ccsMemo, "", CCGetRequestParam("s_description", $Method));
            $this->s_asking_min = new clsControl(ccsTextBox, "s_asking_min", "s_asking_min", ccsFloat, "", CCGetRequestParam("s_asking_min", $Method));
            $this->s_asking_max = new clsControl(ccsTextBox, "s_asking_max", "s_asking_max", ccsFloat, "", CCGetRequestParam("s_asking_max", $Method));
            $this->s_make_offer = new clsControl(ccsCheckBox, "s_make_offer", "s_make_offer", ccsInteger, "", CCGetRequestParam("s_make_offer", $Method));
            $this->s_make_offer->CheckedValue = 1;
            $this->s_make_offer->UncheckedValue = 0;
            $this->s_quantity = new clsControl(ccsTextBox, "s_quantity", "s_quantity", ccsInteger, "", CCGetRequestParam("s_quantity", $Method));
            $this->s_city_town = new clsControl(ccsTextBox, "s_city_town", "s_city_town", ccsText, "", CCGetRequestParam("s_city_town", $Method));
            $this->s_state_province = new clsControl(ccsTextBox, "s_state_province", "s_state_province", ccsText, "", CCGetRequestParam("s_state_province", $Method));
            $this->DoSearch = new clsButton("DoSearch");
        }
    }
//End Class_Initialize Event

//Validate Method @4-5A06C722
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_ItemNum->Validate() && $Validation);
        $Validation = ($this->s_user_id->Validate() && $Validation);
        $Validation = ($this->s_title->Validate() && $Validation);
        $Validation = ($this->s_description->Validate() && $Validation);
        $Validation = ($this->s_asking_min->Validate() && $Validation);
        $Validation = ($this->s_asking_max->Validate() && $Validation);
        $Validation = ($this->s_make_offer->Validate() && $Validation);
        $Validation = ($this->s_quantity->Validate() && $Validation);
        $Validation = ($this->s_city_town->Validate() && $Validation);
        $Validation = ($this->s_state_province->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @4-10587EFF
    function Operation()
    {
        global $Redirect;

        $this->EditMode = false;
        if(!($this->Visible && $this->FormSubmitted))
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = "DoSearch";
            if(strlen(CCGetParam("DoSearch", ""))) {
                $this->PressedButton = "DoSearch";
                $db = new clsDBNetConnect;
                //print_r($_POST);
                $string = "";
                if (!$_GET["GetOutside"]){
                	while (list($key, $value) = each($_POST)){
	                	if (is_array($value)){
                			$value = implode("-", $value);
                			if (strstr($value, "-0") || strpos($value, "0") === 0){
	                			$value = "0";
                			}
                		}
                		$value = str_replace(" ::!:!: ", "", $value);
                		$value = str_replace(" :!:!:: ", "", $value);
                		if ($key != "DoSearch")
	                		$string .= $key . " ::!:!: " . $value . " :!:!:: ";
                	}
                }
                else{
                	while (list($key, $value) = each($_GET)){
                		
	                	if (is_array($value)){
                			$value = implode("-", $value);
                			if (strstr($value, "-0") || strpos($value, "0") === 0){
	                			$value = "0";
                			}
                		}
                		$value = str_replace(" ::!:!: ", "", $value);
                		$value = str_replace(" :!:!:: ", "", $value);
                		if ($key != "DoSearch" && $key != "ccsForm" && $key != "GetOutside")
	                		$string .= $key . " ::!:!: " . $value . " :!:!:: ";
                	}
                }
				$query = "insert into search_history (`user_id`, `date`, `value`) values ('" . CCGetUserID() . "', '" . time() . "', '" . mysql_escape_string($string) . "')";
				$db->query($query);
				$new_id = mysql_insert_id();
            }
        }
        $Redirect = "ViewCat.php?search_id=$new_id";// . CCGetQueryString("Form", Array("DoSearch","ccsForm"));
        if($this->Validate()) {
            if($this->PressedButton == "DoSearch") {
                if(!CCGetEvent($this->DoSearch->CCSEvents, "OnClick")) {
                    $Redirect = "";
                } else {
                    $Redirect = "ViewCat.php?search_id=$new_id";// . CCGetQueryString("Form", Array("DoSearch"));
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @4-43FD934A
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
        $cat = $_REQUEST["CatID"];
        $catoptions="";
        $subcats = "";
		$catlist = new clsDBNetConnect;
		$catlist->query("select * from categories where cat_id=1");
  		while($catlist->next_record()) {
      		if ($cat==$catlist->f("cat_id"))
          		$selected = " selected";
  			$catoptions .= "<option value=\"" . $catlist->f("cat_id") . "\"$selected>" . "Any" . "</option>";
  			if ($selected)
  				$subcats = "Any";
  			$selected = "";
  			$catlist2 = new clsDBNetConnect();
  			$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
     		while($catlist2->next_record()) {
			    if ($cat==$catlist2->f("cat_id"))
		        	$selected = " selected";
     			$catoptions .= "<option value=\"" . $catlist2->f("cat_id") . "\"$selected>--" . $catlist2->f("name") . "</option>";
     			if ($selected){
  					$subcats = $catlist2->f("cat_id");
  					$subcattree1 = $subcats;
     			}
     			$selected = "";
     			$catlist3 = new clsDBNetConnect();
     			$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
        		while($catlist3->next_record()) {
                  if ($cat==$catlist3->f("cat_id"))
                  	$selected = " selected";
       			  $catoptions .= "<option value=\"" . $catlist3->f("cat_id") . "\"$selected>----" . $catlist3->f("name") . "</option>";
       			  if ($selected) {
  					$subcats = $catlist3->f("cat_id");
  					$subcattree2 = $subcats;
       			  }
  				  elseif (!$selected && $subcattree1 && $subcats != "Any"){
  				  	$subcats .= ";" . $catlist3->f("cat_id");
  				  	$subcattree2 = $subcats;
  				  }
        		  $selected = "";
        		  $catlist4 = new clsDBNetConnect();
        		  $catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
           			while($catlist4->next_record()) {
                    	if ($cat==$catlist4->f("cat_id"))
              		       	$selected = " selected";
           				$catoptions .= "<option value=\"" . $catlist4->f("cat_id") . "\"$selected>------" . $catlist4->f("name") . "</option>";
           				if ($selected) {
  							$subcats = $catlist4->f("cat_id");
  							$subcattree3 = $subcats;
           				}
  				  		elseif (!$selected && $subcattree2 && $subcats != "Any"){
  				  			$subcats .= ";" . $catlist4->f("cat_id");
  				  			$subcattree3 = $subcats;
  				  		}
           				$selected = "";
           				$catlist5 = new clsDBNetConnect();
           				$catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
              			while($catlist5->next_record()) {
                        	if ($cat==$catlist5->f("cat_id"))
                        		$selected = " selected";
              				$catoptions .= "<option value=\"" . $catlist5->f("cat_id") . "\"$selected>--------" . $catlist5->f("name") . "</option>";
              				if ($selected){
  								$subcats = $catlist5->f("cat_id");
  								$subcattree4 = $subcats;
              				}
  				  			elseif (!$selected && $subcattree3 && $subcats != "Any"){
	  				  			$subcats .= ";" . $catlist5->f("cat_id");
	  				  			$subcattree4 = $subcats;
  				  			}
              				$selected = "";
              				$catlist6 = new clsDBNetConnect();
              				$catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
                 			while($catlist6->next_record()) {
                        		if ($cat==$catlist6->f("cat_id"))
                           			$selected = " selected";
                 				$catoptions .= "<option value=\"" . $catlist6->f("cat_id") . "\"$selected>----------" . $catlist6->f("name") . "</option>";
                 				if ($selected){
  									$subcats = $catlist6->f("cat_id");
  									$subcattree5 = $subcats;
                 				}
  				  				elseif (!$selected && $subcattree4 && $subcats != "Any"){
	  				  				$subcats .= ";" . $catlist6->f("cat_id");
	  				  				$subcattree5 = $subcats;
                 				}
                 				$selected = "";
                 			}
                 			$subcattree4 = "";
              			}
              			$subcattree3 = "";
           			}
           			$subcattree2 = "";
        		}
        		$subcattree1 = "";
     		}
  		}

        if($this->FormSubmitted) {
            $Error .= $this->s_ItemNum->Errors->ToString();
            $Error .= $this->s_user_id->Errors->ToString();
            $Error .= $this->s_title->Errors->ToString();
            $Error .= $this->s_indexsearch->Errors->ToString();
            $Error .= $this->s_description->Errors->ToString();
            $Error .= $this->s_asking_min->Errors->ToString();
            $Error .= $this->s_asking_max->Errors->ToString();
            $Error .= $this->s_make_offer->Errors->ToString();
            $Error .= $this->s_quantity->Errors->ToString();
            $Error .= $this->s_city_town->Errors->ToString();
            $Error .= $this->s_state_province->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("subcats", $subcats);
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $Tpl->SetVar("catoptions", $catoptions);
        $this->s_ItemNum->Show();
        $this->s_user_id->Show();
        $this->s_title->Show();
        $this->s_indexsearch->Show();
        $this->s_description->Show();
        $this->s_asking_min->Show();
        $this->s_asking_max->Show();
        $this->s_make_offer->Show();
        $this->s_quantity->Show();
        $this->s_city_town->Show();
        $this->s_state_province->Show();
        $this->DoSearch->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End itemsSearch Class @4-FCB6E20C

//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-A4892299
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

$FileName = "search.php";
$Redirect = "";
$TemplateFileName = "templates/search.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Initialize Objects @1-8374EDC9

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$itemsSearch = new clsRecorditemsSearch();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-B06FCBC8
$Header->Operations();
$itemsSearch->Operation();
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

//BEGIN CUSTOM FIELDS BUILD CODE//
	if ($_REQUEST["CatID"])
	$finalcat = $_REQUEST["CatID"];
	else
	$finalcat = "1";
	$cats = "(";
	$db = new clsDBNetConnect;
	$query = "select * from categories where cat_id='" . $finalcat . "'";
	$db->query($query);
	$db->next_record();
	$Tpl->SetVar("category",$finalcat);
	$Tpl->SetVar("cat_name",$db->f("name"));
	$cats .= "cat_id=" . $db->f("cat_id");

	if ($db->f("sub_cat_id")>0){
	    $cats .= " or ";
	    $sub = $db->f("sub_cat_id");
	    $query = "select * from categories where cat_id=$sub";
	    $db->query($query);
	    $db->next_record();
    	$cats .= "cat_id=" . $db->f("cat_id");
    	if ($db->f("sub_cat_id")>0){
	    	$cats .= " or ";
	    	$sub = $db->f("sub_cat_id");
	    	$query = "select * from categories where cat_id=$sub";
	    	$db->query($query);
	    	$db->next_record();
	    	$cats .= "cat_id=" . $db->f("cat_id");
	    	if ($db->f("sub_cat_id")>0){
	    		$cats .= " or ";
	    		$sub = $db->f("sub_cat_id");
	    		$query = "select * from categories where cat_id=$sub";
	    		$db->query($query);
	    		$db->next_record();
	    		$cats .= "cat_id=" . $db->f("cat_id");
	    		if ($db->f("sub_cat_id")>0){
	    			$cats .= " or ";
	    			$sub = $db->f("sub_cat_id");
	    			$query = "select * from categories where cat_id=$sub";
	    			$db->query($query);
	    			$db->next_record();
	    			$cats .= "cat_id=" . $db->f("cat_id");
	    			if ($db->f("sub_cat_id")>0){
	    				$cats .= " or ";
    					$sub = $db->f("sub_cat_id");
	    				$query = "select * from categories where cat_id=$sub";
	    				$db->query($query);
	    				$db->next_record();
	    				$cats .= "cat_id=" . $db->f("cat_id");
	    				if ($db->f("sub_cat_id")>0){
	    					$cats .= " or ";
    						$sub = $db->f("sub_cat_id");
	    					$query = "select * from categories where cat_id=$sub";
	    					$db->query($query);
	    					$db->next_record();
	    					$cats .= "cat_id=" . $db->f("cat_id");
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
	    } else{
	    	$cats .= ")";
	    }
	} else{
	    $cats .= ")";
	}
	
/////////////////////////////////
//Custom Text Area Fields////////
/////////////////////////////////


		$Tpl->SetBlockVar("Custom_TextArea", "");
        $custtxt = new clsDBNetConnect;
		$query = "select * from custom_textarea where $cats and `searchable` = '1'";
		$custtxt->query($query);
		if ($custtxt->next_record()){
			$custtxt->seek();
			$queryfields = "(";
			$count = 0;

			while ($custtxt->next_record()){
				If ($count > 0)
		    		$queryfields .= " or ";
				$queryfields .= "field_id='" . $custtxt->f("id") . "'";
				$textvar[$custtxt->f("id")] = $custtxt->f("template_var");
				$textdesc[$custtxt->f("id")] = $custtxt->f("description");
	 			$textname[$custtxt->f("id")] = $custtxt->f("name");
				$count++;
			}
			$custtxt->seek();
			$queryfields .= ") and";
			
			while ($custtxt->next_record()){

				$Tpl->SetVar("ta_name", multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("ta_description", multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("ta_var", "custtxt_area::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
				$Tpl->SetVar("ta_value", stripslashes($fieldvalues[$custtxt->f("id")]));
				$Tpl->SetVar("ta_name_" . $custtxt->f("id"), multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("ta_description_" . $custtxt->f("id"), multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("ta_var_" . $custtxt->f("id"), "custtxt_area::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
				$Tpl->SetVar("ta_value_" . $custtxt->f("id"), stripslashes($fieldvalues[$custtxt->f("id")]));
				$Tpl->Parse("Row",True);
			}
        	$Tpl->Parse("Custom_TextArea", True);
        }

        //////////////////////////////
        //Custom TextBox
        //////////////////////////////

        $txtvar = "";
		$txtdesc = "";
		$txtname = "";
		$custtxtvalues = "";
		$custtxt = "";
		$fieldvalues = "";
		$Tpl->SetBlockVar("Custom_TextBox", "");
		$custtxt = new clsDBNetConnect;
		$query = "select * from custom_textbox where $cats and `searchable` = '1'";
		$custtxt->query($query);
		if ($custtxt->next_record()){
			$custtxt->seek();
			$queryfields = "(";
			$count = 0;

			while ($custtxt->next_record()){
				If ($count > 0)
		    		$queryfields .= " or ";
				$queryfields .= "field_id='" . $custtxt->f("id") . "'";
				$textvar[$custtxt->f("id")] = $custtxt->f("template_var");
	 			$textdesc[$custtxt->f("id")] = $custtxt->f("description");
	 			$textname[$custtxt->f("id")] = $custtxt->f("name");
				$count++;
			}
			$custtxt->seek();
			$queryfields .= ") and";
			
			while ($custtxt->next_record()){
				$Tpl->SetVar("tb_name", multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("tb_description", multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("tb_value", stripslashes($fieldvalues[$custtxt->f("id")]));
				$Tpl->SetVar("tb_var", "custtxt_box::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
				$Tpl->SetVar("tb_name_" . $custtxt->f("id"), multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("tb_description_" . $custtxt->f("id"), multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("tb_value_" . $custtxt->f("id"), stripslashes($fieldvalues[$custtxt->f("id")]));
				$Tpl->SetVar("tb_var_" . $custtxt->f("id"), "custtxt_box::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
				$Tpl->Parse("tb_Row",True);
			}
		    $Tpl->Parse("Custom_TextBox", True);
		}
		
		/////////////////////////////////////////////////////////////////
		//Custom DropDown Fields
		/////////////////////////////////////////////////////////////////

		$txtvar = "";
		$txtdesc = "";
		$txtname = "";
		$custtxtvalues = "";
		$custtxt = "";
		$fieldvalues = "";
		$optionlist = "";
		$checked = "";
		$selected = "";
		$Tpl->SetBlockVar("Custom_DropDown", "");
		$custtxt = new clsDBNetConnect;
		$custoptions = new clsDBNetConnect;
		$query = "select * from custom_dropdown where $cats and `searchable` = '1' and `style` = '1'";
		$custtxt->query($query);
		if ($custtxt->next_record()){
			$custtxt->seek();
			$queryfields = "(";
			$count = 0;

			while ($custtxt->next_record()){
				If ($count > 0)
				    $queryfields .= " or ";
				$query = "select * from custom_dropdown_options where field_id = '" . $custtxt->f("id") . "'";
				$custoptions->query($query);
				
				while ($custoptions->next_record()){
					$checked = "";
					if ($custoptions->f("id") == $selected[$custtxt->f("id")]){
						$checked = " selected ";
					}
					else{
			    		$checked = "";
					}
					$optionlist[$custtxt->f("id")][] = "<option value=\"" . $custoptions->f("id") . "\"$checked>" . $custoptions->f("option") . "</option>\n";
				}
				$queryfields .= "field_id='" . $custtxt->f("id") . "'";
				$textvar[$custtxt->f("id")] = $custtxt->f("template_var");
	 			$textdesc[$custtxt->f("id")] = $custtxt->f("description");
	 			$textname[$custtxt->f("id")] = $custtxt->f("name");
				$count++;
			}

			$custtxt->seek();
			$count = 0;
			while ($custtxt->next_record()){
				$i = 0;
				$builtoptions = "<option value=\"0\" selected>ANY</option>\n";
				while ($optionlist[$custtxt->f("id")][$i]){
					$builtoptions .= $optionlist[$custtxt->f("id")][$i];
					$i++;
				}

				$Tpl->SetVar("dd_name", multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("dd_description", multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("dd_var", "custddbox::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
		        $Tpl->SetVar("dropdown_Options", $builtoptions);
		        $Tpl->SetVar("dd_name_" . $custtxt->f("id"), multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("dd_description_" . $custtxt->f("id"), multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("dd_var_" . $custtxt->f("id"), "custddbox::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
		        $Tpl->SetVar("dropdown_Options_" . $custtxt->f("id"), $builtoptions);
		        $Tpl->Parse("dd_Row", True);
			}

		    $Tpl->Parse("Custom_DropDown", True);
		}
		
		//////////////////////////////////
		//Display Dropdown Boxes as CheckBoxes
		//////////////////////////////////
		
		$txtvar = "";
		$txtdesc = "";
		$txtname = "";
		$custtxtvalues = "";
		$custtxt = "";
		$fieldvalues = "";
		$optionlist = "";
		$checked = "";
		$selected = "";
		$Tpl->SetBlockVar("Custom_DropDown_As_Checkbox", "");
		$custtxt = new clsDBNetConnect;
		$custoptions = new clsDBNetConnect;
		$query = "select * from custom_dropdown where $cats and `searchable` = '1' and `style` = '2'";
		$custtxt->query($query);
		if ($custtxt->next_record()){
			$custtxt->seek();
			$queryfields = "(";
			$count = 0;

			while ($custtxt->next_record()){
				If ($count > 0)
				    $queryfields .= " or ";
				$query = "select * from custom_dropdown_options where field_id = '" . $custtxt->f("id") . "'";
				$custoptions->query($query);
				
				while ($custoptions->next_record()){
					$checked = "";
					if ($custoptions->f("id") == $selected[$custtxt->f("id")]){
						$checked = " checked ";
					}
					else{
			    		$checked = "";
					}
					$optionlist[$custtxt->f("id")][] = "<input type=\"checkbox\" name=\"" . "custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id") . "[]\" value=\"" . $custoptions->f("id") . "\"" . $checked . ">&nbsp;" . $custoptions->f("option");
				}
				$queryfields .= "field_id='" . $custtxt->f("id") . "'";
				$textvar[$custtxt->f("id")] = $custtxt->f("template_var");
	 			$textdesc[$custtxt->f("id")] = $custtxt->f("description");
	 			$textname[$custtxt->f("id")] = $custtxt->f("name");
				$count++;
			}

			$custtxt->seek();
			$count = 0;
			while ($custtxt->next_record()){
				$i = 0;
				$x = 0;
				$colspan = $custtxt->f("per_row")-1;
				$builtoptions = "<tr><td colspan=\"" . $colspan . "\"><input type=\"checkbox\" name=\"" . "custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id") . "[]\" value=\"0\">&nbsp;ANY</td></tr>";
				while ($optionlist[$custtxt->f("id")][$i]){
					$x++;
					$builtoptions .= "<td>" . $optionlist[$custtxt->f("id")][$i];
					$i++;
					if ($x == $custtxt->f("per_row")){
						$builtoptions .= "</td></tr>";
						$x = 0;
						if ($optionlist[$custtxt->f("id")][$i])
							$builtoptions .= "<td><tr>";
					}
					else
						$builtoptions .= "</td>";						
				}

				$Tpl->SetVar("dd_name", multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("dd_description", multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("dd_var", "custddbox::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
		        $Tpl->SetVar("dropdown_Options", $builtoptions);
		        $Tpl->SetVar("dd_name_" . $custtxt->f("id"), multiline($textname[$custtxt->f("id")]));
				$Tpl->SetVar("dd_description_" . $custtxt->f("id"), multiline($textdesc[$custtxt->f("id")]));
				$Tpl->SetVar("dd_var_" . $custtxt->f("id"), "custddbox::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id"));
		        $Tpl->SetVar("dropdown_Options_" . $custtxt->f("id"), $builtoptions);
		        $Tpl->Parse("ddcb_Row", True);
			}

		    $Tpl->Parse("Custom_DropDown_As_Checkbox", True);
		}
		//////////////////////////////////
		//End Custom Vars/////////////////
		//////////////////////////////////
		
		
//END CUSTOM FIELD BUILD CODE






//Show Page @1-C6DA985C
$Header->Show("Header");
$itemsSearch->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
