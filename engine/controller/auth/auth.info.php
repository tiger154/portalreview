<?php
/***************************************************************************************
 * 로그인 정보 컨트롤러
 * 
 * 작성일 : 2011.07.29
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

/**
 * DB OBJECT
 */

/**
 * VAR / PROC
 */
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

unset($_SESSION);

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"var"=>$var,
));
?>
