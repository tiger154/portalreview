<?php /* Template_ 2.2.4 2012/01/16 10:08:04 /www/revu39/engine/view/V3.9/manager/manager.review.htm 000002432 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/category.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.review.js"></script>
<script>var code = "<?php echo(Module::$param[1])?>";</script>
<h2>전체리뷰</h2>
<form name="form1" id="form1">
<select name="cate1" id="cate1"><option value="">1차분류선택</option></select>
<select name="cate2" id="cate2"><option value="">2차분류선택</option></select>
<select name="cate3" id="cate3"><option value="">3차분류선택</option></select>
<select name="cate4" id="cate4"><option value="">4차분류선택</option></select>
<input type="button" value="검색" id="searchReviewBtn" />* 검색DB가 구축되지 않아 카테고리와 제목/닉네임이 동시에 검색되지 않습니다.
<br />
<h3>검색된 리뷰는 총 <?php echo number_format($TPL_VAR["cnt"])?> 건입니다.</h3>
<hr />
<table width="100%">
	<tr align="center">
		<th>리뷰번호</th>
		<th>등록일</th>
		<th>카테고리</th>
		<th>이미지</th> 
		<th>제목</th>
		<th>닉네임</th>
		<th>캐시</th>
		<th>상태</th>		
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["rno"]?></td>
		<td><?php echo $TPL_V1["regdate"]?></td>
		<td><?php echo $TPL_V1["cate_desc"]?></td>
		<td><img src="<?php echo $TPL_V1["thumbimage_url"]?>" alt="<?php echo $TPL_V1["title"]?>" width="50" height="50" /></td>
		<td align="left" width="350">
			<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>,'t');"><?php echo $TPL_V1["title"]?></a>
			<br />
			<img src="<?php echo $TPL_V1["blog_icon"]?>" class="imgb_space" />
		</td>
		<td><a href="javascript:manager.user(<?php echo $TPL_V1["userno"]?>);"><?php echo $TPL_V1["nickname"]?></a></td>
		<td><?php echo number_format($TPL_V1["cash"]["cash"])?></td>
		<td><a href="javascript:mngreview.confirmStatus(<?php echo $TPL_V1["rno"]?>);"><?php echo $TPL_V1["status_text"]?></a></td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>