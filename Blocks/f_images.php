<?
class clsGriditems { //items class @8-DDF99D24

//Variables @8-9AD3C4FA

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

//Class_Initialize Event @8-6FC17898
    function clsGriditems()
    {
        global $FileName;
        $this->ComponentName = "items";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clsitemsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 4;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->image_preview = new clsControl(ccsLabel, "image_preview", "image_preview", ccsInteger, "", CCGetRequestParam("image_preview", ccsGet));
        $this->image_preview->HTML = true;
        $this->image_one = new clsControl(ccsLabel, "image_one", "image_one", ccsText, "", CCGetRequestParam("image_one", ccsGet));
        $this->image_one->HTML = true;
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->title = new clsControl(ccsLabel, "title", "title", ccsText, "", CCGetRequestParam("title", ccsGet));
        $this->asking_price = new clsControl(ccsLabel, "asking_price", "asking_price", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("asking_price", ccsGet));
        $this->city_town = new clsControl(ccsLabel, "city_town", "city_town", ccsText, "", CCGetRequestParam("city_town", ccsGet));
        $this->state_province = new clsControl(ccsLabel, "state_province", "state_province", ccsText, "", CCGetRequestParam("state_province", ccsGet));
    }
//End Class_Initialize Event

//Initialize Method @8-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @8-8C1DD5D3
    function Show()
    {
        global $Tpl;
        global $now;
                global $plugins;
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
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                $this->title->SetValue($this->ds->title->GetValue());
                if($this->ds->image_preview->GetValue() == 1 && $this->ds->image_one->GetValue() != ""){
                	                    if ($now["has_gd"])
                	                    $this->image_preview->SetValue("<table bgcolor=\"#000000\" border=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\" border=\"6\"><img src=\"imageresizer.php?heightsize=75&widthsize=75&filename=". $this->ds->image_one->GetValue()."\" border=0 /></a></td></tr></table>");
                	                    else
                                        $this->image_preview->SetValue("<table bgcolor=\"#000000\" border=\"0\"><tr><td width=\"75\" height=\"75\" valign=\"middle\" align=\"center\" bgcolor=\"#FFFFFF\"><a href=\"ViewItem.php?ItemNum=" . $this->ds->ItemNum->GetValue() . "\" border=\"6\">" . thumbnail($this->ds->image_one->GetValue(),75,75,0,0) . "</a></td></tr></table>");
                                } elseif($this->ds->image_one->GetValue() != ""){
                                        $this->image_preview->SetValue("<img src=\"images/apic.gif\">");
                                } else {
                                        $this->image_preview->SetValue("");
                                }
                                if($this->ds->city_town->GetValue() != ""){
                        $this->city_town->SetValue($this->ds->city_town->GetValue() . ", ");
                } else {
                                        $this->city_town->SetValue($this->ds->city_town->GetValue());
                                }
                                $this->asking_price->SetValue($this->ds->asking_price->GetValue());
                $this->state_province->SetValue($this->ds->state_province->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->ItemNum->Show();
                $this->title->Show();
                $this->image_preview->Show();
                $this->asking_price->Show();
                $this->city_town->Show();
                $this->state_province->Show();
                $Tpl->block_path = $GridBlock;
                $Tpl->parse("Row", true);
                $ShownRecords++;
                $is_next_record = $this->ds->next_record();

                // Parse Separator
                if($is_next_record && $ShownRecords < $this->PageSize)
                    $Tpl->parseto("Separator", true, "Row");
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

} //End items Class @8-FCB6E20C

class clsitemsDataSource extends clsDBNetConnect {  //itemsDataSource Class @8-585CFEF7

//Variables @8-8493567C
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $image_preview;
    var $image_one;
    var $ItemNum;
    var $title;
    var $asking_price;
    var $city_town;
    var $state_province;
//End Variables

//Class_Initialize Event @8-FB821147
    function clsitemsDataSource()
    {
        $this->Initialize();
        $this->image_preview = new clsField("image_preview", ccsInteger, "");
        $this->image_one = new clsField("image_one", ccsText, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->title = new clsField("title", ccsText, "");
        $this->asking_price = new clsField("asking_price", ccsFloat, "");
        $this->city_town = new clsField("city_town", ccsText, "");
        $this->state_province = new clsField("state_province", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @8-A41D3EBB
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "rand() LIMIT 4";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            "");
    }
//End SetOrder Method

//Prepare Method @8-BBC57120
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->Criterion[1] = "status='1'";
        $this->wp->Criterion[2] = "home_featured='1'";
        $this->wp->Criterion[3] = "image_preview='1'";
        $this->wp->AssembledWhere = $this->wp->opAND(false, $this->wp->opAND(false, $this->wp->Criterion[1], $this->wp->Criterion[2]), $this->wp->Criterion[3]);
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @8-368AA817
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

//SetValues Method @8-1A53CF05
    function SetValues()
    {
        $this->image_preview->SetDBValue($this->f("image_preview"));
        $this->image_one->SetDBValue($this->f("image_one"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->title->SetDBValue($this->f("title"));
        $this->asking_price->SetDBValue($this->f("asking_price"));
        $this->city_town->SetDBValue($this->f("city_town"));
        $this->state_province->SetDBValue($this->f("state_province"));
    }
//End SetValues Method

} 
?>