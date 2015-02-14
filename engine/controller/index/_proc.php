<?php
/***************************************************************************************
 * 인덱스 컨트롤러
 * 
 * 작성일 : 2011.07.08
 * 작성자 : 이종학
 * 히스토리 : 
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
$CLASS_REVIEW = &Module::singleton("Review.Review");

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
	 * 실시간 리뷰카운트
	 */
	case "realtime.review.count.proc" :		 
		$FRAME = "ajax";
		$count = $CLASS_REVIEW->getReviewCount($DB, $type="", $cate=array(), $status="1", $date=array());
		if($count > 0) {
			$jsonArr['count'] = number_format($count);
			$jsonArr['result'] = "success";
		} else {
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