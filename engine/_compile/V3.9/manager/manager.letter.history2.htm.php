<?php /* Template_ 2.2.4 2011/12/02 15:50:18 /www/revu39/engine/view/V3.9/manager/manager.letter.history2.htm 000002974 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
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


	 //document.forms['RevUform'].onsubmit();
	 //document.forms['RevUform'].submit();
//-->

</script>

<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<form name="RevUform" id="RevUform" method="post" enctype="multipart/form-data"  action="">
<input type="hidden" name="code" id="code" value="<?php echo $TPL_VAR["code"]?>" />
<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["page"]?>" />
<input type="hidden" name="page_row" id="page_row" value="<?php echo $TPL_VAR["page_row"]?>" />
<input type="hidden" name="btitle" id="btitle" value="<?php echo $TPL_VAR["btitle"]?>" />
<input type="hidden" name="idx" id="idx" value="" />
<input type="hidden" name="ref_idx" id="ref_idx" value="" />
<input type="hidden" name="passwd" id="passwd" value="" />
<input type="hidden" name="module" id="module" value="<?php echo $TPL_VAR["module"]?>" />

	<!-- 상단 -->
	<table border="0" width="980" cellpadding="5" cellspacing="0">
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
			<table border="0" width="970">
				<tr>
					<td align="left" height="35" border="0" bgcolor="#808040">
						<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;로그><b>개별메일내역</b></font>&nbsp;

						<br>
						☞ 개별 메일 전송 내역입니다.<br>
					</td>



				</tr>
			</table>				
			
			<table width="970"  border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" >
				<tr>
					<th>메일제목</th>
					<th>전송일</th>
					<th>발신자 정보</th>
					<th>수신자수</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="30" align="center">

					<td><?php echo $TPL_V1["subject"]?></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><?php echo $TPL_V1["sendname"]?></td>
					<td><?php echo $TPL_V1["membercount"]?></td>
				</tr>
<?php }}?>
			</table>


<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist"></div>
<?php }?>
			

			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>





</form>