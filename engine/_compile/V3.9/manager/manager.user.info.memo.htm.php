<?php /* Template_ 2.2.4 2012/01/10 16:40:26 /www/revu39/engine/view/V3.9/manager/manager.user.info.memo.htm 000001006 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<table width="100%" class="table-user">
	<tr>
		<th>일련번호</th>
		<th>메모</th>
		<th>등록자</th>
		<th>등록일</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td width="60"><?php echo $TPL_V1["mno"]?></td>
		<td align="left"><?php echo nl2br($TPL_V1["memo"])?></td>
		<td width="100"><?php echo $TPL_V1["user"]["username"]?>(<?php echo $TPL_V1["user"]["nickname"]?>)</td>
		<td width="120"><?php echo $TPL_V1["regdate"]?></td>
	</tr>
<?php }}?>
</table>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>