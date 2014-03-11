<?php
//BindEvents Method @1-6C250052
function BindEvents()
{
    global $users;
    $users->user_password->CCSEvents["OnValidate"] = "users_user_password_OnValidate";
    global $users;
    $users->user_password2->CCSEvents["OnValidate"] = "users_user_password2_OnValidate";
}
//End BindEvents Method

function users_user_password_OnValidate() { //users_user_password_OnValidate @8-457C3F73

//Custom Code @14-2A29BDB7
global $users;
        if (strlen($users->user_password->GetText()) < 4)
    {
        $users->user_password->Errors->addError("Your password must be atleast 4 characters long");
    }
        if($users->user_password->Value != $users->user_password2->Value)
          {
        $users->user_password->Errors->addError("The confirmation password does not equal the first password");
    }
//End Custom Code

} //Close users_user_password_OnValidate @8-FCB6E20C

function users_user_password2_OnValidate() { //users_user_password2_OnValidate @9-E17C9084

//Custom Code @15-2A29BDB7
        global $users;
        if (strlen($users->user_password2->GetText()) < 4)
    {
        $users->user_password2->Errors->addError("Your password must be atleast 4 characters long");
    }
//End Custom Code

} //Close users_user_password2_OnValidate @9-FCB6E20C

//DEL
//DEL          if (strlen($users->user_password2->GetText()) < 4)
//DEL      {
//DEL          $users->user_password->Errors->addError("Your password must be atleast 4 characters long");
//DEL      }
//DEL            if($users->user_password->Value != $users->user_password2->Value)
//DEL            {
//DEL          $users->user_password->Errors->addError("The confirmation password does not equal the first password");
//DEL      }



?>