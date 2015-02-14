<?php /* Template_ 2.2.4 2012/01/10 16:40:05 /www/revu39/engine/view/V3.9/manager/manager.user.info.point.htm 000001191 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<table width="100%" class="table-user">
	<tr>
		<th width="100">포인트</th>
		<td><?php echo number_format($TPL_VAR["point"]["point"])?></td>
	</tr>
	<tr>
		<th>사용포인트</th>
		<td>-</td>
	</tr>
	<tr>
		<th>포인트 적립내역</th>
		<td valign="top">
			<table width="100%">
				<tr>
					<th>포인트타입</th>
					<th>포인트</th>
					<th>등록일</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr align="center">
					<td><?php echo $TPL_V1["point_type_text"]?></td>
					<td><?php echo number_format($TPL_V1["point"])?></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
				</tr>
<?php }}?>
			</table>
		</td>
	</tr>	
</table>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>