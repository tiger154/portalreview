<?php
/***************************************************************************************
 * 이벤트
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