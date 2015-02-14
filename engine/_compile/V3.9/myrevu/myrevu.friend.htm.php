<?php /* Template_ 2.2.4 2011/11/08 16:51:31 /www/revu39/engine/view/V3.9/myrevu/myrevu.friend.htm 000004260 */ 
$TPL_grouplist_1=empty($TPL_VAR["grouplist"])||!is_array($TPL_VAR["grouplist"])?0:count($TPL_VAR["grouplist"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.friend.js"></script>
<script type="text/javascript">myfriend.initVar('<?php echo $TPL_VAR["type"]?>','<?php echo $TPL_VAR["groupno"]?>');</script>
<div class="title_line gray_l_text"><img src="/images/myrevu/title_myfriend.gif" align="left"/></div>
<!-- 상단 상태 라인 -->
<div class="review_manage_state_make">
	<span class="black_text"><strong>친구분류</strong></span>&nbsp;
	<input type="text" name="gdesc" id="gdesc" class="input_common" maxlength="30" style="width:180px;" />
	<img src="/images/common/but/but_g_plus.gif" id="gdescRegBtn" alt="추가" title="추가" style="vertical-align:middle;margin:0 0 2px -4px;" class="btn"  />
</div>
<!-- 친구분류별 소트 -->
<div class="review_manage_state_group">
	<ul>
		<li class="gray_stitle"><a href="/myrevu/friend/<?php echo $TPL_VAR["type"]?>">전체</a></li>
<?php if($TPL_grouplist_1){foreach($TPL_VAR["grouplist"] as $TPL_V1){?>
		<li>|</li>
		<li>
			<a href="/myrevu/friend/<?php echo $TPL_VAR["type"]?>/<?php echo $TPL_V1["groupno"]?>"><?php if($TPL_VAR["groupno"]==$TPL_V1["groupno"]){?><strong><u><?php echo $TPL_V1["gdesc"]?></u></strong><?php }else{?><?php echo $TPL_V1["gdesc"]?><?php }?></a>&nbsp;
			<img src="/images/common/but/but_sw_xclose.gif" alt="삭제" title="삭제" class="h2_space btn" onClick="myfriend.confirmDeleteGroup(<?php echo $TPL_V1["groupno"]?>);" />
		</li>
<?php }}?>
	</ul>	
</div>
<!-- 친구별 검색,버튼 -->
<div class="clear"></div>
<div class="myfriend_state">
	<!-- 검색 -->
	<div class="myfriend_statel">
		<div style=" height:23px;margin-left:80px;">
			<select name="searchType" id="searchType">
				<option value="nickname">닉네임</option>
				<option value="email">이메일</option>
			</select>
			&nbsp;&nbsp;
			<input type="text" class="input_common" name="searchKeyword" id="searchKeyword" style=" width:140px;" />
			<img src="/images/common/but/but_s_search.gif" id="searchBtn" alt="검색" title="검색" class="btn" style="margin:0 0 -8px -4px;" />
		</div>
	</div>
	<!-- 내가등록 _i / 나를등록 _me / 서로등록 _eash -->
	<div class="myfriend_stater">
		<img src="/images/common/but/but_i_friend.gif" alt="내가등록한" title="내가등록한" onClick="common.redirect('/myrevu/friend/MY/<?php echo $TPL_VAR["groupno"]?>');" class="btn" />&nbsp;
		<img src="/images/common/but/but_me_friend.gif" alt="나를등록한" title="나를등록한" onClick="common.redirect('/myrevu/friend/ME/<?php echo $TPL_VAR["groupno"]?>');" class="btn" />&nbsp;
		<img src="/images/common/but/but_each_friend.gif" alt="서로등록한" title="서로등록한" onClick="common.redirect('/myrevu/friend/EO/<?php echo $TPL_VAR["groupno"]?>');" class="btn" />
	</div>
</div>
<div class="clear"></div>

<!-- 검색후 리스트 전체 시작 / 디폴트 4줄-->
<div class="myfriend_state">
	<div class="myfriend_white">
		<!--검색결과 텍스트 -->
		<div class="my_searchtext" id="resultUser" style="display:none;"></div>
		<div class="my_grayline2"></div>
		<div class="my_gray2box">
<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
			<div class="myfriend_<?php echo $TPL_V1["type"]?>_box">
				<ul>
					<li class="myfriend_thum"><img src="<?php echo $TPL_V1["userimage"]?>" width="80" height="80" onClick="context.load(<?php echo $TPL_V1["userno"]?>);" class="btn" /></li>
					<li class="myfriend_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);"><span class="white11_text"><?php echo $TPL_V1["nickname"]?></span></a></li>
				</ul>
			</div>
<?php if(($TPL_I1+ 1)% 5== 0){?>
			<div class="my_grayline2"></div>
<?php }else{?>
			<div class="myfriend_space"></div>
<?php }?>	
<?php }}?>
		</div>
	</div>
</div>
<!-- 프렌즈 리스트 전체 끝 / 디폴트 4줄 -->
<div class="clear"></div>
<div style="height:60px;"></div>
<center><?php echo $TPL_VAR["link"]?></center>