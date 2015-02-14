<?php
/***************************************************************************************
 * 관리자 트랜잭션로그
 * 
 * 작성일 : 2011.11.04
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
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_LOG = &Module::singleton("Manager.Log");

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_LOG->getCronLogCount($DB_LOG, Module::$param[3]); 
$list = $CLASS_LOG->getCronLogList($DB_LOG, $limit, Module::$param[3]);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	//$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);	
	//$list[$i]['point_type_text'] = $type[$list[$i]['point_type']];
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