<?php
/***************************************************************************************
 * 관리자 통계로그
 * 
 * 작성일 : 2011.11.04
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
$CLASS_PAGE = &Module::singleton("Page2", 0);
$CLASS_LOG = &Module::singleton("Manager.Log");

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$stats = $CLASS_LOG->getStats($DB_LOG);
$eday = date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$sdate = (Module::$param[1] == "") ? date("Ym01") : Module::$param[1];
$edate = (Module::$param[2] == "") ? date("Ym").$eday : Module::$param[2];

$stats2 = array();
$stats2['user_tcnt'] = $CLASS_LOG->getStatsSum($DB_LOG, "user_cnt", $sdate, $edate);
$stats2['secede_tcnt'] = $CLASS_LOG->getStatsSum($DB_LOG, "secede_cnt", $sdate, $edate);
$stats2['cash_save'] = $CLASS_LOG->getStatsSum($DB_LOG, "cash_save", $sdate, $edate);
$stats2['cash_use'] = $CLASS_LOG->getStatsSum($DB_LOG, "cash_use", $sdate, $edate);	

$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageRow', 31);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_LOG->getStatsCount($DB_LOG, $sdate, $edate); 
$list = $CLASS_LOG->getStatsList($DB_LOG, $limit, $sdate, $edate);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";
		
//for($i=0; $i<$size; $i++) { }

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"stats"=>$stats, 
	"stats2"=>$stats2, 
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"sdate"=>$sdate, 
	"edate"=>$edate, 
	"param"=>Module::$param,
));
?>