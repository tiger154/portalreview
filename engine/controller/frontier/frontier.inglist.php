<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;
$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$defaltimg			= "http://"._DOMAIN."/images/common/noimage.gif";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

$b_cate_table = "Rf_cate1_code";
$m_cate_table = "Rf_cate2_code";
$s_cate_table = "Rf_cate3_code";
$f_cate_table  = "Rf_cate4_code";
$area1_table		= "Rf_area_bcode";		
$area2_table		= "Rf_area_mcode";		
$area3_table		= "Rf_area_scode";		



$CLASS_PAGE = &Module::singleton("Page2", 0);		
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		

$DB = &Module::loadDb("revu");



$nowmonth		= date("m");
$nowday			= date("d");

$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();

$toplist		= $CLASS_FRONTIER->FrontierListSelectT($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "A", $frname, "T");

$mainlist	= $CLASS_FRONTIER->FrontierListSelectM($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "A", $frname, $limit);




$cnt = $CLASS_FRONTIER->getFringListCount($DB, $code, $flag_delete='0', $btitle, $sch_opt, $sch_con, "A", $frname);


$size = sizeof($mainlist);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0;$i<sizeof($toplist);$i++) {



	$reg_date = $toplist[$i]['regdate']; 



	
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
	
	$jstart_date = $toplist[$i]['start_date'];
	$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";
	$toplist[$i]['start_date'] = $jstart_date;

	
	$jend_date = $toplist[$i]['end_date'];
	$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";
	$toplist[$i]['end_date'] = $jend_date;

	
	$notice_date = $toplist[$i]['notice_date'];
	$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";
	$toplist[$i]['notice_date'] = $notice_date;

	
	$due_sdate = $toplist[$i]['due_sdate'];
	$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";
	$toplist[$i]['due_sdate'] = $due_sdate;

	
	$due_edate = $toplist[$i]['due_edate'];
	$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";
	$toplist[$i]['due_edate'] = $due_edate;

	$cssblank = "N";
	
	if($toplist[$i]['frno'] > "877"){    

		$topimgDir							= substr($toplist[$i]['frid'],2,4);
		$topimg								= $domain.$topimgDir."/".$toplist[$i]['titleimg'];
		$toplist[$i]['toplistimg']			= $topimg;
	}else{

		$oldimgname = explode("{", $toplist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$toplist[$i]['toplistimg']		= $oldlink.$oldimgname."_list.gif";

	}

	$wincnt =  $CLASS_FRONTIER->WinnerCheck($DB, $toplist[$i]['frno']);

	if($wincnt  > 0){
		$winnerbutton = "<a href='javascript:entrypopup(\"".$toplist[$i]['frno']."\");'><img src='/images/common/but/but_g_winner.gif' align='right' alt='당첨자보기' title='당첨자보기'/></a>";
		$toplist[$i]['winnerbutton'] = $winnerbutton; 

	}


	$area_code1					= substr($toplist[$i]['areacode'], 0,2);
	$area_code2					= substr($toplist[$i]['areacode'], 2,3);
	$area_code3					= substr($toplist[$i]['areacode'], 5,2);
	$area_bcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
	$area_mcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
	$area_scode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");
	$result_area_desc			= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc;
	$toplist[$i]['address']	= trim($result_area_desc);
	


	$toplist[$i]['subject'] = $CLASS_BASE->strLimitUTF($toplist[$i]['subject'], "34", "", $eStr="...");
	$toplist[$i]['frproduct'] = $CLASS_BASE->strLimitUTF($toplist[$i]['frproduct'], "18", "", $eStr="...");

}

if($cssblank == "")$cssblank = "Y";






for($i=0;$i<sizeof($mainlist);$i++) {

	$reg_date = $mainlist[$i]['regdate']; 
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

	$jstart_date = $mainlist[$i]['start_date'];
	$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";
	$mainlist[$i]['start_date'] = $jstart_date;
	$jend_date = $mainlist[$i]['end_date'];
	$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";
	$mainlist[$i]['end_date'] = $jend_date;
	$notice_date = $mainlist[$i]['notice_date'];
	$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";
	$mainlist[$i]['notice_date'] = $notice_date;
	$due_sdate = $mainlist[$i]['due_sdate'];
	$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";
	$mainlist[$i]['due_sdate'] = $due_sdate;
	$due_edate = $mainlist[$i]['due_edate'];
	$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";
	$mainlist[$i]['due_edate'] = $due_edate;


	if($mainlist[$i]['frno'] > "877"){ 


		$topimgDir							= substr($mainlist[$i]['frid'],2,4);
		$topimg								= $domain.$topimgDir."/".$mainlist[$i]['titleimg'];
		if($mainlist[$i]['titleimg'] == ""){
			$mainlist[$i]['mainlistimg'] = $defaltimg;
		}else{
			$mainlist[$i]['mainlistimg']	= $topimg;
		}
		
	}else{

		$oldimgname = explode("{", $mainlist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$mainlist[$i]['mainlistimg']		= $oldlink.$oldimgname."_list.gif";

	}

	$wincnt2 =  $CLASS_FRONTIER->WinnerCheck($DB, $mainlist[$i]['frno']);

	if($wincnt2  > 0 ){
		
		$winnerbutton = "<a href='javascript:entrypopup(\"".$mainlist[$i]['frno']."\");'><img src='/images/common/but/but_g_winner.gif' align='right' alt='당첨자보기' title='당첨자보기'/></a>";
		$mainlist[$i]['winnerbutton'] = $winnerbutton; 
	}

	$area_code1					= substr($mainlist[$i]['areacode'], 0,2);
	$area_code2					= substr($mainlist[$i]['areacode'], 2,3);
	$area_code3					= substr($mainlist[$i]['areacode'], 5,2);
	$area_bcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
	$area_mcode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
	$area_scode_desc			= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");
	$result_area_desc			= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc;
	$mainlist[$i]['address']	= trim($result_area_desc);
	$mainlist[$i]['subject'] = $CLASS_BASE->strLimitUTF($mainlist[$i]['subject'], "34", "", $eStr="...");
	$mainlist[$i]['frproduct'] = $CLASS_BASE->strLimitUTF($mainlist[$i]['frproduct'], "18", "", $eStr="...");


}


$TPL->defineTemplate("entrylayer", "frontier", "frontier.entrywinner.layer.htm");
$TPL->setValue(array(
	"logo"=>$logo,	
	"toplist"=>$toplist,
	"mainlist"=>$mainlist,
	"nowmonth"=>$nowmonth,
	"nowday"=>$nowday,
	"link"=>$link,
	"size"=>$size,
	"cssblank"=>$cssblank,

));
?>