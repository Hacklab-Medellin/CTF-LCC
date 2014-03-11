<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

function Page_BeforeShow() { //Page_BeforeShow @1-66DC429C

//Set Tag @4-E60AFC09
    global $Tpl;
    $userlog = CCGetSession("RecentUserSign");
        $userem = CCGetSession("RecentUserEmail");
        $Tpl->SetVar("userlogin", $userlog);
        $Tpl->SetVar("useremail", $userem);
        CCSetSession("RecentUserSign", "");
        CCSetSession("RecentUserEmail", "");
//End Set Tag

} //Close Page_BeforeShow @1-FCB6E20C


?>