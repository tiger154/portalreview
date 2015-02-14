<?php /* Template_ 2.2.4 2011/12/29 10:16:32 /www/revu39/engine/view/V3.9/manager/manager.cash.withdraw.htm 000003494 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<style type="text/css">@import "<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.css";</style>
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["EXTENDS"]?>/js.jquery.datepick/jquery.datepick-ko.js"></script> 
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.cash.js"></script>
<h2>캐시신청자</h2>
<form name="form1" id="form1">
<hr />
<h3>
총캐쉬신청액은 <font color="red"><?php echo number_format($TPL_VAR["stats"]["cash"])?></font> 원이며, 
이달의 신청액은<font color="blue"><?php echo number_format($TPL_VAR["cashsum"])?></font>원, 
신청자는<?php echo number_format($TPL_VAR["cnt"])?>명입니다.
</h3>
<input type="text" name="sdate" id="sdate" size="10" maxlength="10" value="<?php echo $TPL_VAR["sdate"]?>" /> 
~
<input type="text" name="edate" id="edate" size="10" maxlength="10" value="<?php echo $TPL_VAR["edate"]?>" />
<input type="button" value="검색" id="searchWithdrawBtn" />
<input type="button" value="다운로드" id="downWidthdrawBtn" />
<hr />
<table width="100%">
	<tr>
		<th>신청일시</th> 
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>액수</th>		
		<th>은행</th>
		<th>계좌번호</th>
		<th>휴대폰번호</th>
		<th>주민번호</th>
		<th>주소</th>
		<th>첨부보기</th>
		<th>처리여부</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["regdate"]?></td>
		<td><?php echo $TPL_V1["user"]["userid"]?></td>
		<td><a href="javascript:manager.user(<?php echo $TPL_V1["userno"]?>);"><?php echo $TPL_V1["user"]["nickname"]?></a></td>
		<td><?php echo $TPL_V1["user"]["username"]?></td>
		<td><?php echo number_format($TPL_V1["cash"])?> 캐시</td>
		<td><?php echo $TPL_V1["bank"]["code_desc"]?></td>
		<td><?php echo $TPL_V1["account_number"]?></td>
		<td><?php echo $TPL_V1["extra"]["cell"]?></td>
		<td><?php echo $TPL_V1["socialno"]?></td>
		<td>[<?php echo $TPL_V1["extra"]["zipcode"]?>]<?php echo $TPL_V1["extra"]["addr1"]?> <?php echo $TPL_V1["extra"]["addr2"]?></td>
		<td>
<?php if($TPL_V1["attach_type1"]=="1"){?>
			<a href="javascript:common.popup('popupAttachType1','/manager/cash.withdraw.file/I/<?php echo $TPL_V1["wno"]?>');"><?php echo $TPL_V1["attach_type_text1"]?></a>
<?php }else{?>
			<?php echo $TPL_V1["attach_type_text1"]?>

<?php }?> 
			| 
<?php if($TPL_V1["attach_type2"]=="1"){?>
			<a href="javascript:common.popup('popupAttachType2','/manager/cash.withdraw.file/A/<?php echo $TPL_V1["wno"]?>');"><?php echo $TPL_V1["attach_type_text2"]?></a>
<?php }else{?>
			<?php echo $TPL_V1["attach_type_text2"]?>

<?php }?> 
		</td>		
		<td>
<?php if($TPL_V1["flag_pay"]=="0"){?>
			<a href="javascript:mngcash.confirmWithdraw(<?php echo $TPL_V1["wno"]?>);"><?php echo $TPL_V1["flag_pay_text"]?></a>
<?php }else{?>
			<?php echo $TPL_V1["flag_pay_text"]?>

<?php }?>
		</td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>