<?php
/***************************************************************************************
 * 관리자 리뷰목록2
 * 
 * 작성일 : 2011.11.17
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
$cnt = $CLASS_REVIEW->getManagerReviewCount($DB, Module::$param[1], Module::$param[2]);
$list = $CLASS_REVIEW->getManagerReviewList($DB, $limit, Module::$param[1], Module::$param[2]);
$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	$list[$i]['status_text'] = $CLASS_REVIEW->status[$list[$i]['status']];
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"cate"=>$cate,
	"param"=>Module::$param,
	"point_flag"=>$point_flag,
	"date_flag"=>$date_flag,
));
?>