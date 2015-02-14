<?php /* Template_ 2.2.4 2011/11/22 18:13:23 /www/revu39/engine/view/V3.9/manager/manager.frontier.winreviewlist.htm 000002529 */ 
$TPL_reviewlist_1=empty($TPL_VAR["reviewlist"])||!is_array($TPL_VAR["reviewlist"])?0:count($TPL_VAR["reviewlist"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">
<input type="hidden" name="code" id="code" value="<?php echo $TPL_VAR["code"]?>" />

<input type="hidden" name="frname" id="frname" value="<?php echo $TPL_VAR["title"]?>" />
<input type="hidden" name="event_no" id="event_no" value="<?php echo $TPL_VAR["event_no"]?>" />

<input type="hidden" name="count" id="count" value="<?php echo $TPL_VAR["entry_count"]?>" />



<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["page"]?>" />
<input type="hidden" name="page_row" id="page_row" value="<?php echo $TPL_VAR["page_row"]?>" />
<input type="hidden" name="btitle" id="btitle" value="<?php echo $TPL_VAR["btitle"]?>" />
<input type="hidden" name="idx" id="idx" value="" />
<input type="hidden" name="ref_idx" id="ref_idx" value="" />
<input type="hidden" name="passwd" id="passwd" value="" />
<input type="hidden" name="module" id="module" value="<?php echo $TPL_VAR["module"]?>" />

	<!-- 상단 -->
	<table border="0" width="560" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<table width="560"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">

				

			<table width="560"  border="1" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">
				<tr>
					<th>리뷰URL</th>
					<th>RevU연동</th>
				</tr>
<?php if($TPL_reviewlist_1){foreach($TPL_VAR["reviewlist"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="25" align="center">

					<td><a href="<?php echo $TPL_V1["url"]?>" target="_blank"><font color=blue><U><?php echo $TPL_V1["title"]?></U></font></a></td>
<?php if($TPL_V1["frno"]== 0){?> 
					<td width="80"><font color=blue><a href="javascript:frontierReviewReg('<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_V1["enurl"]?>','<?php echo $TPL_V1["userno"]?>');">등록</a></font></td>
<?php }else{?>
					<td width="80"></font></td>
<?php }?>
				</tr>
<?php }}?>


			</table>


			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>



	<table width="560" border="0">
		<tr>
			<td width="560">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>