<?php
class clsHeader { //Header class @1-CC982CB1





//Variables @1-E1CF4CAE


    var $FileName = "";


    var $Redirect = "";


    var $Tpl = "";


    var $TemplateFileName = "";


    var $BlockToParse = "";


    var $ComponentName = "";





    // Events;


    var $CCSEvents = "";


    var $CCSEventResult = "";


    var $TemplatePath;


    var $Enabled;


//End Variables





//Class_Initialize Event @1-294958F6


    function clsHeader()


    {


        $this->Enabled = true;


        if($this->Enabled)


        {


            $this->FileName = "Header.php";


            $this->Redirect = "";


            $this->TemplateFileName = "Header.html";


            $this->BlockToParse = "main";





            // Create Components


            $this->ItemsList = new clsControl(ccsLink, "ItemsList", "ItemsList", ccsText, "", CCGetRequestParam("ItemsList", ccsGet));


            $this->ItemsList->Page = "ItemsList.php";


            $this->ListUsers = new clsControl(ccsLink, "ListUsers", "ListUsers", ccsText, "", CCGetRequestParam("ListUsers", ccsGet));


            $this->ListUsers->Page = "ListUsers.php";


            $this->ChargesList = new clsControl(ccsLink, "ChargesList", "ChargesList", ccsText, "", CCGetRequestParam("ChargesList", ccsGet));


            $this->ChargesList->Page = "ChargesList.php";


            $this->Online = new clsControl(ccsLink, "Online", "Online", ccsText, "", CCGetRequestParam("Online", ccsGet));


            $this->Online->Page = "Online.php";


            $this->CategoriesList = new clsControl(ccsLink, "CategoriesList", "CategoriesList", ccsText, "", CCGetRequestParam("CategoriesList", ccsGet));


            $this->CategoriesList->Page = "CategoriesList.php";


            $this->SettingsGeneral = new clsControl(ccsLink, "SettingsGeneral", "SettingsGeneral", ccsText, "", CCGetRequestParam("SettingsGeneral", ccsGet));


            $this->SettingsGeneral->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));


            $this->SettingsGeneral->Page = "Settings.php";


            $this->AccountingSettings = new clsControl(ccsLink, "AccountingSettings", "AccountingSettings", ccsText, "", CCGetRequestParam("AccountingSettings", ccsGet));


            $this->AccountingSettings->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));


            $this->AccountingSettings->Page = "Accountings.php";


            $this->Fees = new clsControl(ccsLink, "Fees", "Fees", ccsText, "", CCGetRequestParam("Fees", ccsGet));


            $this->Fees->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));


            $this->Fees->Page = "Fees.php";


            $this->ImageSettings = new clsControl(ccsLink, "ImageSettings", "ImageSettings", ccsText, "", CCGetRequestParam("ImageSettings", ccsGet));


            $this->ImageSettings->Parameters = CCGetQueryString("QueryString", Array("ccsForm"));


            $this->ImageSettings->Page = "ImagesSettings.php";


            $this->ListingDates = new clsControl(ccsLink, "ListingDates", "ListingDates", ccsText, "", CCGetRequestParam("ListingDates", ccsGet));


            $this->ListingDates->Page = "ListingDates.php";


            $this->AgesList = new clsControl(ccsLink, "AgesList", "AgesList", ccsText, "", CCGetRequestParam("AgesList", ccsGet));


            $this->AgesList->Page = "AgesList.php";


            $this->EducationsList = new clsControl(ccsLink, "EducationsList", "EducationsList", ccsText, "", CCGetRequestParam("EducationsList", ccsGet));


            $this->EducationsList->Page = "EducationsList.php";


            $this->IncomesList = new clsControl(ccsLink, "IncomesList", "IncomesList", ccsText, "", CCGetRequestParam("IncomesList", ccsGet));


            $this->IncomesList->Page = "IncomesList.php";


            $this->StatesList = new clsControl(ccsLink, "StatesList", "StatesList", ccsText, "", CCGetRequestParam("StatesList", ccsGet));


            $this->StatesList->Page = "StatesList.php";


            $this->CountriesList = new clsControl(ccsLink, "CountriesList", "CountriesList", ccsText, "", CCGetRequestParam("CountriesList", ccsGet));


            $this->CountriesList->Page = "CountriesList.php";


            $this->Newsletters = new clsControl(ccsLink, "Newsletters", "Newsletters", ccsText, "", CCGetRequestParam("Newsletters", ccsGet));


            $this->Newsletters->Page = "SendNewsletter.php";


            $this->TemplatesEmails = new clsControl(ccsLink, "TemplatesEmails", "TemplatesEmails", ccsText, "", CCGetRequestParam("TemplatesEmails", ccsGet));


            $this->TemplatesEmails->Page = "TemplatesEmails.php";


            $this->TemplatesPages = new clsControl(ccsLink, "TemplatesPages", "TemplatesPages", ccsText, "", CCGetRequestParam("TemplatesPages", ccsGet));


            $this->TemplatesPages->Page = "TemplatesPages.php";


            $this->AdministratorsList = new clsControl(ccsLink, "AdministratorsList", "AdministratorsList", ccsText, "", CCGetRequestParam("AdministratorsList", ccsGet));


            $this->AdministratorsList->Page = "AdministratorsList.php";


        }


    }


//End Class_Initialize Event





//Class_Terminate Event @1-A3749DF6


    function Class_Terminate()


    {


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeUnload");


    }


//End Class_Terminate Event





//BindEvents Method @1-FD8CABE2


    function BindEvents()


    {


        $this->CCSEvents["BeforeShow"] = "Header_BeforeShow";


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterInitialize");


    }


//End BindEvents Method





//Operations Method @1-F24547FA


    function Operations()


    {


        global $Redirect;


        if(!$this->Enabled)


            return "";


    }


//End Operations Method





//Initialize Method @1-61B81EE0


    function Initialize()


    {


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnInitializeView");


        if(!$this->Enabled)


            return "";


    }


//End Initialize Method





//Show Method @1-5CF0B6AD


    function Show($Name)


    {


        global $Tpl;


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow");


        if(!$this->Enabled)


            return "";


        $Tpl->LoadTemplate($this->TemplatePath . $this->TemplateFileName, $Name);


        $this->ItemsList->Show();


        $this->ListUsers->Show();


        $this->ChargesList->Show();


        $this->Online->Show();


        $this->CategoriesList->Show();


        $this->SettingsGeneral->Show();


        $this->AccountingSettings->Show();


        $this->Fees->Show();


        $this->ImageSettings->Show();


        $this->ListingDates->Show();


        $this->AgesList->Show();


        $this->EducationsList->Show();


        $this->IncomesList->Show();


        $this->StatesList->Show();


        $this->CountriesList->Show();


        $this->Newsletters->Show();


        $this->TemplatesEmails->Show();


        $this->TemplatesPages->Show();


        $this->AdministratorsList->Show();


        $db = new clsDBNetConnect;


            @$db->query("show tables like \"phpads_zones\"");


            if ($db->next_record()){


				if (file_exists("../phpads/index.php")){


					$Tpl->SetVar("phpads","<a class=\"ItechClsDataLink\" href=\"../phpads/\">phpAdsNew <br>Admin Login</a>");


				}else{


					$Tpl->SetVar("phpads","<a class=\"ItechClsDataLink\" href=\"phpads.php\">Install phpAdsNew</a>");


				}


			}else{


				$Tpl->SetVar("phpads","<a class=\"ItechClsDataLink\" href=\"phpads.php\">Install phpAdsNew</a>");


			}


        $Tpl->Parse($Name, false);


        $Tpl->SetVar($Name, $Tpl->GetVar($Name));


    }


//End Show Method





} //End Header Class @1-FCB6E20C





//Include Event File @1-6D4F2746


include("./Header_events.php");
?>