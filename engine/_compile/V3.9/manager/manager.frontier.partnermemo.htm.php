<?php /* Template_ 2.2.4 2011/12/05 13:49:39 /www/revu39/engine/view/V3.9/manager/manager.frontier.partnermemo.htm 000001896 */ ?>
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
	<table border="0" width="290" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			
			<table width="100%"  border="0" cellpadding="2" cellspacing="0" bgcolor="#C0C0C0">
				<tr width="100%"> 
					<th><font color=#3333CC>문의 내용 상세보기</font></th>
				</tr>
				<tr bgcolor="#FFFFFF" height="25" align="center">

					<td align='left'><?php echo $TPL_VAR["memo"]?></td>
				
				</tr>


			</table>


			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>



	<table width="290" border="0">
		<tr>
			<td width="890">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>