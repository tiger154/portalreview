<?php
/***************************************************************************************
 * 추천수 많은 리뷰 정보
 * 
 * 작성일 : 2011.10.12
 * 작성자 : 이종학
 * 히스토리 :  
 * 
 ***************************************************************************************/ 
/**
 * 시스템 파일 
 */
require_once "/www/revu39/engine/_sys/sys.conf.cron.php";
require_once _DIR_ENGINE."/_sys/sys.module.php";

/**
 * PHP 에러리포트 설정
 * 
 * sys.conf.php 참조
 */
error_reporting(_ERROR_REPORTING);

/**
 * 사이트설정정보
 */
$SITE = Module::loadConf(_INI_SITE);

/**
 * CLASS
 */
$CLASS_BASE = &Module::singleton("Base");
$CLASS_REVIEW = &Module::singleton("Review.Review");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$list = $CLASS_REVIEW->getOrderReviewListByRecom($DB, $num=5, $day=1);

for($i=0; $i<$num; $i++) {
	if($list[$i]['rno'] != "") {
		$arr = array();
		$arr[] = $i;
		$arr[] = $list[$i]['rno'];	
		$arr[] = $list[$i]['recom_cnt'];	
		$DB->rConnect();
		$res[] = $DB->call("p_cache_review_recom_ins", $arr);
	}	
	//echo "rno :".$list[$i]['rno']." recom_cnt:".$list[$i]['recom_cnt']."\r\n";
}

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "캐시-많은추천리뷰 입력 실패";	
} else {
	$msg = "캐시-많은추천리뷰 입력 성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "캐시-많은추천리뷰", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>
