<?php /* Template_ 2.2.4 2012/01/13 15:16:40 /www/revu39/engine/view/V3.9/myrevu/myrevu.talk.htm 000002650 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.talk.js"></script>
<div class="title_line">
	<div class="socialtalk_title"></div>
	<!-- 댓글 탭 시작 -->
	<div class="socialtalk_tab">
		<ul>
			<li><img src="/images/myrevu/tab_socialtalk_<?php if($TPL_VAR["type"]=='0'){?>on<?php }else{?>off<?php }?>1.gif" onClick="common.redirect('/myrevu/talk/0');" width="116" height="29" alt="내가쓴토크" title="내가쓴토크" class="btn" /></li>
			<li><img src="/images/myrevu/tab_socialtalk_<?php if($TPL_VAR["type"]=='1'){?>on<?php }else{?>off<?php }?>2.gif" onClick="common.redirect('/myrevu/talk/1');" width="116" height="29" alt="내리뷰에달린토크" title="내리뷰에달린토크" class="btn" /></li>
		</ul>
	</div>
	<!-- 리뷰관리 탭 끝 -->
</div>
<!-- 상단 상태 라인 -->
<div class="review_manage_state">
	<div class="review_manage_stater"><span class="gray_db_text">총 <?php echo number_format($TPL_VAR["cnt"])?> 건</span></div>
</div>

<?php if($TPL_list_1){$TPL_I1=-1;foreach($TPL_VAR["list"] as $TPL_V1){$TPL_I1++;?>
<div class="socialtalk_list">
	<div class="thum80_box"><img src="<?php echo $TPL_V1["userimage"]?>" width="80" height="80" /></div>
	<div class="socialtalk_text_box">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="<?php if($TPL_I1% 2== 0){?>pop_reply_gline<?php }else{?>pop_reply_line<?php }?>">
			<tr>
				<td width="30" align="center" valign="top"><img src="<?php echo $TPL_V1["icon"]?>"/></td>
				<td width="569">
					<div class="gray11_l_text text_overlay17">
						<?php echo $TPL_V1["ref"]?> ㅣ <?php echo $TPL_V1["regdate"]?>

						<img src="/images/common/ico/ico_del.gif" align="absmiddle" alt="삭제" title="삭제" class="btn" onClick="mytalk.deleteTalk(<?php echo $TPL_V1["tno"]?>)" />
					</div>
					<div class="common11_text"><b><?php echo $TPL_V1["talk"]?></b></div>
					<div class="sns_post_line"> <a href="javascript:common.socialbar(<?php echo $TPL_V1["review"]["rno"]?>);"><span  class="gray_l_text"><u><?php echo $TPL_V1["title"]?></u></span></a></div>
					
					<!--<div class="sns_kind gray11_l_text">| 리뷰에 달린 토크</div>-->
				</td>
			</tr>
		</table>
	</div>
</div>
<?php }}?>

<?php if($TPL_VAR["size"]> 0){?> 
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
<?php }else{?>
<div class="nolist">등록된 토크가 없습니다.</div>
<?php }?>