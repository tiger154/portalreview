<?php
/***************************************************************************************
 * SNS회원가입폼 컨트롤러
 * 
 * 작성일 : 2011.06.30
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
$CLASS_ZIPCODE = &Module::singleton("Zipcode");
$CLASS_FILE = &Module::singleton("File");
$CLASS_ENCRYPTER = &Module::singleton("Encrypter");
$CLASS_CODE = &Module::singleton("Code.Code");
$CLASS_TWITTER = &Module::singleton("API.TwitterAPI");
$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
$CLASS_USER = &Module::singleton("User.User");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */

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
} else {
	switch($_SESSION['joinType']) {
		case "T" : 
			if($_SESSION['access_token']['user_id'] == "") {
				$CLASS_TWITTER->initJoinSession();
				Module::alert("트위터에 로그인이 되어 있지 않습니다.");
				Module::redirect("/");
			} else {
				$connection = $CLASS_TWITTER->getConnection($DB, $_SESSION['access_token']['user_id']);
				$content_object = $connection->get('account/verify_credentials');
				$content = get_object_vars($content_object);	
				$userid = $content['id']; // 트위터아이디 
				$name = $content['name']; // 트위터이름				
			}
			break;
		case "F" : 
			try {
				$profile = $CLASS_FACEBOOK->facebook->api('/me');
				$userid = $profile['id']; // 페이스북아이디
				$name = $profile['name']; // 페이스북이름
			} catch (FacebookApiException $e) {
				$CLASS_FACEBOOK->initJoinSession();
				Module::close("페이스북에 로그인이 되어 있지 않습니다.");
				Module::redirect("/");
			}
			break;
		default : 
			$CLASS_TWITTER->initJoinSession();
			$CLASS_FACEBOOK->initJoinSession();
			Module::alert("회원가입 타입이 없습니다.");
			Module::redirect("/");
			break;
	}
}

$_agree = _DIR_CONF."/text.agree.txt";
$agree = $CLASS_FILE->read($_agree);
$_policy1 = _DIR_CONF."/text.policy1.txt";
$policy1 = $CLASS_FILE->read($_policy1);
$_policy2 = _DIR_CONF."/text.policy2.txt";
$policy2 = $CLASS_FILE->read($_policy2);
$_policy3 = _DIR_CONF."/text.policy3.txt";
$policy3 = $CLASS_FILE->read($_policy3);
$_policy4 = _DIR_CONF."/text.policy4.txt";
$policy4 = $CLASS_FILE->read($_policy4);

$icon = $CLASS_USER->icon[$_SESSION['joinType']];

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"agree"=>$agree,
	"policy1"=>$policy1,
	"policy2"=>$policy2,
	"policy3"=>$policy3,
	"policy4"=>$policy4,
	"userid"=>$userid, 
	"name"=>$name, 
	"icon"=>$icon,
));
?>