<?php /* Template_ 2.2.4 2011/11/23 15:28:20 /www/revu39/engine/view/V3.9/manager/manager.review.keyword.htm 000002533 */ 
$TPL_seq_1=empty($TPL_VAR["seq"])||!is_array($TPL_VAR["seq"])?0:count($TPL_VAR["seq"]);
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.review.js"></script>
<h2>메인 키워드 리뷰</h2>
<hr>
<table width="100%">
	<tr>
		<td width="400" valign="top">
			<h3>노출키워드</h3>			
			<p>
				<input type="button" value="↑" id="upKeywordBtn" />
				<input type="button" value="↓" id="downKeywordBtn" />				
				<input type="button" value="삭제" id="removeKeywordBtn" />				
				<input type="button" value="적용" id="appKeywordBtn" />
			</p>
			<select id="seq" size="10" style="width:400px;height:400px" >
<?php if($TPL_seq_1){foreach($TPL_VAR["seq"] as $TPL_V1){?>
				<option value="<?php echo $TPL_V1["kno"]?>"><?php echo $TPL_V1["keyword"]["keyword"]?></option>
<?php }}?>
			</select>
			<input name="kno" id="kno" type="hidden" value="">
			<script>combobox.resultOption('seq','kno');</script>
		</td>
		<td valign="top">
			<h3>키워드목록</h3>
			<table width="100%">
				<tr>
					<th width="50">등록</th>
					<th width="70">일련번호</th>
					<th>키워드</th>
					<th>키워드링크</th>
					<th width="100">등록일</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr align="center">
					<td><input type="button" value="<<" onClick="combobox.addOption('seq', '<?php echo $TPL_V1["kno"]?>', '<?php echo $TPL_V1["keyword"]?>');combobox.resultOption('seq','kno');" /></td>
					<td><?php echo $TPL_V1["kno"]?></td>
					<td align="left"><?php echo $TPL_V1["keyword"]?></td>
					<td><input type="button" value="보기" onClick="mngreview.getKeywordLinkSimple(<?php echo $TPL_V1["kno"]?>);" /></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
				</tr>
<?php }}?>
			</table>
			<center><?php echo $TPL_VAR["link"]?></center>
			<hr>
			<h3>키워드 리뷰  - <span id='keyword-title'>선택한 키워드 없음</span></h3>
			<table id="reviewList" width="100%">
				<tr align="center">
					<th width="80">일련번호</th>
					<th width="60">이미지</th>
					<th>제목</th>
					<th width="100">등록일</th>
				</tr>
			</table>
		</td>
	</tr>
</table>
<hr>