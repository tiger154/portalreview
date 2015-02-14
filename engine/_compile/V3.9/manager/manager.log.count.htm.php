<?php /* Template_ 2.2.4 2011/11/04 14:12:32 /www/revu39/engine/view/V3.9/manager/manager.log.count.htm 000003079 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<style type="text/css">@import "<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.css";</style>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick-ko.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.log.js"></script>
<h2>통계로그</h2>
<form name="form1" id="form1">
<hr />
<h3>전체통계</h3>
<table width="100%">	
	<tr>
		<th>회원수</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["user_tcnt"]-$TPL_VAR["stats"]["secede_tcnt"])?> 명</td>
		<th>가입수</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["user_tcnt"])?> 명</td>
		<th>탈퇴수</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["secede_tcnt"])?> 명</td>
		<th>캐시</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash"])?> 캐시</td>
		<th>적립캐시</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash_save"])?> 캐시</td>
		<th>사용캐시</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash_use"])?> 캐시</td>
	</tr>
</table>
<h3>검색통계</h3>
<input type="text" name="sdate" id="sdate" size="10" maxlength="10" value="<?php echo $TPL_VAR["sdate"]?>" /> 
~
<input type="text" name="edate" id="edate" size="10" maxlength="10" value="<?php echo $TPL_VAR["edate"]?>" />
<input type="button" value="검색" id="searchCountLogBtn" />
<table width="100%">	
	<tr>
		<th>가입수</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats2"]["user_tcnt"])?> 명</td>
		<th>탈퇴수</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats2"]["secede_tcnt"])?> 명</td>
		<th>적립캐시</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats2"]["cash_save"])?> 캐시</td>
		<th>사용캐시</th>
		<td align="right"><?php echo number_format($TPL_VAR["stats2"]["cash_use"])?> 캐시</td>
	</tr>
</table>
<hr />
<table width="100%">
	<tr>
		<th>통계일</th> 
		<th>회원가입수</th>
		<th>회원탈퇴수</th>
		<th>캐시적립</th>
		<th>캐시사용</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["date"]?></td>
		<td><?php echo number_format($TPL_V1["user_cnt"])?> 명</td>
		<td><?php echo number_format($TPL_V1["secede_cnt"])?> 명</td>
		<td><?php echo number_format($TPL_V1["cash_save"])?> 캐시</td>
		<td><?php echo number_format($TPL_V1["cash_use"])?> 캐시</td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>