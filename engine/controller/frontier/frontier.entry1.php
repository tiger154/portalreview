<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $FRAME;

$CLASS_CATECODE = &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE = &Module::singleton("Zipcode");

$DB = &Module::loadDb("revu");

$table_name		= "Rf_cate1_code"; 

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
$tel_number = array("02", "051", "053", "032", "062", "042", "052", "031", "033", "043", "063", "061", "054", "055", "064", "070");


$cate1_list = $CLASS_CATECODE->getCate1List($DB);
$bcode_list = $CLASS_ZIPCODE->getBcodeList($DB);



$frno = "69";
$frid	 = "F_20110809234228";
$userno = "93";
$userid = "jingeese";

$TPL->setValue(array(
	"birth_year"=>$birth_year,
	"birth_month"=>$birth_month,
	"birth_day"=>$birth_day,
	"phone_number"=>$phone_number,
	"tel_number"=>$tel_number,
	"cate1_list"=>$cate1_list,
	"bcode_list"=>$bcode_list,
	"frno"=>$frno,
	"frid"=>$frid,
	"userno"=>$userno,
	"userid"=>$userid,
));
?>