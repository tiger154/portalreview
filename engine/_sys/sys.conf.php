<?php
/***************************************************************************************
 * 시스템 설정파일
 * 
 * 사이트의 모든 상수를 정의
 ***************************************************************************************/

header("Content-Type: text/html; charset=UTF-8");
header("P3P: CP='NOI DSP COR IVAa OUR BUS IND UNI COM NAV INT'");


//define("_DOMAIN", str_replace("www.", "", $_SERVER['HTTP_HOST']));
define("_DOMAIN", $_SERVER['HTTP_HOST']);
//define("_DOMAIN_FILE", "file."._DOMAIN);
//define("_DOMAIN_IMAGE", "image."._DOMAIN);
define("_DOMAIN_FILE", "file.revu.co.kr");
define("_DOMAIN_IMAGE", "image.revu.co.kr");
define("_DOMAIN_IMAGE_OLD", "oldimg.revu.co.kr");
define("_DOMAIN_SHORT", "revu.kr");


define("_DIR_ROOT", substr($_SERVER['DOCUMENT_ROOT'],0,strrpos($_SERVER['DOCUMENT_ROOT'],"/")));
define("_DIR_ENGINE", _DIR_ROOT."/engine");
define("_DIR_PUBLIC_HTML", _DIR_ROOT."/public_html");

define("_DIR_MODEL", _DIR_ENGINE."/model");
define("_DIR_VIEW", _DIR_ENGINE."/view");
define("_DIR_CONTROLLER", _DIR_ENGINE."/controller");
define("_DIR_CRON", _DIR_ENGINE."/_cron");
define("_DIR_EXTENDS", _DIR_ENGINE."/_extends");
define("_DIR_SYS", _DIR_ENGINE."/_sys");
define("_DIR_SESSIONDIR", _DIR_ENGINE."/_session");

define("_DIR_CONF", _DIR_ENGINE."/_conf");
define("_DIR_IMAGES" , _DIR_PUBLIC_HTML."/images");
define("_DIR_TMP" , _DIR_ROOT."/tmp");
define("_DIR_PTNER" , _DIR_ROOT."/tmp/partner");
define("_DIR_CRAWLL" , _DIR_PUBLIC_HTML."/images/crawll");

define("_DIR_IMAGES_" , "/images");
define("_DIR_CSS_" , "/css");
define("_DIR_JS_" , "/js");


define("_TPL_COMPILE_CHECK", true);
define("_TPL_COMPILE_EXT", "php");
define("_TPL_COMPILE_DIR", _DIR_ENGINE."/_compile");
define("_TPL_TEMPLATE_DIR", _DIR_VIEW);
define("_TPL_SKIN", "V3.9");
define("_TPL_PREFILTER", "");
//define("_TPL_PREFILTER", "adjustPath & .,jpg,jpeg,gif,png,swf");


define("_SESSION_LOG", true); 
define("_SESSION_CACHEEXPIRE", ini_get("session.cache_expire")); //현재 캐시 만료를 반환 (180)
//define("_SESSION_MAXLIFETIME", ini_get("session.gc_maxlifetime")); 
define("_SESSION_PROBABILITY", ini_get("session.gc_probability")); // 분자(1)
define("_SESSION_DIVISOR", ini_get("session.gc_divisor")); //분모(1000)
define("_SESSION_MAXLIFETIME", 60*60*24*30); 
//define("_SESSION_PROBABILITY", 1); 
//define("_SESSION_DIVISOR", 100); 


define("_MSG", false); // 메세지 노출


define("_DEBUG", false); // 디버그설정


//define("_ERROR_REPORTING", E_PARSE | E_WARNING | E_ERROR);
//define("_ERROR_REPORTING", E_ALL);
//define("_ERROR_REPORTING", E_ALL & E_STRICT & E_ERROR & E_WARNING & E_PARSE & E_NOTICE);
define("_ERROR_REPORTING", 0); //서비스할때 에러메세지 노출안함


define("_ERROR_HANDLER", false);
define("_ERROR_HANDLER_FUNCTION", "Module::error");


define("_FTP_TMP", "tmp"); // FTP임시경로
define("_FTP_USERIMAGE", "userimage"); // FTP회원이미지경로
define("_FTP_FRONTIERIMAGE", "frontier"); // FTP프론티어이미지경로
define("_FTP_REVIEWIMAGE", "review"); // FTP리뷰이미지
define("_FTP_BANNERIMAGE", "banner"); // FTP배너이미지경로
define("_FTP_WITHDRAWIMAGE", "withdraw"); // FTP캐시출금관련 사본이미지 경로
define("_FTP_KEYWORDIMAGE", "keyword"); // FTP키워드이미지 경로
define("_FTP_CP", "partner"); // 제휴사, 관계사 FTP

/*
define("_FTP_TMP", "DATA/tmp"); // FTP임시경로
define("_FTP_USERIMAGE", "DATA/userimage"); // FTP회원이미지경로
define("_FTP_FRONTIERIMAGE", "DATA/frontier"); // FTP프론티어이미지경로
define("_FTP_REVIEWIMAGE", "DATA/review"); // FTP리뷰이미지
define("_FTP_BANNERIMAGE", "DATA/banner"); // FTP배너이미지경로
define("_FTP_WITHDRAWIMAGE", "DATA/withdraw"); // FTP캐시출금관련 사본이미지 경로
*/

define("_INI_SITE", _DIR_CONF."/site.ini"); // 사이트 설정
define("_INI_MSG" , _DIR_ENGINE."/_conf/msg.ini"); // 메세지 파일

// revulove계정
define("CONSUMER_KEY", "JbjyJwzuElq6wRqM7ww");
define("CONSUMER_SECRET", "RITo56SbmTheBtoFJyBr2zfYLQTCL01GryAomuQE");
define("OAUTH_CALLBACK", "http://www.revu.co.kr/api/twitter");
define("OAUTH_ACCESS_TOKEN", "90872886-nYGoye1YvmH7mfUhpAKOLgPihs3Ec9OL2nAPAsK4k");
define("OAUTH_ACCESS_TOKEN_SECRET", "8NTecwE9gCXgP5cztCKtEkAGqDkQQg79Byn8wxNoU");

define("FACEBOOK_KEY", "189402831149686");
define("FACEBOOK_SECRET", "f8e8b16c31bd750e902d6074df065736");
define("FACEBOOK_CALLBACK", "http://www.revu.co.kr/api/facebook");
define("FACEBOOK_NAMESPACE", "revulove");


define("BITLY_APIKEY", "R_dd23f4eb9e5b89753f2a53a794d7d488");
define("BITLY_SHORTEN_URL", "https://api-ssl.bitly.com/v3/shorten");
define("BITLY_ID", "revulove");
?>