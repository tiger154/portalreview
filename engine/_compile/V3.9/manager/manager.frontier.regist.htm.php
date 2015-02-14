<?php /* Template_ 2.2.4 2011/11/28 15:48:52 /www/revu39/engine/view/V3.9/manager/manager.frontier.regist.htm 000023709 */ 
$TPL_cate1_list_1=empty($TPL_VAR["cate1_list"])||!is_array($TPL_VAR["cate1_list"])?0:count($TPL_VAR["cate1_list"]);
$TPL_startyear_1=empty($TPL_VAR["startyear"])||!is_array($TPL_VAR["startyear"])?0:count($TPL_VAR["startyear"]);
$TPL_startmonth_1=empty($TPL_VAR["startmonth"])||!is_array($TPL_VAR["startmonth"])?0:count($TPL_VAR["startmonth"]);
$TPL_startday_1=empty($TPL_VAR["startday"])||!is_array($TPL_VAR["startday"])?0:count($TPL_VAR["startday"]);
$TPL_starttime_1=empty($TPL_VAR["starttime"])||!is_array($TPL_VAR["starttime"])?0:count($TPL_VAR["starttime"]);
$TPL_endyear_1=empty($TPL_VAR["endyear"])||!is_array($TPL_VAR["endyear"])?0:count($TPL_VAR["endyear"]);
$TPL_endmonth_1=empty($TPL_VAR["endmonth"])||!is_array($TPL_VAR["endmonth"])?0:count($TPL_VAR["endmonth"]);
$TPL_endday_1=empty($TPL_VAR["endday"])||!is_array($TPL_VAR["endday"])?0:count($TPL_VAR["endday"]);
$TPL_endtime_1=empty($TPL_VAR["endtime"])||!is_array($TPL_VAR["endtime"])?0:count($TPL_VAR["endtime"]);
$TPL_bcode_list_1=empty($TPL_VAR["bcode_list"])||!is_array($TPL_VAR["bcode_list"])?0:count($TPL_VAR["bcode_list"]);
$TPL_tel_number_1=empty($TPL_VAR["tel_number"])||!is_array($TPL_VAR["tel_number"])?0:count($TPL_VAR["tel_number"]);
$TPL_phone_number_1=empty($TPL_VAR["phone_number"])||!is_array($TPL_VAR["phone_number"])?0:count($TPL_VAR["phone_number"]);?>
<script type="text/javascript">
<!--

//-->
</script>

<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<!-- <script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/htmlarea.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/htmlarea2.js"></script>-->
<!-- <script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/editor_init.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/editor_init2.js"></script> -->

<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action.js"></script>
<!-- <script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action2.js"></script> -->

<input type="hidden" name="tmp_img" id="tmp_img" value="" />
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data" action="">
	<!-- 상단 -->
	<table border="0" width="980" cellpadding="5" cellspacing="0" >
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
				<table border="0" width="100%">
					<tr>
						<td align="left" height="35" border="0" bgcolor="#555555">
							<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;프론티어><b>프론티어 등록</b></font>&nbsp;

						<br><font color=#FFFF33>
						☞ 프론티어 제목에 특수문자 사용을 자제하시기 바랍니다.<br>
						☞ 모집기간 설정값에 따라 프론티어 리스트에 표출됨.<br>
						☞ 프론티어 등록시 모르는 항목이 있거나 문제점은 박상선 과장한테 확인바람.<br>
						☞ 지나친 음주는 건강에 해롭습니다.</font>

						</td>
					</tr>
				</table>

				<table>
					<!-- 프론티어 타입 선택 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;타입&nbsp;<br>
						</td>
						<td width="800">
							<div align="left">
								<input type="radio" name="etype" value="A" border="0" checked> 일반프론티어
								<input type="radio" name="etype" value="B" border="0"> 콘텐츠형
							</div>
						</td>
					</tr>
					<!-- 출처 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;출처&nbsp;<br>
						</td>
						<td>
							<div align="left">
								<input type="radio" name="ctype" value="A" border="0"> RevU
								<input type="radio" name="ctype" value="B" border="0"> 제휴사
							</div>
						</td>
					</tr>

					<!-- 출처 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;썸네일 프로모션&nbsp;<br>
						</td>
						<td>
							<div align="left">
								<input type="radio" name="thumbtype" value="A" border="0"> 큰썸네일(상단진열)
								<input type="radio" name="thumbtype" value="B" border="0"> 일반&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="9933FF">▶<U>큰썸네일</U>을 선택하면 프론티어 <U>리스트 상단</U> 진열, <U>메인페이지</U> 진열(최근2개만 진열됨)</font>
							</div>
						</td>
					</tr>
					<!-- 카테고리 선택 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;카테고리&nbsp;<br>
						</td>
						<td>
							<div align="left">
								<select name="cate1" id="cate1" style="font-size:9pt">
									<!-- <option value="">--1차--</option>
									<option value="1">디지털</option>
									<option value="2">음식</option>
									<option value="3">여행</option> -->
									<option value="">1차분류선택</option>
<?php if($TPL_cate1_list_1){foreach($TPL_VAR["cate1_list"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["cate1"]?>"><?php echo $TPL_V1["cate_desc"]?></option>
<?php }}?>
								</select>
								<select name="cate2" id='cate2' style="font-size:9pt">
									<option value="000">2차분류선택</option>
								</select>
								<select name="cate3" id='cate3' style="font-size:9pt">
									<option value="000">3차분류선택</option>
								</select>
								<select name="cate4" id='cate4' style="font-size:9pt">
									<option value="000">4차분류선택</option>
								</select>
							</div>
						</td>
					</tr>
					<!-- 프론티어 타이틀 제목 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;제목&nbsp;<br>
						</td>
						<td>
							<input type="text" name="subject" id="subject" value="" size="80">
						</td>
					</tr>
					<!-- 모집기간 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;모집기간&nbsp;<br>
						</td>
						<td>
						 <table>
							<td border="0">
								<select name="sdate1" id="startyear">
								<option value="">----</option>
<?php if($TPL_startyear_1){foreach($TPL_VAR["startyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>년
							</td>
							<td>
								<select name="sdate2" id="startmonth">
									<option value="">--</option>
<?php if($TPL_startmonth_1){foreach($TPL_VAR["startmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>월
							</td>
							<td>
									<select name="sdate3" id="startday">
										<option value="">--</option>
<?php if($TPL_startday_1){foreach($TPL_VAR["startday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>일
							</td>
							<td>		
									<select name="sdate4" id="starttime">
										<option value="">--</option>
<?php if($TPL_starttime_1){foreach($TPL_VAR["starttime"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>시			
							</td>
							<td>		
									<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/calender_next2.gif">&nbsp;
							</td>
							<td>		
									<select name="edate1" id="endyear">
										<option value="">----</option>
<?php if($TPL_endyear_1){foreach($TPL_VAR["endyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>년
							</td>
							<td>
									<select name="edate2" id="endmonth">
										<option value="">--</option>
<?php if($TPL_endmonth_1){foreach($TPL_VAR["endmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>월
							</td>		
							<td>		
									<select name="edate3" id="endday">
										<option value="">--</option>
<?php if($TPL_endday_1){foreach($TPL_VAR["endday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>일
							</td>		
							<td>		
									<select name="edate4" id="endtime">
										<option value="">--</option>
<?php if($TPL_endtime_1){foreach($TPL_VAR["endtime"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>시			
							</td>
						</table>
					    </td>
					</tr>


					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;모집인원&nbsp;<br>
						</td>
						<td>
							<input type="text" name="mcount" id="mcount" value="" size="5">&nbsp;명
						</td>
					</tr>
					<!-- 체험단 발표일 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;체험단 발표일&nbsp;<br>
						</td>
						<td>
						<table>
							<td>
								<select name="ndate1" id="jstartyear">
									<option value="">----</option>
<?php if($TPL_startyear_1){foreach($TPL_VAR["startyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>년
							</td>
							<td>
								<select name="ndate2" id="jstartmonth">
									<option value="">--</option>
<?php if($TPL_startmonth_1){foreach($TPL_VAR["startmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>월
							</td>
							<td>
								<select name="ndate3" id="jstartday">
									<option value="">--</option>
<?php if($TPL_startday_1){foreach($TPL_VAR["startday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>일
							</td>
						</table>
						</td>
					</tr>
					<!-- 리뷰작성기간 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;리뷰작성기간&nbsp;<br>
						</td>
						<td>
						<table>
							<td>
								<select name="review_sdate1" id="rstartyear">
									<option value="">----</option>
<?php if($TPL_startyear_1){foreach($TPL_VAR["startyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>년
						    </td>
							<td>
								<select name="review_sdate2" id="rstartmonth">
									<option value="">--</option>
<?php if($TPL_startmonth_1){foreach($TPL_VAR["startmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>월
							</td>
							<td>
								<select name="review_sdate3" id="rstartday">
									<option value="">--</option>
<?php if($TPL_startday_1){foreach($TPL_VAR["startday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>일		
							</td>
							<td>
								<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/calender_next2.gif">&nbsp;
							</td>
							<td>
								<select name="review_edate1" id="rendyear">
									<option value="">----</option>
<?php if($TPL_endyear_1){foreach($TPL_VAR["endyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>년
							</td>
							<td>
								<select name="review_edate2" id="rendmonth">
									<option value="">--</option>
<?php if($TPL_endmonth_1){foreach($TPL_VAR["endmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>월
							</td>
							<td>
								<select name="review_edate3" id="rendday">
									<option value="">--</option>
<?php if($TPL_endday_1){foreach($TPL_VAR["endday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
								</select>일		
							</td>
						</table>
						</td>
					</tr>
					<!-- 체험상품 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;체험상품&nbsp;<br>
						</td>
						<td>
							<!-- <input type="text" name="rproduct" id="rproduct" value="" size="80"> -->
							<textarea id="rproduct" name="rproduct" rows="3" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>
					<!-- 소비자가격 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;소비자가격&nbsp;<br>
						</td>
						<td>
							<input type="text" name="rprice" id="rprice" value="" size="12">&nbsp;원
						</td>
					</tr>
					<!-- 주소 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;주소&nbsp;<br>
						</td>
						<td>
							<select name="area_bcode1" id="areaBcodeCBox1">		
								<option value="00">지역선택</option>
<?php if($TPL_bcode_list_1){foreach($TPL_VAR["bcode_list"] as $TPL_V1){?>
								<option value="<?php echo $TPL_V1["bcode"]?>"><?php echo $TPL_V1["ko_desc"]?></option>
<?php }}?>
							</select>
							<select name="area_mcode1" id="areaMcodeCBox1">		
								<option value="000">지역선택</option>
							</select>
							<select name="area_scode1" id="areaScodeCBox1">		
								<option value="00">지역선택</option>
							</select> <input type="text" name="addr2" id="addr2" size="40" maxlength="60" value="" />
						</td>
					</tr>

					<!-- 약도링크 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;약도 링크주소&nbsp;<br>
						</td>
						<td>
							<input type="text" name="map" id="map" value="" size="50">&nbsp;&nbsp;<input type="button" value="네이버지도" id="naverMapBtn">&nbsp;<input type="button" value="다음지도" id="daumMapBtn">
						</td>
					</tr>

					<!-- 전화번호 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;전화번호&nbsp;<br>
						</td>
						<td>
							<table>
								<td>
									<select name="tel1" id="tel_number">
<?php if($TPL_tel_number_1){foreach($TPL_VAR["tel_number"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>
									<input type="text" name="tel2" value="" size="5" maxlength="4">
									<input type="text" name="tel3" value="" size="5" maxlength="4">,&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td>
									<select name="mobile1" id="phone_number">
<?php if($TPL_phone_number_1){foreach($TPL_VAR["phone_number"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
									</select>
									<input type="text" name="mobile2" value="" size="5" maxlength="4">
									<input type="text" name="mobile3" value="" size="5" maxlength="4">
								</td>
							</table>
						</td>
					</tr>

					<!-- 홈페이지링크 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;홈페이지&nbsp;<br>
						</td>
						<td>
							<input type="text" name="homepage" id="homepage" value="" size="50">&nbsp;&nbsp;<input type="button" value="홈피 찾기" id="homepageBtn">
						</td>
					</tr>

<script type="text/javascript">
<!--
	function add_item(){
		// pre_set 에 있는 내용을 읽어와서 처리..
		var div = document.createElement('div');
		div.innerHTML = document.getElementById('pre_set').innerHTML;
		document.getElementById('field').appendChild(div);
	}

	function remove_item(obj){
		// obj.parentNode 를 이용하여 삭제
		document.getElementById('field').removeChild(obj.parentNode);
	}
//-->
</script>
					<!-- 모집옵션 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;모집옵션&nbsp;<br>
						</td>
						<td>
							<div id="pre_set" style="display:none">
							 <input type="text" name="option[]" value="" style="width:270px"><input type="button" value="삭제" onclick="remove_item(this)"><br>
							</div>
							<input type="button" value="추가" onclick="add_item()">
							<div id="field"><input type="text" name="option[]" value="" style="width:270px"></div><br>
						</td>
					</tr>

					<!-- 캐시지급여부 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;캐시지급여부&nbsp;<br>
						</td>
						<td>
							<input type="text" name="cashcon" value="" size="60">
						</td>
					</tr>
					<!-- 비고 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;비고&nbsp;<br>
						</td>
						<td>
							<textarea id="bigo" name="bigo" rows="7" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>
					<!-- 베스트 리뷰어 발표일 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;베스트 리뷰어 발표일&nbsp;<br>
						</td>
						<td>
							<select name="bestreviewerday1" id="startyear">
								<option value="">----</option>
<?php if($TPL_startyear_1){foreach($TPL_VAR["startyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
							</select>년

							<select name="bestreviewerday2" id="startmonth">
								<option value="">--</option>
<?php if($TPL_startmonth_1){foreach($TPL_VAR["startmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
							</select>월

							<select name="bestreviewerday3" id="startday">
								<option value="">--</option>
<?php if($TPL_startday_1){foreach($TPL_VAR["startday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
							</select>일
						</td>
					</tr>



					<!-- 베스트리뷰어 명수 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;베스트 리뷰어 명수&nbsp;<br>
						</td>
						<td>
							<input type="text" name="bestreviewer_count" value="" size="3">&nbsp;명
						</td>
					</tr>
					<!-- 베스트리뷰어 혜택 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;베스트 리뷰어 혜택&nbsp;<br>
						</td>
						<td>
							<!-- <input type="text" name="bestrevieweraword" value="" size="60"> -->
							<textarea id="bestrevieweraword" name="bestrevieweraword" rows="2" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>

					<!-- 리뷰미션 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;리뷰미션&nbsp;<br>
						</td>
						<!-- <td align="left">
							<textarea id="editorContent" name="editorContent" rows="10"></textarea>
						</td> -->
						<td align="left">
							<textarea id="editor" name="editor" rows="10"  style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>

					<!-- 리뷰 미션 -->
					<!-- <tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;리뷰미션&nbsp;<br>
						</td>
						<td align="left">
							<textarea id="editorContent2" name="editorContent2" rows="7" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr> -->

					<!-- 제목 삽입 키워드 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;제목 삽입 키워드&nbsp;<br>
						</td>
						<td align="left">
							<textarea id="titlekeyword" name="titlekeyword" rows="3" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>
					<!-- 본문 삽입 키워드 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;본문 삽입 키워드&nbsp;<br>
						</td>
						<td align="left">
							<textarea id="storykeyword" name="storykeyword" rows="3" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>

					<!-- 당첨팁 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;당첨TIP&nbsp;<br>
						</td>
						<td align="left">
							<textarea id="tip" name="tip" rows="7" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>
					<!-- 상단이미지 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;상단이미지<br><font color="#7D7D7D">(프론티어 이벤트 본문 상단 이미지)</font>&nbsp;<br>
						</td>
						<td>
							<input type="file" name="file1" id="file1" value=""><br>
							<input type="hidden" name="topimage" id="topimage" value="">
							<font color="#9933FF">▶JPG 712(W)x289(H) 이미지 등록(이미지는 JPG로 확장자가 치환됨)</font>
						</td>
					</tr>
					<!-- 썸네일등록 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;썸네일이미지<br><font color="#7D7D7D">(메인페이지, 프론티어 채널 리스트용)</font>&nbsp;<br>
						</td>
						<td>
							<input type="file" name="file2" id="file2" value=""><br>
							<input type="hidden" name="thumbimage" id="thumbimage" value="">
							<font color="#9933FF">▶JPG  110(W)x102(H) 이미지 등록(이미지는 JPG로 확장자가 치환됨)</font>
						</td>
					</tr>
					<!-- 배너이미지 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;배너이미지&nbsp;<br>
						</td>
						<td>
							<input type="file" name="file3" id="file3" value=""><br>
							<input type="hidden" name="bannerimage" id="bannerimage" value="">
							<font color="#9933FF">▶JPG  198(W)x60(H) 이미지 등록(이미지는 JPG로 확장자가 치환됨)</font>
						</td>
					</tr>		
					
					<!--  자료다운로드 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;관련자료&nbsp;<br>
						</td>
						<td>
							<input type="file" name="file4" id="file4" value=""><br>
							<input type="hidden" name="relfile" id="relfile" value="">
							<font color="#9933FF">▶콘텐츠형일때 관련자료</font>
						</td>
					</tr>	
					<!-- 배너코드 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;배너코드&nbsp;<br>
						</td>
						<td align="left">
							<textarea id="bannercode" name="bannercode" rows="5" style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>


				</table>			
			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>
	<!-- 버튼 -->
	<table width="100%" border="0">
		<tr>
			<td width="100%">&nbsp;
				<center>
				<input type="button" id="registCheck" value="등록"/>
				<input type="button" id="cancelBtn" value="취소"/>
				</center>
			</td>
		</tr>
	</table>
	<!-- 버튼 끝 -->




<!-- <script type="text/javascript">HTMLArea.init();</script> -->
<!-- <script type="text/javascript">HTMLArea2.init();</script> -->

</form>