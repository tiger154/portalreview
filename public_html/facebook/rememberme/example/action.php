<?php
/**
 * This file demonstrates how to use the Rememberme library.
 *
 * Some code (autoload, templating) is just simple boilerplate and no shining
 * example of how to write php applications.
 *
 * @author Gabriel Birke
 */

/**
 * Very simplicistic and inefficient autoload class so I don't have to require all the files
 * @param  $class
 * @return void
 */
function rememberAutoload($class) {
  require dirname(__FILE__).'/../src/'.strtr($class,'_',DIRECTORY_SEPARATOR).".php";
 // echo '/../src/'.strtr($class,'_',DIRECTORY_SEPARATOR).".php";
}
spl_autoload_register("rememberAutoload");

/**
 * Helper function for redirecting and destroying the session
 * @param bool $destroySession
 * @return void
 */
function redirect($destroySession=false) {
  if($destroySession) {
    session_regenerate_id(true);
    session_destroy();
  }
  header("Location: index.php");
  exit;
}

// Normally you would store the credentials in a DB
$username = "demo";
$password = "demo";

// Initialize RememberMe Library with file storage
$storagePath = dirname(__FILE__)."/tokens";
if(!is_writable($storagePath) || !is_dir($storagePath)) {
    die("'$storagePath' does not exist or is not writable by the web server.
            To run the example, please create the directory and give it the
            correct permissions.");
}
$storage = new Rememberme_Storage_File($storagePath);
$rememberMe = new Rememberme($storage);

// First, we initialize the session, to see if we are already logged in
session_start();

echo $_COOKIE[$rememberMe->getCookieName()];

// 유저 네임이 있으면!!!!
// 글고 로그아웃 체크되어있음...
// 쿠키 제거해분다..! 
if(!empty($_SESSION['username'])) {
	  if(!empty($_GET['logout'])) {
		$rememberMe->clearCookie($_SESSION['username']);
		redirect(true);
	  }

	 // 모든 브라우저에 대해서 로그아웃 체크되어있으면!!!
	 // 세가지(이름,식별자,토큰) 싹 제거해분다.
	  if(!empty($_GET['completelogout'])) {
		$storage->cleanAllTriplets($_SESSION['username']);
		redirect(true);
	  }

	  // Check, if the Rememberme cookie exists and is still valid.
	  // If not, we log out the current session
	 // 쿠키 존재하고 아직 유효한지 체크한다! 축하한다. id,identfier,token 동일하네 너 정상이여.
	 // 만약 아니면... 우린 현재 세션에서 빠져나가분다!!!!

	  if(!empty($_COOKIE[$rememberMe->getCookieName()]) && !$rememberMe->cookieIsValid($_SESSION['username'])) {
		redirect(true);
	  }

	  // User is still logged in - show content
	  // 아직 로그인 중이잖아...
	  $content = tpl("user_is_logged_in");
}
// If we are not logged in, try to log in via Rememberme cookie
// 로그인 안했고!!!, 쿠키로 로그인 하려면이여! 
else {
  // If we can present the correct tokens from the cookie, we are logged in
  // *** 축하한다. id,identfier,token 동일하네 너 정상이여.
  $loginresult = $rememberMe->login();
  if($loginresult) {
    $_SESSION['username'] = $loginresult;
    // There is a chance that an attacker has stolen the login token, so we store
    // the fact that the user was logged in via RememberMe (instead of login form)
	// ** 그래도 혹시.. 너가 해커일지도 모르니까... 쿠키로 로그인됬다고 저장한다잉.
    $_SESSION['remembered_by_cookie'] = true;
    redirect();
  }
  else {
    // If $rememberMe returned false, check if the token was invalid
    if($rememberMe->loginTokenWasInvalid()) {
      $content = tpl("cookie_was_stolen");  // 쿠키 누가 훔쳐갔다잉!!
    }
    // $rememberMe returned false because of invalid/missing Rememberme cookie - normal login process
    else {
      if(!empty($_POST)) {
        if($username == $_POST['username'] && $password == $_POST['password']) {
          session_regenerate_id();
          $_SESSION['username'] = $username; // username : demo 
          // If the user wants to be remembered, create Rememberme cookie
		  // ** 별표!!! 리멤버미 체크되어있다문 쿠키 생성해부려라!
          if(!empty($_POST['rememberme'])) {
            $rememberMe->createCookie($username); // 쿠키명 demo에 암호화 쿠키 생성 하는거야(id,identifier,token)
          }
          else {
            $rememberMe->clearCookie();
          }
          redirect();
        }
        else {
          $content = tpl("login", "Invalid credentials");
        }
      }
      else {
        $content = tpl("login");
      }
    }
  }
}

// template function for including content, nothing interesting
function tpl($template, $msg="") {
  $fn = dirname(__FILE__). DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $template . ".php";
  if(file_exists($fn)) {
    ob_start();
    include $fn;
    return ob_get_clean();
  }
  else {
    return "Template $fn not found";
  }
}