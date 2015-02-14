<?php
/***************************************************************************************
 * 마이레뷰-프론티어
 * 
 * 작성일 : 2011.10.7
 * 작성자 : 박상선
 * 히스토리 :  
 * 
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;
 
GLOBAL $FRAME; 
$FRAME = "popup";


//===============================================================
// EXTEND_CLASS
//===============================================================
$CLASS_PAGE			= &Module::singleton("Page");
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		


/**
 * CLASS
 */
$CLASS_BLOG = &Module::singleton("Blog.Blog");

//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");


#######오늘의 프론티어 ##########
$today = date("YmdHis");		
$day_nowmonth	 = date("m");
$day_nowday		 = date("d");

$frontierList	= $CLASS_FRONTIER->FrontierMainselect($DB, $today);  //오늘의 프론티어 롤링리스트 셀렉팅
$frontierCnt	= $CLASS_FRONTIER->FrontierMainCnt($DB, $today);		//체험가능한 프론티어 카운팅

for($f=0; $f<sizeof($frontierList); $f++) {

	//모집기간 시작일 합체조립
	$jstart_date = $frontierList[$f]['start_date'];
	$jstart_date = substr($jstart_date,0,4).".".number_format(substr($jstart_date,5,2)).".".number_format(substr($jstart_date,8,2)).".";
	$frontierList[$f]['start_date'] = $jstart_date;

	//모집기간 종료일 합체조립
	$jend_date = $frontierList[$f]['end_date'];
	$jend_date = substr($jend_date,0,4).".".number_format(substr($jend_date,5,2)).".".number_format(substr($jend_date,8,2)).".";
	$frontierList[$f]['end_date'] = $jend_date;

	//발표일 합체조립
	$jnotice_date = $frontierList[$f]['notice_date'];
	$jnotice_date = substr($jnotice_date,0,4).".".number_format(substr($jnotice_date,5,2)).".".number_format(substr($jnotice_date,8,2)).".";
	$frontierList[$f]['notice_date'] = $jnotice_date;

	//리뷰작성기간 합체조립
	$jdue_edate = $frontierList[$f]['due_edate'];
	$jdue_edate = substr($jdue_edate,0,4).".".number_format(substr($jdue_edate,5,2)).".".number_format(substr($jdue_edate,8,2)).".";
	$frontierList[$f]['due_edate'] = $jdue_edate;



	$frontierList[$f]['subject'] = $CLASS_BASE->strLimitUTF($toplist[$f]['subject'], "28", "", $eStr="...");

}
#######오늘의 프론티어 끝##########

/**
 * VAR / PROC
 */
		
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"day_nowmonth"=>$day_nowmonth,	//오늘의 프론티어 vars
	"day_nowday"=>$day_nowday,			//오늘의 프론티어 vars		
	"frontierCnt"=>$frontierCnt,					//오늘의 프론티어 vars
	"frontierList"=>$frontierList,					//오늘의 프론티어 vars
));




?>