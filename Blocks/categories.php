<?
class clsGridcategories { //categories class @4-3B8F933E

//Variables @4-9AD3C4FA

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

//Class_Initialize Event @4-5895D9BF
    function clsGridcategories()
    {
        global $FileName;
        $this->ComponentName = "categories";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscategoriesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 100;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));

        $this->cat_id = new clsControl(ccsLabel, "cat_id", "cat_id", ccsInteger, "", CCGetRequestParam("cat_id", ccsGet));
        $this->name = new clsControl(ccsLabel, "name", "name", ccsText, "", CCGetRequestParam("name", ccsGet));
    }
//End Class_Initialize Event

//Initialize Method @4-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @4-C33B65DE
    function Show()
    {
        global $Tpl;
        global $itemcatcounts;
        global $admingroup;
        
        if(!$this->Visible) return;

        if ($admingroup){
        	$EditCSS = "
<link rel=\"stylesheet\" type=\"text/css\" href=\"./edit-inplace/lists.css\"/>
<style type=\"text/css\"><!--

.view:hover {
	background-color: #ffffcc;
}
.view, .inplace {
	font-size: 10px;
	font-family: Verdana;
}

.inplace {
	position: absolute;
	visibility: hidden;
	z-index: 10000;
}
.inplace {
	background-color: #ffffcc;
}

#categorylists td {
	width: 9em;
	margin-right: 20px; 
	padding: 0px 20px;
	vertical-align: top;
}
#categorylists th {
	vertical-align: bottom;
	font-weight: normal;
	font-size: 10px;
	padding-top: 20px;
}
#categorylists td.caption {
	font-size: 10px;
	text-align: center;
}
#categorylists li {
	padding: 0px;
	min-height: 1em;
	width: 120px;
}
#categorylists li .view {
	vertical-align: middle;
	padding: 2px;
}
#categorylists input.inplace {
	width: 120px;
	max-width: 120px;
}

/* BugFix: Firefox: avoid bottom margin on draggable elements */
#categorylists #cat_li, #categorylists { margin-top: -2px; }
#categorylists #cat_li li, #categorylists { margin-top: 4px; }

#categorylists #cat_li li { cursor: default; }
#categorylists #cat_li .handle,
{
	float: right;
	background-image: url(./edit-inplace/handle.png);
	background-repeat: repeat-y;
	width: 7px;
	height: 20px;
}
#categorylists #cat_li li .view {
	cursor: text;
}
#categorylists #cat_liEditors input.inplace, #categorylists {
	width: 104px;
	max-width: 104px;
}
#categorylists #cat_liEditors>input.inplace, #categorylists {
	width: 111px;
	max-width: 111px;
}

.inplace {
	margin: 0px;
	padding-left: 1px;
}
.handle {
	cursor: move;
}
.inspector {
	font-size: 10px;
}
--></style>
";
        	$EditJS = "window.onload = function() {
	dragsort.makeListSortable(document.getElementById(\"cat_li\"), setHandle)\n";
        	$OpenEditListEditor = "<form name=\"categories\" action=\"index.php\" method=\"POST\"><input class=\"inspector\" type=\"submit\" value=\"Save Changes\" name=\"SaveChanges\" onclick=\"return saveOrder('cat_li')\"/><div id=\"cat_liEditors\"><input type=\"hidden\" name=\"order\" value=\"\" id=\"catorder\">";
        	$OpenEditList = "<ul id=\"cat_li\" class=\"sortable boxy\">";
        }
        
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
            		if ($admingroup){
            		   	$this->ds->SetValues();
                		$Tpl->block_path = $GridBlock . "/EditRow";
                		$this->cat_id->SetValue($this->ds->cat_id->GetValue());
                		$this->name->SetValue($this->ds->name->GetValue());
                		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                		$this->cat_id->Show();
                		$this->name->Show();
                		$Tpl->SetVar("Count", "(" . $itemcatcounts[$this->ds->cat_id->GetValue()] . ")");
                		$Tpl->SetVar("","");
                		$OpenEditListEditor .= "<input id=\"cat_" . $this->ds->cat_id->GetValue() . "_Edit\" name=\"cat_" . $this->ds->cat_id->GetValue() . "_Edit\" class=\"inplace\" tabindex=\"10\"/>";
                		$EditJS .= "join(\"cat_" . $this->ds->cat_id->GetValue() . "_\", true)\n";
                		$Tpl->block_path = $GridBlock;
                		$Tpl->parse("EditRow", true);
                		$ShownRecords++;
                		$is_next_record = $this->ds->next_record();
            		} else {
            			$this->ds->SetValues();
                		$Tpl->block_path = $GridBlock . "/Row";
                		$this->cat_id->SetValue($this->ds->cat_id->GetValue());
                		$this->name->SetValue($this->ds->name->GetValue());
                		$this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                		$this->cat_id->Show();
                		$this->name->Show();
                		$Tpl->SetVar("Count", "(" . $itemcatcounts[$this->ds->cat_id->GetValue()] . ")");
                		$Tpl->block_path = $GridBlock;
                		$Tpl->parse("Row", true);
                		$ShownRecords++;
                		$is_next_record = $this->ds->next_record();
            		}
            } while ($is_next_record && $ShownRecords < $this->PageSize);
        }
        else // Show NoRecords block if no records are found
        {
            $Tpl->parse("NoRecords", false);
        }
		if ($admingroup){
			$Tpl->SetVar("OpenEditList",$OpenEditList);
			$Tpl->SetVar("CloseEditList","</ul>");
			$Tpl->SetVar("OpenEditListEditor",$OpenEditListEditor . "</div></form>");
        	$Tpl->SetVar("EditCSS",$EditCSS);
        	$Tpl->SetVar("EditJS",$EditJS . "\n}");
		}
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End categories Class @4-FCB6E20C

class clscategoriesDataSource extends clsDBNetConnect {  //categoriesDataSource Class @4-FD2FF1B0

//Variables @4-8F8275DA
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $cat_id;
    var $name;
//End Variables

//Class_Initialize Event @4-0FD0B5D8
    function clscategoriesDataSource()
    {
        $this->Initialize();
        $this->cat_id = new clsField("cat_id", ccsInteger, "");
        $this->name = new clsField("name", ccsText, "");

    }
//End Class_Initialize Event

//SetOrder Method @4-217A5C7E
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "weight, name";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_name" => array("name", "")));
    }
//End SetOrder Method

//Prepare Method @4-9ADE1968
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->Criterion[1] = "sub_cat_id='1'";
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @4-87D4B51E
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM categories";
        $this->SQL = "SELECT *  " .
        "FROM categories";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @4-0632F0F7
    function SetValues()
    {
        $this->cat_id->SetDBValue($this->f("cat_id"));
        $this->name->SetDBValue($this->f("name"));
    }
//End SetValues Method

}
?>