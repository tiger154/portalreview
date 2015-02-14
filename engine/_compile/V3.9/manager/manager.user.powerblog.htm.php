<?php /* Template_ 2.2.4 2012/07/27 10:31:58 /www/revu39/engine/view/V3.9/manager/manager.user.powerblog.htm 000004230 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.powerblog.js"></script>
<h2>파워블로그 신청자</h2>
<form name="form1" id="form1">
<select name="cate" id="cate">
	<option value="">==분야==</option>
	<option value="1" <?php if($TPL_VAR["param"][ 2]=='1'){?>selected<?php }?>>디지털/가전/휴대폰</option>
	<option value="2" <?php if($TPL_VAR["param"][ 2]=='2'){?>selected<?php }?>>맛집/요리</option>
	<option value="3" <?php if($TPL_VAR["param"][ 2]=='3'){?>selected<?php }?>>여행</option>
	<option value="4" <?php if($TPL_VAR["param"][ 2]=='4'){?>selected<?php }?>>영화/TV/연극/공연</option>
	<option value="5" <?php if($TPL_VAR["param"][ 2]=='5'){?>selected<?php }?>>스포츠</option>
	<option value="6" <?php if($TPL_VAR["param"][ 2]=='6'){?>selected<?php }?>>자동차/바이크/자전거</option>
	<option value="7" <?php if($TPL_VAR["param"][ 2]=='7'){?>selected<?php }?>>패션/인테리어</option>
	<option value="8" <?php if($TPL_VAR["param"][ 2]=='8'){?>selected<?php }?>>도서</option>
	<option value="9" <?php if($TPL_VAR["param"][ 2]=='9'){?>selected<?php }?>>음악</option>
	<option value="10" <?php if($TPL_VAR["param"][ 2]=='10'){?>selected<?php }?>>시사</option>
	<option value="11" <?php if($TPL_VAR["param"][ 2]=='11'){?>selected<?php }?>>육아/와이프로거</option>
	<option value="12" <?php if($TPL_VAR["param"][ 2]=='12'){?>selected<?php }?>>레포츠/레저</option>
	<option value="13" <?php if($TPL_VAR["param"][ 2]=='13'){?>selected<?php }?>>화장품/미용</option>
	<option value="14" <?php if($TPL_VAR["param"][ 2]=='14'){?>selected<?php }?>>애완동물</option>
	<option value="15" <?php if($TPL_VAR["param"][ 2]=='15'){?>selected<?php }?>>취미/게임</option>
</select>
<input type="radio" name="flag" value="all" <?php if($TPL_VAR["param"][ 1]=='all'||$TPL_VAR["param"][ 1]==''){?>checked<?php }?> />전체
<input type="radio" name="flag" value="0" <?php if($TPL_VAR["param"][ 1]=='0'){?>checked<?php }?> />심사중
<input type="radio" name="flag" value="1" <?php if($TPL_VAR["param"][ 1]=='1'){?>checked<?php }?> />파워블로그선정
<input type="radio" name="flag" value="2" <?php if($TPL_VAR["param"][ 1]=='2'){?>checked<?php }?> />거절
<input type="button" value="검색" id="searchBtn" />
&nbsp;
<strong>| 총 <font color="red"><?php echo number_format($TPL_VAR["cnt"])?></font>명의 회원이 검색되었습니다.</strong>
<hr />
<table width="100%">
	<tr>
		<th>회원번호</th>
		<th>아이디</th>
		<th>닉네임</th>
		<th>이름</th>
		<th>심사상태</th>
		<th>처리</th>
		<th>분야1</th>
		<th>분야2</th>
		<th>분야3</th>
		<th>분야4</th>
		<th>분야5</th>
		<th>가입일</th> 
	</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
	<tr align="center">
		<td><?php echo $TPL_V1["user"]["userno"]?></td>
		<td><?php echo $TPL_V1["user"]["userid"]?></td>
		<td><a href="javascript:manager.user(<?php echo $TPL_V1["userno"]?>);"><?php echo $TPL_V1["user"]["nickname"]?></a></td>
		<td><?php echo $TPL_V1["user"]["username"]?></td>
		<td><?php echo $TPL_V1["flag_text"]?></td>
		<td>
<?php if($TPL_V1["flag_app"]=="0"){?>
			<input type="button" value="선정" onClick="mngpowerblog.proc('<?php echo $TPL_V1["ano"]?>', '1', '<?php echo $TPL_V1["user"]["nickname"]?>');" />
			<input type="button" value="거절" onClick="mngpowerblog.proc('<?php echo $TPL_V1["ano"]?>', '2', '<?php echo $TPL_V1["user"]["nickname"]?>');" />
<?php }?>
		</td>
		<td><?php echo $TPL_V1["cate1_text"]?></td>
		<td><?php echo $TPL_V1["cate2_text"]?></td>
		<td><?php echo $TPL_V1["cate3_text"]?></td>
		<td><?php echo $TPL_V1["cate4_text"]?></td>
		<td><?php echo $TPL_V1["cate5_text"]?></td>
		<td><?php echo $TPL_V1["regdate"]?></td>
	</tr>
<?php }}?>
</table>

<div class="pageno"><?php echo $TPL_VAR["link"]?></div>
</form>