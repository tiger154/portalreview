<?php
/***************************************************************************************
 * 블로그수정
 * 
 * 작성일 : 2011.09.07
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
$CLASS_PAGE = &Module::singleton("Page2", 2);
$CLASS_BLOG = &Module::singleton("Blog.Blog");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$blogno = Module::$param[0];
$blog = $CLASS_BLOG->getBlog($DB, $blogno);
if($_SESSION['userno'] != $blog['userno']) {
	Module::redirect("/myrevu/blog");
}
$blog['name'] = htmlspecialchars($blog['name']);
//echo $blog['name'];
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"blog"=>$blog,
));
?>