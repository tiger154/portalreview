<?php
/***************************************************************************************
 * 관리자 계정관리
 * 
 * 작성일 : 2012.01.31
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
$CLASS_MANAGER= &Module::singleton("Manager.Manager");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$list = $CLASS_MANAGER->getAdminUserList($DB);

for($i=0; $i<sizeof($list); $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"list"=>$list,
));
?>