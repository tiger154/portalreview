<?php
header("Content-Type: text/html; charset=UTF-8");
header("P3P: CP='NOI DSP COR IVAa OUR BUS IND UNI COM NAV INT'");

define("_HOST", "www.revu.co.kr");
define("_ROOT", "/www/revu39/public_html");
define("_DOMAIN", str_replace("www.", "", _HOST));
//define("_DOMAIN_FILE", "file."._DOMAIN);
//define("_DOMAIN_IMAGE", "image."._DOMAIN);
define("_DOMAIN_FILE", "file.revu.co.kr");
define("_DOMAIN_IMAGE", "image.revu.co.kr");


define("_DIR_ROOT", substr(_ROOT,0,strrpos(_ROOT,"/")));
define("_DIR_ENGINE", _DIR_ROOT."/engine");
define("_DIR_PUBLIC_HTML", _DIR_ROOT."/public_html");

define("_DIR_MODEL", _DIR_ENGINE."/model");
define("_DIR_VIEW", _DIR_ENGINE."/view");
define("_DIR_CONTROLLER", _DIR_ENGINE."/controller");
define("_DIR_CRON", _DIR_ENGINE."/_cron");
define("_DIR_EXTENDS", _DIR_ENGINE."/_extends");
define("_DIR_SYS", _DIR_ENGINE."/_sys");

define("_DIR_CONF", _DIR_ENGINE."/_conf");
define("_DIR_IMAGES" , _DIR_PUBLIC_HTML."/images");
define("_DIR_TMP" , _DIR_ROOT."/tmp");

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
define("_SESSION_CACHEEXPIRE", ini_get("session.cache_expire")); 
define("_SESSION_MAXLIFETIME", ini_get("session.gc_maxlifetime")); 
define("_SESSION_PROBABILITY", ini_get("session.gc_probability")); 
define("_SESSION_DIVISOR", ini_get("session.gc_divisor")); 
//define("_SESSION_MAXLIFETIME", 10); 
//define("_SESSION_PROBABILITY", 1); 
//define("_SESSION_DIVISOR", 100); 

define("_MSG", false); // 메세지 노출

define("_DEBUG", false); // 디버그설정
define("_DEBUG_QUERY", false); // 쿼리보기

define("_ERROR_REPORTING", E_PARSE | E_WARNING);
//define("_ERROR_REPORTING", E_ALL & E_STRICT & E_ERROR & E_WARNING & E_PARSE & E_NOTICE);
//define("_ERROR_REPORTING", 0);

define("_FTP_TMP", "tmp"); // FTP임시경로
define("_FTP_USERIMAGE", "userimage"); // FTP회원이미지경로
define("_FTP_FRONTIERIMAGE", "frontier"); // FTP프론티어이미지경로
define("_FTP_REVIEWIMAGE", "review"); // FTP리뷰이미지


define("_INI_SITE", _DIR_CONF."/site.ini"); // 사이트 설정
define("_INI_MSG" , _DIR_ENGINE."/_conf/msg.ini"); // 메세지 파일
?>