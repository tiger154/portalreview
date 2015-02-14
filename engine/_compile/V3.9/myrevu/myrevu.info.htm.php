<?php /* Template_ 2.2.4 2012/10/04 16:20:35 /www/revu39/engine/view/V3.9/myrevu/myrevu.info.htm 000013603 */ 
$TPL_birth_year_1=empty($TPL_VAR["birth_year"])||!is_array($TPL_VAR["birth_year"])?0:count($TPL_VAR["birth_year"]);
$TPL_birth_month_1=empty($TPL_VAR["birth_month"])||!is_array($TPL_VAR["birth_month"])?0:count($TPL_VAR["birth_month"]);
$TPL_birth_day_1=empty($TPL_VAR["birth_day"])||!is_array($TPL_VAR["birth_day"])?0:count($TPL_VAR["birth_day"]);
$TPL_phone_number_1=empty($TPL_VAR["phone_number"])||!is_array($TPL_VAR["phone_number"])?0:count($TPL_VAR["phone_number"]);
$TPL_cate1_list_1=empty($TPL_VAR["cate1_list"])||!is_array($TPL_VAR["cate1_list"])?0:count($TPL_VAR["cate1_list"]);?>
<script>var area1 = "<?php echo $TPL_VAR["area1"]?>";var area2 = "<?php echo $TPL_VAR["area2"]?>"; var type = "<?php echo $_SESSION["type"]?>";</script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/area.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/file.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.info.js"></script>
<iframe name="frmFile" id="frmFile" width="0" height="0" frameborder="0"></iframe>

<form name="form1" id="form1" enctype="multipart/form-data">
<input type="hidden" id="tmpnickname" value="<?php echo $TPL_VAR["user"]['nickname']?>" />
<div class="title_line gray_l_text"><img src="/images/myrevu/title_join2.gif" /></div>
<table width="100%" border="0" cellspacing="0">
	<tr>
		<td class="block_text">이름</td>
		<td class="block_text2"><span class="black_text"><strong><?php echo $TPL_VAR["user"]['username']?></strong></span></td>
	</tr>
	<tr>
		<td class="block_text">아이디</td>
		<td class="block_text2">
<?php if($_SESSION["type"]=="R"){?>
			<span class="black_text"><strong><?php echo $TPL_VAR["user"]['userid']?></strong></span>
<?php }else{?>
			소셜 로그인 사용자의 계정정보는  레뷰에서 보유하고 있지 않습니다.
<?php }?>
		</td>
	</tr>
	<tr>
		<td class="block_text">비밀번호</td>
		<td class="block_text2">
<?php if($_SESSION["type"]=="R"){?>
			<input type="password" name="passwd" id="passwd" class="input_common input150" maxlength="20" />
			&nbsp;
			<span class="common11_text">* 비밀번호는 4~20자까지 입력 가능합니다.</span>
<?php }else{?>
			소셜 로그인 사용자의 계정정보는  레뷰에서 보유하고 있지 않습니다.
<?php }?>
		</td>
	</tr>
<?php if($_SESSION["type"]=="R"){?>
	<tr>
		<td class="block_text">비밀번호 확인</td>
		<td class="block_text2">
			<input type="password" name="passwd_confirm" id="passwd_confirm" class="input_common input150" maxlength="20" />
		</td>
	</tr>
<?php }?>
	<tr>
		<td class="block_text">닉네임</td>
		<td class="block_text2">
			<input type="text" name="nickname" id="nickname" class="input_common input150" maxlength="15" value="<?php echo $TPL_VAR["user"]['nickname']?>" />
			&nbsp;
			<img src="/images/common/but/but_g_repeat.gif" id="checkNickBtn" alt="중복확인" title="중복확인" class="btn"  style="margin-bottom:-6px;"/></a>
		</td>
	</tr>
	<tr>
		<td class="block_text">이메일</td>
		<td class="block_text2">
			<input type="text" name="email" id="email" class="input_common" value="<?php echo $TPL_VAR["user"]['email']?>"  style=" width:200px;"/>
			<input type="checkbox" name="flag_email" id="flag_email" value="0" <?php if($TPL_VAR["user"]['flag_email']=="0"){?>checked<?php }?> /> 이메일 수신거부			
		</td>
	</tr>
	<tr>
		<td class="block_text">프로필 사진</td>
		<td class="block_text2">
			<div>
				<ul>
					<li class="fl">
						<img src="<?php echo $TPL_VAR["imgsrc"]?>" id="profile_image" alt="프로필이미지" width="100" height="100" />
					</li>
					<li class="fl pl20 pb09">
						<span class="common11_text">* 본인을 표현하는 사진 또는 이미지를 등록해주세요.</span> 
					</li>
					<li  class="fl pl20">
						<!--<img src="/images/common/but/but_findimg.gif" alt="이미지찾기" title="이미지찾기"/>-->
						<input type="file" name="file1" id="file1" value=""  class="input_common"/><br />
						<input type="hidden" name="tmpimage" id="tmpimage" width="80" height="80" value="" />
					</li>
				</ul>
			</div>
		</td>
	</tr>
</table>
<!-- 필수 입력 폼 끝 -->

   <div class=pt40></div>
    
    <!-- SNS 연결정보 (2012.08.13 ) 시작 ------------------------------------------------------------>
    
    <!-- 연결하기 시작-->  
    <div class="title_line gray_l_text"><img align=left src="/images/myrevu/title_joinsns.gif"></div>
    <table border=0 cellSpacing=0 width="100%">
      <tbody>
        <tr>
          <td class=block_text>페이스북</td>
          <td class=block_text2><div class=pb09>
<?php if($TPL_VAR["user"]['fb_relation']> 0){?>
					<font color="3b5998"><b><?php echo $_SESSION["fb_nickname"]?></b></font>으로 연결 됨<a href="javascript:facebook.todo('snsLinkOff');"><img src="/images/myrevu/btn_snsoff.gif " title="연결해제" alt="페이스북 연결해제" style="margin:0 0 -6px 8px;"/></a>
<?php }else{?>
					 <a href="javascript:facebook.todo('snsLinkOn');"><img src="/images/myrevu/btn_snson.gif " title="연결하기" alt="페이스북 연결하기"/></a>	
<?php }?>
		    </div>			
            <div class=pb09>타임라인 연동 
<?php if($TPL_VAR["user"]['flag_opengraph']=='1'){?>
				<img src="/images/myrevu/btn_iconon_on.gif" style="margin-bottom:-4px" title="on" alt="타임라인 연동 on"/>
				<a href="javascript:facebook.todo('fbGraphOff');"><img src="/images/myrevu/btn_iconoff_off.gif" style="margin-bottom:-4px" title="off" alt="타임라인 연동 off"/></a>
<?php }else{?>
				<a href="javascript:facebook.todo('fbGraphOn');"><img src="/images/myrevu/btn_iconon_off.gif" style="margin-bottom:-4px" title="on" alt="타임라인 연동 off"/></a>
				<img src="/images/myrevu/btn_iconoff_on.gif" style="margin-bottom:-4px" title="off" alt="타임라인 연동 on"/>
<?php }?>
			</div>
			</td>
        </tr>
        <tr>
          <td class=block_text>트위터</td>
          <td class=block_text2>
<?php if($TPL_VAR["user"]['twit_relation']> 0){?>
				<font color="3b5998"><b><?php echo $_SESSION["twit_nickname"]?></b></font>으로 연결 됨<a href="javascript:twitter.todo('snsLinkOff');"><img src="/images/myrevu/btn_snsoff.gif " title="연결해제" alt="트위터 연결해제" style="margin:0 0 -6px 8px;"/></a>
<?php }else{?>
				<a href="javascript:twitter.todo('snsLinkOn');"><img src="/images/myrevu/btn_snson.gif " title="연결하기" alt="트위터 연결하기"/></a>
<?php }?>	
			</td>
        </tr>
      </tbody>
    </table>    
    
    <!-- SNS 연결정보 (2012.08.13 ) 끝 ---------------------------------------------------------------->



<div class="pt40"></div>

<!-- 선택 입력 폼 시작 -->
<div class="title_line gray_l_text"><img src="/images/myrevu/title_join3.gif"  align="left"/></div>
<table width="100%" border="0" cellspacing="0">
	<tr>
		<td class="block_text">생년월일<?php echo $TPL_VAR["birth"][ 0]?></td>
		<td class="block_text2">	
			<div class="pr10 fl">
				<select name="birth_year" id="birth_year">
					<option value="">년도선택</option>
<?php if($TPL_birth_year_1){foreach($TPL_VAR["birth_year"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["user_birthday"][ 0]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pr10 fl">
				<select name="birth_month" id="birth_month">
					<option value="">월선택</option>
<?php if($TPL_birth_month_1){foreach($TPL_VAR["birth_month"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["user_birthday"][ 1]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pr10 fl">
				<select name="birth_day" id="birth_day">
					<option value="">일선택</option>
<?php if($TPL_birth_day_1){foreach($TPL_VAR["birth_day"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["user_birthday"][ 2]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pt05 fl">
				<input type="radio" name="flag_lunar" value="0" <?php if($TPL_VAR["extra"]["flag_lunar"]=="0"){?>checked<?php }?>  class="h2_space"/>양력
				<input type="radio" name="flag_lunar" value="1" <?php if($TPL_VAR["extra"]["flag_lunar"]=="1"){?>checked<?php }?>  class="h2_space"/>음력
				&nbsp;&nbsp;&nbsp; &nbsp;
				<span class="gray_d_text"><strong>성별</strong></span>
				&nbsp;
				<input type="radio" name="gender" value="M" <?php if($TPL_VAR["extra"]["gender"]=="M"){?>checked<?php }?>  class="h2_space"/>
				<span class="common11_text">남</span>&nbsp;
				<input type="radio" name="gender" value="F" <?php if($TPL_VAR["extra"]["gender"]=="F"){?>checked<?php }?> class="h2_space"/>
				<span class="common11_text">여</span>
			</div>
			<div class="clear"></div>
		</td>
	</tr>
	<tr>
		<td class="block_text">휴대폰번호</td>
		<td class="block_text2">
			<select name="cell1">		
				<option value="">번호선택</option>
<?php if($TPL_phone_number_1){foreach($TPL_VAR["phone_number"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1?>" <?php if($TPL_VAR["user_cell"][ 0]==$TPL_V1){?>selected<?php }?>><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			&nbsp;-&nbsp;
			<input type="text" name="cell2" id="cell2" size="5" maxlength="4" class="input_common" value="<?php echo $TPL_VAR["user_cell"][ 1]?>" />
			&nbsp;-&nbsp;
			<input type="text" name="cell3" id="cell3" size="5" maxlength="4" class="input_common" value="<?php echo $TPL_VAR["user_cell"][ 2]?>" />
		</td>
	</tr>
	<tr>
		<td class="block_text">전화번호</td>
		<td class="block_text2">
			<input type="text" name="tel1" id="tel1" size="9" maxlength="3" class="input_common" value="<?php echo $TPL_VAR["user_tel"][ 0]?>" />&nbsp;-&nbsp;
			<input type="text" name="tel2" id="tel2" size="5" maxlength="4" class="input_common" value="<?php echo $TPL_VAR["user_tel"][ 1]?>" />&nbsp;-&nbsp;
			<input type="text" name="tel3" id="tel3" size="5" maxlength="4" class="input_common" value="<?php echo $TPL_VAR["user_tel"][ 2]?>" />
		</td>
	</tr>
	<tr>
		<td class="block_text">주소</td>
		<td class="block_text2">
			<div class="pb09">
				<input type="text" name="addrzip" id="addrzip" size="8" maxlength="6" class="input_common" value="<?php echo $TPL_VAR["extra"]["zipcode"]?>" readonly />
				&nbsp;&nbsp;
				<img src="/images/common/but/but_postno.gif" id="zipcodeBtn" alt="우편번호" title="우편번호" class="btn"   style="margin-bottom:-6px;"/>
			</div>
			<div class="pb09">
				<input type="text" name="addr1" id="addr1" size="40" maxlength="60" class="input_common" value="<?php echo $TPL_VAR["extra"]["addr1"]?>" readonly />
				&nbsp;&nbsp;
				<input type="text" name="addr2" id="addr2" size="40" maxlength="60" class="input_common" value="<?php echo $TPL_VAR["extra"]["addr2"]?>" />
			</div>
			<div class="pb09">
				<span class="common11_text">
					* 휴대폰/전화번호/주소 정보가 기입되지 않은 경우 이벤트 당첨에서 제외될 수 있으니, <br />
					정확하게 입력해주세요.
				</span>
			</div>
		</td>
	</tr>
	<tr>
		<td class="block_text">관심지역<br />(최대2개) </td>
		<td class="block_text2">
			<div class="pr10 fl">
				<select name="area_bcode1" id="areaBcodeCBox1" style="width:120px;"><option value="">지역선택</option></select>
			</div>
			<div class="pr10 fl">
				<select name="area_mcode1" id="areaMcodeCBox1" style="width:120px;"><option value="">지역선택</option></select>
				<!--<select name="area_scode1" id="areaScodeCBox1"><option value="">지역선택</option></select>-->
			</div>
			<div class="clear"></div>
			<div class="pb09"></div>
			<div class="pr10 fl">
				<select name="area_bcode2" id="areaBcodeCBox2" style="width:120px;"><option value="">지역선택</option></select> 
			</div>
			<div class="pr10 fl">
				<select name="area_mcode2" id="areaMcodeCBox2" style="width:120px;"><option value="">지역선택</option></select>
				<!--<select name="area_scode2" id="areaScodeCBox2"><option value="">지역선택</option></select>-->
			</div>
		</td>
	</tr>
	<tr>
		<td class="block_text"><p>관심분야<br />(최대2개)</p></td>
		<td class="block_text2">
<?php if($TPL_cate1_list_1){foreach($TPL_VAR["cate1_list"] as $TPL_V1){?> 
			<div class="pb09">
				<input type="checkbox" name="cate[]" value="<?php echo $TPL_V1["cate1"]?>" <?php if($TPL_VAR["cate1"]==$TPL_V1["cate1"]||$TPL_VAR["cate2"]==$TPL_V1["cate1"]){?>checked<?php }?>  class="h2_space"/> 
				<?php echo $TPL_V1["cate_desc"]?> (<?php if(is_array($TPL_R2=$TPL_V1["cate2_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?> <?php echo $TPL_V2["cate_desc"]?><?php }}?> ...)
			</div>
<?php }}?>
		</td>
	</tr>
</table>

<!-- 선택 입력 폼 끝 -->
<div style="width:680px; height:22px; padding:10px 0 0 25px; text-align:left;">
	<a href="javascript:common.redirect('/myrevu/secede');"><span class="gray_stitle">* 회원 탈퇴하기</span></a> 
</div>
<div class="pt40"></div>
<center>	
	<img src="/images/common/but/but_gb_save.gif" id="saveBtn" alt="저장하기" title="저장하기" class="btn" />
</center>
<div class="pt40"></div>
<div id="zipcodelayer"><?php $this->print_("zipcode",$TPL_SCP,1);?></div>	
</form>