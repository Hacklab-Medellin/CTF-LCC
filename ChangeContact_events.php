<?php
//BindEvents Method @1-DC1E3FB0
function BindEvents()
{
    global $users;
    $users->address1->CCSEvents["OnValidate"] = "users_address1_OnValidate";
    global $users;
    $users->city->CCSEvents["OnValidate"] = "users_city_OnValidate";
}
//End BindEvents Method

function users_address1_OnValidate() { //users_address1_OnValidate @12-2226C39F

//Validate Minimum Length @21-29FBCE6F
    global $users;
    if (strlen($users->address1->GetText()) < 4)
    {
        $users->address1->Errors->addError("Your address must be atleast 4 characters long");
    }
//End Validate Minimum Length

} //Close users_address1_OnValidate @12-FCB6E20C

function users_city_OnValidate() { //users_city_OnValidate @14-E4D45B15

//Validate Minimum Length @22-683E0FFF
    global $users;
    if (strlen($users->city->GetText()) < 2)
    {
        $users->city->Errors->addError("Your city must be atleast 2 characters long");
    }
//End Validate Minimum Length

} //Close users_city_OnValidate @14-FCB6E20C


?>