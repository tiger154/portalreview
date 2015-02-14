<?php
/***************************************************************************************
 * 위즈위드 위젯 컨트롤러
 * 
 * 작성일 : 2011.12.13
 * 작성자 : 박상선
 * 히스토리 : 
 ***************************************************************************************/ 
 
/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
GLOBAL $SITE;
GLOBAL $FRAME;

$FRAME = "view";

/**
 * CLASS
 */
//$CLASS_REVIEW = &Module::singleton("Review.Review");



$CLASS_API		= &Module::singleton("Api.Search");


/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */



//$url = $BASE->getUnescape(Module::$param[0]);
$url = Module::$param[0];

$url = "";
for($i=0; $i<sizeof(Module::$param); $i++) {
	$url .= Module::$param[$i];
}
$url = "adfsf";

/*
$url = "";
for($i=0; $i<sizeof(Module::$param); $i++) {
	$url .= "/".Module::$param[$i];
}
*/


// DEFAULT_ROOT = http://www.revu.co.kr/api/search/
// URL_ROOL = http://www.revu.co.kr/api/search/126494/113843/


//$WizwgetLogData	= $CLASS_API->Wizwgetlog($DB, $url);

$ftype = $CLASS_API->SearchFrendType($DB, Module::$param[0],  Module::$param[1]);


/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"param"=>Module::$param,
	"ftype"=>$ftype,
));
?>