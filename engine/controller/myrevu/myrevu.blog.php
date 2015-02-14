<?php
/***************************************************************************************
 * 마이레뷰-블로그
 * 
 * 작성일 : 2011.09.07
 * 작성자 : 이종학
 * 히스토리 :  
 * 
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
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$list = $CLASS_BLOG->getBlogList($DB, $_SESSION['userno']);
$userstats = $CLASS_USER->getUserStats($DB, $_SESSION['userno']);
$usercash = $CLASS_CASH->getCash($DB, $_SESSION['userno']);

$review_cnt = 0;
$talk_cnt = 0;
$cash = 0; 
for($i=0; $i<sizeof($list); $i++) {
	$review_cnt += $list[$i]['review_cnt'];
	$talk_cnt += $list[$i]['talk_cnt'];
	$cash += $list[$i]['cash'];
}

$revu['blogno'] = "0";
$revu['url'] = "http://"._DOMAIN;
$revu['name'] = "레뷰";
$revu['review_cnt'] = number_format($userstats['review_cnt'] - $review_cnt);
$revu['talk_cnt'] = number_format($userstats['talk_cnt'] - $talk_cnt);
$revu['cash'] = number_format($usercash['cash'] - $cash);
$revu['regdate'] = $_SESSION['regdate'];
//array_push($list, $revu);
 
for($i=0; $i<sizeof($list); $i++) {
	$list[$i]['name'] = htmlspecialchars($list[$i]['name']);
	$list[$i]['review_cnt'] = number_format($list[$i]['review_cnt']);
	$list[$i]['talk_cnt'] = number_format($list[$i]['talk_cnt']);
	$list[$i]['cash'] = number_format($list[$i]['cash']);
	$list[$i]['review'] = $CLASS_REVIEW->getMyReviewList($DB, "LIMIT 0, 5", $_SESSION['userno'], $list[$i]['blogno']);
	for($j=0; $j<sizeof($list[$i]['review']); $j++) {
		$_content = $CLASS_REVIEW->getReviewContent($DB, $list[$i]['review'][$j]['rno']);
		$list[$i]['review'][$j]['title'] = $_content['title'];
		$list[$i]['review'][$j]['content'] = $_content['content'];
	} 
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"list"=>$list,
	"cnt"=>number_format(sizeof($list)),
));
?>