<?php /* Template_ 2.2.4 2011/12/12 15:12:36 /www/revu39/engine/view/V3.9/manager/manager.frontier.modify.tel.htm 000002354 */ 
$TPL_tel_number_1=empty($TPL_VAR["tel_number"])||!is_array($TPL_VAR["tel_number"])?0:count($TPL_VAR["tel_number"]);
$TPL_phone_number_1=empty($TPL_VAR["phone_number"])||!is_array($TPL_VAR["phone_number"])?0:count($TPL_VAR["phone_number"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">
<input type="hidden" name="frno" id="frno" value="<?php echo $TPL_VAR["frno"]?>" />
	<!-- 상단 -->
	<table border="0" width="489" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<table width="460"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">

				
			<table width="460"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">
				<tr>
					<th>프론티어 전화번호/휴대폰 번호변경</th>
				</tr>
					<tr>
						<td>
							전화번호 : <select name="tel1" id="tel_number">
<?php if($TPL_tel_number_1){foreach($TPL_VAR["tel_number"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
							</select>
							<input type="text" name="tel2" value="" size="5" maxlength="4">
							<input type="text" name="tel3" value="" size="5" maxlength="4">&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>

					<tr>
						<td>
							휴대폰 번호 : <select name="mobile1" id="phone_number">
<?php if($TPL_phone_number_1){foreach($TPL_VAR["phone_number"] as $TPL_V1){?><option value="<?php echo $TPL_V1?>"><?php echo $TPL_V1?></option><?php }}?>
							</select>
							<input type="text" name="mobile2" value="" size="5" maxlength="4">
							<input type="text" name="mobile3" value="" size="5" maxlength="4">
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
				<input type="button" id="modifyCheck_tel" value="변경"/>
				</center>
			</td>
		</tr>
	</table>
	<!-- 버튼 끝 -->

	<table width="560" border="0">
		<tr>
			<td width="560">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>