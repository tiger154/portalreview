<?php
/***************************************************************************************
 * 레뷰공식블로그 게시판(공지사항) 글 가져오기
 * 
 * 작성일 : 2011.10.12
 * 작성자 : 이종학
 * 히스토리 :  
 * 
 ***************************************************************************************/ 
/**
 * 시스템 파일 
 */
require_once "/www/revu39/engine/_sys/sys.conf.cron.php";
require_once _DIR_ENGINE."/_sys/sys.module.php";

/**
 * PHP 에러리포트 설정
 * 
 * sys.conf.php 참조
 */
error_reporting(_ERROR_REPORTING);

/**
 * 사이트설정정보
 */
$SITE = Module::loadConf(_INI_SITE);

/**
 * CLASS
 */
$CLASS_BASE = &Module::singleton("Base");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_SNOOPY = &Module::singletonExtends("Snoopy");
$CLASS_RSSPARSER = &Module::singleton("RSSParser");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * VAR / PROC
 */
$conf = Module::loadConf(_DIR_CONF."/site.ini");
$CLASS_SNOOPY->submit("http://".$conf['BLOGDOMAIN']);
$rssurl = $CLASS_BLOG->getRSSURL($CLASS_SNOOPY->results);
$CLASS_SNOOPY->submit($rssurl);
$CLASS_RSSPARSER->parse($CLASS_SNOOPY->results);
$notice = $CLASS_RSSPARSER->getItems();
$num = 5;
$res = array();

for($i=0; $i<$num; $i++) {
	/* author, category, title, link, guid, comments, description, pubdate */	
	$arr = array();
	$arr[] = $i;
	//$arr[] = $notice[$i]['author'];
	//$arr[] = $notice[$i]['category'];
	$arr[] = $notice[$i]['title'];
	//$arr[] = $notice[$i]['link'];
	$arr[] = $notice[$i]['guid'];
	//$arr[] = $notice[$i]['comments'];
	//$arr[] = $notice[$i]['description'];
	$arr[] = $CLASS_BLOG->transdate($notice[$i]['pubdate']);
	
	if(($notice[$i]['title'] != "") && ($notice[$i]['guid'] != "") && ($notice[$i]['pubdate'] != "")) {
		$DB->rConnect();
		$res[] = $DB->call("p_cache_notice_ins", $arr);
	}
}

/**
 * CRON LOG
 */
if(Module::result($res, "err", "-1") == false) {
	$msg = "캐시-공지사항 입력 실패";	
} else {
	$msg = "캐시-공지사항 입력 성공";
}		
$CLASS_BASE->insertCronLog($DB_LOG, "캐시-공지사항", __FILE__, $msg);

/**
 * 종료
 */
Module::exitModule();
?>