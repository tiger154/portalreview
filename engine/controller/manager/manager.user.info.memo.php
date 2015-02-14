<?php
/***************************************************************************************
 * 관리자 회원정보
 * 
 * 작성일 : 2011.11.02
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
$CLASS_PAGE = &Module::singleton("Page2", 1);
$CLASS_USER = &Module::singleton("User.User");
$CLASS_MEMO = &Module::singleton("User.Memo");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$userno = Module::$param[0];
if($userno == "") exit;

$CLASS_PAGE->set('page', Module::$param[1]);
$CLASS_PAGE->set('pageRow', 10);
$user = $CLASS_USER->getUser($DB, $userno);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_MEMO->getMemoCount($DB, $userno);
$list = $CLASS_MEMO->getMemoList($DB, $limit, $userno);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);;
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['auserno']);
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