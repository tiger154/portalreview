<?php /* Template_ 2.2.4 2012/12/05 09:40:21 /www/revu39/engine/view/V3.9/manager/manager.frontier.entrylist.htm 000008522 */ 
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
<input type="hidden" name="passwd" id="passwd" value="" />
<input type="hidden" name="module" id="module" value="<?php echo $TPL_VAR["module"]?>" />

	<!-- 상단 -->
	<table border="0" width="960" cellpadding="5" cellspacing="0" align="center">
		<tr>
			<!--본문-->
			<td valign="top" bgcolor="#FFFFFF">
			<table border="0" width="960">
				<tr>
					<td align="left" height="35" border="0">
						프론티어: &nbsp;&nbsp;<font color="#330000" size="3">&nbsp;[&nbsp;<b><?php echo $TPL_VAR["subject"]?></b>&nbsp;]</font>&nbsp;<font color="#A5A5A5">응모 현황</font>&nbsp;
					</td>
				</tr>
			</table>				
			<table border="0" width="960" cellpadding="5" cellspacing="0" style="border:0pt solid black" bgcolor="#FFFFFF">
				<tr>
					

					<td align="right">[응모자수 <font color="#FF0033"><?php echo $TPL_VAR["cnt"]?></font>명]&nbsp;
					

					출력라인 
					<input type=text id='rowNumPerPage' name='rowNumPerPage' value="<?php echo $TPL_VAR["page_row"]?>" size=3 maxlength=3 onKeyDown=OnlyNumber()>줄
					<br> <br>&nbsp;&nbsp;


					
					<!-- 검색Area -->
					
					검색옵션&nbsp;
							<select name="stat" id="stat" style="font-size:9pt">
							<option value="" <?php echo $TPL_VAR["stat_selectall"]?>>------전체------</option>				
							<option value="0" <?php echo $TPL_VAR["stat_select1"]?>>응모중</option>
							<option value="1" <?php echo $TPL_VAR["stat_select2"]?>>당첨</option>
							<option value="P" <?php echo $TPL_VAR["stat_select3"]?>>당첨대기</option>
							</select>		
	
					<!-- 프론티어명&nbsp;<input type='text' name='frname' id='frname' value='<?php echo $TPL_VAR["frname"]?>' size='25'>&nbsp;&nbsp;&nbsp; -->

					<!-- 검색Area -->

					&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" id="entrysearch" value="확인"/>
					</td>
			
				</tr>

			</table>
			
			<br>			
			회원구분 : <span style="background-color:#FFFF99"><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" />파워블로거</span> / 일반회원
			<br><br>

			<table width="100%"  border="1" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0">
				<tr width="100%"> 
					<th><font color=#3333CC>ID</font></th>
					<th width="68"><font color=#3333CC>회원</font></th>
					<th width="98"><font color=#3333CC>응모토크</font></th>
					<th width="60"><font color=#3333CC>별명</font></th>
					<th width="120"><font color=#3333CC>이메일</font></th>
					<th width="55"><font color=#3333CC>생일</font></th>
					<th width="80"><font color=#3333CC>연락처</font></th>
					<th width="160"><font color=#3333CC>주소</font></th>
					<th><font color=#3333CC>옵션</font></th>
					<th><font color=#3333CC>상태</font></th>
					<th><font color=#3333CC>처리</font></th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr bgcolor="<?php if($TPL_V1["flag_powerblog"]=="1"){?>#FFFF99<?php }else{?>#FFFFFF<?php }?>" height="25" align="center">

					<td><?php echo $TPL_V1["userid"]?></td>
					<td>
<?php if($TPL_V1["flag_powerblog"]=="1"){?><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" /><?php }?>						
						<?php echo $TPL_V1["name"]?>(<?php echo $TPL_V1["sex"]?>)<br>
						<a href="javascript:blogpopup('<?php echo $TPL_V1["userno"]?>');"><font color=red><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_view_blog.gif"></font></a>
					</td>					
					<!-- <td><?php echo $TPL_V1["content"]?></td> -->
					<td><textarea rows="4"  style=" width: 160; overflow: visible;"><?php echo $TPL_V1["content"]?></textarea></td>

					<td><?php echo $TPL_V1["nickname"]?></td>
					<td><?php echo $TPL_V1["email"]?></td>
					<td><?php echo $TPL_V1["birthday"]?></td>
					<td><?php echo $TPL_V1["mobile"]?><!-- <br>(<?php echo $TPL_V1["tel"]?>) --></td>
					<td><?php echo $TPL_V1["addr1"]?>&nbsp;<?php echo $TPL_V1["addr2"]?>&nbsp;[<?php echo $TPL_V1["zipcode"]?>]</td>
					<td><?php echo $TPL_V1["options"]?></td>
<?php if($TPL_V1["win"]=="0"){?>	
					<td></td>
<?php }elseif($TPL_V1["win"]=="P"){?>	
					<td>당첨대기</td>
<?php }else{?>
					<td>당첨</td>
<?php }?>



<?php if($TPL_V1["win"]=="0"){?>	
					<td><a href="javascript:frontierEntryWin('<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_VAR["entry_count"]?>','<?php echo $TPL_VAR["title"]?>','<?php echo $TPL_V1["userno"]?>','w','<?php echo $TPL_VAR["page"]?>');"><!-- <img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_admin_fwin.gif"> -->대기등록</a></td><!-- 당첨처리 -->
<?php }elseif($TPL_V1["win"]=="P"){?>	
					<td><a href="javascript:frontierEntryWin('<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_VAR["entry_count"]?>','<?php echo $TPL_VAR["title"]?>','<?php echo $TPL_V1["userno"]?>','s','<?php echo $TPL_VAR["page"]?>');">대기취소</a></td>
<?php }else{?>
					<td><a href="javascript:frontierEntryWin('<?php echo $TPL_VAR["event_no"]?>','<?php echo $TPL_VAR["entry_count"]?>','<?php echo $TPL_VAR["title"]?>','<?php echo $TPL_V1["userno"]?>','c','<?php echo $TPL_VAR["page"]?>');"><img src="<?php echo $TPL_VAR["IMAGES"]?>/admin/but_admin_fesc.gif"></a></td><!-- 취소처리 -->
<?php }?>


				</tr>
<?php }}?>


			</table>

<?php if($TPL_VAR["size"]> 0){?> 
		<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
		<div class="nolist">응모자 없음.</div>
<?php }?>
			
			<div>
				<!-- <input type="button" value="프론티어 목록으로" href="/manager/frontier.list"> -->&nbsp;&nbsp;<input type="button" id="entrysearch2" value="당첨처리 확정"/>
			</div>
			<!--
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



	<table width="960" border="0">
		<tr>
			<td width="960">&nbsp;<!-- 공백 -->
			</td>
		</tr>
	</table>


</form>