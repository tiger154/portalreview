<?php
$domain			= "http://"._DOMAIN_FILE."/frontier/title_img/";
$downlink			= "http://"._DOMAIN_FILE."/frontier/rel_file/";

$b_cate_table		= "Rf_cate1_code";
$m_cate_table	= "Rf_cate2_code";
$s_cate_table		= "Rf_cate3_code";
$area1_table		= "Rf_area_bcode";		
$area2_table		= "Rf_area_mcode";		
$area3_table		= "Rf_area_scode";		

GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

$CLASS_PAGE = &Module::singleton("Page");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_CATECODE	= &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE		= &Module::singleton("Zipcode");

$DB = &Module::loadDb("revu");

$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageNum', Module::$param[1]);
$CLASS_PAGE->set('pageRow', Module::$param[2]);

$frontier_no = Module::$param[0];


$nowmonth			= date("m");
$nowday				= date("d");



$frontierData				= $CLASS_FRONTIER->FrontierView($DB, $frontier_no, $flag_delete="0", $btitle, $sch_opt, $sch_con, $stat, $frname);

$frontierCount			= $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);

$frontierOptionList		= $CLASS_FRONTIER->FrontierOption($DB, $frontier_no);



$enddate				= strtotime($frontierData['end_date']);
$remainday			= floor(($enddate - time())/86400);
$remaintime			= floor((($enddate - time())%86400)/3600);
$remain_message	= "모집마감 ".$remainday."일 ".$remaintime."시간 전";


$topimgDir				= substr($frontierData['frid'],2,4);
$topimg					= $domain.$topimgDir."/".$frontierData['titleimg'];


$category_code		= $frontierData['cate'];


$b_cate = substr($frontierData['cate'], 0,2);
$m_cate = substr($frontierData['cate'], 2,3);
$s_cate = substr($frontierData['cate'], 5,3);

$b_cate_desc = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $b_cate_table, "1");
$m_cate_desc = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $m_cate_table, "2");
$s_cate_desc = $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $s_cate_table, "3");

if($m_cate_desc == ""){
	$cate = $b_cate_desc;
}

if($m_cate_desc != "" and $b_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc;
}

if($m_cate_desc != ""  and $b_cate_desc !=  ""){
	$cate = $b_cate_desc.">".$m_cate_desc.">".$s_cate_desc;
}

if($m_cate_desc != ""  and $b_cate_desc !=  "" ||$s_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc;
}



$area_code1				= substr($frontierData['areacode'], 0,2);
$area_code2				= substr($frontierData['areacode'], 2,3);
$area_code3				= substr($frontierData['areacode'], 5,2);
$area_bcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
$area_mcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
$area_scode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");
$result_area_desc		= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc." ".$frontierData['addr'];


$reg_date				= $frontierData['regdate']; 
$subject				= $frontierData['subject'];
$frproduct				= $frontierData['frproduct'];
$peoplelimit			= $frontierData['peoplelimit'];
$bestrview_prise		= $frontierData['bestrview_prise'];
$price					= $frontierData['oprice'];
$price					= number_format($price);
$filecheck				= $frontierData['filelink'];
$map					= $frontierData['maplink'];
$addr					= $result_area_desc;
$tel						= "☎ ".$frontierData['tel'];
$mobile					= $frontierData['mobile'];
$sitelink					= $frontierData['sitelink'];
$cashpolicy			= $frontierData['cashpolicy'];
$message				= nl2br($frontierData['message']);
$mission				= nl2br($frontierData['mission']);
$keyword				= $frontierData['keyword'];
$tagword				= $frontierData['tagword'];
$tip						= nl2br($frontierData['tip']);
$bannercode_clip	= addslashes($frontierData['bannercode']);
$bannercode			= htmlspecialchars($frontierData['bannercode']);
$etype					= $frontierData['etype'];


if($mobile != ""){

	$mobile = "(Mobile : ".$mobile.")";

}


if($price != ""){
	$price = "<tr>
		  <td class='frontier_table_l gray_d_text'>- 소비자 가격</td>
		  <td class='frontier_table_r'>$price&nbsp;원</td>
		</tr>";
}

if($filecheck != ""){
	
	$downurl = $downlink.$topimgDir."/".$frontierData['filelink'];

	$filelink = "<tr>
	  <td class='frontier_table_l gray_d_text'>- 자료 다운로드</td>
	  <td class='frontier_table_r'>자료를 다운 받아 포스트 하세요.<a href='$downurl' class='w_space'><img src='/images/common/but/but_g_downlord.gif' alt='다운받기'  title='다운받기' class='imgb_space'/></a></td>
	</tr>";
}

if($addr != ""){


	if($map != ""){
			$map = "<a href='$map' target='_blank' class='w_space'><img src='/images/common/but/but_g_map.gif' alt='약도보기'  title='약도보기' class='imgb_space'/></a>";
	}

	$addr = "<tr>
              <td class='frontier_table_l gray_d_text'>- 주소</td>
              <td class='frontier_table_r'>$addr&nbsp;$map</td>
            </tr>";

}

if($sitelink != ""){

	$sitelink = "<tr>
              <td class='frontier_table_l gray_d_text'>- 홈페이지</td>
              <td class='frontier_table_r gray_stitle'><a href='$sitelink' target='_blank'>$sitelink</a></td>
            </tr>";

}


if($bannercode != ""){
	$bannercode = "<div class='frontier_detail_box'>
          <div class='frontier_detail_title'><img src='/images/frontier/title_detailview13.gif' /></div>
          <div class='pt20'></div>
          <div class='frontier_bancode_l'>$bannercode</div>
          <div class='frontier_bancode_r'><a href='javascript:common.copyClip(\"".$bannercode_clip."\",\"배너코드가 복사되었습니다.\")'><img src='/images/common/but/but_bancode.gif' alt='배너코드복사하기' title='배너코드복사하기' /></a></div>
          <div class='clear'></div>
          <div class='frontier_detail_line'><img src='/images/frontier/img_detailview_revu.gif' align='right'  style='padding-top:47px;'/></div>
        </div>
      </div>      
	  <div class='pt40'></div>";

}else{
	$bannercode = "<div class='frontier_detail_box'>
        </div>
      </div>      
	  <div class='pt40'></div>";


}




$etype = "<a href='#'><img src='/images/frontier/but_frontier_review.gif'  alt='리뷰등록하기' title='리뷰등록하기'/></a>";

$jstart_date = $frontierData['start_date'];
$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";


$jend_date = $frontierData['end_date'];
$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";
$notice_date = $frontierData['notice_date'];
$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";
$due_sdate = $frontierData['due_sdate'];
$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";
$due_edate = $frontierData['due_edate'];
$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";
$bestrview_notice_date = $frontierData['bestrview_notice_date'];
$bestrview_notice_date = substr($bestrview_notice_date,0,4)."년".number_format(substr($bestrview_notice_date,5,2))."월".number_format(substr($bestrview_notice_date,8,2))."일";


$TPL->defineTemplate("entrylayer", "frontier", "frontier.entry.layer.htm");
$TPL->setValue(array(
	"logo"=>$logo,	
	"subject"=>$subject,
	"remain_message"=>$remain_message,
	"topimg"=>$topimg,
	"cate"=>$cate,
	"frproduct"=>$frproduct,
	"jstart_date"=>$jstart_date,
	"jend_date"=>$jend_date,
	"peoplelimit"=>$peoplelimit,
	"noticedate"=>$notice_date,
	"due_sdate"=>$due_sdate,
	"due_edate"=>$due_edate,
	"bestrview_notice_date"=>$bestrview_notice_date,
	"bestrview_prise"=>$bestrview_prise,
	"price"=>$price,
	"addr"=>$addr,
	"tel"=>$tel,
	"mobile"=>$mobile,
	"sitelink"=>$sitelink,
	"filelink"=>$filelink,
	"map"=>$map,
	"frontierOptionList"=>$frontierOptionList,
	"cashpolicy"=>$cashpolicy,
	"message"=>$message,
	"mission"=>$mission,
	"keyword"=>$keyword,
	"tagword"=>$tagword,
	"tip"=>$tip,
	"bannercode"=>$bannercode,
	"etype"=>$etype,
));
?>