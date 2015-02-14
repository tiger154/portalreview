<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $FRAME;

$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_MANAGER = &Module::singleton("Manager.Manager");


$DB = &Module::loadDb("revu");

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
$winflag				= Module::$param[10];

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


if($type !=  ""){


	$adminno = $_SESSION["userno"];

	if($type == "w"){
		$message = "당첨대기 처리";
	}else{
		$message = "당첨대기 취소처리";
	}
	$log_message = "프론티어 응모자".$message;
	$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "7001", $event_no, $userno, '', $log_message);

	if($userno != "122240" || $userno != "116249"){
		$winupdate = $CLASS_FRONTIER->frontierentry_update($DB, $event_no, $userno, $type);
	}


	$type = "";
}else{
	$type = "";
}


if($winflag == "W"){

	$adminno = $_SESSION["userno"];
	$message = "당첨처리 확정";
	$log_message = "프론티어 응모자".$message;
	$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "7001", $event_no, $userno, '', $log_message);
	$winstatupdate = $CLASS_FRONTIER->frontierentry_update2($DB, $event_no);

}

$entry_count = $CLASS_FRONTIER->AdmingetEntryListCount2($DB, $event_no, "0");
$cnt = $entry_count;
$list = $CLASS_FRONTIER->AdmingetEntryList2($DB, $event_no, $btitle, $sch_opt, $sch_con, $limit, $frname, $stat);

for($i=0;$i<sizeof($list);$i++) {
	$userno = $list[$i]['userno'];
	$list[$i]['content'] = $BASE->stripScpecial($list[$i]['content']); // 특수문자 제거
	$list[$i]['bloglist'] = $CLASS_FRONTIER->AdminEntryBlogURL($DB, $userno);
}


$subject = $CLASS_FRONTIER->frontiernameSelect($DB, $event_no);

$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";



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