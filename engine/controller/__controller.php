<?php
/***************************************************************************************
 * 컨트롤러명
 * 
 * 작성일 : 2011.07.28
 * 작성자 : 작성자
 * 히스토리 : 
 * 
 * 2011.XX.XX (작성자)
 * > 수정내용1
 * > 수정내용2 
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
//$CLASS_FTP = &Module::singleton("Ftp");

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$val = "변수";

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"val"=>val,
));
?>