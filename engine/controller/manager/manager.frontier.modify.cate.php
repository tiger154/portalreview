<?php
/***************************************************************************************
* Module Name			:	관리자 - 프론티어 등록페이지
* Created Date			:	2011.07.12
* Created by				:	RevU 박상선 
* Modify History			:   
****************************************************************************************/

//===============================================================
//GLOBAL CLASS
//===============================================================
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;


GLOBAL $FRAME;
$FRAME = "popup";
//===============================================================
//CLASS
//===============================================================
$CLASS_CATECODE = &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE = &Module::singleton("Zipcode");

//===============================================================
//EXTEND_CLASS
//===============================================================

//===============================================================
//DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");
$frno = Module::$param[3];
$type = Module::$param[4];


//echo "frno:$frno<br>";
//echo "type:$type<br>";
//===============================================================
//VARS
//===============================================================
$table_name		= "Rf_cate1_code"; //1차 카테고리 테이블 명

$nowyear			= date("Y");
$nowmonth		= date("m");
$nowday			= date("d");

$startyear			= array();
$startmonth		= array();
$startday			= array();
$startnowtime	= array();

$endyear			= array();
$endmonth		= array();
$endday			= array();
$endnowtime		= array();


for($i=$nowyear; $i<=2020; $i++) {
	$startyear[]		= $i;
	$endyear[]		= $i;
}

for($i=1; $i<=12; $i++) {
	$startmonth[]	= $i;
	$endmonth[]		= $i;
}

for($i=1; $i<=31; $i++) {
	$startday[]		= $i;
	$endday[]			= $i;
}

for($i=1; $i<=24; $i++) {
	$starttime[]		= $i;
	$endtime[]		= $i;
}


$phone_number = array("010", "011", "016", "017", "018", "019");
$tel_number = array("02", "051", "053", "032", "062", "042", "052", "031", "033", "043", "063", "061", "054", "055", "064", "070");


$cate1_list = $CLASS_CATECODE->AdmingetCate1List($DB);
$bcode_list = $CLASS_ZIPCODE->getBcodeList($DB);


//===============================================================
//TEMPLATE VARS
//===============================================================
$TPL->setValue(array(
	"frno"=>$frno,
	"type "=>$type,
	"cate1_list"=>$cate1_list,
	"bcode_list"=>$bcode_list,

));
?>