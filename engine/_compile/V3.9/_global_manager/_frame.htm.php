<?php /* Template_ 2.2.4 2012/01/16 17:29:44 /www/revu39/engine/view/V3.9/_global_manager/_frame.htm 000003384 */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
<title><?php echo $TPL_VAR["SITE"]["NAME"]?> 관리자</title>
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
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_layout_manager.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_common.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/<?php echo $TPL_VAR["MODULE"]?>.css" />
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.ui/css/blitzer/jquery-ui-1.8.13.custom.css">
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.menu/apycom-orange/menu.css">
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery/jquery.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.ui/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.menu/apycom-orange/menu.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/<?php echo $TPL_VAR["MODULE"]?>.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/common.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/validation.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/jquery.init.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/api.js"></script>
<script type="text/javascript">
var DOMAIN = "<?php echo $TPL_VAR["DOMAIN"]?>";
var DOMAIN_FILE = "<?php echo $TPL_VAR["DOMAIN_FILE"]?>";
var MOUDLE = "<?php echo $TPL_VAR["MODULE"]?>";
var TODO = "<?php echo $TPL_VAR["TODO"]?>";
var REQUEST_URI = "<?php echo $TPL_VAR["REQUEST_URI"]?>";
var IMAGES = "<?php echo $TPL_VAR["IMAGES"]?>";
</script>
</head>
<body>
<div id="context-user"></div>
<div id="dialog"></div>
<div id="dialog2"></div>
<div id="dialog-modal"></div>
<div id="progressbar"></div>
<div id="popuplayer"></div>
<div id="wrap">
	<div id="top"><?php $this->print_("top",$TPL_SCP,1);?></div>
	<div id="middle">
		<div id="middle-container"><?php $this->print_("mframe",$TPL_SCP,1);?></div>
	</div>
	<div id="footer"><?php $this->print_("footer",$TPL_SCP,1);?></div>
</div>
</body>
</html>