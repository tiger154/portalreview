<?php /* Template_ 2.2.4 2012/01/13 15:22:15 /www/revu39/engine/view/V3.9/review/review.best.htm 000008340 */ 
$TPL_best_1=empty($TPL_VAR["best"])||!is_array($TPL_VAR["best"])?0:count($TPL_VAR["best"]);?>
<div class="title_line"><img src="/images/review/title_bestreview.gif"  align="left"/></div>
<!-- 베스트리뷰선출방법 팝업 연결 -->
<div style="width:714px; height:245px;">
	<img src="/images/review/img_bestreview.gif" id="popupBestVoteBtn" alt="베스트리뷰선출방법" title="베스트리뷰선출방법" class="btn" />
</div>
<!-- 리뷰 베스트박스 시작 -->
<div class="review_best_box">
	<div class="review_best_title">
		<div class="review_best_week">
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/text_gl_pre.gif" alt="이전" title="이전" class="btn" onClick="review.goBest(<?php echo $TPL_VAR["prev_wno"]?>);" />
			<a href="javascript:review.goBest(<?php echo $TPL_VAR["wno"]?>);"><span class="gray_lb_text"><?php echo $TPL_VAR["bestdate"]["sdate"]?> ~ <?php echo $TPL_VAR["bestdate"]["edate"]?></span></a>
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/text_gl_next.gif" alt="다음" title="다음" class="btn" onClick="review.goBest(<?php echo $TPL_VAR["next_wno"]?>);" />
		</div>
	</div>
	<div class="clear"></div>
	<div class="review_best_list">
		<ul>
<?php if($TPL_best_1){$TPL_I1=-1;foreach($TPL_VAR["best"] as $TPL_V1){$TPL_I1++;?>
			<li class="review_best_line<?php echo $TPL_I1+ 1?>">
				<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);" class="socialbar"><span class="review_best_text1 btn <?php if($TPL_I1== 0){?>red_text<?php }else{?>common_text<?php }?>"><?php echo $TPL_V1["title"]?></span></a>
				<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);" class="context-user"><span class="review_best_text2 btn <?php if($TPL_I1== 0){?>red_text<?php }else{?>common_text<?php }?>"><?php echo $TPL_V1["user"]["nickname"]?></span></a>
				<span class="review_best_text3 common_text"><?php echo $TPL_V1["best_recom_cnt"]?></span>
			</li>
<?php }}?>
		</ul>
	</div>
	<!-- 그주에 베스트1위 썸네일 노출 / 이미지 없을시 thum_222_dummy.gif 로 대체 -->
	<div class="review_best_thum">
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/review/icon_bbest.png" class="review_best_layer"/>
<?php if($TPL_VAR["best"][ 0]["thumbimage_url"]==""){?>
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/thum/thum_222_dummy.gif" />
<?php }else{?>
		<img src="<?php echo $TPL_VAR["best"][ 0]["thumbimage_url"]?>" width="222" height="222" />
<?php }?>
	</div>
</div>
<!-- 리뷰 베스트박스 끝-->
<div class="clear"></div>
<div class="pt40"></div>
<div style="width:714px; height:30px; padding-bottom:30px;">
	<img src="/images/review/title_weekbest.gif" />
</div>
<!--디지털 베스트리뷰 한묶음 시작 -->
<?php if(is_array($TPL_R1=$TPL_VAR["list"][ 0]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<div class="week_best_box">
	<div class="best_count"><span class="red11t_text pr25 btn" onClick="review.recomUser(<?php echo $TPL_V1["wno"]?>,<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["best_recom_cnt"]?></span></div>
	<div class="best_post1 common_text"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a></div>
	<div class="best_post2  gray_l_text"><?php echo $TPL_V1["nickname"]?> | <?php echo $TPL_V1["regdate"]?></div>
	<div class="ico_blog"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
</div>
<div class="clear"></div>
<?php }}?>
<div class="clear cbox_line"></div>
<!-- 디지털 베스트리뷰 한묶음 끝 -->

<!--라이프 베스트리뷰 한묶음 시작 -->
<?php if(is_array($TPL_R1=$TPL_VAR["list"][ 1]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<div class="week_best_box">
	<div class="best_count"><span class="red11t_text pr25 btn" onClick="review.recomUser(<?php echo $TPL_V1["wno"]?>,<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["best_recom_cnt"]?></span></div>
	<div class="best_post1 common_text"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a></div>
	<div class="best_post2  gray_l_text"><?php echo $TPL_V1["nickname"]?> | <?php echo $TPL_V1["regdate"]?></div>
	<div class="ico_blog"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
</div>
<div class="clear"></div>
<?php }}?>

<div class="clear cbox_line"></div>
<!-- 라이프 베스트리뷰 한묶음 끝 -->

<!-- 쇼핑 베스트리뷰 한묶음 시작 -->
<?php if(is_array($TPL_R1=$TPL_VAR["list"][ 2]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<div class="week_best_box">
	<div class="best_count"><span class="red11t_text pr25 btn" onClick="review.recomUser(<?php echo $TPL_V1["wno"]?>,<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["best_recom_cnt"]?></span></div>
	<div class="best_post1 common_text"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a></div>
	<div class="best_post2  gray_l_text"><?php echo $TPL_V1["nickname"]?> | <?php echo $TPL_V1["regdate"]?></div>
	<div class="ico_blog"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
</div>
<div class="clear"></div>
<?php }}?>
<div class="clear cbox_line"></div>
<!-- 쇼핑 베스트리뷰 한묶음 끝 -->

<!-- 지역 베스트리뷰 한묶음 시작 -->
<?php if(is_array($TPL_R1=$TPL_VAR["list"][ 3]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<div class="week_best_box">
	<div class="best_count"><span class="red11t_text pr25 btn" onClick="review.recomUser(<?php echo $TPL_V1["wno"]?>,<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["best_recom_cnt"]?></span></div>
	<div class="best_post1 common_text"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a></div>
	<div class="best_post2  gray_l_text"><?php echo $TPL_V1["nickname"]?> | <?php echo $TPL_V1["regdate"]?></div>
	<div class="ico_blog"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
</div>
<div class="clear"></div>
<?php }}?>
<div  class="clear cbox_line"></div>
<!-- 지역 베스트리뷰 한묶음 끝 -->

<!-- 컬쳐 베스트리뷰 한묶음 시작 -->
<?php if(is_array($TPL_R1=$TPL_VAR["list"][ 4]["list"])&&!empty($TPL_R1)){foreach($TPL_R1 as $TPL_V1){?>
<div class="week_best_box">
	<div class="best_count"><span class="red11t_text pr25 btn" onClick="review.recomUser(<?php echo $TPL_V1["wno"]?>,<?php echo $TPL_V1["rno"]?>)"><?php echo $TPL_V1["best_recom_cnt"]?></span></div>
	<div class="best_post1 common_text"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>)" name="<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["title"]?></a></div>
	<div class="best_post2  gray_l_text"><?php echo $TPL_V1["nickname"]?> | <?php echo $TPL_V1["regdate"]?></div>
	<div class="ico_blog"><img src="<?php echo $TPL_V1["blog_icon"]?>" /></div>
</div>
<div class="clear"></div>
<?php }}?>
<div  class="clear cbox_line"></div>
<!-- 컬쳐 베스트리뷰 한묶음 끝 -->			

<div class="clear"></div>
<div class="pop_bestbloger_box" id="popupBestVoteLayer" style="display:none;position:absolute;" class="btn">
	<div class="pop_bestbloger_tbox">
		<ul>
			<li class="pop_bestbloger_title2">
				<img src="/images/common/but/but_xclose.gif" id="popupBestVoteClose" alt="닫기" title="닫기" class="pb09 btn" align="right" />
			</li>
			<li style="height:20px;"></li>
			<li style="height:360px;"><img src="/images/review/img_bestinfo.gif" /></li>
		</ul>
	</div>
</div>
<!-- 추천회원리스트 /사이즈427가변 -->

<div class="pop_bestbloger_box" id="popupBestRecomLayer" style="display:none;position:absolute;width:427px;" class="btn">
	<div class="pop_bestbloger_tbox">
		<div class="pop_bestbloger_title1">
			<img src="/images/common/but/but_xclose.gif" align="right" id="popupBestRecomClose" alt="닫기" title="닫기" class="pb09 btn" />
		</div>
		<div style="height:15px; padding:10px 0 25px 0; text-align:right;">
			<span class="gray11_l_text">* 최근  10건</span> |
			<span class="red11_text">회원 추천수 : </span>
			<span class="red11_text" id="recomCnt">0</span>
		</div>
		<div id="bestRecomUser" style="height:273px;"></div>
	</div>
</div>