<?php
/***************************************************************************************
 * 베스트리뷰 산정
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
$wno_now = $wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d"));
$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
$wno_prev = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno);

$list = $CLASS_REVIEWBEST->getBestCandRankList($DB, $wno_prev, $limit=1);

$clist = array();
$clist = $CLASS_REVIEWBEST->getBestCandRankCateList($DB, $wno_prev, $list[0]['rno']);
for($i=0; $i<sizeof($clist); $i++) array_push($list, $clist[$i]);

$res = array();
$cash = array('20000','10000','10000','5000','5000','5000');

for($i=0; $i<sizeof($list); $i++) {
	$arr = array();
	//$arr[] = $list[$i]['wno'];
	$arr[] = $wno; 
	$arr[] = $list[$i]['userno'];
	$arr[] = $list[$i]['rno'];
	$arr[] = $i+1;
	$arr[] = $list[$i]['recom_cnt'];
	$DB->rConnect();
	$res[] = $DB->call("p_review_best_ins", $arr);

	if(Module::result($res, "err", "-1") != false) {
		$arr = array();
		$arr[] = $list[$i]['userno'];
		$arr[] = "0";
		$arr[] = "302";
		$arr[] = $cash[$i];
		$arr[] = $list[$i]['rno'];
		$DB->rConnect();
		$res[] = $DB->call("p_cash_ins", $arr);
	}
}

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "베스트리뷰-랭킹산정 실패";	
} else {
	$msg = "베스트리뷰-랭킹산정  성공";
}
$CLASS_BASE->insertCronLog($DB_LOG, "베스트리뷰-랭킹산정", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>