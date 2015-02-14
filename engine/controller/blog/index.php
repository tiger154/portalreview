<?php
/***************************************************************************************
 * 블로그홈 컨트롤러
 * 
 * 작성일 : 2011.09.07
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
$CLASS_PAGE = &Module::singleton("Page2", 2);
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
Module::$omit = true; // todo생략
$nickname = trim(urldecode(Module::$param[0]));
if($nickname == "" || $CLASS_USER->isUserNick($DB, $nickname) == false) {
	Module::redirect("/");
}

$blogno = (Module::$param[1] == "all") ? "" : Module::$param[1];
if($blogno != "") {
	if($CLASS_BLOG->isBlog($DB, $blogno) == false) {
		Module::redirect("/blog/@".$nickname);
	}
	$blog = $CLASS_BLOG->getBlog($DB, $blogno);
} else {
	Module::$param[1] = "all";
}

$CLASS_PAGE->set('page', Module::$param[2]);
$limit = $CLASS_PAGE->getLimit();

$user = $CLASS_USER->getUserByNick($DB, $nickname);
$cnt = $CLASS_REVIEW->getMyReviewCount($DB, $user['userno'], $blogno);
$list = $CLASS_REVIEW->getMyReviewList($DB, $limit, $user['userno'], $blogno);

$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module, Module::$param, Module::$omit);
$link = $CLASS_PAGE->getLink();

for($i=0; $i<sizeof($list); $i++) {
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

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"nickname"=>$nickname, 
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"blog"=>$blog,
));
?>