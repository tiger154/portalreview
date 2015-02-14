<?php
/***************************************************************************************
 * 리뷰 - 소셜보기 컨트롤러
 * 
 * 작성일 : 2011.09.14
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

$FRAME = "view";

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

$rno = Module::$param[0];
if($CLASS_REVIEW->isReviewByRno($DB, $rno) == true) {
	$review = $CLASS_REVIEW->getReview($DB, $rno);	
} else {
	//Module::exitModule();
}
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"rno"=>$rno,
	"review"=>$review,
));
?>