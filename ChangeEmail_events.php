<?php
//BindEvents Method @1-86BDD7F6
function BindEvents()
{
    global $users;
    $users->email->CCSEvents["OnValidate"] = "users_email_OnValidate";
}
//End BindEvents Method

function users_email_OnValidate() { //users_email_OnValidate @8-B54A97B0

//Validate Email @9-D8A15481
    global $users;
    if (strlen($users->email->GetText()) && !preg_match("/^[\w\.-]{1,}\@([\da-zA-Z-]{1,}\.){1,}[\da-zA-Z-]+$/", $users->email->GetText()))
    {
        $users->email->Errors->addError("The email address is invalid");
    }
//End Validate Email

} //Close users_email_OnValidate @8-FCB6E20C


?>