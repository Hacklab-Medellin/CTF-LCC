<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @12-503267A8
include("./Header.php");
//End Include Page implementation
if (!$_GET["cat_id"])
	$_GET["cat_id"] = 1;
	
if ($_GET["cat_id"] != 1) {
	$check = new clsDBNetConnect;
	$query = "select * from lookup_listing_dates where cat_id = '" . $_GET["cat_id"] . "'";
	$check->query($query);
	if (!$check->next_record()){
		$check->query("select * from settings_charges where set_id = '" . $_GET["cat_id"] . "'");
		if (!$check->next_record()){
			$check->query("select * from category_details where cat_id = '" . $_GET["cat_id"] . "'");
			if ($check->next_record()) {
				$check->query("update category_details set `pricing` = 0 where cat_id = '" . $_GET["cat_id"] . "'");
			}
		}
	}
	else {
		$check->query("select * from category_details where cat_id = '" . $_GET["cat_id"] . "'");
		if ($check->next_record()) {
			$check->query("update category_details set `pricing` = 1 where cat_id = '" . $_GET["cat_id"] . "'");
		}
		else {
			$check->query("insert into category_details (`cat_id`, `pricing`) values ('" . $_GET["cat_id"] . "', '1')");
		}
	}
}

class clsGridlookup_listing_dates { //lookup_listing_dates class @2-097B61A2

//Variables @2-284264D0

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
    var $Sorter_days;
    var $Navigator;
//End Variables

//Class_Initialize Event @2-A8FF9175
    function clsGridlookup_listing_dates()
    {
        global $FileName;
        $this->ComponentName = "lookup_listing_dates";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clslookup_listing_datesDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 20;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("lookup_listing_datesOrder", "");
        $this->SorterDirection = CCGetParam("lookup_listing_datesDir", "");

        $this->Detail = new clsControl(ccsLink, "Detail", "Detail", ccsText, "", CCGetRequestParam("Detail", ccsGet));
        $this->days = new clsControl(ccsLabel, "days", "days", ccsInteger, "", CCGetRequestParam("days", ccsGet));
        $this->fee = new clsControl(ccsLabel, "fee", "fee", ccsFloat, Array(False, 2, ".", "", False, "", "", 1, True, ""), CCGetRequestParam("fee", ccsGet));
        $this->Sorter_days = new clsSorter($this->ComponentName, "Sorter_days", $FileName);
        $this->lookup_listing_dates_Insert = new clsControl(ccsLink, "lookup_listing_dates_Insert", "lookup_listing_dates_Insert", ccsText, "", CCGetRequestParam("lookup_listing_dates_Insert", ccsGet));
        $this->lookup_listing_dates_Insert->Parameters = CCGetQueryString("QueryString", Array("date_id", "ccsForm"));
        $this->lookup_listing_dates_Insert->Page = "ListingDatesEdit.php";
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @2-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @2-F76E6FF2
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
                $this->Detail->Parameters = CCGetQueryString("QueryString", Array("ccsForm", "cat_id"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "date_id", $this->ds->f("date_id"));
                $this->Detail->Parameters = CCAddParam($this->Detail->Parameters, "cat_id", $_GET["cat_id"]);
                $this->Detail->Page = "ListingDatesEdit.php";
                $this->days->SetValue($this->ds->days->GetValue());
                $this->fee->SetValue($this->ds->fee->GetValue());
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->Detail->Show();
                $this->days->Show();
                $this->fee->Show();
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

        $cat = $_GET["cat_id"];
        $catoptions="";
		$catlist = new clsDBDBNetConnect();
		$catlist->query("select * from categories where cat_id=1");
  		while($catlist->next_record()) {
      		if ($cat==$catlist->f("cat_id"))
          		$selected = " selected";
  		$catoptions .= "<option value=\"" . $catlist->f("cat_id") . "\"$selected>" . $catlist->f("name") . "</option>";
  		$selected = "";
  		$catlist2 = new clsDBDBNetConnect();
  		$catlist2->query("select * from categories where sub_cat_id=" . $catlist->f("cat_id"));
     		while($catlist2->next_record()) {
		               if ($cat==$catlist2->f("cat_id"))
		               $selected = " selected";
     		$catoptions .= "<option value=\"" . $catlist2->f("cat_id") . "\"$selected>&nbsp;" . $catlist2->f("name") . "</option>";
     		$selected = "";
     		$catlist3 = new clsDBDBNetConnect();
     		$catlist3->query("select * from categories where sub_cat_id=" . $catlist2->f("cat_id"));
        		while($catlist3->next_record()) {
		                  if ($cat==$catlist3->f("cat_id"))
		                  $selected = " selected";
		        $catoptions .= "<option value=\"" . $catlist3->f("cat_id") . "\"$selected>&nbsp;&nbsp;" . $catlist3->f("name") . "</option>";
		        $selected = "";
		        $catlist4 = new clsDBDBNetConnect();
		        $catlist4->query("select * from categories where sub_cat_id=" . $catlist3->f("cat_id"));
		           while($catlist4->next_record()) {
		                     if ($cat==$catlist4->f("cat_id"))
		                     $selected = " selected";
		           $catoptions .= "<option value=\"" . $catlist4->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;" . $catlist4->f("name") . "</option>";
		           $selected = "";
		           $catlist5 = new clsDBDBNetConnect();
		           $catlist5->query("select * from categories where sub_cat_id=" . $catlist4->f("cat_id"));
		              while($catlist5->next_record()) {
		                        if ($cat==$catlist5->f("cat_id"))
		                        $selected = " selected";
		              $catoptions .= "<option value=\"" . $catlist5->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;&nbsp;" . $catlist5->f("name") . "</option>";
		              $selected = "";
        		      $catlist6 = new clsDBDBNetConnect();
              		  $catlist6->query("select * from categories where sub_cat_id=" . $catlist5->f("cat_id"));
                 	  while($catlist6->next_record()) {
                           if ($cat==$catlist6->f("cat_id"))
                           $selected = " selected";
                 		  $catoptions .= "<option value=\"" . $catlist6->f("cat_id") . "\"$selected>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $catlist6->f("name") . "</option>";
                 	  	  $selected = "";
                 	  }
              		}
           		}
        	}
     	}
  	}
  		        $Tpl->SetVar("CatOptions", $catoptions);
        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_days->Show();
        $this->lookup_listing_dates_Insert->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End lookup_listing_dates Class @2-FCB6E20C

class clslookup_listing_datesDataSource extends clsDBDBNetConnect {  //lookup_listing_datesDataSource Class @2-619FFB46

//DataSource Variables @2-2C50108E
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $days;
    var $fee;
//End DataSource Variables

//Class_Initialize Event @2-B2D91F9D
    function clslookup_listing_datesDataSource()
    {
        $this->Initialize();
        $this->days = new clsField("days", ccsInteger, "");
        $this->fee = new clsField("fee", ccsFloat, "");

    }
//End Class_Initialize Event

//SetOrder Method @2-4EE07128
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_days" => array("days", "")));
    }
//End SetOrder Method

//Prepare Method @2-DFF3DD87
    function Prepare()
    {
    }
//End Prepare Method

//Open Method @2-4C14C604
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM lookup_listing_dates";
        $this->SQL = "SELECT *  " .
        "FROM lookup_listing_dates";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, " cat_id=" . $_GET["cat_id"], ""), $this);
        $this->query(CCBuildSQL($this->SQL, " cat_id=" . $_GET["cat_id"], $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-E7992A9A
    function SetValues()
    {
        $this->days->SetDBValue($this->f("days"));
        $this->fee->SetDBValue($this->f("fee"));
    }
//End SetValues Method

} //End lookup_listing_datesDataSource Class @2-FCB6E20C

//Include Page implementation @13-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-1937DBF4
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = "ListingDates.php";
$Redirect = "";
$TemplateFileName = "Themes/ListingDates.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-45814D90
CCSecurityRedirect("2", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-5D4150C7
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$lookup_listing_dates = new clsGridlookup_listing_dates();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$lookup_listing_dates->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-351F985C
$Header->Operations();
$Footer->Operations();
//End Execute Components

//Go to destination page @1-BEB91355
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
    header("Location: " . $Redirect);
    exit;
}
//End Go to destination page

//Initialize HTML Template @1-A0111C9D
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView");
$Tpl = new clsTemplate();
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

//Show Page @1-D30AFD57
$Header->Show("Header");
$lookup_listing_dates->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


//DEL      function SetOrder($SorterName, $SorterDirection)
//DEL      {
//DEL          $this->Order = "";
//DEL          $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
//DEL              array("Sorter_date_id" => array("date_id", ""), 
//DEL              "Sorter_days" => array("days", "")));
//DEL      }



?>
