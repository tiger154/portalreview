<?php
/***************************************************************************************
 * 마이레뷰-회원정보수정
 * 
 * 작성일 : 2011.10.05
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
$CLASS_ZIPCODE = &Module::singleton("Zipcode");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
// 정보수정 비밀키

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"now_year"=>$now_year,
));
?>