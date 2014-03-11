<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");

if ($_GET["username"]){
	$user = new clsDBNetConnect;
	$query = "select * from users where user_login='" . $_GET["username"] . "'";
	$user->query($query);
	if ($user->next_record()) {
		$_GET["user_id"] = $user->f("user_id");
	}
	else {
	    $error = 1;
	}
}

//End Include Common Files
$page="Viewing Feedback";
global $REMOTE_ADDR;
global $now;
$ip=$REMOTE_ADDR;
$timeout = $now["timeout"];
$db1 = new clsDBNetConnect;
$db2 = new clsDBNetConnect;
$db3 = new clsDBNetConnect;
$db4 = new clsDBNetConnect;
$db5 = new clsDBNetConnect;
$times = time();

$SQL1 = "DELETE FROM online WHERE datet < $times";
$SQL2 = "SELECT * FROM online WHERE ip='$ip'";
$SQL3 = "UPDATE online SET datet=$times + $timeout, page='$page', user='" . CCGetUserName() . "' WHERE ip='$ip'";
$SQL4 = "INSERT INTO online (ip, datet, user, page) VALUES ('$ip', $times+$timeout,'". CCGetUserName() . "', '$page')";
$SQL5 = "SELECT * FROM online";

$db1->query($SQL1);
$db2->query($SQL2);
if($db2->next_record()){
        $db3->query($SQL3);
} else {
        $db4->query($SQL4);
}

$db5->query($SQL5);
$usersonline = $db5->num_rows();
unset($db1);
unset($db2);
unset($db3);
unset($db4);
unset($db5);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
unset($SQL);
//Include Page implementation @2-503267A8
include("./Header.php");
//End Include Page implementation


class clsGridcomments { //comments class @36-6F333C80

//Variables @36-8731A4E3

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
    var $Sorter_doing_rating;
    var $Sorter_date;
    var $Navigator;
//End Variables

//Class_Initialize Event @36-E5D1A85D
	function clsGridcomments()
    {
        global $FileName;
        $this->ComponentName = "comments";
        $this->Visible = True;
        $this->Errors = new clsErrors();
        $this->ds = new clscommentsDataSource();
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 30;
        else
            $this->PageSize = intval($this->PageSize);
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        $this->SorterName = CCGetParam("commentsOrder", "");
        $this->SorterDirection = CCGetParam("commentsDir", "");

        $this->comment = new clsControl(ccsLabel, "comment", "comment", ccsText, "", CCGetRequestParam("comment", ccsGet));
        $this->date = new clsControl(ccsLabel, "date", "date", ccsText, "", CCGetRequestParam("date", ccsGet));
        $this->date->HTML = true;
        $this->doing_rating = new clsControl(ccsLabel, "doing_rating", "doing_rating", ccsText, "", CCGetRequestParam("doing_rating", ccsGet));
        $this->buysell = new clsControl(ccsLabel, "buysell", "buysell", ccsText, "", CCGetRequestParam("buysell", ccsGet));
        $this->id = new clsControl(ccsLabel, "id", "id", ccsInteger, "", CCGetRequestParam("id", ccsGet));
        $this->ItemNum = new clsControl(ccsLabel, "ItemNum", "ItemNum", ccsInteger, "", CCGetRequestParam("ItemNum", ccsGet));
        $this->rating = new clsControl(ccsLabel, "rating", "rating", ccsText, "", CCGetRequestParam("rating", ccsGet));
        $this->rating->HTML = true;
        $this->Sorter_doing_rating = new clsSorter($this->ComponentName, "Sorter_doing_rating", $FileName);
        $this->Sorter_date = new clsSorter($this->ComponentName, "Sorter_date", $FileName);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 30, tpCentered);
    }
//End Class_Initialize Event

//Initialize Method @36-383CA3E0
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->ds->PageSize = $this->PageSize;
        $this->ds->SetOrder($this->SorterName, $this->SorterDirection);
        $this->ds->AbsolutePage = $this->PageNumber;
    }
//End Initialize Method

//Show Method @36-89453F69
    function Show()
    {
        global $Tpl;
        global $now;
        if(!$this->Visible) return;

        $ShownRecords = 0;

        $this->ds->Parameters["sesUserID"] = CCGetSession("UserID");
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
                $this->comment->SetValue($this->ds->comment->GetValue());
                $twodays = $this->ds->date->GetValue();
                                $theday = getdate($twodays);
                                $lastofyear = substr($theday["year"],-2);
                                $enddate = $theday["mon"] . "/" . $theday["mday"] . "/" . $lastofyear;
                                $this->date->SetValue(date("F j, Y, g:i a", $this->ds->date->GetValue()));
                if(($this->ds->doing_rating->GetValue() != "") && (is_numeric($this->ds->doing_rating->GetValue())) && ($this->ds->doing_rating->GetValue() != 1000000000)){
                                        $lookupdb = new clsDBNetConnect;
                                        $lookupdb->connect();
                                        $thename = CCDLookUp("user_login","users","user_id='" . $this->ds->doing_rating->GetValue() . "'",$lookupdb);
                                        $this->doing_rating->SetValue($thename);
                                        unset($lookupdb);
                                } else {
                                        $this->doing_rating->SetValue($now["sitename"]);
                                }
                $this->id->SetValue($this->ds->id->GetValue());
                $this->ItemNum->SetValue($this->ds->ItemNum->GetValue());
                if ($this->ds->rating->GetValue() == 1)
                	$this->rating->SetValue("<img src=\"images/positive.gif\">");
                if ($this->ds->rating->GetValue() == 0)
                	$this->rating->SetValue("<img src=\"images/neutral.gif\">");
                if ($this->ds->rating->GetValue() == -1)
                	$this->rating->SetValue("<img src=\"images/negative.gif\">");
                if ($this->ds->buysell->GetValue() == 1)
                	$this->buysell->SetValue("Buyer");
                if ($this->ds->buysell->GetValue() == 0)
                	$this->buysell->SetValue("Seller");
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow");
                $this->comment->Show();
                $this->date->Show();
                $this->doing_rating->Show();
                $this->buysell->Show();
                $this->id->Show();
                $this->ItemNum->Show();
                $this->rating->Show();
                $counter = new clsDBNetConnect;
                $query = "select * from feedback where `counter` = '" . $this->ds->id->GetValue() . "'";
                $counter->query($query);
                if ($counter->next_record()) {
                	$Tpl->SetBlockVar("counter", "");
                	$Tpl->setVar("countercomment", stripslashes($counter->f("comment")));
                	$Tpl->setVar("countericon", "<img src=\"images/CounterComment.gif\">");
                	$Tpl->setVar("counterlink", "");
                	$Tpl->parse("counter", "");
                }else{
                	$Tpl->SetBlockVar("counter", "");
                	$Tpl->setVar("countercomment", "");
                	$Tpl->setVar("countericon", "");
                	if (CCGetUserID() == $_GET["user_id"]) {
						$Tpl->setVar("counterlink", "<a href=\"RateUser.php?id=" . $this->ds->id->GetValue() . "\">&nbsp;&nbsp;&nbsp;&nbsp;<i>Comment on this rating</i></a>");
					}
                }
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

        $this->Navigator->TotalPages = $this->ds->PageCount();
        $this->Sorter_doing_rating->Show();
        $this->Sorter_date->Show();
        $this->Navigator->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End comments Class @36-FCB6E20C

class clscommentsDataSource extends clsDBNetConnect {  //commentsDataSource Class @36-48567F33

//Variables @36-2F5B7AB2
    var $CCSEvents = "";
    var $CCSEventResult;

    var $CountSQL;
    var $wp;

    // Datasource fields
    var $comment;
    var $date;
    var $doing_rating;
    var $buysell;
    var $id;
    var $ItemNum;
    var $rating;
//End Variables

//Class_Initialize Event @36-4B038FD2
    function clscommentsDataSource()
    {
        $this->Initialize();
        $this->comment = new clsField("comment", ccsText, "");
        $this->date = new clsField("date", ccsText, "");
        $this->buysell = new clsField("buysell", ccsText, "");
        $this->doing_rating = new clsField("doing_rating", ccsInteger, "");
        $this->ItemNum = new clsField("ItemNum", ccsInteger, "");
        $this->rating = new clsField("rating", ccsText, "");
        $this->id = new clsField("id", ccsInteger, "");

    }
//End Class_Initialize Event

//SetOrder Method @36-C2E9613F
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "date desc";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection,
            array("Sorter_doing_rating" => array("doing_rating", ""),
            "Sorter_date" => array("date", "")));
    }
//End SetOrder Method

//Prepare Method @36-EC0ED421
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->Criterion[1] = "being_rated='" . $_GET["user_id"] . "'";
        $this->wp->Criterion[2] = "counter IS NULL";
		$this->wp->AssembledWhere = $this->wp->Criterion[1] . " AND " . $this->wp->Criterion[2];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @36-56E05C87
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->CountSQL = "SELECT COUNT(*)  " .
        "FROM feedback";
        $this->SQL = "SELECT *  " .
        "FROM feedback";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @36-8C60FE31
    function SetValues()
    {
        $this->comment->SetDBValue($this->f("comment"));
        $this->date->SetDBValue($this->f("date"));
        $this->doing_rating->SetDBValue($this->f("doing_rating"));
        $this->buysell->SetDBValue($this->f("buysell"));
        $this->ItemNum->SetDBValue($this->f("ItemNum"));
        $this->rating->SetDBValue($this->f("rating"));
        $this->id->SetDBValue($this->f("id"));
    }
//End SetValues Method

} //End commentsDataSource Class @36-FCB6E20C


//Include Page implementation @3-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-375A4A35
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

$FileName = "Feedback.php";
$Redirect = "";
$TemplateFileName = "templates/Feedback.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-7FED0150
//End Authenticate User

//Initialize Objects @1-B4723FC9

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath = "./";
$Header->Initialize();
$comments = new clsGridcomments();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath = "./";
$Footer->Initialize();
$comments->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-9D3C7E64
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
include './Lang/lang_class.php';
$Tpl->LoadTemplate(TemplatePath . $TemplateFileName, "main");
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow");
//End Initialize HTML Template

if ($error){
	$Tpl->SetBlockVar("Error", "");
	$Tpl->parse("Error","");
}

$db = new clsDBNetConnect;
$query = "select sum(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL";
$db->query($query);
if ($db->next_record()){
	$rating = $db->f("sum(rating)");
} else {
	$rating = 0;
}
$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL";
$db->query($query);
if ($db->next_record()){
	$total = $db->f("count(rating)");
} else {
	$total = 0;
}
if ($total != 0){
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '1'";
	$db->query($query);
	if ($db->next_record()){
		$pos = $db->f("count(rating)");
	} else {
		$pos = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '0'";
	$db->query($query);
	if ($db->next_record()){
		$neu = $db->f("count(rating)");
	} else {
		$neu = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '-1'";
	$db->query($query);
	if ($db->next_record()){
		$neg = $db->f("count(rating)");
	} else {
		$neg = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '1' and date > '" . (time()-(86400*14)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$pos1 = $db->f("count(rating)");
	} else {
		$pos1 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '0' and date > '" . (time()-(86400*14)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neu1 = $db->f("count(rating)");
	} else {
		$neu1 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '-1' and date > '" . (time()-(86400*14)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neg1 = $db->f("count(rating)");
	} else {
		$neg1 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '1' and date > '" . (time()-(86400*60)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$pos2 = $db->f("count(rating)");
	} else {
		$pos2 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '0' and date > '" . (time()-(86400*60)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neu2 = $db->f("count(rating)");
	} else {
		$neu2 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '-1' and date > '" . (time()-(86400*60)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neg2 = $db->f("count(rating)");
	} else {
		$neg2 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '1' and date > '" . (time()-(86400*183)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$pos3 = $db->f("count(rating)");
	} else {
		$pos3 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '0' and date > '" . (time()-(86400*183)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neu3 = $db->f("count(rating)");
	} else {
		$neu3 = 0;
	}
	$query = "select count(rating) from feedback where being_rated = '" . $_GET["user_id"] . "' and `counter` IS NULL and `rating` = '-1' and date > '" . (time()-(86400*183)) . "'";
	$db->query($query);
	if ($db->next_record()){
		$neg3 = $db->f("count(rating)");
	} else {
		$neg3 = 0;
	}
	$query = "select user_login from users where user_id = '" . $_GET["user_id"] . "'";
	$db->query($query);
	if ($db->next_record()){
		$username = $db->f("user_login");
	} else {
		$neg3 = 0;
	}
	
	$pospercent = ($pos/$total)*100;
	$neupercent = ($neu/$total)*100;
	$negpercent = ($neg/$total)*100;
	$Tpl->setVar("username", $username);
	$Tpl->setVar("pos", $pos);
	$Tpl->setVar("neu", $neu);
	$Tpl->setVar("neg", $neg);
	$Tpl->setVar("pospercent", round($pospercent, 2));
	$Tpl->setVar("neupercent", round($neupercent, 2));
	$Tpl->setVar("negpercent", round($negpercent, 2));
	$Tpl->setVar("pos1", $pos1);
	$Tpl->setVar("neu1", $neu1);
	$Tpl->setVar("neg1", $neg1);
	$Tpl->setVar("pos2", $pos2);
	$Tpl->setVar("neu2", $neu2);
	$Tpl->setVar("neg2", $neg2);
	$Tpl->setVar("pos3", $pos3);
	$Tpl->setVar("neu3", $neu3);
	$Tpl->setVar("neg3", $neg3);
}
//Show Page @1-BE2A4A0B
$Header->Show("Header");
$comments->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
