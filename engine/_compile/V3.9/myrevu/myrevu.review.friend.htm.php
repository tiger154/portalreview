<?php /* Template_ 2.2.4 2012/01/13 15:16:37 /www/revu39/engine/view/V3.9/myrevu/myrevu.review.friend.htm 000004390 */ 
$TPL_grouplist_1=empty($TPL_VAR["grouplist"])||!is_array($TPL_VAR["grouplist"])?0:count($TPL_VAR["grouplist"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="title_line">
	<div class="review_manage_title"></div>
	<!-- 리뷰관리 탭 시작 -->
	<div class="review_manage_tab">
		<ul>
			<li><img src="/images/myrevu/tab_myrevu_off1.gif" width="117" height="31" alt="나의리뷰" title="나의리뷰" onClick="common.redirect('/myrevu/review');" class="btn" /></li>
			<li><img src="/images/myrevu/tab_myrevu_on2.gif" width="117" height="31" alt="마이프렌즈리뷰" title="마이프렌즈리뷰" onClick="common.redirect('/myrevu/review.friend');" class="btn" /></li>
			<li><img src="/images/myrevu/tab_myrevu_off3.gif" width="117" height="31" alt="내가추천한리뷰" title="내가추천한리뷰" onClick="common.redirect('/myrevu/review.recom');" class="btn" /></li>
		</ul>
	</div>
	<!-- 리뷰관리 탭 끝 -->
</div>

<!-- 상단 상태 라인 -->
<div class="review_manage_state">
	<!-- 친구분류별 소트 -->
	<div class="review_manage_state_group">
		<ul>
			<li class="black_text"><strong>친구분류</strong></li>
			<li style="padding:0 5px; text-align:center;">|</li>			
			<li class="gray_stitle"><a href="/myrevu/review.friend">전체</a></li>
<?php if($TPL_grouplist_1){foreach($TPL_VAR["grouplist"] as $TPL_V1){?>
			<li style="padding:0 5px; text-align:center;">|</li>
			<li><a href="javascript:common.redirect('/myrevu/review.friend/1/<?php echo $TPL_V1["groupno"]?>')"><?php if($TPL_VAR["groupno"]==$TPL_V1["groupno"]){?><strong><u><?php echo $TPL_V1["gdesc"]?></u></strong><?php }else{?><?php echo $TPL_V1["gdesc"]?><?php }?></a></li>
<?php }}?>											
		</ul>
	</div>
	<div class="review_manage_stater"><span class="gray_db_text">총 <?php echo number_format($TPL_VAR["cnt"])?> 건</span></div>
</div>

<!-- 마이프렌즈 리스트 한묶음 시작  / 디폴트 10줄-->
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<div class="review_list">

	<!-- 리뷰의 썸네일 110110이상일경우 잘라내기 -->
	<div class="thum110_box">
		<img src="<?php echo $TPL_V1["thumbimage_url"]?>" width="110" height="110" />
	</div>
	<!-- 블로그별 포스트 박스 시작 -->
	<div class="friend_text_box">
		<ul>
			<li style="width:426px; height:32px;">
				<div class="review_title_ico"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
				<div class="friend_title_line gray_title">
					<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a> 
				</div>
			</li>
			<li style="width:426px; height:24px;">
				<div class="friend_cate_name gray_d_text">
					<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["nickname"]?></a>&nbsp;
				</div>
				<div class="friend_cate_line gray11_l_text">
					<?php echo $TPL_V1["cate_desc"]?>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo $TPL_V1["regdate"]?>

				</div>
			</li>
			<li style="width:426px; height:54px;">
				<div class="friend_text"><?php echo $TPL_V1["content"]?></div>
			</li>
		</ul>
	</div>
	<!-- 블로그별 포스트 박스 끝 -->
	
	<!-- sns 박스 시작-->
	<div class="review_sns_box">
		<ul>
			<!-- 페이스북 버튼 삽입  / 보류 -->
			<li class="pt10" style="height:20px;"></li>
			<!-- 레뷰추천 버튼 삽입 / 최대999  -->
			<li class="pt20">
				<div class="revu_hit_box">
					<div class="revu_hit_boxl">
						<img src="/images/common/but/but_revuhit.gif" alt="추천" title="추천" class="btn" onClick="socialbar.recomView(<?php echo $TPL_V1["rno"]?>)"/>
					</div>
					<div class="revu_hit_boxr">
						<div class="revu_hit_text" style="display:block;">
							<span class="red11t_text"><?php echo $TPL_V1["recom_cnt"]?></span>
						</div>
					</div>
				</div>
			</li>
			<!-- 트워터 버튼 삽입 / 보류 -->
			<li class="pt10" ></li>
		</ul>
	</div>
	<!-- sns 박스 끝-->
	<div class="review_dot_line"></div>
</div>
<?php }}?>
<!-- 마이프렌즈 리스트 한묶음 끝 -->
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>