<?php
//BindEvents Method @1-86BDD7F6
function BindEvents()
{
    global $users;
    $users->email->CCSEvents["OnValidate"] = "users_email_OnValidate";
}
//End BindEvents Method

function users_coupons_OnValidate() { //users_email_OnValidate @8-B54A97B0

} 


?>
