<?php
/***************************************************************************************
* Module Name			:	프론티어 목록(메인) 
* Created Date			:	2011.09.19
* Created by				:	RevU 박상선 
* Modify History			:   
 ***************************************************************************************/ 

//===============================================================
//GLOBAL CLASS
//===============================================================
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

//===============================================================
//GLOBAL VARS
//===============================================================
//GLOBAL $FRAME;

$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

$b_cate_table = "Rf_cate1_code";
$m_cate_table = "Rf_cate2_code";
$s_cate_table = "Rf_cate3_code";
$f_cate_table = "Rf_cate4_code";
$area1_table		= "Rf_area_bcode";		//대분류 지역코드
$area2_table		= "Rf_area_mcode";		//중분류 지역코드
$area3_table		= "Rf_area_scode";		//소분류 지역코드

//===============================================================
// EXTEND_CLASS
//===============================================================
$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		


//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");



$nowmonth		= date("m");
$nowday			= date("d");


// 게시물 셀렉팅
// 썸네일 프로모션 프론티어
$toplist		= $CLASS_FRONTIER->FrontierListSelectT($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname, "T"); //A:리뷰중, B:모집중, C: 당첨자선정중, D:종료
// 일반 프론티어
$mainlist	= $CLASS_FRONTIER->FrontierListSelectM($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "B", $frname);


// 모집중 카운팅

$frontierCount = $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);



for($i=0;$i<sizeof($toplist);$i++) {


	$reg_date = $toplist[$i]['regdate']; 


	//카테고리코드별 카테고리명 셋팅
	$b_cate = substr($toplist[$i]['cate'], 0,2);
	$m_cate = substr($toplist[$i]['cate'], 2,3);
	$s_cate = substr($toplist[$i]['cate'], 5,3);
	$f_cate = substr($toplist[$i]['cate'], 8,3);


	$toplist[$i]['b_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $b_cate_table, "1");
	$toplist[$i]['m_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $m_cate_table, "2");
	$toplist[$i]['c_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $s_cate_table, "3");
	$toplist[$i]['f_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $f_cate_table, "4");
	
	if($toplist[$i]['m_cate'] == ""){
		$toplist[$i]['cate'] = $toplist[$i]['b_cate'];
	}

	if($toplist[$i]['m_cate'] != "" and $toplist[$i]['c_cate'] ==  ""){
		$toplist[$i]['cate'] = $toplist[$i]['b_cate'].">".$toplist[$i]['m_cate'];
	}

	if($toplist[$i]['m_cate'] != ""  and $toplist[$i]['c_cate'] !=  "" and $toplist[$i]['f_cate'] ==  ""){
		$toplist[$i]['cate'] = $toplist[$i]['b_cate'].">".$toplist[$i]['m_cate'].">".$toplist[$i]['c_cate'];
	}


	if($toplist[$i]['m_cate'] != ""  and $toplist[$i]['c_cate'] !=  "" and $toplist[$i]['f_cate'] !=  ""){
		$toplist[$i]['cate'] = $toplist[$i]['b_cate'].">".$toplist[$i]['m_cate'].">".$toplist[$i]['c_cate'].">".$toplist[$i]['f_cate'];
	}


	//모집기간 시작일 합체조립
	$jstart_date = $toplist[$i]['start_date'];
	$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";
	$toplist[$i]['start_date'] = $jstart_date;

	//모집기간 종료일 합체조립
	$jend_date = $toplist[$i]['end_date'];
	$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";
	$toplist[$i]['end_date'] = $jend_date;

	//당첨자 발표일 합체조립
	$notice_date = $toplist[$i]['notice_date'];
	$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";
	$toplist[$i]['notice_date'] = $notice_date;

	//리뷰작성 시작일 합체조립
	$due_sdate = $toplist[$i]['due_sdate'];
	$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";
	$toplist[$i]['due_sdate'] = $due_sdate;

	//리뷰작성 종료일 합체조립
	$due_edate = $toplist[$i]['due_edate'];
	$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";
	$toplist[$i]['due_edate'] = $due_edate;


	$cssblank = "N";
	//이미지 찾기

	//상단 프론티어 리스트 이미지 
	if($toplist[$i]['frno'] > "877"){    //신규이미지 경로
		$topimgDir							= substr($toplist[$i]['frid'],2,4);
		$topimg								= $domain.$topimgDir."/".$toplist[$i]['titleimg'];
		$toplist[$i]['toplistimg']		= $topimg;
	}else{ //구이미지 경로

		$oldimgname = explode("{", $toplist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$toplist[$i]['toplistimg']		= $oldlink.$oldimgname."_list.gif";
	}


	//지역코드로 주소 셋팅
	$area_code1					= substr($toplist[$i]['areacode'], 0,2);
	$area_code2					= substr($toplist[$i]['areacode'], 2,3);
	$area_code3					= substr($toplist[$i]['areacode'], 5,2);
	$area_bcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
	$area_mcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
	$area_scode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");
	$result_area_desc			= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc;
	$toplist[$i]['address']	= trim($result_area_desc);
	

	$toplist[$i]['subject'] = $CLASS_BASE->strLimitUTF($toplist[$i]['subject'], "48", "", $eStr="...");
	$toplist[$i]['frproduct'] = $CLASS_BASE->strLimitUTF($toplist[$i]['frproduct'], "24", "", $eStr="...");


}

if($cssblank == "")$cssblank = "Y";



//일반 프론티어 리스트 
for($i=0;$i<sizeof($mainlist);$i++) {



	$reg_date = $mainlist[$i]['regdate']; 



	//카테고리코드별 카테고리명 셋팅
	$b_cate = substr($mainlist[$i]['cate'], 0,2);
	$m_cate = substr($mainlist[$i]['cate'], 2,3);
	$s_cate = substr($mainlist[$i]['cate'], 5,3);
	$f_cate = substr($mainlist[$i]['cate'], 8,3);


	$mainlist[$i]['b_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $b_cate_table, "1");
	$mainlist[$i]['m_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $m_cate_table, "2");
	$mainlist[$i]['c_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $s_cate_table, "3");
	$mainlist[$i]['f_cate'] = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $f_cate_table, "4");
	
	if($mainlist[$i]['m_cate'] == ""){
		$mainlist[$i]['cate'] = $mainlist[$i]['b_cate'];
	}

	if($mainlist[$i]['m_cate'] != "" and $mainlist[$i]['c_cate'] ==  ""){
		$mainlist[$i]['cate'] = $mainlist[$i]['b_cate'].">".$mainlist[$i]['m_cate'];
	}

	if($mainlist[$i]['m_cate'] != ""  and $mainlist[$i]['c_cate'] !=  "" and $mainlist[$i]['f_cate'] ==  ""){
		$mainlist[$i]['cate'] = $mainlist[$i]['b_cate'].">".$mainlist[$i]['m_cate'].">".$mainlist[$i]['c_cate'];
	}

	if($mainlist[$i]['m_cate'] != ""  and $mainlist[$i]['c_cate'] !=  "" and $mainlist[$i]['f_cate'] !=  ""){
		$mainlist[$i]['cate'] = $mainlist[$i]['b_cate'].">".$mainlist[$i]['m_cate'].">".$mainlist[$i]['c_cate'].">".$mainlist[$i]['f_cate'];
	}


	//모집기간 시작일 합체조립
	$jstart_date = $mainlist[$i]['start_date'];
	$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";
	$mainlist[$i]['start_date'] = $jstart_date;

	//모집기간 종료일 합체조립
	$jend_date = $mainlist[$i]['end_date'];
	$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";
	$mainlist[$i]['end_date'] = $jend_date;

	//당첨자 발표일 합체조립
	$notice_date = $mainlist[$i]['notice_date'];
	$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";
	$mainlist[$i]['notice_date'] = $notice_date;

	//리뷰작성 시작일 합체조립
	$due_sdate = $mainlist[$i]['due_sdate'];
	$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";
	$mainlist[$i]['due_sdate'] = $due_sdate;

	//리뷰작성 종료일 합체조립
	$due_edate = $mainlist[$i]['due_edate'];
	$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";
	$mainlist[$i]['due_edate'] = $due_edate;

	//일반 프론티어 리스트 이미지 
	if($mainlist[$i]['frno'] > "877"){    //신규이미지 경로

		$mainimgDir							= substr($mainlist[$i]['frid'],2,4);
		$mainlistimg							= $domain.$mainimgDir."/".$mainlist[$i]['titleimg'];
		$mainlist[$i]['mainlistimg']		= $mainlistimg;
	}else{ //구이미지 경로

		$oldimgname = explode("{", $mainlist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$mainlist[$i]['mainlistimg']		= $oldlink.$oldimgname."_list.gif";
	}
	
	
	$mainlist[$i]['subject']			= $CLASS_BASE->strLimitUTF($mainlist[$i]['subject'], "40", "", $eStr="...");

	//echo "mainlistimg:$mainlistimg";
}


//$sql = "SELECT * FROM test LIMIT 0, 10";
//$aa = $DB->fetch($sql);

//===============================================================
// VARS
//===============================================================


//===============================================================
//TEMPLATE VARS
//===============================================================
$TPL->setValue(array(
	"logo"=>$logo,	
	"toplist"=>$toplist,
	"mainlist"=>$mainlist,
	"nowmonth"=>$nowmonth,
	"nowday"=>$nowday,
	"frontierCount"=>$frontierCount,
	"cssblank"=>$cssblank,
));
?>