<?php
session_start();
include(RelativePath . "/Classes.php");
include(RelativePath . "/db_mysql.php");
include("../Config/vars.php");
include("../Version.php");
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

define("TemplatePath", "./");  //Do not Change!!!
define("ServerURL", $Home_URL);
define("SecureURL", $Secure_URL);


$ShortWeekdays = array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

$Weekdays = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

$ShortMonths =  array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$Months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");



define("ccsInteger", 1);

define("ccsFloat", 2);

define("ccsText", 3);

define("ccsDate", 4);

define("ccsBoolean", 5);

define("ccsMemo", 6);



define("ccsGet", 1);

define("ccsPost", 2);



define("ccsTimestamp", 0);

define("ccsYear", 1);

define("ccsMonth", 2);

define("ccsDay", 3);

define("ccsHour", 4);

define("ccsMinute", 5);

define("ccsSecond", 6);

define("ccsAmPm", 7);

define("ccsShortMonth", 8);

define("ccsFullMonth", 9);

define("ccsWeek", 10);

define("ccsGMT", 11);

define("ccsAppropriateYear", 12);

//End Initialize Common Variables



//DBNetConnect Connection Class @-5F5E2182

class clsDBDBNetConnect extends DB_MySQL

{



    var $DateFormat;

    var $BooleanFormat;

    var $LastSQL;

    var $Errors;



    var $RecordsCount;

    var $RecordNumber;

    var $PageSize;

    var $AbsolutePage;



    var $SQL = "";

    var $Where = "";

    var $Order = "";



    var $Parameters;

    var $wp;



    function clsDBDBNetConnect()

    {

        $this->Initialize();

    }



    function Initialize()

    {

        global $dbs;

	  $this->AbsolutePage = 0;

        $this->PageSize = 0;

        $this->Database = $dbs["DB_NAME"];

        $this->Host = $dbs["DB_HOST"];

        $this->User = $dbs["DB_USER"];

        $this->Password = $dbs["DB_PASS"];

        $this->Persistent = true;

        $this->RecordsCount = 0;

        $this->RecordNumber = 0;

        $this->DateFormat = Array("mm", "/", "dd", "/", "yyyy", " ", "HH", ":", "nn", ":", "ss");

        $this->BooleanFormat = Array(1, 0, "");

        $this->Errors = New clsErrors();

    }



    function MoveToPage($Page)

    {

        if($this->RecordNumber == 0 && $this->PageSize != 0 && $Page != 0)

            while($this->RecordNumber < ($Page - 1) * $this->PageSize && $this->next_record())

                $this->RecordNumber++;

    }

    function PageCount()

    {

        return ceil($this->RecordsCount / $this->PageSize);

    }



    function ToSQL($Value, $ValueType)

    {

        if(strlen($Value) || ($ValueType == ccsBoolean && is_bool($Value)))

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsDate)

            {

                return "'" . addslashes($Value) . "'";

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else

                    $Value = "'" . addslashes($Value) . "'";

                return $Value;

            }

            else

            {

                return "'" . addslashes($Value) . "'";

            }

        }

        else

        {

            return "NULL";

        }

    }



    function SQLValue($Value, $ValueType)

    {

        if(!strlen($Value))

        {

            return "NULL";

        }

        else

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else

                    $Value = addslashes($Value);

                return $Value;

            }

            else

            {

                return addslashes($Value);

            }

        }

    }





}

//End DBNetConnect Connection Class



class clsDBNetConnect extends DB_MySQL

{



    var $DateFormat;

    var $BooleanFormat;

    var $LastSQL;

    var $Errors;



    var $RecordsCount;

    var $RecordNumber;

    var $PageSize;

    var $AbsolutePage;



    var $SQL = "";

    var $Where = "";

    var $Order = "";



    var $Parameters;

    var $wp;



    function clsDBNetConnect()

    {

        $this->Initialize();

    }



    function Initialize()

    {

        global $dbs;

	  $this->AbsolutePage = 0;

        $this->PageSize = 0;

        $this->Database = $dbs["DB_NAME"];

        $this->Host = $dbs["DB_HOST"];

        $this->User = $dbs["DB_USER"];

        $this->Password = $dbs["DB_PASS"];

        $this->Persistent = true;

        $this->RecordsCount = 0;

        $this->RecordNumber = 0;

        $this->DateFormat = Array("mm", "/", "dd", "/", "yyyy", " ", "HH", ":", "nn", ":", "ss");

        $this->BooleanFormat = Array(1, 0, "");

        $this->Errors = New clsErrors();

    }



    function MoveToPage($Page)

    {

        if($this->RecordNumber == 0 && $this->PageSize != 0 && $Page != 0)

            while($this->RecordNumber < ($Page - 1) * $this->PageSize && $this->next_record())

                $this->RecordNumber++;

    }

    function PageCount()

    {

        return ceil($this->RecordsCount / $this->PageSize);

    }



    function ToSQL($Value, $ValueType)

    {

        if(strlen($Value) || ($ValueType == ccsBoolean && is_bool($Value)))

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsDate)

            {

                return "'" . addslashes($Value) . "'";

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else if(strtoupper($Value) == "TRUE" || strtoupper($Value) == "FALSE")

                    $Value = strtoupper($Value);

                else

                    $Value = "'" . addslashes($Value) . "'";

                return $Value;

            }

            else

            {

                return "'" . addslashes($Value) . "'";

            }

        }

        else

        {

            return "NULL";

        }

    }



    function SQLValue($Value, $ValueType)

    {

        if(!strlen($Value))

        {

            return "NULL";

        }

        else

        {

            if($ValueType == ccsInteger || $ValueType == ccsFloat)

            {

                return doubleval(str_replace(",", ".", $Value));

            }

            else if($ValueType == ccsBoolean)

            {

                if(is_bool($Value))

                    $Value = $Value ? "1" : "0";

                else if(is_numeric($Value))

                    $Value = intval($Value);

                else if(strtoupper($Value) == "TRUE" || strtoupper($Value) == "FALSE")

                    $Value = strtoupper($Value);

                else

                    $Value = addslashes($Value);

                return $Value;

            }

            else

            {

                return addslashes($Value);

            }

        }

    }





}





//CCToHTML @0-93F44B0D

function CCToHTML($Value)

{

  return htmlspecialchars($Value);

}

//End CCToHTML



//CCToURL @0-88FAFE26

function CCToURL($Value)

{

  return urlencode($Value);

}

//End CCToURL



//CCGetEvent @0-903C07B4

function CCGetEvent($events, $event_name)

{

  $result = "";

  $function_name = (is_array($events) && isset($events[$event_name])) ? $events[$event_name] : "";

  if($function_name && function_exists($function_name))

    $result = call_user_func ($function_name);

  $result = (strlen($result) || $result === false) ? $result : true;

  return $result;  

}

//End CCGetEvent



//CCGetValueHTML @0-0180C79D

function CCGetValueHTML($db, $fieldname)

{

  return htmlspecialchars($db->f($fieldname));

}

//End CCGetValueHTML



//CCGetValue @0-EAF96C23

function CCGetValue($db, $fieldname)

{

  return $db->f($fieldname);

}

//End CCGetValue



//CCGetSession @0-9BBC6D71

function CCGetSession($parameter_name)

{

    global $_SESSION;

    return isset($_SESSION[$parameter_name]) ? $_SESSION[$parameter_name] : "";

}

//End CCGetSession



//CCSetSession @0-1F870DB4

function CCSetSession($param_name, $param_value)

{

 global ${$param_name};

  if(session_is_registered($param_name))

    session_unregister($param_name);

  ${$param_name} = $param_value;

  session_register($param_name);

  $_SESSION[$param_name] = $param_value;

}

//End CCSetSession



//CCGetCookie @0-705AF8CB

function CCGetCookie($parameter_name)

{

    global $_COOKIE;

    return isset($_COOKIE[$parameter_name]) ? $_COOKIE[$parameter_name] : "";

}

//End CCGetCookie



//CCSetCookie @0-1E0B074A

function CCSetCookie($parameter_name, $param_value)

{

  setcookie ($parameter_name, $param_value, time() + 3600 * 24 * 366);  

}

//End CCSetCookie



//CCStrip @0-F5DAB56A

function CCStrip($value)

{

  if(get_magic_quotes_gpc() == 0)

    return $value;

  else

    return stripslashes($value);

}

//End CCStrip



//CCGetParam @0-C3E4B53D

function CCGetParam($parameter_name, $default_value)

{

    global $_POST;

    global $_GET;

    $parameter_value = "";

    if(isset($_POST[$parameter_name]))

        $parameter_value = CCStrip($_POST[$parameter_name]);

    else if(isset($_GET[$parameter_name]))

        $parameter_value = CCStrip($_GET[$parameter_name]);

    else

        $parameter_value = $default_value;

    return $parameter_value;

}

//End CCGetParam



//CCGetFromPost @0-1067CEA0

function CCGetFromPost($parameter_name, $default_value)

{

    global $_POST;

    return isset($_POST[$parameter_name]) ? CCStrip($_POST[$parameter_name]) : $default_value;

}

//End CCGetFromPost



//CCGetFromGet @0-BAD57EE5

function CCGetFromGet($parameter_name, $default_value)

{

    global $_GET;

    return isset($_GET[$parameter_name]) ? CCStrip($_GET[$parameter_name]) : $default_value;

}

//End CCGetFromGet



//CCToSQL @0-422F5B92

function CCToSQL($Value, $ValueType)

{

  if(!strlen($Value))

  {

    return "NULL";

  }

  else

  {

    if($ValueType == ccsInteger || $ValueType == ccsFloat)

    {

      return doubleval(str_replace(",", ".", $Value));

    }

    else

    {

      return "'" . str_replace("'", "''", $Value) . "'";

    }

  }

}

//End CCToSQL



//CCDLookUp @0-A937C7E0

function CCDLookUp($field_name, $table_name, $where_condition, $db)

{

  $sql = "SELECT " . $field_name . " FROM " . $table_name . ($where_condition ? " WHERE " . $where_condition : "");

  return CCGetDBValue($sql, $db);

}

//End CCDLookUp



//CCGetDBValue @0-417763E3

function CCGetDBValue($sql, $db)

{

  $db->query($sql);

  if($db->next_record())

    return $db->f(0);

  else 

    return "";

}

//End CCGetDBValue



//CCGetListValues @0-5D6EE70E

function CCGetListValues($db, $sql, $where = "", $order_by = "", $bound_column = "", $text_column = "")

{

    $values = "";

    if(!strlen($bound_column))

        $bound_column = 0;

    if(!strlen($text_column))

        $text_column = 1;

    if(strlen($where))

        $sql .= " WHERE " . $where;

    if(strlen($order_by))

        $sql .= " ORDER BY " . $order_by;

    $db->query($sql);

    if ($db->next_record())

    {

        do

        {

            $values[] = array($db->f($bound_column), $db->f($text_column));

        } while ($db->next_record());

    }

    return $values;

}



//End CCGetListValues



//CCBuildSQL @0-AD00EEB4

function CCBuildSQL($sql, $where = "", $order_by = "")

{

    if(strlen($where))

        $sql .= " WHERE " . $where;

    if(strlen($order_by))

        $sql .= " ORDER BY " . $order_by;

    return $sql;

}



//End CCBuildSQL



//CCGetRequestParam @0-1C3CB87C

function CCGetRequestParam($ParameterName, $Method)

{

    global $_POST;

    global $_GET;

    $ParameterValue = "";

    if($Method == ccsGet && isset($_GET[$ParameterName]))

        $ParameterValue = CCStrip($_GET[$ParameterName]);

    else if($Method == ccsPost && isset($_POST[$ParameterName]))

        $ParameterValue = CCStrip($_POST[$ParameterName]);

    return $ParameterValue;

}

//End CCGetRequestParam



//CCGetQueryString @0-F67D7840

function CCGetQueryString($CollectionName, $RemoveParameters)

{

    global $_POST;

    global $_GET;

    $querystring = "";

    $postdata = "";

    if($CollectionName == "Form")

        $querystring = CCCollectionToString($_POST, $RemoveParameters);

    else if($CollectionName == "QueryString")

        $querystring = CCCollectionToString($_GET, $RemoveParameters);

    else if($CollectionName == "All")

    {

        $querystring = CCCollectionToString($_GET, $RemoveParameters);

        $postdata = CCCollectionToString($_POST, $RemoveParameters);

        if(strlen($postdata) > 0 && strlen($querystring) > 0)

            $querystring .= "&" . $postdata;

        else

            $querystring .= $postdata;

    }

    else

        die("1050: Common Functions. CCGetQueryString Function. " .

            "The CollectionName contains an illegal value.");

    return $querystring;

}

//End CCGetQueryString



//CCCollectionToString @0-883F2B49

function CCCollectionToString($ParametersCollection, $RemoveParameters)

{

  $Result = ""; 

  if(is_array($ParametersCollection))

  {

    reset($ParametersCollection);

    foreach($ParametersCollection as $ItemName => $ItemValues)

    {

      $Remove = false;

      if(is_array($RemoveParameters))

      {

        for($I = 0; $I < sizeof($RemoveParameters); $I++)

        {

          if($RemoveParameters[$I] == $ItemName)

          {

            $Remove = true;

            break;

          }

        }

      }

      if(!$Remove)

      {

        if(is_array($ItemValues))

          for($J = 0; $J < sizeof($ItemValues); $J++)

            $Result .= "&" . $ItemName . "[]=" . urlencode(CCStrip($ItemValues[$J]));

        else

           $Result .= "&" . $ItemName . "=" . urlencode(CCStrip($ItemValues));

      }

    }

  }



  if(strlen($Result) > 0)

    $Result = substr($Result, 1);

  return $Result;

}

//End CCCollectionToString



//CCAddParam @0-56573314

function CCAddParam($querystring, $ParameterName, $ParameterValue)

{

    global $_GET;

    $Result = "";

    $CurrentParameterValue = isset($_GET[$ParameterName]) ? $_GET[$ParameterName] : "";

    $Result = str_replace($ParameterName . "=" . urlencode($CurrentParameterValue), "", $querystring);

    $Result .= "&" . $ParameterName . "=" . urlencode($ParameterValue);

    $Result = str_replace("&&", "&", $Result);

    if (substr($Result, 0, 1) == "&")

        $Result = substr($Result, 1);

    return $Result;

}

//End CCAddParam



//CCRemoveParam @0-9355EFB5

function CCRemoveParam($querystring, $ParameterName)

{

    global $_GET;

    $Result = "";

    $Result = str_replace($ParameterName . "=" . urlencode($_GET[$ParameterName]), "", $querystring);

    $Result = str_replace("&&", "&", $Result);

    if (substr($Result, 0, 1) == "&")

        $Result = substr($Result, 1);

    return $Result;

}

//End CCRemoveParam



//CCGetOrder @0-27B4AC18

function CCGetOrder($DefaultSorting, $SorterName, $SorterDirection, $MapArray)

{

  if(is_array($MapArray) && isset($MapArray[$SorterName]))

    if(strtoupper($SorterDirection) == "DESC")

      $OrderValue = ($MapArray[$SorterName][1] != "") ? $MapArray[$SorterName][1] : $MapArray[$SorterName][0] . " DESC";

    else

      $OrderValue = $MapArray[$SorterName][0];

  else

    $OrderValue = $DefaultSorting;



  return $OrderValue;

}

//End CCGetOrder



//CCGetDateArray @0-7F53F050

function CCGetDateArray($timestamp)

{

  $DateArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

  if(strlen($timestamp) && is_numeric($timestamp))

  {

    $DateArray[ccsTimestamp] = $timestamp;

    $DateArray[ccsYear] = date("Y", $timestamp);

    $DateArray[ccsMonth] = date("n", $timestamp);

    $DateArray[ccsDay] = date("j", $timestamp);

    $DateArray[ccsHour] = date("G", $timestamp);

    $DateArray[ccsMinute] = date("i", $timestamp);

    $DateArray[ccsSecond] = date("s", $timestamp);

  }

  return $DateArray;

}

//End CCGetDateArray





//CCFormatDate @0-C97FDD0E

function CCFormatDate($DateToFormat, $FormatMask)

{

  global $ShortWeekdays;

  global $Weekdays;

  global $ShortMonths;

  global $Months;



  if(!is_array($DateToFormat) && strlen($DateToFormat))

    $DateToFormat = CCGetDateArray($DateToFormat);



  if(is_array($FormatMask) && is_array($DateToFormat))

  {

    $masks = array(

      "GeneralDate" => "n/j/y, h:i:s A", "LongDate" => "l, F j, Y",

      "ShortDate" => "n/j/y", "LongTime" => "g:i:s A",

      "ShortTime" => "H:i", "d" => "j", "dd" => "d",

      "m" => "n", "mm" => "m", 

      "h" => "g", "hh" => "h", "H" => "G", "HH" => "H",

      "nn" => "i", "ss" => "s", "AM/PM" => "A", "am/pm" => "a"

    );

    $FormatedDate = "";

    for($i = 0; $i < sizeof($FormatMask); $i++)

    {

      if(isset($masks[$FormatMask[$i]]))

      {

        $FormatedDate .= date($masks[$FormatMask[$i]], $DateToFormat[ccsTimestamp]);

      }

      else

      {

        switch ($FormatMask[$i])

        {

          case "yy": 

            $FormatedDate .= substr($DateToFormat[ccsYear], 2);

            break;

          case "yyyy": 

            $FormatedDate .= $DateToFormat[ccsYear];

            break;

          case "ddd": 

            $FormatedDate .= $ShortWeekdays[date("w", $DateToFormat[ccsTimestamp])];

            break;

          case "dddd": 

            $FormatedDate .= $Weekdays[date("w", $DateToFormat[ccsTimestamp])];

            break;

          case "w": 

            $FormatedDate .= (date("w", $DateToFormat[ccsTimestamp]) + 1);

            break;

          case "ww": 

            $FormatedDate .= ceil((6 + date("z", $DateToFormat[ccsTimestamp]) - date("w", $DateToFormat[ccsTimestamp])) / 7);

            break;

          case "mmm": 

            $FormatedDate .= $ShortMonths[date("n", $DateToFormat[ccsTimestamp]) - 1];

            break;

          case "mmmm":

            $FormatedDate .= $Months[date("n", $DateToFormat[ccsTimestamp]) - 1];

            break;

          case "q":

            $FormatedDate .= ceil(date("n", $DateToFormat[ccsTimestamp]) / 3);

            break;

          case "y":

            $FormatedDate .= (date("z", $DateToFormat[ccsTimestamp]) + 1);

            break;

          case "n": 

            $FormatedDate .= intval(date("i", $DateToFormat[ccsTimestamp]));

            break;

          case "s":

            $FormatedDate .= intval(date("s", $DateToFormat[ccsTimestamp]));

            break;

          case "A/P":

            $am = date("A", $DateToFormat[ccsTimestamp]);

            $FormatedDate .= $am[0];

            break;

          case "a/p":

            $am = date("a", $DateToFormat[ccsTimestamp]);

            $FormatedDate .= $am[0];

            break;

          case "GMT":

            $gmt = date("Z", $DateToFormat[ccsTimestamp]) / (60 * 60);

            if($gmt >= 0) $gmt = "+" . $gmt;

            $FormatedDate .= $gmt;

            break;

          default:

            $FormatedDate .= $FormatMask[$i];

            break;

        }

      }

    }

  }

  else

  {

    $FormatedDate = "";

  }

  return $FormatedDate;

}

//End CCFormatDate



//CCValidateDate @0-79CC2BE1

function CCValidateDate($ValidatingDate, $FormatMask)

{

  $IsValid = true;

  if(is_array($FormatMask) && strlen($ValidatingDate))

  {

    $RegExp = CCGetDateRegExp($FormatMask);

    $IsValid = preg_match($RegExp[0], $ValidatingDate, $matches);

  }



  return $IsValid;

}

//End CCValidateDate



//CCParseDate @0-307D0235

function CCParseDate($ParsingDate, $FormatMask)

{

  global $ShortMonths;

  global $Months;



  if(is_array($FormatMask) && strlen($ParsingDate))

  {

    $DateArray = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $RegExp = CCGetDateRegExp($FormatMask);

    $IsValid = preg_match($RegExp[0], $ParsingDate, $matches);

    for($i = 1; $i < sizeof($matches); $i++)

      $DateArray[$RegExp[$i]] = $matches[$i];



    if($DateArray[ccsMonth] == 0 && ($DateArray[ccsFullMonth] != 0 || $DateArray[ccsShortMonth] != 0))

    {

      if($DateArray[ccsFullMonth] != 0)

        $DateArray[ccsMonth] = CCGetIndex($Months, $DateArray[ccsFullMonth], true) + 1;

      else if($DateArray[ccsShortMonth] != 0)

        $DateArray[ccsMonth] = CCGetIndex($ShortMonths, $DateArray[ccsShortMonth], true) + 1;

    }



    if($DateArray[ccsHour] < 12 && strtoupper($DateArray[ccsAmPm][0]) == "P")

      $DateArray[ccsHour] += 12;



    if($DateArray[ccsHour] == 12 && strtoupper($DateArray[ccsAmPm][0]) == "A")

      $DateArray[ccsHour] = 0;



    if(strlen($DateArray[ccsYear]) == 2)

      if($DateArray[ccsYear] < 70)

        $DateArray[ccsYear] = "20" . $DateArray[ccsYear];

      else

        $DateArray[ccsYear] = "19" . $DateArray[ccsYear];

      

    if($DateArray[ccsYear] < 1971 && $DateArray[ccsYear] > 0)

      $DateArray[ccsAppropriateYear] = $DateArray[ccsYear] + intval((2000 - $DateArray[ccsYear]) / 28) * 28;

    else if($DateArray[ccsYear] > 2030)

      $DateArray[ccsAppropriateYear] = $DateArray[ccsYear] - intval(($DateArray[ccsYear] - 2000) / 28) * 28;



    //$ParsingDate = mktime ($DateArray[ccsHour], $DateArray[ccsMinute], $DateArray[ccsSecond], $DateArray[ccsMonth], $DateArray[ccsDay], $DateArray[ccsAppropriateYear]);

    $DateArray[ccsTimestamp] = mktime ($DateArray[ccsHour], $DateArray[ccsMinute], $DateArray[ccsSecond], $DateArray[ccsMonth], $DateArray[ccsDay], $DateArray[ccsAppropriateYear]);

    if($DateArray[ccsTimestamp] < 0) $ParsingDate = "";

    else $ParsingDate = $DateArray;

    

  }



  return $ParsingDate;

}

//End CCParseDate



//CCGetDateRegExp @0-9237C33C

function CCGetDateRegExp($FormatMask)

{

  global $ShortWeekdays;

  global $Weekdays;

  global $ShortMonths;

  global $Months;



  $RegExp = false;

  if(is_array($FormatMask))

  {

    $masks = array(

      "GeneralDate" => array("(\d{1,2})\/(\d{1,2})\/(\d{2}), (\d{2}):(\d{2}):(\d{2}) (AM|PM)", ccsMonth, ccsDay, ccsYear, ccsHour, ccsMinute, ccsSecond, ccsAmPm), 

      "LongDate" => array("(" . join("|", $Weekdays) . "), (" . join("|", $Months) . ") (\d{1,2}), (\d{4})", ccsWeek, ccsFullMonth, ccsDay, ccsYear),

      "ShortDate" => array("(\d{1,2})\/(\d{1,2})\/(\d{2})", ccsMonth, ccsDay, ccsYear), 

      "LongTime" => array("(\d{1,2}):(\d{2}):(\d{2}) (AM|PM)", ccsHour, ccsMinute, ccsSecond, ccsAmPm),

      "ShortTime" => array("(\d{2}):(\d{2})", ccsHour, ccsMinute), 

      "d" => array("(\d{1,2})", ccsDay), 

      "dd" => array("(\d{2})", ccsDay), 

      "ddd" => array("(" . join("|", $ShortWeekdays) . ")", ccsWeek), 

      "dddd" => array("(" . join("|", $Weekdays) . ")", ccsWeek), 

      "w" => array("\d"), "ww" => array("\d{1,2}"),

      "m" => array("(\d{1,2})", ccsMonth), "mm" => array("(\d{2})", ccsMonth), 

      "mmm" => array("(" . join("|", $ShortMonths) . ")", ccsShortMonth), 

      "mmmm" => array("(" . join("|", $Months) . ")", ccsFullMonth),

      "y" => array("\d{1,3}"), "yy" => array("(\d{2})", ccsYear), 

      "yyyy" => array("(\d{4})", ccsYear), "q" => array("\d"),

      "h" => array("(\d{1,2})", ccsHour), "hh" => array("(\d{2})", ccsHour), 

      "H" => array("(\d{1,2})", ccsHour), "HH" => array("(\d{2})", ccsHour),

      "n" => array("(\d{1,2})", ccsMinute), "nn" => array("(\d{2})", ccsMinute), 

      "s" => array("(\d{1,2})", ccsSecond), "ss" => array("(\d{2})", ccsSecond), 

      "AM/PM" => array("(AM|PM)", ccsAmPm), "am/pm" => array("(am|pm)", ccsAmPm), 

      "A/P" => array("(A|P)", ccsAmPm), "a/p" => array("(a|p)", ccsAmPm),

      "GMT" => array("([\+\-]\d{2})", ccsGMT)

    );

    $RegExp[0] = "";

    $RegExpIndex = 1;

    for($i = 0; $i < sizeof($FormatMask); $i++)

    {

      if(isset($masks[$FormatMask[$i]]))

      {

        $MaskArray = $masks[$FormatMask[$i]];

        $RegExp[0] .= $MaskArray[0];

        for($j = 1; $j < sizeof($MaskArray); $j++)

          $RegExp[$RegExpIndex++] = $MaskArray[$j];

      }

      else

        $RegExp[0] .= CCAddEscape($FormatMask[$i]);

    }

    $RegExp[0] = "/^" . $RegExp[0] . "$/";

  }



  return $RegExp;

}

//End CCGetDateRegExp



//CCAddEscape @0-06D50C27

function CCAddEscape($FormatMask)

{

  $meta_characters = array("\\", "^", "\$", ".", "[", "|", "(", ")", "?", "*", "+", "{", "-", "]", "/");

  for($i = 0; $i < sizeof($meta_characters); $i++)

    $FormatMask = str_replace($meta_characters[$i], "\\" . $meta_characters[$i], $FormatMask);

  return $FormatMask;

}

//End CCAddEscape



//CCGetIndex @0-8DB8E12C

function CCGetIndex($ArrayValues, $Value, $IgnoreCase = true)

{

  $index = false;

  for($i = 0; $i < sizeof($ArrayValues); $i++)

  {

    if(($IgnoreCase && strtoupper($ArrayValues[$i]) == strtoupper($Value)) || ($ArrayValues[$i] == $Value))

    {

      $index = $i;

      break;

    }

  }

  return $index;

}

//End CCGetIndex



//CCFormatNumber @0-B39A1596

function CCFormatNumber($NumberToFormat, $FormatArray)

{

  $Result = "";

  if(is_array($FormatArray) && strlen($NumberToFormat))

  {

    $IsExtendedFormat = $FormatArray[0];

    $IsNegative = ($NumberToFormat < 0);

    $NumberToFormat = abs($NumberToFormat);

    $NumberToFormat *= $FormatArray[7];

  

    if($IsExtendedFormat) // Extended format

    {

      $DecimalSeparator = $FormatArray[2];

      $PeriodSeparator = $FormatArray[3];

      $ObligatoryBeforeDecimal = 0;

      $DigitsBeforeDecimal = 0;

      $BeforeDecimal = $FormatArray[5];

      $AfterDecimal = $FormatArray[6];

      if(is_array($BeforeDecimal)) {

        for($i = 0; $i < sizeof($BeforeDecimal); $i++) {

          if($BeforeDecimal[$i] == "0") {

            $ObligatoryBeforeDecimal++;

            $DigitsBeforeDecimal++;

          } else if($BeforeDecimal[$i] == "#") 

            $DigitsBeforeDecimal++;

        }

      }

      $ObligatoryAfterDecimal = 0;

      $DigitsAfterDecimal = 0;

      if(is_array($AfterDecimal)) {

        for($i = 0; $i < sizeof($AfterDecimal); $i++) {

          if($AfterDecimal[$i] == "0") {

            $ObligatoryAfterDecimal++;

            $DigitsAfterDecimal++;

          } else if($AfterDecimal[$i] == "#")

            $DigitsAfterDecimal++;

        }

      }

  

      $NumberToFormat = number_format($NumberToFormat, $DigitsAfterDecimal, ".", "");

      $NumberParts = explode(".", $NumberToFormat);



      $LeftPart = $NumberParts[0];

      if($LeftPart == "0") $LeftPart = "";

      $RightPart = isset($NumberParts[1]) ? $NumberParts[1] : "";

      $j = strlen($LeftPart);

    

      if(is_array($BeforeDecimal))

      {

        $RankNumber = 0;

        $i = sizeof($BeforeDecimal);

        while ($i > 0 || $j > 0)

        {

          if(($i > 0 && ($BeforeDecimal[$i - 1] == "#" || $BeforeDecimal[$i - 1] == "0")) || ($j > 0 && $i < 1)) {

            $RankNumber++;

            $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";

            if($ObligatoryBeforeDecimal > 0 && $j < 1)

              $Result = "0" . $CurrentSeparator . $Result;

            else if($j > 0)

              $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;

            $j--;

            $ObligatoryBeforeDecimal--;

            $DigitsBeforeDecimal--;

            if($DigitsBeforeDecimal == 0 && $j > 0)

              for(;$j > 0; $j--)

              {

                $RankNumber++;

                $CurrentSeparator = ($RankNumber % 3 == 1 && $RankNumber > 3 && $j > 0) ? $PeriodSeparator : "";

                $Result = $LeftPart[$j - 1] . $CurrentSeparator . $Result;

              }

          }

          else if ($i > 0) {

            $BeforeDecimal[$i - 1] = str_replace("##", "#", $BeforeDecimal[$i - 1]);

            $BeforeDecimal[$i - 1] = str_replace("00", "0", $BeforeDecimal[$i - 1]);

            $Result = $BeforeDecimal[$i - 1] . $Result;

          }

          $i--;

        }

      }



      // Left part after decimal

      $RightResult = "";

      $IsRightNumber = false;

      if(is_array($AfterDecimal))

      {

        $IsZero = true;

        for($i = sizeof($AfterDecimal); $i > 0; $i--) {

          if($AfterDecimal[$i - 1] == "#" || $AfterDecimal[$i - 1] == "0") {

            if($DigitsAfterDecimal > $ObligatoryAfterDecimal) {

              if($RightPart[$DigitsAfterDecimal - 1] != "0") 

                $IsZero = false;

              if(!$IsZero)

              {

                $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;

                $IsRightNumber = true;

              }

            } else {

              $RightResult = $RightPart[$DigitsAfterDecimal - 1] . $RightResult;

              $IsRightNumber = true;

            }

            $DigitsAfterDecimal--;

          } else {

            $AfterDecimal[$i - 1] = str_replace("##", "#", $AfterDecimal[$i - 1]);

            $AfterDecimal[$i - 1] = str_replace("00", "0", $AfterDecimal[$i - 1]);

            $RightResult = $AfterDecimal[$i - 1] . $RightResult;

          }

        }

      }

    

      if($IsRightNumber)

        $Result .= $DecimalSeparator ;



      $Result .= $RightResult;



      if(!$FormatArray[4] && $IsNegative && $Result)

        $Result = "-" . $Result;

    }

    else // Simple format

    {

      if(!$FormatArray[4] && $IsNegative)

        $Result = "-" . $FormatArray[5] . number_format($NumberToFormat, $FormatArray[1], $FormatArray[2], $FormatArray[3]) . $FormatArray[6];

      else

        $Result = $FormatArray[5] . number_format($NumberToFormat, $FormatArray[1], $FormatArray[2], $FormatArray[3]) . $FormatArray[6];

    }



    if(!$FormatArray[8])

      $Result = htmlspecialchars($Result);



    if(strlen($FormatArray[9]))

      $Result = "<FONT COLOR=\"" . $FormatArray[9] . "\">" . $Result . "</FONT>";

  }

  else

  {

    $Result = $NumberToFormat;

  }



  return $Result;

}

//End CCFormatNumber



//CCValidateNumber @0-D53857C4

function CCValidateNumber($NumberValue, $FormatArray)

{

  $is_valid = true;

  if(strlen($NumberValue))

  {

    $NumberValue = CCCleanNumber($NumberValue, $FormatArray);

    $is_valid = is_numeric($NumberValue);

  }

  return $is_valid;

}



//End CCValidateNumber



//CCParseNumber @0-51D95F29

function CCParseNumber($NumberValue, $FormatArray, $DataType)

{

  $NumberValue = CCCleanNumber($NumberValue, $FormatArray);

  if(is_array($FormatArray) && strlen($NumberValue))

  {



    if($FormatArray[4]) // Is use parenthesis

      $NumberValue = - abs(doubleval($NumberValue));



    $NumberValue /= $FormatArray[7];

  }



  if(strlen($NumberValue))

  {

    if($DataType == ccsFloat)

      $NumberValue = doubleval($NumberValue);

    else

      $NumberValue = round($NumberValue, 0);

  }



  return $NumberValue;

}

//End CCParseNumber



//CCCleanNumber @0-2A278526

function CCCleanNumber($NumberValue, $FormatArray)

{

  if(is_array($FormatArray))

  {

    $IsExtendedFormat = $FormatArray[0];



    if($IsExtendedFormat) // Extended format

    {

      $BeforeDecimal = $FormatArray[5];

      $AfterDecimal = $FormatArray[6];

    

      if(is_array($BeforeDecimal))

      {

        for($i = sizeof($BeforeDecimal); $i > 0; $i--) {

          if($BeforeDecimal[$i - 1] != "#" && $BeforeDecimal[$i - 1] != "0") 

          {

            $search = $BeforeDecimal[$i - 1];

            $search = ($search == "##" || $search == "00") ? $search[0] : $search;

            $NumberValue = str_replace($search, "", $NumberValue);

          }

        }

      }



      if(is_array($AfterDecimal))

      {

        for($i = sizeof($AfterDecimal); $i > 0; $i--) {

          if($AfterDecimal[$i - 1] != "#" && $AfterDecimal[$i - 1] != "0") 

          {

            $search = $AfterDecimal[$i - 1];

            $search = ($search == "##" || $search == "00") ? $search[0] : $search;

            $NumberValue = str_replace($search, "", $NumberValue);

          }

        }

      }

    }

    else // Simple format

    {

      if(strlen($FormatArray[5]))

        $NumberValue = str_replace($FormatArray[5], "", $NumberValue);

      if(strlen($FormatArray[6]))

        $NumberValue = str_replace($FormatArray[6], "", $NumberValue);

    }



    if(strlen($FormatArray[3]))

      $NumberValue = str_replace($FormatArray[3], "", $NumberValue); // Period separator

    if(strlen($FormatArray[2]))

      $NumberValue = str_replace($FormatArray[2], ".", $NumberValue); // Decimal separator



    if(strlen($FormatArray[9]))

    {

      $NumberValue = str_replace("<FONT COLOR=\"" . $FormatArray[9] . "\">", "", $NumberValue);

      $NumberValue = str_replace("</FONT>", "", $NumberValue);

    }

  }

  $NumberValue = str_replace(",", ".", $NumberValue); // Decimal separator



  return $NumberValue;

}

//End CCCleanNumber



//CCParseInteger @0-FDF2EE85

function CCParseInteger($NumberValue, $FormatArray)

{

  return CCParseNumber($NumberValue, $FormatArray, ccsInteger);

}

//End CCParseInteger



//CCParseFloat @0-C9EAEA95

function CCParseFloat($NumberValue, $FormatArray)

{

  return CCParseNumber($NumberValue, $FormatArray, ccsFloat);

}

//End CCParseFloat



//CCValidateBoolean @0-7BAB2020

function CCValidateBoolean($BooleanValue, $Format)

{

  $Result = true;



  if(is_array($Format))

  {

    if(strtolower($BooleanValue) != strtolower($Format[0]) 

      && strtolower($BooleanValue) != strtolower($Format[1]) 

      && strtolower($BooleanValue) != strtolower($Format[2])

    )

      $Result = false;

  }



  return $Result;

}

//End CCValidateBoolean





//CCFormatBoolean @0-4E964142

function CCFormatBoolean($BooleanValue, $Format)

{

  $Result = $BooleanValue;



  if(is_array($Format))

  {

    if($BooleanValue)

      $Result = $Format[0];

    else if(strval($BooleanValue) == "0" || $BooleanValue === false)

      $Result = $Format[1];

    else

      $Result = $Format[2];

  }



  return $Result;

}

//End CCFormatBoolean



//CCParseBoolean @0-0C7716BC

function CCParseBoolean($Value, $Format)

{

  $Result = $Value;

  if(is_array($Format))

  {

    if(strtolower(strval($Value)) == strtolower(strval($Format[0])))

      $Result = true;

    else if(strtolower(strval($Value)) == strtolower(strval($Format[1])))

      $Result = false;

    else

      $Result = "";

  }

  return $Result;

}

//End CCParseBoolean



//CCCheckSSL @0-E299E90E

function CCCheckSSL()

{

  $protocol = getenv("SERVER_PROTOCOL");

  $protocol = substr($protocol, 0, 5);

  if($protocol != "HTTPS")

  {

    echo "SSL connection error. This page can be accessed only via secured connection.";

    exit;

  }

}



//End CCCheckSSL



//CCSecurityRedirect @0-11071578

function CCSecurityRedirect($GroupsAccess, $URL, $ReturnPage, $QueryString)

{

    $ErrorType = CCSecurityAccessCheck($GroupsAccess);

    if($ErrorType != "success")

    {

        if(!strlen($URL))

            $Link = "Login.php";

        else

            $Link = $URL;

        if(strlen($QueryString))

            $ReturnPage .= "?" . $QueryString;

        header("Location: " . $Link . "?ret_link=" . urlencode($ReturnPage) . "&type=" . $ErrorType);

        exit;

    }

}

//End CCSecurityRedirect



//CCSecurityAccessCheck @0-7B496647

function CCSecurityAccessCheck($GroupsAccess)

{

    $ErrorType = "success";

    if(!strlen(CCGetUserID()))

    {

        $ErrorType = "notLogged";

    }

    else

    {

        $GroupID = CCGetGroupID();

        if(!strlen($GroupID))

        {

            $ErrorType = "groupIDNotSet";

        }

        else

        {

            if(!CCUserInGroups($GroupID, $GroupsAccess))

                $ErrorType = "illegalGroup";

        }

    }

    return $ErrorType;

}

//End CCSecurityAccessCheck



//CCGetUserID @0-4295EF1C

function CCGetUserID()

{

    return CCGetSession("AdminID");

}

//End CCGetUserID



//CCGetGroupID @0-CDD2F173

function CCGetGroupID()

{

    return CCGetSession("AdminGroup");

}

//End CCGetGroupID



//CCGetUserLogin @0-16FC2393

function CCGetUserLogin()

{

    return CCGetSession("AdminLogin");

}

//End CCGetUserLogin



//CCGetUserPassword @0-FF9DADAF

function CCGetUserPassword()

{

    return CCGetSession("UserPassword");

}

//End CCGetUserPassword



//CCUserInGroups @0-51407098

function CCUserInGroups($GroupID, $GroupsAccess)

{

    $Result = "";

    if(strlen($GroupsAccess))

    {

        $GroupNumber = intval($GroupID);

        while(!$Result && $GroupNumber > 0)

        {

            $Result = (strpos(";" . $GroupsAccess . ";", ";" . $GroupNumber . ";") !== false);

            $GroupNumber--;

        }

    }

    else

    {

        $Result = true;

    }

    return $Result;

}

//End CCUserInGroups



//CCLoginUser @0-D80FB079

function CCLoginUser($Login, $Password)

{

    $db = new clsDBDBNetConnect();

    $SQL = "SELECT `admin_id`, `level` FROM `administrators` WHERE `username`=" . $db->ToSQL($Login, ccsText) . " AND `password`=" . $db->ToSQL($Password, ccsText);

    $db->query($SQL);

    $Result = $db->next_record();

    if($Result)

    {

        CCSetSession("AdminID", $db->f("admin_id"));

        CCSetSession("AdminLogin", $Login);

        CCSetSession("UserPassword", $Password);

        CCSetSession("AdminGroup", $db->f("level"));

    }

    unset($db);

    return $Result;

}

//End CCLoginUser



//CCLogoutUser @0-6451E5A4

function CCLogoutUser()

{

    CCSetSession("AdminID", "");

    CCSetSession("AdminLogin", "");

    CCSetSession("UserPassword", "");

    CCSetSession("AdminGroup", "");

}

//End CCLogoutUser



function GetUserNameID($Ider)

{

	$dbs = new clsDBDBNetConnect;

	$dbs->connect();

	$dbs->query("SELECT user_login FROM users WHERE user_id='" . $Ider . "'");

	if($dbs->next_record())

	{

		return $dbs->f(0);

	}

	else

	{

		return "No User Found!";

	}

	unset($dbs);

}

function GetUserStatus($status)

{

	if($status == 0)

	{

		$out = "On Hold";

	}

	if($status == 1)

	{

		$out = "Active";

	}

	if($status == 2)

	{

		$out = "Active";

	}

	if($status == 3)

	{

		$out = "Suspended";

	}

	return $out;

}

function GetItemStatus($status)

{

	if($status == 0)

	{

		$out = "Not Started";

	}

	if($status == 1)

	{

		$out = "Open";

	}

	if($status == 2)

	{

		$out = "Closed";

	}

	return $out;

}

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_general WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $now = array(

        "sitename"       => $db->f("sitename"),

        "siteemail"      => $db->f("siteemail"),

        "homeurl"        => $db->f("homeurl"),

        "secureurl"      => $db->f("secureurl"),

        "uploadurl"      => $db->f("uploadurl"),

        "pagentrys"      => $db->f("pagentrys"),

        "frontentrys"    => $db->f("frontentrys"),

        "notify"         => $db->f("notify"),

        "notifyemail"    => $db->f("notifyemail"),

        "timeout"        => $db->f("timeout")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize System Variables



//Initialize Accounting Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_accounting WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $accounting = array(

        "paypal_on"                  => $db->f("paypal_on"),

        "paypal"                     => $db->f("paypal"),

        "authorize_on"               => $db->f("authorizenet_on"),

        "authorize"                  => $db->f("authorizenet"),

	"authorize_tran_key"         => $db->f("authorize_tran_key")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize Accounting Variables



//Initialize Charges Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_charges WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $charges = array(

        "currency"      => $db->f("currency"),

        "listing_fee"   => $db->f("listing_fee"),

        "home_fee"      => $db->f("home_fee"),

        "cat_fee"       => $db->f("cat_fee"),

        "gallery_fee"   => $db->f("gallery_fee"),

        "image_pre_fee" => $db->f("image_pre_fee"),

        "slide_fee"     => $db->f("slide_fee"),

        "counter_fee"   => $db->f("counter_fee"),

        "bold_fee"      => $db->f("bold_fee"),

        "high_fee"      => $db->f("high_fee"),

        "upload_fee"   => $db->f("upload_fee")

        );

    }

$regcharges = $charges;

unset($db);

unset($SQL);

unset($Result);

//End Initialize Charges Variables



//Initialize Images Variables

$db = new clsDBNetConnect();

$SQL = "SELECT * FROM settings_images WHERE set_id='1'";

$db->query($SQL);

$Result = $db->next_record();

if($Result)

    {

        $images = array(

        "maxuploadwidth"  => $db->f("maxuploadwidth"),

                "maxuploadheight" => $db->f("maxuploadheight")

        );

    }



unset($db);

unset($SQL);

unset($Result);

//End Initialize Images Variables

function ReplacePA($str,$art)

{

      if($nr1=strpos($str,'['))

      {

        $tr=substr($str,0,$nr1);

        $nr2=strpos($str,']',$nr1);

        $tr.=$art[substr($str,$nr1+1,$nr2-$nr1-1)];

        $tr.=substr($str,$nr2+1);

        return ReplacePA($tr,$art);

      }

      else

      {

        $OUT = explode("76PULL*PULL76", $str);

        return $OUT[1];

      }

}



function mailnews($touser, $message, $subject, $EP)

{

      global $now;

      global $accounting;

      global $charges;

      

      

      $newsubject = ReplacePA("76PULL*PULL76" . $subject, $EP);  

      $newmessage = ReplacePA("76PULL*PULL76" . $message, $EP); 

      $to = $touser;

      $subject = $newsubject;      

      $message = $newmessage;      

      $from = $now["siteemail"];   

      $fromname = $now["sitename"];

      $additional_headers = "From: \"$fromname\" <$from>\nReply-To: $from";

      @mail ($to, $subject, $message, $additional_headers);

}



function PreviewTemplate($page) {

	$randname = gen_rand(8);

	$file = "../temp_templates/" . $randname . ".html";

    $fp = fopen($file,"w");

    fwrite($fp, stripslashes($_POST["page_temp"]), strlen(stripslashes($_POST["page_temp"])));

    fclose($fp);

	return $randname;

}



function gen_rand($char) {

    srand ((float) microtime() * 10000000);

    $array = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');

    srand ((double) microtime() * 10000000);

    $caa=(count($array)-1);

    $new_array=$array;

    for ($x=0;$x<=$caa;$x++)

    {

        $ca=(count($array)-1);

        $i=rand(0,$ca);

        $new_array[$x]=$array[$i];

        for ($t=$i;$t<$ca;$t++)

            $array[$t]=$array[$t+1];

        array_pop($array);

    }

    $rand_id = "";

    while ($num < $char){

        $rand_id .= $new_array["$num"];

        $num++;

    }



    return $rand_id;

}



function subscribe($user_id, $subsc_id, $paid = 0){

	global $EP;

	$db = new clsDBNetConnect;

	$query = "select * from subscription_plans where id = '" . $subsc_id . "'";

	$db->query($query);

	if ($db->next_record()){

		$db2 = new clsDBNetConnect;

		$query = "select * from used_subscriptions where user_id='" . $user_id . "' and subsc_id='" . $subsc_id . "' and expires>'" . time() . "'" ;

		$db2->query($query);

		if ($db2->next_record()){

			addtogroup($user_id, $db->f("group"), $db2->f("group"));

			$expires = $db2->f("expires");

			$duration = $db->f("duration");

			$duration = $duration*86400;

			$duration = $duration+$expires;

			if ($db->f("unlimited"))

				$duration = 9999999999;

			$query = "insert into used_subscriptions (`user_id`, `date`, `expires`, `subsc_id`, `paid`, `group`, `active`) values ('" . $user_id . "', '" . time() . "', '" . $duration . "', '" . $subsc_id . "', '" . $paid . "', '" . $db->f("group") . "', '1')";

			$db2->query($query);

		} else {

			addtogroup($user_id, $db->f("group"));

			$duration = $db->f("duration");

			$duration = $duration*86400;

			if ($db->f("intro") && $db->f("intro_price") == $paid){

				$duration = $db->f("intro_duration");

				$duration = $duration*86400;

			}

			$duration = $duration+time();

			if ($db->f("unlimited"))

				$duration = 9999999999;

			$query = "insert into used_subscriptions (`user_id`, `date`, `expires`, `subsc_id`, `paid`, `group`, `active`) values ('" . $user_id . "', '" . time() . "', '" . $duration . "', '" . $subsc_id . "', '" . $paid . "', '" . $db->f("group") . "', '1')";

			$db->query($query);

		}

		if ($duration == 9999999999)

			$EP["EMAIL_EXPIRES"] = "Never";

		else

			$EP["EMAIL_EXPIRES"] = date("F j, Y, g:i a", $duration);

		$return = $duration;

	}

	else {

		print "Invalid Subscription ID Specified";

		exit;

	}

	return $return;

}



function addtogroup($user_id, $addto, $removefrom=""){

	$db = new clsDBNetConnect;

	$query = "select * from groups where id=" . $addto;

	$db->query($query);

	if ($db->next_record()){

		$db2 = new clsDBNetConnect;

		$query = "delete from groups_users where user_id = '" . $user_id . "' and group_id = '" . $addto . "'";

		$db2->query($query);

		if ($removefrom){

			$query = "delete from groups_users where user_id = '" . $user_id . "' and group_id = '" . $group_id . "'";

			$db2->query($query);

		}

		$query = "insert into groups_users (`user_id`, `group_id`) values ('" . $user_id . "', '" . $addto . "')";

		$db2->query($query);

		if ($db->f("tokens") > 0){

			$tokens = $db->f("tokens");

			$query = "select tokens from users where user_id = $user_id";

			$db->query($query);

			if ($db->next_record()){

				$existingtokens = $db->f("tokens");

				$newtokens = $tokens + $existingtokens;

				$query = "update users set tokens = '" . $newtokens . "' where user_id = '" . $user_id . "'";

				$db->query($query);

			}

		}

	}

}



function endsubscription($active_id){

	$db = new clsDBNetConnect;

	$query = "select * from used_subscriptions where `id` = " . $active_id;

	$db->query($query);

	if ($db->next_record()){

		$group = $db->f("group");

		$user_id = $db->f("user_id");

		$query = "delete from groups_users where user_id = " . $user_id . " and group_id = " . $group;

		$db->query($query);

		$query = "update used_subscriptions set `active` = '0', expires = " . time() . " where `id` = " . $active_id;

		$db->query($query);

	}

}



function index_listing($ItemNum, $data="", $type="", $field_id="", $field_num=""){

	$db = new clsDBNetConnect;

	$db3 = new clsDBNetConnect;

	$terms = 0;

	$optionterms = 0;

	if (!$data && $ItemNum && !$type){

		$query = "SELECT pos FROM `listing_index` where `ItemNum` = $ItemNum order by pos desc limit 1";

		$db->query($query);

		if ($db->next_record()){

			$optionterms = $db->f("pos");

			$optionterms++;

			$optionterms++;

		}

		else

			$optionterms = 0;

		$query = "select * from items where ItemNum = '" . $ItemNum . "'";

		$db->query($query);

		if ($db->next_record()){

			$text = strip_tags(html_entity_decode($db->f("title") . " " . $db->f("description") . " " . $db->f("added_description") . " " . $db->f("city_town") . " " . $db->f("state_province")));

			$text = str_replace("\n", " ", $text);

			$text = str_replace(",", " ", $text);

			$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

			$array = explode(" ", $text);

			while (list($key, $value) = each($array)) {

				if (strlen($value) > 0) {

					$terms++;

					$optionterms++;

					$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`) values ('" . mysql_escape_string($db->f("ItemNum")) . "', '" . mysql_escape_string($value) . "', '" . $optionterms . "', 'main')";

					$db3->query($query);

				}

			}

		}

	}

	elseif ($data && $ItemNum && !$type) {

		$query = "SELECT pos FROM `listing_index` where `ItemNum` = $ItemNum order by pos desc limit 1";

		$db->query($query);

		if ($db->next_record()){

			$optionterms = $db->f("pos");

			$optionterms++;

			$optionterms++;

		}

		else

			$optionterms = 0;

		$text = strip_tags(html_entity_decode($data));

		$text = str_replace("\n", " ", $text);

		$text = str_replace(",", " ", $text);

		$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

		$array = explode(" ", $text);

		while (list($key, $value) = each($array)) {

			if (strlen($value) > 0) {

				$terms++;

				$optionterms++;

				$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`) values ('" . mysql_escape_string($ItemNum) . "', '" . mysql_escape_string($value) . "', '" . $optionterms . "', '" . $type . "')";

				$db3->query($query);

			}

		}

	}

	elseif ($data && $ItemNum && $type){

		$query = "SELECT pos FROM `listing_index` where `ItemNum` = $ItemNum order by pos desc limit 1";

		$db->query($query);

		if ($db->next_record()){

			$optionterms = $db->f("pos");

			$optionterms++;

			$optionterms++;

		}

		else

			$optionterms = 0;

		if ($type == "dd"){

			$query = "select * from custom_dropdown_options where `id` = $field_num";

			$db->query($query);

			if ($db->next_record()) {

				$data = $db->f("option");

			}

		}

		$text = strip_tags(html_entity_decode($data));

		$text = str_replace("\n", " ", $text);

		$text = str_replace(",", " ", $text);

		$text = preg_replace("/[^A-Z,^a-z,^\',^0-9]/", " ", $text);

		$array = explode(" ", $text);

		while (list($key, $value) = each($array)) {

			if (strlen($value) > 0) {

				$terms++;

				$optionterms++;

				$query = "insert into listing_index (`ItemNum`, `value`, `pos`, `field_type`, `field_id`, `field_num`) values ('" . mysql_escape_string($ItemNum) . "', '" . mysql_escape_string($value) . "', '" . $optionterms . "', '" . $type . "', '" . $field_id . "', '" . $field_num . "')";

				$db3->query($query);



			}

		}

	}

	return $terms;

}



function add_catcounts($category){

	$db = new clsDBNetConnect();

	$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $category . "'";

	$db->query($query);

	$query = "select `sub_cat_id` from categories where `cat_id` = '" . $category . "'";

	$db->query($query);

	if ($db->next_record()){

		$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		if ($db->next_record()){

			$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			if ($db->next_record()){

				$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				if ($db->next_record()){

					$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					if ($db->next_record()){

						$query = "update `categories` set `count` = `count`+1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

						$db->query($query);

					}

				}

			}

		}

	}

}



function subtract_catcounts($category){

	$db = new clsDBNetConnect();

	$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $category . "'";

	$db->query($query);

	$query = "select `sub_cat_id` from categories where `cat_id` = '" . $category . "'";

	$db->query($query);

	if ($db->next_record()){

		$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

		$db->query($query);

		if ($db->next_record()){

			$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

			$db->query($query);

			if ($db->next_record()){

				$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

				$db->query($query);

				if ($db->next_record()){

					$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					$query = "select `sub_cat_id` from categories where `cat_id` = '" . $db->f("sub_cat_id") . "'";

					$db->query($query);

					if ($db->next_record()){

						$query = "update `categories` set `count` = `count`-1 where `cat_id` = '" . $db->f("sub_cat_id") . "'";

						$db->query($query);

					}

				}

			}

		}

	}

}



?>