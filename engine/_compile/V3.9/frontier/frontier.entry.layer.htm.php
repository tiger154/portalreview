<?php /* Template_ 2.2.4 2012/01/26 17:23:35 /www/revu39/engine/view/V3.9/frontier/frontier.entry.layer.htm 000010133 */ 
$TPL_birth_year_1=empty($TPL_VAR["birth_year"])||!is_array($TPL_VAR["birth_year"])?0:count($TPL_VAR["birth_year"]);
$TPL_birth_month_1=empty($TPL_VAR["birth_month"])||!is_array($TPL_VAR["birth_month"])?0:count($TPL_VAR["birth_month"]);
$TPL_birth_day_1=empty($TPL_VAR["birth_day"])||!is_array($TPL_VAR["birth_day"])?0:count($TPL_VAR["birth_day"]);
$TPL_phone_number_1=empty($TPL_VAR["phone_number"])||!is_array($TPL_VAR["phone_number"])?0:count($TPL_VAR["phone_number"]);
$TPL_tel_number_1=empty($TPL_VAR["tel_number"])||!is_array($TPL_VAR["tel_number"])?0:count($TPL_VAR["tel_number"]);
$TPL_option_list_1=empty($TPL_VAR["option_list"])||!is_array($TPL_VAR["option_list"])?0:count($TPL_VAR["option_list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<div id="zipcodelayer"><?php $this->print_("zipcode",$TPL_SCP,1);?></div>	

<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action.js"></script>

<input type="hidden" name="frno" id="frno" value='<?php echo $TPL_VAR["frno"]?>'>
<input type="hidden" name="frid" id="frid" value='<?php echo $TPL_VAR["frid"]?>'>
<input type="hidden" name="userno" id="userno" value='<?php echo $TPL_VAR["userno"]?>'>
<input type="hidden" name="userid" id="userid" value='<?php echo $TPL_VAR["userid"]?>'>
<input type="hidden" name="option_count" id="option_count" value='<?php echo $TPL_VAR["option_count"]?>'>

<!-- 당첨자팝업 /사이즈500가변 -->
<div class="pop_frontier_box">
		<div class="pop_frontier_tbox">
				<ul>
						<li class="pop_frontier_title2">
								<div  class="fr" style="width:19px; height:26px; padding-bottom:9px;"><img src="/images/common/but/but_xclose.gif" align="right" alt="닫기" title="닫기" onclick="common.closeLayer('entrylayer')"/></div>
						</li>
						<li class="img_frontier_entry"></li>
						<li class="pb25"></li>

<?php if($TPL_VAR["option_count"]== 0){?>
						<li class="pop_entry_box_none">
<?php }else{?>
						<li class="pop_entry_box">
<?php }?>
								<!-- 블로그가 없으면 블로그가 등록되지 않았습니다. / 등록버튼 but_blogin.gif -->
<?php if($TPL_VAR["blogcount"]> 0){?>
								<div class="pop_entry_line">
										<ul>
												<li class="fl gray_d_text" style=" width:180px; height:18px; vertical-align:middle;">블로그가 등록 되어 있습니다.</li>
												<li class="fl" style="height:18px;"><a href="/myrevu/blog"><img src="/images/common/but/but_blogcare.gif"  alt="블로그등록관리" title="블로그등록관리" ></a></li>
										</ul>
								</div>
<?php }else{?>
								<div class="pop_entry_line">
										<ul>
												<li class="fl gray_d_text" style=" width:180px; height:18px; vertical-align:middle;">블로그를 등록하세요.</li>
												<li class="fl" style="height:18px;"><a href="/myrevu/blog.register"><img src="/images/common/but/but_blogcare.gif"  alt="블로그등록관리" title="블로그등록관리" ></a></li>
										</ul>
								</div>
	
<?php }?>
								<div class="clear"></div>
								<!-- 이름 -->
								<div class="pop_entry_line">
										<input type="text" name="name" id="name" value="<?php echo $TPL_VAR["username"]?>" size="20" class="input_entry320">
								</div>
								<!-- 성별 -->
								<div class="pop_entry_line">
										<ul>
												<li class="fl" style=" width:24px; height:18px;">
														<input type="radio" name="sex" value="M"  border="0" class="h_space" <?php echo $TPL_VAR["sex1"]?>>
												</li>
												<li class="fl common_text" style=" width:30px; height:18px;"><strong>남자</strong></li>
												<li class="fl" style=" width:24px; height:18px;">
														<input type="radio" name="sex" value="F" border="0" class="h_space" <?php echo $TPL_VAR["sex2"]?>>
												</li>
												<li class="fl common_text" style=" width:30px; height:18px;"><strong>여자</strong></li>
										</ul>
								</div>
								<!-- 생년월일 -->
								<div class="pop_entry_line">
									<table>
										<tr>
											<td>
												<select name="birth_year" id="birth_year">
												<option value="">----</option>
<?php if($TPL_birth_year_1){foreach($TPL_VAR["birth_year"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_V1==$TPL_VAR["birthday_year"]){?> selected <?php }?>><?php echo $TPL_V1?></option><?php }}?>
												</select>년&nbsp;
											</td>
											<td>
												<select name="birth_month" id="birth_month" style="width:40px;">
												<option value="">--</option>
<?php if($TPL_birth_month_1){foreach($TPL_VAR["birth_month"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_V1==$TPL_VAR["birthday_month"]){?> selected <?php }?>><?php echo $TPL_V1?></option><?php }}?>
												</select>월&nbsp;
											</td>
											<td>
												<select name="birth_day" id="birth_day"  style="width:40px;">
												<option value="">--</option>
<?php if($TPL_birth_day_1){foreach($TPL_VAR["birth_day"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_V1==$TPL_VAR["birthday_date"]){?> selected <?php }?>><?php echo $TPL_V1?></option><?php }}?>
												</select>일&nbsp;
											</td>
										</tr>
									</table>
								</div>
								<!-- 휴대폰번호 -->
								<div class="pop_entry_line">
									<table>
										<tr>
											<td>
												<select name="mobile1" id="phone_number" style="width:45px; margin-right:5px;">
<?php if($TPL_phone_number_1){foreach($TPL_VAR["phone_number"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1?>" <?php if($TPL_V1==$TPL_VAR["cell_1"]){?> selected <?php }?>><?php echo $TPL_V1?></option>													
<?php }}?>
												
												
												
												
												</select>&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="text" name="mobile2" id="mobile2" value="<?php echo $TPL_VAR["cell_2"]?>" maxlength="4"  class="input_entry320" style="width:35px; margin-right:5px;">-
												<input type="text" name="mobile3" id="mobile3" value="<?php echo $TPL_VAR["cell_3"]?>" maxlength="4"  class="input_entry320" style="width:35px; margin-right:5px;">
											</td>
										</tr>
									</table>
								</div>
								<!-- 전화번호 -->
								<div class="pop_entry_line">
									<table>
										<tr>
											<td>
												<select name="tel1" id="tel_number" style="width:45px; margin-right:5px;">
<?php if($TPL_tel_number_1){foreach($TPL_VAR["tel_number"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>" <?php if($TPL_V1==$TPL_VAR["tel_1"]){?> selected <?php }?>><?php echo $TPL_V1?></option><?php }}?>
												</select>&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="text" name="tel2" id="tel2" value="<?php echo $TPL_VAR["tel_2"]?>" maxlength="4"  class="input_entry320" style="width:35px; margin-right:5px;">-
												<input type="text" name="tel3" id="tel3" value="<?php echo $TPL_VAR["tel_3"]?>" maxlength="4"  class="input_entry320" style="width:35px; margin-right:5px;">
											</td>
										</tr>
									</table>
								</div>
								<!--우편번호-->
								<div class="pop_entry_line">
										<ul>

												<input type="text" name="addrzip" id="addrzip" size="8" maxlength="6" value="<?php echo $TPL_VAR["zipcode"]?>" class="input_entry320" readonly style="width:45px;">
												<img src="/images/common/but/but_postno.gif"  id="zipcodeBtn" alt="우편번호">
										</ul>
								</div>
								<!-- 주소 -->
								<div class="pop_entry_line">
										<input name="addr1" type="text" class="input_entry320" id="addr1" value="<?php echo $TPL_VAR["addr1"]?>" readonly>
								</div>
								<div class="pop_entry_line">
										<input name="addr2" type="text" class="input_entry320" id="addr2" value="<?php echo $TPL_VAR["addr2"]?>">
								</div>
								<!-- 옵션 -->
<?php if($TPL_VAR["option_count"]!= 0){?>
								<div class="pop_entry_line">
									<table>
										<tr>
											<td>

												<select name="option1" id="option1">
													<option value="">옵션선택</option>
<?php if($TPL_option_list_1){foreach($TPL_VAR["option_list"] as $TPL_V1){?>
													<option value="<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["froption"]?></option>
<?php }}?>
												</select>
											</td>
										</tr>
									</table>
								</div>
								<div class="clear"></div>
<?php }?>

								<!-- 토크 -->
								<div class="pop_entry_talkline">
										<ul>

<?php if($TPL_VAR["option_count"]== 0){?>

												<li style="height:90px;">
														<textarea  id="editor" name="editor" rows="7" class="input_entry_area"></textarea>
												</li>
<?php }else{?>


												<li style="height:70px;">
														<textarea  id="editor" name="editor" rows="5" class="input_entry_area"></textarea>
												</li>


<?php }?>
												<li style="padding-top:20px;">
														<div class="fl" style="width:30px; text-align:left;">
																<input type="checkbox" name="agree" id="agree" value="a">
														</div>
														<div class="fl gray11_d_text" style="width:290px;"> 당첨 후 기간 내 리뷰를 작성하지 않으면, <br />
																체험상품을 반납하거나 그에 맞는 캐쉬를 차감합니다.<br />
																내용에 동의 하신 후 응모가 가능합니다.<br />
														</div>
												</li>
										</ul>
								</div>
								<!-- 토크 끝-->
						</li>
						<li class="pb25"></li>
						<li style="width:448px; height:33px; text-align:center;"><img src="/images/common/but/but_big_entry.gif" alt="응모하기" title="응모하기" id="registCheck"></li>
				</ul>
		</div>
</div>
</form>