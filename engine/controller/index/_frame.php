<?php
 /***************************************************************************************
 * 인덱스  프레임 컨트롤러
 * 
 * 작성일 : 2011.10.12
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
$CLASS_SITE = &Module::singleton("Site.Site");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier"); //프론티어

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

$conf = $conf = Module::loadConf(_DIR_CONF."/site.ini");
$notice = $CLASS_SITE->getNotice($DB);
$chart1 = $CLASS_SITE->getRecomReviewByOrder($DB);
$chart2 = $CLASS_SITE->getRecomReviewByRegdate($DB);

//배너 셀렉팅		
$banner_right = $CLASS_FRONTIER->BannerSelect($DB, "L"); 
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
$frontierbannerlist		= $CLASS_FRONTIER->FrontierBannerList($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "M");
$frontierbannerlistcnt	= $CLASS_FRONTIER->FrontierBannerListCnt($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "M");

for($i=0;$i<sizeof($frontierbannerlist);$i++) {
	if($frontierbannerlist[$i]['frno'] > "877"){
		$bannerimgDir = substr($frontierbannerlist[$i]['frid'],2,4);
		$bannerimg_name = $frontierbannerlist[$i]['titleimg'];
		$bannerimg_ready =  "http://"._DOMAIN_FILE."/frontier/banner_img/".$bannerimgDir."/".$bannerimg_name;		//파일서버 이미지 경로(배너 이미지)
		$frontierbannerlist[$i]['bannerimg'] = $bannerimg_ready;
	}else{
		$oldimgname = explode("{", $frontierbannerlist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$frontierbannerlist[$i]['bannerimg']		= $oldlink.$oldimgname."_ani.gif";
	}
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"conf"=>$conf,
	"notice"=>$notice,
	"chart1"=>$chart1,
	"chart2"=>$chart2,
	"banner_right_img"=>$banner_right_img,
	"banner_right_link"=>$banner_right_link,
	"frontierbannerlist"=>$frontierbannerlist,
	"frontierbannerlistcnt"=>$frontierbannerlistcnt,
));
?>