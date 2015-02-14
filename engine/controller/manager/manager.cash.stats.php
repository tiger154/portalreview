<?php
/***************************************************************************************
 * 관리자 캐시적립현황
 * 
 * 작성일 : 2011.11.15
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

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
switch(Module::$param[2]) {
	case "nickname" : $user = $CLASS_USER->getUserByNick($DB, Module::$param[3]); break;
	case "userid" : $user = $CLASS_USER->getUserByID($DB, Module::$param[3]); break;
	case "userno" : $user['userno'] = Module::$param[3]; break;
}

$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_CASH->getCashCount($DB, Module::$param[1], $user['userno']); 
$list = $CLASS_CASH->getCashList($DB, $limit, Module::$param[1], $user['userno']); 
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

$_type = $CLASS_CODE->getCashTypeList($DB);
$type = array();
for($i=0; $i<sizeof($_type); $i++) {	
	$type[$_type[$i]['state']] = $_type[$i]['state_explain'];
}
for($i=0; $i<$size; $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);
	$list[$i]['flag_sign_text'] = $CLASS_CASH->flag_sign[$list[$i]['flag_sign']];
	$list[$i]['cash_type_text'] = $type[$list[$i]['cash_type']];
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>