<?php /* Template_ 2.2.4 2012/01/13 15:13:19 /www/revu39/engine/view/V3.9/myrevu/myrevu.review.htm 000004920 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/review.manager.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.review.js"></script>

<div class="title_line">
	<div class="review_manage_title"></div>
	<!-- 리뷰관리 탭 시작 -->
	<div class="review_manage_tab">
		<ul>
			<li><img src="/images/myrevu/tab_myrevu_on1.gif" width="117" height="31" onClick="common.redirect('/myrevu/review');" class="btn" /></li>
			<li><img src="/images/myrevu/tab_myrevu_off2.gif" width="117" height="31" alt="마이프렌즈리뷰" title="마이프렌즈리뷰" onClick="common.redirect('/myrevu/review.friend');" class="btn" /></li>
			<li><img src="/images/myrevu/tab_myrevu_off3.gif" width="117" height="31" alt="내가추천한리뷰" title="내가추천한리뷰" onClick="common.redirect('/myrevu/review.recom');" class="btn" /></li>
		</ul>
	</div>
	<!-- 리뷰관리 탭 끝 -->
</div>
<!-- 상단 상태 라인 -->
<div class="review_manage_state">
	<div class="review_manage_stater"><span class="gray_db_text">총 <?php echo number_format($TPL_VAR["cnt"])?> 건</span></div>
</div>

<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<div class="review_list">
	<div class="check_box">
		<input type="checkbox" name="checkno" value="<?php echo $TPL_V1["rno"]?>">
	</div>
	<!-- 리뷰의 썸네일 110110이상일경우 잘라내기 -->
	<div class="thum110_box">
		<img src="<?php echo $TPL_V1["thumbimage_url"]?>" width="110" height="110" />
	</div>
	<!-- 블로그별 포스트 박스 시작 -->
	<div class="review_text_box">
		<ul>
			<li style="width:399px; height:32px;">
				<div class="review_title_ico"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
				<div class="review_title_line gray_title">
					<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a>
				</div>
				<div class="review_title_but">
					<img src="/images/common/ico/ico_edit.gif" alt="수정" title="수정" class="btn" onClick="reviewManager.infoReview(<?php echo $TPL_V1["rno"]?>)" />
					&nbsp;&nbsp;
					<img src="/images/common/ico/ico_del.gif" alt="삭제" title="삭제" class="btn" onClick="reviewManager.deleteReview(<?php echo $TPL_V1["rno"]?>)" />
				</div>
			</li>
			<li style="width:399px; height:24px;">
				<div class="review_cate_line gray11_l_text">
					<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>)"><?php echo $TPL_V1["nickname"]?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo $TPL_V1["cate_desc"]?>&nbsp;&nbsp;|&nbsp;&nbsp;
					<?php echo $TPL_V1["regdate"]?>

				</div>
				<div class="review_cate_cash"><span class="red_text" style="margin-left:19px;"><?php echo $TPL_V1["cash"]?></span></div>
			</li>
			<li style="width:399px; height:54px;">
				<div class="review_text"><?php echo $TPL_V1["content"]?></div>
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
			<li class="pt10"></li>
		</ul>
	</div>
	<!-- sns 박스 끝-->
	<div class="review_dot_line"></div>
</div>
<?php }}?>

<div style="width:714px; height:18px; padding:8px 0 8px 0; text-align:left;">
	<img src="/images/common/but/but_g_allchoice.gif" id="reverseBtn" alt="전체선택" title="전체선택" class="btn" />
	&nbsp;
	<img src="/images/common/but/but_w_choicedel.gif" id="deleteBtn" alt="선택삭제" title="선택삭제" class="btn" /></a>
</div>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>

<div id="reviewlayer" style="display:none;background-color: #FFF;padding:20px;"><?php $this->print_("reviewlayer",$TPL_SCP,1);?></div>