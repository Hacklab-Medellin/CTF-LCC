<?
$Home_URL = "http://classi.demonstrationserver.com/";
$Secure_URL = "http://classi.demonstrationserver.com/";
$SSL_Required = 0;
$dbs = array(
"DB_NAME" => "Las_reses", // The name of the database that this program will use
"DB_HOST" => "localhost", // The host that this database is on. Ex. localhost or mysql.yoursite.com or 65.29.231.91
"DB_USER" => "root", // The username setup to use this database. Must have Read/Write access
"DB_PASS" => "TOOR" // The password for the above user
);
$config_NumberOfWords = 2;
$config_MaxNumberOfDigitBetweenWords = 2;
$config_DigitsAfterLastWord = FALSE;
$config_autocron = FALSE;
$notify_time = 0;
if(!ini_get('register_globals')) {


   if(version_compare(phpversion(), "4.1.2", "<")) {


      echo "Incompatible PHP Version";


      echo "Please see http://www.itechscripts.com for more information";


      exit();


   }


   if(version_compare(phpversion(), "4.3.0", "<")) {


      if(is_array($_SERVER)) extract($_SERVER, EXTR_SKIP);


      if(is_array($_COOKIE)) extract($_COOKIE, EXTR_SKIP);


      if(is_array($_POST)) extract($_POST, EXTR_SKIP);


      if(is_array($_GET)) extract($_GET, EXTR_SKIP);


      if(is_array($_ENV)) extract($_ENV, EXTR_SKIP);


      if(is_array($_FILES)) extract($_FILES, EXTR_SKIP);


   }


   else {


      if(is_array($_SERVER)) extract($_SERVER, EXTR_SKIP|EXTR_REFS);


      if(is_array($_COOKIE)) extract($_COOKIE, EXTR_SKIP|EXTR_REFS);


      if(is_array($_POST)) extract($_POST, EXTR_SKIP|EXTR_REFS);


      if(is_array($_GET)) extract($_GET, EXTR_SKIP|EXTR_REFS);


      if(is_array($_ENV)) extract($_ENV, EXTR_SKIP|EXTR_REFS);


      if(is_array($_FILES)) extract($_FILES, EXTR_SKIP|EXTR_REFS);


   }


}
$admingroup = TRUE;
?>
