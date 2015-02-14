<?php /* Template_ 2.2.4 2012/01/16 14:46:12 /www/revu39/engine/view/V3.9/review/review.frontier.htm 000005656 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script>var code = "<?php echo(Module::$param[1])?>";</script>
<!-- 각 카데고리명 표시 -->
<div class="review_category">
	<img src="<?php echo $TPL_VAR["IMAGES"]?>/review/title_review.gif" align="left"/>
	<ul>
		<li class="pl25">&nbsp;</li>
		<!-- 카테고리별 텝 시작 / 전체가 디폴트 / 선택시 파일명 on으로 변경 -->
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off1.gif" id="rcate1" class="btn" alt="전체" title="전체" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off2.gif" id="rcate2" class="btn" alt="맛집" title="맛집" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off3.gif" id="rcate3" class="btn" alt="여행" title="여행" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off4.gif" id="rcate4" class="btn" alt="패션" title="패션" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off5.gif" id="rcate5" class="btn" alt="요리" title="요리" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off6.gif" id="rcate6" class="btn" alt="화장품" title="화장품" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off7.gif" id="rcate7" class="btn" alt="IT" title="IT" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off8.gif" id="rcate8" class="btn" alt="영화" title="영화" /></li>
		<li><img src="<?php echo $TPL_VAR["IMAGES"]?>/review/tab_review_off9.gif" id="rcate9" class="btn" alt="프론티어" title="프론티어" /></li>
	</ul>
</div>
<div class="clear"></div>
<br />

<!-- 리스트 묶음 박스 시작  / 한페이지에 10개 나열-->
<div class="review_list">
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<ul>
<?php if($TPL_V1["is_thumb"]=="1"){?>
		<li class="thumb110_box">
		<!-- 리스트 이미지 -->
			<img src="<?php echo $TPL_V1["thumbimage110_url"]?>" alt="<?php echo $TPL_V1["title"]?>" width="110" height="110" />			
		</li>
<?php }?>
<?php if($TPL_V1["is_thumb"]=="1"){?>
		<li class="review_text_box">
			<!-- 리뷰 내용 박스 -->
			<div class="list_title_line gray_title">
				<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);" name="<?php echo $TPL_V1["rno"]?>" class="socialbar"><?php echo $TPL_V1["title"]?></a>
			</div>
			<!-- 소셜토크 없으면 히든처리 -->
			<div class="review_title_talk red11_text">(<?php echo $TPL_V1["talk_cnt"]?>)</div>
			<div class="clear"></div>
			<div class="review_text_line"><?php echo $TPL_V1["content"]?></div>
			<!-- 블로그 타입이미지 삽입  / daum, egloos, naver,tistory / 그 이외의것 etc -->
			<div class="review_text_line2 gray11_l_text">
				<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);" class="context-user"><?php echo $TPL_V1["nickname"]?></a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $TPL_V1["regdate"]?>

				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $TPL_V1["cate_desc"]?>

				<img src="<?php echo $TPL_V1["blog_icon"]?>" class="imgb_space" />
			</div>
		</li>
<?php }elseif($TPL_V1["is_thumb"]=="0"){?>
		<li class="review_text_box2">
			<!-- 리뷰 내용 박스 -->
			<div class="list_title_bline gray_title">
				<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);" name="<?php echo $TPL_V1["rno"]?>" class="socialbar"><?php echo $TPL_V1["title"]?></a>
			</div>
			<!-- 소셜토크 없으면 히든처리 -->
			<div class="review_title_talk red11_text">(<?php echo $TPL_V1["talk_cnt"]?>)</div>
			<div class="clear"></div>
			<div class="review_text_bline"><?php echo $TPL_V1["content"]?></div>
			<!-- 블로그 타입이미지 삽입  / daum, egloos, naver,tistory / 그 이외의것 etc -->
			<div class="review_text_bline2 gray11_l_text">
				<a href="javascript:context.load(<?php echo $TPL_V1["userno"]?>);" class="context-user"><?php echo $TPL_V1["nickname"]?></a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $TPL_V1["regdate"]?>

				&nbsp;&nbsp;|&nbsp;&nbsp;
				<?php echo $TPL_V1["cate_desc"]?>

				<img src="<?php echo $TPL_V1["blog_icon"]?>" class="imgb_space" />
			</div>
		</li>
<?php }?>
		<li class="review_sns_box">
			<!--  sns 박스 -->
			<!-- 레뷰추천 버튼 삽입 / 최대999  -->
			<div class="pt40"></div>
			<div class="revu_hit_box">
				<div class="revu_hit_boxl">
					<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_revuhit.gif" onClick="common.socialbarRecom(<?php echo $TPL_V1["rno"]?>)" alt="추천" title="추천" class="btn" />
				</div>
				<div class="revu_hit_boxr">
					<div class="revu_hit_text" style="display:block;"><span class="red11t_text" id="recom_cnt<?php echo $TPL_V1["rno"]?>"><?php echo $TPL_V1["recom_cnt"]?></span></div>
				</div>
			</div>
			<div class="pt10"></div>
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_b_tweet.gif" onClick="twitter.todo('tweet', <?php echo $TPL_V1["rno"]?>);" class="btn" />
			<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_b_facebook.gif" onClick="facebook.todo('wall', <?php echo $TPL_V1["rno"]?>);" class="btn" />
			<!-- sns 박스 끝-->
		</li>
	</ul>
	<div class="clear"></div>
	<div class="cbox_line"></div>
<?php }}?>
</div>
<!-- 리스트 묶음 박스 끝 -->
<div class="clear"></div>
<?php if($TPL_VAR["size"]> 0){?> 
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
<div class="nolist">등록된 리뷰가 없습니다.</div>
<?php }?>