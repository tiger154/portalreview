<?php
/***************************************************************************************
 * 도움말 보기 컨트롤러
 * 
 * 작성일 : 2011.10.19
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

$FRAME = "popup";

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
$type = Module::$param[0];

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"type"=>$type,
));
?>