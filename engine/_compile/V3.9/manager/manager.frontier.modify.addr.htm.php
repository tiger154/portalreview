<?php /* Template_ 2.2.4 2011/12/12 14:16:06 /www/revu39/engine/view/V3.9/manager/manager.frontier.modify.addr.htm 000002164 */ 
$TPL_bcode_list_1=empty($TPL_VAR["bcode_list"])||!is_array($TPL_VAR["bcode_list"])?0:count($TPL_VAR["bcode_list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
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
					<th>프론티어 주소변경</th>
				</tr>
					<tr>
						<td>
							<div align="left">
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
							</select> <br>상세주소:<input type="text" name="addr2" id="addr2" size="46" maxlength="60" value="" />
							</div>
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
				<input type="button" id="modifyCheck_addr" value="변경"/>
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