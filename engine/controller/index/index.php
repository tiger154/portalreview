<?php
 /***************************************************************************************
 * 인덱스 컨트롤러
 * 
 * 작성일 : 2011.07.04
 * 작성자 : 이종학
 * 히스토리 :
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
//GLOBAL $SITE;
//GLOBAL $FRAME;

/**
 * CLASS
 */
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_SITE = &Module::singleton("Site.Site");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWKEYWORD = &Module::singleton("Review.ReviewKeyword");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$oldlink= "http://"._DOMAIN_FILE."/frontier/old_img/";

$today = date("YmdHis");		
$day_nowmonth	 = date("m");
$day_nowday		 = date("d");

$frontierList	= $CLASS_FRONTIER->FrontierMainselect($DB, $today);
$frontierCnt	= $CLASS_FRONTIER->FrontierMainCnt($DB, $today);

$revulog		= $CLASS_FRONTIER->RevuLogTemp($DB);

for($f=0; $f<sizeof($frontierList); $f++) {
	$chackday = $frontierList[$f]['end_date'];
	$jstart_date = $frontierList[$f]['start_date'];
	$jstart_date = substr($jstart_date,0,4).".".number_format(substr($jstart_date,5,2)).".".number_format(substr($jstart_date,8,2)).".";
	$frontierList[$f]['start_date'] = $jstart_date;
	$jend_date = $frontierList[$f]['end_date'];
	$jend_date = substr($jend_date,0,4).".".number_format(substr($jend_date,5,2)).".".number_format(substr($jend_date,8,2)).".";
	$frontierList[$f]['end_date'] = $jend_date;
	$jnotice_date = $frontierList[$f]['notice_date'];
	$jnotice_date = substr($jnotice_date,0,4).".".number_format(substr($jnotice_date,5,2)).".".number_format(substr($jnotice_date,8,2)).".";
	$frontierList[$f]['notice_date'] = $jnotice_date;
	$jdue_edate = $frontierList[$f]['due_edate'];
	$jdue_edate = substr($jdue_edate,0,4).".".number_format(substr($jdue_edate,5,2)).".".number_format(substr($jdue_edate,8,2)).".";
	$frontierList[$f]['due_edate'] = $jdue_edate;
	$frontierList[$f]['subject'] = $CLASS_BASE->strLimitUTF($frontierList[$f]['subject'], "18", "", $eStr="...");
	if($frontierList[$f]['frno'] > "877"){
		//이미지 경로 처리
		$imgdomain			= "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_img/";
		$topimgDir							= substr($frontierList[$f]['frid'],2,4);
		$topimg								= $imgdomain.$topimgDir."/".$frontierList[$f]['titleimg'];
		$frontierList[$f]['toplistimg']			= $topimg;	
	}else{
		$oldimgname = explode("{", $frontierList[$f]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$frontierList[$f]['toplistimg']		= $oldlink.$oldimgname."_list.gif";
	}
	//카운트 (시간) 표시하기
	$enddate = strtotime($chackday);
	$remainday = floor(($enddate - time())/86400);
	$remaintime = floor((($enddate - time())%86400)/3600);
	if($remainday < 1){
		if($remaintime < 0){
			$frontierList[$f]['remaincount'] = "모집종료";
		}else{
			$frontierList[$f]['remaincount'] = $remaintime."시간 남음";
		}
		
	}else{	
		$frontierList[$f]['remaincount'] = $remainday."일 남음";
	}

}

$banner_main = $CLASS_FRONTIER->BannerSelect($DB, "M");						 // 메인페이지 본문 중앙 배너 랜덤 셀렉팅
for($m=0; $m<sizeof($banner_main); $m++) {
	$banner_main_img			= $banner_main[$m]['bannerimg']; //메인배너 이미지
	$banner_main_linktype		= $banner_main[$m]['linktype'];		//메인배너 새창,본창 열기 구분값
	$banner_main_url			= $banner_main[$m]['siteurl'];		//메인배너 링크주고
	$banner_main_img 	= "http://"._DOMAIN_FILE."/"._FTP_BANNERIMAGE."/".$banner_main_img;
	if($banner_main_url == "-"){			
		$banner_main_link = "<img src='$banner_main_img'  alt='레뷰 광고 배너 입니다.' title='' width='714' height='134'>";
	}else{
		if($banner_main_linktype = "T"){
			$banner_main_link = "<a href='$banner_main_url' target='_blank'>$banner_main_link<img src='$banner_main_img'  alt='레뷰 광고 배너 링크연결' title='' width='714' height='134'></a>";
		}else{
			$banner_main_link = "<a href='$banner_main_url' target='_top'>$banner_main_link<img src='$banner_main_img'  alt='레뷰 광고 배너 링크연결' title='' width='714' height='134'></a>";
		}
	}
}

$frontierChecklist = $CLASS_FRONTIER->FrontierMainListCount($DB, $today);
if($frontierChecklist < 4){
	$frontierfourlist_count = $CLASS_FRONTIER->FrontierMainFourListA_count($DB, $today);
	if($frontierfourlist_count < 4){
		$frontierfourlist = $CLASS_FRONTIER->FrontierMainFourListAE($DB, $today);
	}else{
		$frontierfourlist = $CLASS_FRONTIER->FrontierMainFourListA($DB, $today);
	}
	$fourlink			= "A";
}else{
	$frontierfourlist = $CLASS_FRONTIER->FrontierMainFourListB($DB, $today);
	$fourlink			= "B";
}

for($r=0; $r<sizeof($frontierfourlist); $r++) {
	$imgdomain = "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_simg/";
	$frontierfourlist[$r]['subject'] = $CLASS_BASE->strLimitUTF($frontierfourlist[$r]['subject'], "15", "", $eStr="...");
	if($frontierfourlist[$r]['frno'] > "877"){
		$imgDir = substr($frontierfourlist[$r]['frid'],2,4);
		$fourlistimg = $imgdomain.$imgDir."/".$frontierfourlist[$r]['titleimg'];
		$frontierfourlist[$r]['listimg'] = $fourlistimg;	
	}else{
		$oldimgname = explode("{", $frontierfourlist[$r]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$frontierfourlist[$r]['listimg']= $oldlink.$oldimgname.".jpg";
	}
	//발표일 합체조립
	$jnotice_date = $frontierfourlist[$r]['notice_date'];
	$jnotice_date = substr($jnotice_date,0,4).".".number_format(substr($jnotice_date,5,2)).".".number_format(substr($jnotice_date,8,2)).".";
	$frontierfourlist[$r]['notice_date'] = $jnotice_date;
	$frno = $frontierfourlist[$r]['frno'];
	$frontierfourlist[$r]['fourlink'] = "<a href='/frontier/detailview/1/$frno/A/' target='_top'>";
}

$keywordReview = array();
$keyword = $CLASS_REVIEWKEYWORD->getKeywordListByOrder($DB);
for($i=0; $i<sizeof($keyword); $i++) {
	$keywordReview[]['list'] = $CLASS_SITE->getKeywordReview($DB, $keyword[$i]['kno'], $num=3);
}

$noticeReview = array();
$cate = array("", "11005", "13", "12016", "11010", "12017", "10", "14008", "frontier");
for($i=0; $i<sizeof($cate); $i++) {
	$noticeReview[]['list'] = $CLASS_SITE->getNoticeReview($DB, $cate[$i]);
}

$bestData = $CLASS_SITE->getBestReview($DB);

$realtimeReview = array();
$cate = array("", "11005", "13", "12016", "11010", "12017", "10", "14008", "frontier");
for($i=0; $i<sizeof($cate); $i++) {
	if($cate[$i] != "frontier") {
		$realtimeReview[$i]['list'] = $CLASS_SITE->getRealtimeReview($DB, $type="", $cate[$i]);
	} else {
		$realtimeReview[$i]['list'] = $CLASS_SITE->getRealtimeReview($DB, $type="F", $cate="");
	}
}
$reviewCount = number_format($CLASS_REVIEW->getReviewCount($DB, "", "", $status="1"));

$realtimeTalk = $CLASS_SITE->getRealtimeTalkByAll($DB);

$flag_newyear = (date("Y-m-d") >= '2011-01-02') ? true : false;

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"keyword"=>$keyword,
	"keywordReview"=>$keywordReview, 
	"noticeReview"=>$noticeReview,
	"bestReview"=>$bestData['list'],
	"bestDate"=>$bestData['date'],
	"reviewCount"=>$reviewCount,
	"realtimeReview"=>$realtimeReview,
	"realtimeTalk"=>$realtimeTalk,
	"day_nowmonth"=>$day_nowmonth,
	"day_nowday"=>$day_nowday,		
	"frontierCnt"=>$frontierCnt,
	"frontierList"=>$frontierList,
	"banner_main_img"=>$banner_main_img,
	"banner_main_link"=>$banner_main_link,
	"frontierfourlist"=>$frontierfourlist,
	"flag_newyear"=>$flag_newyear,
));
?>