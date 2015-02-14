<?php
/******************************************************************************************
* Module Name			:	관리자 - 프론티어 응모자 관리(응모정보view, 당첨/취소처리)
* Created Date			:	2011.08.18
* Created by				:	RevU 박상선 
* Modify History			:   
*******************************************************************************************/
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
$FRAME = "popup";
//===============================================================
//CLASS
//===============================================================
$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

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
//$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE = &Module::singleton("Page2", 0);		

$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageNum', Module::$param[1]);
$CLASS_PAGE->set('pageRow', Module::$param[2]);

$event_no			= Module::$param[3];
$entry_count		= Module::$param[4];
$title					= urldecode(Module::$param[5]);
$userno			= Module::$param[6];
$type				= Module::$param[7];
$list					= Module::$param[8];
$stat					= Module::$param[9];

$limit = $CLASS_PAGE->getLimit();

$param = array();
$param[] = $event_no;
$param[] = $entry_count;
$param[] = $title;

$module = "frontier.entrylist";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");


$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];




$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

//당첨-당첨취소 처리
if($type !=  ""){
	$winupdate = $CLASS_FRONTIER->frontierentry_update($DB, $event_no, $userno, $type);
	$type = "";
}else{
	$type = "";
}

//응모정보 게시물 카운트
$entry_count = $CLASS_FRONTIER->AdmingetEntryListCount($DB, $event_no, "0");
$cnt = $entry_count;
// 게시물리스트
$list = $CLASS_FRONTIER->AdmingetEntryList($DB, $event_no, $btitle, $sch_opt, $sch_con, $limit, $frname, $stat);



// 프론티어 제목
$subject = $CLASS_FRONTIER->frontiernameSelect($DB, $event_no);


// 페이지생성
//$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
//$link = $CLASS_PAGE->getLinkFrontier();
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";


// 페이지폼
/*
$page_form = $CLASS_PAGE->firstPageLink."&nbsp;";
$page_form .= $CLASS_PAGE->backLink."&nbsp;";
$page_form .= $CLASS_PAGE->prevPageLink."&nbsp;";
$page_form .= $CLASS_PAGE->pageLink."&nbsp;";
$page_form .= $CLASS_PAGE->nextPageLink."&nbsp;";
$page_form .= $CLASS_PAGE->forwardLink."&nbsp;";
$page_form .= $CLASS_PAGE->lastPageLink;
*/
//===============================================================
//TEMPLATE VARS
//===============================================================


$TPL->setValue(array(
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"link"=>$link,
	"size"=>$size,
	"cnt"=>$cnt,
	"param"=>$param,
	"frname"=>$frname,
	"event_no"=>$event_no,
	"entry_count"=>$entry_count,
	"cate3"=>$cate3,
	"stat"=>$stat,
	"subject"=>$subject,
	"stat_selectall"=>$stat_selectall,
	"stat_select1"=>$stat_select1,
	"stat_select2"=>$stat_select2,
	"stat_select3"=>$stat_select3,
	"stat_select4"=>$stat_select4,
	"desc_text"=>$desc_text,
	"list"=>$list,
));
?>