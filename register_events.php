<?php
//BindEvents Method @1-FAE695FA
function BindEvents()
{
    global $users;
    $users->CCSEvents["OnValidate"] = "users_OnValidate";
    global $users;
    $users->CCSEvents["AfterInsert"] = "users_AfterInsert";
}
//End BindEvents Method

function users_OnValidate() { //users_OnValidate @4-FEEF4C24

//Custom Code @33-2A29BDB7
//Validate Maximum Length @40-6FEE40B6
    global $users;
    if (strlen($users->user_login->GetValue()) > 15)
    {
        $users->user_login->Errors->addError("The username must be 15 characters or less");
    }
//End Validate Maximum Length

//Validate Age @40-6FEE40B6
	global $now;
	if ($now["bounceout"]) {
    global $users;
    if ($users->age->GetValue() == 0)
    {
        $users->age->Errors->addError("You must select an age group");
    }
   }
//End Validate Maximum Length

//Validate Minimum Length @41-24A023E7
    global $users;
    if (strlen($users->user_login->GetValue()) < 3)
    {
        $users->user_login->Errors->addError("The username must be atleast 3 characters long");
    }
//End Validate Minimum Length

//Validate Email @42-AF610AF2
    global $users;
    if (strlen($users->email->GetValue()) && !preg_match("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/",$users->email->Text))
    {
        $users->email->Errors->addError("Please enter a valid email address");
    }
//End Validate Email

//Validate Minimum Length @43-A4944465
    global $users;
    if (strlen($users->address1->GetValue()) < 3)
    {
        $users->address1->Errors->addError("The address must be atleast 3 characters long");
    }
//End Validate Minimum Length

//Validate Required Value @39-249BE035
    global $users;



/*



    if ($users->agreement_id->Text != "1")
    {
        $users->agreement_id->Errors->addError("You must agree to the terms and conditions in order to register");
    }



*/



//End Validate Required Value
//End Custom Code

} //Close users_OnValidate @4-FCB6E20C

function users_AfterInsert() { //users_AfterInsert @4-34AA212C

//Custom Code @34-2A29BDB7
        global $users;
        global $now;
        global $NewPass;
        global $EP;
        global $Give_New_Credit;
        global $Give_Amount;
		global $Give_Tokens;
        global $Give_Cause;

        $lookdb = new clsDBNetConnect;
                $lookdb->connect();
                $lookdb->query("SELECT * FROM users WHERE user_login='" . $users->user_login->Value . "'");
                if($lookdb->next_record()) {
                        $ld = array(
                        "first" => $lookdb->f("first_name"),
                        "ID" => $lookdb->f("user_id"),
                        "user_password" => $lookdb->f("user_password"),
                        "last" => $lookdb->f("last_name"),
                        "email" => $lookdb->f("email"),
                        "address" => $lookdb->f("address1"),
                        "address2" => $lookdb->f("address2"),
                        "state" => $lookdb->f("state_id"),
                        "zip" => $lookdb->f("zip"),
                        "city" => $lookdb->f("city"),
                        "phonedy" => $lookdb->f("phone_day"),
                        "phoneevn" => $lookdb->f("phone_evn"),
                        "fax" => $lookdb->f("fax"),
                        "ip" => $lookdb->f("ip_insert"),
                        "date_created" => $lookdb->f("date_created")
				);
                }
        CCSetSession("RecentUserSign", $users->user_login->Value);
        CCSetSession("RecentUserEmail", $users->email->Value);
        $EP["EMAIL:CURRENT_USERNAME"] = $users->user_login->Value;
        $EP["EMAIL:CURRENT_USERID"] = $ld["ID"];
        $EP["EMAIL:CURRENT_USER_PASSWORD"] = $ld["user_password"];
        $EP["EMAIL:CURRENT_USER_FIRST_NAME"] = $ld["first"];
        $EP["EMAIL:CURRENT_USER_LAST_NAME"] = $ld["last"];
        $EP["EMAIL:CURRENT_USER_EMAIL"] = $ld["email"];
        $EP["EMAIL:CURRENT_USER_ADDRESS"] = $ld["address"];
        $EP["EMAIL:CURRENT_USER_ADDRESS2"] = $ld["address2"];
        $EP["EMAIL:CURRENT_USER_STATE"] = $ld["state"];
        $EP["EMAIL:CURRENT_USER_CITY"] = $ld["city"];
        $EP["EMAIL:CURRENT_USER_ZIP"] = $ld["zip"];
        $EP["EMAIL:CURRENT_USER_DAY_PHONE"] = $ld["phonedy"];
        $EP["EMAIL:CURRENT_USER_EVN_PHONE"] = $ld["phoneevn"];
        $EP["EMAIL:CURRENT_USER_FAX"] = $ld["fax"];
        $EP["EMAIL:CURRENT_USER_IP"] = getenv("REMOTE_ADDR");
        $EP["EMAIL:CURRENT_USER__REGISTERED_IP"] = $ld["ip"];
        $EP["EMAIL:CURRENT_USER_DATE_SIGNEDUP"] = date("F j, Y, g:i a", $ld["date_created"]);
		
        mailout("NewRegistration", $now["notify"], $ld["ID"], 1000000000, time(), $EP);
        if($Give_New_Credit==1)
        {
          $gdb = new clsDBNetConnect;
          $gdb->connect();
          if ($Give_Amount){
          	$SQL = "INSERT INTO charges(user_id, date, cause, charge) VALUES ('" . $ld["ID"] . "', '" . time() . "', '" . $Give_Cause . "', '" . $Give_Amount . "')";
          	$gdb->query($SQL);
          }
          if ($Give_Tokens){
          	$SQL = "update users set tokens = '" . $Give_Tokens . "' where user_id = '" . $ld["ID"] . "'";
          	$gdb->query($SQL);
          }
        }
//End Send Email
//End Custom Code

} //Close users_AfterInsert @4-FCB6E20C



?>
