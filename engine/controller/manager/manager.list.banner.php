<?php
/***************************************************************************************
* Module Name			:	관리자 - 프론티어 목록페이지
* Created Date			:	2011.07.25
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
$CLASS_PAGE = &Module::singleton("Page");
$CLASS_MANAGER = &Module::singleton("Manager.Manager");

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


$btype = Module::$param[3];
$campaign = urldecode(Module::$param[4]);
$spon = urldecode(Module::$param[5]);
$stat = Module::$param[6];
$flag = Module::$param[7];
if($flag == "D"){
	
	$banner_no = Module::$param[6];
	$bannerdel = $CLASS_MANAGER->BannerDel($DB, $banner_no);

	echo "
	<script>
		alert('배너가 삭제처리 되었습니다');
	</script>
	";	  
	$flag = "";
}


$param = array();
$param[] = $btype;
$param[] = $linktype;
$param[] = $campaign;
$param[] = $spon;
$param[] = $stat;



//페이지관련 
$module = "list.banner";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");

$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];


$limit = "Limit ".($page - 1) * $page_row.",".$page_row;
$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

// 게시물카운트
$cnt = $CLASS_MANAGER->BannerListCnt($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, $btype, $campaign);

$CLASS_PAGE->set('totalRowCount', $cnt);

// 게시물리스트
$list = $CLASS_MANAGER->BannerListSelect($DB, $code, $btitle, $sch_opt, $sch_con, $CLASS_PAGE->getLimit(), $btype, $campaign);


for($i=0;$i<sizeof($list);$i++) {

	$today = date("YmdHis");
	$today = strtotime($today);
	
	$j = $i+1;
	$list[$i]['idx'] = $j;
	

	if($list[$i]['btype'] == "M"){
		$list[$i]['btype_desc'] = "<font color=#990066>메인배너</font>";
	}else{
		$list[$i]['btype_desc']= "<font color=#336633>우측배너</font>";
	}

	if($list[$i]['linktype'] == "T"){
		$list[$i]['linktype_desc'] = "<img src='/images/admin/tree_icon04.gif'>&nbsp;<font color=#FF6633>새창</font>";
	}else{
		$list[$i]['linktype_desc']= "<img src='/images/admin/tree_icon07.gif'>&nbsp;<font color=#FF6633>현재창</font>";
	}

	//배너순서 설정


}


//selected 처리
if($stat == "M"){
	$stat_select1 = "selected";
}else if($stat == "L"){
	$stat_select4 = "selected";
}else{
	$stat_selectall = "selected";
}


// 페이지생성
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
$link = $CLASS_PAGE->getLinkFrontier();




$TPL->setValue(array(
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"param"=>$param,
	"btype"=>$btype,
	"linktype"=>$linktype,
	"campaign"=>$campaign,
	"spon"=>$spon,
	"btype_desc"=>$btype_desc,
	"linktype_desc"=>$linktype_desc,
	"stat"=>$stat,
	"imgdir"=>$imgdir,

));
?>