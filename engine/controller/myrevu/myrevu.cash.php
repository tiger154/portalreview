<?php
/***************************************************************************************
 * 마이레뷰-캐시
 * 
 * 작성일 : 2011.09.07
 * 작성자 : 이종학
 * 히스토리 :  
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
$CLASS_PAGE = &Module::singleton("Page2", 0);
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_REVIEW = &Module::singleton("Review.Review");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$cash = $CLASS_CASH->getCash($DB, $_SESSION['userno']);

$CLASS_PAGE->set('page', Module::$param[0]);
$cnt = $CLASS_CASH->getCashCount($DB, Module::$param[1], $_SESSION['userno']);
$list = $CLASS_CASH->getCashList($DB, $CLASS_PAGE->getLimit(), Module::$param[1], $_SESSION['userno']);
for($i=0; $i<sizeof($list); $i++) {
	$list[$i]['sign'] = ($list[$i]['flag_sign'] == "0") ? "+" : "-";
	$list[$i]['span_class'] = ($list[$i]['flag_sign'] == "0") ? "red_b_text" : "gray_lb_text";
	$_cashInfo = $CLASS_CODE->getCashType($DB, $list[$i]['cash_type']);
	$list[$i]['cash_explain'] = $_cashInfo['state_explain'];	
	if(!empty($list[$i]['rno'])) {
		$_content = $CLASS_REVIEW->getReviewContent($DB, $list[$i]['rno']);
		$list[$i]['title'] = "(".$BASE->strLimitUTF($_content['title'], 50, false, '...').")";
	}	
}

$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = $CLASS_PAGE->getLink();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"cash"=>$cash,
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
));
?>