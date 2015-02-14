<?php
/***************************************************************************************
 * 위즈위드 이벤트 위젯 컨트롤러
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

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"param"=>Module::$param,
));
?>