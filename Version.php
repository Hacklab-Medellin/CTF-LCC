<?php
$ItechclVersion = "3.0";
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
$name="";
?>