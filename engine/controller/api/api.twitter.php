<?php
/***************************************************************************************
 * 트위터컨트롤러
 * 
 * 작성일 : 2011.12.02
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
$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
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
// callback 페이지
if(!empty($_REQUEST['oauth_verifier'])) {
	// 트위터 토큰 얻은 후 정보 저장(SESSION,DB) 
	$connection = $CLASS_TWITTER->getAccessToken($DB); //엑세스 토큰 가져온후 DB저장, SESSION 생성
	//if (200 == $connection->http_code) {
	if ($connection != false) {
		if($CLASS_TWITTER->isResource() == true) { // SESSION 존재시, Revu기본 모듈로 이동

			// 인증후 처리페이지 리다이렉트
			$param = "";
			$param .= ($_SESSION['api_twitter_todo'] != "") ? "/".$_SESSION['api_twitter_todo'] : "";
			$param .= ($_SESSION['api_twitter_param'] != "") ? "/".$_SESSION['api_twitter_param'] : ""; 			
			Module::redirect("/api/twitter".$param);
		} else {
			$CLASS_TWITTER->initSession();
			Module::alert("트위터 리소스정보가 없습니다. 다시 시도 하시길 바랍니다.");
			Module::close();
		}
	} else {
		Module::alert("트위터 인증이 실패하였습니다. 다시 시도 하시길 바랍니다.");
		Module::close();
	}
} else {
	// API 리소스 세션
	$_SESSION['api_twitter_todo'] = Module::$param[0];
	$_SESSION['api_twitter_param'] = Module::$param[1];
	
	if($_SESSION['access_token']['user_id'] == "") {
		$connection = $CLASS_TWITTER->getRequestToken(); // 요청토큰 가져오기
		switch ($connection->http_code) { // 정상적으로 가져왔을시 Access토큰 가져오기 모듈로 이동
			case 200:
				$url = $connection->getAuthorizeURL($_SESSION['oauth_token']);
				Module::redirect($url);
				break;
			default:
				Module::alert("트위터 접속이 실패하였습니다. 다시 시도 하시길 바랍니다.");
				Module::close();
				break;
		}
	} else {
		if($CLASS_TWITTER->isUser($DB, $_SESSION['access_token']['user_id']) == true) {									
			$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);	
			
			/***
			 * SNS 통합 로그인 모듈 삽입 예정 부분 2012.08.25 
			***/
//			if(!empty($_SESSION['t_username'])) {
//				 // Check, if the Rememberme cookie exists and is still valid.
//				 // If not, we log out the current session
//			     // 쿠키 존재하고 아직 유효한지 체크한다! 
//			     // 만약 아니면... 우린 현재 세션에서 빠져나가분다!!!!
//				if(!empty($_COOKIE[$rememberMe->getCookieName()]) && !$rememberMe->cookieIsValid($_SESSION['t_username'])) {
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
//						$_SESSION['t_username'] = $loginresult; // 로그인 인정함.
//						// There is a chance that an attacker has stolen the login token, so we store
//						// the fact that the user was logged in via RememberMe (instead of login form)
//						// ** 그래도 혹시.. 너가 해커일지도 모르니까... 쿠키로 로그인됬다고 저장한다잉.
//						$_SESSION['t_remembered_by_cookie'] = true;						
//					  } else { // login process 
//						     // 토큰만 틀리다면 훔쳐간거지..
//							 if($rememberMe->loginTokenWasInvalid()) {
//							     // 쿠키 누가 훔쳐갔다잉!!
//							 }else{ // 고것도 아니면 첫 방문 or 쿠키삭제네 로그인 프로세스 태워줘야지..
//								// log in process 
////								 session_regenerate_id();
//								 //$rememberMe->clearCookie($user); // 혹시 기존에 값이 있으면 제거 해주장.
//								 $_SESSION['t_username'] = $_SESSION['access_token']['user_id'];  // t_username에 트윗 userID(유니크한!)  세션 만들어주고! 
//								 $rememberMe->createCookie($_SESSION['access_token']['user_id']); //PHP_REMEMBERME에 Twit userID(유니크한!),식별자,토큰 쿠키 만들어주기..ㅋㅋ, 나중엔 걍 fbuserid로 변경해야긋다..
//								 //$CLASS_COOKIE->set("user_fb_testvalue",1);
//							 }
//
//					  }	
//             }


			
			switch($_SESSION['api_twitter_todo'])
			{
				case "loginLink" : 
					
					if($_SESSION['api_twitter_param'] == "1") $reload = true;
					
					$content_object = $connection->get('account/verify_credentials');
					$content = get_object_vars($content_object);
											
					if(!empty($content['id'])) {
						
						$type = "T"; // 회원타입
						$userid = $content['id']; // 트위터아이디 
						$name = $content['name']; // 트위터이름
						
						// 회원이 아닐 경우  가입폼
						if($CLASS_USER->isUserID($DB, $userid, $type) == false && 
						$CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
							$_SESSION['joinType'] = $type;
							$_SESSION['joinSNSKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "login");
							$script = "window.opener.document.location = '/join/sns' ;";
							Module::callScript($script);
							Module::close();
							Module::exitModule();
						} 
						
						if($CLASS_USER->isUserID($DB, $userid, $type) == true) {	
							// 회원정보
							$userInfo = $CLASS_USER->getUserByID($DB, $userid, $type);
							$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
							$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
							$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
							$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
							$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
							$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
							$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
							// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
							$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
							$userInfo['cash'] = number_format($cashInfo['cash']);
							$userInfo['point'] = number_format($pointInfo['point']);
							$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
							$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
							$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
							// 세션
							$CLASS_LOGIN->setSnsLoginSession($userInfo);
							$CLASS_LOGIN->addSession($extraInfo);
							$CLASS_LOGIN->addSession($statsInfo);
							$CLASS_LOGIN->addSession($blogInfo);
							$CLASS_LOGIN->addSession($frontierInfo1);
							$CLASS_LOGIN->addSession($frontierInfo2);		
							//리멤버미 DB저장, 쿠키생성 
							$rememberMe->createCookie_sns($userid,"Twit");
							// 회원이미지  $content['profile_image_url_https']
							$_SESSION['userimage'] = $content['profile_image_url']; 
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
							$arr[] = "TI"; // 로그인타입 
							$DB->rConnect();
							$res[] = $DB->call("p_account_login_upd", $arr);							
							// 결과
							$loginArr['login_result'] = "Y";
						} else {
							$loginArr['login_result'] = "N";
						}
						$loginArr['login_type'] = $type."I";					
						// 로그인 로그
						$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $loginArr);						
						// 트위터 리소스 초기화
						$CLASS_TWITTER->initResource();
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
							Module::close("트위터 연동 로그인이 실패하였습니다.");		
						}
						
					} else {
						//$CLASS_TWITTER->initSession();
						Module::close("트위터 연동로그인이 실패하였습니다. 다시 시도 하시길 바랍니다.");
					}
					break;
				
				case "login" : 
					
						if($_SESSION['api_twitter_param'] == "1") $reload = true;
						
						$content_object = $connection->get('account/verify_credentials');
						$content = get_object_vars($content_object);
												
						if(!empty($content['id'])) {
							
							$type = "T"; // 회원타입
							$userid = $content['id']; // 트위터아이디 
							$name = $content['name']; // 트위터이름							
							
						
								
							if($CLASS_USER->isUserLinkID($DB, $content['id'],$type)==true){
								
								//Do revu login process and activate sns account(fb,twit)
								// 회원정보(first step is to get revu account via facebook account)
								$userInfo = $CLASS_USER->getUserRelationByID($DB, $content['id'], $type); //relation-Information > revu account
		

								$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
								$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
								$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
								$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
								$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
								$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
								$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
								// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
								$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
								$userInfo['cash'] = number_format($cashInfo['cash']);
								$userInfo['point'] = number_format($pointInfo['point']);
								$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
								$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
								$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
								// 세션
								$CLASS_LOGIN->setSnsLoginSession($userInfo);
								$CLASS_LOGIN->addSession($extraInfo);
								$CLASS_LOGIN->addSession($statsInfo);
								$CLASS_LOGIN->addSession($blogInfo);
								$CLASS_LOGIN->addSession($frontierInfo1);
								$CLASS_LOGIN->addSession($frontierInfo2);	
								$_SESSION['twit_nickname'] = $content['name']; // 트위터이름	
								if($userInfo["fb_relation"] > 0){
									//get twit information on twit db
									
									$relationFbInform = $CLASS_USER->getUserFbLogInformByID($DB, $userInfo["fb_relation"]);	
									$_SESSION['fb_189402831149686_code'] = $relationFbInform["code"];
									$_SESSION['fb_189402831149686_access_token'] = $relationFbInform["access_token"];	
									$_SESSION['fb_189402831149686_user_id'] = $relationFbInform["user_id"];	
									$_SESSION['fb_189402831149686_state'] = $relationFbInform["state"];	

									$user = $CLASS_FACEBOOK->facebook->getUser();		
									if($user && $user != "0") {	
										try {
											$CLASS_FACEBOOK->facebook->setAccessToken($relationFbInform["access_token"]);
											$profile = $CLASS_FACEBOOK->facebook->api('/me'); // Facebook Return value set
											if(!empty($profile) && $CLASS_FACEBOOK->isLogin() == true) {		
												// DO success proc
												$_SESSION["fb_nickname"] = $profile["name"];								
											}else{						
												// Need to active accessToken
												$jsonArr['login_result'] = "FN.Error(03)";
											}
										} catch (FacebookApiException $e) {
											$jsonArr['login_result'] = "FN.Error(02)";
											//Module::close($e);
											//error_log($e);
											//$user = null;
										}
									}else{
										$jsonArr['login_result'] = "FN.Error(01)";
										//Module::redirect($CLASS_FACEBOOK->loginURL);
									}
								}
								//리멤버미 DB저장, 쿠키생성 
								$rememberMe->createCookie_sns($userid,"Twit");
								// 회원이미지  $content['profile_image_url_https']
								$_SESSION['userimage'] = $CLASS_USER->getImage($userInfo['userno'], $extraInfo['userimage']);
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
									$arr[] = "TI"; // 로그인타입 
									$DB->rConnect();
									$res[] = $DB->call("p_account_login_upd", $arr);							
									// 결과
									$loginArr['login_result'] = "Y";

							}else{
								// 회원이 아닐 경우  가입폼
								if($CLASS_USER->isUserID($DB, $userid, $type) == false && 
								$CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
									$_SESSION['joinType'] = $type;
									$_SESSION['joinSNSKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "login");
									$script = "window.opener.document.location = '/join/sns' ;";
									Module::callScript($script);
									Module::close();
									Module::exitModule();
								} 
								
								if($CLASS_USER->isUserID($DB, $userid, $type) == true) {	
									// 회원정보
									$userInfo = $CLASS_USER->getUserByID($DB, $userid, $type);
									$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
									$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
									$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
									$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
									$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
									$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
									$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
									// 등급, 캐시, 포인트, 리뷰수, 추천, 댓글;
									$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
									$userInfo['cash'] = number_format($cashInfo['cash']);
									$userInfo['point'] = number_format($pointInfo['point']);
									$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
									$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
									$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
									// 세션
									$CLASS_LOGIN->setSnsLoginSession($userInfo);
									$CLASS_LOGIN->addSession($extraInfo);
									$CLASS_LOGIN->addSession($statsInfo);
									$CLASS_LOGIN->addSession($blogInfo);
									$CLASS_LOGIN->addSession($frontierInfo1);
									$CLASS_LOGIN->addSession($frontierInfo2);		
									//리멤버미 DB저장, 쿠키생성 
									$rememberMe->createCookie_sns($userid,"Twit");
									// 회원이미지  $content['profile_image_url_https']
									$_SESSION['userimage'] = $content['profile_image_url']; 
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
									$arr[] = "TI"; // 로그인타입 
									$DB->rConnect();
									$res[] = $DB->call("p_account_login_upd", $arr);							
									// 결과
									$loginArr['login_result'] = "Y";
								} else {
									$loginArr['login_result'] = "N";
								}	
							}
							
							$loginArr['login_type'] = $type."I";					
							// 로그인 로그
							$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $loginArr);						
							// 트위터 리소스 초기화
							$CLASS_TWITTER->initResource();
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
								Module::close("트위터 연동 로그인이 실패하였습니다.");		
							}
							
						} else {
							//$CLASS_TWITTER->initSession();
							Module::close("트위터 연동로그인이 실패하였습니다. 다시 시도 하시길 바랍니다.");
						}
						break;

				case "logout" : 
					$CLASS_TWITTER->initSession();
					// 1) Clear cookie 
					// 2) Change link status to off 
					Module::close();
					break;
					
				case "auth" :  
					Module::close();
					break;
					
				case "tweet" :
					// 리뷰댓글 레이어노출 
					//$script = "opener.twitter.tweet(".$_SESSION['api_twitter_param'].");";
					//Module::callScript($script);
					//Module::close();
					//print_r($_SESSION);
					$review = $CLASS_REVIEW->getReview($DB, $_SESSION['api_twitter_param']);
					if($review['rno'] == "") {
						Module::close("리뷰가 존재 하지 않습니다.");
					}
					$review['title'] = $BASE->strLimitUTF($review['title'], 70, false, "...");					
					// 회원정보
					$content_object = $connection->get('account/verify_credentials');
					$content = get_object_vars($content_object);
					$userid = $content['id']; // 트위터아이디 
					$name = $content['name']; // 트위터이름
					
					$url = "http://"._DOMAIN."/".$_SESSION['api_twitter_param'];	
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
					break;
				
				case "slogin" :					
					//$script = "window.opener.document.location.reload();";					
					$script = "window.opener.loginFlag['T'] = '1';";
					$script .= "window.opener.socialbar.turnIcon('T', 'on');";
					$script .= "window.opener.socialbar.setIcon();";
					Module::callScript($script);
					Module::close();
					break;

				case "slogout" : 
					$CLASS_TWITTER->initSession();
					$script = "window.opener.loginFlag['T'] = '';";
					$script .= "window.opener.socialbar.turnIcon('T', 'off');";
					$script .= "window.opener.socialbar.setIcon();";					
					//$script = "window.opener.document.location.reload();";
					Module::callScript($script); 
					Module::close();
					break;

				case "slinkOn" :	
					// 1) Get login cookie
				    // 2) Search triplet
					// 3) If exist data update twittID by loginID 
					if(!$rememberMe->cookieIsValid($_SESSION["userid"])){					
						//리멤버미 DB저장, 쿠키생성 
						$rememberMe->createCookie_sns($_SESSION['access_token']['user_id'],"RTwit",$_SESSION["userid"]);
					}else{
						$loginresult = $rememberMe->logintwit($_SESSION['access_token']['user_id']);
						if($loginresult) {						
							// There is a chance that an attacker has stolen the login token, so we store
							// the fact that the user was logged in via RememberMe (instead of login form)						
							 $_SESSION['t_remembered_by_cookie'] = true;						
						  } else { 

						  }
					}
					 Module::close();
					break; 	
				case "slinkOff" :
					// If FB-link is off, clear cookie
				    if($_SESSION["fb_".FACEBOOK_KEY."_user_id"] == ""){
						$rememberMe->clearCookie(true);
					}else{
						// Update cookie as twit infotm to delete
						$loginresult = $rememberMe->logintwit();
					}
				       //  2) unset session of facebook
				    $CLASS_TWITTER->initSession();
					Module::close();					
				break; 

				 case "snsLinkOn" :						
				    // 1) Find that Twit account is in revu DB
					// 2) If it's not, Find link-sns-account by TWITTER_ID
					// 3) If it's not, Update TWITT field to authed Twit-account
					$type = "T"; // 회원타입
					$userid = $_SESSION['access_token']['user_id']; // 레뷰아이디					
					if($CLASS_USER->isUserID($DB, $userid, $type) == false && $CLASS_USER->isUserSNS($DB, $userid, $type) == false) {
						if($CLASS_USER->isUserLinkID($DB, $userid,$type)==false){
							// Do about update process of fb field	
//							echo $_SESSION['userno']."</br>";
//							echo  $userid;
							$arr = array();
							$arr[] = $_SESSION['userno'];
							$arr[] = $userid;
							$DB->rConnect();
							$res[] = $DB->call("p_account_twitt_upd", $arr);	

							$content_object = $connection->get('account/verify_credentials');
							$content = get_object_vars($content_object);						
							$_SESSION['twit_nickname'] = $content['name']; // 트위터이름
						}else{
							Module::close("이미 연결된 계정입니다.(code:2)");
						}
					}else{
						$CLASS_TWITTER->initSession();
						Module::close("기존 트위터 가입계정은 연결하기 기능을 사용하실수없습니다. 트위터 계정으로 로그인 후 탈퇴 후 다시 연결하기 기능을 이용해주세요(code:1)");
					}	

					$script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);			  
					Module::close();
				break;

				case "snsLinkOff" :
					// 1) Find row has linked twitt-relation field in TWITT-SESSION-USERID
				    // 2) Update twitt-relation field to 0
					// 3) Init Twitt-SESSION
					$type = "T"; // 회원타입
					if($CLASS_USER->isUserLinkID($DB, $_SESSION['access_token']['user_id'], $type)==true){
						// Update twit-relation field to 0(init process)
						$arr = array();
						$arr[] = $_SESSION['userno'];
						$arr[] = 0;
						$DB->rConnect();
						$res[] = $DB->call("p_account_twitt_upd", $arr);	
						$CLASS_TWITTER->initSession();
					}else{
						Module::close("연결된 계정이 아닙니다.");
					}

					$script = "var url = window.opener.document.URL; opener.document.location = url;";	
					Module::callScript($script);
					Module::close();					
				break; 

				default : 
					Module::callScript("alert('aa');"); 
					//$CLASS_TWITTER->initSession();
					//Module::close("트위터 리소스정보가 없습니다. 다시 시도 하시길 바랍니다.");
					Module::close();
					break;
			}
		
		// 허용안된 경우 세션 초기화 후 인증페이지 
		} else {
			$CLASS_TWITTER->initSession();
			Module::redirect("/api/twitter");
		}
	}
}
/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"todo"=>$_SESSION['api_twitter_todo'],
	"review"=>$review,
	"bitlyData"=>$bitlyData,
	"userid"=>$userid,
	"name"=>$name,
));
?>