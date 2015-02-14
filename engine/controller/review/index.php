<?php
/***************************************************************************************
 * 리뷰메인 컨트롤러
 * 
 * 작성일 : 2011.09.22
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
// 베스트 리뷰
Module::$omit = true;
$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d", mktime(date("H"),date("i"),date("s"), date("m"), date("d"), date("Y"))));

if((Module::$param[1] == "")) {	
	$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
} else {
	$wno = Module::$param[1];
	if($wno_now <= $wno || $wno < 1) {
		$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
	}	
}
$bestdate = $CLASS_REVIEWBEST->getBestWeekDate($DB, $wno);
$best = $CLASS_REVIEWBEST->getBestReview($DB, $wno, $limit=6);
for($i=0; $i<sizeof($best); $i++) {
	$_review = $CLASS_REVIEW->getReview($DB, $best[$i]['rno']);	
	$best[$i]['title'] = $_review['title'];
	$_file = $CLASS_REVIEW->getReviewFile($DB, $best[$i]['rno'], "T"); 
	if($i == 0) {
		$best[$i]['thumbimage_url'] = $CLASS_REVIEW->getThumbimage($_file[0]['filename'], $_review['regdate']);
	}
	$best[$i]['user'] = $CLASS_USER->getUser($DB, $best[$i]['userno']);
}
$prev_wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno);
$next_wno = $CLASS_REVIEWBEST->getBestWeekNext($DB, $wno);
$prev_wno = ($prev_wno == "") ? $wno : $prev_wno;
$next_wno = ($next_wno == "") ? $wno : $next_wno;

// 리스트
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEW->getReviewCount($DB, $type="", $cate="", $status="1", $date="");
$list = $CLASS_REVIEW->getReviewList($DB, $limit, $type="", $cate="", $status="1", $date="", $order="", $desc="");
$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module, Module::$param, Module::$omit);
$link = $CLASS_PAGE->getLink();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"best"=>$best,
	"bestdate"=>$bestdate,
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"wno"=>$wno,
	"prev_wno"=>$prev_wno,
	"next_wno"=>$next_wno,
	"param"=>Module::$param,
));
?>