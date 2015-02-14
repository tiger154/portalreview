<?php
/***************************************************************************************
 * 리뷰 컨트롤러
 * 
 * 작성일 : 2011.10.15
 * 작성자 :  이종학
 * 히스토리 : 
 * 
 * 2011.XX.XX (작성자)
 * > 수정내용1
 * > 수정내용2 
 * 
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
GLOBAL $SITE;
GLOBAL $FRAME;

/**
 * CLASS
 */
$CLASS_USER = &Module::singleton("User.USer");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$jsonArr = array();

/**
 * TODO
 */
switch(Module::$todo)
{	
	/**
	 * 베스트후보추천회원정보
	 */
	case "cand.recom.user.proc" :		 
		$FRAME = "ajax";
		$limit = 10;
		$list = $CLASS_REVIEWBEST->getBestCandRecomList($DB, $_POST['wno'], $_POST['rno']);	
		$size = sizeof($list);	
		$cnt = ($size > $limit) ? 10 : $size;
		if($size > 0) {
			$jsonArr['recomCnt'] = $size;
			$jsonArr['cnt'] = $cnt;
			for($i=0; $i<$cnt; $i++) {
				$user = $CLASS_USER->getUser($DB, $list[$i]['userno']);
				$extra = $CLASS_USER->getUserExtra($DB, $list[$i]['userno']);
				$list[$i]['nickname'] = $user['nickname'];
				$list[$i]['userimage'] = $CLASS_USER->getImage($list[$i]['userno'], $extra['userimage']);
				unset($user);
				unset($extra);
			}
			$jsonArr['list'] = $list;
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		} 
		break;
	/**
	 * 베스트리뷰 정보
	 */
	case "best.week.data.proc" :		 
		$FRAME = "ajax";
		
		$bestData = $CLASS_SITE->getBestReviewSearch($DB,$titlemaxlenUse=true,$titlemaxlen=18,$_POST['wno']);
		$size = sizeof($bestData["list"]);
		if($size > 0) {
			$jsonArr['list'] = $bestData;
			$jsonArr['result'] = "success";
		}else{
			$jsonArr['result'] = "fail";
		}	

		break;

	/**
	 * 디폴트
	 */
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		break;

}

/**
 * AJAX OUTPUT 
 */
if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}

/**
 * MODULE & DB CONNECT CLOSE
 */
Module::exitModule();
?>