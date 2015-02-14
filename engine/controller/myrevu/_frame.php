<?php
 /***************************************************************************************
 * 마이레뷰  프레임 컨트롤러
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
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$conf = $conf = Module::loadConf(_DIR_CONF."/site.ini");
$notice = $CLASS_SITE->getNotice($DB);

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
		
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"conf"=>$conf,
	"notice"=>$notice,
	"banner_right_img"=>$banner_right_img,
	"banner_right_link"=>$banner_right_link,
));
?>