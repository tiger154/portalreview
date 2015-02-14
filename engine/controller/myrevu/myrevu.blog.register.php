<?php
/***************************************************************************************
 * 마이레뷰-블로그등록 컨트롤러
 * 
 * 작성일 : 2011.07.29
 * 작성자 : 이종학
 * 히스토리 :  
 * 
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
GLOBAL $SITE;
GLOBAL $FRAME;
 
/**
 * CLASS
 */
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$val = "변수";
//echo $CLASS_ENCRYPTER->createGUID();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"val"=>val,
));
?>