<?php /* Template_ 2.2.4 2011/11/09 16:03:25 /www/revu39/engine/view/V3.9/join/join.step1.htm 000009431 */ 
$TPL_birth_year_1=empty($TPL_VAR["birth_year"])||!is_array($TPL_VAR["birth_year"])?0:count($TPL_VAR["birth_year"]);
$TPL_birth_month_1=empty($TPL_VAR["birth_month"])||!is_array($TPL_VAR["birth_month"])?0:count($TPL_VAR["birth_month"]);
$TPL_birth_day_1=empty($TPL_VAR["birth_day"])||!is_array($TPL_VAR["birth_day"])?0:count($TPL_VAR["birth_day"]);
$TPL_phone_number_1=empty($TPL_VAR["phone_number"])||!is_array($TPL_VAR["phone_number"])?0:count($TPL_VAR["phone_number"]);
$TPL_cate1_list_1=empty($TPL_VAR["cate1_list"])||!is_array($TPL_VAR["cate1_list"])?0:count($TPL_VAR["cate1_list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/file.js"></script>
<iframe name="frmFile" id="frmFile" width="0" height="0" frameborder="0"></iframe>

<form name="form1" id="form1" enctype="multipart/form-data">
<div class="title_line gray_l_text"><img src="/images/myrevu/title_join1.gif" /></div>
<div class="pb25"><img src="/images/myrevu/img_joinstep2.gif" /></div>
<div class="title_line gray_l_text"><img src="/images/myrevu/title_join2.gif" /></div>
<table width="100%" border="0" cellspacing="0">
	<tr>
		<td class="block_text">이름</td>
		<td class="block_text2">
			<input type="text" name="username" id="username" class="input_common input150" maxlength="20" />
			&nbsp;
			<span class="common11_text">* 실명확인이 되지 않을 경우 캐쉬 출금이 불가능할 수 있습니다.</span>
		</td>
	</tr>
	<tr>
		<td class="block_text">아이디</td>
		<td class="block_text2">
			<input type="text" name="userid" id="userid" class="input_common input150" maxlength="12" />	
			&nbsp;
			<img src="/images/common/but/but_g_repeat.gif" id="checkIDBtn" alt="중복확인" title="중복확인" class="btn" />
			&nbsp;
			<span class="common11_text">* 영문, 숫자, -, _만 허용합니다. 4~12자까지 입력 가능합니다.</span>
		</td>
	</tr>
	<tr>
		<td class="block_text">비밀번호</td>
		<td class="block_text2">
			<input type="password" name="passwd" id="passwd" class="input_common input150" maxlength="20" />
			&nbsp;
			<span class="common11_text">* 비밀번호는 4~20자까지 입력 가능합니다.</span>
		</td>
	</tr>
	<tr>
		<td class="block_text">비밀번호 확인</td>
		<td class="block_text2">
			<input type="password" name="passwd_confirm" id="passwd_confirm" class="input_common input150" maxlength="20" />
		</td>
	</tr>
	<tr>
		<td class="block_text">닉네임</td>
		<td class="block_text2">
			<input type="text" name="nickname" id="nickname" class="input_common input150" maxlength="15" />
			&nbsp;
			<img src="/images/common/but/but_g_repeat.gif" id="checkNickBtn" alt="중복확인" title="중복확인" class="btn" /></a>
		</td>
	</tr>
	<tr>
		<td class="block_text">이메일</td>
		<td class="block_text2">
			<input type="text" name="email" id="email" class="input_common"  style=" width:200px;"/>
		</td>
	</tr>
	<tr>
		<td class="block_text">프로필 사진</td>
		<td class="block_text2">
			<div>
				<ul>
					<li class="fl">
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/thum/thum_080080.gif" id="profile_image" alt="프로필이미지" />
					</li>
					<li class="fl pl20 pb09">
						<span class="common11_text">* 본인을 표현하는 사진 또는 이미지를 등록해주세요.</span> 
					</li>
					<li  class="fl pl20">
						<!--<img src="/images/common/but/but_findimg.gif" alt="이미지찾기" title="이미지찾기"/>-->
						<input type="file" name="file1" id="file1" value=""  class="input_common"/><br />
						<input type="hidden" name="tmpimage" id="tmpimage" value="" />
					</li>
				</ul>
			</div>
		</td>
	</tr>
</table>
<!-- 필수 입력 폼 끝 -->

<div class="pt40"></div>

<!-- 선택 입력 폼 시작 -->
<div class="title_line gray_l_text"><img src="/images/myrevu/title_join3.gif"  align="left"/></div>
<table width="100%" border="0" cellspacing="0">
	<tr>
		<td class="block_text">생년월일</td>
		<td class="block_text2">	
			<div class="pr10 fl">
				<select name="birth_year" id="birth_year">
					<option value="">년도선택</option>
<?php if($TPL_birth_year_1){foreach($TPL_VAR["birth_year"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pr10 fl">
				<select name="birth_month" id="birth_month">
					<option value="">월선택</option>
<?php if($TPL_birth_month_1){foreach($TPL_VAR["birth_month"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pr10 fl">
				<select name="birth_day" id="birth_day">
					<option value="">일선택</option>
<?php if($TPL_birth_day_1){foreach($TPL_VAR["birth_day"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
				</select>
			</div>
			<div class="pt05 fl">
				<input type="radio" name="flag_lunar" value="0"  class="h2_space"/>양력
				<input type="radio" name="flag_lunar" value="1"  class="h2_space"/>음력
				&nbsp;&nbsp;&nbsp; &nbsp;
				<span class="gray_d_text"><strong>성별</strong></span>
				&nbsp;&nbsp;
				<input type="radio" name="gender" value="M"  class="h2_space"/>
				<span class="common11_text">남</span>&nbsp;
				<input type="radio" name="gender" value="F"  class="h2_space"/>
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
				<option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option>
<?php }}?>
			</select>
			&nbsp;-&nbsp;
			<input type="text" name="cell2" id="cell2" size="5" maxlength="4" class="input_common" />
			&nbsp;-&nbsp;
			<input type="text" name="cell3" id="cell3" size="5" maxlength="4" class="input_common" />
		</td>
	</tr>
	<tr>
		<td class="block_text">전화번호</td>
		<td class="block_text2">
			<input type="text" name="tel1" id="tel1" size="9" maxlength="3" class="input_common" />&nbsp;-&nbsp;
			<input type="text" name="tel2" id="tel2" size="5" maxlength="4" class="input_common" />&nbsp;-&nbsp;
			<input type="text" name="tel3" id="tel3" size="5" maxlength="4" class="input_common" />
		</td>
	</tr>
	<tr>
		<td class="block_text">주소</td>
		<td class="block_text2">
			<div class="pb09">
				<input type="text" name="addrzip" id="addrzip" size="8" maxlength="6" class="input_common" readonly />
				&nbsp;&nbsp;
				<img src="/images/common/but/but_postno.gif" id="zipcodeBtn" alt="우편번호" title="우편번호" class="btn" />
			</div>
			<div class="pb09">
				<input type="text" name="addr1" id="addr1" size="40" maxlength="60" class="input_common" readonly />
				&nbsp;&nbsp;
				<input type="text" name="addr2" id="addr2" size="40" maxlength="60" class="input_common" />
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
		<td class="block_text">관심지역<br />(최대2개)</td>
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
			<div class="pb09"><input type="checkbox" name="cate[]" value="<?php echo $TPL_V1["cate1"]?>" class="h2_space"/> <?php echo $TPL_V1["cate_desc"]?> (<?php if(is_array($TPL_R2=$TPL_V1["cate2_list"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?> <?php echo $TPL_V2["cate_desc"]?><?php }}?> ...)</div>
<?php }}?>
		</td>
	</tr>
</table>
<!-- 선택 입력 폼 끝 -->

<div class="pt40"></div>

<center>
	<img src="/images/common/but/but_gb_pre.gif" id="joinCancelBtn" alt="이전" title="이전" class="btn" />
	&nbsp;&nbsp;&nbsp;
	<img src="/images/common/but/but_gb_next.gif" id="joinBtn" alt="다음" title="다음" class="btn" />
</center>

<div class="pt40"></div>
<div id="zipcodelayer"><?php $this->print_("zipcode",$TPL_SCP,1);?></div>
</form>