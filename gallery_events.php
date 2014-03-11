<?php
//BindEvents Method @1-7B33276C
function BindEvents()
{
    global $items;
    $items->CCSEvents["BeforeShow"] = "items_BeforeShow";
}
//End BindEvents Method

function items_BeforeShow() { //items_BeforeShow @4-10DCF469

//Set Tag @17-2B3E26A5
    global $Tpl;
    $Tpl->SetVar("cat_id_in", CCGetFromGet("CatID",""));
//End Set Tag

} //Close items_BeforeShow @4-FCB6E20C


?>