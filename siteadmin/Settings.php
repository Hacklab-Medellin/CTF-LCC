<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
include(RelativePath . "/lang_entry.php");
$name="itechclassifieds";
$www = "www.scriptpermit.com"; // your main site (remote server)
$domain = $_SERVER['SERVER_NAME'];
$ipaddress=gethostbyname($domain);
$type = "full";
$verss = "3.0";
$ref = $_SERVER["REQUEST_URI"];
$needle = '/';
$result = substr($ref, 0, -strlen($ref)+strrpos($ref, $needle));
$url = "http://$www/dcheck/conf.php?url=$domain&name=$name&ipaddress=$ipaddress&path=$result&type=$type&verss=$verss";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
$resres = curl_exec($ch);
curl_close($ch);
$grep = $resres;
$is = explode("|", $grep);
if($is[0]=="no")
{
echo "$is[1]";
exit();
}

//End Include Common Files

//Include Page implementation @19-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordsettings_general { //settings_general Class @2-8AA33C3C

//Variables @2-052F1B76

    // Public variables
    var $ComponentName;
    var $HTMLFormAction;
    var $PressedButton;
    var $Errors;
    var $FormSubmitted;
    var $Visible;
    var $Recordset;

    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateAllowed;
    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @2-9DFA6E52
    function clsRecordsettings_general()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssettings_generalDataSource();
        $this->UpdateAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "settings_general";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->sitename = new clsControl(ccsTextBox, "sitename", "sitename", ccsText, "", CCGetRequestParam("sitename", $Method));
            $this->siteemail = new clsControl(ccsTextBox, "siteemail", "siteemail", ccsText, "", CCGetRequestParam("siteemail", $Method));
            $this->homeurl = new clsControl(ccsTextBox, "homeurl", "homeurl", ccsText, "", CCGetRequestParam("homeurl", $Method));
            $this->secureurl = new clsControl(ccsTextBox, "secureurl", "secureurl", ccsText, "", CCGetRequestParam("secureurl", $Method));
            $this->uploadurl = new clsControl(ccsTextBox, "uploadurl", "uploadurl", ccsText, "", CCGetRequestParam("uploadurl", $Method));
            $this->pagentrys = new clsControl(ccsTextBox, "pagentrys", "pagentrys", ccsInteger, "", CCGetRequestParam("pagentrys", $Method));
            $this->frontentrys = new clsControl(ccsTextBox, "frontentrys", "frontentrys", ccsInteger, "", CCGetRequestParam("frontentrys", $Method));
            $this->notify = new clsControl(ccsListBox, "notify", "notify", ccsInteger, "", CCGetRequestParam("notify", $Method));
            $this->notify->DSType = dsListOfValues;
            $this->notify->Values = array(array("0", "No"), array("1", "Yes"));
            $this->has_gd = new clsControl(ccsListBox, "has_gd", "has_gd", ccsInteger, "", CCGetRequestParam("has_gd", $Method));
            $this->has_gd->DSType = dsListOfValues;
            $this->has_gd->Values = array(array("0", "No"), array("1", "Yes"));
            $this->approv_priority = new clsControl(ccsListBox, "approv_priority", "approv_priority", ccsInteger, "", CCGetRequestParam("approv_priority", $Method));
            $this->approv_priority->DSType = dsListOfValues;
            $this->approv_priority->Values = array(array("0", "No Approval Required"), array("1", "Require Approval"));
            $this->notifyads = new clsControl(ccsListBox, "notifyads", "Notify of Ads", ccsInteger, "", CCGetRequestParam("notifyads", $Method));
            $this->notifyads->DSType = dsListOfValues;
            $this->notifyads->Values = array(array("0", "No"), array("1", "Yes"));
            $this->notifyemail = new clsControl(ccsTextBox, "notifyemail", "notifyemail", ccsText, "", CCGetRequestParam("notifyemail", $Method));
            $this->bounceout = new clsControl(ccsListBox, "bounceout", "Bounce Out", ccsInteger, "", CCGetRequestParam("bounceout", $Method));
            $this->bounceout->DSType = dsListOfValues;
            $this->bounceout->Values = array(array("1", "Yes"), array("0", "No"));
            $this->bounce_id = new clsControl(ccsListBox, "bounce_id", "Bounced Age Group", ccsInteger, "", CCGetRequestParam("bounce_id", $Method));
            $this->bounce_id->DSType = dsTable;
            list($this->bounce_id->BoundColumn, $this->bounce_id->TextColumn) = array("age_id", "age_desc");
            $this->bounce_id->ds = new clsDBDBNetConnect();
            $this->bounce_id->ds->SQL = "SELECT *  " .
"FROM lookup_ages";
            $this->langg_id = new clsControl(ccsListBox, "langg_id", "Language ID", ccsInteger, "", CCGetRequestParam("langg_id", $Method));
            $this->langg_id->DSType = dsTable;
            list($this->langg_id->BoundColumn, $this->langg_id->TextColumn) = array("lang_id", "lang_file");
            $this->langg_id->ds = new clsDBDBNetConnect();
            $this->langg_id->ds->SQL = "SELECT *  " .
"FROM languages";

            $this->timeout = new clsControl(ccsTextBox, "timeout", "timeout", ccsInteger, "", CCGetRequestParam("timeout", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
            $this->set_id = new clsControl(ccsHidden, "set_id", "set_id", ccsInteger, "", CCGetRequestParam("set_id", $Method));
            $this->set_id->Required = true;
        }
    }
//End Class_Initialize Event

//Initialize Method @2-90EC5D36
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->ds->Parameters["urlset_id"] = CCGetFromGet("set_id", "");
    }
//End Initialize Method

//Validate Method @2-B53FD624
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->sitename->Validate() && $Validation);
        $Validation = ($this->siteemail->Validate() && $Validation);
        $Validation = ($this->homeurl->Validate() && $Validation);
        $Validation = ($this->secureurl->Validate() && $Validation);
        $Validation = ($this->uploadurl->Validate() && $Validation);
        $Validation = ($this->pagentrys->Validate() && $Validation);
        $Validation = ($this->frontentrys->Validate() && $Validation);
        $Validation = ($this->notify->Validate() && $Validation);
        $Validation = ($this->has_gd->Validate() && $Validation);
        $Validation = ($this->approv_priority->Validate() && $Validation);
        $Validation = ($this->notifyads->Validate() && $Validation);
        $Validation = ($this->notifyemail->Validate() && $Validation);
        $Validation = ($this->bounceout->Validate() && $Validation);
        $Validation = ($this->bounce_id->Validate() && $Validation);
        $Validation = ($this->langg_id->Validate() && $Validation);
        $Validation = ($this->timeout->Validate() && $Validation);
        $Validation = ($this->set_id->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-8A36197A
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!$this->FormSubmitted)
            return;

        if($this->FormSubmitted) {
            $this->PressedButton = $this->EditMode ? "Update" : "Cancel";
            if(strlen(CCGetParam("Update", ""))) {
                $this->PressedButton = "Update";
            } else if(strlen(CCGetParam("Cancel", ""))) {
                $this->PressedButton = "Cancel";
            }
        }
        $Redirect = "index.php?" . CCGetQueryString("QueryString", Array("Update","Cancel","ccsForm"));
        if($this->PressedButton == "Cancel") {
            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                $Redirect = "";
            } else {
                $Redirect = "index.php?" . CCGetQueryString("QueryString", array("ccsForm"));
            }
        } else if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//UpdateRow Method @2-98EE5E89
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        if(!$this->UpdateAllowed) return false;
        $this->ds->sitename->SetValue($this->sitename->GetValue());
        $this->ds->siteemail->SetValue($this->siteemail->GetValue());
        $this->ds->homeurl->SetValue($this->homeurl->GetValue());
        $this->ds->secureurl->SetValue($this->secureurl->GetValue());
        $this->ds->uploadurl->SetValue($this->uploadurl->GetValue());
        $this->ds->pagentrys->SetValue($this->pagentrys->GetValue());
        $this->ds->frontentrys->SetValue($this->frontentrys->GetValue());
        $this->ds->notify->SetValue($this->notify->GetValue());
        $this->ds->has_gd->SetValue($this->has_gd->GetValue());
        $this->ds->approv_priority->SetValue($this->approv_priority->GetValue());
        $this->ds->notifyads->SetValue($this->notifyads->GetValue());
        $this->ds->notifyemail->SetValue($this->notifyemail->GetValue());
        $this->ds->bounceout->SetValue($this->bounceout->GetValue());
        $this->ds->bounce_id->SetValue($this->bounce_id->GetValue());
        $this->ds->langg_id->SetValue($this->langg_id->GetValue());
        $this->ds->timeout->SetValue($this->timeout->GetValue());
        $this->ds->set_id->SetValue($this->set_id->GetValue());
        $this->ds->Update();
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterUpdate");
        if($this->ds->Errors->Count() > 0)
        {
            echo "Error in Record " . $this->ComponentName . " / Update Operation";
            $this->ds->Errors->Clear();
            $this->Errors->AddError("Database command error.");
        }
        return ($this->Errors->Count() == 0);
    }
//End UpdateRow Method

//Show Method @2-F7075CB8
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->notify->Prepare();
        $this->has_gd->Prepare();
        $this->approv_priority->Prepare();
        $this->notifyads->Prepare();
        $this->bounceout->Prepare();
        $this->bounce_id->Prepare();
        $this->langg_id->Prepare();

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record settings_general";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->sitename->SetValue($this->ds->sitename->GetValue());
                        $this->siteemail->SetValue($this->ds->siteemail->GetValue());
                        $this->homeurl->SetValue($this->ds->homeurl->GetValue());
                        $this->secureurl->SetValue($this->ds->secureurl->GetValue());
                        $this->uploadurl->SetValue($this->ds->uploadurl->GetValue());
                        $this->pagentrys->SetValue($this->ds->pagentrys->GetValue());
                        $this->frontentrys->SetValue($this->ds->frontentrys->GetValue());
                        $this->notify->SetValue($this->ds->notify->GetValue());
                        $this->has_gd->SetValue($this->ds->has_gd->GetValue());
                        $this->approv_priority->SetValue($this->ds->approv_priority->GetValue());
                        $this->notifyads->SetValue($this->ds->notifyads->GetValue());
                        $this->notifyemail->SetValue($this->ds->notifyemail->GetValue());
                        $this->bounceout->SetValue($this->ds->bounceout->GetValue());
                        $this->bounce_id->SetValue($this->ds->bounce_id->GetValue());
                        $this->langg_id->SetValue($this->ds->langg_id->GetValue());
                        $this->timeout->SetValue($this->ds->timeout->GetValue());
                        $this->set_id->SetValue($this->ds->set_id->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        if(!$this->FormSubmitted)
        {
        }

        if($this->FormSubmitted) {
            $Error .= $this->sitename->Errors->ToString();
            $Error .= $this->siteemail->Errors->ToString();
            $Error .= $this->homeurl->Errors->ToString();
            $Error .= $this->secureurl->Errors->ToString();
            $Error .= $this->uploadurl->Errors->ToString();
            $Error .= $this->pagentrys->Errors->ToString();
            $Error .= $this->frontentrys->Errors->ToString();
            $Error .= $this->notify->Errors->ToString();
            $Error .= $this->has_gd->Errors->ToString();
            $Error .= $this->approv_priority->Errors->ToString();
            $Error .= $this->notifyads->Errors->ToString();
            $Error .= $this->notifyemail->Errors->ToString();
            $Error .= $this->bounceout->Errors->ToString();
            $Error .= $this->bounce_id->Errors->ToString();
            $Error .= $this->langg_id->Errors->ToString();
            $Error .= $this->timeout->Errors->ToString();
            $Error .= $this->set_id->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");
        $this->sitename->Show();
        $this->siteemail->Show();
        $this->homeurl->Show();
        $this->secureurl->Show();
        $this->uploadurl->Show();
        $this->pagentrys->Show();
        $this->frontentrys->Show();
        $this->notify->Show();
        $this->has_gd->Show();
        $this->approv_priority->Show();
        $this->notifyads->Show();
        $this->notifyemail->Show();
        $this->bounceout->Show();
        $this->bounce_id->Show();
        $this->langg_id->Show();
        $this->timeout->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $this->set_id->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End settings_general Class @2-FCB6E20C

class clssettings_generalDataSource extends clsDBDBNetConnect {  //settings_generalDataSource Class @2-FC1AE975

//DataSource Variables @2-B2C50C61
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $sitename;
    var $siteemail;
    var $homeurl;
    var $secureurl;
    var $uploadurl;
    var $pagentrys;
    var $frontentrys;
    var $notify;
    var $has_gd;
    var $approv_priority;
    var $notifyads;
    var $notifyemail;
    var $bounceout;
    var $bounce_id;
    var $langg_id;
    var $timeout;
    var $set_id;
//End DataSource Variables

//Class_Initialize Event @2-E22AFF89
    function clssettings_generalDataSource()
    {
        $this->Initialize();
        $this->sitename = new clsField("sitename", ccsText, "");
        $this->siteemail = new clsField("siteemail", ccsText, "");
        $this->homeurl = new clsField("homeurl", ccsText, "");
        $this->secureurl = new clsField("secureurl", ccsText, "");
        $this->uploadurl = new clsField("uploadurl", ccsText, "");
        $this->pagentrys = new clsField("pagentrys", ccsInteger, "");
        $this->frontentrys = new clsField("frontentrys", ccsInteger, "");
        $this->notify = new clsField("notify", ccsInteger, "");
        $this->has_gd = new clsField("has_gd", ccsInteger, "");
        $this->approv_priority = new clsField("approv_priority", ccsInteger, "");
        $this->notifyads = new clsField("notifyads", ccsInteger, "");
        $this->notifyemail = new clsField("notifyemail", ccsText, "");
        $this->bounceout = new clsField("bounceout", ccsInteger, "");
        $this->bounce_id = new clsField("bounce_id", ccsInteger, "");
        $this->langg_id = new clsField("langg_id", ccsInteger, "");
        $this->timeout = new clsField("timeout", ccsInteger, "");
        $this->set_id = new clsField("set_id", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-D221C61F
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlset_id", ccsInteger, "", "", $this->Parameters["urlset_id"], 1);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "`set_id`", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->Where = $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-194CA9E3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM settings_general";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-AFB2C4CC
    function SetValues()
    {
        $this->sitename->SetDBValue($this->f("sitename"));
        $this->siteemail->SetDBValue($this->f("siteemail"));
        $this->homeurl->SetDBValue($this->f("homeurl"));
        $this->secureurl->SetDBValue($this->f("secureurl"));
        $this->uploadurl->SetDBValue($this->f("uploadurl"));
        $this->pagentrys->SetDBValue($this->f("pagentrys"));
        $this->frontentrys->SetDBValue($this->f("frontentrys"));
        $this->notify->SetDBValue($this->f("notify"));
        $this->has_gd->SetDBValue($this->f("has_gd"));
        $this->approv_priority->SetDBValue($this->f("approv_priority"));
        $this->notifyads->SetDBValue($this->f("notifyads"));
        $this->notifyemail->SetDBValue($this->f("notifyemail"));
        $this->bounceout->SetDBValue($this->f("bounceout"));
        $this->bounce_id->SetDBValue($this->f("bounceout_id"));
        $this->langg_id->SetDBValue($this->f("language_id"));
        $this->timeout->SetDBValue($this->f("timeout"));
        $this->set_id->SetDBValue($this->f("set_id"));
    }
//End SetValues Method

//Update Method @2-27849922
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE `settings_general` SET "
             . "`sitename`=" . $this->ToSQL($this->sitename->GetDBValue(), $this->sitename->DataType) . ", "
             . "`siteemail`=" . $this->ToSQL($this->siteemail->GetDBValue(), $this->siteemail->DataType) . ", "
             . "`homeurl`=" . $this->ToSQL($this->homeurl->GetDBValue(), $this->homeurl->DataType) . ", "
             . "`secureurl`=" . $this->ToSQL($this->secureurl->GetDBValue(), $this->secureurl->DataType) . ", "
             . "`uploadurl`=" . $this->ToSQL($this->uploadurl->GetDBValue(), $this->uploadurl->DataType) . ", "
             . "`pagentrys`=" . $this->ToSQL($this->pagentrys->GetDBValue(), $this->pagentrys->DataType) . ", "
             . "`frontentrys`=" . $this->ToSQL($this->frontentrys->GetDBValue(), $this->frontentrys->DataType) . ", "
             . "`notify`=" . $this->ToSQL($this->notify->GetDBValue(), $this->notify->DataType) . ", "
             . "`has_gd`=" . $this->ToSQL($this->has_gd->GetDBValue(), $this->has_gd->DataType) . ", "
             . "`approv_priority`=" . $this->ToSQL($this->approv_priority->GetDBValue(), $this->approv_priority->DataType) . ", "
             . "`notifyads`=" . $this->ToSQL($this->notifyads->GetDBValue(), $this->notifyads->DataType) . ", "
             . "`notifyemail`=" . $this->ToSQL($this->notifyemail->GetDBValue(), $this->notifyemail->DataType) . ", "
             . "`bounceout`=" . $this->ToSQL($this->bounceout->GetDBValue(), $this->bounceout->DataType) . ", "
             . "`bounceout_id`=" . $this->ToSQL($this->bounce_id->GetDBValue(), $this->bounce_id->DataType) . ", "
             . "`language_id`=" . $this->ToSQL($this->langg_id->GetDBValue(), $this->langg_id->DataType) . ", "
             . "`timeout`=" . $this->ToSQL($this->timeout->GetDBValue(), $this->timeout->DataType) . ", "
             . "`set_id`=" . $this->ToSQL($this->set_id->GetDBValue(), $this->set_id->DataType);
        $SQL = CCBuildSQL($SQL, $this->Where, "");
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End settings_generalDataSource Class @2-FCB6E20C

//Include Page implementation @20-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-DC96FBA6
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

$FileName = "Settings.php";
$Redirect = "";
$TemplateFileName = "Themes/Settings.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-2C4DB19D
CCSecurityRedirect("3", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-2BF8985F
$DBDBNetConnect = new clsDBDBNetConnect();

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$settings_general = new clsRecordsettings_general();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$settings_general->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-2EE3B7BF
$Header->Operations();
$settings_general->Operation();
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

//Show Page @1-E893ACB4
$Header->Show("Header");
$settings_general->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page
?>