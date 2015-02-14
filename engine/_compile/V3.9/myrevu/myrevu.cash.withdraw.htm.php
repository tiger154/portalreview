<?php /* Template_ 2.2.4 2011/11/08 16:40:20 /www/revu39/engine/view/V3.9/myrevu/myrevu.cash.withdraw.htm 000008479 */ 
$TPL_cashList_1=empty($TPL_VAR["cashList"])||!is_array($TPL_VAR["cashList"])?0:count($TPL_VAR["cashList"]);
$TPL_bankcode_1=empty($TPL_VAR["bankcode"])||!is_array($TPL_VAR["bankcode"])?0:count($TPL_VAR["bankcode"]);?>
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/myrevu.cash.js"></script>
<iframe name="frmFile" id="frmFile" width="0" height="0" frameborder="0"></iframe>
<form name="withdrawForm" id="withdrawForm" enctype="multipart/form-data">

<div class="title_line gray_l_text"><img src="/images/myrevu/title_cash.gif"  align="left"/></div>
<div style="width:714px; height:190px; margin-bottom:40px;"><img src="/images/myrevu/img_cash.gif" /></div>
<!-- 입력폼1/출금신청 시작 -->
<div class="title32_line"><img src="/images/myrevu/title_cash2.gif" align="left"/></div>
<div style="width:714px; height:auto;">
	<table width="100%" border="0" cellspacing="0">
		<tr>
			<td class="block_text">출금가능 캐쉬</td>
			<td class="block_text2"><span class="red_title"><?php echo number_format($TPL_VAR["cash"]["cash"])?></span></td>
		</tr>
		<tr>
			<td class="block_text">출금신청 캐쉬</td>
			<td class="block_text2">
				<select name="cash" id="cash">
<?php if($TPL_cashList_1){foreach($TPL_VAR["cashList"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["cash"]?>"><?php echo number_format($TPL_V1["cash"])?></option>
<?php }}?>
				</select>
				&nbsp;<span class="common11_text pt05">* 캐쉬는 10,000단위로만 신청 가능합니다.</span>
			</td>
		</tr>
	</table>
</div>
<!-- 입력폼1/출금신청  끝 -->

<div style="height:40px;"></div>

<!-- 입력폼2/신청자정보 시작 -->
<div class="title32_line"><img src="/images/myrevu/title_cash3.gif" align="left"/></div>
<div style="width:714px; height:auto;">
	<table width="100%" border="0" cellspacing="0">
		<tr>
			<td class="block_text">본인확인</td>
			<td class="block_text2">
				<span class="black_text"><strong>이름</strong></span>
				&nbsp;&nbsp;
				<input type="text" name="name" id="name" class="input_common" value="<?php echo $_SESSION["username"]?>" />
				&nbsp;&nbsp;
				<span class="black_text"><strong>주민번호</strong></span>
				&nbsp;&nbsp;
				<input type="text" name="socialno1" id="socialno1" class="input_common" maxlength="6" style="width:100px;" value="" />
				&nbsp;-&nbsp;
				<input type="text" name="socialno2" id="socialno2" class="input_common" maxlength="7" style="width:100px;" value="" />
				<br /><br />
				<span class=" gray11_l_text">* 본인 확인 및 기타소득 신고를 위해 개인정보를 정확히 입력해주셔야 합니다.</span>
			</td>
		</tr>
		<tr>
			<td class="block_text">파일첨부</td>
			<td class="block_text2">
				<div style="width:82px; height:132px;margin:0 20px 0 0;"class="fl">
					<ul>
						<li class="thum1">
							<img src="/images/common/thum/thum_profile_dummy4.gif" id="thumb_image1" width="80" height="80" />
							<input type="hidden" name="thumbmime1" id="thumbmime1" value="" />
							<input type="hidden" name="thumbname1" id="thumbname1" value="" />
							<input type="hidden" name="thumbsize1" id="thumbsize1" value="" />
						</li>
					</ul>
				</div>
				<div style="width:418px; height:132px;"class="fl">
					<div style="width:418px; height:22px; padding-bottom:8px;" class="gray_d_text">
						<input type="radio" name="attach_type1" value="0"  checked  class="h2_space"/>&nbsp;신분증 사본을 팩스 또는 레뷰메일로 보냅니다.
					</div>
					<div style="width:400px; height:22px; padding:0 0 8px 18px;" class="common_text"> 
						<strong>FAX : 02-3438-5501 / E-mail : <a href="mailto:revu@revu.co.kr" target="_blank">revu@revu.co.kr</a></strong>
					</div>
					<div style="width:418px; height:22px; padding-bottom:8px;" class="gray_d_text">
						<input type="radio" name="attach_type1"  value="1"  class="h2_space"/>&nbsp;신분증 사본을 이미지 파일로 첨부합니다.
					</div>
					<div style="width:418px; height:22px; padding:0 0 8px 18px;" class="gray_d_text">
						<input type="file" name="file1" id="file1"  class="input_common"/>
					</div>	
					<div style="width:400px; height:22px; padding:0 0 8px 18px;" class=" gray11_l_text">
						 * 5 MB 이하의 jpg, gif, bmp, png 파일만 첨부 가능합니다.
					</div>
				</div>
			</td>
		</tr>
	</table>
</div>
<!-- 입력폼2/신청자정보 끝 -->

<div style="height:40px;"></div>

<!-- 입력폼3/입금계좌정보 시작 -->
<div class="title32_line"><img src="/images/myrevu/title_cash4.gif"  align="left"/></div>
<div style="width:714px;">
	<table width="100%" border="0" cellspacing="0" >
		<tr>
			<td class="block_text">예금주</td>
			<td class="block_text2">
				<input type="text" name="account_holder" id="account_holder" class="input_common" value="<?php echo $_SESSION["username"]?>"  style="width:180px;"/>
				<span class="gray11_l_text">* 신청자 정보와 일치하지 않을 경우 입금처리 되지 않습니다.</span>
			</td>
		</tr>
		<tr>
			<td class="block_text">은행(코드)</td>
			<td class="block_text2">
				<select name="bankcode" id="bankcode" style="width:190px;"> 
					<option value="">은행선택</option>
<?php if($TPL_bankcode_1){foreach($TPL_VAR["bankcode"] as $TPL_V1){?>
					<option value="<?php echo $TPL_V1["code"]?>"><?php echo $TPL_V1["code_desc"]?>(<?php echo $TPL_V1["code"]?>)</option>
<?php }}?>
				</select>
				&nbsp;<span class="common11_text pt05">* 은행을 선택해주세요.</span>
			</td>
		</tr>
		<tr>
			<td class="block_text">계좌번호</td>
			<td class="block_text2">
				<input type="text" name="account_number" id="account_number" class="input_common" value='' style="width:180px;"/>
				&nbsp;<span class="common11_text">* ‘ -’ 없이 입력해 주세요.</span>
			</td>
		</tr>
		<tr>
			<td class="block_text">파일첨부</td>
			<td class="block_text2">
				<div style="width:82px; height:112px;margin:0 20px 0 0;"class="fl">
					<ul>
						<li class="thum1">
							<img src="/images/common/thum/thum_profile_dummy4.gif" id="thumb_image2" width="80" height="80" />
							<input type="hidden" name="thumbmime2" id="thumbmime2" value="" />
							<input type="hidden" name="thumbname2" id="thumbname2" value="" />
							<input type="hidden" name="thumbsize2" id="thumbsize2" value="" />
						</li>
					</ul>
				</div>
				<div style="width:418px; height:132px;"class="fl">
					<div style="width:418px; height:22px; padding-bottom:8px;">
						<input type="radio" name="attach_type2" value="0" border="0" checked  class="h2_space"/>
						&nbsp;
						<span class="gray_d_text">계좌 사본을 팩스 또는 레뷰메일로 보냅니다.</span>
					</div>
					<div style="width:400px; height:22px; padding:0 0 8px 18px;" class="common_text">
						<strong>FAX : 02-3438-5501 / E-mail : <a href="mailto:revu@revu.co.kr" target="_blank">revu@revu.co.kr</a></strong>
					</div>
					<div style="width:418px; height:22px; padding-bottom:8px;" class="gray_d_text">
						<input type="radio" name="attach_type2"  value="1" border="0"  class="h2_space"/>
						&nbsp;계좌 사본을 이미지 파일로 첨부합니다.
					</div>
					<div style="width:418px; height:22px; padding:0 0 8px 18px;" class="gray_d_text">
						<input type="file" name="file2" id="file2"  class="input_common"/>
					</div>	
					<div style="width:400px; height:22px; padding:0 0 8px 18px;" class=" gray11_l_text"> 
						* 5 MB 이하의 jpg, gif, bmp, png 파일만 첨부 가능합니다.
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="block_text">캐쉬 지급 일정</td>
			<td class="block_text2">
				<span class="ln19">매달 21일부터 다음 달 20일까지 신청 건은 그 다음달 10일에 입금 처리됩니다.<br />
				(예. 9월 22일 신청 → 11월 10일 입금)<br />
				※ 계좌 입금시 3.3%의 기타소득 공제를 한 후에 입금됩니다.</span>
			</td>
		</tr>
	</table>
</div>
<!-- 입력폼3/입금계좌정보 끝 -->

<div style="width:714px;height:33px; padding:40px 0; text-align:center;" class="clear">
	<img src="/images/common/but/but_big_ok.gif" id="saveBtn" alt="확인" title="확인" class="btn" />
	<img src="/images/common/space.gif" width="15px;" />
	<img src="/images/common/but/but_big_esc.gif" id="cancelBtn" alt="취소" title="취소" class="btn" /> 
</div>

</form>