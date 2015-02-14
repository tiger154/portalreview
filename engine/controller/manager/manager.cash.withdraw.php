<?php
/***************************************************************************************
 * 관리자 캐시신청 리스트
 * 
 * 작성일 : 2011.11.14
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
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_LOG = &Module::singleton("Manager.Log");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$stats = $CLASS_LOG->getStats($DB_LOG);
$eday = date("t", mktime(0, 0, 0, date("m"), date("d"), date("Y")));
$sdate = (Module::$param[1] == "") ? date("Ym01") : Module::$param[1];
$edate = (Module::$param[2] == "") ? date("Ym").$eday : Module::$param[2];
$cashsum = $CLASS_CASH->getCashWithdrawSum($DB, $sdate, $edate);
$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_CASH->getCashWithdrawCount($DB, $sdate, $edate);
$list = $CLASS_CASH->getCashWithdrawList($DB, $limit, $sdate, $edate);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0; $i<$size; $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);
	$list[$i]['extra'] = $CLASS_USER->getUserExtra($DB, $list[$i]['userno']);
	$list[$i]['bank'] = $CLASS_CODE->getBankCode($DB, $list[$i]['bankcode']);	
	$list[$i]['attach_type_text1'] = $CLASS_CASH->attach_type1[$list[$i]['attach_type1']];
	$list[$i]['attach_type_text2'] = $CLASS_CASH->attach_type2[$list[$i]['attach_type2']];	
	$list[$i]['flag_pay_text'] = $CLASS_CASH->flag_pay[$list[$i]['flag_pay']];
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"stats"=>$stats,
	"cashsum"=>$cashsum, 
	"sdate"=>$sdate, 
	"edate"=>$edate, 
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>