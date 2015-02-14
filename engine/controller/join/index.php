<?php
/***************************************************************************************
 * 회원가입약관 컨트롤러
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
$CLASS_FILE = &Module::singleton("File");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");

/**
 * DB OBJECT
 */

/**
 * VAR / PROC
 */
$_agree = _DIR_CONF."/text.agree.txt";
$agree = $CLASS_FILE->read($_agree);
$_policy1 = _DIR_CONF."/text.policy1.txt";
$policy1 = $CLASS_FILE->read($_policy1);
$_policy2 = _DIR_CONF."/text.policy2.txt";
$policy2 = $CLASS_FILE->read($_policy2);
$_policy3 = _DIR_CONF."/text.policy3.txt";
$policy3 = $CLASS_FILE->read($_policy3);
$_policy4 = _DIR_CONF."/text.policy4.txt";
$policy4 = $CLASS_FILE->read($_policy4);

// 회원가입키 초기화
$_SESSION['joinKey'] = "";

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"agree"=>$agree,
	"policy1"=>$policy1,
	"policy2"=>$policy2,
	"policy3"=>$policy3,
	"policy4"=>$policy4,
));
?>