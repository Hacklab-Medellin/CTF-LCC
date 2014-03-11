<?php

//Include Common Files @1-5471E0F2

define("RelativePath", ".");

include(RelativePath . "/Common.php");

include(RelativePath . "/Template.php");

include(RelativePath . "/Sorter.php");

include(RelativePath . "/Navigator.php");

  

//End Include Common Files



//Include Page implementation @11-DC989187

include(RelativePath . "/Header.php");

//End Include Page implementation



Class clsRecordcategories { //categories Class @2-A91DF029



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



//Class_Initialize Event @2-BB91610A

    function clsRecordcategories()

    {



        global $FileName;

        $this->Visible = true;

        $this->Errors = new clsErrors();

        $this->ds = new clscategoriesDataSource();

        if($this->Visible)

        {

            $this->ComponentName = "categories";

            $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $this->ComponentName);

            $CCSForm = CCGetFromGet("ccsForm", "");

            $this->FormSubmitted = ($CCSForm == $this->ComponentName);

            $Method = $this->FormSubmitted ? ccsPost : ccsGet;

            $this->sub_cat_id = new clsControl(ccsTextBox, "sub_cat_id", "sub_cat_id", ccsInteger, "", CCGetRequestParam("sub_cat_id", $Method));

            $this->caname = new clsControl(ccsTextBox, "caname", "caname", ccsText, "", CCGetRequestParam("caname", $Method));

            $this->weight = new clsControl(ccsTextBox, "weight", "Weight", ccsInteger, "", CCGetRequestParam("weight", $Method));

            $this->Insert = new clsButton("Insert");

            $this->Update = new clsButton("Update");

            $this->Delete = new clsButton("Delete");

            $this->Cancel = new clsButton("Cancel");

            $this->cat_id = new clsControl(ccsHidden, "cat_id", "cat_id", ccsInteger, "", CCGetRequestParam("cat_id", $Method));

            if(!$this->FormSubmitted) {

                if(!strlen($this->sub_cat_id->GetValue()))

                    $this->sub_cat_id->SetValue(CCGetFromGet("SUBID", ""));

                if(!strlen($this->weight->GetValue()))

                    $this->weight->SetValue(1);

            }

        }

    }

//End Class_Initialize Event



//Initialize Method @2-4E36F16D

    function Initialize()

    {



        if(!$this->Visible)

            return;



        $this->ds->Parameters["urlcat_id"] = CCGetFromGet("cat_id", "");

    }

//End Initialize Method



//Validate Method @2-CBCF8449

    function Validate()

    {

        $Validation = true;

        $Where = "";

        $Validation = ($this->sub_cat_id->Validate() && $Validation);

        $Validation = ($this->caname->Validate() && $Validation);

        $Validation = ($this->weight->Validate() && $Validation);

        $Validation = ($this->cat_id->Validate() && $Validation);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate");

        return (($this->Errors->Count() == 0) && $Validation);

    }

//End Validate Method



//Operation Method @2-D812BC87

    function Operation()

    {

        global $Redirect;



        $this->ds->Prepare();

        $this->EditMode = $this->ds->AllParametersSet;

        if(!($this->Visible && $this->FormSubmitted))

            return;



        if($this->FormSubmitted) {

            $this->PressedButton = $this->EditMode ? "Update" : "Insert";

            if(strlen(CCGetParam("Insert", ""))) {

                $this->PressedButton = "Insert";

            } else if(strlen(CCGetParam("Update", ""))) {

                $this->PressedButton = "Update";

            } else if(strlen(CCGetParam("Delete", ""))) {

                $this->PressedButton = "Delete";

            } else if(strlen(CCGetParam("Cancel", ""))) {

                $this->PressedButton = "Cancel";

            }

        }

        $Redirect = "CategoriesList.php?" . CCGetQueryString("QueryString", Array("Insert","Update","Delete","Cancel","ccsForm"));

        if($this->PressedButton == "Delete") {

            if(!CCGetEvent($this->Delete->CCSEvents, "OnClick") || !$this->DeleteRow()) {

                $Redirect = "";

            }

        } else if($this->PressedButton == "Cancel") {

            if(!CCGetEvent($this->Cancel->CCSEvents, "OnClick")) {

                $Redirect = "";

            } else {

                $Redirect = "CategoriesList.php?" . CCGetQueryString("QueryString", array("ccsForm"));

            }

        } else if($this->Validate()) {

            if($this->PressedButton == "Insert") {

                if(!CCGetEvent($this->Insert->CCSEvents, "OnClick") || !$this->InsertRow()) {

                    $Redirect = "";

                }

            } else if($this->PressedButton == "Update") {

                if(!CCGetEvent($this->Update->CCSEvents, "OnClick") || !$this->UpdateRow()) {

                    $Redirect = "";

                }

            }

        } else {

            $Redirect = "";

        }

    }

//End Operation Method



//InsertRow Method @2-C26BFE7D

    function InsertRow()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeInsert");

        $this->ds->sub_cat_id->SetValue($this->sub_cat_id->GetValue());

        $this->ds->name->SetValue($this->name->GetValue());

        $this->ds->weight->SetValue($this->weight->GetValue());

        $this->ds->cat_id->SetValue($this->cat_id->GetValue());

        $this->ds->Insert();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInsert");

        if($this->ds->Errors->Count() > 0)

        {

            echo "Error in Record " . $this->ComponentName . " / Insert Operation";

            $this->ds->Errors->Clear();

            $this->Errors->AddError("Database command error.");

        }

        return ($this->Errors->Count() == 0);

    }

//End InsertRow Method



//UpdateRow Method @2-2402368B

    function UpdateRow()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUpdate");

        $this->ds->sub_cat_id->SetValue($this->sub_cat_id->GetValue());

        $this->ds->name->SetValue($this->caname->GetValue());

        $this->ds->weight->SetValue($this->weight->GetValue());

        $this->ds->cat_id->SetValue($this->cat_id->GetValue());

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



//DeleteRow Method @2-A9D87FED

    function DeleteRow()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeDelete");

        $this->ds->Delete();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterDelete");

        if($this->ds->Errors->Count())

        {

            echo "Error in Record " . ComponentName . " / Delete Operation";

            $this->ds->Errors->Clear();

            $this->Errors->AddError("Database command error.");

        }

        return ($this->Errors->Count() == 0);

    }

//End DeleteRow Method



//Show Method @2-00EE98F4

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

                    echo "Error in Record categories";

                }

                else if($this->ds->next_record())

                {

                    $this->ds->SetValues();

                    if(!$this->FormSubmitted)

                    {

                        $this->sub_cat_id->SetValue($this->ds->sub_cat_id->GetValue());

                        $this->caname->SetValue($this->ds->name->GetValue());

                        $this->weight->SetValue($this->ds->weight->GetValue());

                        $this->cat_id->SetValue($this->ds->cat_id->GetValue());

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

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");



        if($this->FormSubmitted) {

            $Error .= $this->sub_cat_id->Errors->ToString();

            $Error .= $this->caname->Errors->ToString();

            $Error .= $this->weight->Errors->ToString();

            $Error .= $this->cat_id->Errors->ToString();

            $Error .= $this->Errors->ToString();

            $Error .= $this->ds->Errors->ToString();

            $Tpl->SetVar("Error", $Error);

            $Tpl->Parse("Error", false);

        }

        $Tpl->SetVar("Action", $this->HTMLFormAction);

        $this->Insert->Visible = !$this->EditMode;

        $this->Update->Visible = $this->EditMode;

        $this->Delete->Visible = $this->EditMode;

        $this->sub_cat_id->Show();

        $this->caname->Show();

        $this->weight->Show();

        $this->Insert->Show();

        $this->Update->Show();

        $this->Delete->Show();

        $this->Cancel->Show();

        $this->cat_id->Show();

        $Tpl->parse("", false);

        $Tpl->block_path = "";

    }

//End Show Method



} //End categories Class @2-FCB6E20C



class clscategoriesDataSource extends clsDBDBNetConnect {  //categoriesDataSource Class @2-BF04F525



//Variables @2-56CBF5B8

    var $CCSEvents = "";

    var $CCSEventResult;



    var $InsertParameters;

    var $UpdateParameters;

    var $DeleteParameters;

    var $wp;

    var $AllParametersSet;



    // Datasource fields

    var $sub_cat_id;

    var $caname;

    var $weight;

    var $cat_id;

//End Variables



//Class_Initialize Event @2-2B183EF9

    function clscategoriesDataSource()

    {

        $this->Initialize();

        $this->sub_cat_id = new clsField("sub_cat_id", ccsInteger, "");

        $this->name = new clsField("caname", ccsText, "");

        $this->weight = new clsField("weight", ccsInteger, "");

        $this->cat_id = new clsField("cat_id", ccsInteger, "");



    }

//End Class_Initialize Event



//Prepare Method @2-B9761AC0

    function Prepare()

    {

        $this->wp = new clsSQLParameters();

        $this->wp->AddParameter("1", "urlcat_id", ccsInteger, "", "", $this->Parameters["urlcat_id"], "");

        $this->AllParametersSet = $this->wp->AllParamsSet();

        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "cat_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger));

        $this->wp->AssembledWhere = $this->wp->Criterion[1];

        $this->Where = $this->wp->AssembledWhere;

    }

//End Prepare Method



//Open Method @2-41C314D1

    function Open()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect");

        $this->SQL = "SELECT *  " .

        "FROM categories";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect");

        $this->query(CCBuildSQL($this->SQL, $this->Where, $this->Order));

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect");

        $this->MoveToPage($this->AbsolutePage);

    }

//End Open Method



//SetValues Method @2-9472F61E

    function SetValues()

    {

        $this->sub_cat_id->SetDBValue($this->f("sub_cat_id"));

        $this->name->SetDBValue($this->f("name"));

        $this->weight->SetDBValue($this->f("weight"));

        $this->cat_id->SetDBValue($this->f("cat_id"));

    }

//End SetValues Method



//Insert Method @2-11D0104E

    function Insert()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildInsert");

        $SQL = "INSERT INTO categories ("

             . "sub_cat_id, "

             . "name, "

             . "weight, "

             . "cat_id"

             . ") VALUES ("

             . $this->ToSQL($this->sub_cat_id->GetDBValue(), $this->sub_cat_id->DataType) . ", "

             . $this->ToSQL($this->name->GetDBValue(), $this->caname->DataType) . ", "

             . $this->ToSQL($this->weight->GetDBValue(), $this->weight->DataType) . ", "

             . $this->ToSQL($this->cat_id->GetDBValue(), $this->cat_id->DataType)

             . ")";

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteInsert");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteInsert");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

		if ($this->sub_cat_id->GetDBValue() == 1){

			$new_id = mysql_insert_id();

			$query = "insert into groups_categories (`cat_id`,`group_id`) values ('" . $new_id . "', '1')";

			$group = new clsDBNetConnect;

			$group->query($query);

		}

    }

//End Insert Method



//Update Method @2-CD383C11

    function Update()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildUpdate");

        $SQL = "UPDATE categories SET "

             . "sub_cat_id=" . $this->ToSQL($this->sub_cat_id->GetDBValue(), $this->sub_cat_id->DataType) . ", "

             . "name=" . $this->ToSQL($this->name->GetDBValue(), $this->caname->DataType) . ", "

             . "weight=" . $this->ToSQL($this->weight->GetDBValue(), $this->weight->DataType) . ", "

             . "cat_id=" . $this->ToSQL($this->cat_id->GetDBValue(), $this->cat_id->DataType);

        $SQL = CCBuildSQL($SQL, $this->Where, "");

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteUpdate");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteUpdate");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

    }

//End Update Method



//Delete Method @2-C9B1FDEB

    function Delete()

    {

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildDelete");

        $SQL = "DELETE FROM categories WHERE " . $this->Where;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteDelete");

        $this->query($SQL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteDelete");

        if($this->Errors->Count() > 0)

            $this->Errors->AddError($this->Errors->ToString());

    }

//End Delete Method



} //End categoriesDataSource Class @2-FCB6E20C



//Include Page implementation @12-B991DFB8

include(RelativePath . "/Footer.php");

//End Include Page implementation



//Initialize Page @1-3A7869DA

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



$FileName = "CategoriesMaintanence.php";

$Redirect = "";

$TemplateFileName = "Themes/CategoriesMaintanence.html";

$BlockToParse = "main";

$PathToRoot = "./";

//End Initialize Page



//Authenticate User @1-FFD44987

CCSecurityRedirect("1", "", $FileName, CCGetQueryString("QueryString", ""));

//End Authenticate User



//Initialize Objects @1-8D21FAD2

$DBDBNetConnect = new clsDBDBNetConnect();



// Controls

$Header = new clsHeader();

$Header->BindEvents();

$Header->TemplatePath =  "Themes/";

$Header->Initialize();

$categories = new clsRecordcategories();

$Footer = new clsFooter();

$Footer->BindEvents();

$Footer->TemplatePath =  "Themes/";

$Footer->Initialize();

$categories->Initialize();



$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize");

//End Initialize Objects



//Execute Components @1-301894F4

$Header->Operations();

$categories->Operation();

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



//Show Page @1-0396759A

$Header->Show("Header");

$categories->Show();

$Footer->Show("Footer");

$Tpl->PParse("main", false);

//End Show Page



//Unload Page @1-AB7622EF

$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload");

unset($Tpl);

//End Unload Page





?>

