<?php
//BindEvents Method @1-7454E908
require_once("./authorizenet.class.php");
function BindEvents()
{
    global $charges1;
    $charges1->charge->CCSEvents["OnValidate"] = "charges1_charge_OnValidate";
}
//End BindEvents Method

function charges1_charge_OnValidate() { //charges1_charge_OnValidate @10-D55FB1E0

//Custom Code @22-2A29BDB7
global $charges1;
global $accounting;
global $regcharges;
global $finalamount;
$dba = new clsDBNetConnect;
$dba->connect();
$dba->query("SELECT * FROM users WHERE user_id='" . CCGetUserID() . "'");
$dbL = new clsDBNetConnect;
$dbL->connect();
while($dba->next_record())
{
      $clook = $dba->f("country_id");
      $city = $dba->f("city");
      $state = $dba->f("state_id");
      $addr = $dba->f("address1");
      $zip = $dba->f("zip");
      $usid = $dba->f("user_id");
      $email = $dba->f("email");
      $country = CCDLookUp("country_desc", "lookup_countries", "country_id='" . $clook . "'", $dbL);
}

$payment_config = array("method"=>"cc","login"=>$accounting["authorize"],"tran_key"=>$accounting["authorize_tran_key"], "currency_code"=>$regcharges["currencycode"]); 
$customer_info = array("first_name"=>$charges1->FirstName->GetValue(),
		       "last_name"=>$charges1->LastName->GetValue(),
	               "address"=>$addr,
                       "city"=>$city,
                       "state"=>$state,
                       "zip"=>$zip,
                       "country"=>$country,
                       "cust_id"=>$usid,
                       "email"=>$email);
$credit_card_info = array("card_num"=>$charges1->CCNumber->GetValue(), 
			  "exp_date"=>$charges1->ExpDate->GetValue(), 
			  "card_code"=>$charges1->CardCode->GetValue(),
			  "charge_type"=>"AUTH_CAPTURE");

$payment =& new payment_authorizenet($payment_config);
$payment->setCustomerIP($_SERVER["REMOTE_ADDR"]);
$payment->enableCustomerEmails(TRUE);
$payment->addCustomerInfo($customer_info, "billing");
$result = $payment->doPayment(rand(), "Classified Ad Listing Fee", $charges1->charge->GetValue(), "no", $credit_card_info);

if(!$result) {
	$result_code = $payment->response_code;    // 2 = declined, 3 = error
	if($result_code == 2){
        	$charges1->charge->Errors->addError("The Card has been declined. Please make sure the Name, CC Number, and Expiration date are correct.");
	}
	if($result_code == 3){
        	$charges1->charge->Errors->addError("There was an error trying to process your card. Please make sure the Name, CC Number, and Expiration date are correct.");
	}
}

$finalamount = $payment->x_amount;

//End Custom Code

} //Close charges1_charge_OnValidate @10-FCB6E20C



?>
