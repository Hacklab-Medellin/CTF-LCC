<?php
//Include Common Files @1-5471E0F2
define("RelativePath", ".");
include(RelativePath . "/Common.php");
include(RelativePath . "/Template.php");
include(RelativePath . "/Sorter.php");
include(RelativePath . "/Navigator.php");
  
//End Include Common Files

//Include Page implementation @10-503267A8
include("./Header.php");
//End Include Page implementation

Class clsRecordsettings_images { //settings_images Class @2-BFE446CD

//Variables @2-90DA4C9A

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

    var $ds;
    var $EditMode;
    var $ValidatingControls;
    var $Controls;

    // Class variables
//End Variables

//Class_Initialize Event @2-70D46CF0
    function clsRecordsettings_images()
    {

        global $FileName;
        $this->Visible = true;
        $this->Errors = new clsErrors();
        $this->ds = new clssettings_imagesDataSource();
        $this->InsertAllowed = false;
        $this->DeleteAllowed = false;
        if($this->Visible)
        {
            $this->ComponentName = "settings_images";
            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);
            $CCSForm = CCGetFromGet("ccsForm", "");
            $this->FormSubmitted = ($CCSForm == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->maxuploadwidth = new clsControl(ccsTextBox, "maxuploadwidth", "maxuploadwidth", ccsInteger, "", CCGetRequestParam("maxuploadwidth", $Method));
            $this->maxuploadheight = new clsControl(ccsTextBox, "maxuploadheight", "maxuploadheight", ccsInteger, "", CCGetRequestParam("maxuploadheight", $Method));
            $this->Update = new clsButton("Update");
            $this->Cancel = new clsButton("Cancel");
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

//Validate Method @2-FE122F26
    function Validate()
    {
        $Validation = true;
        $Where = "";
        $Validation = ($this->maxuploadwidth->Validate() && $Validation);
        $Validation = ($this->maxuploadheight->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//Operation Method @2-5E3F043D
    function Operation()
    {
        global $Redirect;

        $this->ds->Prepare();
        $this->EditMode = $this->ds->AllParametersSet;
        if(!($this->Visible && $this->FormSubmitted))
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
        if($this->Validate()) {
            if($this->PressedButton == "Update") {
                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {
                    $Redirect = "";
                }
            } else if($this->PressedButton == "Cancel") {
                if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {
                    $Redirect = "";
                } else {
                    $Redirect = "index.php?" . CCGetQueryString("QueryString", array("ccsForm"));
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//UpdateRow Method @2-133D9F52
    function UpdateRow()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");
        $this->ds->maxuploadwidth->SetValue($this->maxuploadwidth->GetValue());
        $this->ds->maxuploadheight->SetValue($this->maxuploadheight->GetValue());
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

//Show Method @2-EDEE06A1
    function Show()
    {
        global $Tpl;
        global $FileName;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->ds->open();
        $RecordBlock = "Record " . $this->ComponentName;
        $Tpl->block_path = $RecordBlock;
        if($this->EditMode)
        {
            if($this->Errors->Count() == 0)
            {
                if($this->ds->Errors->Count() > 0)
                {
                    echo "Error in Record settings_images";
                }
                else if($this->ds->next_record())
                {
                    $this->ds->SetValues();
                    if(!$this->FormSubmitted)
                    {
                        $this->maxuploadwidth->SetValue($this->ds->maxuploadwidth->GetValue());
                        $this->maxuploadheight->SetValue($this->ds->maxuploadheight->GetValue());
                    }
                }
                else
                {
                    $this->EditMode = false;
                }
            }
        }
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");

        if($this->FormSubmitted) {
            $Error .= $this->maxuploadwidth->Errors->ToString();
            $Error .= $this->maxuploadheight->Errors->ToString();
            $Error .= $this->Errors->ToString();
            $Error .= $this->ds->Errors->ToString();
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $Tpl->SetVar("Action", $this->HTMLFormAction);
        $this->Update->Visible = $this->EditMode;
        $this->maxuploadwidth->Show();
        $this->maxuploadheight->Show();
        $this->Update->Show();
        $this->Cancel->Show();
        $Tpl->parse("", false);
        $Tpl->block_path = "";
    }
//End Show Method

} //End settings_images Class @2-FCB6E20C

class clssettings_imagesDataSource extends clsDBDBNetConnect {  //settings_imagesDataSource Class @2-C463F5C4

//Variables @2-7FAE2897
    var $CCSEvents = "";
    var $CCSEventResult;

    var $UpdateParameters;
    var $wp;
    var $AllParametersSet;

    // Datasource fields
    var $maxuploadwidth;
    var $maxuploadheight;
//End Variables

//Class_Initialize Event @2-5DE4DFA2
    function clssettings_imagesDataSource()
    {
        $this->Initialize();
        $this->maxuploadwidth = new clsField("maxuploadwidth", ccsInteger, "");
        $this->maxuploadheight = new clsField("maxuploadheight", ccsInteger, "");

    }
//End Class_Initialize Event

//Prepare Method @2-7C7D15F5
    function Prepare()
    {
        $this->wp = new clsSQLParameters();
        $this->wp->AddParameter("1", "urlset_id", ccsInteger, "", "", $this->Parameters["urlset_id"], 1);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "set_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));
        $this->wp->AssembledWhere = $this->wp->Criterion[1];
        $this->Where = $this->wp->AssembledWhere;
    }
//End Prepare Method

//Open Method @2-8A94497D
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");
        $this->SQL = "SELECT *  " .
        "FROM settings_images";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");
        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");
        $this->MoveToPage($this->AbsolutePage);
    }
//End Open Method

//SetValues Method @2-0DC4A0B0
    function SetValues()
    {
        $this->maxuploadwidth->SetDBValue($this->f("maxuploadwidth"));
        $this->maxuploadheight->SetDBValue($this->f("maxuploadheight"));
    }
//End SetValues Method

//Update Method @2-6299E9F9
    function Update()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");
        $SQL = "UPDATE settings_images SET " .
            "maxuploadwidth=" . $this->ToSQL($this->maxuploadwidth->DBValue, $this->maxuploadwidth->DataType) . ", " . 
            "maxuploadheight=" . $this->ToSQL($this->maxuploadheight->DBValue, $this->maxuploadheight->DataType) . 
            " WHERE " . $this->Where;
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");
        $this->query($SQL);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");
        if($this->Errors->Count() > 0)
            $this->Errors->AddError($this->Errors->ToString());
    }
//End Update Method

} //End settings_imagesDataSource Class @2-FCB6E20C

//Include Page implementation @11-353B2997
include("./Footer.php");
//End Include Page implementation

//Initialize Page @1-55214BB8
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

$FileName = "ImagesSettings.php";
$Redirect = "";
$TemplateFileName = "Themes/ImagesSettings.html";
$BlockToParse = "main";
$PathToRoot = "./";
//End Initialize Page

//Authenticate User @1-FFD44987
CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));
//End Authenticate User

//Initialize Objects @1-674149F7

// Controls
$Header = new clsHeader();
$Header->BindEvents();
$Header->TemplatePath =  "Themes/";
$Header->Initialize();
$settings_images = new clsRecordsettings_images();
$Footer = new clsFooter();
$Footer->BindEvents();
$Footer->TemplatePath =  "Themes/";
$Footer->Initialize();
$settings_images->Initialize();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");
//End Initialize Objects

//Execute Components @1-34F568FE
$Header->Operations();
$settings_images->Operation();
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

//Show Page @1-FCEDFFD8
$Header->Show("Header");
$settings_images->Show();
$Footer->Show("Footer");
$Tpl->PParse("main", false);
//End Show Page

//Unload Page @1-AB7622EF
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");
unset($Tpl);
//End Unload Page


?>
