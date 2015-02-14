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
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_CODE = &Module::singleton("Code.Code");

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
$CLASS_PAGE->set('pageRow', 15);
$user = $CLASS_USER->getUser($DB, $userno);
$limit = $CLASS_PAGE->getLimit();
$point = $CLASS_POINT->getPoint($DB, $user['userno']);
$cnt = $CLASS_POINT->getPointCount($DB, $user['userno']);
$list = $CLASS_POINT->getPointList($DB, $limit, $user['userno']);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);;
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";
$_type = $CLASS_CODE->getPointTypeList($DB);
$type = array();
for($i=0; $i<sizeof($_type); $i++) {	
	$type[$_type[$i]['state']] = $_type[$i]['state_explain'];
}
for($i=0; $i<sizeof($list); $i++) {
	$list[$i]['point_type_text'] = $type[$list[$i]['point_type']];
	$list[$i]['regdate'] = $BASE->transDate($list[$i]['regdate'], "F");
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"point"=>$point,
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>