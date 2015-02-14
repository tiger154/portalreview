<?php
/***************************************************************************************
* Module Name			:	프론티어 수정페이지
* Created Date			:	2011.12.02
* Created by				:	RevU 박상선 
* Modify History			:   
 ***************************************************************************************/ 

//하드코딩 : 나중에 옮김
$domain			= "http://"._DOMAIN_FILE."/frontier/title_img/";
$downlink			= "http://"._DOMAIN_FILE."/frontier/rel_file/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

$b_cate_table		= "Rf_cate1_code";		//대분류 카테고리 테이블
$m_cate_table	= "Rf_cate2_code";		// 중분류 카테고리 테이블
$s_cate_table		= "Rf_cate3_code";		//소분류 카테고리 테이블
$f_cate_table		= "Rf_cate4_code";		//최소분류 카테고리 테이블
$area1_table		= "Rf_area_bcode";		//대분류 지역코드
$area2_table		= "Rf_area_mcode";		//중분류 지역코드
$area3_table		= "Rf_area_scode";		//소분류 지역코드

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



//===============================================================
// EXTEND_CLASS
//===============================================================
//$CLASS_PAGE			= &Module::singleton("Page");
$CLASS_PAGE			= &Module::singleton("Page2", 0);		
$CLASS_PAGE2			= &Module::singleton("Page3", 3);		
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_CATECODE	= &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE		= &Module::singleton("Zipcode");
$CLASS_USER			= &Module::singleton("User.User");
$CLASS_BASE			= &Module::singleton("Base");		




//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");

$frontier_no = Module::$param[1];
$frtype		  = Module::$param[2];




$nowmonth			= date("m");
$nowday				= date("d");

// 프론티어 상세보기 셀렉팅
$frontierData					= $CLASS_FRONTIER->AdminFrontierView($DB, $frontier_no, $flag_delete="0", $btitle, $sch_opt, $sch_con, $stat, $frname);
// 옵션 셀렉팅
$frontierOptionList			= $CLASS_FRONTIER->FrontierOption($DB, $frontier_no);


$nowyear			= date("Y");
$nowmonth		= date("m");
$nowday			= date("d");

$startyear			= array();
$startmonth		= array();
$startday			= array();
$startnowtime	= array();

$endyear			= array();
$endmonth		= array();
$endday			= array();
$endnowtime		= array();


for($i=$nowyear; $i<=2020; $i++) {
	$startyear[]		= $i;
	$endyear[]		= $i;
}

for($i=1; $i<=12; $i++) {
	$startmonth[]	= $i;
	$endmonth[]		= $i;
}

for($i=1; $i<=31; $i++) {
	$startday[]		= $i;
	$endday[]			= $i;
}

for($i=1; $i<=24; $i++) {
	$starttime[]		= $i;
	$endtime[]		= $i;
}



//모집마감일 만들기
$enddate				= strtotime($frontierData['end_date']);
$remainday			= floor(($enddate - time())/86400);

	

if($enddate > time()){
	$remaintime			= floor((($enddate - time())%86400)/3600);
	$remain_message	= "<font color=#FFFF00>[모집마감 ".$remainday."일 ".$remaintime."시간 전]</font>";
}else{
	$remain_message = "<font color=#FFFF00>[모집마감]</font>";
}

//상단 프론티어 이미지 
if($frontierData['frno'] > "877"){    //신규이미지 경로

	$topimgDir				= substr($frontierData['frid'],2,4);
	$topimg					= $domain.$topimgDir."/".$frontierData['titleimg'];
}else{

	$oldimgname = explode("{", $frontierData['frid']);
	$oldimgname = explode("}", $oldimgname[1]);
	$oldimgname = $oldimgname[0];
	$topimg	= $oldlink.$oldimgname.".jpg";
}


$category_code		= $frontierData['cate'];
$frid						= $frontierData['frid'];
//카테고리코드별 카테고리명 셋팅
$b_cate						= substr($frontierData['cate'], 0,2);
$m_cate					= substr($frontierData['cate'], 2,3);
$s_cate						= substr($frontierData['cate'], 5,3);
$f_cate						= substr($frontierData['cate'], 8,3);
$b_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $b_cate_table, "1");
$m_cate_desc			= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $m_cate_table, "2");
$s_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $s_cate_table, "3");
$f_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $f_cate_table, "4");

//- 카테고리코드별 카테고리명 셋팅
if($m_cate_desc == ""){
	$cate = $b_cate_desc;
}
if($b_cate_desc != "" and $m_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc;
}
if($m_cate_desc != ""  and $b_cate_desc !=  ""){
	$cate = $b_cate_desc.">".$m_cate_desc.">".$s_cate_desc;
}
if($m_cate_desc != ""  and $b_cate_desc !=  "" and$s_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc;
}
if($m_cate_desc != ""  and $b_cate_desc !=  "" and $s_cate_desc ==  "" and $f_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc;
}
if($m_cate_desc != ""  and $b_cate_desc !=  "" and $s_cate_desc !=  "" and $f_cate_desc ==  ""){
	$cate = $b_cate_desc.">".$m_cate_desc.">".$s_cate_desc;
}
if($m_cate_desc != ""  and $b_cate_desc !=  "" and $s_cate_desc !=  "" and $f_cate_desc !=  ""){
	$cate = $b_cate_desc.">".$m_cate_desc.">".$s_cate_desc.">".$s_cate_desc;
}
//- 카테고리코드별 카테고리명 셋팅-끝


//지역코드로 지역정보 셋팅
$area_code1				= substr($frontierData['areacode'], 0,2);
$area_code2				= substr($frontierData['areacode'], 2,3);
$area_code3				= substr($frontierData['areacode'], 5,2);

$area_bcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
$area_mcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
$area_scode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");

$result_area_desc		= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc." ".$frontierData['addr'];

//데이타 정렬
$reg_date				= $frontierData['regdate']; 
$subject				= $frontierData['subject'];
//$subject				= $CLASS_BASE->strLimitUTF($subject, "40", "", $eStr="...");
//$subject2				= $CLASS_BASE->strLimitUTF($subject, "26", "", $eStr="...");


$frproduct				= $frontierData['frproduct'];
$peoplelimit			= $frontierData['peoplelimit'];
$bestrview_prise		= $frontierData['bestrview_prise'];
$price					= $frontierData['oprice'];

$filecheck				= $frontierData['filelink'];
$map					= $frontierData['maplink'];
$address				= trim($result_area_desc);
$tel						= $frontierData['tel'];
$telcheck				= substr($tel, 4,1);
if($telcheck == ""){
	$telcheck = "F";
}

$mobile					= $frontierData['mobile'];

$mobilecheck	= substr($mobile, 6,1);
if($mobilecheck == ""){
	$mobilecheck = "F";
}

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
$ctype					= $frontierData['partner'];
$thumb					= $frontierData['thumbstyle'];


//echo "etype:$etype<br>";
//타입 선택값 
if($etype == "A"){
	$etypecheck1 = "checked";
	$etypecheck2 = "";
}else{
	$etypecheck1 = "";
	$etypecheck2 = "checked";
}
//echo "etypecheck1:$etypecheck1<br>";
//echo "etypecheck2:$etypecheck2<br>";

//출처 선택값 
if($ctype == "A"){
	$ctypecheck1 = "checked";
	$ctypecheck2 = "";
}else{
	$ctypecheck1 = "";
	$ctypecheck2 = "checked";
}
//리스트 프로모션 선택값 
if($thumb == "A"){
	$thumbcheck1 = "checked";
	$thumbcheck2 = "";
}else{
	$thumbcheck1 = "";
	$thumbcheck2 = "checked";
}
//템플릿 변수 및 버튼처리 - 시작
if($tel != ""){

	$tel = "<U>tel</U>".$tel."";

}else{
	//$tel = "<U>tel</U> : 등록안됨";
}

if($mobile != ""){

	$mobile = "<U>Mobile</U>".$mobile."";

}else{
	//$mobile = "<U>Mobile</U> : 등록안됨";
}

if($price != "" and $price != "0"){
	$price =  number_format($price);
}

if($filecheck != ""){
	
	$downurl = $downlink.$topimgDir."/".$frontierData['filelink'];

	$filelink = "<tr>
	  <td class='frontier_table_l gray_d_text'>- 자료 다운로드</td>
	  <td class='frontier_table_r'>자료를 다운 받아 포스트 하세요.<a href='$downurl' class='w_space'><img src='/images/common/but/but_g_downlord.gif' alt='다운받기'  title='다운받기' class='imgb_space'/></a></td>
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

/**********************************
* 버튼 처리
***********************************/

#step1 응모하기, 리뷰등록하기 버튼 판단 : 응모중 기간인지 체크함
$dateCheck = $CLASS_FRONTIER->DateCheckFrontier($DB, $frontier_no);
for($z=0;$z<sizeof($dateCheck);$z++) {

	$entrydate		=	strtotime($dateCheck[$z]['end_date']);
	$reviewdate	=	strtotime($dateCheck[$z]['due_edate']);
}

$today = date("Y-m-d H:i:s");
$today = strtotime($today);

//echo "entrydate:$entrydate<br>";
//echo "today:$today<br>";




//템플릿 변수 및 버튼처리 - 끝

//모집기간 시작일 합체조립
$jstart_date = $frontierData['start_date'];
$jstart_date = substr($jstart_date,0,4)."년".number_format(substr($jstart_date,5,2))."월".number_format(substr($jstart_date,8,2))."일";


//모집기간 종료일 합체조립
$jend_date = $frontierData['end_date'];
$jend_date = substr($jend_date,0,4)."년".number_format(substr($jend_date,5,2))."월".number_format(substr($jend_date,8,2))."일";

//당첨자 발표일 합체조립
$notice_date = $frontierData['notice_date'];
$notice_date = substr($notice_date,0,4)."년".number_format(substr($notice_date,5,2))."월".number_format(substr($notice_date,8,2))."일";


//리뷰작성 시작일 합체조립
$due_sdate = $frontierData['due_sdate'];
$due_sdate = substr($due_sdate,0,4)."년".number_format(substr($due_sdate,5,2))."월".number_format(substr($due_sdate,8,2))."일";

//리뷰작성 종료일 합체조립
$due_edate = $frontierData['due_edate'];
$due_edate = substr($due_edate,0,4)."년".number_format(substr($due_edate,5,2))."월".number_format(substr($due_edate,8,2))."일";


//베스트 리뷰어 발표일 합체조립
$bestrview_notice_date = $frontierData['bestrview_notice_date'];
if($bestrview_notice_date != "" and $bestrview_notice_date != "0000-00-00 00:00:00"){
	
	$bestrview_notice_date2 = substr($bestrview_notice_date,0,4)."년".number_format(substr($bestrview_notice_date,5,2))."월".number_format(substr($bestrview_notice_date,8,2))."일";

	$bestrview_notice_date = "<li class='frontier_detailview7'><div class='detailview_text'>$bestrview_notice_date2</div></li>";
	}else{
	$bestrview_notice_date = "";
}

$bestrviewer_count = $frontierData['bestrviewer_count'];

//응모하기 
$table_name		= "Rf_cate1_code"; //1차 카테고리 테이블 명

$now_year = date("Y");
$now_month = date("m");
$now_day = date("d");
$birth_year = array();
$birth_month = array();
$birth_day = array();
for($i=$now_year; $i>=1900; $i--) {
	$birth_year[] = $i;
}
for($i=1; $i<=12; $i++) {
	$birth_month[] = $i;
}
for($i=1; $i<=31; $i++) {
	$birth_day[] = $i;
}

$phone_number = array("010", "011", "016", "017", "018", "019");
$tel_number = array("02", "051", "053", "032", "062", "042", "052", "031", "033", "043", "063", "061", "054", "055", "064", "070");


$cate1_list = $CLASS_CATECODE->getCate1List($DB);
$bcode_list = $CLASS_ZIPCODE->getBcodeList($DB);
$option_list = $CLASS_FRONTIER->FrontierOption2($DB,$frontier_no);


$frno			= $frontier_no;
$user_num	= $_SESSION["userno"];


//===============================================================
//TEMPLATE VARS
//===============================================================
$TPL->defineTemplate("zipcode", "_global_layer", "zipcode.htm");



$TPL->setValue(array(
	"logo"=>$logo,	
	"subject"=>$subject,
	"subject2"=>$subject2,
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
	"address"=>$address,
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
	"etypecheck1"=>$etypecheck1,
	"etypecheck2"=>$etypecheck2,
	"ctypecheck1"=>$ctypecheck1, 
	"ctypecheck2"=>$ctypecheck2, 
	"thumbcheck1"=>$thumbcheck1,
	"thumbcheck2"=>$thumbcheck2,
	"birth_year"=>$birth_year,
	"birth_month"=>$birth_month,
	"birth_day"=>$birth_day,
	"phone_number"=>$phone_number,
	"tel_number"=>$tel_number,
	"cate1_list"=>$cate1_list,
	"bcode_list"=>$bcode_list,
	"frno"=>$frno,
	"frid"=>$frid,
	"userno"=>$userno,
	"userid"=>$userid,
	"option_list"=>$option_list,
	"user_num"=>$user_num,
	"link"=>$link,
	"size"=>$size,
	"type"=>$type,
	"link2"=>$link2,
	"size2"=>$size2,
	"scroll"=>$scroll,
	"tabmenu"=>$tabmenu,
	"mobilecheck"=>$mobilecheck,
	"telcheck"=>$telcheck,
	"now_year"=>$nowyear,
	"now_month"=>$nowmonth,
	"nowday"=>$nowday,
	"startyear"=>$startyear,
	"startmonth"=>$startmonth,
	"startday"=>$startday,
	"starttime"=>$starttime,
	"endyear"=>$endyear,
	"endmonth"=>$endmonth,
	"endday"=>$endday,
	"endtime"=>$endtime,
	"bestrviewer_count"=>$bestrviewer_count,
	"bannercode_clip"=>$bannercode_clip,
));
?>