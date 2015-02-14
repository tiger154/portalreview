<?php
/***************************************************************************************
 * 관리자 키워드리뷰링크
 * 
 * 작성일 : 2011.11.18
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
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWKEYWORD = &Module::singleton("Review.ReviewKeyword");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageRow', 10);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEWKEYWORD->getKeywordCount($DB);
$list = $CLASS_REVIEWKEYWORD->getKeywordList($DB, $limit);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
));
?>