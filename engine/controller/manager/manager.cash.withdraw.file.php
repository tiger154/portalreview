<?php
/***************************************************************************************
 * 관리자  캐시신청 첨부파일
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
$FRAME = "popup";

/**
 * CLASS
 */
$CLASS_PAGE = &Module::singleton("Page2", 0);
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
if(Module::$param[0] == "" || Module::$param[1] == "") {
	Module::alert("잘못된 경로입니다.");
	Module::close();
}
$withdraw = $CLASS_CASH->getCashWithdraw($DB, Module::$param[1]);
$file = $CLASS_CASH->getCashWithdrawFile($DB, Module::$param[0], Module::$param[1]);
$dir1 = substr($file['regdate'],0,4);
$dir2 = substr($file['regdate'],5,2);
$dir3 = substr($file['regdate'],8,2);
$img = "http://"._DOMAIN_FILE."/"._FTP_WITHDRAWIMAGE."/".$dir1."/".$dir2."/".$dir3."/".$file['filename'];
$user = $CLASS_USER->getUser($DB, $withdraw['userno']);
$type_text = $CLASS_CASH->attach_type[Module::$param[0]];

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array( 
	"withdraw"=>$withdraw, 
	"file"=>$file,
	"img"=>$img, 
	"user"=>$user,
	"type_text"=>$type_text, 
));
?>