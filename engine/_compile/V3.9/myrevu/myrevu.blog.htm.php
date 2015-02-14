<?php /* Template_ 2.2.4 2012/01/13 15:16:45 /www/revu39/engine/view/V3.9/myrevu/myrevu.blog.htm 000002959 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<div class="title_line">
	<div class="myblog_title"><div class="myblog_info">| 총 <?php echo $TPL_VAR["cnt"]?>개의 블로그가 등록되었습니다.</div></div>
</div>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
<div class="myblog_title_bg" style="margin-top:20px;">
	<!-- 블로그 제목 -->
	<div class="myblog_title_text">
		<span class="black_title w20_space"><?php echo $TPL_V1["name"]?></span>
		(<a href="<?php echo $TPL_V1["url"]?>" target="_blank" style="text-decoration:underline;"><?php echo $TPL_V1["url"]?></a>)
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_w_ok.gif" class="btn" align="absmiddle" onClick="common.redirect('/myrevu/blog.modify/<?php echo $TPL_V1["blogno"]?>');" />
	</div>
</div>
<!-- 블로그 정보 박스 시작 -->
<div class="myblog_box">
	<div class="myblog_tbox">
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td class="block_text100">등록일</td>
				<td class="block_text195"><span class="gray_l_text"><strong><?php echo $TPL_V1["regdate"]?></strong></span></td>
				<td class="block_text100">적립캐쉬</td>
				<!-- 캐쉬 내역로 연결 -->
				<td class="block_text195">총 <a href="javascript:common.redirect('/myrevu/cash');" style="text-decoration:underline"><?php echo $TPL_V1["cash"]?></a> 원</td>
			</tr>
			<tr>
				<td class="block_text100">총 리뷰 수</td>
				<!-- 프론티어 리뷰로 연결 -->
				<td class="block_text195"><a href="javascript:context.home('<?php echo $_SESSION["nickname"]?>');" style="text-decoration:underline"><span class="gray_db_text"><?php echo $TPL_V1["review_cnt"]?></span></a> 건</td>
				<td class="block_text100">총 토크 수</td>
				<td class="block_text195"><span class="gray_db_text"><?php echo $TPL_V1["talk_cnt"]?></span> 건</td>
			</tr>
			<tr>
				<td class="block_text100">최근 <br />등록 리뷰</td>
				<td class="block_text520" colspan="3">
				<div style="width:520px; height:auto; padding-top:10px;">
					<ul>
<?php if(is_array($TPL_R2=$TPL_V1["review"])&&!empty($TPL_R2)){foreach($TPL_R2 as $TPL_V2){?>
						<li class="pb09 text_overlay17">
							<a href="javascript:common.socialbar(<?php echo $TPL_V2["rno"]?>);" class="socialbar"><span class="black_text"><?php echo $TPL_V2["title"]?></span></a>
						</li>
<?php }}?>
						<!-- 나의리뷰로 연결 -->
						<li class="pt20" style="text-align:right;">
							<img src="/images/common/ico/ico_more.gif" alt="more" title="more" class="btn" onClick="common.redirect('/blog/@<?php echo $_SESSION["nickname"]?>/<?php echo $TPL_V1["blogno"]?>')" />
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