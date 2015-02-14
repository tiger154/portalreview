<?php
/***************************************************************************************
* Module Name			:	관리자 - 예약/그룹 메일 전송내역
* Created Date			:	2011.12.02
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
$CLASS_PAGE			= &Module::singleton("Page");
$CLASS_PAGE			= &Module::singleton("Page2", 0);		
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		
$CLASS_BASIC			= &Module::singleton("Mail.Mailcla");

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


$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageNum', Module::$param[1]);
$CLASS_PAGE->set('pageRow', Module::$param[2]);






$limit = $CLASS_PAGE->getLimit();

$module = "letter.history";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");

$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];


//$limit = "Limit ".($page - 1) * $page_row.",".$page_row;
$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

// 게시물카운트
$cnt = $CLASS_BASIC->AdminGroupMailCnt($DB);
$CLASS_PAGE->set('totalRowCount', $cnt);

// 게시물리스트
$list = $CLASS_BASIC->AdminGroupMailselect($DB);



for($i=0;$i<sizeof($list);$i++) {

	$reserve_year = $list[$i]['reserve_year']; 

	if($reserve_year == "0"){
		$r_type = "즉시발송";
	}else{
		$r_type = "예약발송";
	}
	$list[$i]['r_type'] = $r_type;

	$list[$i]['r_type'] = $r_type;

	if($list[$i]['sendtype'] == "E"){
		$send_type = "개별메일";
	}else if($list[$i]['sendtype'] == "A"){
		$send_type = "그룹메일";
	}else{
		$send_type = "프론티어당첨메일";
	}

	$list[$i]['send_type'] = $send_type;


	if($list[$i]['recipientgroup'] == "A"){
		$group = "전체회원";
	}else if($list[$i]['recipientgroup'] == "B"){
		$group = "남성회원";
	}else if($list[$i]['recipientgroup'] == "C"){
		$group = "여성회원";
	}else if($list[$i]['recipientgroup'] == "1"){
		$group = "운영 테스트 그룹";
	}else{
		$group = "프론티어당첨메일";
	}
	$list[$i]['group'] = $group;



	$list[$i]['subject'] = $CLASS_BASE->strLimitUTF($list[$i]['subject'], "34", "", $eStr="...");

}



$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

//===============================================================
//TEMPLATE VARS
//===============================================================




$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"size"=>$size,
	"param"=>$param,
	"cate1_list"=>$cate1_list,
	"cate1"=>$cate1,
	"cate2"=>$cate2,
	"cate3"=>$cate3,
	"stat"=>$stat,
	"frname"=>$frname,
	"stat_selectall"=>$stat_selectall,
	"stat_select1"=>$stat_select1,
	"stat_select2"=>$stat_select2,
	"stat_select3"=>$stat_select3,
	"stat_select4"=>$stat_select4,
	"desc_text"=>$desc_text,

));
?>