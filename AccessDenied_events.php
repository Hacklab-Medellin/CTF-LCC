<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

function Page_BeforeShow() { //Page_BeforeShow @1-66DC429C

//Set Tag @4-6DC9F5CF
    global $Tpl;
        global $REMOTE_ADDR;
    $Tpl->SetVar("userip", $REMOTE_ADDR);
//End Set Tag

} //Close Page_BeforeShow @1-FCB6E20C


?>