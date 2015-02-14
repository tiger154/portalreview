<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $FRAME;
$FRAME = "popup";

$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

$DB = &Module::loadDb("revu");


$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageNum', Module::$param[1]);
$CLASS_PAGE->set('pageRow', Module::$param[2]);
$CLASS_BASE			= &Module::singleton("Base");		

$frno			= Module::$param[3];
$param = array();
$param[] = $frno;

$module = "frontier.entrywinner.layer";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");

$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;

$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];

$limit = "Limit ".($page - 1) * $page_row.",".$page_row;

$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";


$entry_count = $CLASS_FRONTIER->getEntryListCount($DB, $frno, "1");
$cnt = $entry_count;
$CLASS_PAGE->set('totalRowCount', $cnt);



$list = $CLASS_FRONTIER->getEntryWinnerList2($DB, $frno, $CLASS_PAGE->getLimit(), "1");



$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
$link = $CLASS_PAGE->getLinkFrontier();



for($i=0;$i<sizeof($list);$i++) {

	
	$subject = $CLASS_BASE->strLimitUTF($list[$i]['subject'], "27", "", $eStr="...");

	$bannercode = $list[$i]['bannercode']; 
	$_bannercode = addslashes($bannercode);
	$bannercode = htmlspecialchars($bannercode);


	if($bannercode != ""){
		$codecopy = "<a href='javascript:copyHtml(\"".$_bannercode."\")'><img src='/images/common/but/but_g_bancode.gif' alt='배너코드복사' title='배너코드복사' /></a>";
	}


}





$TPL->setValue(array(
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"list"=>$list,
	"cnt"=>$cnt,
	"link"=>$link,
	"param"=>$param,
	"title"=>$title,
	"event_no"=>$event_no,
	"entry_count"=>$entry_count,
	"stat"=>$stat,
	"subject"=>$subject,
	"bannercode"=>$bannercode,
	"codecopy"=>$codecopy,

));
?>