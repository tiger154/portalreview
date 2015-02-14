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
$cnt = $CLASS_CASH->getCashWithdrawCount($DB, $sdate, $edate);
$list = $CLASS_CASH->getCashWithdrawList($DB, "LIMIT 0, ".$cnt, $sdate, $edate);
$size = sizeof($list);

$html = "";
$html .= "<table width='100%' cellpadding='1'>";
$html .= "<tr bgcolor='CCC'>";
$html .= "<th>신청일시</th>"; 
$html .= "<th>아이디</th>";
$html .= "<th>닉네임</th>";
$html .= "<th>이름</th>";
$html .= "<th>액수</th>";		
$html .= "<th>은행</th>";
$html .= "<th>계좌번호</th>";
$html .= "<th>휴대폰번호</th>";
$html .= "<th>주민번호</th>";
$html .= "<th>주소</th>";
$html .= "</tr>";
for($i=0; $i<$size; $i++) {
	$list[$i]['user'] = $CLASS_USER->getUser($DB, $list[$i]['userno']);
	$list[$i]['extra'] = $CLASS_USER->getUserExtra($DB, $list[$i]['userno']);
	$list[$i]['bank'] = $CLASS_CODE->getBankCode($DB, $list[$i]['bankcode']);	
	$list[$i]['attach_type_text1'] = $CLASS_CASH->attach_type1[$list[$i]['attach_type1']];
	$list[$i]['attach_type_text2'] = $CLASS_CASH->attach_type2[$list[$i]['attach_type2']];	
	$list[$i]['flag_pay_text'] = $CLASS_CASH->flag_pay[$list[$i]['flag_pay']];
	$html .= "<tr>";
	$html .= "<th>&nbsp;".$list[$i]['regdate']."</th>"; 
	$html .= "<th>&nbsp;".$list[$i]['user']['userid']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['user']['nickname']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['user']['username']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['cash']."</th>";		
	$html .= "<th>&nbsp;".$list[$i]['bank']['code_desc']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['account_number']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['extra']['cell']."</th>";
	$html .= "<th>&nbsp;".$list[$i]['socialno']."</th>";
	$html .= "<th>&nbsp;[".$list[$i]['extra']['zipcode']."]".$list[$i]['extra']['addr1']." ".$list[$i]['extra']['addr2']."</th>";
	$html .= "</tr>";
}
$html .= "</table>";
header( "Content-type: application/vnd.ms-excel" ); 
header( "Content-Disposition: attachment; filename=캐시신청자_".$sdate."_".$edate.".xls"); 
header( "Content-Description: PHP5 Generated Data" );
print($html);
Module::exitModule();

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