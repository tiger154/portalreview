<?php /* Template_ 2.2.4 2012/01/06 10:18:37 /www/revu39/engine/view/V3.9/manager/manager.user.htm 000003142 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<h2>전체회원</h2>
<form name="form1" id="form1">
<input type="radio" name="flag" value="all" <?php if($TPL_VAR["param"][ 1]=='all'||$TPL_VAR["param"][ 1]==''){?>checked<?php }?> />전체
<input type="radio" name="flag" value="powerblog" <?php if($TPL_VAR["param"][ 1]=='powerblog'){?>checked<?php }?> />파워블로그
<input type="radio" name="flag" value="black" <?php if($TPL_VAR["param"][ 1]=='black'){?>checked<?php }?> />블랙리스트
<input type="radio" name="flag" value="email" <?php if($TPL_VAR["param"][ 1]=='email'){?>checked<?php }?> />이메일수신
<select name="opt" id="opt">
	<option value="">==검색==</option>
	<option value="nickname" <?php if($TPL_VAR["param"][ 2]=='nickname'){?>selected<?php }?>>닉네임</option>
	<option value="userid" <?php if($TPL_VAR["param"][ 2]=='userid'){?>selected<?php }?>>아이디</option>
	<option value="username" <?php if($TPL_VAR["param"][ 2]=='username'){?>selected<?php }?>>이름</option>
	<option value="email" <?php if($TPL_VAR["param"][ 2]=='email'){?>selected<?php }?>>이메일</option>
</select>
<input type="text" name="keyword" id="keyword" value="<?php echo $TPL_VAR["param"][ 3]?>" />
<input type="button" value="검색" id="searchBtn" />
&nbsp;
<strong>| 총 <font color="red"><?php echo number_format($TPL_VAR["cnt"])?></font>명의 회원이 검색되었습니다.</strong>
<hr />
<table width="100%">
	<tr align="center">
		<th>가입일</th> 
		<th>회원번호</th> 
		<th>타입</th>
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>이메일</th>
		<th>포인트</th>
		<th>캐시</th>
		<th>파워블로그</th>
		<th>이메일수신</th>
		<th>블랙리스트</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["regdate"]?></td>
		<td><?php echo $TPL_V1["userno"]?></td>
		<td><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_<?php echo $TPL_V1["type"]?>.gif" /></td>
		<td><?php echo $TPL_V1["userid"]?></td>
		<td><?php if($TPL_V1["flag_powerblog"]=="1"){?><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" /> <?php }?><a href="javascript:manager.user(<?php echo $TPL_V1["userno"]?>);"><?php echo $TPL_V1["nickname"]?></a></td>
		<td><?php echo $TPL_V1["username"]?></td>
		<td><?php echo $TPL_V1["email"]?></td>
		<td><?php echo number_format($TPL_V1["point"]["point"])?></td>
		<td><?php echo number_format($TPL_V1["cash"]["cash"])?></td>
		<td><?php echo $TPL_V1["flag_powerblog_text"]?></td>
		<td><?php echo $TPL_V1["flag_email_text"]?></td>
		<td><?php echo $TPL_V1["flag_black_text"]?></td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>