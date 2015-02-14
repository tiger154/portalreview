<?php
/***************************************************************************************
 * 회원가입 컨트롤러
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
// var
GLOBAL $SITE;
GLOBAL $FRAME;

/**
 * CLASS
 */
$CLASS_FTP = &Module::singleton("Ftp");
$CLASS_FILE = &Module::singleton("File");
$CLASS_THUMBNAIL = &Module::singleton("Thumbnail");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_LOGIN = &Module::singleton("Auth.Login");
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_USER = &Module::singleton("User.User");
$CLASS_CASH = &Module::singleton("User.Cash");
$CLASS_POINT = &Module::singleton("User.Point");
$CLASS_GRADE = &Module::singleton("User.Grade");
$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

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
	 * 회원가입처리
	 */
	case "step1.proc" :
		
		if($_SESSION['joinKey'] == "" || $CLASS_ENCRYPTER->decryptMD5($_SESSION['joinKey'], "step1") != $_SERVER['REMOTE_ADDR']) {
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/join");
			break;
		}		
		$_SESSION['joinKey'] = "";		
		$acArr = array();		
		$acArr[] = $_POST['userid'];
		$acArr[] = $_POST['username'];
		$acArr[] = $_POST['passwd'];
		$acArr[] = $_POST['nickname'];
		$acArr[] = $_POST['email'];
		$acArr[] = "R";		
		$res = array();
		$res[] = $DB->call("p_account_ins", $acArr);		
		if($res[0]['orcode'] == '1') {
			if($_POST['tmpimage'] != "" && $_FILES['file1']['error'] == "0") {
				$idx = ceil($res[0]['ouserno']/10000);
				$dir1 = _FTP_USERIMAGE."/".$idx;
				$dir2 = _FTP_TMP;
				$file1 = $res[0]['ouserno'].".".$CLASS_FILE->getExtname($_FILES['file1']['name']);
				$file2 = $_POST['tmpimage'];
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir1);
				$CLASS_FTP->move($dir2."/".$file2, $dir1."/".$file1);
				$CLASS_FTP->close();
				$_POST['userimage'] = $file1;
			}	
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];
			$acArr[] = ($_POST['gender'] == "") ? "A" : $_POST['gender'];
			$acArr[] = (($_POST['birth_year'] != '') && ($_POST['birth_month'] != '') && ($_POST['birth_day'] != '')) ? $_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'] : '';
			$acArr[] = $_POST['flag_lunar'];
			$acArr[] = (($_POST['cell1'] != '') && ($_POST['cell2'] != '') && ($_POST['cell3'] != '')) ? $_POST['cell1']."-".$_POST['cell2']."-".$_POST['cell3'] : '';
			$acArr[] = (($_POST['tel1'] != '') && ($_POST['tel2'] != '') && ($_POST['tel3'] != '')) ? $_POST['tel1']."-".$_POST['tel2']."-".$_POST['tel3'] : '';
			$acArr[] = $_POST['addrzip'];
			$acArr[] = $_POST['addr1'];
			$acArr[] = $_POST['addr2'];
			$acArr[] = $_POST['userimage'];			
			$DB->rConnect();			
			$res[] = $DB->call("p_account_extra_ins", $acArr);

			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$acArr[] = $_POST['area_bcode1'];
			$acArr[] = $_POST['area_mcode1'];
			$acArr[] = $_POST['area_scode1'];
			$DB->rConnect();	
			$res[] = $DB->call("p_account_area_code_ins", $acArr);

			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$acArr[] = $_POST['area_bcode2'];
			$acArr[] = $_POST['area_mcode2'];
			$acArr[] = $_POST['area_scode2'];
			$DB->rConnect();
			$res[] = $DB->call("p_account_area_code_ins", $acArr);

			for($i=0; $i<sizeof($_POST['cate']); $i++) {
				$acArr = array();
				$acArr[] = $res[0]['ouserno'];	
				$acArr[] = $_POST['cate'][$i];
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';
				$acArr[] = '';				
				$DB->rConnect();
				$res[] = $DB->call("p_account_cate_code_ins", $acArr);
			}

			$arr = array();
			$arr[] = $res[0]['ouserno'];
			$arr[] = "0"; 
			$arr[] = "100"; 
			$arr[] = "";
			$DB->rConnect();
			$res[] = $DB->call("p_point_ins", $arr);

			if(Module::result($res, "err", "-1") == false) {
				$DB->rConnect();
				$acArr = array();
				$acArr[] = $res[0]['ouserno'];	
				$DB->call("p_account_join_del", $acArr);
				Module::alert("회원가입도중 처리가 실패하였습니다.");
				Module::redirect("/join");
			} else {
				// 로그인 처리 변경시  아래모두 변경 작업해야함
				// 0.join.proc
				// 1.auth.login.ajax.proc
				// 2.auth.login.refresh.proc 
				// 3.myrevu.info.modify.proc
				$DB->rConnect();
				$userInfo = $CLASS_USER->getUser($DB, $res[0]['ouserno']);
				$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
				$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
				$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno']);
				$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
				$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
				$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
				$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
				$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
				$userInfo['cash'] = number_format($cashInfo['cash']);
				$userInfo['point'] = number_format($pointInfo['point']);
				$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
				$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
				$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
				$CLASS_LOGIN->setSession($userInfo);
				$CLASS_LOGIN->addSession($extraInfo);
				$CLASS_LOGIN->addSession($statsInfo);
				$CLASS_LOGIN->addSession($blogInfo);
				$CLASS_LOGIN->addSession($frontierInfo1);
				$CLASS_LOGIN->addSession($frontierInfo2);
				
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = $userInfo['grade'];
				$DB->rConnect();
				$res[] = $DB->call("p_account_grade_upd", $arr);
				
				if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
					$arr = array();
					$arr[] = $userInfo['userno'];
					$arr[] = "0"; 
					$arr[] = "101"; 
					$arr[] = "";
					$DB->rConnect();
					$res[] = $DB->call("p_point_ins", $arr);
				}
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = "I"; 
				$DB->rConnect();
				$res[] = $DB->call("p_account_login_upd", $arr);
				$_SESSION['joinKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "step2");
				
				// 로그인 로그
				$loginArr['login_result'] = "Y";
				$loginArr['login_type'] = "RI";
				$loginArr['referer'] = $_SERVER['HTTP_REFERER'];
				$userInfo['passwd'] = $CLASS_ENCRYPTER->encryptMD5($_POST['passwd'], $key="jingeese");
				$DB->rConnect();
				$CLASS_LOGIN->insertLoginLog($DB_LOG, $userInfo, $loginArr);
				
				//Module::alert("회원가입되었습니다.");
				Module::redirect("/join/step2");
			}
		} else {
			Module::alert("회원가입처리가 실패하였습니다.");
			Module::redirect("/join");
		}
		break;
	
	/**
	 * SNS회원가입처리
	 */
	case "sns.proc" :
		
		$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
		
		if($_SESSION['joinSNSKey'] == "" || 
		$CLASS_ENCRYPTER->decryptMD5($_SESSION['joinSNSKey'], "login") != $_SERVER['REMOTE_ADDR']) 
		{
			$CLASS_TWITTER->initJoinSession();
			$CLASS_FACEBOOK->initJoinSession();
			Module::alert("잘못된 경로입니다.");
			Module::redirect("/");
		}		
		if($_SESSION['joinType'] == "") {
			$CLASS_TWITTER->initJoinSession();
			$CLASS_FACEBOOK->initJoinSession();
			Module::alert("가입정보가 잘못되어있습니다.");
			Module::redirect("/");
		}		
		switch($_SESSION['joinType']) {
			case "T" :
				if($_SESSION['access_token']['user_id'] == "") {
					$CLASS_TWITTER->initJoinSession();
					Module::alert("트위터에 로그인이 되어 있지 않습니다.");
					Module::redirect("/");
				}
				$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
				$content_object = $connection->get('account/verify_credentials');
				$content = get_object_vars($content_object);
				$type = $_SESSION['joinType'];
				$userid = $content['id']; // 트위터아이디 
				$name = $content['name']; // 트위터이름	
				break;
				
			case "F" : 
				try {
					$profile = $CLASS_FACEBOOK->facebook->api('/me');
					$type = $_SESSION['joinType'];
					$userid = $profile['id']; // 페이스북아이디
					$name = $profile['name']; // 페이스북이름
				} catch (FacebookApiException $e) {
					$CLASS_FACEBOOK->initJoinSession();
					Module::close("페이스북에 로그인이 되어 있지 않습니다.");
					Module::redirect("/");
				}
				break;
		}
					
		// 기본정보 가입처리
		$acArr = array();
		$acArr[] = $userid; // 아이디 
		$acArr[] = $_POST['username']; // 이름 
		$acArr[] = $userid; // 비밀번호
		$acArr[] = $_POST['nickname']; // 닉네임
		$acArr[] = $_POST['email']; // 이메일
		$acArr[] = $type; // 회원타입
				
		$res = array();
		$res[] = $DB->call("p_account_ins", $acArr);
		
		// 회원부가정보			
		$acArr = array();
		$acArr[] = $res[0]['ouserno']; // 회원번호	
		$acArr[] = "A"; // 성별(A:미확인) 
		$acArr[] = ""; // 생년월일
		$acArr[] = ""; // 양력,음력
		$acArr[] = ""; // 휴대폰번호
		$acArr[] = ""; // 전화번호
		$acArr[] = ""; // 우편번호
		$acArr[] = ""; // 주소1
		$acArr[] = ""; // 주소2
		$acArr[] = ""; // 회원이미지			
		$DB->rConnect();			
		$res[] = $DB->call("p_account_extra_ins", $acArr);
		
		// SNS회원정보			
		$acArr = array();
		$acArr[] = $type; // 회원타입
		$acArr[] = $res[0]['ouserno']; // 회원번호
		$acArr[] = $userid; // 트위터아이디
		$acArr[] = $name; // 트위터이름	
		$DB->rConnect();			
		$res[] = $DB->call("p_account_sns_ins", $acArr);
		
		$arr = array();
		$arr[] = $res[0]['ouserno'];
		$arr[] = "0"; 
		$arr[] = "100"; 
		$arr[] = "";
		$DB->rConnect();
		$res[] = $DB->call("p_point_ins", $arr);

		if(Module::result($res, "err", "-1") == false) {
			$DB->rConnect();
			$acArr = array();
			$acArr[] = $res[0]['ouserno'];	
			$DB->call("p_account_join_del", $acArr);
			Module::alert("회원가입도중 처리가 실패하였습니다.");
			Module::redirect("/join");
		} else {
			// 로그인 처리 변경시  아래모두 변경 작업해야함
			// 0.join.proc
			// 1.auth.login.ajax.proc
			// 2.auth.login.refresh.proc 
			// 3.auth.facebook 
			// 4.auth.twitter.callback 
			// 5.myrevu.info.modify.proc
			$DB->rConnect();
			$userInfo = $CLASS_USER->getUser($DB, $res[0]['ouserno']);
			$extraInfo = $CLASS_USER->getUserExtra($DB, $userInfo['userno']);
			$statsInfo = $CLASS_USER->getUserStats($DB, $userInfo['userno']);
			$blogInfo = $CLASS_BLOG->getLoginBlogList($DB, $userInfo['userno']);
			$frontierInfo1 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "A", 2);
			$frontierInfo2 = $CLASS_FRONTIER->getLoginFrontierList($DB, $userInfo['userno'], "B", 2);
			$cashInfo = $CLASS_CASH->getCash($DB, $userInfo['userno']);
			$pointInfo = $CLASS_POINT->getPoint($DB, $userInfo['userno']);
			$userInfo['grade'] = $CLASS_GRADE->getGrade($DB, $userInfo['userno']); 
			$userInfo['cash'] = number_format($cashInfo['cash']);
			$userInfo['point'] = number_format($pointInfo['point']);
			$statsInfo['review_cnt'] = number_format($statsInfo['review_cnt']);
			$statsInfo['recom_cnt'] = number_format($statsInfo['recom_cnt']);
			$statsInfo['talk_cnt'] = number_format($pointInfo['talk_cnt']);
			$CLASS_LOGIN->setSession($userInfo);
			$CLASS_LOGIN->addSession($extraInfo);
			$CLASS_LOGIN->addSession($statsInfo);
			$CLASS_LOGIN->addSession($blogInfo);
			$CLASS_LOGIN->addSession($frontierInfo1);
			$CLASS_LOGIN->addSession($frontierInfo2);
			
			$arr = array();
			$arr[] = $userInfo['userno'];
			$arr[] = $userInfo['grade'];
			$DB->rConnect();
			$res[] = $DB->call("p_account_grade_upd", $arr);
			
			if($CLASS_LOGIN->isLoginPastTime($DB, $userInfo['userno'], $time=24) == true) {
				$arr = array();
				$arr[] = $userInfo['userno'];
				$arr[] = "0"; 
				$arr[] = "101"; 
				$arr[] = "";
				$DB->rConnect();
				$res[] = $DB->call("p_point_ins", $arr);
			}
			$arr = array();
			$arr[] = $userInfo['userno'];
			$arr[] = "I"; 
			$DB->rConnect();
			$res[] = $DB->call("p_account_login_upd", $arr);
			$_SESSION['joinKey'] = $CLASS_ENCRYPTER->encryptMD5($_SERVER['REMOTE_ADDR'], "step2");
			$CLASS_TWITTER->initJoinSession();
			//Module::alert("회원가입되었습니다.");
			Module::redirect("/join/step2");
		}
		break; 
		
	/**
	 * 아이디 중복체크
	 */
	case "check.id.proc" :
		$FRAME = "ajax";
		if($CLASS_USER->checkRepeatID($DB, $_POST['userid']) == false) {			
			$jsonArr['result'] = "success";			
		} else {
			$jsonArr['result'] = "fail";
		}	
		$jsonArr['userid'] = $_POST['userid'];
		break;
		
	/**
	 * 닉네임 중복체크
	 */
	case "check.nick.proc" :
		$FRAME = "ajax";
		if($CLASS_USER->checkRepeatNick($DB, $_POST['nickname']) == false) {			
			$jsonArr['result'] = "success";			
		} else {
			$jsonArr['result'] = "fail";
		}	
		$jsonArr['nickname'] = $_POST['nickname'];
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
	 * 회원이미지 임시업로드
	 */
	case "image.upload.proc" :
		
		// 디렉토리생성
		if($_FILES['file1']['error'] == "0") {
			$tmp = $_FILES['file1']['tmp_name'];
			$file1 = $_FILES['file1']['name'];
			$file2 = uniqid("");
			
			if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 100, 100) == true) {
				$dir = _FTP_TMP;
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir."/".$_POST['tmpimage']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				Module::callScript("parent.join.previewUserImage('$file2');");
				break;
			}
		} 
		Module::callScript("parent.join.initUserImage();");		
		break;

	/**
	 * 디폴트
	 */
	default :
		Module::alert("잘못된 경로입니다.");
		Module::redirectModule("/join");
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