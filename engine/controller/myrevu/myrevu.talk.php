<?php
/***************************************************************************************
 * 마이레뷰-소셜토크
 * 
 * 작성일 : 2011.12.22
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
$CLASS_PAGE = &Module::singleton("Page2", 1);
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWTALK = &Module::singleton("Review.ReviewTalk");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
if(Module::$param[0] == "0" || Module::$param[0] == "") $type = "0"; else $type = "1";
Module::$param[0] = $type;
$CLASS_PAGE->set('page', Module::$param[1]);
$limit = $CLASS_PAGE->getLimit();
$cnt = $CLASS_REVIEWTALK->getTalkUserCount($DB, $type, $_SESSION['userno'], $flag_del="0");
$list = $CLASS_REVIEWTALK->getTalkUserList($DB, $limit, $type, $_SESSION['userno'], $flag_del="0");
$list = $CLASS_REVIEWTALK->getTalkDataBind($DB, $list);
$size = sizeof($list);
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, Module::$param);
$link = ($size > 0) ? $CLASS_PAGE->getLink() : "";

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"type"=>$type, 
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"cnt"=>$cnt,
	"list"=>$list,
	"size"=>$size, 
	"link"=>$link,
	"param"=>Module::$param,
));
?>