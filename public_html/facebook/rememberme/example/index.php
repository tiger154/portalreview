<?php
// Include PHP before any content is generated to we can set cookies
// Sets the $content variable with the dynamic page content
include "./action_db.php";
//phpinfo();



$db_opt = array ("tableName"=>"Ru_rememberme","credentialColumn"=>"credential","tokenColumn"=>"token","persistentTokenColumn"=>"persistent_token","expiresColumn"=>"expires");
$mysqli_connection_tmp = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");
$rPDO = new Rememberme_Storage_PDO($db_opt);
$rPDO->setConnection($mysqli_connection_tmp);

//print_r($_SESSION);
$rememberMe = new Rememberme($rPDO);
$user = '10003485931';


define("_DOMAIN", $_SERVER['HTTP_HOST']);
ini_set("session.cookie_domain", _DOMAIN); // ���ǰ��� �����ΰ� ** .revu.co.kr �� �ҽ� ���굵���� ���Ե�
session_cache_limiter('nocache, must-revalidate'); //ĳ�� ������
session_set_cookie_params(0, "/", _DOMAIN); //��Ű ����ð� 0:������ ������������, �ð������� �ش� �ð����� ���� ��) 30�� $lifetime = 60*60*24*30;
// If browser is closed, sessionID is expired. so we can only check both credential value and persistent_token via cookie decripted value 
// not sessionID 
session_start(); // ���� �ʱ�ȭ�� ���ؼ� �ʼ�

//echo session_id()."</br>";
//echo $_COOKIE["PHP_REMEMBERME"]."</br>";
if(!empty($_SESSION['fb_unit_username'])){
	// �α��� �����̹Ƿ� ������ �۾��� ����.
	// �ٸ� �α��� ����������, ��Ű ��ȿ(�Ⱓ)�� ����� ��쿡�� üũ �� ���� �����Ѵ�.
	if(!empty($_COOKIE[$rememberMe->getCookieName()]) && !$rememberMe->cookieIsValid($_SESSION['fb_unit_username'])) {
     echo "Error occured(cookie is exists, invalied cookie value) it's mean cookie is deleted or cookie is expired";
   }
}else{ // invalid/missing Rememberme cookie - normal login process
	 $loginresult = $rememberMe->login();
	 if($loginresult) { // �̷α����̸�, ��Ű����, ��Ű�� ��ū �� �ĺ��ڰ� �����ϴٸ�, ��ū �� ������� ���� ����
	 //session_regenerate_id();
     $_SESSION['fb_unit_username'] = $loginresult; //�α��� ���� �ִٸ� ���̵� �� ���� ���� ���� ����
    // There is a chance that an attacker has stolen the login token, so we store
    // the fact that the user was logged in via RememberMe (instead of login form)
     $_SESSION['fb_unitremembered_by_cookie'] = true;
	
	 } else {// userID ��� ��ū �Ǵ� �ĺ��ڰ� �ٸ�.
		 if($rememberMe->loginTokenWasInvalid()) { // ��ū ���� �ٸ��ٸ�.
		  echo "������ ���İ�";
		} else { // �̷α��� �����̸�, ��ū ���� ���� �ϴٸ�.
			$_SESSION['fb_unit_username'] = $user; 
			$rememberMe->createCookie($user);
		}

	 }
}









//$rtState = $rPDO->findTriplet('test', '78b1e6d775cec5260001af137a79dbd5', '0e0530c1430da76495955eb06eb99d95');






?>
<!doctype html>

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Rememberme PHP library test</title>
  <meta name="author" content="Gabriel Birke">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css?v=2">
</head>

<body>

  <div id="container">
    <header>
      <h1>Rememberme PHP library test</h1>
    </header>
    
    <div id="main">
      <?php
      // Output generated content
      //echo $content;
      ?>
    </div>
    
    <footer>

    </footer>
  </div> <!-- end of #container -->
  
</body>
</html>