<?php /* Template_ 2.2.4 2012/01/10 16:40:31 /www/revu39/engine/view/V3.9/manager/manager.user.info.cash.htm 000001314 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<table width="100%" class="table-user">
	<tr>
		<th width="100">캐시</th>
		<td><?php echo number_format($TPL_VAR["cash"]["cash"])?></td>
	</tr>
	<tr>
		<th>출금캐시</th>
		<td><?php echo number_format($TPL_VAR["cash"]["cash_use"])?></td>
	</tr>
	<tr>
		<th>캐시 적립내역</th>
		<td valign="top">			
			<table width="100%">
				<tr>
					<th>캐시타입</th>
					<th>적립/차감</th>
					<th>캐시</th>
					<th>등록일</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr align="center">
					<td><?php echo $TPL_V1["cash_type_text"]?></td>
					<td><?php echo $TPL_V1["flag_sign"]?></td>
					<td><?php echo number_format($TPL_V1["cash"])?></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
				</tr>
<?php }}?>
			</table>					
		</td>
	</tr>			
</table>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>