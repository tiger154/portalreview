<?php /* Template_ 2.2.4 2011/11/23 11:03:35 /www/revu39/engine/view/V3.9/manager/manager.review.keyword.link.htm 000002953 */ 
$TPL_list_1=empty($TPL_VAR["list"])||!is_array($TPL_VAR["list"])?0:count($TPL_VAR["list"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/review.manager.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/input.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/_global/file.js"></script>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.review.js"></script>
<iframe name="frmFile" id="frmFile" width="0" height="0" frameborder="0"></iframe>
<form name="form1" id="form1" enctype="multipart/form-data">
<input type="hidden" name="kno" id="kno" />
<input type="hidden" name="rno" id="rno" />
<h2>키워드 링크</h2>
<hr>
<table width="100%">
	<tr>
		<td width="350" valign="top">
			<h3>키워드목록</h3>
			키워드 : <input type="text" id="keyword" size="30" /> <input type="button" value="등록" id="regKeywordBtn" />
			<table width="100%">
				<tr>
					<th width="120">키워드</th>
					<th>등록일</th>
					<th>처리</th>
				</tr>
<?php if($TPL_list_1){foreach($TPL_VAR["list"] as $TPL_V1){?>
				<tr>
					<td><a href="javascript:mngreview.getKeywordLink(<?php echo $TPL_V1["kno"]?>);"><?php echo $TPL_V1["keyword"]?></a></td>
					<td><?php echo $TPL_V1["regdate"]?></td>
					<td align="center"><input type="button" value="삭제" onClick="mngreview.confirmDeleteKeyword(<?php echo $TPL_V1["kno"]?>);" /></td>
				</tr>
<?php }}?>
			</table>
			<center><?php echo $TPL_VAR["link"]?></center>
		</td>
		<td valign="top">
			<h3>키워드 리뷰  - <span id='keyword-title'>선택한 키워드 없음</span> - <span id='rno-title'>선택한 리뷰없음</span></h3>
			<table id="reviewList" width="100%">
				<tr align="center">
					<th width="80">일련번호</th>
					<th width="60">이미지</th>
					<th>제목</th>
					<th width="100">등록일</th>
					<th width="100">처리</th>
				</tr>
				<tr>
					<td colspan="5" height="100" align="center">키워드를 선택하세요.</td>
				</tr>
			</table>
			<hr />
			이미지등록 : <input type="file" id="file1" name="file1" />(.jpg로만 등록하세요.)
			<hr />
			
			<h3>리뷰일련번호  등록</h3>
			일련번호 : <input type="text" id="reg_rno" size="20" /> <input type="button" value="등록" id="rnoKeywordLinkBtn" />
			<hr />
			
			<h3>리뷰검색  등록</h3>
			제목 : <input type="text" id="title" size="40" /> <input type="button" value="검색" id="searchKeywordLinkBtn" />
			<table id="reviewList2" width="100%">
				<tr align="center">
					<th width="80">일련번호</th>
					<th>제목</th>
					<th width="100">등록일</th>
					<th width="50">처리</th>
				</tr>
			</table>			
		</td>
	</tr>
</table>
<hr>
</form>