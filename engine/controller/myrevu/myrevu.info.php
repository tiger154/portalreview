<?php
/***************************************************************************************
 * 마이레뷰-회원정보수정
 * 
 * 작성일 : 2011.09.08
 * 작성자 : 이종학
 * 히스토리 :  
 * 
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
$CLASS_ZIPCODE = &Module::singleton("Zipcode");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$_SESSION['infoKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "info");

$now_year = date("Y");
$now_month = date("m");
$now_day = date("d");
$birth_year = array();
$birth_month = array();
$birth_day = array();
for($i=$now_year; $i>=1900; $i--) {
	$birth_year[] = $i;
}
for($i=1; $i<=12; $i++) {
	$birth_month[] = $i;
}
for($i=1; $i<=31; $i++) {
	$birth_day[] = $i;
}
$phone_number = array("010", "011", "016", "017", "018", "019");
$cate1_list = $CLASS_CODE->getCate1List($DB);
for($i=0; $i<sizeof($cate1_list); $i++) {
	$cate2_list = $CLASS_CODE->getCate2List($DB, $cate1_list[$i]['cate1']);	
	for($j=0; $j<sizeof($cate2_list); $j++) {
		if($j < 5) {
			$cate1_list[$i]['cate2_list'][$j] = $cate2_list[$j];
		}
	}
}

$user = $CLASS_USER->getUser($DB, $_SESSION['userno']);
$extra = $CLASS_USER->getUserExtra($DB, $user['userno']);
$imgsrc = $CLASS_USER->getImage($user['userno'], $extra['userimage']);

$user_birthday = explode("-",$extra['birthday']);
$user_cell = explode("-",$extra['cell']);
$user_tel = explode("-",$extra['tel']);
$user_catecode = $CLASS_USER->getUserCateCode($DB, $user['userno']);
$cate1 = $CLASS_CODE->transCate($user_catecode[0]); // array -> string
$cate2 = $CLASS_CODE->transCate($user_catecode[1]); // array -> string
$user_areacode = $CLASS_USER->getUserAreaCode($DB, $user['userno']);
$area1 = $CLASS_CODE->transArea($user_areacode[0]); // array -> string
$area2 = $CLASS_CODE->transArea($user_areacode[1]); // array -> string

/**
 * TEMPLATE VARS
 */
$TPL->defineTemplate("zipcode", "_global_layer", "zipcode.htm");
$TPL->setValue(array(
	"now_year"=>$now_year,
	"now_month"=>$now_month,
	"now_day"=>$now_day,
	"birth_year"=>$birth_year,
	"birth_month"=>$birth_month,
	"birth_day"=>$birth_day,
	"phone_number"=>$phone_number,
	"bcode_list"=>$bcode_list,
	"cate1_list"=>$cate1_list,
	"user"=>$user,
	"extra"=>$extra,
	"imgsrc"=>$imgsrc,
	"user_birthday"=>$user_birthday,
	"user_cell"=>$user_cell,
	"user_tel"=>$user_tel,
	"user_areacode"=>$user_areacode,
	"area1"=>$area1,
	"area2"=>$area2,
	"cate1"=>$cate1,
	"cate2"=>$cate2,
));
?>