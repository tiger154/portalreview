<?php /* Template_ 2.2.4 2012/01/12 16:40:50 /www/revu39/engine/view/V3.9/manager/manager.user.info.review.htm 000001395 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<table width="100%" class="table-user">
	<tr>
		<th width="100">총 리뷰 수</th>
		<td><?php echo number_format($TPL_VAR["stats"]["review_cnt"])?></td>
	</tr>
	<tr>
		<th>베스트 리뷰</th>
		<td><?php echo $TPL_VAR["user"]["userno"]?></td>
	</tr>
	<tr>
		<th>리뷰 리스트<br />(최근10건)</th>
		<td valign="top">
			<table width="100%">
				<tr>
					<th>제목</th>
					<th>닉네임</th>
					<th>토크수</th>
					<th>등록일</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr align="center">
					<td align="left" width="300"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);"><?php echo $TPL_V1["title"]?></a></td>
					<td><?php echo $TPL_V1["nickname"]?></td>
					<td><?php echo $TPL_V1["talk_cnt"]?></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
				</tr>
<?php }}?>
			</table>
		</td>
	</tr>			
</table>
<div class="pageno"><?php echo $TPL_VAR["link"]?></div>