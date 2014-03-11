<?php
//BindEvents Method @1-397EAC53
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";
}
//End BindEvents Method

function Page_AfterInitialize() { //Page_AfterInitialize @1-56434BCA

//Logout @4-676B5201
    if(strlen(CCGetParam("Logout", ""))) 
    {
        CCLogoutUser();
        global $Redirect;
        $Redirect = "Logout.php";
    }
//End Logout

//Logout @10-676B5201
    if(strlen(CCGetParam("Logout", ""))) 
    {
        CCLogoutUser();
        global $Redirect;
        $Redirect = "Logout.php";
    }
//End Logout

} //Close Page_AfterInitialize @1-FCB6E20C


?>
