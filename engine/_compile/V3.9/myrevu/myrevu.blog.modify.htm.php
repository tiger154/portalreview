<?php /* Template_ 2.2.4 2012/01/11 16:37:36 /www/revu39/engine/view/V3.9/myrevu/myrevu.blog.modify.htm 000002239 */ ?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.blog.js"></script>
<div class="title_line">
	<div class="myblog_title"><div class="myblog_info"></div></div>
</div>

<div class="myblog_title_bg" style="margin-top:20px;">
	<!-- 블로그 제목 -->
	<div class="myblog_title_text">
		블로그명 : <input type="text" id="blogName" maxlength="100" size="30" value="<?php echo $TPL_VAR["blog"]["name"]?>" />
		(<a href="<?php echo $TPL_VAR["blog"]["url"]?>" target="_blank" style="text-decoration:underline;"><?php echo $TPL_VAR["blog"]["url"]?></a>)
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_w_edit.gif" class="btn" align="absmiddle" onClick="myblog.modifyBlog(<?php echo $TPL_VAR["blog"]["blogno"]?>);" />
		<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_w_del.gif" class="btn" align="absmiddle" onClick="myblog.deleteBlog(<?php echo $TPL_VAR["blog"]["blogno"]?>);" />
	</div>
</div>
<!-- 블로그 정보 박스 시작 -->
<div class="myblog_box">
	<div class="myblog_tbox">
		<table width="100%" border="0" cellspacing="0">
			<tr>
				<td class="block_text100">등록일</td>
				<td class="block_text520" colspan="3"><span class="gray_l_text"><strong><?php echo $TPL_VAR["blog"]["regdate"]?></strong></span></td>
			</tr>
			<tr>
				<td class="block_text100">총 리뷰 수</td>
				<!-- 프론티어 리뷰로 연결 -->
				<td class="block_text195"><a href="javascript:common.redirect('/blog/@<?php echo $TPL_VAR["nickname"]?>/<?php echo $TPL_VAR["blog"]["blogno"]?>');" style="text-decoration:underline"><span class="gray_db_text"><?php echo $TPL_VAR["blog"]["review_cnt"]?></span></a> 건</td>
				<td class="block_text100">총 토크 수</td>
				<td class="block_text195"><span class="gray_db_text"><?php echo $TPL_VAR["blog"]["talk_cnt"]?></span>건</td>
			</tr>
		</table>
	</div>
</div>
<!-- 블로그 정보 박스 끝 -->
<div class="clear" style="height:20px;"></div>
<center>
	<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/but/but_gb_pre.gif" class="btn" onClick="common.redirect('/myrevu/blog');" />
</center>