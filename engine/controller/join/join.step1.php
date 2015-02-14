<?php
/***************************************************************************************
 * 회원가입폼 컨트롤러
 * 
 * 작성일 : 2011.06.30
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
$CLASS_ZIPCODE = &Module::singleton("Zipcode");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_CODE = &Module::singleton("Code.Code");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
if($_REQUEST["agree_confirm"] == "1" && $_REQUEST["policy_confirm1"] == "1" 
&& $_REQUEST["policy_confirm2"] == "1" && $_REQUEST["policy_confirm3"] == "1" 
&& $_REQUEST["policy_confirm4"] == "1") {
	$_SESSION['joinKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "step1");
}
if($_SESSION['joinKey'] == "") {
	Module::alert("이용약관 동의를 읽으신 후에 가입하시길 바랍니다.");
	Module::redirect("/join");
}

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
$bcode_list = $CLASS_ZIPCODE->getBcodeList($DB);
$cate1_list = $CLASS_CODE->getCate1List($DB);
for($i=0; $i<sizeof($cate1_list); $i++) {
	$cate2_list = $CLASS_CODE->getCate2List($DB, $cate1_list[$i]['cate1']);	
	for($j=0; $j<sizeof($cate2_list); $j++) {
		if($j < 5) {
			$cate1_list[$i]['cate2_list'][$j] = $cate2_list[$j];
		}
	}
}

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
));
?>