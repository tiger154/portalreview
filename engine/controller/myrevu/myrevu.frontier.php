<?php
/***************************************************************************************
 * 마이레뷰-프론티어
 * 
 * 작성일 : 2011.10.7
 * 작성자 : 박상선
 * 히스토리 :  
 * 
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $DESIGN;

$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

//===============================================================
// EXTEND_CLASS
//===============================================================
//$CLASS_PAGE			= &Module::singleton("Page");
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		
$CLASS_BLOG			= &Module::singleton("Blog.Blog");
$CLASS_REVIEW		= &Module::singleton("Review.Review");
$CLASS_PAGE			= &Module::singleton("Page2", 0);		



//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");


$CLASS_PAGE->set('page', Module::$param[0]);
$limit = $CLASS_PAGE->getLimit();

// 게시물 셀렉팅
// 내가 응모한 프론티어
//$myfron_entrylist		= $CLASS_FRONTIER->MyFrontierEntrySelect($DB, $_SESSION["userno"], "0"); 
// 당첨 프론티어
$myfron_winlist			= $CLASS_FRONTIER->MyFrontierEntryWinSelect($DB, $_SESSION["userno"], "1", $limit);


// 내가 응모한 프론티어 카운팅
//$myfron_entrycount	= $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);
// 당첨된 프론티어 카운팅
$cnt		= $CLASS_FRONTIER->FrontierWinCount($DB, $_SESSION["userno"]);

$size = sizeof($myfron_winlist);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

for($i=0;$i<sizeof($myfron_winlist);$i++) {


	
	if($myfron_winlist[$i]['frno'] > "877"){    //신규이미지 경로
		
		//$imgDir	= substr($myfron_winlist[$i]['frid'],2,4);
		//$listimg	= $domain.$imgDir."/".$myfron_winlist[$i]['frno'].".jpg";
		//$myfron_winlist[$i]['winimg'] = $listimg;

		$mainimgDir	= substr($myfron_winlist[$i]['frid'],2,4);
		$entryimgname = $CLASS_FRONTIER->ListimgSelect($DB, $myfron_winlist[$i]['frno']);
		$listimg	= "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_img/".$mainimgDir."/".$entryimgname;

		$myfron_winlist[$i]['winimg'] = $listimg;
		

	}else{
		$oldimgname = explode("{", $myfron_winlist[$i]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$myfron_winlist[$i]['winimg']	= $oldlink.$oldimgname."_list.gif";

	}



	//$myfron_winlist[$i]['rsubject'] = $myfron_winlist[$i]['subject'];
	$myfron_winlist[$i]['subject'] = $CLASS_BASE->strLimitUTF($myfron_winlist[$i]['subject'], "23", "", $eStr="...");

	//해당 프론티어의 리뷰등록 최근등록물의 리뷰번호와 회원번호 셀렉팅
	$accountinfo					= $CLASS_FRONTIER->FrontierReviewendlist($DB, $myfron_winlist[$i]['frno'], "1");
	for($d=0;$d<sizeof($accountinfo);$d++) {
			$rno = $accountinfo[$d]['rno'];				//해당 등록 리뷰등록번호
			$userno = $accountinfo[$d]['userno'];  //해당 등록 리뷰 글쓴이(회원번호)
			//echo "userno:$rno<br>";
			$myfron_winlist[$i]['review_nickname']				= $CLASS_FRONTIER->ReviewUserNickname($DB, $userno); //회원의 닉네임을 가져오자
			$myfron_winlist[$i]['content']							= $CLASS_FRONTIER->ReviewContentData($DB, $rno);		//해당 리뷰의 컨텐츠를 가져오자
			$myfron_winlist[$i]['rno'] = $rno;

			if($myfron_winlist[$i]['review_nickname'] == ""){
				$myfron_winlist[$i]['view'] = "N";
			}else{
				$myfron_winlist[$i]['view'] = "Y";
				
			}

	}

	$myfron_winlist[$i]['reviewcnt'] = $CLASS_FRONTIER->FrontierReviewCnt($DB, $myfron_winlist[$i]['frno']);
	
	//리뷰등록 남은 일
	$enddate				= strtotime($myfron_winlist[$i]['due_edate']);
	$due_edate			= floor(($enddate - time())/86400);
	$myfron_winlist[$i]['due_edate'] = $due_edate;


}
//블로그 리스트

$userno = $_SESSION['userno'];


if($_SESSION['userno'] != ""){
	$bloglist = $CLASS_BLOG->getBlogList($DB, $_SESSION['userno']);
	$formArr = array("blog", "url", "revu");
	$type = (in_array(Module::$param[0], $formArr) == false) ? "blog" : Module::$param[0];
}
	
/**
 * VAR / PROC
 */
		
/**
 * TEMPLATE VARS
 */
$TPL->defineTemplate("entrylayer2", "frontier", "frontier.review.layer.htm");
$TPL->defineTemplate("reviewlayer", "_global_layer", "review.htm");


$TPL->setValue(array(
	"type"=>$type,
	"myfron_entrylist"=>$myfron_entrylist,
	"myfron_winlist"=>$myfron_winlist,
	"bloglist"=>$bloglist,
	"link"=>$link,
	"size"=>$size,

));
?>