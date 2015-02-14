<?php /* Template_ 2.2.4 2011/10/27 18:22:05 /www/revu39/engine/view/V3.9/myrevu/myrevu.review.register.htm 000005099 */ 
$TPL_bloglist_1=empty($TPL_VAR["bloglist"])||!is_array($TPL_VAR["bloglist"])?0:count($TPL_VAR["bloglist"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/zipcode.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/review.manager.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.review.register.js"></script>

<?php if($TPL_VAR["type"]=="blog"){?>
<div class="title_line">
	<div class="my_post_title"></div>
	<!-- 포스트 등록 시작 -->
	<div class="my_post_tab">
		<ul>
			<li>
				<img src="/images/myrevu/tab_mypost_on1.gif" id="tabBtn1" width="131" height="29" class="btn" />
			</li>
			<li>
				<img src="/images/myrevu/tab_mypost_off2.gif" id="tabBtn2" width="131" height="29" class="btn" />
			</li>
		</ul>
	</div>
	<!-- 포스트등록 탭 끝 -->
</div>
<div class="clear" style="width:714px; height:20px;"></div>

<div style="width:680px; height:22px; padding-left:34px; margin-bottom:40px; text-align:right;">
	<ul>
		<li style="width:430px; height:22px; padding:0 15px 0 150px; text-align:right;" class="fl">
			<div class="fl pt05"><span class="gray11_l_text">* 내 블로그의 글을 선택하여 등록할 수 있습니다.</span></div>
			<div class="pl15 fl">
				<select name="blogList" id="blogList">
					<option value=''>블로그를 선택하세요.</option>
<?php if($TPL_bloglist_1){foreach($TPL_VAR["bloglist"] as $TPL_V1){?>
					<option value='<?php echo $TPL_V1["url"]?>'><?php echo $TPL_V1["name"]?></option>
<?php }}?>
				</select>
			</div>
		</li>
		<li style="width:79px; height:19px;" class="fl">
			<img src="/images/common/but/but_g_call.gif" id="blogLoadBtn" alt="불러오기" title="불러오기" class="btn" />		
		</li>
	</ul>
</div>
<div class="clear"></div>

<table id="articleList" width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class="table_listbg" width="120"><span class="gray_d_text"><strong>작성일</strong></span></td>
		<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
		<td class="table_listbg" width="110"><span class="gray_d_text"><strong>이미지</strong></span></td>
		<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
		<td class="table_listbg" width="370"><span class="gray_d_text"><strong>제 목</strong></span></td>
		<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
		<td class="table_listbg" width="120"><span class="gray_d_text"><strong>레뷰에 등록</strong></span></td>
	</tr>
	<tr>
		<td colspan="7" height="50" align="center">등록된 게시물이 없습니다.</td>
	</tr>
</table>
<br /><br />
<?php }?>

<?php if($TPL_VAR["type"]=="url"){?>
<div class="title_line">
	<div class="my_post_title"></div>
	<!-- 포스트 등록 시작 -->
	<div class="my_post_tab">
		<ul>
			<li>
				<img src="/images/myrevu/tab_mypost_off1.gif" id="tabBtn1" width="131" height="29" class="btn" />
			</li>
			<li>
				<img src="/images/myrevu/tab_mypost_on2.gif" id="tabBtn2" width="131" height="29" class="btn" />
			</li>
		</ul>
	</div>
	<!-- 포스트등록 탭 끝 -->
</div>
<div class="clear" style="width:714px; height:20px;"></div>

<div style="width:714px; height:22px; margin:40px 0; text-align:right;">
	<ul>
		<li style="width:79px; height:19px;" class="fr">
			<img src="/images/common/but/but_gb_in.gif" id="feedRegBtn" alt="등록하기" title="등록하기" class="btn" />
		</li>
		<li style="width:580px; height:22px; padding-right:15px; text-align:right;" class="fr">
			<span class="gray_d_text" style="font-weight:bold">URL 입력</span>
			&nbsp;&nbsp;
			<input type="text" name="feedFormURL" id="feedFormURL" value="http://" size="40" style="width:480px;" class="input_common" />
		</li>
		<li class="clear" style="height:12px;"></li>
		<li style="width:680px; height:19px; padding-left:130px; text-align:left;">
			<span class="common11_text">* RSS 피드로 불러오지 못하는 이전 글들을 등록하실 수 있습니다.</span>
		</li>
		<li style="width:680px; height:19px; padding-left:130px; text-align:left;">
			<span class="common11_text">* http:// 로 시작하는 글을 고유주소(퍼머링크)를 입력해주세요.</span>
		</li>
		<li style="width:680px; height:19px; padding-left:130px; text-align:left;">
			<span class="common11_text">* 레뷰에 등록된 본인 블로그의 글만 등록하실 수 있습니다.</span>
		</li>
	</ul>						
</div>
<div style="width:714px; height:20px;margin-bottom:80px;" class="clear" ></div>
<?php }?>

<?php if($TPL_VAR["type"]=="revu"){?>
<?php }?>

<div id="reviewlayer" style="display:none;background-color: #FFF;padding:20px;"><?php $this->print_("reviewlayer",$TPL_SCP,1);?></div>