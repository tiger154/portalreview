<?php /* Template_ 2.2.4 2012/06/04 09:25:56 /www/revu39/engine/view/V3.9/_global_search/_frame.htm 000008205 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
<title>검색어 :: 레뷰 - 세상 모든 것에 대한 리뷰</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Subject" content="<?php echo $TPL_VAR["SITE"]["DOMAIN"]?>" />
<meta name="verify-v1" content="c7qPZTfB1pUMtQBmsxdVRpF2Rn4M5+mypsJhQ1yQds4=" />
<meta name="Author" content="<?php echo $TPL_VAR["SITE"]["NAME"]?>" />
<meta name="Publisher" content="<?php echo $TPL_VAR["DOMAIN"]?>" />
<meta name="Other Agent" content="<?php echo $TPL_VAR["SITE"]["EMAIL"]?>" />
<meta name="keywords" content="<?php echo $TPL_VAR["SITE"]["KEYWORDS"]?>" />
<link rel="shortcut icon" href="<?php echo $TPL_VAR["IMAGES"]?>/common/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $TPL_VAR["IMAGES"]?>/common/favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style.css" />
<!--link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_common.css" /-->
<style type="text/css">
/* help > zindex 7 */
#context-user { display: none; overflow: hidden; position: absolute; z-index: 10; width:130px; height:226px; background:url(/images/myrevu/bg_pop_blog.gif) no-repeat; }
#context-user .box { width:130px; height:225px; background:url(/images/myrevu/bg_pop_blog2.gif) no-repeat;}
#context-user .thumbox {width:80px; height:109px; padding:22px 25px 0 25px;}
#context-user .thum{width:80px; height:80px; overflow:hidden;}
#context-user .text{width:80px; height:15px; margin:8px 0;overflow:hidden;}
#context-user .line{width:80px; height:25px;}

/* loginlayer > zindex 15 */
#loginlayer { display: none; position: absolute; z-index: 15; margin: 0; padding: 0px; width:298px; height:243px; background:#ffffff; border:#aaaaaa solid 1px; }
#loginlayer .title { width:298px; height:34px; background:url(/images/join/title_poplogin.gif) no-repeat;}
#loginlayer .title img { padding: 10px 15px 0 0; cursor: pointer;} 
#loginlayer .box { margin: 0; padding:25px 15px 30px 15px; width:270px;}
#loginlayer .box li {width:270px;}

/* login-tab */ 
#login-tab1 { display: block; }
#login-tab2 { display: none; }
#login-tab3 { display: none; }
#login-btn1 { display: block; }
#login-btn2 { display: none; }
#login-btn3 { display: none; }
#login-frontier1 { display: block; }
#login-frontier2 { display: none; }

/* log */  
.login_box {width:225px; height:175px; padding-bottom:40px;}
.login_input {width:225px; height:54px; background:url(/images/join/bg_idpw225.gif) no-repeat;}
.login_input_line {width:154px; height:54px; padding-right:10px;float:left; display:inline;}
.login_but {width:61px; height:54px;float:left; display:inline;} 
.logout_box {width:225px; height:274px; padding-bottom:40px; background:#ffffff;}
.logout_title {width:215px; height:16px; background:#666666; padding:8px 0 7px 10px;}
.logout_line1 {width:203px; height:18px; padding:7px 10px; border-bottom:#cccccc solid 1px;border-left:#cccccc solid 1px;border-right:#cccccc solid 1px;}
.logout_line2 {width:223px; height:171px; border-bottom:#cccccc solid 1px;border-left:#cccccc solid 1px;border-right:#cccccc solid 1px; position:relative;}
.logout_line2_text {width:203px; height:86px; padding:10px;}
.myblog_title {width:203px; height:13px; background:url(/images/join/title_myblog.gif) no-repeat;}
.mycash_line {width:101px; padding-bottom:9px; float:left; display:inline;}
.logout_line3 {width:203px; height:20px; padding:9px 10px; border-bottom:#cccccc solid 1px;border-left:#cccccc solid 1px;border-right:#cccccc solid 1px;}
.ico_newbox {width:73px;height:25px;background:url(/images/common/ico/ico_newbox.png) no-repeat;position:absolute;top:10px; left:0;}
.ico_bgbox_myfrontier {width:73px;height:25px;background:url(/images/common/ico/ico_bgbox.png) no-repeat;position:absolute;top:10px; left:74px;}
.ico_bgbox_mycash {width:73px;height:25px;background:url(/images/common/ico/ico_bgbox.png) no-repeat;position:absolute;top:10px; left:150px;}
.ico_bgbox_text {width:52px; height:8px; padding-top:11px; font-family:; font-size:11px;line-height:1.2; letter-spacing:-1px;color:#ffffff; text-align:right;}
</style>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/<?php echo $TPL_VAR["MODULE"]?>.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.ui/css/blitzer/jquery-ui-1.8.13.custom.css">
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/<?php echo $TPL_VAR["MODULE"]?>.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/common.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/layout.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/login.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/validation.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/jquery.init.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/context.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/api.js"></script>
<script type="text/javascript">
var DOMAIN = "<?php echo $TPL_VAR["DOMAIN"]?>";
var DOMAIN_FILE = "<?php echo $TPL_VAR["DOMAIN_FILE"]?>";
var MOUDLE = "<?php echo $TPL_VAR["MODULE"]?>";
var TODO = "<?php echo $TPL_VAR["TODO"]?>";
var REQUEST_URI = "<?php echo $TPL_VAR["REQUEST_URI"]?>";
var IMAGES = "<?php echo $TPL_VAR["IMAGES"]?>";
</script>
<!-- 구글 log 스크립트 -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5555634-2']);
  _gaq.push(['_setDomainName', 'revu.co.kr']);
  _gaq.push(['_setAllowLinker', true]);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<!-- 구글 log 스크립트 /-->

</head>
<body>
<div id="dialog"></div>
<div id="dialog2"></div>
<div id="dialog-modal"></div>
<div id="progressbar"></div>
<div id="popuplayer"></div>
<div id="bglayer"></div>
<div id="context-user"></div>
<div id="helplayer"></div>
<ul class="hiding">
	<li><a href="#content">검색결과 바로가기</a></li>
	<li><a href="#aside">소셜 로그인, 인기검색어 및 주간베스트 리뷰 바로가기</a></li>
</ul>
<hr>
<body>
<div id="wrap"> 
	<!-- header -->
	<div id="header"><?php $this->print_("top",$TPL_SCP,1);?></div>
	<hr>
	<div id="container">	
		<!-- snb -->
		<div class="snb" id="snb"><?php $this->print_("sidemenu",$TPL_SCP,1);?></div>
		<!-- // snb -->
		<hr>
		<div id="content"> 
		    <!-- middletop : 검색어제안,유사검색어,스폰서링크-->
<?php $this->print_("middletop",$TPL_SCP,1);?>

			<!--// middletop-->
			<hr>
			<!-- container : 검색결과-->
<?php $this->print_("container",$TPL_SCP,1);?>

            <!-- //container -->		
        </div>
		<hr>
		<!-- aside : 우측 프레임-->
		<div class="aside" id="aside">
<?php $this->print_("sidebar",$TPL_SCP,1);?> <!-- 로그인레이어 -->
<?php $this->print_("sidebar_search",$TPL_SCP,1);?> <!-- 기타 노출정보 -->
		</div>
		<!-- // aside -->
	</div>
	<!-- // container -->
	<hr>
	<!-- footer -->
	<div id="footer"><?php $this->print_("footer",$TPL_SCP,1);?></div>
	<!-- // footer -->
</div>
<!-- // wrap -->
</body>
</html>