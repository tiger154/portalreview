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
$CLASS_REVIEW = &Module::singleton("Review.Review");

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
$stats = $CLASS_USER->getUserStats($DB, $user['userno']);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEW->getMyReviewCount($DB, $user['userno'], $blogno="");
$list = $CLASS_REVIEW->getMyReviewList($DB, $limit, $user['userno'], $blogno="");
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);;
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"stats"=>$stats, 
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>