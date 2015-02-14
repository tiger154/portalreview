<?php
/***************************************************************************************
 * 관리자 베스트 리뷰 주간정보
 * 
 * 작성일 : 2011.10.05
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
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEWBEST->getBestWeekCount($DB);
$list = $CLASS_REVIEWBEST->getBestWeekList($DB, $limit);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

$wno = $CLASS_REVIEWBEST->getBestWeekWNo($DB, date("Y-m-d")); // 후보선정주
$wno_prev = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno); // 투표주
for($i=0; $i<$size; $i++) {
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"cate"=>$cate,
	"wno"=>$wno,
	"wno_prev"=>$wno_prev,
	"param"=>Module::$param,
));
?>