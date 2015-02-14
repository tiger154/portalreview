<?php
$domain			= "http://"._DOMAIN_FILE."/frontier/title_img/";
$downlink			= "http://"._DOMAIN_FILE."/frontier/rel_file/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";
$b_cate_table		= "Rf_cate1_code";		
$m_cate_table	= "Rf_cate2_code";		
$s_cate_table		= "Rf_cate3_code";		
$f_cate_table		= "Rf_cate4_code";		
$area1_table		= "Rf_area_bcode";		
$area2_table		= "Rf_area_mcode";		
$area3_table		= "Rf_area_scode";		

GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

$CLASS_PAGE			= &Module::singleton("Page2", 0);		
$CLASS_PAGE2			= &Module::singleton("Page3", 3);		
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_CATECODE	= &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE		= &Module::singleton("Zipcode");
$CLASS_USER			= &Module::singleton("User.User");
$CLASS_BLOG			= &Module::singleton("Blog.Blog");
$CLASS_REVIEW		= &Module::singleton("Review.Review");
$CLASS_BASE			= &Module::singleton("Base");		


$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();


$CLASS_PAGE2->set('page', Module::$param[3]);
$limit2 = $CLASS_PAGE2->getLimit();


if(Module::$param[0] != "1" || Module::$param[3] != "" || Module::$param[4] == "M"){

	$scroll = "<script type='text/javascript'>
				<!--
				window.onload = function() {
				var pagebottom = document.body.scrollHeight;
					window.scrollTo(0, pagebottom);
				}
				//-->
				</script>";
}

$DB = &Module::loadDb("revu");

$frontier_no = Module::$param[1];
$frtype		  = Module::$param[2];

$nowmonth			= date("m");
$nowday				= date("d");



$frontierData					= $CLASS_FRONTIER->FrontierView($DB, $frontier_no, $flag_delete="0", $btitle, $sch_opt, $sch_con, $stat, $frname);
$frontierCount				= $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);
$frontierOptionList			= $CLASS_FRONTIER->FrontierOption($DB, $frontier_no);


$talkData						= $CLASS_FRONTIER->FrontierEntryTalk($DB, $frontier_no, $limit);
$talkDataCnt					= $CLASS_FRONTIER->FrontierEntryTalkCnt($DB, $frontier_no);
$reviewData					= $CLASS_FRONTIER->FrontierReview($DB, $frontier_no, $limit2);
$reviewDataCnt				= $CLASS_FRONTIER->FrontierReviewCnt($DB, $frontier_no);

$size = sizeof($talkData);
$CLASS_PAGE->set('totalRowCount', $talkDataCnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

$size2 = sizeof($reviewData);
$CLASS_PAGE2->set('totalRowCount', $reviewDataCnt);
$CLASS_PAGE2->pageLink("/".Module::$module."/".Module::$todo,Module::$param);
$link2 = ($size2 > 0) ? $CLASS_PAGE2->getLink() : "";

$userno			= $_SESSION["userno"];

for($r=0;$r<sizeof($reviewData);$r++) {
	$review_nickname = $CLASS_FRONTIER->ReviewUserNickname($DB, $reviewData[$r]['userno']);

	$reviewData[$r]['review_nickname'] = $review_nickname;
	$reviewData[$r]['file'] = $CLASS_FRONTIER->ReviewFileData($DB, $reviewData[$r]['rno']);
	$reviewData[$r]['imgurl'] = $CLASS_REVIEW->getThumbimage($reviewData[$r]['file'], $reviewData[$r]['regdate']) ;
	$imgurl = $reviewData[$r]['imgurl'];
	//$reviewData[$r]['content']			= $CLASS_FRONTIER->ReviewContentData($DB, $reviewData[$r]['rno']);
	$reviewData[$r]['review']			= $CLASS_FRONTIER->ReviewContentData($DB, $reviewData[$r]['rno']);
	$reviewData[$r]['review']['content']			= strip_tags($reviewData[$r]['review']['content']);
}

for($i=0;$i<sizeof($talkData);$i++) {


	$extraInfo = $CLASS_USER->getUserExtra($DB, $talkData[$i]['userno']);
	$talkData_ = $talkData[$i]['regdate'];
	$talkdate = substr($talkData_,0,4).".".number_format(substr($talkData_,5,2)).".".number_format(substr($talkData_,8,2)).". ".number_format(substr($talkData_,10,2)).":".number_format(substr($talkData_,12,2)).":".number_format(substr($talkData_,14,2));
	$talkData[$i]['talkdate'] = $talkdate;
	$talkData[$i]['userimg'] = $CLASS_USER->getImage($talkData[$i]['userno'], $extraInfo['userimage']);
	$talkData[$i]['replytalk']	= $CLASS_FRONTIER->FrontierTalkReply($DB, $frontier_no, $talkData[$i]['no']);

	$select_userno = $talkData[$i]['userno'];
	if($talkData[$i]['delflag'] == "1"){ 
		$talkData[$i]['nickname'] = "";
		$talkData[$i]['regdate'] = "";
		$talkData[$i]['content'] = "삭제된 토크입니다.";
		$talkData[$i]['userimg'] = "/images/frontier/thum_profile_dummy4.gif";
	}else{
		if($userno == $select_userno){

			$talkData[$i]['talk_button'] = "<a href='javascript:replytoggle3(\"".$talkData[$i]['no']."\")'><img src='/images/common/ico/ico_edit.gif' alt='수정' title='수정' class='img_space'></a><img src='/images/common/ico/ico_del.gif' alt='삭제' title='삭제' class='img_space' style='cursor:hand' onclick='talkreplydel2(\"".$talkData[$i]['no']."\")'></a>";

			$talkData[$i]['content'] = htmlspecialchars($talkData[$i]['content']);
		}
	}

	
	for($j=0;$j<sizeof($talkData[$i]['replytalk']);$j++) {
		
		$replyData_ = $talkData[$i]['replytalk'][$j]['regdate'];

		if($userno == $talkData[$i]['replytalk'][$j]['userno']){

			$talkData[$i]['replytalk'][$j]['reply_button'] = "<a href='javascript:replytoggle2(\"".$talkData[$i]['replytalk'][$j]['no']."\")'><img src='/images/common/ico/ico_edit.gif' alt='수정' title='수정' class='img_space'></a><img src='/images/common/ico/ico_del.gif' alt='삭제' title='삭제' class='img_space' style='cursor:hand' onclick='talkreplydel(\"".$talkData[$i]['replytalk'][$j]['no']."\")'></a>";

		}

	}



}

	$enddate				= strtotime($frontierData['end_date']);
	$remainday			= floor(($enddate - time())/86400);

	if($enddate > time()){
		$remaintime			= floor((($enddate - time())%86400)/3600);
		$remain_message	= "<font color=#FFFF00>[모집마감 ".$remainday."일 ".$remaintime."시간 전]</font>";
	}else{
		$remain_message = "<font color=#FFFF00>[모집마감]</font>";
	}

	if($frontierData['frno'] > "877"){   

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
$b_cate						= substr($frontierData['cate'], 0,2);
$m_cate					= substr($frontierData['cate'], 2,3);
$s_cate						= substr($frontierData['cate'], 5,3);
$f_cate						= substr($frontierData['cate'], 8,3);
$b_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $b_cate_table, "1");
$m_cate_desc			= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $m_cate_table, "2");
$s_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $s_cate_table, "3");
$f_cate_desc				= $CLASS_FRONTIER->getBcateSelect($DB, $b_cate, $m_cate, $s_cate, $f_cate, $f_cate_table, "4");

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
$area_code1				= substr($frontierData['areacode'], 0,2);
$area_code2				= substr($frontierData['areacode'], 2,3);
$area_code3				= substr($frontierData['areacode'], 5,2);
$area_bcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area1_table, "1");
$area_mcode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area2_table, "2");
$area_scode_desc		= $CLASS_FRONTIER->areadescSelect($DB, $area_code1, $area_code2, $area_code3, $area3_table, "3");
$result_area_desc		= $area_bcode_desc." ".$area_mcode_desc." ".$area_scode_desc." ".$frontierData['addr'];

$reg_date				= $frontierData['regdate']; 
$subject				= $frontierData['subject'];
$subject = $CLASS_BASE->strLimitUTF($subject, "40", "", $eStr="...");
$subject2 = $CLASS_BASE->strLimitUTF($subject, "24", "", $eStr="...");

$frproduct				= $frontierData['frproduct'];
$peoplelimit			= $frontierData['peoplelimit'];
$bestrview_prise		= $frontierData['bestrview_prise'];
$price					= $frontierData['oprice'];

$filecheck				= $frontierData['filelink'];
$map					= $frontierData['maplink'];
$address				= trim($result_area_desc);
$tel						= $frontierData['tel'];
$telcheck	= substr($tel, 4,1);
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


$mission				= nl2br(htmlspecialchars($frontierData['mission']));


//$keyword				= $frontierData['keyword'];
$keyword				= $frontierData['keyword'];


$tagword				= $frontierData['tagword'];
//$tagword				= nl2br(htmlspecialchars($frontierData['tagword']));

$tip						= nl2br($frontierData['tip']);
$bannercode_clip	= addslashes($frontierData['bannercode']);
$bannercode			= htmlspecialchars($frontierData['bannercode']);
$event_type					= $frontierData['etype'];

if($frontier_no == "1171"){
	$etc_table = "<table width='712' border='0' cellspacing='0' cellpadding='0'>	<tr><td><a href='http://www.wizwid.com/CSW/handler/wizwid/kr/EventConcert-Start?BannerID=008306' target='_blank'><img src='/images/frontier/Frontier2_wizwid_footer.jpg' width='712' height='639' border='0' /></a></td></tr></table>";
}

if($frontier_no == "1181"){
	$etc_table = "<table width='712' border='0' cellspacing='0' cellpadding='0'><tr>";
	$etc_table .= "<td height='315' bgcolor='#000000' align='center'><iframe width='420' height='315' src='http://www.youtube.com/embed/L8I0ZYIk1G8' frameborder='0' allowfullscreen></iframe></td>";
	$etc_table .= "</tr><tr>";
	$etc_table .= "<td height='830'><img src='http://"._DOMAIN_FILE."/frontier/title_img/2012/1181_2.jpg' /></td>";
	$etc_table .= "</tr><tr>";
	$etc_table .= "<td height='772'><img src='http://"._DOMAIN_FILE."/frontier/title_img/2012/1181_3.jpg' /></td></tr></table>";
}

if($mobile != ""){

	$mobile = "(Mobile : ".$mobile.")";

}

if($price == "0"){

	$price = "";
}

if($price != "" and $price != "0"){
	$price =  number_format($price);
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


if($frontierData['frno'] > "877"){  

	
	if($sitelink != ""){

		$sitelink = "<tr>
				  <td class='frontier_table_l gray_d_text'>- 홈페이지</td>
				  <td class='frontier_table_r gray_stitle'><a href='$sitelink' target='_blank'>$sitelink</a></td>
				</tr>";

	}

}else{


	$sitelink2 = substr($sitelink, 7,1);
	if($sitelink2 != ""){

		$sitelink = "<tr>
				  <td class='frontier_table_l gray_d_text'>- 홈페이지</td>
				  <td class='frontier_table_r gray_stitle'><a href='$sitelink' target='_blank'>$sitelink</a></td>
				</tr>";

	}

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

$dateCheck = $CLASS_FRONTIER->DateCheckFrontier($DB, $frontier_no);
for($z=0;$z<sizeof($dateCheck);$z++) {

	$entrydate		=	strtotime($dateCheck[$z]['end_date']);
	$reviewdate	=	strtotime($dateCheck[$z]['due_edate']);
}

$today = date("Y-m-d H:i:s");
$today = strtotime($today);


if($event_type == "A"){

	if($entrydate > $today){ 
		
		if($_SESSION['userno'] != ""){
			$dupcnt = $CLASS_FRONTIER->EntryDuplication($DB, $frontier_no, $_SESSION['userno']);
		}else{
			$dupcnt = "0";
		}
		

		
		if($dupcnt < 1){	
			if($_SESSION['userno'] != ""){ 
				$etype = "<a href='javascript:common.openCenterLayer(\"entrylayer\", -1, -1, 100);'><img src='/images/frontier/but_frontier_entry.gif'  alt='이 프론티어에 응모합니다' title='이 프론티어에 응모합니다'/></a>";
			}else{
				$etype = "<a href='javascript:common.openLayer(\"loginlayer\");'><img src='/images/frontier/but_frontier_entry.gif'  alt='이 프론티어에 응모합니다' title='이 프론티어에 응모합니다'/></a>";
			}
		}else{	
			$etype = "<img src='/images/frontier/but_frontier_entry2.gif'>";
		}


	}else{ 
		if($_SESSION['userno'] != ""){ 
			$etype = "<a href='javascript:common.openCenterLayer(\"entrylayer2\", -1, -1, 90);'><img src='/images/frontier/but_frontier_review.gif'  alt='이 프론티어에 리뷰를 등록합니다' title='이 프론티어에 리뷰를 등록합니다'/></a>";
		}else{
			$etype = "<a href='javascript:common.openLayer(\"loginlayer\");'><img src='/images/frontier/but_frontier_review.gif'  alt='이 프론티어에 리뷰를 등록합니다' title='이 프론티어에 리뷰를 등록합니다'/></a>";
		}

	}
}else{

	$etype = "<a href='javascript:common.openCenterLayer(\"entrylayer2\", -1, -1, 90);'><img src='/images/frontier/but_frontier_review.gif'  alt='이 프론티어에 리뷰를 등록합니다' title='이 프론티어에 리뷰를 등록합니다'/></a>";

}

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
if($bestrview_notice_date != "" and $bestrview_notice_date != "0000-00-00 00:00:00"){
	
	$bestrview_notice_date2 = substr($bestrview_notice_date,0,4)."년".number_format(substr($bestrview_notice_date,5,2))."월".number_format(substr($bestrview_notice_date,8,2))."일";

	$bestrview_notice_date = "<li class='frontier_detailview7'><div class='detailview_text'>$bestrview_notice_date2</div></li>";
	}else{
	$bestrview_notice_date = "";
}


$table_name		= "Rf_cate1_code"; 

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
$option_count = $CLASS_FRONTIER->FrontierOptionCount($DB,$frontier_no);


$frno			= $frontier_no;
$user_num	= $_SESSION["userno"];



if($userno != ""){
	$bloglist = $CLASS_BLOG->getBlogList($DB, $_SESSION['userno']);
	$formArr = array("blog", "url", "revu");
	$type = (in_array(Module::$param[0], $formArr) == false) ? "blog" : Module::$param[0];
}
	
$blogcount = $CLASS_BLOG->getBlogCount($DB, $_SESSION['userno']);
$TPL->defineTemplate("zipcode", "_global_layer", "zipcode.htm");

$TPL->defineTemplate("entrylayer", "frontier", "frontier.entry.layer.htm");
$TPL->defineTemplate("entrylayer2", "frontier", "frontier.review.layer.htm");
$TPL->defineTemplate("reviewlayer", "_global_layer", "review.htm");

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
	"option_count"=>$option_count,
	"talkDataCnt"=>$talkDataCnt,
	"talkData"=>$talkData,
	"user_num"=>$user_num,
	"link"=>$link,
	"size"=>$size,
	"bloglist"=>$bloglist,
	"type"=>$type,
	"link2"=>$link2,
	"size2"=>$size2,
	"reviewDataCnt"=>$reviewDataCnt,
	"reviewData"=>$reviewData,
	"scroll"=>$scroll,
	"tabmenu"=>$tabmenu,
	"mobilecheck"=>$mobilecheck,
	"telcheck"=>$telcheck,
	"blogcount"=>$blogcount,
	"etc_table"=>$etc_table, 
));
?>