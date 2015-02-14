<?php /* Template_ 2.2.4 2012/01/16 10:08:37 /www/revu39/engine/view/V3.9/manager/manager.review2.htm 000002175 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.review.js"></script>
<h2>리뷰검색</h2>
<form name="form1" id="form1">
<select name="opt" id="opt">
	<option value="">==검색==</option>
	<option value="title" <?php if($TPL_VAR["param"][ 1]=='title'){?>selected<?php }?>>제목</option>
	<option value="nickname" <?php if($TPL_VAR["param"][ 1]=='nickname'){?>selected<?php }?>>닉네임</option>
</select>
<input type="text" name="keyword" id="keyword" value="<?php echo $TPL_VAR["param"][ 2]?>" />
<input type="button" value="검색" id="searchReviewBtn2" />
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
			<a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>,'t');" name="<?php echo $TPL_V1["rno"]?>" class="socialbar"><?php echo $TPL_V1["title"]?></a>
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