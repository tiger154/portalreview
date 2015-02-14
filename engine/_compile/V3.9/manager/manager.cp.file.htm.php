<?php /* Template_ 2.2.4 2011/11/24 15:30:53 /www/revu39/engine/view/V3.9/manager/manager.cp.file.htm 000002460 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">

	<!-- 상단 -->
	<table border="0" width="980" cellpadding="5" cellspacing="0">
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
			<table border="0" width="970">
				<tr>
					<td align="left" height="35" border="0" bgcolor="#FF9966">
						<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;Revu 담자자 및 관계사외 메뉴 사용 금지</font>&nbsp;
					</td>
				</tr>
			</table>				
			<table border="0" width="970" cellpadding="5" cellspacing="0" style="border:1pt solid black" bgcolor="#FFFFFF">
				<tr>
					

					<td align="right">접속시간 : <?php echo $TPL_VAR["nowtime"]?>

					
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="afileregist" value="등록"/>
					</td>
				</tr>

			</table>

			<br>
			<table width="970"  border="1" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0">
				<tr>
					<th>순번</th>
					<th>제목</th>
					<th>파일명</th>
					<th>등록일</th>
					<th>삭제</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="27" align="center">



					<td><?php echo $TPL_V1["no"]?></td>
					<td align="left"><?php echo $TPL_V1["title"]?></td>
					<!-- <td><a href="/manager/cp.file/d/<?php echo $TPL_V1["no"]?>"><?php echo $TPL_V1["file"]?></a></td> -->
					<td><a href="<?php echo $TPL_VAR["DOMAIN_FILE"]?>/partner/<?php echo $TPL_V1["file"]?>"><?php echo $TPL_V1["file"]?></a></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><img src='/images/common/ico/ico_del.gif' alt='삭제' title='삭제' class='img_space' style='cursor:hand' onclick='AfileDel("<?php echo $TPL_V1["file"]?>","<?php echo $TPL_V1["no"]?>")'></a></td>
				</tr>
<?php }}?>
			</table>

		<!-- 
<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist"></div>
<?php }?> -->
			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>



	<table width="800" border="0">
		<tr>
			<td width="800">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>