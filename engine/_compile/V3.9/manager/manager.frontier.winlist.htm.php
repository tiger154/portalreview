<?php /* Template_ 2.2.4 2011/11/30 10:53:14 /www/revu39/engine/view/V3.9/manager/manager.frontier.winlist.htm 000007494 */ 
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

<input type="hidden" name="frname" id="frname" value="<?php echo $TPL_VAR["title"]?>" />
<input type="hidden" name="event_no" id="event_no" value="<?php echo $TPL_VAR["event_no"]?>" />
<input type="hidden" name="count" id="count" value="<?php echo $TPL_VAR["entry_count"]?>" />
<input type="hidden" name="page" id="page" value="<?php echo $TPL_VAR["page"]?>" />
<input type="hidden" name="page_row" id="page_row" value="<?php echo $TPL_VAR["page_row"]?>" />
<input type="hidden" name="btitle" id="btitle" value="<?php echo $TPL_VAR["btitle"]?>" />
<input type="hidden" name="idx" id="idx" value="" />
<input type="hidden" name="ref_idx" id="ref_idx" value="" />
<input type="hidden" name="module" id="module" value="<?php echo $TPL_VAR["module"]?>" />

	<!-- 상단 -->
	<table border="0" width="900" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
			<table border="0" width="900">
				<tr>
					<td align="left" height="35" border="0">
						프론티어명: &nbsp;&nbsp;<font color="#993300" size="3">&nbsp;&nbsp;<b><?php echo $TPL_VAR["subject"]?></b>&nbsp;</font>&nbsp;
					</td>
				</tr>
			</table>				
			<table border="0" width="900" cellpadding="5" cellspacing="0" style="border:0pt solid black" bgcolor="#FFFFFF">
				<tr>
					

					<td align="right">[당첨자수 <font color="#FF0033"><?php echo $TPL_VAR["cnt"]?></font>명]&nbsp;
					

					<!-- 출력라인 
					<input type=text name='rowNumPerPage' value="<?php echo $TPL_VAR["page_row"]?>" size=3 maxlength=3 onKeyDown=OnlyNumber()>줄-->
					<br> <br>&nbsp;&nbsp;


					
					<!-- 검색Area -->
					<!-- 상태&nbsp;
							<select name="stat" id="stat" style="font-size:9pt">
							<option value="" <?php echo $TPL_VAR["stat_selectall"]?>>------전체------</option>				
							<option value="0" <?php echo $TPL_VAR["stat_select1"]?>>응모중</option>
							<option value="1" <?php echo $TPL_VAR["stat_select2"]?>>당첨</option>

							</select> -->

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


					<!-- 프론티어명&nbsp;<input type='text' name='frname' id='frname' value='<?php echo $TPL_VAR["frname"]?>' size='25'>&nbsp;&nbsp;&nbsp; -->

					<!-- 검색Area -->

					&nbsp;&nbsp;&nbsp;&nbsp;<!-- <input type="button" id="entrysearch" value="확인"/> -->
					</td>
			
				</tr>

			</table>
			<br>

			<table width="100%"  border="1" cellpadding="0" cellspacing="0" bgcolor="#FFCC99">
				<tr width="100%"> 
					<th><font color=#FF0000>ID</font></th>
					<th width="72"><font color=#FF0000>회원</font></th>
					<th><font color=#FF0000>별명</font></th>
					<th width="120"><font color=#FF0000>이메일</font></th>
					<th width="72"><font color=#FF0000>리뷰</font></th>
					<th><font color=#FF0000>지급된 캐시</font></th>
					<th><font color=#FF0000>지급할 캐시</font></th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="25" align="center" valign="middle">

					<td><?php echo $TPL_V1["userid"]?></td>
					<td><?php echo $TPL_V1["name"]?>(<?php echo $TPL_V1["sex"]?>)<br><a href="javascript:blogpopup2('<?php echo $TPL_V1["userno"]?>');"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_view_blog.gif"></a></td>
					<td><?php echo $TPL_V1["nickname"]?></td>
					<td><?php echo $TPL_V1["email"]?></td>
					<td><a href="javascript:reviewpopup('<?php echo $TPL_V1["userno"]?>','<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_VAR["entry_count"]?>');"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_view_review.gif"></a></td>
					<td><?php echo $TPL_V1["paycash"]?></td>

<?php if($TPL_V1["cashbutton"]=='N'){?>
					<td>-</td><!-- 지급된 놈들 -->
<?php }else{?>
					<td><input type="text" id="cash<?php echo $TPL_V1["userno"]?>" name="cash<?php echo $TPL_V1["userno"]?>" value="" size="7" maxlength="7">&nbsp;<a href="javascript:paycash('<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_V1["userno"]?>');"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_input_cash.gif"></a></td><!-- 캐시지급 -->
<?php }?>


				</tr>
<?php }}?>


			</table>

<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist">당첨자 없음.</div>
<?php }?>
			<!-- 
			<div class="form-btn-right">
				<span class="btn strong"><input type="button" class="btn" value="공지사항 등록" style="width:120px;" onClick="writeForm('<?php echo $TPL_VAR["module"]?>')" /></span>
			</div>

			<div class="clear"></div>

			<div class="form-btn-center">
				<select name="sch_opt" id="sch_opt" class="myboard_select">
					<option value="">전체</option>
					<option value="title" <?php if($TPL_VAR["sch_opt"]=='title'){?>selected<?php }?>>제목</option>
					<option value="content" <?php if($TPL_VAR["sch_opt"]=='content'){?>selected<?php }?>>내용</option>
					<option value="nickname" <?php if($TPL_VAR["sch_opt"]=='nickname'){?>selected<?php }?>>필명</option>
				</select>
				<input name="sch_con" id="sch_con" type="text" class="myboard_input" value="<?php echo $TPL_VAR["sch_con"]?>" size="25" onKeyDown="searchEnter(event,'<?php echo $TPL_VAR["module"]?>')" />
				<span class="small btn"><input type="button" class="btn" value="검색" style="width:60px;" onClick="searchInit('<?php echo $TPL_VAR["module"]?>');" /></span>
			</div> -->

			</td>
			<!-- 본문 끝 -->
		</tr>
	</table>



	<table width="900" border="0">
		<tr>
			<td width="900">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>