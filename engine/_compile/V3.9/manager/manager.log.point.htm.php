<?php /* Template_ 2.2.4 2011/11/04 11:23:40 /www/revu39/engine/view/V3.9/manager/manager.log.point.htm 000002321 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.log.js"></script>
<h2>포인트로그</h2>
<form name="form1" id="form1">
<input type="radio" name="flag" value="all" <?php if($TPL_VAR["param"][ 1]=='all'||$TPL_VAR["param"][ 1]==''){?>checked<?php }?> />전체
<select name="opt" id="opt">
	<option value="">==검색==</option>
	<option value="nickname" <?php if($TPL_VAR["param"][ 2]=='nickname'){?>selected<?php }?>>닉네임</option>
	<option value="userid" <?php if($TPL_VAR["param"][ 2]=='userid'){?>selected<?php }?>>아이디</option>
	<option value="userno" <?php if($TPL_VAR["param"][ 2]=='userno'){?>selected<?php }?>>회원번호</option>
</select>
<input type="text" name="keyword" id="keyword" value="<?php echo $TPL_VAR["param"][ 3]?>" />
<input type="button" value="검색" id="searchPointLogBtn" />
&nbsp;
<strong>| 총 <font color="red"><?php echo number_format($TPL_VAR["cnt"])?></font>건이 검색되었습니다.</strong>
<hr />
<table width="100%">
	<tr>
		<th>일련번호</th> 
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>포인트타입</th>
		<th>포인트</th>
		<th>적용전포인트</th>
		<th>적용후포인트</th>
		<th>등록일</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["idx"]?></td>
		<td><?php echo $TPL_V1["user"]["userid"]?></td>
		<td><a href="javascript:common.popup('popupUserInfo','/manager/user.info/<?php echo $TPL_V1["userno"]?>');"><?php echo $TPL_V1["user"]["nickname"]?></a></td>
		<td><?php echo $TPL_V1["user"]["username"]?></td>
		<td><?php echo $TPL_V1["point_type_text"]?></td>
		<td><?php echo number_format($TPL_V1["point"])?></td>
		<td><?php echo number_format($TPL_V1["point_before"])?></td>
		<td><?php echo number_format($TPL_V1["point_after"])?></td>
		<td><?php echo $TPL_V1["regdate"]?></td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>