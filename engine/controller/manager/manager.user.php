<?php
/***************************************************************************************
 * 관리자 회원리스트
 * 
 * 작성일 : 2011.10.28
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
$CLASS_PAGE = &Module::singleton("Page2", 0);
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_USER->getUserCount($DB, Module::$param[1], Module::$param[2], Module::$param[3]);
$list = $CLASS_USER->getUserList($DB, $limit, Module::$param[1], Module::$param[2], Module::$param[3]);
//echo Module::$param[1];
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	$list[$i]['cash'] = $CLASS_CASH->getCash($DB, $list[$i]['userno']);
	$list[$i]['point'] = $CLASS_POINT->getPoint($DB, $list[$i]['userno']);
	$list[$i]['flag_activated_text'] = $CLASS_USER->flag_activated[$list[$i]['flag_activated']];
	$list[$i]['flag_powerblog_text'] = $CLASS_USER->flag_powerblog[$list[$i]['flag_powerblog']];
	$list[$i]['flag_email_text'] = $CLASS_USER->flag_email[$list[$i]['flag_email']];
	$list[$i]['flag_black_text'] = $CLASS_USER->flag_black[$list[$i]['flag_black']];
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>