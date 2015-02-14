<?php
/***************************************************************************************
* Module Name			:	관리자 - 뉴스 레터 발송
* Created Date			:	2011.08.25
* Created by				:	RevU 박상선 
* Modify History			:   
****************************************************************************************/

//===============================================================
//GLOBAL CLASS
//===============================================================
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;

//===============================================================
//GLOBAL VARS
//===============================================================
GLOBAL $FRAME;

//===============================================================
//CLASS
//===============================================================
$CLASS_BASIC = &Module::singleton("Mail.Mailcla");

//===============================================================
//EXTEND_CLASS
//===============================================================

//===============================================================
//DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");

//===============================================================
//VARS
//===============================================================

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

$frwinmail_list = $CLASS_BASIC->getFrontierWinMailList($DB);



//===============================================================
//TEMPLATE VARS
//===============================================================
$TPL->setValue(array(
	"frwinmail_list"=>$frwinmail_list,
	"now_month"=>$nowmonth,
	"nowday"=>$nowday,
	"startyear"=>$startyear,
	"startmonth"=>$startmonth,
	"startday"=>$startday,
	"starttime"=>$starttime,
	"endyear"=>$endyear,
	"endmonth"=>$endmonth,
	"endday"=>$endday,
	"endtime"=>$endtime,
	"phone_number"=>$phone_number,
	"tel_number"=>$tel_number,
	"cate1_list"=>$cate1_list,
	"bcode_list"=>$bcode_list,

));
?>