<?php
/***************************************************************************************
 * 마이레뷰 컨트롤러
 * 
 * 작성일 : 2011.08.08
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
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWTALK = &Module::singleton("Review.ReviewTalk");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_FRIEND = &Module::singleton("User.Friend");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_FRONTIER	= &Module::singleton("Frontier.Frontier");
$CLASS_BASE = &Module::singleton("Base");		
$CLASS_TIME	= &Module::singleton("Site.Site");		


/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$oldlink = "http://"._DOMAIN_FILE."/frontier/old_img/";

$frontierWin = array();
for($i=0;$i<4;$i++) {	
	$frontierWin[$i]['title'] = "(당첨된)건조한 환절기, 냉면 한 그릇으로";
	$frontierWin[$i]['content'] = "쉐보레의 첫 글로벌 중형차 '말리부'";
}

$frontierEntry = $CLASS_FRONTIER->MyrevuEntrySelect($DB, $_SESSION["userno"], "0"); 
for($s=0;$s<sizeof($frontierEntry);$s++) {
	if($frontierEntry[$s]['frno'] > "877"){    //신규이미지 경로
		$mainimgDir	= substr($frontierEntry[$s]['frid'],2,4);
		$entryimgname = $CLASS_FRONTIER->ListimgSelect($DB, $frontierEntry[$s]['frno']);
		$mainlistimg	= "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_img/".$mainimgDir."/".$entryimgname;
		$frontierEntry[$s]['entryimg'] = $mainlistimg;
	}else{
		$oldimgname = explode("{", $frontierEntry[$s]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$frontierEntry[$s]['entryimg']		= $oldlink.$oldimgname."_list.gif";
		$url = $oldlink.$oldimgname.".jpg";		
		if(!@fopen($url,"r")) //--> 파일과 같은 것을 찾는다. 
		{ 
			$frontierEntry[$s]['entryimg']	 = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";	//더미 이미지
		}else{
			$frontierEntry[$s]['entryimg']		= $oldlink.$oldimgname."_list.gif";
		}
	}
	$frontierEntry[$s]['title'] = $CLASS_BASE->strLimitUTF($frontierEntry[$s]['subject'], "48", "", $eStr="...");	
	$enddate				= strtotime($frontierEntry[$s]['end_date']);
	$remainday			= floor(($enddate - time())/86400);
	$frontierEntry[$s]['remainday'] = $remainday;

	//응모한 프론티어의 토크 셀렉팅
	$accountinfo					= $CLASS_FRONTIER->MyrevuEntryTalkSelect($DB, $frontierEntry[$s]['frno'], $_SESSION['userno']);
	for($d=0;$d<sizeof($accountinfo);$d++) {
			$frontierEntry[$s]['no']			= $accountinfo[$d]['no'];				//해당 등록 토크등록번호
			$frontierEntry[$s]['content'] = $accountinfo[$d]['content'];  //해당 등록 토크 내용
			//토크등록 지난시간 만들기 ㅡㅡ; 
			$timerdate	 = strtotime($accountinfo[$d]['regdate']);
			$timerday	= floor(($timerdate - time())/86400);
			$timerday	= -$timerday;
			$timerdatehour = floor((($timerdate - time())%86400)/3600);
			$timerdatehour = -$timerdatehour;
			$frontierEntry[$s]['entrytimer']	= $timerday."일 ".$timerdatehour."시간 전";
	}
}
$myfron_winlist			= $CLASS_FRONTIER->MyFrontierEntryWinSelect4($DB, $_SESSION["userno"], "1", $limit);
for($i=0;$i<sizeof($myfron_winlist);$i++) {
	$imgDir	= substr($myfron_winlist[$i]['frid'],2,4);
	$winimgname = $CLASS_FRONTIER->ListimgSelect($DB, $myfron_winlist[$i]['frno']);	
	$listimg	= "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_img/".$imgDir."/".$winimgname;
	$myfron_winlist[$i]['winimg'] = $listimg;
	$myfron_winlist[$i]['subject'] = $CLASS_BASE->strLimitUTF($myfron_winlist[$i]['subject'], "23", "", $eStr="...");
	//해당 프론티어의 리뷰등록 최근등록물의 리뷰번호와 회원번호 셀렉팅
	$accountinfo2					= $CLASS_FRONTIER->FrontierReviewendlist2($DB, $myfron_winlist[$i]['frno'], $_SESSION["userno"], "1");
	for($d=0;$d<sizeof($accountinfo2);$d++) {
			$rno = $accountinfo2[$d]['rno'];				//해당 등록 리뷰등록번호
			$content = $accountinfo2[$d]['content'];  //해당 등록 리뷰 글쓴이(회원번호)
			$myfron_winlist[$i]['rno'] = $rno;
			$myfron_winlist[$i]['content'] = $content;
	}
	$review_remaintime = $CLASS_FRONTIER->FrontierReviewTime($DB, $myfron_winlist[$i]['frno']);
	//리뷰등록 남은 일
	$enddate				= strtotime($review_remaintime);
	$due_edate			= floor(($enddate - time())/86400);
	$myfron_winlist[$i]['due_edate'] = $due_edate;
}
// 당첨된 프론티어 끝--------------------------/

// 리뷰
$myreview = $CLASS_REVIEW->getMyReviewList($DB, "LIMIT 0, 10", $_SESSION['userno']);
$myreview = $CLASS_REVIEW->getReviewDataBind($DB, $myreview);

// 서로 등록한 프렌즈
$friendList1 = $CLASS_FRIEND->getFriendList($DB, "LIMIT 0, 5", $_SESSION['userno'], "EO", $groupno);
for($i=0;$i<sizeof($friendList1);$i++) {
	$userno = $CLASS_FRIEND->getUsernoByType($_SESSION['userno'], $friendList1[$i]['userno'], $friendList1[$i]['fuserno']);
	$user = $CLASS_USER->getUser($DB, $userno);
	$extra = $CLASS_USER->getUserExtra($DB, $user['userno']);
	$friendList1[$i]['nickname'] = $user['nickname'];
	$friendList1[$i]['userimage'] = $CLASS_USER->getImage($user['userno'], $extra['userimage']);
	//$blog = $CLASS_BLOG->getBlogList($DB, $user['userno'], $flag_activated="1", "LIMIT 0, 1"); 
	//$friendList1[$i]['blog_url'] = $blog[0]['url'];
	//$review = $CLASS_REVIEW->getMyReviewList($DB, "LIMIT 0, 2", $user['userno']);
	//$review = $CLASS_REVIEW->getReviewDataBind($DB, $review);
	//$friendList1[$i]['review'] = $review;
}
// 내가 등록한 프렌즈
$friendList2 = $CLASS_FRIEND->getFriendList($DB, "LIMIT 0, 5", $_SESSION['userno'], "MY", $groupno);
for($i=0;$i<sizeof($friendList2);$i++) {
	$userno = $CLASS_FRIEND->getUsernoByType($_SESSION['userno'], $friendList2[$i]['userno'], $friendList2[$i]['fuserno']);
	$user = $CLASS_USER->getUser($DB, $userno);
	$extra = $CLASS_USER->getUserExtra($DB, $user['userno']);
	$friendList2[$i]['nickname'] = $user['nickname'];
	$friendList2[$i]['userimage'] = $CLASS_USER->getImage($user['userno'], $extra['userimage']);
}
// 나를 등록한 프렌즈
$friendList3 = $CLASS_FRIEND->getFriendList($DB, "LIMIT 0, 5", $_SESSION['userno'], "ME", $groupno);
for($i=0;$i<sizeof($friendList3);$i++) {
	$userno = $CLASS_FRIEND->getUsernoByType($_SESSION['userno'], $friendList3[$i]['userno'], $friendList3[$i]['fuserno']);
	$user = $CLASS_USER->getUser($DB, $userno);
	$extra = $CLASS_USER->getUserExtra($DB, $user['userno']);
	$friendList3[$i]['nickname'] = $user['nickname'];
	$friendList3[$i]['userimage'] = $CLASS_USER->getImage($user['userno'], $extra['userimage']);
}

//블로그 리스트
$userno = $_SESSION['userno'];
if($_SESSION['userno'] != ""){
	$bloglist = $CLASS_BLOG->getBlogList($DB, $_SESSION['userno']);
	$formArr = array("blog", "url", "revu");
	$type = (in_array(Module::$param[0], $formArr) == false) ? "blog" : Module::$param[0];
}

// 소셜댓글
$talkcnt1 = $CLASS_REVIEWTALK->getTalkUserCount($DB, "1", $_SESSION['userno'], $flag_del="0");
$talklist1 = $CLASS_REVIEWTALK->getTalkUserList($DB, "LIMIT 0, 4", "0", $_SESSION['userno'], $flag_del="0");
$talklist1 = $CLASS_REVIEWTALK->getTalkDataBind($DB, $talklist1);
for($i=0; $i<sizeof($talklist1); $i++) {
	$talklist1[$i]['talk'] = strip_tags($talklist1[$i]['talk']);
}
$talkcnt2 = $CLASS_REVIEWTALK->getTalkUserCount($DB, "1", $_SESSION['userno'], $flag_del="0");
$talklist2 = $CLASS_REVIEWTALK->getTalkUserList($DB, "LIMIT 0, 4", "1", $_SESSION['userno'], $flag_del="0");
$talklist2 = $CLASS_REVIEWTALK->getTalkDataBind($DB, $talklist2);
for($i=0; $i<sizeof($talklist2); $i++) {
	$talklist2[$i]['talk'] = strip_tags($talklist2[$i]['talk']);
}

/**
 * TEMPLATE VARS
 */
$TPL->defineTemplate("entrylayer2", "frontier", "frontier.review.layer.htm");
$TPL->defineTemplate("reviewlayer", "_global_layer", "review.htm");
$TPL->setValue(array(
	"frontierEntry"=>$frontierEntry,
	"frontierEntrySize"=>sizeof($frontierEntry),
	"frontierWinsize"=>sizeof($myfron_winlist),
	"myfron_winlist"=>$myfron_winlist,
	"frontierreviewsize"=>sizeof($accountinfo2),
	"myreview"=>$myreview,
	"friendList1"=>$friendList1,
	"friendSize1"=>sizeof($friendList1),
	"friendList2"=>$friendList2,
	"friendSize2"=>sizeof($friendList2),
	"friendList3"=>$friendList3,
	"friendSize3"=>sizeof($friendList3),
	"bloglist"=>$bloglist,
	"type"=>$type,
	"talkcnt1"=>number_format($talkcnt1),
	"talklist1"=>$talklist1,
	"talkcnt2"=>number_format($talkcnt2),
	"talklist2"=>$talklist2,
));
?>