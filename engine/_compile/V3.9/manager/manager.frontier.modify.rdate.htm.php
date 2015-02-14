<?php /* Template_ 2.2.4 2011/12/09 16:58:02 /www/revu39/engine/view/V3.9/manager/manager.frontier.modify.rdate.htm 000003780 */ 
$TPL_startyear_1=empty($TPL_VAR["startyear"])||!is_array($TPL_VAR["startyear"])?0:count($TPL_VAR["startyear"]);
$TPL_startmonth_1=empty($TPL_VAR["startmonth"])||!is_array($TPL_VAR["startmonth"])?0:count($TPL_VAR["startmonth"]);
$TPL_startday_1=empty($TPL_VAR["startday"])||!is_array($TPL_VAR["startday"])?0:count($TPL_VAR["startday"]);
$TPL_endyear_1=empty($TPL_VAR["endyear"])||!is_array($TPL_VAR["endyear"])?0:count($TPL_VAR["endyear"]);
$TPL_endmonth_1=empty($TPL_VAR["endmonth"])||!is_array($TPL_VAR["endmonth"])?0:count($TPL_VAR["endmonth"]);
$TPL_endday_1=empty($TPL_VAR["endday"])||!is_array($TPL_VAR["endday"])?0:count($TPL_VAR["endday"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">
<input type="hidden" name="frno" id="frno" value="<?php echo $TPL_VAR["frno"]?>" />
	<!-- 상단 -->
	<table border="0" width="520" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<table width="520"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">

				
			<table width="520"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">
				<tr>
					<th>리뷰기간 재설정</th>
				</tr>
					<tr>
						<table>
							<td border="0">
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
				<input type="button" id="modifyCheck_rdate" value="변경"/>
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