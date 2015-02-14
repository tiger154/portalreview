<?php
include "/www/revu39/engine/_extends/php.facebook/facebook.php";


$app_id = "189402831149686";
$app_secret = "f8e8b16c31bd750e902d6074df065736";
$facebook = new Facebook(array(
'appId' => $app_id,
'secret' => $app_secret,
'cookie' => true
));

//echo $facebook->getUser();
if(($facebook->getUser())==0)
{
 header("Location:{$facebook->getLoginUrl(array('scope' => 'read_stream, publish_stream, offline_access'))}");
 //echo 1212;
 exit;
}else{
	echo "1313"."<br>";
	echo $facebook->getUser();
	$accounts_list = $facebook->api('/me/accounts');
	echo "i am connected";
}


?>
