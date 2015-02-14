<?php /* Template_ 2.2.4 2011/12/12 14:16:12 /www/revu39/engine/view/V3.9/manager/manager.frontier.modify.cate.htm 000002155 */ 
$TPL_cate1_list_1=empty($TPL_VAR["cate1_list"])||!is_array($TPL_VAR["cate1_list"])?0:count($TPL_VAR["cate1_list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">
<input type="hidden" name="frno" id="frno" value="<?php echo $TPL_VAR["frno"]?>" />
	<!-- 상단 -->
	<table border="0" width="489" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<table width="460"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">

				
			<table width="460"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">
				<tr>
					<th>변경할 카테고리 선택</th>
				</tr>
					<tr>
						<td>
							<div align="left">
								<select name="cate1" id="cate1" style="font-size:9pt">
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
				<input type="button" id="modifyCheck_cate" value="변경"/>
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