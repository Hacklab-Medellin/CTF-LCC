<?php
//BindEvents Method @1-A2F23582
function BindEvents()
{
    global $items;
    $items->CCSEvents["OnValidate"] = "items_OnValidate";
    global $items;
    $items->CCSEvents["AfterInsert"] = "items_AfterInsert";
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

function items_OnValidate() { //items_OnValidate @4-84873489

//Custom Code @33-2A29BDB7
//Validate Minimum Length @37-9F31AFB8
    global $items;
    if (strlen($items->title->GetValue()) < 5)
    {
        $items->title->Errors->addError("Your title must be atleast 5 characters long");
    }
//End Validate Minimum Length

//Validate Minimum Value @38-5DC7FCB3
    global $items;
    if (($items->category->GetValue() == 1) || ($items->category->GetValue() < 1) || ($items->category->GetValue() == ""))
    {
        $items->category->Errors->addError("Invalid category selection");
    }
//End Validate Minimum Value

//Validate Minimum Value @39-62603E15
    global $items;
    if (($items->quantity->GetValue() == "") || ($items->quantity->GetValue() < 1))
    {
        $items->quantity->Errors->addError("You must have atleast 1 item to sell");
    }
//End Validate Minimum Value

//Validate Minimum Value @40-76EFD938
    global $items;
    if (($items->image_one->GetValue() == "") && ($items->image_preview->GetValue() == 1))
    {
        $items->image_preview->Errors->addError("The image preview feature may only be used if an image is loaded into the first slot");
    }
    if ($items->description->GetValue() == "")
    {
         $items->description->Errors->addError("Your description cannot be empty");
    }
    if ($items->asking_price->GetValue() < 0)
    {
         $items->asking_price->Errors->addError("You have not specified a valid asking price. For no price, enter a 0. You inputed " . $items->asking_price->GetValue() . " in the field.");
    }
    
    if (($items->image_one->GetValue() == "") && ($items->gallery_featured->GetValue() == 1))
    {
        $items->gallery_featured->Errors->addError("The Gallery feature may only be used if an image is loaded into the first slot");
    }
//End Validate Minimum Value

//Custom Code @69-2A29BDB7
global $items;
    if (($items->image_one->GetValue() == "") && ($items->slide_show->GetValue() == 1))
    {
        $items->slide_show->Errors->addError("The slide show feature may only be used if an image is loaded into the first slot");
    }

//End Custom Code
//End Custom Code

} //Close items_OnValidate @4-FCB6E20C

function items_AfterInsert() { //items_AfterInsert @4-9CB79601

//Custom Code @34-2A29BDB7
global $finalItemNum;

//End Custom Code

} //Close items_AfterInsert @4-FCB6E20C

function Page_BeforeShow() { //Page_BeforeShow @1-66DC429C

//Custom Code @32-2A29BDB7
    global $Tpl;

	$finalcat = CCGetFromGet("finalcat","");
	$ItemNum = CCGetFromGet("Item_Number","");
	if (CCGetSession("RecentPreviewItem"))
      	$ItemNum = CCGetSession("RecentPreviewItem");
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

		$Tpl->SetBlockVar("Custom_TextArea", "");
        $custtxt = new clsDBNetConnect;
		$query = "select * from custom_textarea where $cats";
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
			if (!$_POST["closes"] && $_GET["Item_Number"]){
				$custtxtvalues = new clsDBNetConnect;
				$query = "select * from custom_textarea_values where $queryfields ItemNum=" . $ItemNum;
				$custtxtvalues->query($query);
				while ($custtxtvalues->next_record()){
					$fieldvalues[$custtxtvalues->f("field_id")] = $custtxtvalues->f("value");
				}
			}
			if ($_POST && !$_GET["Item_Number"]){
				$custtxt->seek();
				while ($custtxt->next_record()){
					$fieldvalues[$custtxt->f("id")] = $_POST["custtxt_area::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id")];
				}
			}

			$custtxt->seek();
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
		$query = "select * from custom_textbox where $cats";
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
			if ($_GET["Item_Number"] && !$_POST["closes"]){
				$custtxtvalues = new clsDBNetConnect;
				$query = "select * from custom_textbox_values where $queryfields ItemNum=" . $ItemNum;
				$custtxtvalues->query($query);
				while ($custtxtvalues->next_record()){
					$fieldvalues[$custtxtvalues->f("field_id")] = $custtxtvalues->f("value");
				}
			}

			if ($_POST && !$_GET["Item_Number"]){
				$custtxt->seek();
				while ($custtxt->next_record()){
					$fieldvalues[$custtxt->f("id")] = $_POST["custtxt_box::" . $textvar[$custtxt->f("id")] . "::" . $custtxt->f("id")];
				}
			}

			$custtxt->seek();
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
		$query = "select * from custom_dropdown where $cats";
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
				if ($_GET["Item_Number"] && !$_POST["custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id")]){
					$dvalue = new clsDBNetConnect;
				    $query = "select * from custom_dropdown_values where ItemNum = $ItemNum and field_id = " . $custtxt->f("id");
				    $dvalue->query($query);
		    		if ($dvalue->next_record()){
		    			$selected[$custtxt->f("id")] = $dvalue->f("option_id");
		    		}
		    		else {
		    			$selected[$custtxt->f("id")] = "default";
		    		}
				}
				elseif($_POST["custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id")]) {
					$selected[$custtxt->f("id")] = $_POST["custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id")];
				}
				while ($custoptions->next_record()){
					$checked = "";
					if ((!$_GET["Item_Number"] && !$_POST["custddbox::" . $custtxt->f("template_var") . "::" . $custtxt->f("id")] && $custoptions->f("default") == 1) || ($custoptions->f("default") == 1 && $selected[$custtxt->f("id")] == "default")) {
			    		$checked = " selected ";
					}
					elseif ($custoptions->f("id") == $selected[$custtxt->f("id")]){
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
				$builtoptions = "";
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
		//End Custom Vars/////////////////
		//////////////////////////////////
        
global $regcharges;
        $sql = "SELECT * FROM categories WHERE sub_cat_id > '0' ORDER BY weight, name";
        $db = new clsDBNetConnect();
        $db->connect();
        $db->query($sql);
          while($db->next_record())
        {
                $catid = $db->f(0);
                $subid = $db->f(1);
                $name = $db->f(2);
                if($subid == 1)
                {
                        $inis .= "<OPTION value=\"" . $catid . "\">" . $name . "</OPTION>";
                }
                $dsper .= "catlist[" . $catid . "] = new Array(" . $subid . " , \"" . $name . "\");\r\n";
        }
        $closestCat = getparents($_GET["finalcat"]);
        if (!$closestCat)
            $closestCat = 1;
	  $db2 = new clsDBNetConnect;
	  $db2->connect();
	  $db2->query("SELECT * FROM lookup_listing_dates WHERE charge_for='1' and cat_id=$closestCat");
	  $dayfees = "";
	  while($db2->next_record())
	  {
	  	$dayfees = $dayfees . $db2->f("days") . " Days - <font color='red'>" . $regcharges["currency"] . $db2->f("fee") . "</font><br>";
	  }
        $Tpl->SetVar("cats", $dsper);
        $Tpl->SetVar("catbuild", $inis);
	  $Tpl->SetVar("dayfees", $dayfees);
                unset($db);
//End Custom Code

} //Close Page_BeforeShow @1-FCB6E20C
?>