<?php /* Template_ 2.2.4 2012/01/13 15:18:48 /www/revu39/engine/view/V3.9/blog/blog.info.htm 000002635 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="title_line">
	<span class="title_nick"><?php echo $TPL_VAR["nickname"]?></span>&nbsp;&nbsp;<span class="title_text">님의 블로그입니다.</span>
</div>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<div class="myblog_title_bg" style="margin-top:20px;">
	<!-- 블로그 제목 -->
	<div class="myblog_title_text">
		<span class="black_title w20_space"><?php echo $TPL_V1["name"]?></span>
		(<a href="<?php echo $TPL_V1["url"]?>" target="_blank" style="text-decoration:underline;"><?php echo $TPL_V1["url"]?></a>)
	</div>
</div>
<!-- 블로그 정보 박스 시작 -->
<div class="myblog_box">
	<div class="myblog_tbox">
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td class="block_text100">등록일</td>
				<td class="block_text520" colspan="3"><span class="gray_l_text"><strong><?php echo $TPL_V1["regdate"]?></strong></span></td>
			</tr>
			<tr>
				<td class="block_text100">총 리뷰 수</td>
				<!-- 프론티어 리뷰로 연결 -->
				<td class="block_text195"><a href="javascript:common.redirect('/blog/@<?php echo $TPL_VAR["nickname"]?>/<?php echo $TPL_V1["blogno"]?>');" style="text-decoration:underline"><span class="gray_db_text"><?php echo $TPL_V1["review_cnt"]?></span></a> 건</td>
				<td class="block_text100">총 토크 수</td>
				<td class="block_text195"><span class="gray_db_text"><?php echo $TPL_V1["talk_cnt"]?></span>건</td>
			</tr>
			<tr>
				<td class="block_text100">최근 <br />등록 리뷰</td>
				<td class="block_text520" colspan="3">
				<div style="width:520px; height:auto; padding-top:10px;">
					<ul>
<?php if(is_array($TPL_R2=$TPL_V1["review"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li class="mb10 text_overlay19">
							<a href="javascript:common.socialbar(<?php echo $TPL_V2["rno"]?>);" class="socialbar"><span class="common_title"><?php echo $TPL_V2["title"]?></span></a>
						</li>
<?php }}?>
						<!-- 나의리뷰로 연결 -->
						<li class="pt20" style="text-align:right;">
							<img src="/images/common/but/but_tx_more.gif" alt="더보기" title="더보기" class="btn" onClick="common.redirect('/blog/@<?php echo $TPL_VAR["nickname"]?>/<?php echo $TPL_V1["blogno"]?>')" />
						</li>
					</ul>
				</div>
				</td>
			</tr>
		</table>
	</div>
</div>
<!-- 블로그 정보 박스 끝 -->
<div class="clear" style="height:20px;"></div>
<?php }}?>