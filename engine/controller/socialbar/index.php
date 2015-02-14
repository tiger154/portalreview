<?php
 /***************************************************************************************
 * 리뷰-소셜바컨트롤러
 * 
 * 작성일 : 2011.12.14
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
$CLASS_COOKIE = &Module::singleton("Cookie");
$CLASS_CURL = &Module::singleton("Curl");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
$CLASS_REVIEWTALK = &Module::singleton("Review.ReviewTalk");
$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
// 모듈명이 리뷰일련번호
$rno = Module::$module;
if($CLASS_REVIEW->isReviewByRno($DB, $rno) != true) {
	Module::redirect("notpage");
} else {	
	$url = "http://"._DOMAIN."/".$rno;	
	$CLASS_CURL->init(BITLY_SHORTEN_URL, "POST");
	$CLASS_CURL->setAutoReferer();
	$CLASS_CURL->addPostParameter(new CurlPostParameter('login', BITLY_ID));
	$CLASS_CURL->addPostParameter(new CurlPostParameter('apiKey', BITLY_APIKEY));
	$CLASS_CURL->addPostParameter(new CurlPostParameter('longUrl', $url));
	$CLASS_CURL->addPostParameter(new CurlPostParameter('format', 'json'));
	$result = $CLASS_CURL->execute();
	$CLASS_CURL->close();
	$bitly = get_object_vars(json_decode($result->ResposeBody));
	$bitlyData = get_object_vars($bitly['data']);
	if($bitly['status_code'] != 200) {
		$shortUrl = $url;
	} else {
		$shortUrl = $bitlyData['url'];
	}
	$review = $CLASS_REVIEW->getReview($DB, $rno);
	$user = $CLASS_USER->getUser($DB, $review['userno']);
		
	$review['cate'] = $CLASS_CODE->transCateArray($review['cate1'],$review['cate2'],$review['cate3'],$review['cate4']);
	$review['catedesc'] = $CLASS_CODE->getCateDesc($DB, $review['cate']);
		
	$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($DB, date("Y-m-d"));
	$review['wno'] = $CLASS_REVIEWBEST->getBestWeekPrev($DB, $wno_now);
	$review['flag_cand'] = $CLASS_REVIEWBEST->isBestCandReview($DB, $review['wno'], $review['rno']);
	if($review['flag_cand'] == true) {
		$cand = $CLASS_REVIEWBEST->getBestCandReview($DB, $review['wno'], $review['rno']);
		$review['best_recom_cnt'] = $cand['recom_cnt'];
	}
	if($review['type'] == "R") {
		$review['url'] = "http://"._DOMAIN."/review/frame/".$review['rno'];
	}
	$review['title'] = $BASE->strLimitUTF(strip_tags($review['title']), 70, false, '...');	
	$review['surl'] = "http://"._DOMAIN."/".$review['rno'];
	
	// 레뷰로그인체크
	$login = array();
	$login['R'] = ($_SESSION['userno'] != "") ? true : false;
	$login['T'] = ($_SESSION['access_token']['user_id'] != "") ? true : false;
	
	// 리뷰 썸네일 추출 by revu 2012.09.19	
	$_file = $CLASS_REVIEW->getReviewFile($DB, $review['rno'], "T"); // 썸네일 가져오기
	if($review['rid'] == ""){ //리뉴얼 이후 이미지		
		$review['thumbimage_url'] = $CLASS_REVIEW->getThumbimage($_file[0]['filename'], $review['regdate'], "110");
	} else { // 리뉴얼 이전 이미지 
		$review['thumbimage_url'] = $CLASS_REVIEW->getThumbimageOld($_file[0]['filename'], $review['regdate'], $review['rid']);
	}
   if($_file[0]['filename'] == ""){
		$review['thumbimage_url'] = "http://www.revu.co.kr/images/revu.png";
   }
/********
 *@ 쿠키 체크 및 페이스북 세션 확인 모듈 
 *
*****/					
//function rememberAutoload($class) {
//  require _DIR_EXTENDS.'/php.Rememberme/src/'.strtr($class,'_',DIRECTORY_SEPARATOR).".php";
//}
//spl_autoload_register("rememberAutoload");

/**
 * Remember me Object
 */
//$db_opt_tmp = array ("tableName"=>"Ru_rememberme","credentialColumn"=>"credential","tokenColumn"=>"token","persistentTokenColumn"=>"persistent_token","expiresColumn"=>"expires");
//$mysqli_connection_tmp = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");
//$rPDO = new Rememberme_Storage_PDO($db_opt_tmp);
//$rPDO->setConnection($mysqli_connection_tmp);
//$rememberMe = new Rememberme($rPDO);


//if(!empty($_SESSION['f_username'])) {
//	// 로그인 상태이므로 아무처리 안함.
//	//echo 3;
//}else{
//	$loginresult = $rememberMe->login();
//	
//	if($loginresult) {
//		$_SESSION['f_username'] = $loginresult; // 로그인 인정함.
//		// There is a chance that an attacker has stolen the login token, so we store
//		// the fact that the user was logged in via RememberMe (instead of login form)
//		// ** 그래도 혹시.. 너가 해커일지도 모르니까... 쿠키로 로그인됬다고 저장한다잉.
//		$_SESSION['remembered_by_cookie'] = true;
//		//echo 1;
//	  } else {	
//		 // 1) not social login 2) guest 3) logout 
//		//echo 2;
//	  }
//}
//
////echo $_COOKIE[$rememberMe->getCookieName()];
///* FB connect status check, If not conneceted , we reset to session from db information*/
//if ($CLASS_FACEBOOK->isLogin() == false){ // 페이스북 로그인 실패하면
//	 if($rememberMe->getCookieName()){  // 쿠키값이 있다면..
//		 $Cookietemp = explode("|",  $_COOKIE[$rememberMe->getCookieName()]); // 쿠키값을 가져온다.
//		if($CLASS_FACEBOOK->isUser($DB,$Cookietemp["0"])){ // DB에 UserID 접속 정보가 있다면. 
//			 $f_row = $CLASS_FACEBOOK->getUser($DB,$Cookietemp["0"]);
//			 $field = $CLASS_FACEBOOK->getSessionField();
//			 // reset session value
//			 $_SESSION[$field['code']] = $f_row["code"]; // 페이스북코드
//			 $_SESSION[$field['access_token']] = $f_row["access_token"]; // 페이스북토큰
//			 $_SESSION[$field['user_id']] = $f_row["user_id"]; // 페이스북유저아이디
//			 $_SESSION[$field['state']] = $f_row["state"]; // 페이스북상태값
//		}
//	  }else{
//	    // 1) not social login 2) guest 3) logout   
//	  }
//}else{
////  echo 2;
//}
$login['F'] = ($CLASS_FACEBOOK->isLogin() == true) ? true : false;

//print_r($_COOKIE);
//echo $Cookietemp[0];



  // print_r($_COOKIE);	
//print_r($_SESSION);	

 //***************** 페이스북 with 로그인 체크 모듈 (기본 60일) 2012.08.22 *****************
//
//    $user = $CLASS_FACEBOOK->facebook->getUser(); // 이미 로그인 되었다면, 유저정보 추출가능.
// 
//	if ($user) {
//	  try {
//		// Proceed knowing you have a logged in user who's authenticated.
//		//$user_profile = $facebook->api('/me');
//	    $login['FFFF'] = $user;
//	  
//	  } catch (FacebookApiException $e) {
//		//error_log($e);
//		//$user = null;
//	  }
//	}
//	else {
//		$login['FFFF'] = $false;
//		//	  $fbUrl = $facebook->getLoginUrl(array('scope' => 'read_stream, publish_stream, offline_access'));
//		//	  header("Location:".$fbUrl);
//		//	  exit();
//	}

 /**************************************************************/







	// 디폴트 선택체크
	if($CLASS_COOKIE->is("cookieSocialIcon") == true) {
		if($login[$CLASS_COOKIE->get("cookieSocialIcon")] == true) {
			$iconType = $CLASS_COOKIE->get("cookieSocialIcon");
		}
	}
	
	// 댓글리스트
	$talk = $CLASS_REVIEWTALK->getTalkList($DB, $review['rno'], $num=15, $flag_del="0", $tno="");
	for($i=0; $i<sizeof($talk); $i++) {
		$talk[$i]['ref'] =  $CLASS_REVIEWTALK->transRef($talk[$i]['type'], $talk[$i]['nickname']);
		$talk[$i]['icon'] =  $CLASS_REVIEWTALK->transIcon($talk[$i]['type']);
	}
	//$tno = $CLASS_REVIEWTALK->getTalkNextTno($DB, $review['rno'], $flag_del="0", $talk[sizeof($talk)-1]['tno']);
	$tno = $talk[sizeof($talk)-1]['tno'];
	
	// 다음토크
	$_tno = $CLASS_REVIEWTALK->getTalkNextTno($DB, $review['rno'], $flag_del="0", $tno);	
	if($_tno == "") $tno = ""; 
	
	// 마지막댓글
	$talklast = $CLASS_REVIEWTALK->getTalkLast($DB, $review['rno']);	
	
	// 조회수 업데이트
	$arr = array();
	$arr[] = $review['rno'];
	$arr[] = $_SESSION['userno'];
	$res[] = $DB->call("p_review_view_cnt_upd", $arr);
	$DB->rConnect();
			
	// 리뷰조회 포인트지급
	if($_SESSION['userno'] != "") {
		$arr = array();
		$arr[] = $_SESSION['userno'];
		$arr[] = "0"; // 지급 
		$arr[] = "306"; // 리뷰조회(306) 
		$arr[] = $review['rno']; // 리뷰번호
		$res[] = $DB->call("p_point_ins", $arr);
		$DB->rConnect();
	}
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"shortUrl"=>$shortUrl,
	"rno"=>$rno,
	"review"=>$review, 
	"talk"=>$talk,
	"talklast"=>$talklast,
	"tno"=>$tno, 
	"user"=>$user,
	"login"=>$login,
	"cate"=>$cate, 
	"catedesc"=>$catedesc, 
	"iconType"=>$iconType, 
	"title"=>$review['title'],
));
?>