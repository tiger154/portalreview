<?php
/***************************************************************************************
 * 추천리뷰리스트 컨트롤러
 * 
 * 작성일 : 2011.10.10
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
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$CLASS_PAGE->set('page', Module::$param[0]);
$cnt = $CLASS_REVIEW->getRecomReviewCount($DB, $_SESSION['userno']);
$list = $CLASS_REVIEW->getRecomReviewList($DB, $CLASS_PAGE->getLimit(), $_SESSION['userno']);

for($i=0;$i<sizeof($list);$i++) {	
	$list[$i] = $CLASS_REVIEW->getReview($DB, $list[$i]['rno']);
	$list[$i]['content'] = $BASE->strLimitUTF(strip_tags($list[$i]['content']), 400, false, '...');	
	$list[$i]['blog_icon'] = $CLASS_BLOG->getBlogIcon($list[$i]['url']);
	$_user = $CLASS_USER->getUser($DB, $list[$i]['userno']);
	$list[$i]['nickname'] = $_user['nickname'];
	$_cate = $CLASS_CODE->transCate($list[$i]['cate1'],$list[$i]['cate2'],$list[$i]['cate3'],$list[$i]['cate4'],$list[$i]['cate5'],$list[$i]['cate6']);
	$list[$i]['cate_desc'] = $CLASS_CODE->getCateDesc($DB, $_cate);	
	$_file = $CLASS_REVIEW->getReviewFile($DB, $list[$i]['rno'], "T"); 
	$list[$i]['thumbimage_url'] = $CLASS_REVIEW->getThumbimage($_file[0]['filename'], $list[$i]['regdate']);
}

$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
$link = $CLASS_PAGE->getLink();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(	
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
));
?>