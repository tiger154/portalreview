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



$userno			= Module::$param[3];

$limit = $CLASS_PAGE->getLimit();

$param = array();
$param[] = $event_no;
$param[] = $entry_count;
$param[] = $title;

$module = "frontier.entrybloglist";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");


$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];




$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";


$bloglist = $CLASS_FRONTIER->AdminEntryBlogURL($DB, $userno);
	


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
	"bloglist"=>$bloglist,
));
?>