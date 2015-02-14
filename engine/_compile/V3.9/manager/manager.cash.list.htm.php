<?php /* Template_ 2.2.4 2012/01/03 15:31:31 /www/revu39/engine/view/V3.9/manager/manager.cash.list.htm 000002552 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<style type="text/css">@import "<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.css";</style>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick-ko.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.cash.js"></script>
<h2>캐시합계내역</h2>
<hr />
<h3><font color="red">부하가 많이 걸리는 페이지입니다. 대도록이면 유저접속이 많은 시간을 피해주세요.</font></h3>
<form name="form1" id="form1">
<hr />
<h3>
<?php echo $TPL_VAR["sdate_text"]?> ~ <?php echo $TPL_VAR["edate_text"]?> - 총 적립캐시 : <font color="red"><?php echo number_format($TPL_VAR["cashsum0"])?></font> 원 /  
총 지급캐시 :  <font color="blue"><?php echo number_format($TPL_VAR["cashsum1"])?></font>원 
</h3>
<input type="text" name="sdate" id="sdate" size="10" maxlength="10" value="<?php echo $TPL_VAR["sdate"]?>" /> 
~
<input type="text" name="edate" id="edate" size="10" maxlength="10" value="<?php echo $TPL_VAR["edate"]?>" />
<input type="button" value="검색" id="searchCashSumBtn" />
<hr />
<table width="100%">
	<tr>
		<th>회원번호</th> 
		<th>닉네임</th>
		<th>설명</th>
		<th>적립/지급</th>
		<th>캐시</th>	
		<th>프론티어<br />일련번호</th>
		<th>리뷰일련번호</th>
		<th>리뷰제목</th>
		<th>적립/지급일</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["userno"]?></td>		
		<td><a href="javascript:manager.user(<?php echo $TPL_V1["userno"]?>);"><?php echo $TPL_V1["user"]["nickname"]?></a></td>
		<td><?php echo $TPL_V1["state_explain"]?></td>
		<td><?php echo $TPL_V1["flag_sign"]?></td>
		<td><?php echo number_format($TPL_V1["cash"])?> 캐시</td>		
		<td><?php echo $TPL_V1["frno"]?></td>
		<td><?php echo $TPL_V1["rno"]?></td>
		<td align="left" width="280"><?php echo $TPL_V1["title"]?></td>
		<td><?php echo $TPL_V1["regdate"]?></td>		
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>