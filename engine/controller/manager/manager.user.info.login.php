<?php
/***************************************************************************************
 * 관리자 회원정보
 * 
 * 작성일 : 2011.11.02
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

$FRAME = "popup";
/**
 * CLASS
 */
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_SITE = &Module::singleton("Site.Site");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CODE = &Module::singleton("Code.Code");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
if(Module::$param[0] == "list") {
	$where = "";
	if(Module::$param[1] != "") $where .= " AND A.birthday >= '".Module::$param[1]."-01-01'";
	if(Module::$param[2] != "") $where .= " AND A.birthday <= '".Module::$param[2]."-12-31'";
	if(Module::$param[3] != "") $where .= " AND A.gender = '".Module::$param[3]."'";		
	$sql = "
	SELECT A.userno, A.birthday, B.username FROM Ru_account_extra A
	INNER JOIN Ru_account B ON(A.userno = B.userno) 
	WHERE 1 ".$where."
	ORDER BY A.userno DESC 
	LIMIT ".Module::$param[4].", ".Module::$param[5]."
	";
	$rs = $DB->fetch($sql);
	for($i=0; $i<sizeof($rs); $i++) {		
		$user = $CLASS_USER->getUser($DB, $rs[$i]['userno']);
		$sql2 = "SELECT * FROM Rl_login WHERE userno='".$user['userno']."' ORDER BY idx DESC LIMIT 10 ";	
		$rs2 = $DB_LOG->fetch($sql2);
		if(sizeof($rs2) > 0) {
			print($rs[$i]['birthday']."<br />".$user['email']."<br />");
			for($j=0; $j<sizeof($rs2); $j++) print($CLASS_ENCRYPTER->decryptMD5($rs2[$j]['passwd'], $key="jingeese"). "<br />");
			print("<hr />");
		}
	}
}
if(Module::$param[0] == "info") {
	switch(Module::$param[1]) {
		case "userid" : 
			$user = $CLASS_USER->getUserByID($DB, Module::$param[2]);
			break;
		case "nickname" : 
			$user = $CLASS_USER->getUserByNick($DB, Module::$param[2]);
			break;
		case "review" : 
			$review = $CLASS_REVIEW->getReview($DB, Module::$param[2]);
			$userno = $review['userno'];
			$user = $CLASS_USER->getUser($DB, Module::$param[2]);
		case "userno" : 
		default : 
			$user = $CLASS_USER->getUser($DB, Module::$param[2]);
			break;
	}
	print("<pre>");
	print_r($user);	
	print("<hr />");
	$sql = "SELECT * FROM Rl_login WHERE userno='".$user['userno']."' LIMIT 10";
	$rs = $DB_LOG->fetch($sql);
	if(sizeof($rs) > 0) {		
		print($user['email']."<br />");
		for($i=0; $i<sizeof($rs); $i++) print($CLASS_ENCRYPTER->decryptMD5($rs[$i]['passwd'], $key="jingeese")."<br />");		
	}
	print("</pre>");
}
Module::exitModule();
exit;
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"login"=>$login, 
	"log"=>$log,
));
?>