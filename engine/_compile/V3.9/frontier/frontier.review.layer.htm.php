<?php /* Template_ 2.2.4 2011/12/30 13:19:34 /www/revu39/engine/view/V3.9/frontier/frontier.review.layer.htm 000002997 */ 
$TPL_bloglist_1=empty($TPL_VAR["bloglist"])||!is_array($TPL_VAR["bloglist"])?0:count($TPL_VAR["bloglist"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/review.manager.js"></script>

<input type="hidden" name="frno" id="frno" value='<?php echo $TPL_VAR["frno"]?>'>
<input type="hidden" name="blogcnt" id="blogcnt" value="<?php echo $_SESSION["blog_cnt"]?>" />

<!-- 리뷰등록팝업 /사이즈500가변 -->
<div class="pop_frontier_box">
	<div class="pop_frontier_tbox">
		<ul>
			<li class="pop_frontier_title3">
				<div class="pop_frontier_titlebox3 gray_d_text"><span id="subject"><?php echo $TPL_VAR["subject2"]?></span></div>
				<div  class="fr" style="width:19px; height:26px; padding-bottom:9px;"><img src="/images/common/but/but_xclose.gif" align="right" alt="닫기" title="닫기" class="btn" onclick="common.closeLayer('entrylayer2')"></div>
			</li>
			<li class="img_frontier_review"></li>
			<li class="pb25"></li>
			<li class="pop_review_box">
<?php if($TPL_VAR["type"]=="blog"){?>
				<div class="fl gray_d_text"><strong class="w_space">블로그선택</strong></div>
				<div class="fl">
						<!-- 유저블로그리스트 -->
						<div class="fl">
							<select  name="blogList" id="blogList" style="margin-right:10px; width:200px">
								<option value="" selected="selected">블로그를 선택해주세요.</option>
								<option value=""><?php if($TPL_bloglist_1){foreach($TPL_VAR["bloglist"] as $TPL_V1){?></option>
								<option value='<?php echo $TPL_V1["url"]?>'><?php echo $TPL_V1["name"]?></option>
<?php }}?>
							</select>
						</div>
				</div>
				<div class="fl">&nbsp;<img src="/images/common/but/but_g_call.gif" alt="불러오기" title="불러오기" id="blogLoadBtn" class="btn"></a></div>
				<div class="fl"><a href="/myrevu/blog"><img src="/images/common/but/but_w_ok.gif" alt="관리" title="관리"class="img_space btn" /></a></div>
				<div class="pb25"></div>
			</li>
			<li>					
<?php }?>
				<!-- 
				<li class="pop_review_line">
						<div class="pop_review_text gray_d_text"><a href="#" target="_blank">[2010.09]Kota Kinabalu :Nexus resort</a></div>
						<div class="pop_review_but"><a href="#"><img src="/images/common/but/but_g_in.gif" alt="등록" title="등록" /></a></div>
				</li> 
				-->
				<div style="overflow-y:auto; overflow-x:hidden; width:100%; height:450px; ">
					<table id="articleList" width="430" height="400" border="0" cellspacing="0" cellpadding="0">
						<tr><td colspan="7"></td></tr>
						<tr>
							<td colspan="7" height="400" align="center">등록된 게시물이 없습니다.</td>
						</tr>
					</table>
				</div>


			</li>
		</ul>
	</div>
</div>