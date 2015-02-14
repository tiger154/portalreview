<?php
/***************************************************************************************
 * 관리자 파워블로그 신청리스트
 * 
 * 작성일 : 2011.10.31
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
$CLASS_MANAGER_POWERBLOG = &Module::singleton("Manager.PowerBlog");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_MANAGER_POWERBLOG->getPowerBlogCount($DB, Module::$param[1], Module::$param[2], Module::$param[3]);
$list = $CLASS_MANAGER_POWERBLOG->getPowerBlogList($DB, $limit, Module::$param[1], Module::$param[2], Module::$param[3]);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);
	$list[$i]['flag_text'] = $CLASS_MANAGER_POWERBLOG->flag[$list[$i]['flag_app']];
	$list[$i]['cate1_text'] = $CLASS_MANAGER_POWERBLOG->cate[$list[$i]['cate1']];
	$list[$i]['cate2_text'] = $CLASS_MANAGER_POWERBLOG->cate[$list[$i]['cate2']];
	$list[$i]['cate3_text'] = $CLASS_MANAGER_POWERBLOG->cate[$list[$i]['cate3']];
	$list[$i]['cate4_text'] = $CLASS_MANAGER_POWERBLOG->cate[$list[$i]['cate4']];
	$list[$i]['cate5_text'] = $CLASS_MANAGER_POWERBLOG->cate[$list[$i]['cate5']];
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
	"cate"=>$CLASS_MANAGER_POWERBLOG->cate,
));
?>