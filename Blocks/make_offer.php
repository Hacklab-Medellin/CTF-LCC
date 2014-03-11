<?

class clsGriditems3 { //items1 class @19-239DFDFA

//Variables @19-9AD3C4FA

    // Public variables
    var $ComponentName;
    var $Visible; var $Errors;
    var $ds; var $PageSize;
    var $SorterName = "";
    var $SorterDirection = "";
    var $PageNumber;

    var $CCSEvents = "";
    var $CCSEventResult;

    // Grid Controls
    var $StaticControls; var $RowControls;
//End Variables

//Class_Initialize Event @19-23CAD8F7
    function clsGriditems3()
    {
        global $FileName;
        global $now;
        $this->ComponentName = "items3";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitems3DataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = $now["frontentrys"];
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->background = new clsControl(ccsLabel, "background", "background", ccsInteger, "", CCGetRequestParam("background", ccsGet));
        $this->background->HTML = true;
        $this->bold2 = new clsControl(ccsLabel, "bold2", "bold2", ccsText, "", CCGetRequestParam("bold2", ccsGet));
        $this->bold2->HTML = true;
        $this->image_preview = new clsControl(ccsLabel, "image_preview", "image_preview", ccsInteger, "", CCGetRequestParam("image_preview", ccsGet));
        $this->image_preview->HTML = true;
        $this->image_one = new clsControl(ccsLabel, "image_one", "image_one", ccsText, "", CCGetRequestParam("image_one", ccsGet));
        $this->image_one->HTML = true;
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->bold = new clsControl(ccsLabel, "bold", "bold", ccsInteger, "", CCGetRequestParam("bold", ccsGet));
        $this->bold->HTML = true;
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->make_offer = new clsControl(ccsLabel, "make_offer", "make_offer", ccsInteger, "", CCGetRequestParam("make_offer", ccsGet));
        $this->make_offer->HTML = true;
        $this->city_town = new clsControl(ccsLabel, "city_town", "city_town", ccsText, "", CCGetRequestParam("city_town", ccsGet));
        $this->state_province = new clsControl(ccsLabel, "state_province", "state_province", ccsText, "", CCGetRequestParam("state_province", ccsGet));
        $this->started = new clsControl(ccsLabel, "started", "started", ccsInteger, "", CCGetRequestParam("started", ccsGet));
        $this->asking_price = new clsControl(ccsLabel, "asking_price", "asking_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", ccsGet));
    }
//End Class_Initialize Event

//Initialize Method @19-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @19-3C748704
    function Show()
    {
        global $Tpl;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Prepare();
        $this->ds->Open();

        $GridBlock = "Grid " . $this->ComponentName;
        $Tpl->block_path = $GridBlock;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        $is_next_record = $this->ds->next_record();
        if($is_next_record && $ShownRecords < $this->PageSize)
        {
            do {
                    $this->ds->SetValues();
                $Tpl->block_path = $GridBlock . "/Row";
                if($this->ds->bold->GetValue() == 1){
                                        $this->bold2->SetValue("</b>");
                        $this->bold->SetValue("<b>");
                                } else {
                                        $this->bold2->SetValue("");
                        $this->bold->SetValue("");
                                }
                                if($this->ds->background->GetValue() == 1){
                                      $this->background->SetValue("bgcolor=\"#FFFFC0\"");
                                }
                                // else{
                                //        $this->background->SetValue("bgcolor=\"#FFFFFF\"");
                                //}
                                if($this->ds->image_one->GetValue() != ""){
                                        $this->image_preview->SetValue("<img src=\"images/apic.gif\">");
                                } else {
                                        $this->image_preview->SetValue("");
                                }
                                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                if($this->ds->make_offer->GetValue() == 1){
                                        $this->make_offer->SetValue("&nbsp;<font color=#ff0000>(Make Offer)</font>");
                                } else {
                                        $this->make_offer->SetValue("");
                                }
                                if($this->ds->city_town->GetValue() != ""){
                        $this->city_town->SetValue($this->ds->city_town->GetValue() . ", ");
                } else {
                                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                                }
                                $this->state_province->SetValue($this->ds->state_province->GetValue());
                $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                $theday = getdate($this->ds->started->GetValue());
                                //$theday = getdate($itemvars["closes"]);
                        $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->started->SetValue("");
                                unset($newdate);
                                unset($theday);
                                unset($lastofyear);
                                unset($enddate);
                            $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->background->Show();
                $this->image_preview->Show();
                $this->ItemNum->Show();
                $this->bold->Show();
                                $this->bold2->Show();
                $this->title->Show();
                $this->make_offer->Show();
                $this->city_town->Show();
                $this->state_province->Show();
                $this->asking_price->Show();
                $this->started->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }

        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End items3 Class @19-FCB6E20C

class clsitems3DataSource extends clsDBNetConnect {  //items3DataSource Class @19-30AAB679

//Variables @19-B3BBC84E
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $background;
    var $image_preview;
    var $image_one;
    var $ItemNum;
    var $bold;
    var $title;
    var $make_offer;
    var $city_town;
    var $state_province;
    var $started;
    var $asking_price;
//End Variables

//Class_Initialize Event @19-8E1DC958
    function clsitems3DataSource()
    {
        $this->Initialize();
        $this->background = new clsField("background", ccsInteger, "");
        $this->image_preview = new clsField("image_preview", ccsInteger, "");
        $this->image_one = new clsField("image_one", ccsText, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->bold = new clsField("bold", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->make_offer = new clsField("make_offer", ccsInteger, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state_province = new clsField("state_province", ccsText, "");
        $this->started = new clsField("started", ccsInteger, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");

    }
//End Class_Initialize Event

//SetOrder Method @19-8661118A
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "rand() LIMIT 3";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            "");
    }
//End SetOrder Method

//Prepare Method @19-98194D48
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->Criterion[1] = "status='1'";
        $this->wp->Criterion[2] = "make_offer='1'";
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @19-368AA817
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM items";
        $this->SQL = "SELECT *  " .
        "FROM items";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @19-27A8A7CF
    function SetValues()
    {
        $this->background->SetDBValue($this->f("background"));
        $this->image_preview->SetDBValue($this->f("image_preview"));
        $this->image_one->SetDBValue($this->f("image_one"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->bold->SetDBValue($this->f("bold"));
        $this->title->SetDBValue($this->f("title"));
        $this->make_offer->SetDBValue($this->f("make_offer"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state_province->SetDBValue($this->f("state_province"));
        $this->started->SetDBValue($this->f("started"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
    }
//End SetValues Method

}
?>