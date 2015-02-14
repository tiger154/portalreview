<?php /* Template_ 2.2.4 2012/12/04 10:58:43 /www/revu39/engine/view/V3.9/_global/_frame.htm 000005605 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" xmlns:fb="http://www.facebook.com/2008/fbml">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# revulove: http://ogp.me/ns/fb/revulove#">
<title><?php echo $TPL_VAR["SITE"]["TITLE"]?>:::<?php echo $TPL_VAR["subject"]?></title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta http-equiv="imagetoolbar" content="no" />
<meta name="Subject" content="<?php echo $TPL_VAR["SITE"]["DOMAIN"]?>" />
<meta name="verify-v1" content="c7qPZTfB1pUMtQBmsxdVRpF2Rn4M5+mypsJhQ1yQds4=" />
<meta name="Author" content="<?php echo $TPL_VAR["SITE"]["NAME"]?>" />
<meta name="Publisher" content="<?php echo $TPL_VAR["DOMAIN"]?>" />
<meta name="Other Agent" content="<?php echo $TPL_VAR["SITE"]["EMAIL"]?>" />
<meta name="keywords" content="<?php echo $TPL_VAR["SITE"]["KEYWORDS"]?>" />
<meta property="fb:app_id" content="<?php echo $TPL_VAR["FACEBOOK_KEY"]?>" /> 
<meta property="og:type" content="<?php echo $TPL_VAR["FACEBOOK_NAMESPACE"]?>:<?php echo $TPL_VAR["facebookObject"]?>" /> 
<meta property="og:url" content="<?php echo $TPL_VAR["DOMAIN_URL"]?>" /> 
<meta property="og:title"  content="<?php echo $TPL_VAR["subject"]?>" />
<meta property="og:image"  content="<?php echo $TPL_VAR["top_thumbimg"]?>" />
<meta property="og:description"  content="레뷰 프론티어에 참여해보세요!" /> 
<meta property="revulove:starttime" content="<?php echo $TPL_VAR["fb_start_date"]?>" /> 
<meta property="revulove:endtime" content="<?php echo $TPL_VAR["fb_end_date"]?>" /> 
<meta property="og:locale" content="ko_KR" />
<meta property="og:locale:alternate" content="ko_KR" />
<link rel="shortcut icon" href="<?php echo $TPL_VAR["IMAGES"]?>/common/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo $TPL_VAR["IMAGES"]?>/common/favicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_layout.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_common.css" />
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
<script type='text/javascript'>var TBRUM=TBRUM||{};TBRUM.q=TBRUM.q||[];TBRUM.q.push(['mark','firstbyte',(new Date).getTime()]);(function(){var a=document.createElement('script');a.type='text/javascript';a.async=true;a.src=document.location.protocol+'//insight.torbit.com/v1/insight.min.js';var b=document.getElementsByTagName('script')[0];b.parentNode.insertBefore(a,b)})();</script>
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
<div id="wrap">
	<div id="top"><?php $this->print_("top",$TPL_SCP,1);?></div>
	<div class="clear"></div>
	<div id="middle">
		<div id="middle-container"><?php $this->print_("mframe",$TPL_SCP,1);?></div>
	</div>
	<div class="clear"></div>
	<div id="footer"><?php $this->print_("footer",$TPL_SCP,1);?></div>
</div>
<div id="loginlayer"><?php $this->print_("loginlayer",$TPL_SCP,1);?></div>
<?php $this->print_("etcscript",$TPL_SCP,1);?>

</body>
</html>