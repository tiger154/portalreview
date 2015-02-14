<?php

//echo 1;
//exit;
/**
 * 버퍼저장
 */
//ob_start("ob_gzhandler");

/**
 * 시스템 파일 
 */
$_DOC_ROOT = substr($_SERVER['DOCUMENT_ROOT'], 0, strrpos($_SERVER['DOCUMENT_ROOT'], "/"));
require_once $_DOC_ROOT."/engine/_sys/sys.conf.php";
require_once _DIR_ENGINE."/_sys/sys.module.php";
require_once _DIR_ENGINE."/_extends/php.Template_/Template_.class.php";

/*************** 
 *  @@ Remember Me include module 
 ****************/
//$CLASS_REMEMBERME = &Module::singleton("API.Rememberme"); //remember me
function rememberAutoload($class) {
  require _DIR_EXTENDS.'/php.Rememberme/src/'.strtr($class,'_',DIRECTORY_SEPARATOR).".php";
}
spl_autoload_register("rememberAutoload");




/**
 * PHP 에러리포트 / 에러핸들러 설정
 * 
 * sys.conf.php 참조
 */
error_reporting(_ERROR_REPORTING);  // sys.conf.php 파일 참조(웹정상서비스시 비활성화)
//if(_ERROR_HANDLER == true) set_error_handler(_ERROR_HANDLER_FUNCTION);

/**
 * 처리시간측정-시작
 */
$__sTime = Module::getMicroTime();

/**
 * 기본클래스
 */
$TPL = &Module::singleton("Template");
$BASE = &Module::singleton("Base");


$db_opt_tmp = array ("tableName"=>"Ru_rememberme","credentialColumn"=>"credential","tokenColumn"=>"token","persistentTokenColumn"=>"persistent_token","expiresColumn"=>"expires","fbColumn"=>"rf","twitColumn"=>"rt");
$mysqli_connection_tmp = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");
$rPDO = new Rememberme_Storage_PDO($db_opt_tmp);
$rPDO->setConnection($mysqli_connection_tmp);
$rememberMe = new Rememberme($rPDO); //RememberMe
//$SESSION = &Module::singleton("Session"); DB세션사용

/**
 * 사이트설정정보
		ID=revu
		NAME="레뷰"
		DOMAIN="dev.revu.co.kr"
		BLOGDOMAIN="blog.revu.co.kr"
		KEYWORDS="세상의 모든 리뷰, 리뷰"
		EMAIL="revu@revu.co.kr"
		TITLE="레뷰"
		DESC=^^
		PARKING=N - 공사중 유무
		STARTPAGE=N - 시작페이지 
		STARTMODULE="/join"
		STARTVAR=""
		URL=dev.revu.co.kr
		PHONE=02-999-9999
		FAX=02-8888-8888
		COMPANY="아이에스이커머스"
		CEO=이종학
		ADDRESS="서울시 강남구 삼성2동 78 (주)아이에스 이커머스"
 */
$SITE = Module::loadConf(_INI_SITE); //상단 주석 참조 -> /engine/_conf/site.ini
$TPL->setValue(array("SITE"=>$SITE)); 





/**
 * 템플릿경로
 */
$HeaderProtocol = isset($_SERVER['HTTPS']) ? "https://" : "http://";

$TPL->setValue(array("DOMAIN"=>$HeaderProtocol._DOMAIN));
$TPL->setValue(array("DOMAIN_FILE"=>"http://"._DOMAIN_FILE));
$TPL->setValue(array("IMAGES"=>"http://"._DOMAIN."/images"));
$TPL->setValue(array("EXTENDS"=>$HeaderProtocol._DOMAIN."/extends"));
$TPL->setValue(array("JS"=>$HeaderProtocol._DOMAIN."/js"));
$TPL->setValue(array("CSS"=>$HeaderProtocol._DOMAIN."/css"));
$TPL->setValue(array("FACEBOOK_NAMESPACE"=>FACEBOOK_NAMESPACE));
$TPL->setValue(array("FACEBOOK_KEY"=>FACEBOOK_KEY));
$TPL->setValue(array("DOMAIN_URL"=>$HeaderProtocol._DOMAIN.$_SERVER['REQUEST_URI']));

 
/**
 * 세션설정 javascript:alert(document.cookie)
 session.cache_expire 1440*30(분단위)
 gc_maxlifetime(초단위), 가비지컬렉션 
 cookie_lifetime(초단위), 0은 브라우저 닫을때까지
 
 * 적용 안될시 session_save_path(_DIR_SESSIONDIR);  적용하기 
 */
$s_lifetime  = 60*60*24*30; //sec
$m_lifetime = 60*24*30; //min

//session_save_path("/www/revu39/engine/_session");
//ini_set('session.gc_maxlifetime', $s_lifetime); // 세션 아무작업 없을때 유지시간
//ini_set('session.cookie_lifetime', $s_lifetime); // 쿠키 유지시간
//ini_set('session.cache_expire', $m_lifetime); // 분 단위로 캐시한 세션 페이지가 살아있을 시간을 지정합니다

ini_set("session.cookie_domain", _DOMAIN); // 세션공유 도메인값 ** .revu.co.kr 로 할시 서브도메인 포함됨
session_cache_limiter('nocache, must-revalidate'); //캐시 사용안함
session_set_cookie_params(0, "/", _DOMAIN, false, true); //쿠키 적용시간 0:브라우저 닫히기전까지, 시간지정시 해당 시간까지 유지 예) 30일 $lifetime = 60*60*24*30;
//session_set_cookie_params ( int $lifetime [, string $path [, string $domain [, bool $secure = false [, bool $httponly = false ]]]] )
session_start(); 
$TPL->setValue($_SESSION);	 // 세션변수설정
//print_r($_SESSION);
//print_r($_COOKIE);
/**
 * @@@@@모듈로드
   - 해당 페이지의 핵심
   - Module::routeModule() 함수에서 아래의 기능을 수행한다.
		1. 모듈명, 액션, 파라미터, 프레임명 값 할당 
        2. 콘트롤러페이지(php), 프레임페이지(php) 맵핑 
		3. 인증정보 처리(인증관련 xml 값 해석후 처리) /conf/priv.module.xml
 */
Module::routeModule(); // 권한체크포함
$TPL->setValue(array("MODULE"=>Module::$module)); //모듈명
$TPL->setValue(array("TODO"=>Module::$todo)); //액션값
$TPL->setValue(array("REQUEST_URI"=>$_SERVER["REQUEST_URI"])); //현재 페이지 주소(도메인제외)


/**
 * 시작페이지(모듈명변경) / 파킹페이지 설정
 */
Module::parking(Module::$module);
Module::startPage(Module::$module);

/**
 * Rememberme 값에 따른 로그인 Session, SnS계정 활성화
 */
 
 if(isset($_SESSION["userid"])){
	//Do nothing
 }else{
	
/*Class init*/	
//	 $CLASS_LOGIN_COMMON = &Module::singleton("Auth.Login");
//	 $CLASS_BLOG_COMMON = &Module::singleton("Blog.Blog");
//	 $CLASS_USER_COMMON = &Module::singleton("User.User");
//	 $CLASS_CASH_COMMON = &Module::singleton("User.Cash");
//	 $CLASS_POINT_COMMON = &Module::singleton("User.Point");
//	 $CLASS_GRADE_COMMON = &Module::singleton("User.Grade");
//	 $CLASS_FRONTIER_COMMON = &Module::singleton("Frontier.Frontier");

   // 1) 쿠키 가져오기
   // 2) DB서칭 후 존재한다면, 로그인세션, SnS계정 활성화 처리
   //      @Return value
   //      loginID = 109289
   //      rfbID = 10000254869
   //      rtwitID = 6054892
   //>      login session process~~~
   //>      rfb active session process~~~
   //>      rtwit session process~~~
   // 3) 그외 경우 로그기록 남기기.... 
 }

/**
 * 디자인프레임설정
   - 프레임 값에 따른 디자인 템플릿 처리 
 */

 
switch($FRAME) {
	case "none" :
	case "ajax" : // AJAX처리
		break;	
	
	case "parking" : // 파킹
		$TPL->defineTemplate("frame", "_global", "_parking.htm");
		break;
	
	case "notpage" : // 페이지/모듈없음
		$TPL->defineTemplate("frame", "_global", "_notpage.htm");
		break;
	
	case "popup" : // 팝업창
		$TPL->defineTemplate("frame", "_global", "_popup.htm");
		$TPL->defineTemplate("contents", Module::$module, Module::$module.".".Module::$todo.".htm");
		$TPL->defineTemplate("etcscript", "_global", "_etcscript.htm");
		// 리사이즈체크
		foreach(Module::$param as $key => $val) {
			if($val == "resize") $resize = true;
			$TPL->setValue(array("RESIZE"=>$resize));
		}
		break;
	
	case "view" : // 뷰
		if(Module::$todo != "") {
			$TPL->defineTemplate("frame", Module::$module, Module::$module.".".Module::$todo.".htm");
		} else {
			$TPL->defineTemplate("frame", Module::$module, "index.htm");			
		}
		break;	
	
	case "socialbar" : // 소셜바 
		$TPL->defineTemplate("frame", "_global", "_socialbar.htm");
		$TPL->defineTemplate("socialbar", "socialbar", "index.htm");
		$TPL->defineTemplate("etcscript", "_global", "_etcscript.htm");
		$TPL->defineTemplate("loginlayer", "_global_layer", "slogin.htm");
		$TPL->defineTemplate("sidebar", "_global", "sidebar.htm");	
		break;

   	case "search" : // 검색 **** 
     			
        //**** 정의된 값을 확인후 실행한다. 
		//** 서브페이지 없는 형태로 제작함
		//** 액션이 있는 경우 아이프레임으로 지정함.
		// /www/revu39/engine/controller/search/_frame.php	
			if(Module::$todo != "") { //아이프레임이라면				
				$TPL->defineTemplate("frame", Module::$module, Module::$module.".".Module::$todo.".htm");			
				
			} else {
				
				$TPL->defineTemplate("frame", "_global_search", "_frame.htm");
				$TPL->defineTemplate("top", "_global_search", "top.htm");
				$TPL->defineTemplate("sidemenu", "_global_search", "sidemenu.htm");
				$TPL->defineTemplate("sidebar", "_global", "sidebar.htm");	
				$TPL->defineTemplate("sidebar_search", "_global_search", "sidebar_search.htm");			
				$TPL->defineTemplate("middletop", "_global_search", "middletop.htm");				
				$TPL->defineTemplate("container", "_global_search", "container.htm");
				$TPL->defineTemplate("footer", "_global_search", "footer.htm");
				//$TPL->defineTemplate("etcscript", "_global", "_etcscript.htm");
				//$TPL->defineTemplate("mframe", Module::$module, "_frame.htm");		
				//$TPL->defineTemplate("loginlayer", "_global_layer", "login.htm");
				$TPL->defineTemplate("contents", Module::$module, "index.htm");			
			}
			break;
		

  
	case "manager" : // 페이지
		// 인덱스 및 일반페이지 (TPL_ID, SRC, FILENAME)
		$TPL->defineTemplate("frame", "_global_manager", "_frame.htm");
		$TPL->defineTemplate("top", "_global_manager", "top.htm");
		$TPL->defineTemplate("container", "_global_manager", "container.htm");
		$TPL->defineTemplate("footer", "_global_manager", "footer.htm");
		$TPL->defineTemplate("etcscript", "_global_manager", "_etcscript.htm");
		$TPL->defineTemplate("mframe", Module::$module, "_frame.htm");
		if(Module::$todo != "") {
			$TPL->defineTemplate("contents", Module::$module, Module::$module.".".Module::$todo.".htm");
		} else {
			$TPL->defineTemplate("contents", Module::$module, "index.htm");			
		}
		break;
	
	case "frame" : 
	default :
		// 인덱스 및 일반페이지 (TPL_ID, SRC, FILENAME)
		$TPL->defineTemplate("frame", "_global", "_frame.htm");
		$TPL->defineTemplate("top", "_global", "top.htm");
		//$TPL->defineTemplate("sidemenu", "_global", "sidemenu.htm");
		$TPL->defineTemplate("sidebar", "_global", "sidebar.htm");		
		$TPL->defineTemplate("container", "_global", "container.htm");
		$TPL->defineTemplate("footer", "_global", "footer.htm");
		$TPL->defineTemplate("etcscript", "_global", "_etcscript.htm");
		$TPL->defineTemplate("mframe", Module::$module, "_frame.htm");		
		$TPL->defineTemplate("loginlayer", "_global_layer", "login.htm");
		if(Module::$todo != "") {
			$TPL->defineTemplate("contents", Module::$module, Module::$module.".".Module::$todo.".htm");
		} else {
			$TPL->defineTemplate("contents", Module::$module, "index.htm");			
		}
		break;
}

/**
 * 템플릿최종변수셋팅
 */
$TPL->assignValue();

/**
 * 디자인프레임에 따른 페이지 출력
 */
switch($FRAME) {
	case "none" : // 템플릿출력안함
	case "ajax" : // AJAX처리
		break;
	case "popup" : // 팝업창	
	case "view" : // 뷰프레임	
	case "socialbar" : // 소셜바
	case "frame" :
	default :
		$TPL->print_("frame");
		break;
}

/**
 * 처리시간측정-종료
 */
$__eTime = Module::getMicroTime();
Module::runTimeMsg($__sTime, $__eTime);
Module::debugMsg();

/**
 * 버퍼내용출력
 */
//ob_end_flush();

/**
 * 종료
 */
Module::exitModule();
if(count($mysqli_connection_tmp) > 0) {
    unset($mysqli_connection_tmp);
	foreach($mysqli_connection_tmp as $key => $val) {
		unset($mysqli_connection_tmp[$key]);
	}
}

?>
