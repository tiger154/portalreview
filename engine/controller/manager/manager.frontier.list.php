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
$CLASS_PAGE			= &Module::singleton("Page");

$CLASS_PAGE			= &Module::singleton("Page2", 0);		

$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		
$CLASS_MANAGER	= &Module::singleton("manager.manager");

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
$flag = Module::$param[2];

if($flag == "D"){

		$del_frno = Module::$param[1];

		$adminno = $_SESSION["userno"];
		$message = "프론티어 삭제처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $del_frno, "", "", $log_message);

		$result		= $CLASS_MANAGER->adminfrontierdel($DB, $del_frno);

		if($result == true) {
			Module::alert("프론티어가 삭제처리 되었습니다.");
		} else {
		    Module::alert("오류");
		}
		
		Module::redirectModule("/mng.revu.co.kr/manager/frontier.list");
		break;


}else{

	$CLASS_PAGE->set('page', Module::$param[0]);
	$CLASS_PAGE->set('pageNum', Module::$param[1]);
	$CLASS_PAGE->set('pageRow', Module::$param[2]);


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
}



$limit = $CLASS_PAGE->getLimit();

$module = "frontier.list";
$INI_BOARD = &Module::loadConf(_DIR_CONF."/".$module.".ini");

$code = (!empty($_GET['code'])) ? $_GET['code'] : $INI_BOARD['CODE'];
$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$page_num = (!empty($_GET['page_num'])) ? $_GET['page_num'] : $INI_BOARD['PAGE_NUM'];
$page_row = (!empty($_GET['page_row'])) ? $_GET['page_row'] : $INI_BOARD['PAGE_ROW'];


//$limit = "Limit ".($page - 1) * $page_row.",".$page_row;
$sch_opt = (!empty($_GET['sch_opt'])) ? $_GET['sch_opt'] : "";
$sch_con = (!empty($_GET['sch_con'])) ? $_GET['sch_con'] : "";

// 게시물카운트
$cnt = $CLASS_FRONTIER->AdmingetListCount($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, $stat, $frname);

$CLASS_PAGE->set('totalRowCount', $cnt);

// 게시물리스트
$list = $CLASS_FRONTIER->AdmingetList($DB, $code, $btitle, $sch_opt, $sch_con, $CLASS_PAGE->getLimit(), $stat, $frname);


//카테고리 관련 정보
$table_name		= "Rf_cate1_code"; //1차 카테고리 테이블 명
$cate1_list = $CLASS_FRONTIER->getCate1List($DB);


for($i=0;$i<sizeof($list);$i++) {

	$today = date("YmdHis");
	$today = strtotime($today);

	
	
	//모집기간, 당첨자선정일, 리뷰등록기간을 판단하여 프론티어 상태값 셋팅
	if(strtotime($list[$i]['start_date']) < $today and $today < strtotime($list[$i]['end_date'])){

			$list[$i]['fronstat']= "<font color=#336633><img src='/images/admin/but_admin_step1.gif'></font>"; //모집중

	}else if(strtotime($list[$i]['end_date']) < $today){

			if(strtotime($list[$i]['notice_date']) > $today){
				$list[$i]['fronstat'] = "<font color=#996600><img src='/images/admin/but_admin_step2.gif'></font>"; //당첨자 선정중
			}else if(strtotime($list[$i]['due_edate']) < $today){
				$list[$i]['fronstat']= "<font color=#FF0000><img src='/images/admin/but_admin_step4.gif'></font>"; //종료
			}else{
				$list[$i]['fronstat']= "<font color=#6633FF><img src='/images/admin/but_admin_step3.gif'></font>"; //리뷰중
			}

	}else{
		
		$list[$i]['fronstat'] = "<font color=#FF0000><img src='/images/admin/but_admin_step4.gif'></font>"; //종료

	}

	//응모자수 없을때 -태크 삽입
	if($list[$i]['entry_count'] == ""){
		$list[$i]['entry_count'] = "-";
	}

	//카테고리코드별 카테고리명 셋팅
	$b_cate = substr($list[$i]['cate'], 0,2);
	$m_cate = substr($list[$i]['cate'], 2,3);
	$s_cate = substr($list[$i]['cate'], 5,3);
	$ss_cate = substr($list[$i]['cate'], 8,3);

	$b_cate_table = "Rf_cate1_code";		//1차 카테고리
	$m_cate_table = "Rf_cate2_code";	//2차 카테고리
	$s_cate_table = "Rf_cate3_code";		//3차 카테고리
	$ss_cate_table = "Rf_cate4_code";   //4차 카테고리


	$list[$i]['b_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $ss_cate, $b_cate_table, "1");
	$list[$i]['m_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $ss_cate, $m_cate_table, "2");
	$list[$i]['c_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $ss_cate, $s_cate_table, "3");
	$list[$i]['s_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $ss_cate, $ss_cate_table, "4");
	
	if($list[$i]['m_cate'] == ""){
		$list[$i]['cate'] = $list[$i]['b_cate'];
	}

	if($list[$i]['m_cate'] != "" and $list[$i]['c_cate'] ==  ""){
		$list[$i]['cate'] = $list[$i]['b_cate']."/".$list[$i]['m_cate'];
	}

	if($list[$i]['m_cate'] != ""  and $list[$i]['c_cate'] !=  ""){
		$list[$i]['cate'] = $list[$i]['b_cate']."/".$list[$i]['m_cate']."/".$list[$i]['c_cate'];
	}

	if($list[$i]['m_cate'] != ""  and $list[$i]['c_cate'] !=  "" and $list[$i]['s_cate'] !=  ""){
		$list[$i]['cate'] = $list[$i]['b_cate']."/".$list[$i]['m_cate']."/".$list[$i]['c_cate']."/".$list[$i]['s_cate'];
	}

	if($list[$i]['maindisplay'] == "1"){
		$list[$i]['maindisplay'] = "<b><a href='javascript:frontierMaindisplay(\"".$list[$i]['frno']."\", \"\");'><font color=red><img src='/images/admin/ico_admin_y.gif'></a></b>"; //롤링 Y
	}else{
		$list[$i]['maindisplay'] = "<a href='javascript:frontierMaindisplay(\"".$list[$i]['frno']."\", \"1\");'><img src='/images/admin/ico_admin_n.gif'></a>"; //롤링N
	}

	$list[$i]['subject'] = $CLASS_BASE->strLimitUTF($list[$i]['subject'], "30", "", $eStr="...");

}


/*
for($i=0;$i<sizeof($list);$i++) {
	$list[$i]['newIcon'] = $CLASS_BOARD->newIcon(substr($list[$i]['regdate'],0,10),$INI_BOARD['NEWICON']);
	list($list[$i]['register_date'], $list[$i]['register_time']) = explode(' ', $list[$i]['regdate']);
	$list[$i]['register_date'] = str_replace('-','.', $list[$i]['register_date']);
}
*/

// 페이지생성
//$CLASS_PAGE->pageLink($page_num, $page, $cnt, $page_row, &$prevPageLink, &$nextPageLink, &$lastPageLink, &$pageLink, &$lastPage,	&$backLink, &$forwardLink, $search="search", $module);


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

//selected 처리
if($stat == "A"){
	$stat_select1 = "selected";
}else if($stat == "B"){
	$stat_select2 = "selected";
}else if($stat == "C"){
	$stat_select3 = "selected";
}else if($stat == "D"){
	$stat_select4 = "selected";
}else{
	$stat_selectall = "selected";
}



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