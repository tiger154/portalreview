<?php
/***************************************************************************************
 * 회원등급산정표 크론
 * 
 * 작성일 : 2011.10.18
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
$CLASS_GRADE = &Module::singleton("User.Grade");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$grade = 18; 
$sq = 1.5; 
$num = 10; 
$minPoint = 1000;
$maxPoint = $CLASS_GRADE->getMaxPoint($DB);
$mediumPoint = $CLASS_GRADE->getMediumPoint($DB, $num);
$gradeArr = $CLASS_GRADE->getGradeArray($maxPoint, $mediumPoint, $minPoint, $grade, $sq);
$res = array();
if($gradeArr == false) {
	$res[]["err"] = "-1";		
} else {
	for($i=0; $i<sizeof($gradeArr); $i++) {
		$arr = array();
		$arr[] = $i+1;
		$arr[] = $gradeArr[$i]['spoint'];
		$arr[] = $gradeArr[$i]['epoint'];
		$arr[] = $gradeArr[$i]['gap'];
		$arr[] = $CLASS_GRADE->getUsernum($DB, $gradeArr[$i]['spoint'], $gradeArr[$i]['epoint']);
		$res[] = $DB->call("p_grade_ins", $arr);			
		$DB->rConnect();
	}
}

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "회원등급-일일등급산정표 생성 실패";	
} else {
	$msg = "회원등급-일일등급산정표 생성  성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "회원등급-일일등급산정표", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>