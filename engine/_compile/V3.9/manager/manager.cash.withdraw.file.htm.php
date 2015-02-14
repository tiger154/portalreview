<?php /* Template_ 2.2.4 2011/11/14 19:03:42 /www/revu39/engine/view/V3.9/manager/manager.cash.withdraw.file.htm 000000864 */ ?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/jquery.init.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.cash.js"></script>
<h2>닉네임:<?php echo $TPL_VAR["user"]["nickname"]?> / 회원명 : <?php echo $TPL_VAR["user"]["username"]?> / 아이디 : <?php echo $TPL_VAR["user"]["userid"]?> 님의 <?php echo $TPL_VAR["type_text"]?>정보</h2>
<form name="form1" id="form1">
<center>
	<img src="<?php echo $TPL_VAR["img"]?>" width="600" height="400" />
	<br /><br />
	<input type="button" value="닫기" onClick="common.popupClose();" />
</center>
</form>