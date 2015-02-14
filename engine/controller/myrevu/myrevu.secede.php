<?php
/***************************************************************************************
 * 마이레뷰-회원탈퇴
 * 
 * 작성일 : 2011.09.29
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
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$user = $CLASS_USER->getUser($DB, $_SESSION['userno']);
$list = $CLASS_CODE->getSecedeTypeList($DB);
$_SESSION['secedeKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "secede");

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"user"=>$user,
	"list"=>$list,
));
?>