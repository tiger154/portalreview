<?php /* Template_ 2.2.4 2011/10/21 17:02:33 /www/revu39/engine/view/V3.9/manager/manager.letter.step3.htm 000005640 */ 
$TPL_frwinmail_list_1=empty($TPL_VAR["frwinmail_list"])||!is_array($TPL_VAR["frwinmail_list"])?0:count($TPL_VAR["frwinmail_list"]);
$TPL_startyear_1=empty($TPL_VAR["startyear"])||!is_array($TPL_VAR["startyear"])?0:count($TPL_VAR["startyear"]);
$TPL_startmonth_1=empty($TPL_VAR["startmonth"])||!is_array($TPL_VAR["startmonth"])?0:count($TPL_VAR["startmonth"]);
$TPL_startday_1=empty($TPL_VAR["startday"])||!is_array($TPL_VAR["startday"])?0:count($TPL_VAR["startday"]);
$TPL_starttime_1=empty($TPL_VAR["starttime"])||!is_array($TPL_VAR["starttime"])?0:count($TPL_VAR["starttime"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data" action="">

	<!-- 상단 -->
	<table border="0" width="980" cellpadding="5" cellspacing="0" >
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
				<table border="0" width="100%">
					<tr>
						<td align="left" height="35" border="0" bgcolor="#666699">
							<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;메일관리><b>프론티어 당첨메일</b></font>&nbsp;
						</td>
					</tr>
				</table>

				<table>

					<!-- 메일 타이틀 제목 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#B5E7FF">
							&nbsp;제목&nbsp;<br>
						</td>
						<td>
							<input type="text" name="subject" id="subject" value="" size="80">
						</td>
					</tr>
					<!-- 메일 발신자 표시명-->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#B5E7FF">
							&nbsp;발신자 표시명&nbsp;<br>
						</td>
						<td>
							<input type="text" name="sendname" id="sendname" value="" size="80">
						</td>
					</tr>




					
					<div id=typeview3 style='display:none'>
					<tr>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;해당 프론티어 선택&nbsp;<br>
						</td>
						<td>
							<select name="frontiergroup" id="frontiergroup">		
<?php if($TPL_frwinmail_list_1){foreach($TPL_VAR["frwinmail_list"] as $TPL_V1){?>
									<option value="<?php echo $TPL_V1["frno"]?>"><?php echo $TPL_V1["subject"]?></option>
<?php }}?>
							</select>
						</td>
					</tr>										
					</tr>

					<!-- 본문내용 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#B5E7FF">
							&nbsp;내용&nbsp;<br>
						</td>
						<td>
							<textarea id="editor" name="editor" rows="10"  style=" width: 100%; overflow: visible;"></textarea>
						</td>
					</tr>			
					<!-- 발송시간 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#B5E7FF">
							&nbsp;발송&nbsp;<br>
						</td>
						<td>
							<input type=radio name=sending value="R"  id="sending2" checked> 예약발송
							<input type=radio name=sending value="N"  id="sending1" > 즉시발송
						</td>
					</tr>								

					
					<!-- 예약시간-->
					<tr id=reserved>
						<td align="left" width="120" border="0" bgcolor="#AAAAAA">
							&nbsp;예약발송 시간설정&nbsp;<br>
						</td>
							<td>
								<select name="reserve_year" id="reyear">
									<option value="">----</option>
<?php if($TPL_startyear_1){foreach($TPL_VAR["startyear"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>년</option><?php }}?>
								</select>&nbsp;
								<select name="reserve_month" id="remonth">
									<option value="">--</option>
<?php if($TPL_startmonth_1){foreach($TPL_VAR["startmonth"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>월</option><?php }}?>
								</select>&nbsp;
								<select name="reserve_date" id="redate">
									<option value="">--</option>
<?php if($TPL_startday_1){foreach($TPL_VAR["startday"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>일</option><?php }}?>
								</select>&nbsp;	
								<select name="reserve_time" id="retime">
									<option value="">--</option>
<?php if($TPL_starttime_1){foreach($TPL_VAR["starttime"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?>시</option><?php }}?>
								</select>&nbsp;		
																
							</td>
					</tr>

		</tr>
	</table>
	<!-- 버튼 -->
	<table width="800" border="0">
		<tr>
			<td width="800">&nbsp;
				<center>
				<input type="button" id="sendmail" value="등록"/>
				<input type="button" id="cancelBtn" value="취소"/>
				</center>
			</td>
		</tr>
	</table>
	<!-- 버튼 끝 -->


	<table width="800" border="0">
		<tr>
			<td width="800">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>

<input type="hidden" name="command" value="input">


<!-- //**********************************************************************************//	
//	메일종류코드  N : 뉴스레터, E : 이벤트알림, W : 이벤트 당첨							//
// 전송타입  E : 개별발송, A : 그룹발송, B : 프론티어 당첨 발송							//
// 수신그룹 A : 전체, B : 남성회원, C : 여성회원,  D : 블랙리스트회원					//
// 전송구분 : R : 예약발송, N : 즉시발송															//
//*********************************************************************************// -->
<input type="hidden" name="mtype" value="B">
</form>