<?php
/***************************************************************************************
* Module Name			:	관리자 - cp 파일 다운 목록페이지
* Created Date			:	2011.10.27
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
$CLASS_BASE			= &Module::singleton("Base");		
$CLASS_MANAGER	= &Module::singleton("Manager.Manager");
$CLASS_FTP				= &Module::singleton("Ftp");
$CLASS_FILE				= &Module::singleton("File");

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

/*
$cate1 = Module::$param[3];
$cate2 = Module::$param[4];
$cate3 = Module::$param[5];
$cate4 = Module::$param[6];
$stat = Module::$param[7];

$frname = urldecode(Module::$param[8]);


$param = array();
$param[] = $cate1;
$param[] = $cate2;
$param[] = $cate3;
$param[] = $stat;
$param[] = $frname;

$limit = $CLASS_PAGE->getLimit();
*/

$type = Module::$param[0];

//다운링크
if($type == "d"){

	$no = Module::$param[1];


	$file_name = $CLASS_MANAGER->AfileSelect($DB, $no);
	for($i=0;$i<sizeof($file_name);$i++) {
		$ftpfile	= $file_name[$i]['file'];
	}

	$dir1 = _FTP_CP;	
	$CLASS_FTP->connect("file");

	$url = "http://"._DOMAIN_FILE."/partner";

	$down = $CLASS_FILE->download2($ftpfile, $ftpfile, $url);



	$CLASS_FTP->close(); //스토리지 서버  ftp 디스컨넥팅

}

$module = "cp.file";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");


/*
$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];
*/

//$limit = "Limit ".($page - 1) * $page_row.",".$page_row;
$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

// 게시물카운트
$cnt = $CLASS_MANAGER->AfileCount($DB);

$CLASS_PAGE->set('totalRowCount', $cnt);

// 게시물리스트
$list = $CLASS_MANAGER->AfileList($DB);




//접속시간 셋팅
$nowtime = date("Y")."/".date("m")."/".date("d")." ".date("H").":".date("i").":".date("s");


/*
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";
*/

$TPL->setValue(array(
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"size"=>$size,
	"param"=>$param,
	"nowtime"=>$nowtime,

));
?>