<?php

function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}

function Page_BeforeShow() {

    global $Tpl;
   
}

function buynowPayPal($ItemNum) {
	
	global $Tpl;
	global $EP;
    
    $Tpl->SetBlockVar("Confirm_PayPal", "");
    $iteminfo = new clsDBNetConnect;
    
	$query = "Select * from items where ItemNum=$ItemNum";
	$iteminfo->query($query);
	$iteminfo->next_record();
		$sellerid = $iteminfo->f("user_id");
    
    $sellerinfo = new clsDBNetConnect;
    
    $query = "select first_name, last_name, email, user_login from users where user_id=$sellerid";
    $sellerinfo->query($query);
    $sellerinfo->next_record();
		
	$userinfo = new clsDBNetConnect;
    
    $from_user_id = CCGetSession("UserID");
    $query = "select first_name, last_name, email, user_login from users where user_id=$from_user_id";
    $userinfo->query($query);
    $userinfo->next_record();
	$shipoption = 1;
	while ($iteminfo->f("ship" . $shipoption) != ""){
		if ($shipoption == 1)
			$Tpl->setVar("checked", "checked");
		else
			$Tpl->setVar("checked", "");
		if ($iteminfo->f("shipfee" . $shipoption) == 0 || $iteminfo->f("shipfee" . $shipoption) == "")
		    $price = "0.00";
		else
		    $price = $iteminfo->f("shipfee" . $shipoption);
		$Tpl->setVar("method", $iteminfo->f("ship" . $shipoption));
		$Tpl->setVar("option", $shipoption);
		$Tpl->setVar("price", "$" . $price);
        $Tpl->Parse("Row",True);
		$shipoption++;
	}
	if (!$iteminfo->f("ship1")) {
		$Tpl->setVar("method", "No Shipping Specified");
		$Tpl->setVar("option", "999999");
		$Tpl->setVar("price", "$" . "0.00");
		$Tpl->setVar("checked", "checked");
		$Tpl->Parse("Row",True);
	}
	
	$Tpl->setVar("ItemNum", $ItemNum);
	$Tpl->setVar("title", $iteminfo->f("title"));
	$Tpl->setVar("asking_price", $iteminfo->f("asking_price"));
    $Tpl->Parse("Confirm_PayPal", True);

}
?>
