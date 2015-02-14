<?php
/***************************************************************************************
 * 프론티어 Right Frame 컨트롤러
 * 
 * 작성일 : 2011.10.02
 * 작성자 : 레뷰 박상선
 * 히스토리 : 
 ***************************************************************************************/ 


//===============================================================
//GLOBAL CLASS
//===============================================================
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

//===============================================================
//GLOBAL VARS
//===============================================================
//GLOBAL $FRAME;

$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";


//===============================================================
// EXTEND_CLASS
//===============================================================
$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_REVIEW		= &Module::singleton("Review.Review");
$CLASS_SITE = &Module::singleton("Site.Site");


//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");



$nowmonth		= date("m");
$nowday			= date("d");


// 게시물 셀렉팅
// 썸네일 프로모션 프론티어
$right_toplist		= $CLASS_FRONTIER->FrontierListSelectTframe($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "T"); //A:리뷰중, B:모집중, C: 당첨자선정중, D:종료
// 일반 프론티어
$right_mainlist	= $CLASS_FRONTIER->FrontierListSelectTframe($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "M");
// 프론티어 리뷰
$right_reviewlist	= $CLASS_FRONTIER->FrontierReviewTframe($DB);

for($z=0;$z<sizeof($right_reviewlist);$z++){

		//rno, userno, cate1, cate2, cate3, cate4, area1, area2, area3, addr, regdate
		$right_reviewlist[$z]['nickname']		= $CLASS_FRONTIER->ReviewUserNickname($DB, $right_reviewlist[$z]['userno']);
		$right_reviewlist[$z]['review']					= $CLASS_FRONTIER->ReviewContentData($DB, $right_reviewlist[$z]['rno']);
		$right_reviewlist[$z]['reviewimg']		= $CLASS_FRONTIER->ReviewFileData($DB, $right_reviewlist[$z]['rno']);		
		$right_reviewlist[$z]['imgurl']				= $CLASS_REVIEW->getThumbimage($right_reviewlist[$z]['reviewimg'], $right_reviewlist[$z]['regdate']) ;
}


// 모집중 카운팅

$frontierCount = $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);



for($i=0;$i<sizeof($right_toplist);$i++) {



	//상단 프론티어 리스트 이미지 
	if($right_toplist[$i]['frno'] > "877"){
		$topimgDir									= substr($right_toplist[$i]['frid'],2,4);
		$topimg										= $domain.$topimgDir."/".$right_toplist[$i]['titleimg'];
		$right_toplist[$i]['toplistimg']		= $topimg;
	}else{
		$oldimgname = explode("{", $right_toplist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$right_toplist[$i]['toplistimg']		= $oldlink.$oldimgname."_list.gif";
	}
	//$img_dir = substr($toplist[$i]['regdate'],0,4);
	
	//당첨자 발표일 합체조립
	$rnotice_date								= $right_toplist[$i]['notice_date'];
	$rnotice_date								= substr($rnotice_date,0,4)."년".number_format(substr($rnotice_date,5,2))."월".number_format(substr($rnotice_date,8,2))."일";
	$right_toplist[$i]['notice_date']	= $rnotice_date;


}




//일반 프론티어 리스트 
for($i=0;$i<sizeof($right_mainlist);$i++) {

}


$frontierbannerlist		= $CLASS_FRONTIER->FrontierBannerList($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "M");
$frontierbannerlistcnt	= $CLASS_FRONTIER->FrontierBannerListCnt($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "M");



//프론티어 배너 리스트 
for($i=0;$i<sizeof($frontierbannerlist);$i++) {



		if($frontierbannerlist[$i]['frno'] > "877"){

			$bannerimgDir							= substr($frontierbannerlist[$i]['frid'],2,4);
			$bannerimg_name = $frontierbannerlist[$i]['titleimg'];
			//echo "$bannerimg_name<br>";
			$bannerimg_ready =  "http://"._DOMAIN_FILE."/frontier/banner_img/".$bannerimgDir."/".$frontierbannerlist[$i]['titleimg'];		//파일서버 이미지 경로(배너 이미지)
			$frontierbannerlist[$i]['bannerimg'] = $bannerimg_ready;
		}else{

			$oldimgname = explode("{", $frontierbannerlist[$i]['frid']);
			$oldimgname = explode("}", $oldimgname[1]);
			$oldimgname = $oldimgname[0];
			$frontierbannerlist[$i]['bannerimg']		= $oldlink.$oldimgname."_ani.gif";

		}




		//echo "bannerimg_ready:$bannerimg_ready<br>";
}

//$sql = "SELECT * FROM test LIMIT 0, 10";
//$aa = $DB->fetch($sql);

//배너 셀렉팅		
$banner_right = $CLASS_FRONTIER->BannerSelect($DB, "L");				// 메인페이지 본문 오른쪽 배너 랜덤 셀렉팅
for($n=0; $n<sizeof($banner_right); $n++) {
		$banner_right_img			= $banner_right[$n]['bannerimg']; //오른쪽 배너 이미지
		$banner_right_linktype		= $banner_right[$n]['linktype'];		//오른쪽 배너 새창,본창 열기 구분값
		$banner_right_url			= $banner_right[$n]['siteurl'];		//오른쪽 배너 메인배너 링크주고
		if($banner_right_linktype = "T"){
			$banner_right_link = "<a href='$banner_right_url' target='_blank'>";
		}else{
			$banner_right_link = "<a href='$banner_right_url' target='_top'>";
		}
}

if($n < 1){
	$banner_right_img = "N";
}else{
	$banner_right_img 	= "http://"._DOMAIN_FILE."/"._FTP_BANNERIMAGE."/".$banner_right_img;
}

//===============================================================
// VARS
//===============================================================
$conf = $conf = Module::loadConf(_DIR_CONF."/site.ini");
$notice = $CLASS_SITE->getNotice($DB);
$chart1 = $CLASS_SITE->getRecomReviewByOrder($DB);
$chart2 = $CLASS_SITE->getRecomReviewByRegdate($DB);

$openGraphFacebook = "review";
//===============================================================
//TEMPLATE VARS
//===============================================================
$TPL->setValue(array(
	"logo"=>$logo,	
	"right_toplist"=>$right_toplist,
	"right_mainlist"=>$right_mainlist,
	"nowmonth"=>$nowmonth,
	"nowday"=>$nowday,
	"frontierCount"=>$frontierCount,
	"cssblank"=>$cssblank,
	"frontierbannerlist"=>$frontierbannerlist,
	"frontierbannerlistcnt"=>$frontierbannerlistcnt,
	"right_reviewlist"=>$right_reviewlist,
	"banner_right_img"=>$banner_right_img,
	"banner_right_link"=>$banner_right_link,
	"conf"=>$conf,
	"notice"=>$notice,
	"chart1"=>$chart1,
	"chart2"=>$chart2,
	"facebookObject"=>$openGraphFacebook,
));

?>