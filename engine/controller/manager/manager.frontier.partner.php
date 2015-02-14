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
$CLASS_MANAGER	= &Module::singleton("Manager.Manager");

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

$module = "frontier.partner";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");

$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];


//$limit = "Limit ".($page - 1) * $page_row.",".$page_row;
$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

// 게시물카운트
$cnt = $CLASS_MANAGER->AdminPartnerCnt($DB);

$CLASS_PAGE->set('totalRowCount', $cnt);

// 게시물리스트
$list = $CLASS_MANAGER->AdminPartnerselect($DB);

for($i=0;$i<sizeof($list);$i++) {

	$type = $list[$i]['confirm_']; 

	if($type == "0"){
		$r_type = "미처리";
	}else{
		$r_type = "담당자확인";
	}

	$list[$i]['confirm'] = $r_type;
	$list[$i]['memo'] = $CLASS_BASE->strLimitUTF($list[$i]['memo'], "34", "", $eStr="...");
	

	$rfile = $list[$i]['file'];
	if($rfile == ""){
		$list[$i]['file'] =  "-";
	}else{
		$list[$i]['file'] = "<a href='http://file.revu.co.kr/frontier/alliance_file/$rfile'>$rfile</a>";
	}

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
));
?>