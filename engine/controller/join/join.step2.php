<?php
/***************************************************************************************
 * 회원가입완료 컨트롤러
 * 
 * 작성일 : 2011.06.30
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

/**
 * CLASS
 */
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");

/**
 * DB OBJECT
 */

/**
 * VAR / PROC
 */
if($_SESSION['joinKey'] == "" || $CLASS_ENCRYPTER->decryptMD5($_SESSION['joinKey'], "step2") != $_SERVER['REMOTE_ADDR']) {
	Module::alert("잘못된 경로입니다.");
	Module::redirect("/join");
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"val"=>$val,
));
?>