<?php
error_reporting(0);

include "/www/revu39/engine/_sys/sys.conf.cron.php";
include "/www/revu39/engine/_sys/sys.module.php";




$CLASS_API		= &Module::singleton("Api.Wizwget");


/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */



//$url = $BASE->getUnescape(Module::$param[0]);
$url = $_GET['URL'];

//echo "url:$url<br>";
$flag = Module::$param[0];

//echo "flag:$flag<br>";

/*
$url = "";
for($i=0; $i<sizeof(Module::$param); $i++) {
	$url .= "/".Module::$param[$i];
}
*/

$WizwgetLogDupCheck = $CLASS_API->WizwgetlogDup($DB, $url);



$WizwgetLogData	= $CLASS_API->Wizwgetlog($DB, $url, $WizwgetLogDupCheck);






?>

<meta name="width" content="170" />
<meta name="height" content="300" />
<style type="text/css">
.wizwget_170box {min-width:170px;min-height:300px; width:100%; height:460px; background-color:#FFF;}
</style>
<div class="wizwget_170box">
<div style="height:300px;">
	<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab" id="param" width="170" height="300">
	<param name="movie" value="http://www.revu.co.kr/images/wizwget/2012.swf" width="170"  height="300">
	<param name="quality" value="high">
	<param name="bgcolor" value="#ffffff">
	<param name="menu" value="false">
	<param name=wmode value="transparent">
	<param name="swliveconnect" value="true">
	<embed src="http://www.revu.co.kr/images/wizwget/2012.swf" quality=high bgcolor="#ffffff" menu="false" width="170"  height="300" swliveconnect="true" id="param" name="param" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed>
	</object>
</div>
</div>


