<?php
/***************************************************************************************
 * 마이레뷰-캐시
 * 
 * 작성일 : 2011.09.07
 * 작성자 : 이종학
 * 히스토리 :  
 * 
 ***************************************************************************************/ 
//print_r($_SESSION);
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
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_REVIEW = &Module::singleton("Review.Review");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$_SESSION['withdrawKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "withdraw");
$bankcode = $CLASS_CODE->getBankCodeList($DB);
$cash = $CLASS_CASH->getCash($DB, $_SESSION['userno']);
$mincash = 30000;
$cashList = array();
if($cash['cash'] < $mincash) {
	Module::alert("30,000캐시 이상의 경우에만 출금 가능합니다.");
	Module::redirect("/myrevu/cash");
}

// 3만일 경우 조건 추가
if($cash['cash'] == 30000){
	$size = 1;
}else{
	$size = floor(($cash['cash']-30000)/10000)+1;
}



for($i=0; $i<$size; $i++) {
	$cashList[$i]['cash'] = $mincash + ($i * 10000);
	//echo $cashList[$i]['cash']."<br/>";
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"bankcode"=>$bankcode, 
	"cash"=>$cash,
	"cashList"=>$cashList, 
));
?>