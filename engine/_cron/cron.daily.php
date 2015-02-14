<?php
/***************************************************************************************
 * 일일처리 크론
 * 
 * 작성일 : 2011.11.03
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

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$res = array();

// 통계 일별날짜 추가
$arr = array();
$res[] = $DB_LOG->call("p_count_date_ins", $arr);

/**
 * CRON LOG
 */

$DB_LOG->rConnect();
if(Module::result($res, "err", "-1") == false) {
	$msg = "일별처리 실패";	
} else {
	$msg = "일별처리 성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "일별처리", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>