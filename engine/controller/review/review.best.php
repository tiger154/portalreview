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
//$CLASS_PAGE = &Module::singleton("Page2", 0);
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
$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d", mktime(date("H"),date("i"),date("s"), date("m"), date("d"), date("Y"))));
if((Module::$param[0] == "")) {	
	$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
} else {
	$wno = Module::$param[0];
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

$wno_cand = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);

$cate = array("10","11","12","13","14");
$list = $CLASS_REVIEWBEST->getBestVoteList($DB, $wno_cand, $cate, $num=5);
for($i=0; $i<sizeof($list); $i++) {
	for($j=0; $j<sizeof($list[$i]['list']); $j++) {
		$list[$i]['list'][$j]['blog_icon'] = $CLASS_BLOG->getBlogIcon($list[$i]['list'][$j]['url']);
	}
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"best"=>$best,
	"bestdate"=>$bestdate,
	"wno"=>$wno,
	"prev_wno"=>$prev_wno,
	"next_wno"=>$next_wno,
	"list"=>$list,
));
?>