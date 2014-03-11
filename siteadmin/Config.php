<?FFE3E3
<?php
#####################################################
# 1.- Full Home Path                                #
# Enter the full path to the program                #
# Example: http://www.yoursite.com/classifieds/     #
# Note: Do not forget the http:// and the trailing  #
# slash at the end                                  #
#####################################################
$Home_URL = "http://lab.demonstrationserver.com/classifieds/";
#####################################################
# 2.- SSL Full Path                                 #
# Enter the full path to the program if you are     #
# using SSL. If you are not using SSL, you can      #
# either leave this blank or use your regular path. #
# Example: https://www.yoursite.com/classifieds/    #
# Note: Do not forget the https:// (if required)    #
# and the trailing slash at the end                 #
#####################################################
$Secure_URL = "http://lab.demonstrationserver.com/classifieds/";
#####################################################
# 3.- Secure Certificate Options                    #
# If you are using SSL, Set this to 1. If not,      #
# leave it at 0                                     #
#####################################################
$SSL_Required = 0;
#####################################################
# 4.- Database Connection                           #
# These are your Database connection details.       #
# Follow the instructions next to each variable.    #
#####################################################
$dbs = array(
"DB_NAME" => "labdemo_classifieds", // The name of the database that this program will use
"DB_HOST" => "localhost", // The host that this database is on. Ex. localhost or mysql.yoursite.com or 65.29.231.91
"DB_USER" => "labdemo_user", // The username setup to use this database. Must have Read/Write access
"DB_PASS" => "resolute432" // The password for the above user
);
#####################################################
# 5.- Password Options                              #
# Enter the number of words you would like the      #
# password generator to use when creating new       #
# passwords.                                        #
#####################################################
$config_NumberOfWords = 2;
#####################################################
# 6.- Password Options                              #
# Enter the number of digits you would like the     #
# password generator to use in between words when   #
# creating new passwords.                           #
#####################################################
$config_MaxNumberOfDigitBetweenWords = 2;
#####################################################
# 7.- Password Options                              #
# Would you like digits after the last word of the  #
# newly generated password.                         #
# TRUE for yes                                      #
# FALSE for no                                      #
#####################################################
$config_DigitsAfterLastWord = FALSE;
#####################################################
# 8.- Auto Cron.php on page loads                   #
# Would you like the Cron.php code to be autorun on #
# each page load (for sites without cron support)   #
# TRUE for yes                                      #
# FALSE for no                                      #
#####################################################
$config_autocron = FALSE;

#####################################################
# 9.- Notify Email Time                             #
# Sets up the script to send an email to the user   #
# when a listing they own is about to expire.       #
# Number of days in advance to send the email       #
# Blank (empty quotes) for no notification          #
#####################################################
$notify_time = 0;


#####################################################
#        DO NOT EDIT BELOW THIS LINE!!!             #
#        DO NOT EDIT BELOW THIS LINE!!!             #
#####################################################


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
