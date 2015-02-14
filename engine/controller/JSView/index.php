<?php
/***************************************************************************************
 * 임시 위젯 컨트롤러
 * 
 * 작성일 : 2011.10.20
 * 작성자 : 이종학
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