<?php
/***************************************************************************************
 * 페이스북 로그인 컨트롤러
 * 
 * 작성일 : 2011.07.22
 * 작성자 : 이종학
 * 히스토리 : 
 ***************************************************************************************/ 

 /**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $rememberMe;
// var
GLOBAL $SITE;
GLOBAL $FRAME;

$FRAME = "popup";
 
/**
 * CLASS
 */
$CLASS_COOKIE = &Module::singleton("Cookie"); 
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_CURL = &Module::singleton("Curl");
$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
$CLASS_AUTH = &Module::singleton("Auth.Auth");
$CLASS_LOGIN = &Module::singleton("Auth.Login");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_GRADE = &Module::singleton("User.Grade");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_REVIEW = &Module::singleton("Review.Review");
                                                                   

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");


/**
 * VAR / PROC
 */
$user = $CLASS_FACEBOOK->facebook->getUser(); // 이미 로그인 되었다면, 유저정보 추출가능.

// API 세션
$_SESSION['api_facebook_todo'] = Module::$param[0];
$_SESSION['api_facebook_param'] = Module::$param[1];
//|| $rememberMe->cookieIsValid($_SESSION['f_username'])
	 

if($user && $user != "0") {	
	try {
		$profile = $CLASS_FACEBOOK->facebook->api('/me'); // Facebook Return value set
		if(!empty($profile) && $CLASS_FACEBOOK->isLogin() == true) {				
			$field = $CLASS_FACEBOOK->getSessionField();
			$arr = array(); 
			$arr[] = $_SESSION[$field['code']]; // 페이스북코드
			$arr[] = $_SESSION[$field['access_token']]; // 페이스북토큰
			$arr[] = $_SESSION[$field['user_id']]; // 페이스북유저아이디
			$arr[] = $_SESSION[$field['state']]; // 페이스북상태값 FACEBOOK_KEY
			$DB->rConnect();
			$res[] = $DB->call("p_account_facebook_ins", $arr);		
			
			/***********  
			  * set rememberme cookie module
			***********/
				//session_regenerate_id();
				//$rememberMe->clearCookie($field['user_id']);

//			if(!empty($_SESSION['f_username'])) {
//				 // Check, if the Rememberme cookie exists and is still valid.
//				 // If not, we log out the current session
//			     // 쿠키 존재하고 아직 유효한지 체크한다! 
//			     // 만약 아니면... 우린 현재 세션에서 빠져나가분다!!!! 
//				if(!empty($_COOKIE[$rememberMe->getCookieName()]) && !$rememberMe->cookieIsValid($_SESSION['f_username'])) {
//					//** unset session of login cookie
//					//echo "로그인상태고, 쿠키 토큰 값이 달르다야!";
//					//echo $_COOKIE[$rememberMe->getCookieName()];
//					echo "Error occurd(s101:your valied time is exfired)";
//					//exit;					
//				}	
//
//			}  // If we are not logged in, try to log in via Rememberme cookie
//			   // 로그인 안했고!!!, 쿠키로 로그인 하려면이여! 
//             else {
//				    // 쿠키의 Triplet 일치한다면 True 반환 
//					 $loginresult = $rememberMe->login();
//					if($loginresult) {
//						$_SESSION['f_username'] = $loginresult; // 로그인 인정함.
//						// There is a chance that an attacker has stolen the login token, so we store
//						// the fact that the user was logged in via RememberMe (instead of login form)
//						// ** 그래도 혹시.. 너가 해커일지도 모르니까... 쿠키로 로그인됬다고 저장한다잉.
//						$_SESSION['remembered_by_cookie'] = true;						
//					  } else { // login process 
//						     // 토큰만 틀리다면 훔쳐간거지..
//							 if($rememberMe->loginTokenWasInvalid()) {
//							     // 쿠키 누가 훔쳐갔다잉!!
//							 }else{ // 고것도 아니면 첫 방문 or 쿠키삭제네 로그인 프로세스 태워줘야지..
//								// log in process 
////								 session_regenerate_id();
//								 //$rememberMe->clearCookie($user); // 혹시 기존에 값이 있으면 제거 해주장.
//								 $_SESSION['f_username'] = $user;  // f_username에 페북 userID(유니크한!)  세션 만들어주고! 
//								 $rememberMe->createCookie($user); //PHP_REMEMBERME에 FB userID(유니크한!),식별자,토큰 쿠키 만들어주기..ㅋㅋ, 나중엔 걍 fbuserid로 변경해야긋다..
//								 //$CLASS_COOKIE->set("user_fb_testvalue",1);
//							 }
//
//					  }	
//             }
		   




			switch($_SESSION['api_facebook_todo'])
			{
				case "loginLink" : 
					
					if($_SESSION['api_facebook_param'] == "1") $reload = true;
					
					$type = "F"; // 회원타입
					$userid = $profile['id']; // 레뷰아이디
					$name = $profile['name']; // 페이스북이름
					// 회원이 아닐 경우  가입폼	
					if($CLASS_USER->isUserID($DB, $userid, $type) == false && $CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
						$_SESSION['joinType'] = $type;
						$_SESSION['joinSNSKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "login");
						$script = "window.opener.document.location = '/join/sns' ;";
						Module::callScript($script);
						Module::close();
						Module::exitModule();
					}
					if($CLASS_USER->isUserID($DB, $userid, $type) == true) {
						// 회원정보
						$userInfo = $CLASS_USER->getUserByID($DB, $userid, $type); //Ru_account
						$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']); //Ru_account_extra
						$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']); //Ru_account_stats
						$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2); //Ru_account_blog , flag_activated = '1'
						$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2); //Ru_frontier_entry a, Ru_frontier_binfo b  a.win = '1'
						$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2); //Ru_frontier_entry a, Ru_frontier_binfo b a.win = '0'
						$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']); //Ru_account_cash
						$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']); //Ru_account_point
						// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
						$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
						$userInfo['cash'] = number_format($cashInfo['cash']);
						$userInfo['point'] = number_format($pointInfo['point']);
						$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
						$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
						$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
						// 세션(Login Pro)		
						$CLASS_LOGIN->setSnsLoginSession($userInfo); // Facebook Session값을 제거해버리는 에러 확인 2012.08.22 => setFbSession으로 변경(세션초기화기능 제거본)
						$CLASS_LOGIN->addSession($extraInfo);
						$CLASS_LOGIN->addSession($statsInfo);
						$CLASS_LOGIN->addSession($blogInfo);
						$CLASS_LOGIN->addSession($frontierInfo1);
						$CLASS_LOGIN->addSession($frontierInfo2);
						//리멤버미 DB저장, 쿠키생성 
						$rememberMe->createCookie_sns($userid,"FB");

						// 회원이미지 ?type = square | small | normal | large
						$_SESSION['userimage'] = "https://graph.facebook.com/".$profile['id']."/picture?type=square";
						// 등급업데이트
						$arr = array();
						$arr[] = $userInfo['userno'];
						$arr[] = $userInfo['grade'];
						$DB->rConnect();
						$res[] = $DB->call("p_account_grade_upd", $arr);
						// 로그인포인트지급
						if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
							$arr = array();
							$arr[] = $userInfo['userno'];
							$arr[] = "0"; // 지급 
							$arr[] = "101"; // 유효로그인(101) 
							$arr[] = ""; // 리뷰번호
							$DB->rConnect();
							$res[] = $DB->call("p_point_ins", $arr);
						}
						// 로그인시간업데이트
						$arr = array();
						$arr[] = $userInfo['userno'];
						$arr[] = "FI"; // 로그인타입 
						$DB->rConnect();
						$res[] = $DB->call("p_account_login_upd", $arr);
						// 결과	
						$loginArr['login_result'] = "Y";
						// 페이스북 로그아웃 url
						$_SESSION['logout_url'] = $CLASS_FACEBOOK->facebook->getLogoutUrl();
					} else {
						$loginArr['login_result'] = "N";
					}
					$loginArr['login_type'] = $type."I";
					// 로그인 로그
					$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $loginArr);					
					if($loginArr['login_result'] == "Y") {
						if($reload == true) {
							$script = "var url = window.opener.document.URL; opener.document.location = url;";
						} else {
							$script = "window.opener.loginFlag['R'] = '1';";
							$script .= "window.opener.socialbar.turnIcon('R', 'on');";
							$script .= "window.opener.socialbar.setIcon();";				
							$script .= "window.opener.common.closeLayer('loginlayer');";
						}	
						Module::callScript($script);
						Module::close();
					} else {
						Module::close("페이스북 연동 로그인이 실패하였습니다.");
					}
					break; 

				case "login" : 
					
					if($_SESSION['api_facebook_param'] == "1") $reload = true;
					
					$type = "F"; // 회원타입
					$userid = $profile['id']; // 레뷰아이디
					$name = $profile['name']; // 페이스북이름
					// 1) We need to Check linked revu account via authed facebook account
					// 2) If its exist, do revu login process and actavite facebook account

					// 3) If its not exist, do default module
					
					if($CLASS_USER->isUserLinkID($DB, $profile['id'],$type)==true){
						//Do revu login process and activate sns account(fb,twit)
						// 회원정보(first step is to get revu account via facebook account)
						$userInfo = $CLASS_USER->getUserRelationByID($DB, $profile['id'], $type); //relation-Information > revu account

						$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']); //Ru_account_extra
						$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']); //Ru_account_stats
						$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2); //Ru_account_blog , flag_activated = '1'
						$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2); //Ru_frontier_entry a, Ru_frontier_binfo b  a.win = '1'
						$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2); //Ru_frontier_entry a, Ru_frontier_binfo b a.win = '0'
						$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']); //Ru_account_cash
						$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']); //Ru_account_point
						// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
						$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
						$userInfo['cash'] = number_format($cashInfo['cash']);
						$userInfo['point'] = number_format($pointInfo['point']);
						$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
						$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
						$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
						// 세션(Login Pro)		
						$CLASS_LOGIN->setSnsLoginSession($userInfo); // Facebook Session값을 제거해버리는 에러 확인 2012.08.22 => setFbSession으로 변경(세션초기화기능 제거본)
						$CLASS_LOGIN->addSession($extraInfo);
						$CLASS_LOGIN->addSession($statsInfo);
						$CLASS_LOGIN->addSession($blogInfo);
						$CLASS_LOGIN->addSession($frontierInfo1);
						$CLASS_LOGIN->addSession($frontierInfo2);		
						$_SESSION["fb_nickname"] = $profile["name"];
						if($userInfo["twit_relation"] > 0){
							//get twit information on twit db
							$relationTwitInform = $CLASS_USER->getUserTwitLogInformByID($DB, $userInfo["twit_relation"]);	
							$arrRelationTwit = array("oauth_token"=>$relationTwitInform["oauth_token"],"oauth_token_secret"=>$relationTwitInform["oauth_token_secret"],"user_id"=>$relationTwitInform["user_id"],"screen_name"=>$relationTwitInform["screen_name"]);
							$_SESSION['access_token'] = $arrRelationTwit;	
							
							$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
							$content_object = $connection->get('account/verify_credentials');
							$content = get_object_vars($content_object);
							$_SESSION['twit_nickname'] = $content['name']; // 트위터이름		
   					    }
						//리멤버미 DB저장, 쿠키생성 
						$rememberMe->createCookie_sns($userid,"FB");

						// 회원이미지 ?type = square | small | normal | large
						$_SESSION['userimage'] = "https://graph.facebook.com/".$profile['id']."/picture?type=square";
						// 등급업데이트
						$arr = array();
						$arr[] = $userInfo['userno'];
						$arr[] = $userInfo['grade'];
						$DB->rConnect();
						$res[] = $DB->call("p_account_grade_upd", $arr);
						// 로그인포인트지급
						if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
							$arr = array();
							$arr[] = $userInfo['userno'];
							$arr[] = "0"; // 지급 
							$arr[] = "101"; // 유효로그인(101) 
							$arr[] = ""; // 리뷰번호
							$DB->rConnect();
							$res[] = $DB->call("p_point_ins", $arr);
						}
						// 로그인시간업데이트
						$arr = array();
						$arr[] = $userInfo['userno'];
						$arr[] = "FI"; // 로그인타입 
						$DB->rConnect();
						$res[] = $DB->call("p_account_login_upd", $arr);
						// 결과	
						$loginArr['login_result'] = "Y";
						// 페이스북 로그아웃 url
						$_SESSION['logout_url'] = $CLASS_FACEBOOK->facebook->getLogoutUrl();
					}else{ // 1)FB 연결된 레뷰 계정 없음,  2)기존 SNS 회원

						// 회원이 아닐 경우  가입폼	
						if($CLASS_USER->isUserID($DB, $userid, $type) == false && $CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
							$_SESSION['joinType'] = $type;
							$_SESSION['joinSNSKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "login");
							$script = "window.opener.document.location = '/join/sns' ;";
							Module::callScript($script);
							Module::close();
							Module::exitModule();
						 }
						
						if($CLASS_USER->isUserID($DB, $userid, $type) == true) {
							// 회원정보
							$userInfo = $CLASS_USER->getUserByID($DB, $userid, $type); //Ru_account
							$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']); //Ru_account_extra
							$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']); //Ru_account_stats
							$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2); //Ru_account_blog , flag_activated = '1'
							$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2); //Ru_frontier_entry a, Ru_frontier_binfo b  a.win = '1'
							$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2); //Ru_frontier_entry a, Ru_frontier_binfo b a.win = '0'
							$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']); //Ru_account_cash
							$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']); //Ru_account_point
							// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
							$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
							$userInfo['cash'] = number_format($cashInfo['cash']);
							$userInfo['point'] = number_format($pointInfo['point']);
							$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
							$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
							$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
							// 세션(Login Pro)		
							$CLASS_LOGIN->setSnsLoginSession($userInfo); // Facebook Session값을 제거해버리는 에러 확인 2012.08.22 => setFbSession으로 변경(세션초기화기능 제거본)
							$CLASS_LOGIN->addSession($extraInfo);
							$CLASS_LOGIN->addSession($statsInfo);
							$CLASS_LOGIN->addSession($blogInfo);
							$CLASS_LOGIN->addSession($frontierInfo1);
							$CLASS_LOGIN->addSession($frontierInfo2);
							//리멤버미 DB저장, 쿠키생성 
							$rememberMe->createCookie_sns($userid,"FB");

							// 회원이미지 ?type = square | small | normal | large
							$_SESSION['userimage'] = "https://graph.facebook.com/".$profile['id']."/picture?type=square";
							// 등급업데이트
							$arr = array();
							$arr[] = $userInfo['userno'];
							$arr[] = $userInfo['grade'];
							$DB->rConnect();
							$res[] = $DB->call("p_account_grade_upd", $arr);
							// 로그인포인트지급
							if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
								$arr = array();
								$arr[] = $userInfo['userno'];
								$arr[] = "0"; // 지급 
								$arr[] = "101"; // 유효로그인(101) 
								$arr[] = ""; // 리뷰번호
								$DB->rConnect();
								$res[] = $DB->call("p_point_ins", $arr);
							}
							// 로그인시간업데이트
							$arr = array();
							$arr[] = $userInfo['userno'];
							$arr[] = "FI"; // 로그인타입 
							$DB->rConnect();
							$res[] = $DB->call("p_account_login_upd", $arr);
							// 결과	
							$loginArr['login_result'] = "Y";
							// 페이스북 로그아웃 url
							$_SESSION['logout_url'] = $CLASS_FACEBOOK->facebook->getLogoutUrl();
						} else {
							$loginArr['login_result'] = "N";
						}
					}
					
					$loginArr['login_type'] = $type."I";
					// 로그인 로그
					$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $loginArr);					
					if($loginArr['login_result'] == "Y") {
						if($reload == true) {
							$script = "var url = window.opener.document.URL; opener.document.location = url;";
						} else {
							$script = "window.opener.loginFlag['R'] = '1';";
							$script .= "window.opener.socialbar.turnIcon('R', 'on');";
							$script .= "window.opener.socialbar.setIcon();";				
							$script .= "window.opener.common.closeLayer('loginlayer');";
						}	
						Module::callScript($script);
						Module::close();
					} else {
						Module::close("페이스북 연동 로그인이 실패하였습니다.");
					}
					break; 

				case "wall" :
					$review = $CLASS_REVIEW->getReview($DB, $_SESSION['api_facebook_param']);
					if($review['rno'] == "") {
						Module::close("리뷰가 존재 하지 않습니다.");
					}
					$review['title'] = $BASE->strLimitUTF($review['title'], 70, false, "...");
					
					$logoutUrl = $CLASS_FACEBOOK->facebook->getLogoutUrl();	
					
					// 회원정보
					$userid = $profile['id']; // 레뷰아이디
					$name = $profile['name']; // 페이스북이름
					
					$url = "http://"._DOMAIN."/".$_SESSION['api_facebook_param'];	
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
						Module::close("짧은URL 연동이 실패하였습니다. 다시 시도하세요.");
					}
					/*
					try {
						$CLASS_FACEBOOK->facebook->api("/".$user."/feed?access_token=".$_SESSION[$field['access_token']], "POST", 
						array("access_token"=>$_SESSION[$field['access_token']], "message" => "안녕하세요!!!"));	
					} catch (FacebookApiException $e) {
						Module::close("페이스북 연동이 실패하였습니다.");
					} 
					*/
					break; 
				case "logout" : 
					$CLASS_FACEBOOK->initSession();
				    // Cookie clear...need
					// linkoff function need to db 
					Module::close();
					break;
					
				case "slogin" :				
					//$script = "window.opener.document.location.reload();";
					$script = "window.opener.loginFlag['F'] = '1';";
					$script .= "window.opener.socialbar.turnIcon('F', 'on');";
					$script .= "window.opener.socialbar.setIcon();";
					Module::callScript($script);
					Module::close();
					break;

				case "slogout" : 
					//$CLASS_TWITTER->initSession();
				    $CLASS_FACEBOOK->initSession();
					//$script = "window.opener.document.location.reload();";
					$script = "window.opener.loginFlag['F'] = '';";
					$script .= "window.opener.socialbar.turnIcon('F', 'off');";
					$script .= "window.opener.socialbar.setIcon();";		
					Module::callScript($script); 
					Module::close();
					break;
				 case "slinkOn" :	
					
					// 1) Get login cookie
				    // 2) Search triplet
					// 3) If exist data update twittID by loginID					
					
					if(!$rememberMe->cookieIsValid($_SESSION["userid"])){					
						//리멤버미 DB저장, 쿠키생성 					
						$rememberMe->createCookie_sns($_SESSION["fb_".FACEBOOK_KEY."_user_id"],"RFB",$_SESSION["userid"]);
					}else{
						$loginresult = $rememberMe->loginfb($_SESSION["fb_".FACEBOOK_KEY."_user_id"]);
						if($loginresult) {							
							// 1)There is a chance that an attacker has stolen the login token, so we store
							// the fact that the user was logged in via RememberMe (instead of login form)						
							 $_SESSION['f_remembered_by_cookie'] = true;						
						 } else { 

						 }	
					}
								  
					 Module::close();
				break;
				
				case "slinkOff" :
					// If twitt-link is off, clear cookie
				    if($_SESSION['access_token']['user_id'] == ""){
						$rememberMe->clearCookie(true);
					}else{
						// Update cookie as facebook infotm to delete
						$loginresult = $rememberMe->loginfb();
					}
				       //  2) unset session of facebook
				    $CLASS_FACEBOOK->initSession_slink();
					Module::close();					
				break; 

				 case "snsLinkOn" :						
				    // 1) Find that FB account is in revu DB
					// 2) If it's not, Find link-sns-account by FBSESSION_ID
					// 3) If it's not, Update FB field to authed FB-account
					$type = "F"; // 회원타입
					$userid = $profile['id']; // 레뷰아이디
					$name = $profile['name']; // 페이스북이름
					if($CLASS_USER->isUserID($DB, $userid, $type) == false && $CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
						if($CLASS_USER->isUserLinkID($DB, $userid,$type)==false){
							// Do about update process of fb field	
//							echo $_SESSION['userno']."</br>";
//							echo  $userid;
							$arr = array();
							$arr[] = $_SESSION['userno'];
							$arr[] = $userid;
							$DB->rConnect();
							$res[] = $DB->call("p_account_fb_upd", $arr);	
							$_SESSION["fb_nickname"] = $profile['name'];
						}else{
							Module::close("이미 연결된 계정입니다.(code:2)");
						}
					}else{
						$CLASS_FACEBOOK->initSession_slink();
						Module::close("기존 페이스북 가입계정은 연결하기 기능을 사용하실수없습니다. 페이스북 계정으로 로그인 후 탈퇴 후 다시 연결하기 기능을 이용해주세요 (code:1)");
					}	
					
					$script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);
					Module::close();
				break;

				case "snsLinkOff" :
					// 1) Find row has linked fb-relation field in FB-SESSION-USERID
				    // 2) Update fb-relation field to 0
					// 3) Init FB-SESSION
					$type = "F"; // 회원타입
					if($CLASS_USER->isUserLinkID($DB, $profile['id'], $type)==true){
						// Update fb-relation field to 0(init process)
						$arr = array();
						$arr[] = $_SESSION['userno'];
						$arr[] = 0;
						$DB->rConnect();
						$res[] = $DB->call("p_account_fb_upd", $arr);
						// Update opengraph value to 0
						$arr = array();
						$arr[] = $_SESSION['userno'];
						$arr[] = "0";
						$DB->rConnect();
						$res[] = $DB->call("p_account_fb_opengraph_ins", $arr);	

						$CLASS_FACEBOOK->initSession_slink();
					}else{
						Module::close("연결된 계정이 아닙니다.");
					}
					$script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);
					Module::close();					
				break; 

				case "fbGraphOn" :
					
					// Update the state of OpenGraph to 1
					// Check UserSessionID
					// If exixt DO about DB update process 
					// else alert("You accepted the worng way, try again it") and go to main Activity
					$type = "F"; // 회원타입
					if($CLASS_USER->isUserLinkID($DB, $profile['id'], $type)==true){
						if($_SESSION['userno']){						
							$arr = array();
							$arr[] = $_SESSION['userno'];
							$arr[] = 1;
							$DB->rConnect();
							$res[] = $DB->call("p_account_fb_opengraph_ins", $arr);	
							
						}else{
							$CLASS_FACEBOOK->initSession_slink();
							Module::close("잘못된 방법으로 접근하셨습니다.다시 시도해주세요.");
						}	
					}else{
						$CLASS_FACEBOOK->initSession_slink();
						Module::close("페이스북 연결하기 활성화 이후, 타임라인 연동을 해주세요");
					}
					
						
					$script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);
					Module::close();					
				break;

				case "fbGraphOff" :
					// Do Update GraphOff to 0 
					if($_SESSION['userno']){
						$arr = array();
						$arr[] = $_SESSION['userno'];
						$arr[] = "0";
						$DB->rConnect();
						$res[] = $DB->call("p_account_fb_opengraph_ins", $arr);	
					}else{
						Module::close("잘못된 방법으로 접근하셨습니다.다시 시도해주세요.");
					}
					
                    $script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);
					Module::close();					
				break;

				


				default : 
					break;
			}
		} else {
			Module::redirect($CLASS_FACEBOOK->loginURL);
		}		
	} catch (FacebookApiException $e) {
		Module::close("페이스북 회원정보가 없습니다.");
		//error_log($e);
		//$user = null;
	}
} else {
//	echo "없음";
//	break;	
	Module::redirect($CLASS_FACEBOOK->loginURL);
}

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"todo"=>$_SESSION['api_facebook_todo'],
	"review"=>$review,
	"bitlyData"=>$bitlyData,
	"userid"=>$userid,
	"name"=>$name,
	"logoutUrl"=>$logoutUrl, 
));
?>
