<?php /* Template_ 2.2.4 2011/10/28 14:12:31 /www/revu39/engine/view/V3.9/manager/manager.cp.file.regist.htm 000003124 */ ?>
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
							<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;관련 파일 등록</font>&nbsp;
						</td>
					</tr>
				</table>

				<table>
					
					<!--  제목 -->
					<tr>
						<td align="left" width="120" border="0" bgcolor="#99CC66">
							&nbsp;Subject&nbsp;<br>
						</td>
						<td>
							<input type="text" name="subject" id="subject" value="" size="80">
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
							<font color="#9933FF"></font>
						</td>
					</tr>	
			

				</table>			
			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>
	<!-- 버튼 -->
	<table width="800" border="0">
		<tr>
			<td width="800">&nbsp;
				<center>
				<input type="button" id="afilCheck" value="등록"/>
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




<!-- <script type="text/javascript">HTMLArea.init();</script> -->
<!-- <script type="text/javascript">HTMLArea2.init();</script> -->

</form>