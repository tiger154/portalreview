<?php /* Template_ 2.2.4 2011/11/24 15:31:32 /www/revu39/engine/view/V3.9/manager/manager.list.banner.htm 000005711 */ 
$TPL_cate1_list_1=empty($TPL_VAR["cate1_list"])||!is_array($TPL_VAR["cate1_list"])?0:count($TPL_VAR["cate1_list"]);
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
					<td align="left" height="35" border="0" bgcolor="#006600">
						<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;화면관리><b>배너관리</b></font>&nbsp;
					</td>
				</tr>
			</table>				
			<table border="0" width="970" cellpadding="5" cellspacing="0" style="border:1pt solid black" bgcolor="#FFFFFF">
				<tr>
					

					<td align="right">[배너 등록수 <font color="#FF0033"><?php echo $TPL_VAR["cnt"]?></font>개]&nbsp;
					

					<!-- 출력라인 
					<input type=text name='rowNumPerPage' value="<?php echo $TPL_VAR["page_row"]?>" size=3 maxlength=3 onKeyDown=OnlyNumber()>줄-->
					<br> <br>&nbsp;&nbsp;


					
					<!-- 검색Area -->
					&nbsp;
							<select name="stat" id="stat" style="font-size:9pt">
							<option value="" <?php echo $TPL_VAR["stat_selectall"]?>>------전체------</option>				
							<option value="M" <?php echo $TPL_VAR["stat_select1"]?>>메인배너</option>
							<option value="L" <?php echo $TPL_VAR["stat_select2"]?>>우측배너</option>
							</select>

					<!-- 
					등록카테고리&nbsp;
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
					-->


					배너 캠페인명&nbsp;<input type='text' name='campaign' id='campaign' value='<?php echo $TPL_VAR["campaign"]?>' size='25'>&nbsp;&nbsp;&nbsp;

					<!-- 검색Area -->

					&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="bannersearch" value="확인"/>
					</td>
			<?}?>
				</tr>



			<table width="970"  border="0" cellpadding="3" cellspacing="0" bgcolor="#C0C0C0" bordercolorlight="#4F4F4F">
				<tr>
					<th>순번</th>
					<!-- <th>정렬</th> -->
					<th>캠페인명</th>
					<th>배너종류</th>
					<th>링크타입</th>
					<th>스폰서명</th>
					<th>배너이미지</th>
					<th>링크주소</th>
					<th>등록일</th>
					<th>삭제</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="25" align="center">
					<td><?php echo $TPL_V1["idx"]?></td>
					<!-- <td><?php echo $TPL_V1["order"]?></td> -->
					<td><!-- <a href="javascript:view('<?php echo $TPL_V1["idx"]?>','<?php echo $TPL_VAR["module"]?>');"> --><?php echo $TPL_V1["campaign"]?><!-- </a> --></td>
					<td align="center">
						<?php echo $TPL_V1["btype_desc"]?>

					</td>
					<td><?php echo $TPL_V1["linktype_desc"]?></td>
					<td><?php echo $TPL_V1["spon"]?></a></td>
					<td><img src ='<?php echo $TPL_VAR["DOMAIN_FILE"]?>/banner/<?php echo $TPL_V1["bannerimg"]?>' width="120"></td>
					<td><a href="<?php echo $TPL_V1["siteurl"]?>" target="top"><?php echo $TPL_V1["siteurl"]?></a></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td><a href="javascript:bannerdel('<?php echo $TPL_V1["no"]?>', 'D');"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/btn_form04.gif"></a></td><!-- 삭제처리 -->
				</tr>
<?php }}?>
			</table>

<?php if($TPL_VAR["cnt"]< 1){?>	
			<div class="form-nolist">등록된 배너가 없습니다.</div>
<?php }else{?>
			<div class="form-paging"><?php echo $TPL_VAR["link"]?></div>	
<?php }?>
			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>




</form>