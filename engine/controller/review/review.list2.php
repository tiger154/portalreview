<?php
/***************************************************************************************
 * 리뷰리스트 컨트롤러
 * 
 * 작성일 : 2011.09.20
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
if(Module::$param[1] != "") {
	$cate = $CLASS_CODE->transCate(Module::$param[1]);
	if($CLASS_CODE->isCate($DB, $cate) == false) Module::redirect("/review");
}
switch(Module::$param[2]) {
	case "point" : $point_flag = "on"; $date_flag = "off"; break;
	default : $date_flag = "on"; $point_flag = "off"; break;
}

$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEW->getReviewCount($DB, $type="", $cate, $status="1", $date="");
$list = $CLASS_REVIEW->getReviewList($DB, $limit, $type="", $cate, $status="1", $date="", Module::$param[2], Module::$param[3]);
$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

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