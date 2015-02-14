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
 
GLOBAL $FRAME; 
$FRAME = "popup";

$domain			= "http://"._DOMAIN_FILE."/frontier/list_img/";
$oldlink				= "http://"._DOMAIN_FILE."/frontier/old_img/";

//===============================================================
// EXTEND_CLASS
//===============================================================
$CLASS_PAGE			= &Module::singleton("Page");
$CLASS_FRONTIER		= &Module::singleton("Frontier.Frontier");
$CLASS_BASE			= &Module::singleton("Base");		


/**
 * CLASS
 */
$CLASS_BLOG = &Module::singleton("Blog.Blog");

//===============================================================
// DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");



// 게시물 셀렉팅
// 내가 응모한 프론티어
$myfron_entrylist		= $CLASS_FRONTIER->MyFrontierEntrySelect($DB, $_SESSION["userno"], "0"); 

// 내가 응모한 프론티어 카운팅
//$myfron_entrycount	= $CLASS_FRONTIER->getListCount($DB, $code, $flag_delete, $btitle, $sch_opt, $sch_con, "B", $frname);

//echo "myfron_entrycount:$myfron_entrycount";

for($s=0;$s<sizeof($myfron_entrylist);$s++) {



	if($myfron_entrylist[$s]['frno'] > "877"){    //신규이미지 경로

		$mainimgDir	= substr($myfron_entrylist[$s]['frid'],2,4);
		//$mainlistimg	= $domain.$mainimgDir."/".$myfron_entrylist[$s]['frno'].".jpg";

		$entryimgname = $CLASS_FRONTIER->ListimgSelect($DB, $myfron_entrylist[$s]['frno']);
		$mainlistimg	= "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/list_img/".$mainimgDir."/".$entryimgname;

		$myfron_entrylist[$s]['Entryimg'] = $mainlistimg;

	}else{

		$oldimgname = explode("{", $myfron_entrylist[$s]['frid']);
		$oldimgname = explode("}", $oldimgname[1]);
		$oldimgname = $oldimgname[0];
		$myfron_entrylist[$s]['Entryimg']		= $oldlink.$oldimgname."_list.gif";
		
		$url = $oldlink.$oldimgname.".jpg";		

		if(!@fopen($url,"r")) //--> 파일과 같은 것을 찾는다. 
		{ 
			$myfron_entrylist[$s]['Entryimg']	 = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";	//더미 이미지

		}else{
			$myfron_entrylist[$s]['Entryimg']		= $oldlink.$oldimgname."_list.gif";
		}


		

	}






	$myfron_entrylist[$s]['subject'] = $CLASS_BASE->strLimitUTF($myfron_entrylist[$s]['subject'], "18", "", $eStr="...");
	$notice_date				= $myfron_entrylist[$s]['notice_date'];	
	$enddate				= strtotime($myfron_entrylist[$s]['end_date']);
	$remainday			= floor(($enddate - time())/86400);
	if($remainday < 0){
		$remainday = substr($notice_date,2,2).".".number_format(substr($notice_date,5,2)).".".number_format(substr($notice_date,8,2));

	}else{
		$remainday = "D -".$remainday;

	}

	$myfron_entrylist[$s]['remainday'] = $remainday;
}


//응모한 프론티어가 있을때와 없을때와 다르게 이미지를 선택함
if($s == "0"){
	//echo "응모한 프론티어가 없음";
	$headimg = "<tr>
					<td width='z' height='35' colspan='5' align='center'><img src='/images/myrevu/img_nonefrontier.gif' width='220'  height='189'></td>
				</tr>";

	
}else{
	//echo "응모한 프론티어가 하나 이상일때";
	$headimg = "<tr>
					<td width='620' height='35' colspan='5' align='center'><img src='/images/myrevu/title_myentry.gif' width='623' height='35' /></td>
				</tr>";
	$leftbutton = "<div class='sliderkit-btn sliderkit-nav-btn sliderkit-nav-prev'><a href='#' title='이전보기'><span><img src='/images/common/but/but_frontier_pre.gif' alt='이전보기' width='32' height='61' title='이전보기'></span></a></div>";
	$rightbutton = "<div class='sliderkit-btn sliderkit-nav-btn sliderkit-nav-next'><a href='#' title='다음보기'>
				<span><img src='/images/common/but/but_frontier_next.gif' alt='다음보기' width='32' height='61' title='다음보기' ></span></a>
				</div>";
}


/**
 * VAR / PROC
 */
		
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"type"=>$type,
	"myfron_entrylist"=>$myfron_entrylist,
	"headimg"=>$headimg,
	"leftbutton"=>$leftbutton,
	"rightbutton"=>$rightbutton,
));




?>