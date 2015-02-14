<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";
$b_cate_table = "Rf_cate1_code";
$m_cate_table = "Rf_cate2_code";
$s_cate_table = "Rf_cate3_code";
$f_cate_table = "Rf_cate4_code";

$CLASS_PAGE			= &Module::singleton("Page2", 0);		
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		

$DB = &Module::loadDb("revu");

$nowmonth		= date("m");
$nowday			= date("d");

$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();


$mainlist	= $CLASS_FRONTIER->EndFrontierList($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "A", $frname, $limit);

$cnt = $CLASS_FRONTIER->getEndListCount($DB, $code, $flag_delete="0", $btitle, $sch_opt, $sch_con, "A", $frname);

$size = sizeof($mainlist);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

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

	if($mainlist[$i]['m_cate'] != "" and $mainlist[$i]['c_cate'] !=  "" and $mainlist[$i]['f_cate'] ==  ""){
		$mainlist[$i]['cate'] = $mainlist[$i]['b_cate'].">".$mainlist[$i]['m_cate'].">".$mainlist[$i]['c_cate'];
	}

	if($mainlist[$i]['m_cate'] != "" and $mainlist[$i]['c_cate'] !=  "" and $mainlist[$i]['f_cate'] !=  ""){
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

	

	$mainlist[$i]['subject'] = $CLASS_BASE->strLimitUTF($mainlist[$i]['subject'], "27", "", $eStr="...");
	
	if($mainlist[$i]['frno'] > "877"){    

		$topimgDir							= substr($mainlist[$i]['frid'],2,4);
		$topimg								= $domain.$topimgDir."/".$mainlist[$i]['titleimg'];
		$mainlist[$i]['listimg']			= $topimg;
	}else{

		$oldimgname = explode("{", $mainlist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$mainlist[$i]['listimg']		= $oldlink.$oldimgname."_list.gif";

	}




	
	$accountinfo					= $CLASS_FRONTIER->FrontierReviewendlist($DB, $mainlist[$i]['frno'], "1");
	for($d=0;$d<sizeof($accountinfo);$d++) {
			$rno = $accountinfo[$d]['rno'];				
			$userno = $accountinfo[$d]['userno'];  
			$mainlist[$i]['review_nickname']				= $CLASS_FRONTIER->ReviewUserNickname($DB, $userno); 
			$reveiw_content										= $CLASS_FRONTIER->ReviewContentData($DB, $rno);		

			$mainlist[$i]['content'] = $reveiw_content;
			$mainlist[$i]['rno'] = $rno;
			$mainlist[$i]['userno'] = $userno;

			if($mainlist[$i]['review_nickname'] == ""){
				$mainlist[$i]['view'] = "N";
			}else{
				$mainlist[$i]['view'] = "Y";
				
			}

			

	}
	$mainlist[$i]['reviewcnt'] = $CLASS_FRONTIER->FrontierReviewCnt($DB, $mainlist[$i]['frno']);


	
}

$TPL->setValue(array(
	"logo"=>$logo,	
	"mainlist"=>$mainlist,
	"nowmonth"=>$nowmonth,
	"nowday"=>$nowday,
	"link"=>$link,
	"size"=>$size,
	"cssblank"=>$cssblank,
	"review_nickname"=>$review_nickname,
	"reviewData"=>$reviewData,
	"userno"=>$userno,
	"rno"=>$rno,

));
?>