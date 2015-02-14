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
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
$CLASS_MANAGER_POWERBLOG = &Module::singleton("Manager.PowerBlog");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$userno = Module::$param[0];
if($userno == "") exit;

$user = $CLASS_USER->getUser($DB, $userno);
$extra = $CLASS_USER->getUserExtra($DB, $user['userno']);
$stats = $CLASS_USER->getUserStats($DB, $user['userno']);
$area = $CLASS_USER->getUserAreaCode($DB, $user['userno']);
$cate = $CLASS_USER->getUserCateCode($DB, $user['userno']);
$blog = $CLASS_BLOG->getBlogList($DB, $user['userno']);
$cash = $CLASS_CASH->getCash($DB, $user['userno']);
$point = $CLASS_POINT->getPoint($DB, $user['userno']);
$reviewbest = $CLASS_REVIEWBEST->getBestReviewByUser($DB, $user['userno'], $limit=10);
$reviewbestCnt = $CLASS_REVIEWBEST->getBestReviewCountByUser($DB, $user['userno']);
$userimage = $CLASS_USER->getImage($user['userno'], $extra['userimage']);

// 파워블로그텍스트
$user['flag_powerblog_text'] = $CLASS_USER->flag_powerblog[$user['flag_powerblog']];
// 이메일수신여부텍스트
$user['flag_email_text'] = $CLASS_USER->flag_email[$user['flag_email']];
// 블랙리스트텍스트
$user['flag_black_text'] = $CLASS_USER->flag_black[$user['flag_black']];
// 성별텍스트
$extra['gender_text'] = $CLASS_USER->gender[$extra['gender']];
// 양력/음력
$extra['flag_lunar_text'] = $CLASS_USER->flag_lunar[$extra['flag_lunar']];
// 관심지역
$area_desc = array();
for($i=0; $i<sizeof($area); $i++) {
	$_area = array();
	$_area[] = $area[$i]['bcode'];
	$_area[] = $area[$i]['mcode'];
	$_area[] = $area[$i]['scode'];	
	$area_desc[$i]['desc'] = $CLASS_CODE->getAreaDesc($DB, $_area);
}
// 카테고리
$cate_desc = array();
for($i=0; $i<sizeof($cate); $i++) {
	$_cate = array();
	$_cate[] = $cate[$i]['cate1'];
	$cate_desc[$i]['desc'] = $CLASS_CODE->getCateDesc($DB, $_cate);
}
// 파워블로그
$powerblog = $CLASS_MANAGER_POWERBLOG->getPowerBlog($DB, $user['userno']);
 
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"user"=>$user,
	"userimage"=>$userimage, 
	"extra"=>$extra,
	"stats"=>$stats,
	"area"=>$area, 
	"area_desc"=>$area_desc, 
	"cate"=>$cate, 
	"cate_desc"=>$cate_desc, 
	"powerblog"=>$powerblog,
	"blog"=>$blog,
	"blog_cnt"=>sizeof($blog),
	"cash"=>$cash, 
	"point"=>$point,
	"reviewbest"=>$reviewbest,
	"reviewbestCnt"=>$reviewbestCnt,	
));
?>