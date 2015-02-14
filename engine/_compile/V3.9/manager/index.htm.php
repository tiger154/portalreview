<?php /* Template_ 2.2.4 2011/11/15 15:08:08 /www/revu39/engine/view/V3.9/manager/index.htm 000002294 */ ?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.login.js"></script>
<div id="login-form">
	<div class="login-box">
		<div class="login-box-top"></div>
		<div class="login-box-container">
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/text_login.gif" alt="LOGIN" class="login-img" />			
			<p><span class="login-title"><?php echo $TPL_VAR["SITE"]["NAME"]?>관리자</span></p>
			<div class="login-box-content">
				<div class="bh10"></div>
<?php if($_SESSION["userno"]!=""){?>
				<form name="loginForm" id="loginForm">
				<div class="login-box-info">
					<dl>
						<dt><img src="<?php echo $_SESSION["userimage"]?>" width="80" height="60" /></dt>
						<dd><span class="text-login"><?php echo $_SESSION["nickname"]?></span>님</dd>
					</dl>
				</div>
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/btn_logout.gif" id="logoutBtn" value="로그아웃" class="btn" />
				</form>
<?php }else{?>
				<form name="loginForm" id="loginForm">
				<div class="login-box-form">
					<dl>
						<!--<dt>아이디</dt>-->
						<dt><img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/text_login_id.gif" alt="아이디" /></dt>
						<dd><input type="text" class="input_trans" name="login_userid" id="login_userid" value="<?php echo $_COOKIE["userid"]?>" /><br /></dd>
					</dl>
					<div class="clear"></div>
					<dl>
						<!--<dt>비밀번호</dt>-->
						<dt><img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/text_login_pw.gif" alt="비밀번호" /></dt>
						<dd><input type="password" class="input_trans" name="login_passwd" id="login_passwd" value="" /></dd>
					</dl>
					<div class="clear"></div>
				</div>
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/btn_login.gif" id="loginBtn" alt="로그인" title="로그인" class="btn" />
				<div class="clear"></div>
				<div class="link">
					<input type="checkbox" name="saveid" id="saveid" value="1" <?php if($_COOKIE["saveid"]=="1"){?>checked<?php }?> /><span class="text-link">아이디저장</span>
				</div>
				</form>
<?php }?>
				<div class="clear"></div>
			</div>
		</div>
		<div class="login-box-bottom"></div>
	</div>
</div>