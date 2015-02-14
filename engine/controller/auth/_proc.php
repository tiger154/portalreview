<?php
/***************************************************************************************
 * 인증 컨트롤러
 * 
 * 작성일 : 2011.07.08
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

/**
 * CLASS
 */
$CLASS_COOKIE = &Module::singleton("Cookie");
$CLASS_EMAIL = &Module::singleton("Email");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_AUTH = &Module::singleton("Auth.Auth");
$CLASS_LOGIN = &Module::singleton("Auth.Login");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_GRADE = &Module::singleton("User.Grade");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");

/*************** 
 *  @@ Remember Me include module 
 ****************/
//$CLASS_REMEMBERME = &Module::singleton("API.Rememberme"); //remember me
//function rememberAutoload($class) {
//  require _DIR_EXTENDS.'/php.Rememberme/src/'.strtr($class,'_',DIRECTORY_SEPARATOR).".php";
//}
//spl_autoload_register("rememberAutoload");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

/**
 * Remember me Object
 */
//$db_opt_tmp = array ("tableName"=>"Ru_rememberme","credentialColumn"=>"credential","tokenColumn"=>"token","persistentTokenColumn"=>"persistent_token","expiresColumn"=>"expires");
//$mysqli_connection_tmp = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");
//$rPDO = new Rememberme_Storage_PDO($db_opt_tmp);
//$rPDO->setConnection($mysqli_connection_tmp);
//$rememberMe = new Rememberme($rPDO);

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
	 * 로그인처리
	 */
	case "login.proc" : 
		break;
	
	/**
	 *  AJAX 로그인처리
	 */
	case "login.ajax.proc" : 
		
		// 로그인 처리 변경시  아래모두 변경 작업해야함
		// 0.join.proc
		// 1.auth.login.ajax.proc
		// 2.auth.login.refresh.proc 
		// 3.myrevu.info.modify.proc
		//exit;
		$FRAME = "ajax";
		$_POST['userid'] = urldecode($_POST['userid']);
		$_POST['passwd'] = urldecode($_POST['passwd']);		
		//$_POST['userid'] = $BASE->stripScpecial($_POST['userid']);  //패스워드 특수문자체크와 같은 이유로 특수문자 체크 함수 주석처리 (2011.10.25 박상선)
		//$_POST['passwd'] = $BASE->stripScpecial($_POST['passwd']);
		
		$_REQUEST['url'] = urldecode($_REQUEST['url']);
		if($CLASS_USER->isUserID($DB, $_POST['userid']) == true) {
			if($CLASS_USER->isUserPass($DB, $_POST['userid'], $_POST['passwd']) == true) {
				// 회원정보
				$userInfo = $CLASS_USER->getUserByID($DB, $_POST['userid']);
				$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
				$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
				$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
				$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
				//print_r($frontierInfo1);
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
				$CLASS_LOGIN->setSession($userInfo);
				$CLASS_LOGIN->addSession($extraInfo);
				$CLASS_LOGIN->addSession($statsInfo);
				$CLASS_LOGIN->addSession($blogInfo);
				$CLASS_LOGIN->addSession($frontierInfo1);
				$CLASS_LOGIN->addSession($frontierInfo2);
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
				// 회원이미지
				$_SESSION['userimage'] = $CLASS_USER->getImage($userInfo['userno'], $extraInfo['userimage']);
				// 등급업데이트
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = $userInfo['grade'];
				$DB->rConnect();
				$DB->call("p_account_grade_upd", $arr);
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
				$arr[] = "I"; // 로그인타입 
				$DB->rConnect();
				$res[] = $DB->call("p_account_login_upd", $arr);
				// 결과
				$jsonArr['login_result'] = "Y";
			} else {
				$jsonArr['login_result'] = "P"; // wrong password
			}
		} else {
			//Module::alert("아이디 또는 비밀번호가 옳바르지 않습니다1.");			
			$jsonArr['login_result'] = "N"; // wrong id
		}
		
		$jsonArr['login_type'] = "RI";
		$jsonArr['referer'] = ($_POST['referer'] != "") ? $_POST['referer'] : $_SERVER['HTTP_REFERER'];
		
		// 로그인 로그
		$userInfo['passwd'] = $CLASS_ENCRYPTER->encryptMD5($_POST['passwd'], $key="jingeese");
		$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $jsonArr);

		// 아이디 저장
		if($_POST['saveid'] == "1") {
			$CLASS_COOKIE->set("saveid", $value=$_POST['saveid'], $expiry, $path='/', $domain=_DOMAIN);
			$CLASS_COOKIE->set("userid", $value=$_POST['userid'], $expiry, $path='/', $domain=_DOMAIN);
		} else {
			$CLASS_COOKIE->del("saveid", $path='/', $domain=_DOMAIN, $global=false);
			$CLASS_COOKIE->del("userid", $path='/', $domain=_DOMAIN, $global=false);
		}
		
		// 리다이렉트 URL은  POST가 우선 순위			
		//$reUrl = (!empty($_POST['url'])) ? $_POST['url'] : $_GET['url'];
		// 공통사용
		$retUrl = (!empty($_REQUEST['url'])) ? $_REQUEST['url'] : "";
	
		if($jsonArr['login_result'] == "Y") {
			$jsonArr['result'] = "success";
			$jsonArr['url'] = $retUrl;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;

/**
	 *  AJAX 로그인처리
	 */
	case "customlogin.ajax.proc" : 
		
		// 로그인 처리 변경시  아래모두 변경 작업해야함
		// 0.join.proc
		// 1.auth.login.ajax.proc
		// 2.auth.login.refresh.proc 
		// 3.myrevu.info.modify.proc
		//exit;
		$FRAME = "ajax";
		$_POST['userid'] = urldecode($_POST['userid']);
		$_POST['passwd'] = urldecode($_POST['passwd']);		
		//$_POST['userid'] = $BASE->stripScpecial($_POST['userid']);  //패스워드 특수문자체크와 같은 이유로 특수문자 체크 함수 주석처리 (2011.10.25 박상선)
		//$_POST['passwd'] = $BASE->stripScpecial($_POST['passwd']);
		
		$_REQUEST['url'] = urldecode($_REQUEST['url']);
		if($CLASS_USER->isUserID($DB, $_POST['userid']) == true) {
			if($CLASS_USER->isUserPass($DB, $_POST['userid'], $_POST['passwd']) == true) {
				// 회원정보
				$userInfo = $CLASS_USER->getUserByID($DB, $_POST['userid']);
				$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
				$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
				$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno'], 2);
				$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
				//print_r($frontierInfo1);
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
				$CLASS_LOGIN->setSession($userInfo);
				$CLASS_LOGIN->addSession($extraInfo);
				$CLASS_LOGIN->addSession($statsInfo);
				$CLASS_LOGIN->addSession($blogInfo);
				$CLASS_LOGIN->addSession($frontierInfo1);
				$CLASS_LOGIN->addSession($frontierInfo2);
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
				// 회원이미지
				$_SESSION['userimage'] = $CLASS_USER->getImage($userInfo['userno'], $extraInfo['userimage']);
				// 등급업데이트
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = $userInfo['grade'];
				$DB->rConnect();
				$DB->call("p_account_grade_upd", $arr);
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
				$arr[] = "I"; // 로그인타입 
				$DB->rConnect();
				$res[] = $DB->call("p_account_login_upd", $arr);
				// 결과
				$jsonArr['login_result'] = "Y";
			} else {
				$jsonArr['login_result'] = "P"; // wrong password
			}
		} else {
			//Module::alert("아이디 또는 비밀번호가 옳바르지 않습니다1.");			
			$jsonArr['login_result'] = "N"; // wrong id
		}
		
		$jsonArr['login_type'] = "RI";
		$jsonArr['referer'] = ($_POST['referer'] != "") ? $_POST['referer'] : $_SERVER['HTTP_REFERER'];
		
		// 로그인 로그
		$userInfo['passwd'] = $CLASS_ENCRYPTER->encryptMD5($_POST['passwd'], $key="jingeese");
		$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $jsonArr);

		// 아이디 저장
		if($_POST['saveid'] == "1") {
			$CLASS_COOKIE->set("saveid", $value=$_POST['saveid'], $expiry, $path='/', $domain=_DOMAIN);
			$CLASS_COOKIE->set("userid", $value=$_POST['userid'], $expiry, $path='/', $domain=_DOMAIN);
		} else {
			$CLASS_COOKIE->del("saveid", $path='/', $domain=_DOMAIN, $global=false);
			$CLASS_COOKIE->del("userid", $path='/', $domain=_DOMAIN, $global=false);
		}
		
		// 리다이렉트 URL은  POST가 우선 순위			
		//$reUrl = (!empty($_POST['url'])) ? $_POST['url'] : $_GET['url'];
		// 공통사용
		$retUrl = (!empty($_REQUEST['url'])) ? $_REQUEST['url'] : "";
	
		if($jsonArr['login_result'] == "Y") {
			$jsonArr['result'] = "success";
			$jsonArr['url'] = $retUrl;
		} else {
			$jsonArr['result'] = "fail";
			Module::alert("아이디 또는 비밀번호가 옳바르지 않습니다1.");			
		}

		Module::redirect($_SERVER['HTTP_REFERER']);

		break;	

	/**
	 * 로그인 리프레시
	 */
	case "login.refresh.proc" :
		
		// 로그인 처리 변경시  아래모두 변경 작업해야함
		// 0.join.proc
		// 1.auth.login.ajax.proc
		// 2.auth.login.refresh.proc
		// 3.myrevu.info.modify.proc
		
		$FRAME = "ajax";
				
		if(empty($_SESSION['userno'])) {
			$jsonArr['result'] = "fail";
			break;
		} else {
			// 회원정보
			$userInfo = $CLASS_USER->getUser($DB, $_SESSION['userno']);
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
			//$CLASS_LOGIN->initSession();
			$CLASS_LOGIN->setSession($userInfo);
			$CLASS_LOGIN->addSession($extraInfo);
			$CLASS_LOGIN->addSession($statsInfo);
			$CLASS_LOGIN->addSession($blogInfo);
			$CLASS_LOGIN->addSession($frontierInfo1);
			$CLASS_LOGIN->addSession($frontierInfo2);
			// 회원이미지
			$_SESSION['userimage'] = $CLASS_USER->getImage($userInfo['userno'], $extraInfo['userimage']);
			$jsonArr['user'] = $userInfo;
			$jsonArr['extra'] = $extraInfo;
			$jsonArr['stats'] = $statsInfo;
			$jsonArr['blog'] = $blogInfo;
			$jsonArr['frontier1'] = $frontierInfo1;
			$jsonArr['frontier2'] = $frontierInfo2;
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
			$arr[] = "I"; // 로그인타입 
			$DB->rConnect();
			$res[] = $DB->call("p_account_login_upd", $arr);
			// 결과
			$jsonArr['result'] = "success";
			break;
		}
		 
	/**
	 * 로그아웃 처리
	 */
	case "logout.proc" :
		$_POST['referer'] = ($_POST['referer'] != "") ? $_POST['referer'] : $_SERVER['HTTP_REFERER'];
		$_POST['login_type'] = $_SESSION['type']."O";

		$rememberMe->clearCookie(true);			// delect cookie information by revu 2012.08.28	
		$CLASS_LOGIN->insertLoginLog($DB_LOG, $_SESSION, $_POST);
		$CLASS_LOGIN->initSession();
		Module::redirect("/");
		break;
	
	/**
	 * 추천아이디 체크
	 */
	case "check.recomid.proc" :
		$FRAME = "ajax";
		if($CLASS_USER->isUserID($DB, $_POST['recomid']) == true) {
			$jsonArr['result'] = "success";			
		} else {
			$jsonArr['result'] = "fail";
		}	
		$jsonArr['recomid'] = $_POST['recomid'];
		break;
	
	/**
	 * 아이디검색
	 */
	case "search.id.proc" :
		$FRAME = "ajax";
		
		$list = $CLASS_USER->getUserListByEmail($DB, trim($_POST['email']));		
		$conf = Module::loadConf(_INI_SITE, false);
		$conf['EMAIL'] = (empty($conf['EMAIL'])) ? "revu@revu.co.kr" : $conf['EMAIL'];
		if(sizeof($list) < 1) {
			$jsonArr['result'] = "fail";
		} else {
			$res = array();			
			for($i=0; $i<sizeof($list); $i++) {
				$message = "";				
				$message .= "<h3>안녕하세요. ".$list[$i]['email']."님!</h3>";
				$message .= "<h3>회원님의 ".$conf['NAME']." 아이디는 ".$list[$i]['userid']."입니다.</h3>";
				$message .= "<br /><br />";
				$message .= "아이디 : ".$list[$i]['userid']."<br />";
				$message .= "닉네임 : ".$list[$i]['nickname']."<br />";
				$message .= "가입일자 : ".$list[$i]['regdate']."<br /><br />";
				$message .= "<a href='http://".$conf['DOMAIN']."' target='_blank'>로그인하러가기</a><br /><br />";
				$message .= $conf['NAME']." 사이트에서 아이디 찾기를 하여 발송된 메일입니다.<br />";
				$message .= "아이디 찾기를 하지 않았는데 본 메일을 받은 경우, 본 메일을 <a href='mailto:".$conf['EMAIL']."'>".$conf['EMAIL']."</a>로 전달해 주세요.";
				$message .= "<br /><br />";
				$message .= "<hr />";
				$message .= "본 메일은 발신 전용입니다.<br />";
				$message .= $conf['NAME']." 서비스에 대한 문의는 <a href='mailto:".$conf['EMAIL']."'>".$conf['EMAIL']."</a> 로 보내주시면 빠른 시간 안에 회신 드리겠습니다.<br />";
				$message .= "Copyright @ISEcommerce CO.LTD. All rights reserved.";
				$CLASS_EMAIL->from($conf['EMAIL'], $conf['NAME']);
				$CLASS_EMAIL->subject('[레뷰] 아이디찾기로 요청하신 아이디입니다.');
				$CLASS_EMAIL->to($_POST['email']);
				$CLASS_EMAIL->message($message);
				$res[] = $CLASS_EMAIL->send();
				//echo $CLASS_EMAIL->print_debugger();
			}
			if(Module::result($res) == false) {
				$jsonArr['result'] = "sendfail";
			} else {
				$jsonArr['result'] = "success";
			}
		}
		break;
	
	/**
	 * 비밀번호검색
	 */
	case "search.passwd.proc" :
		$FRAME = "ajax";
		
		if($CLASS_USER->isUserID($DB, $_POST['userid']) == false) {
			$jsonArr['result'] = "user";
		} else {
			$user = $CLASS_USER->getUserByID($DB, $_POST['userid']);
			if($_POST['email'] != $user['email']) {
				$jsonArr['result'] = "email";
			} else {
				$conf = Module::loadConf(_INI_SITE, false);
				$conf['EMAIL'] = (empty($conf['EMAIL'])) ? "revu@revu.co.kr" : $conf['EMAIL'];				
				$res = array();
				
				// 비번변경
				$passwd = substr($CLASS_ENCRYPTER->encryptMD5($user['userid'], date("Ymdhis")),0, 10);
				$arr = array();
				$arr[] = $user['userno'];
				$arr[] = $passwd;
				$arr[] = $user['nickname'];
				$arr[] = $user['email'];
				$arr[] = $user['flag_email'];				
				$res[] = $DB->call("p_account_upd", $arr);
				
				$message = "";				
				$message .= "<h3>안녕하세요. ".$user['userid']."님!</h3>";
				$message .= "<h3>회원님의 ".$conf['NAME']." 비밀번호는 아래와 같이 초기화 되었습니다.</h3>";
				$message .= "<br /><br />";
				$message .= "비밀번호 : ".$passwd."<br />";
				$message .= "<a href='http://".$conf['DOMAIN']."' target='_blank'>로그인하러가기</a><br /><br />";
				$message .= "레뷰 사이트 내에서의 회원님의 비밀번호는 암호화되어 관리자도 알 수 없습니다.<br />";
				$message .= "초기화된 비밀번호로 로그인 한 후 본인만 아는 비밀번호로 꼭 변경해 주세요.!<br />";
				$message .= $conf['NAME']." 사이트에서 비밀번호 찾기를 하여 발송된 메일입니다.<br />";
				$message .= "비밀번호찾기를 하지 않았는데 본 메일을 받은 경우, 본 메일을 <a href='mailto:".$conf['EMAIL']."'>".$conf['EMAIL']."</a>로 전달해 주세요.";
				$message .= "<br /><br />";
				$message .= "<hr />";
				$message .= "본 메일은 발신 전용입니다.<br />";
				$message .= $conf['NAME']." 서비스에 대한 문의는 <a href='mailto:".$conf['EMAIL']."'>".$conf['EMAIL']."</a> 로 보내주시면 빠른 시간 안에 회신 드리겠습니다.<br />";
				$message .= "Copyright @ISEcommerce CO.LTD. All rights reserved.";
				$CLASS_EMAIL->from($conf['EMAIL'], $conf['NAME']);
				$CLASS_EMAIL->subject('[레뷰] 비밀번호 찾기로 요청하신 비밀번호입니다.');
				$CLASS_EMAIL->to($_POST['email']);
				$CLASS_EMAIL->message($message);
				$res[] = $CLASS_EMAIL->send();
				//echo $CLASS_EMAIL->print_debugger();
				if(Module::result($res) == false) {
					$jsonArr['result'] = "sendfail";
				} else {
					$jsonArr['result'] = "success";
				}
			}
		}
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