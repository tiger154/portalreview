<?php /* Template_ 2.2.4 2012/01/17 13:48:39 /www/revu39/engine/view/V3.9/myrevu/index.htm 000014503 */ 
$TPL_frontierEntry_1=empty($TPL_VAR["frontierEntry"])||!is_array($TPL_VAR["frontierEntry"])?0:count($TPL_VAR["frontierEntry"]);
$TPL_myfron_winlist_1=empty($TPL_VAR["myfron_winlist"])||!is_array($TPL_VAR["myfron_winlist"])?0:count($TPL_VAR["myfron_winlist"]);
$TPL_myreview_1=empty($TPL_VAR["myreview"])||!is_array($TPL_VAR["myreview"])?0:count($TPL_VAR["myreview"]);
$TPL_friendList1_1=empty($TPL_VAR["friendList1"])||!is_array($TPL_VAR["friendList1"])?0:count($TPL_VAR["friendList1"]);
$TPL_friendList2_1=empty($TPL_VAR["friendList2"])||!is_array($TPL_VAR["friendList2"])?0:count($TPL_VAR["friendList2"]);
$TPL_friendList3_1=empty($TPL_VAR["friendList3"])||!is_array($TPL_VAR["friendList3"])?0:count($TPL_VAR["friendList3"]);
$TPL_talklist1_1=empty($TPL_VAR["talklist1"])||!is_array($TPL_VAR["talklist1"])?0:count($TPL_VAR["talklist1"]);
$TPL_talklist2_1=empty($TPL_VAR["talklist2"])||!is_array($TPL_VAR["talklist2"])?0:count($TPL_VAR["talklist2"]);?>
<div class="title_line">
	<div class="my_frontier_title"></div>
	<!-- 프론티어관리 탭 /응모한 시작 -->
	<div class="my_frontier_tab">
		<ul>
			<li><img src="/images/myrevu/tab_frontier_on1.gif" id="frontierTab1" width="116" height="29" alt="응모중인프론티어" title="응모중인프론티어" class="btn" /></li>
			<li><img src="/images/myrevu/tab_frontier_off2.gif" id="frontierTab2" width="116" height="29" alt="당첨된프론티어" title="당첨된프론티어" class="btn" /></li>
		</ul>
	</div>
	<!-- 프론티어관리 탭 끝 -->
</div>

<div class="clear" style="width:714px; height:20px;"></div>

<!-- 응모한프론트어 -->
<div id="frontierEntry" class="m_talktime2">
	<!--해당프론티어 한줄 시작 -->
<?php if($TPL_VAR["frontierEntrySize"]> 0){?>
<?php if($TPL_frontierEntry_1){foreach($TPL_VAR["frontierEntry"] as $TPL_V1){?>
	<div class="m_talktime_line">
		<!-- 프론티어이미지 비례축소 066066 -->
		<div class="m_talktime_thum">
			<a href="frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_top"><img src="<?php echo $TPL_V1["entryimg"]?>"  width="66" height="66"/></a>
			</div>
		<div class="m_talktime_text1">
			<?php echo $TPL_V1["title"]?>

		</div>
		<div class="m_talktime_text2"><?php echo $TPL_V1["content"]?></div>
	</div>
	<div class="m_talktime_sbox">
		<div style="padding:26px 0 0 34px;"><span class="orange_text"><?php echo $TPL_V1["entrytimer"]?></span></div>
	</div>
	<div class="m_talktime_dotline"></div>
<?php }}?>
<?php }else{?>
	<div class="pt25"></div>
	<center><U>응모</U>한 프론티어가 없습니다.</center>
<?php }?>
	<!--해당프론티어 한줄 끝 -->
	<div style="width:714px; height:20px; padding-top:5px; text-align:right;" class="clear" >
		<img src="/images/common/ico/ico_more.gif" id="frontierEntryMoreBtn" class="btn" />
	</div>
	<div style="height:25px;"></div>
</div>
<!-- 응모한프론트어 끝 -->

<!-- 당첨된프론트어 -->
<div id="frontierWin" class="m_talktime2">
	<!--해당프론티어 한줄 시작 -->
<?php if($TPL_VAR["frontierWinsize"]> 0){?>
<?php if($TPL_myfron_winlist_1){foreach($TPL_VAR["myfron_winlist"] as $TPL_V1){?>
	<div class="m_talktime_line">
		<!-- 프론티어이미지 비례축소 066066 -->
		<div class="m_talktime_thum">
			<a href="frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_top"><img src="<?php echo $TPL_V1["winimg"]?>"  width="66" height="66"/></a>
		</div>
		<div class="m_talktime_text1">
			<a href="frontier/detailview//<?php echo $TPL_V1["frno"]?>//" target="_blank"><span class="gray_stitle"><?php echo $TPL_V1["subject"]?></span></a>
		</div>
		<!-- 당첨된 프론티어의 리뷰가 없을때 -->
<?php if($TPL_VAR["frontierreviewsize"]> 0){?>
		<div class="m_talktime_text3"><?php echo $TPL_V1["content"]?></div>
		</div>
		<div>
			<div></div>
		</div>
<?php }else{?>
		<div class="m_talktime_text3">본 프론티어에 <font color=#FF6666>리뷰</font>를 등록해 주세요.</div>
		</div>
		<div class="m_talktime_sbox">
			<div style="padding:26px 0 0 34px;"><span class="orange_text"><a href='javascript:reviewManager.setFrontier(<?php echo $TPL_V1["frno"]?>,"<?php echo $TPL_V1["subject"]?>");common.openCenterLayer("entrylayer2", -1, -1, 90);'>리뷰등록</a> D-<?php echo $TPL_V1["due_edate"]?></span></div>
		</div>
<?php }?>
	<div class="m_talktime_dotline"></div>
<?php }}?>
<?php }else{?>
	<div style="height:25px;"></div>
	<center><U>당첨</U>된 프론티어가 없습니다.</center>
<?php }?>

	<!--해당프론티어 한줄 끝 -->
	<div style="width:714px; height:20px; padding-top:5px; text-align:right;" class="clear" >
		<img src="/images/common/ico/ico_more.gif" id="frontierWinMoreBtn" class="btn" />
	</div>
	<div style="height:25px;"></div>
</div>
<!-- 응모한프론트어 끝 -->

<div class="clear"></div>

<!-- 리뷰관리 시작 -->
<div class="title42_line">
	<ul>
		<li style="width:134px;" class="fl"><img src="/images/myrevu/title_manage_review.gif"  align="left"/></li>
		<li style="width:265px; height:22px; padding-right:15px;text-align:right;" class="fr">
		</li>
	</ul>
</div>
<div class="clear"></div>
<div style="width:714px; height:auto;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="table_listbg" width="120"><span class="gray_d_text"><strong>등록일</strong></span></td>
			<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
			<td class="table_listbg" width="480"><span class="gray_d_text"><strong>리뷰 제목</strong></span></td>
			<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
			<td class="table_listbg" width="120"><span class="gray_d_text"><strong>적립 캐쉬</strong></span></td>
		</tr>
<?php if($TPL_myreview_1){foreach($TPL_VAR["myreview"] as $TPL_V1){?>
		<tr>
			<td colspan="2" class="table12_line" align="center">
				<div class="common_text text_overlay17"><?php echo $TPL_V1["regdate"]?></div>
			</td>
			<td colspan="2" class="table12_line" >
				<div class="common_text text_overlay17">
					<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a>
					&nbsp;
					<span class="red_text"></span>
				</div>
			</td>
			<td class="table12_line" align="center"><span class="red_b_text">+ <?php echo $TPL_V1["cash"]?></span></td>
		</tr>
<?php }}?>
	</table>
</div>

<div style="width:714px; height:20px; padding-top:5px;margin-bottom:40px; text-align:right;" class="clear" >
	<img src="/images/common/ico/ico_more.gif" id="reviewMoreBtn" class="btn" />
</div>
<div style="height:25px;"></div>

<!-- 프렌즈관리 시작 -->
<div class="title_line">
	<div class="my_friend_title"> </div>
	<!-- 프렌즈관리 탭 시작 -->
	<div class="my_friend_tab">
		<ul>
			<li><img src="/images/myrevu/tab_friend_on1.gif" id="friendTab1" width="131" height="29" alt="서로등록한프렌즈" title="내가등록한프렌즈" class="btn" /></li>
			<li><img src="/images/myrevu/tab_friend_off2.gif" id="friendTab2" width="131" height="29" alt="내가등록한프렌즈" title="내가등록한프렌즈" class="btn" /></li>
			<li><img src="/images/myrevu/tab_friend_off3.gif" id="friendTab3" width="131" height="29" alt="나를등록한프렌즈" title="나를등록한프렌즈" class="btn" /></li>
		</ul>
	</div>
	<!-- 프렌즈관리 탭 끝 -->
</div>
<div class="clear" style="width:714px; height:20px;"></div>

<div id="friendList1">
	<div class="myfriend_state">
		<div class="myfriend_white">
			<!--검색결과 텍스트 -->
			<div class="my_searchtext" id="resultUser" style="display:none;"></div>
			<div class="my_grayline2"></div>
			<div class="my_gray2box">
<?php if($TPL_VAR["friendSize1"]> 0){?>
<?php if($TPL_friendList1_1){$TPL_I1=-1;foreach($TPL_VAR["friendList1"] as $TPL_V1){$TPL_I1++;?>
				<div class="myfriend_EO_box">
					<ul>
						<li class="myfriend_thum"><img src="<?php echo $TPL_V1["userimage"]?>" onClick="context.load(<?php echo $TPL_V1["userno"]?>);" class="btn" /></li>
						<li class="myfriend_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);"><span class="white11_text"><?php echo $TPL_V1["nickname"]?></span></a></li>
					</ul>
				</div>
<?php if(($TPL_I1+ 1)% 5== 0){?>
				<div class="my_grayline2"></div>
<?php }else{?>
				<div class="myfriend_space"></div>
<?php }?>	
<?php }}?>
<?php }else{?>
			<div class="pt25"></div>
			<center>등록된 친구가 없습니다.</center>
<?php }?>
			</div>
		</div>
	</div>
</div>

<div id="friendList2">
	<div class="myfriend_state">
		<div class="myfriend_white">
			<!--검색결과 텍스트 -->
			<div class="my_searchtext" id="resultUser" style="display:none;"></div>
			<div class="my_grayline2"></div>
			<div class="my_gray2box">
<?php if($TPL_VAR["friendSize2"]> 0){?>
<?php if($TPL_friendList2_1){$TPL_I1=-1;foreach($TPL_VAR["friendList2"] as $TPL_V1){$TPL_I1++;?>
				<div class="myfriend_MY_box">
					<ul>
						<li class="myfriend_thum"><img src="<?php echo $TPL_V1["userimage"]?>" onClick="context.load(<?php echo $TPL_V1["userno"]?>);" class="btn" /></li>
						<li class="myfriend_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);"><span class="white11_text"><?php echo $TPL_V1["nickname"]?></span></a></li>
					</ul>
				</div>
<?php if(($TPL_I1+ 1)% 5== 0){?>
				<div class="my_grayline2"></div>
<?php }else{?>
				<div class="myfriend_space"></div>
<?php }?>	
<?php }}?>
<?php }else{?>
			<div class="pt25"></div>
			<center>등록된 친구가 없습니다.</center>
<?php }?>
			</div>
		</div>
	</div>
</div>

<div id="friendList3">
	<div class="myfriend_state">
		<div class="myfriend_white">
			<!--검색결과 텍스트 -->
			<div class="my_searchtext" id="resultUser" style="display:none;"></div>
			<div class="my_grayline2"></div>
			<div class="my_gray2box">
<?php if($TPL_VAR["friendSize3"]> 0){?>
<?php if($TPL_friendList3_1){$TPL_I1=-1;foreach($TPL_VAR["friendList3"] as $TPL_V1){$TPL_I1++;?>
				<div class="myfriend_ME_box">
					<ul>
						<li class="myfriend_thum"><img src="<?php echo $TPL_V1["userimage"]?>" onClick="context.load(<?php echo $TPL_V1["userno"]?>);" class="btn" /></li>
						<li class="myfriend_text"><a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);"><span class="white11_text"><?php echo $TPL_V1["nickname"]?></span></a></li>
					</ul>
				</div>
<?php if(($TPL_I1+ 1)% 5== 0){?>
				<div class="my_grayline2"></div>
<?php }else{?>
				<div class="myfriend_space"></div>
<?php }?>	
<?php }}?>
<?php }else{?>
			<div class="pt25"></div>
			<center>등록된 친구가 없습니다.</center>
<?php }?>
			</div>
		</div>
	</div>
</div>

<div style="width:714px; height:20px; padding-top:5px; margin-bottom:40px; text-align:right;" class="clear" >
	<img src="/images/common/ico/ico_more.gif" id="friendMoreBtn" class="btn" />
</div>

<div class="title_line">
	<div style="width:134px;" class="fl"><img src="/images/myrevu/title_manage_social.gif"  align="left"/></div>
	<div class="socialtalk_tab">
		<ul>
			<li><img src="/images/myrevu/tab_socialtalk_on1.gif" id="socialTab1" width="116" height="29" alt="내가쓴토크" title="내가쓴토크" class="btn" /></li>
			<li><img src="/images/myrevu/tab_socialtalk_off2.gif" id="socialTab2" width="116" height="29" alt="내리뷰에달린토크" title="내리뷰에달린토크" class="btn" /></li>
		</ul>
	</div>
</div>
<div class="clear" style="width:714px; height:20px;"></div>

<div id="socialTalk1">
<?php if($TPL_talklist1_1){foreach($TPL_VAR["talklist1"] as $TPL_V1){?>
	<div class="socialtalk_list66">
		<div class="thum66_box"><img src="<?php echo $TPL_V1["userimage"]?>" width="66" height="66" /></div>
		<div class="socialtalk_text_box66">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="30" align="center" class="pop_reply_gline" valign="top"><img src="<?php echo $TPL_V1["icon"]?>"/></td>
					<td width="569" class="pop_reply_gline">
						<div class="gray11_l_text text_overlay17"><?php echo $TPL_V1["ref"]?> ㅣ <?php echo $TPL_V1["regdate"]?></div>
						<div class="common11_text text_overlay14"><strong><?php echo $TPL_V1["talk"]?></strong></div>
						<div class="sns_post_line66"> 
							<a href="javascript:common.socialbar(<?php echo $TPL_V1["review"]["rno"]?>);"><span class="gray_l_text" style="text-decoration:underline;"><?php echo $TPL_V1["title"]?></span></a>
						</div>
						<!--<div class="sns_kind66 gray11_l_text">| 리뷰에 달린 토크</div>-->
					</td>
				</tr>				
			</table>
		</div>
	</div>
<?php }}?>
	<div style="width:714px; height:20px; padding-top:5px;margin-bottom:40px; text-align:right; border-top:#cccccc solid 1px;" class="clear" >
		<a href="/myrevu/talk/1"><img src="/images/common/ico/ico_more.gif" /></a>
	</div>
</div>

<div id="socialTalk2">
<?php if($TPL_talklist2_1){foreach($TPL_VAR["talklist2"] as $TPL_V1){?>
	<div class="socialtalk_list66">
		<div class="thum66_box"><img src="<?php echo $TPL_V1["userimage"]?>" width="66" height="66" /></div>
		<div class="socialtalk_text_box66">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="30" align="center" class="pop_reply_gline" valign="top"><img src="<?php echo $TPL_V1["icon"]?>"/></td>
					<td width="569" class="pop_reply_gline">
						<div class="gray11_l_text text_overlay17"><?php echo $TPL_V1["ref"]?> ㅣ <?php echo $TPL_V1["regdate"]?></div>
						<div class="common11_text text_overlay14"><strong><?php echo $TPL_V1["talk"]?></strong></div>
						<div class="sns_post_line66"> 
							<a href="javascript:common.socialbar(<?php echo $TPL_V1["review"]["rno"]?>);"><span class="gray_l_text" style="text-decoration:underline;"><?php echo $TPL_V1["title"]?></span></a>
						</div>
						<!--<div class="sns_kind66 gray11_l_text">| 리뷰에 달린 토크</div>-->
					</td>
				</tr>				
			</table>
		</div>
	</div>
<?php }}?>
	<div style="width:714px; height:20px; padding-top:5px;margin-bottom:40px; text-align:right; border-top:#cccccc solid 1px;" class="clear" >
		<a href="/myrevu/talk/0"><img src="/images/common/ico/ico_more.gif" /></a>
	</div>
</div>

<div id="entrylayer2" style="display:none; position:absolute; "><?php $this->print_("entrylayer2",$TPL_SCP,1);?></div>
<div id="reviewlayer" style="display:none; position:absolute; "><?php $this->print_("reviewlayer",$TPL_SCP,1);?></div>