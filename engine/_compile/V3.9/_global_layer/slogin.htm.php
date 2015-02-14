<?php /* Template_ 2.2.4 2012/01/17 13:48:16 /www/revu39/engine/view/V3.9/_global_layer/slogin.htm 000002296 */ ?>
<!-- 로그인 팝업 -->
<ul>
	<li class="title">
		<img src="/images/common/but/but_w_xclose.gif" align="right" alt="닫기" title="닫기" onClick="common.closeLayer('loginlayer');" />
	</li>
	<li class="box">
		<!-- 로그인입력 박스 -->
		<ul>
			<li style="height:19px;">
				<img src="/images/join/title_snsin.gif" style="margin-right:35px;" /><img src="/images/join/title_twitterin.gif" id="twitterBtn" alt="트위터" title="트위터" class="btn" /><img src="/images/join/title_facebookin.gif" id="facebookBtn" alt="페이스북" title="페이스북" class="btn" />		
			</li>
			<li style="height:17px; background:url(/images/common/bg/line_log17.gif) repeat-x;"></li>
			<li class="login_input">
				<div class="login_input_line">
					<ul>
						<li style="padding:6px 0 3px 37px;">
							<input type="text" name="login_userid3" id="login_userid3" value="<?php echo $_COOKIE["userid"]?>" class="input_trans" />
						</li>
						<li style="padding:10px 0 3px 37px;">
							<input type="password" name="login_passwd3" id="login_passwd3" value="" class="input_trans" />
						</li>
					</ul>
				</div>
				<div class="login_but">
					<img src="/images/common/but/but_login.gif" alt="로그인" title="로그인" style="margin-left:35px;" onClick="login.slogin('login_userid3','login_passwd3', 'login_saveid3', '<?php echo $TPL_VAR["REQUEST_URI"]?>');" class='btn' />
				</div>
			</li>
			<li class="clear"></li>
			<li style="height:15px; background:url(/images/common/bg/line_log15.gif) repeat-x;"></li>
			<li style="height:29px; padding-top:15px; text-align:center;">
				<img src="/images/join/title_joinin.gif" alt="회원가입" title="회원가입" onClick="common.redirect('/join');" class="btn" /><img src="/images/join/title_idpwin.gif" alt="ID/PW찾기" title="ID/PW찾기" onClick="common.redirect('/auth/idpw');" class="btn" /><a href="http://blog.revu.co.kr/2137" target="blank"><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_socialinfo.gif" id="snsInfoBtn" alt="소셜로그인안내" title="소셜로그인안내" class="btn" /></a>
			</li>
		</ul>
		<!-- 로그인입력 박스  끝-->
	</li>
</ul>