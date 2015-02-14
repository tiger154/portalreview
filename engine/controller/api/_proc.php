<?php
/***************************************************************************************
 * 레뷰 API컨트롤러
 * 
 * 작성일 : 2011.11.30
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
$CLASS_CURL = &Module::singleton("Curl");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_REVIEW = &Module::singleton("Review.Review");
$CLASS_REVIEWTALK = &Module::singleton("Review.ReviewTalk");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$jsonArr = array();

/**
 * TODO
 */
switch(Module::$todo)
{		
	/**
	 * 짧은 URL처리
	 */
	case "bitly.shorten.url.proc" :
		$FRAME = "ajax";
		$CLASS_CURL->init(BITLY_SHORTEN_URL, "POST");
		$CLASS_CURL->setAutoReferer();
		$CLASS_CURL->addPostParameter(new CurlPostParameter('login', BITLY_ID));
		$CLASS_CURL->addPostParameter(new CurlPostParameter('apiKey', BITLY_APIKEY));
		$CLASS_CURL->addPostParameter(new CurlPostParameter('longUrl', $_POST['longurl']));
		$CLASS_CURL->addPostParameter(new CurlPostParameter('format', 'json'));	
		$result = $CLASS_CURL->execute();
		$CLASS_CURL->close();
		$jsonArr['result'] = json_decode($result->ResposeBody);
		$jsonArr['callback'] = $_POST['callback'];
		break;
	
	/**
	 * 트위터 - 로그인(세션체크)
	 */
	case "twitter.islogin.proc" :
		$FRAME = "ajax";
		if($_SESSION['access_token']['user_id'] == "") {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
			$jsonArr['todo'] = $_POST['todo'];
			$jsonArr['param'] = $_POST['param'];
		}
		break; 
	
	/**
	 * 트위터 - 세션초기화
	 */
	case "twitter.session.init.proc" :		
		$FRAME = "ajax";
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		$CLASS_TWITTER->initSession();
		$jsonArr['result'] = "success";
		break; 
	
	/**
	 * 트위터 - 트윗정보
	 */
	case "twitter.tweet.info.proc" :
		$FRAME = "ajax";
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		if($_SESSION['access_token']['user_id'] == "") {
			$jsonArr['result'] = "fail";
		} else {			
			$review = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
			if($review['rno'] == "") {
				$jsonArr['result'] = "review";
				break;
			}
			$url = "http://"._DOMAIN."/".$_POST['rno'];	
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
				$jsonArr['result'] = "shorten";
				break;
			}
			$jsonArr['result'] = "success";
			$jsonArr['rno'] = $_POST['rno'];
			$jsonArr['title'] = $review['title'];
			$jsonArr['url'] = $bitlyData['url'];
		}
		break; 
	
	/**
	 * 트위터 - 트윗등록
	 */
	case "twitter.tweet.proc" :
		$FRAME = "ajax";
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		if($_SESSION['access_token']['user_id'] == "") {
			$jsonArr['result'] = "session";
			break;
		}		
		if($CLASS_TWITTER->isUser($DB, $_SESSION['access_token']['user_id']) == false){
			$jsonArr['result'] = "nouser";
			break;
		} 
		$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
		$connection->post('statuses/update', array('status' => $_POST['msg']));		
		$jsonArr['rno'] = $_POST['rno'];
		if($connection->http_code == 200) {
			$jsonArr['result'] = "success";
			//$CLASS_TWITTER->initSession();
		} else {
			$jsonArr['result'] = "fail";
		}
		break; 
	
	/**
	 * 페이스북 담벼락등록
	 */
	case "facebook.wall.proc" :
		$FRAME = "ajax";
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
		$user = $CLASS_FACEBOOK->facebook->getUser();
		if($user == "") {
			$jsonArr['result'] = "nouser";
			break;
		}
		$field = $CLASS_FACEBOOK->getSessionField();		
		if($CLASS_FACEBOOK->isLogin($DB, $_SESSION[$field['user_id']]) == false){
			$jsonArr['result'] = "session";
			break;
		} 		
		try {
			$CLASS_FACEBOOK->facebook->api("/".$user."/feed?access_token=".$_SESSION[$field['access_token']], "POST", 
			array("access_token"=>$_SESSION[$field['access_token']], "message" =>$_POST['msg']));
			$jsonArr['result'] = "success";			
			$CLASS_FACEBOOK->initSession();	
		} catch (FacebookApiException $e) {
			$jsonArr['result'] = "fail";
		}
		break; 
	/**
	 * 검색모듈.친구타입 확인
	 */
	case "search.friend.type.proc" :
		$CLASS_SEARCH		= &Module::singleton("Api.Search");
		$FRAME = "ajax";		
		$ftype = $CLASS_SEARCH->SearchFrendType($DB, $_POST['userno'],  $_POST['fuserno']);
		$jsonArr['result'] = $ftype;
		$jsonArr['userno'] = $_POST['userno'];
		$jsonArr['fuserno'] =  $_POST['fuserno'];
		//echo $_POST['userno'];
		break;	
	/**
	 * 디폴트
	 */
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		 
		break;
		
}

/**
 * AJAX OUTPUT 
 */

if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}

/**
 * MODULE & DB CONNECT CLOSE
 */
Module::exitModule();
?>