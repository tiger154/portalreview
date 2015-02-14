<?php /* Template_ 2.2.4 2012/01/13 15:18:06 /www/revu39/engine/view/V3.9/myrevu/myrevu.cash.htm 000002868 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.cash.js"></script>
<div class="title_line gray_l_text"><img src="/images/myrevu/title_cash.gif" align="left"/></div>
<div class="mycash_bg">
	<ul>
		<li style="height:45px;"></li>
		<li class="mycash_bg_text red_title"><?php echo number_format($TPL_VAR["cash"]["cash_save"])?></li>
		<li class="mycash_bg_text gray_l_title"><?php echo number_format($TPL_VAR["cash"]["cash_use"])?></li>
		<li class="mycash_bg_text black_title"><?php echo number_format($TPL_VAR["cash"]["cash"])?></li>
	</ul>
</div>
<div class="mycash_bg_but">
<?php if($TPL_VAR["cash"]["cash"]>= 30000){?>
	<img src="/images/common/but/but_cashoffer.gif" id="withdrawBtn" alt="출금신청" title="출금신청" class="btn" />
<?php }else{?>
	<img src="/images/common/but/but_cashoffer.gif" id="withdrawBtn2" alt="출금신청" title="출금신청" class="btn" />
<?php }?>
</div>
<div class="clear" style="height:60px;"></div>
<!-- 적립내역 시작 -->
<div class="title32_line">
	<img src="/images/myrevu/title_cashlist.gif"  align="left"/>
</div>
<div style="width:714px; height:auto;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="table_listbg" width="120"><strong>날짜</strong></td>
			<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
			<td class="table_listbg" width="480"><span class="gray_d_text"><strong>내용</strong></span></td>
			<td class="table_listbg" width="3"><img src="/images/common/bg/bg_table_sline.gif" /></td>
			<td class="table_listbg" width="120"><span class="gray_d_text"><strong>캐쉬</strong></span></td>
		</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
		<tr>
			<td colspan="2" class="table12_line" align="center">
				<div class="common_text text_overlay17"><?php echo $TPL_V1["regdate"]?></div>
			</td>
			<td colspan="2" class="table12_line" ><a href="#">
				<div class="common_text text_overlay17"><?php echo $TPL_V1["cash_explain"]?> <a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);" class="socialbar"><?php echo $TPL_V1["title"]?></a></div>
			</td>
			<td class="table12_line" align="center">
				<span class="<?php echo $TPL_V1["span_class"]?>"><?php echo $TPL_V1["sign"]?> <?php echo number_format($TPL_V1["cash"])?></span>
			</td>
		</tr>
<?php }}?>
<?php if($TPL_VAR["cnt"]< 1){?>
		<tr>
			<td colspan="5" class="table12_line" align="center">
				<div class="common_text text_overlay17">캐시정보가 없습니다.</div>
			</td>
		</tr>
<?php }?>
	</table>
</div>
<div class="clear"></div>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>