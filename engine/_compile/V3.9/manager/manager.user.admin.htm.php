<?php /* Template_ 2.2.4 2012/01/31 12:42:57 /www/revu39/engine/view/V3.9/manager/manager.user.admin.htm 000001510 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<h2>관리자 계정정보</h2>
<form name="form1" id="form1">
회원번호 : <input type="text" name="userno" id="userno" size="10" maxlength="12" />
등급 : (10<input type="text" name="grade" id="grade" size="1" maxlength="1" />)
설명 : <input type="text" name="admin_desc" id="admin_desc" size="15" maxlength="50" />
<input type="button" value="등록" onClick="mnguser.registAdmin();" />
<hr />
<table width="100%">
	<tr align="center">		 
		<th>회원번호</th>
		<th>등급</th> 
		<th>설명</th>
		<th>아이디</th>
		<th>이름</th>
		<th>닉네임</th>
		<th>삭제</th>
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">		
		<td><?php echo $TPL_V1["userno"]?></td>
		<td><?php echo $TPL_V1["grade"]?></td>
		<td><?php echo $TPL_V1["admin_desc"]?></td>
		<td><?php echo $TPL_V1["user"]["userid"]?></td>
		<td><?php echo $TPL_V1["user"]["username"]?></td>
		<td><?php echo $TPL_V1["user"]["nickname"]?></td>
		<td><input type="button" value="삭제" onClick="mnguser.confirmDeleteAdmin(<?php echo $TPL_V1["userno"]?>);" /></td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>