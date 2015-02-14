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
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$wno = $CLASS_REVIEWBEST->getBestWeekLast($DB);
$date = $CLASS_REVIEWBEST->getBestWeekDate($DB, $wno); 
$edate = explode("-", $date['edate']); 
$sdate = date("Y-m-d H:i:s", mktime(0,0,0, $edate[1], $edate[2]+1, $edate[0]));

$arr = array();
$arr[] = $sdate;
$arr[] = 6;
$res = array();
$res[] = $DB->call("p_review_best_week_ins", $arr);			
$DB->rConnect();

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "베스트리뷰-주간정보입력 실패";	
} else {
	$msg = "베스트리뷰-주간정보입력  성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "베스트리뷰-주간정보", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>