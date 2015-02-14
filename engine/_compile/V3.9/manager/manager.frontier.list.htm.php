<?php /* Template_ 2.2.4 2012/01/27 11:53:46 /www/revu39/engine/view/V3.9/manager/manager.frontier.list.htm 000007929 */ 
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
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/editor.htmlarea/config/button_action.js"></script>

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
					<td align="left" height="35" border="0" bgcolor="#FF9966">
						<font color="#FFFFFF">&nbsp;<img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/lyr_tit_bu.gif">&nbsp;프론티어><b>프론티어 목록</b></font>&nbsp;

						<br>
						☞ NO 는 프론티어번호. 등록번호임. 프론티어 구분은 모두 이 NO로 처리됨. 업무처리시 해당 프론티어 번호로 구분하기 바람.<br>
						☞ 메인등록(롤링)은 레뷰 메인페이지에 DISPLAY되도록 설정함. 담당자 이외에는 롤링 설정을 바꾸지 마세요.<br>
						☞ 해당 프론티어의 응모자를 확인하려면 <img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/ico_admin_view.gif" width="33">를 클릭 하세요.<br>
						☞ 시키는 대로 하시오!.<br>
					</td>



				</tr>
			</table>				
			<table border="0" width="970" cellpadding="5" cellspacing="0" style="border:0pt solid black" bgcolor="#FFFFFF">
				<tr>
					

					<td align="right">[프론티어 등록수 <font color="#FF0033"><?php echo $TPL_VAR["cnt"]?></font>개]&nbsp;
					

					<!-- 출력라인 
					<input type=text name='rowNumPerPage' value="<?php echo $TPL_VAR["page_row"]?>" size=3 maxlength=3 onKeyDown=OnlyNumber()>줄-->
					<br> <br>&nbsp;&nbsp;


					
					<!-- 검색Area -->
					상태&nbsp;
							<select name="stat" id="stat" style="font-size:9pt">
							<option value="" <?php echo $TPL_VAR["stat_selectall"]?>>------전체------</option>	
							<option value="B" <?php echo $TPL_VAR["stat_select2"]?>>모집중</option>							
							<option value="A" <?php echo $TPL_VAR["stat_select1"]?>>리뷰중</option>
							<option value="C" <?php echo $TPL_VAR["stat_select3"]?>>당첨자선정중</option>
							<option value="D" <?php echo $TPL_VAR["stat_select4"]?>>종료</option>
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


					프론티어명&nbsp;<input type='text' name='frname' id='frname' value='<?php echo $TPL_VAR["frname"]?>' size='25'>&nbsp;&nbsp;&nbsp;

					<!-- 검색Area -->

					&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="search" value="확인"/>
					</td>
			<?}?>
				</tr>

			</table>


			<table width="970"  border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" >
				<tr>
					<th>NO</th>
					<th>등록카테고리</th>
					<th>메인롤링</th>
					<th>제목</th>
					<th>수정</th>
					<th>응모기간</th>
					<th>응모자</th>
					<th>상태</th>
					<th>Del</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="#FFFFFF" height="30" align="center">

					<td><?php echo $TPL_V1["frno"]?></td>
					<td><?php echo $TPL_V1["cate"]?></td>
					<td><?php echo $TPL_V1["maindisplay"]?></td>
					<td align="left"><a href="/frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_blank"><?php echo $TPL_V1["subject"]?></a></td>
					<td align="center"><a href="/manager/detailview.adminpopup.editer//<?php echo $TPL_V1["frno"]?>//" target="_top">수정</a></td>
					<td><?php echo $TPL_V1["start_date"]?>~<?php echo $TPL_V1["end_date"]?></td>
					<td><!-- <a href="javascript:entrypopup('<?php echo $TPL_V1["frno"]?>','<?php echo $TPL_V1["entry_count"]?>');"> --><a href="/manager/frontier.entrylist/1/10/15/<?php echo $TPL_V1["frno"]?>/<?php echo $TPL_V1["entry_count"]?>" target="_top"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/ico_admin_view.gif" width="33"></a></td>
					<td><?php echo $TPL_V1["fronstat"]?></td>
					<td><a href="/manager/frontier.list/1/<?php echo $TPL_V1["frno"]?>/D/" target="_top"><img src="<?php echo $TPL_VAR["IMAGES"]?>/manager/delete_btn_02.gif"></a></td>
					<input type="hidden" name="frno" id="frno" value="<?php echo $TPL_V1["frno"]?>" />

				</tr>
<?php }}?>
			</table>


<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist"></div>
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





</form>