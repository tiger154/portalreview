<?php
 /***************************************************************************************
 * 블로그  프레임 컨트롤러
 * 
 * 작성일 : 2011.10.12
 * 작성자 : 이종학
 * 히스토리 :
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
//GLOBAL $SITE;
//GLOBAL $FRAME;
 
/**
 * CLASS
 */
$CLASS_SITE = &Module::singleton("Site.Site");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$conf = $conf = Module::loadConf(_DIR_CONF."/site.ini");
$notice = $CLASS_SITE->getNotice($DB);

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"conf"=>$conf,
	"notice"=>$notice,
));
?>