<?php /* Template_ 2.2.4 2012/09/20 11:13:37 /www/revu39/engine/view/V3.9/_global/sidebar.htm 000011675 */ ?>
<form name="loginForm" id="loginForm">
<?php if($_SESSION["userid"]!=''){?>

<!-- 로그아웃 박스_블로그 -->
<div class="logout_box">
	<!-- 아뒤 종류에 따라 아이콘 변경 / ico_revu.gif /ico_twitter.gif / ico_facebook.gif -->
	<div class="logout_title">
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_<?php echo $_SESSION["type"]?>.gif" alt="회원타입" style="margin:0 10px -4px 0;" />		
<?php if($_SESSION["fb_189402831149686_user_id"]> 0){?>
		<img src="http://www.revu.co.kr/images/common/ico/ico_F.gif" style="margin:0 10px -4px 0;">
<?php }?>
<?php if($_SESSION["access_token"]["user_id"]> 0){?>
		<img src="http://www.revu.co.kr/images/common/ico/ico_T.gif" style="margin:0 10px -4px 0;">
<?php }?>	
		<span class="white11_text">			
			<strong><?php echo $_SESSION["nickname"]?></strong>&nbsp;&nbsp;님
<?php if($_SESSION["flag_powerblog"]=="1"){?><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" alt="파워블로거" title="파워블로거" align="bottom" /><?php }?>
		</span>
		<!--<img src="<?php echo $_SESSION["userimage"]?>" alt="회원이미지" />-->
	</div>
	<div class="logout_line1">
		<ul>
			<li class="common11_text fl" style="width:142px;">
				<a href="javascript:common.redirect('/myrevu');" id="myReviewBtn">마이레뷰</a>&nbsp;
				<span class="gray_lc_text">|</span>&nbsp;
				<a href="javascript:common.redirect('/myrevu/info');" id="myReviewBtn">회원정보수정</a>
				<!--<input type="button" id="reviewRegBtn" value="리뷰등록하기" onClick=""/>-->
			</li>
			<li class="fl" style="width:61px;">
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_w_logout.gif" id="logoutBtn" alt="로그아웃" title="로그아웃" class="btn" />
			</li>
		</ul>
  	</div>
  	<div class="logout_line2">
  		<ul id="login-tab1">
  			<li class="fl" style="height:65px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_on1.gif" alt="블로그" title="블로그" class="loginTabBtn1 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off2.gif"  alt="프론티어" title="프론티어" class="loginTabBtn2 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off3.gif"  alt="나의활동" title="나의활동" class="loginTabBtn3 btn"/>
  			</li>
  			<li class="clear"></li>
  			<li>
  				<div class="logout_line2_text">
  					<ul>
  					<!-- 블로그 내용 -->
<?php if($_SESSION["blog_cnt"]> 0){?>
  						<!--<li class="myblog_title">-->
  						<li>
  							나의 블로그
  							<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_plus.gif" id="blogAddBtn" align="right" alt="추가" title="추가" class="btn" />
  						</li>
  						<li class="pb15"></li>
<?php if(is_array($TPL_R1=$_SESSION["blog_list"])&&!empty($TPL_R1)){$TPL_I1=-1;foreach($TPL_R1 as $TPL_V1){$TPL_I1++;?>
  						<li class="pb09">
  							<div id="login-tab-blog<?php echo $TPL_I1?>">
	  							<a href="<?php echo $TPL_V1["url"]?>" target="_blank"><span class="common11_text"><?php echo $TPL_V1["name"]?></span></a>&nbsp;&nbsp;<span class="red11_text">(<?php echo $TPL_V1["review_cnt"]?>)</span>
  							</div>
  						</li>
<?php }}?>
  						<!-- 등록한 블로그가 없을때 -->
<?php }else{?>
  						<!--<li class="myblog_title">-->
  						<li>
  							나의 블로그
  							<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_plus.gif" id="blogAddBtn" align="right" alt="추가" title="추가" class="btn" /></a>
  						</li>
  						<li class="pb25"></li>
  						<li class="common11_text"><center>등록한 블로그가 없습니다.</center></li>
<?php }?>
  					</ul>
  				</div>
  			</li>
  		</ul>
		
  		<ul id="login-tab2">
			<li class="fl" style="height:65px;">
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off1.gif" alt="블로그" title="블로그" class="loginTabBtn1 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_on2.gif"  alt="프론티어" title="프론티어" class="loginTabBtn2 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off3.gif"  alt="나의활동" title="나의활동" class="loginTabBtn3 btn" />
			</li>
			<li class="clear"></li>
			<li>
				<div id="login-frontier1" class="logout_line2_text">
					<ul>
						<li style="height:13px;">
							<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_myfrontier_on1.gif" alt="당첨된프론티어" title="당첨된프론티어" class="loginFrontierBtn1 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_myfrontier_off2.gif"  alt="응모중인프론티어" title="응모중인프론티어" class="loginFrontierBtn2 btn"/>
						</li>
<?php if($_SESSION["frontier_cnt1"]> 0){?>
						<li class="pb15"></li>
<?php if(is_array($TPL_R1=$_SESSION["frontier_list1"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<li class="pb09">
							<a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_top"><span class="common11_text"><font color=#336633><?php echo $TPL_V1["title"]?></font></span></a>&nbsp;
						</li>
<?php }}?>
<?php }else{?>
						<li class="pb25"></li>
						<li class="common11_text"><center>당첨된 프론티어가 없습니다.</center></li>
<?php }?>
					</ul>
				</div>				
				<div id="login-frontier2" class="logout_line2_text">
					<ul>
						<li style="height:13px;">
							<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_myfrontier_off1.gif" alt="응모중인프론티어" title="응모중인프론티어" class="loginFrontierBtn1 btn"/><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_myfrontier_on2.gif"  alt="응모중인프론티어" title="응모중인프론티어" class="loginFrontierBtn2 btn"/>
						</li>
<?php if($_SESSION["frontier_cnt2"]> 0){?>
						<li class="pb15"></li>
<?php if(is_array($TPL_R1=$_SESSION["frontier_list2"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
						<li class="pb09">
							<a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_top"><span class="common11_text"><font color=#6633FF><?php echo $TPL_V1["title"]?></font></span></a>&nbsp;
						</li>
<?php }}?>
<?php }else{?>
						<!-- 프론티어 내용  / 대기중인 없을때-->
						<li class="pb25"></li>
						<li class="common11_text"><center>응모중인 프론티어가 없습니다.</center></li>
<?php }?>
					</ul>
				</div>
			</li>
		</ul>

		<ul id="login-tab3">
			<li class="fl" style="height:65px;">
				<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off1.gif" alt="블로그" title="블로그" class="loginTabBtn1 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_off2.gif"  alt="프론티어" title="프론티어" class="loginTabBtn2 btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/logtab_on3.gif"  alt="나의활동" title="나의활동" class="loginTabBtn3 btn" />
			</li>
			<li class="clear"></li>
			<li>
				<!-- 나의활동 내용 -->
				<div id="mycash_in" class="logout_line2_text" >
					<ul>
						<li class="mycash_line common11_text">캐쉬적립&nbsp;<a href="javascript:common.redirect('/myrevu/cash')"><span class="red11_text2" id="login-tab-cash"><?php echo $_SESSION["cash"]?></span></a></li>
						<li class="mycash_line common11_text">추천수&nbsp;<span class="red11_text2" id="login-tab-recom-cnt"><?php echo $_SESSION["recom_cnt"]?></span></li>
						<li class="clear"></li>
						<li class="mycash_line common11_text">&nbsp; </li>
						<li class="mycash_line common11_text">&nbsp;</li>
						<li class="clear"></li>
						<li style="31px;">
							<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_r_review.gif" id="reviewRegBtn" alt="리뷰등록하기" title="리뷰등록하기" class="btn" />
						</li>
					</ul>
				</div>
				<!-- 활동내용이 없을때 -->
				<div id="mycash_none" class="logout_line2_text" style="display:none;">
					<ul>
						<li class="pb25"></li>
						<li class="common11_text"><center>활동내용이 없습니다.</center></li>
					</ul>
				</div>
			</li>
		</ul>
		
	</div>
  	<div class="logout_line3">
  		<ul id="login-btn1">
  			<li class="common11_text fl" style="width:150px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_tx_more.gif" id="moreBtn1" alt="더보기" title="더보기" class="btn" />
  			</li>
  			<li class="fr" style="width:38px; height:17px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_f5.gif" id="refreshBtn1" alt="새로고침" title="새로고침" class="btn" />
  			</li>
  		</ul>
  		<ul id="login-btn2">
  			<li class="common11_text fl" style="width:150px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_tx_more.gif" id="moreBtn2" alt="더보기" title="더보기" class="btn" />
  			</li>
  			<li class="fr" style="width:38px; height:17px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_f5.gif" id="refreshBtn2" alt="새로고침" title="새로고침" class="btn" />
  			</li>
  		</ul>
  		<ul id="login-btn3">
  			<li class="common11_text fl" style="width:150px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_tx_more.gif" id="moreBtn3" alt="더보기" title="더보기" class="btn" />
  			</li>
  			<li class="fr" style="width:38px; height:17px;">
  				<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_f5.gif" id="refreshBtn3" alt="새로고침" title="새로고침" class="btn" />
  			</li>
  		</ul>
  	</div>
</div>
<?php }else{?>

<!-- 로그인 박스 -->
<div class="login_box">
	<ul>
		<li style="height:31px;"><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_login.gif" /></li>
		<li style="height:10px;"></li>
		<li style="height:19px;">			
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_snsin.gif" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_twitterin.gif" id="twitterBtn" alt="트위터" title="트위터" class="btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_facebookin.gif" id="facebookBtn" alt="페이스북" title="페이스북" class="btn" />					
		</li>
		<li style="height:17px; background:url(<?php echo $TPL_VAR["IMAGES"]?>/common/bg/line_log17.gif) repeat-x;"></li>
		<li class="login_input">
			<div class="login_input_line">
				<ul>
					<li style="padding:6px 0 3px 37px;">
						<input type="text" class="input_trans" name="login_userid" id="login_userid" value="<?php echo $_COOKIE["userid"]?>" />
					</li>
					<li style="padding:10px 0 3px 37px;">
						<input type="password" class="input_trans" name="login_passwd" id="login_passwd" value="" />
					</li>
				</ul>
			</div>
			<div class="login_but">
				<a href="#"><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_login.gif" id="loginBtn" alt="로그인" title="로그인" /></a>
			</div>
		</li>
		<li class="clear"></li>
		<li style="height:15px; background:url(<?php echo $TPL_VAR["IMAGES"]?>/common/bg/line_log15.gif) repeat-x;"></li>
		<li style="height:29px;">
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_joinin.gif" id="joinSiteBtn" alt="회원가입" title="회원가입" class="btn" /><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_idpwin.gif" id="searchInfoBtn" alt="ID/PW찾기" title="ID/PW찾기" class="btn" /><a href="http://blog.revu.co.kr/2137" target="blank"><img src="<?php echo $TPL_VAR["IMAGES"]?>/join/title_socialinfo.gif" id="snsInfoBtn" alt="소셜로그인안내" title="소셜로그인안내" class="btn" /></a>
		</li>
	</ul>
</div>
<?php }?>
</form>