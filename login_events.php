<?php
//BindEvents Method @1-9D2936A0

function BindEvents()

{

    global $Login;

    $Login->DoLogin->CCSEvents["OnClick"] = "Login_DoLogin_OnClick";

    global $CCSEvents;

    $CCSEvents["AfterInitialize"] = "Page_AfterInitialize";

}

//End BindEvents Method



function Login_DoLogin_OnClick() { //Login_DoLogin_OnClick @3-AFF8EBF1



//Login @4-1C5B8B18

    global $Login;

    if(!CCLoginUser($Login->login->Value, $Login->password->Value))

    {

        $Login->Errors->addError("Login or Password is incorrect.");

        $Login->password->SetValue("");

        return false;

    }
    else
    {


        global $Redirect;

        if(CCGetGroupID() == 0)
        {
                 $Login->Errors->addError("Your account is currently on hold.");
                 $Login->password->SetValue("");
                 CCLogoutUser();
                 return false;
        }
        elseif(CCGetGroupID() == 3)
        {
                 $Login->Errors->addError("Your account has been suspended.");
                 $Login->password->SetValue("");
                 CCLogoutUser();
                 return false;
        }
        else
        {
        $Redirect = CCGetParam("ret_link", $Redirect);

        return true;
        }

    }

//End Login



} //Close Login_DoLogin_OnClick @3-FCB6E20C



function Page_AfterInitialize() { //Page_AfterInitialize @1-56434BCA



//Logout @9-EC13F9E1

    if(strlen(CCGetParam("Logout", "")))

    {

        CCLogoutUser();

        global $Redirect;

        $Redirect = "login.php";

    }

//End Logout



} //Close Page_AfterInitialize @1-FCB6E20C







?>