<?php
/***************************************************************************************
 * 친구리스트 컨트롤러
 * 
 * 작성일 : 2011.08.30
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
$CLASS_USER = &Module::singleton("User.User");
$CLASS_FRIEND = &Module::singleton("User.Friend");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */


/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"grouplist"=>$grouplist,
));
?>