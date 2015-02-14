<?php
/***************************************************************************************
 * 관리자 회원리스트
 * 
 * 작성일 : 2011.10.28
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
$CLASS_USER = &Module::singleton("User.User");
$CLASS_GRADE = &Module::singleton("User.Grade");
$CLASS_LOG = &Module::singleton("Manager.Log");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
$CLASS_MANAGER_POWERBLOG = &Module::singleton("Manager.PowerBlog");
$CLASS_MANAGER = &Module::singleton("Manager.Manager");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");
$DB_MYSQL = &Module::loadDb("mysql");

/**
 * VAR / PROC
 */
// mysql 이벤트
$var = $BASE->getMysqlVariables("event_scheduler");

// 총 통계
$stats = $CLASS_LOG->getStats($DB_LOG);

// 캐시로그
$nday = date("Y-m-d");
$pday = date("Y-m-d", mktime(date("H"),date("i"),date("s"), date("m"), date("d")-1, date("Y")));
$nmonth = date("Y-m");
$pmonth = date("Y-m", mktime(date("H"),date("i"),date("s"), date("m")-1, date("d"), date("Y")));
$cashLog['nday']['date'] = $nday;
$cashLog['nday']['cash_save'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_save", $nday, $nday);
$cashLog['nday']['cash_use'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_use", $nday, $nday);
$cashLog['pday']['date'] = $pday;
$cashLog['pday']['cash_save'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_save", $pday, $pday);
$cashLog['pday']['cash_use'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_use", $pday, $pday);
$cashLog['nmonth']['date'] = $nmonth;
$cashLog['nmonth']['cash_save'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_save", $nmonth."-01", $nmonth."-31");
$cashLog['nmonth']['cash_use'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_use", $nmonth."-01", $nmonth."-31");
$cashLog['pmonth']['date'] = $pmonth;
$cashLog['pmonth']['cash_save'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_save", $pmonth."-01", $pmonth."-31");
$cashLog['pmonth']['cash_use'] = $CLASS_LOG->getCashByDate($DB_LOG, "cash_use", $pmonth."-01", $pmonth."-31");

// 회원등급 리스트
$gradeList = $CLASS_GRADE->getGradeList($DB);
$gradeLogList = $CLASS_LOG->getCronLogList($DB_LOG, "LIMIT 0, 1", "회원등급-일일등급산정표");

// 크론로그 리스트
$logList = $CLASS_LOG->getCronLogList($DB_LOG, "LIMIT 0, 10");

// 트랜잭션 에러로그 리스트
$errorList = $CLASS_LOG->getErrorLogList($DB_LOG, "LIMIT 0, 10");

// 베스트리뷰
$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d", mktime(date("H"),date("i"),date("s"), date("m"), date("d"), date("Y"))));
$wno = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
$bestdate = $CLASS_REVIEWBEST->getBestWeekDate($DB, $wno); 
$best = $CLASS_REVIEWBEST->getBestReview($DB, $wno, $limit=6);
for($i=0; $i<sizeof($best); $i++) {
	$_review = $CLASS_REVIEW->getReview($DB, $best[$i]['rno']);
	$_cash = $CLASS_LOG->getBestReviewCash($DB, $best[$i]['userno'], $best[$i]['rno']);
	$best[$i]['title'] = $_review['title'];
	$best[$i]['user'] = $CLASS_USER->getUser($DB, $best[$i]['userno']);
	$best[$i]['cash'] = $_cash['cash'];
}

// 파워블로그 신청
$powerblogList = $CLASS_MANAGER_POWERBLOG->getPowerBlogList($DB, "LIMIT 0, 5", "0");
for($i=0; $i<sizeof($powerblogList); $i++) {
	$powerblogList[$i]['user'] = $CLASS_USER->getUser($DB, $powerblogList[$i]['userno']);
	$powerblogList[$i]['cate1_text'] = $CLASS_MANAGER_POWERBLOG->cate[$powerblogList[$i]['cate1']];
	$powerblogList[$i]['cate2_text'] = $CLASS_MANAGER_POWERBLOG->cate[$powerblogList[$i]['cate2']];
	$powerblogList[$i]['cate3_text'] = $CLASS_MANAGER_POWERBLOG->cate[$powerblogList[$i]['cate3']];
	$powerblogList[$i]['cate4_text'] = $CLASS_MANAGER_POWERBLOG->cate[$powerblogList[$i]['cate4']];
	$powerblogList[$i]['cate5_text'] = $CLASS_MANAGER_POWERBLOG->cate[$powerblogList[$i]['cate5']];
}

// 제휴신청리스트 
$allianceList = $CLASS_MANAGER->getFrontierAllianceList($DB, "LIMIT 0, 10");
for($i=0; $i<sizeof($allianceList); $i++) {
	$allianceList[$i]['memo'] = $BASE->strLimitUTF($allianceList[$i]['memo'], 25, $checkmb=false, $eStr='...');	
}
//print_r($_SESSION);
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"var"=>$var, 
	"stats"=>$stats,
	"cashLog"=>$cashLog, 
	"gradeList"=>$gradeList,
	"gradeLogList"=>$gradeLogList,
	"logList"=>$logList,
	"errorList"=>$errorList,
	"best"=>$best,
	"bestdate"=>$bestdate,
	"powerblogList"=>$powerblogList,
	"allianceList"=>$allianceList,
));
?>