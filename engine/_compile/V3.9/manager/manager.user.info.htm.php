<?php /* Template_ 2.2.4 2012/01/17 17:19:24 /www/revu39/engine/view/V3.9/manager/manager.user.info.htm 000010235 */ 
$TPL_cate_desc_1=empty($TPL_VAR["cate_desc"])||!is_array($TPL_VAR["cate_desc"])?0:count($TPL_VAR["cate_desc"]);
$TPL_area_desc_1=empty($TPL_VAR["area_desc"])||!is_array($TPL_VAR["area_desc"])?0:count($TPL_VAR["area_desc"]);
$TPL_blog_1=empty($TPL_VAR["blog"])||!is_array($TPL_VAR["blog"])?0:count($TPL_VAR["blog"]);
$TPL_reviewbest_1=empty($TPL_VAR["reviewbest"])||!is_array($TPL_VAR["reviewbest"])?0:count($TPL_VAR["reviewbest"]);?>
<link type="text/css" rel="stylesheet" href="<?php echo $TPL_VAR["CSS"]?>/_global/_style_manager.css" />
<script type="text/javascript" src="<?php echo $TPL_VAR["JS"]?>/manager.user.js"></script>
<h2><?php echo $TPL_VAR["user"]["nickname"]?>님의 회원정보</h2>
<form name="form1" id="form1">
<input type="hidden" id="user_email" value="<?php echo $TPL_VAR["user"]["email"]?>" />
<div id="tabs" style="height: 590px;">
	<ul>
		<li><a href="#tabs-1">기본정보</a></li>
		<li><a href="#tabs-2">블로그정보</a></li>
		<li><a href="#tabs-3">리뷰정보</a></li>
		<li><a href="#tabs-4">베스트리뷰정보</a></li>
		<li><a href="#tabs-5">메모내역</a></li>
		<li><a href="#tabs-8">캐시적립내역</a></li>
		<li><a href="#tabs-9">포인트로그</a></li>
	</ul>
	<div id="tabs-1">
		<table width="100%" class="table-user">
			<tr>
				<th width="120">가입일</th>
				<td width="260"><?php echo $TPL_VAR["user"]["regdate"]?></td>
				<th width="120">이메일</th>
				<td width="260"><?php echo $TPL_VAR["user"]["email"]?> / <?php echo $TPL_VAR["user"]["flag_email_text"]?></td>
			</tr>
			<tr>
				<th>ID / 회원번호</th>
				<td><?php echo $TPL_VAR["user"]["userid"]?> / <?php echo $TPL_VAR["user"]["userno"]?></td>
				<th>ID 소속</th>
				<td><img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_<?php echo $TPL_VAR["user"]["type"]?>.gif" /></td>
			</tr>
			<tr>
				<th>닉네임 / 이름</th>
				<td><?php echo $TPL_VAR["user"]["nickname"]?> / <?php echo $TPL_VAR["user"]["username"]?></td>
				<th>회원이미지</th>
				<td><img src="<?php echo $TPL_VAR["userimage"]?>" width="80" height="80" /></td>
			</tr>
			<tr>
				<th>포인트 </th>
				<td><?php echo number_format($TPL_VAR["point"]["point"])?></td>
				<th>캐시</th>
				<td><?php echo number_format($TPL_VAR["cash"]["cash"])?></td>
			</tr>
			<tr>
				<th>파워블로그</th>
				<td>
<?php if($TPL_VAR["user"]["flag_powerblog"]=="1"){?>
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" />
<?php }?> 
					<?php echo $TPL_VAR["user"]["flag_powerblog_text"]?>

<?php if($TPL_VAR["powerblog"]["cate1"]!=""){?><br /><?php echo $TPL_VAR["powerblog"]["cate_desc1"]?><?php }?>
<?php if($TPL_VAR["powerblog"]["cate2"]!=""){?><br /><?php echo $TPL_VAR["powerblog"]["cate_desc2"]?><?php }?>
<?php if($TPL_VAR["powerblog"]["cate3"]!=""){?><br /><?php echo $TPL_VAR["powerblog"]["cate_desc3"]?><?php }?>
<?php if($TPL_VAR["powerblog"]["cate4"]!=""){?><br /><?php echo $TPL_VAR["powerblog"]["cate_desc4"]?><?php }?>
<?php if($TPL_VAR["powerblog"]["cate5"]!=""){?><br /><?php echo $TPL_VAR["powerblog"]["cate_desc5"]?><?php }?>
				</td>
				<th>블랙리스트</th>
				<td><?php echo $TPL_VAR["user"]["flag_black_text"]?></td>
			</tr>
			<tr>
				<th>성별</th>
				<td><?php echo $TPL_VAR["extra"]["gender_text"]?>/<?php echo $TPL_VAR["extra"]["gender"]?></td>
				<th>생년월일</th>
				<td><?php echo $TPL_VAR["extra"]["birthday"]?>(<?php echo $TPL_VAR["extra"]["flag_lunar_text"]?>)</td>
			</tr>
			<tr>
				<th>휴대폰</th>
				<td><?php echo $TPL_VAR["extra"]["cell"]?></td>
				<th>전화번호</th>
				<td><?php echo $TPL_VAR["extra"]["tel"]?></td>
			</tr>
			<tr>
				<th>주소지</th>
				<td colspan="3"><?php echo $TPL_VAR["extra"]["addr1"]?> <?php echo $TPL_VAR["extra"]["addr2"]?></td>
			</tr>
			<tr>
				<th>관심분야</th>
				<td><?php if($TPL_cate_desc_1){foreach($TPL_VAR["cate_desc"] as $TPL_V1){?><?php echo $TPL_V1["desc"]?><br /><?php }}?></td>
				<th>관심지역</th>
				<td><?php if($TPL_area_desc_1){foreach($TPL_VAR["area_desc"] as $TPL_V1){?><?php echo $TPL_V1["desc"]?><br /><?php }}?></td>
			</tr>
			<tr>
				<th>리뷰수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["review_cnt"])?></td>
				<th>토크수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["talk_cnt"])?></td>
			</tr>
			<tr>
				<th>포인트</th>
				<td><?php echo number_format($TPL_VAR["point"]["point"])?></td>
				<th>캐시</th>
				<td><?php echo number_format($TPL_VAR["cash"]["cash"])?></td>
			</tr>
			<tr>
				<th>로그인 횟수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["login_cnt"])?></td>
				<th>최근로그인</th>
				<td><?php echo $TPL_VAR["stats"]["login_regdate"]?></td>
			</tr>
			<tr>
				<th>총 리뷰 수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["review_cnt"])?></td>
				<th>총 추천 수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["recom_cnt"])?></td>
			</tr>
			<tr>
				<th>총 토크 수</th>
				<td><?php echo number_format($TPL_VAR["stats"]["talk_cnt"])?></td>
				<th>총 메세지 수(X)</th>
				<td><?php echo number_format($TPL_VAR["stats"]["message_cnt"])?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-2">
		<table width="100%" class="table-user">			
			<tr>
				<th width="100">파워블로거</th>
				<td>
<?php if($TPL_VAR["user"]["flag_powerblog"]=="1"){?>
						<img src="<?php echo $TPL_VAR["IMAGES"]?>/common/ico/ico_revupower.gif" />
<?php }?>
					<?php echo $TPL_VAR["user"]["flag_powerblog_text"]?>

				</td>
			</tr>
			<tr>
				<th>분야</th>
				<td>
<?php if($TPL_VAR["powerblog"]["cate1"]!=""){?><?php echo $TPL_VAR["powerblog"]["cate_desc1"]?><br /><?php }?>
<?php if($TPL_VAR["powerblog"]["cate2"]!=""){?><?php echo $TPL_VAR["powerblog"]["cate_desc2"]?><br /><?php }?>
<?php if($TPL_VAR["powerblog"]["cate3"]!=""){?><?php echo $TPL_VAR["powerblog"]["cate_desc3"]?><br /><?php }?>
<?php if($TPL_VAR["powerblog"]["cate4"]!=""){?><?php echo $TPL_VAR["powerblog"]["cate_desc4"]?><br /><?php }?>
<?php if($TPL_VAR["powerblog"]["cate5"]!=""){?><?php echo $TPL_VAR["powerblog"]["cate_desc5"]?><br /><?php }?>
				</td>
			</tr>
			<tr>
				<th>등록된 블로그 수</th>
				<td><?php echo number_format($TPL_VAR["blog_cnt"])?></td>
			</tr>
			<tr>
				<th>블로그 리스트</th>
				<td valign="top">
					<table width="100%">
						<tr>
							<th>블로그번호</th>
							<th>타이틀/URL</th>
							<th>사용유무</th>
							<th>리뷰수</th>
							<th>토크수</th>
							<th>캐시</th>
							<th>등록일</th>
						</tr>
<?php if($TPL_blog_1){foreach($TPL_VAR["blog"] as $TPL_V1){?>
						<tr align="center">
							<td><?php echo $TPL_V1["blogno"]?></td>
							<td><?php echo $TPL_V1["name"]?><br /><a href="<?php echo $TPL_V1["url"]?>" target="_blank"><?php echo $TPL_V1["url"]?></a></td>							
							<td><?php echo $TPL_V1["flag_activated"]?></td>
							<td><?php echo $TPL_V1["review_cnt"]?></td>
							<td><?php echo $TPL_V1["talk_cnt"]?></td>
							<td><?php echo $TPL_V1["cash"]?></td>
							<td><?php echo $TPL_V1["regdate"]?></td>
						</tr>
<?php }}?>
					</table>
				</td>
			</tr>			
		</table>
	</div>
	<div id="tabs-3">
		<iframe width="760" height="540" src="/manager/user.info.review/<?php echo $TPL_VAR["user"]["userno"]?>" frameborder="0"></iframe> 
	</div>
	<div id="tabs-4">
		<table width="100%" class="table-user">
			<tr>
				<th width="100">총 베스트리뷰 수</th>
				<td><?php echo number_format($TPL_VAR["reviewbestCnt"])?></td>
			</tr>
			<tr>
				<th>베스트리뷰 <br />리스트<br />(최근10건)</th>
				<td valign="top">
					<table width="100%">
						<tr>
							<th>베스트기간</th>
							<th>랭킹</th>
							<th>제목</th>
							<th>추천수</th>							
							<th>등록일</th>
						</tr>
<?php if($TPL_reviewbest_1){foreach($TPL_VAR["reviewbest"] as $TPL_V1){?>
						<tr align="center">
							<td><?php echo $TPL_V1["sdate"]?>~<?php echo $TPL_V1["edate"]?></td>
							<td><?php echo $TPL_V1["rank"]?></td>
							<td align="left" width="300"><a href="javascript:common.socialbar(<?php echo $TPL_V1["rno"]?>);"><?php echo $TPL_V1["review"]["title"]?></a></td>
							<td><?php echo $TPL_V1["best_recom_cnt"]?></td>
							<td><?php echo $TPL_V1["regdate"]?></td>
						</tr>
<?php }}?>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-5">
		<iframe width="760" height="540" src="/manager/user.info.memo/<?php echo $TPL_VAR["user"]["userno"]?>" frameborder="0"></iframe> 
	</div>
	<div id="tabs-8">
		<iframe width="760" height="540" src="/manager/user.info.cash/<?php echo $TPL_VAR["user"]["userno"]?>" frameborder="0"></iframe>	
	</div>
	<div id="tabs-9">
		<iframe width="760" height="540" src="/manager/user.info.point/<?php echo $TPL_VAR["user"]["userno"]?>" frameborder="0"></iframe>
	</div>
<br />
</div>
<center>
	<input type="button" value="메모" onClick="mnguser.confirmMemo(<?php echo $TPL_VAR["user"]["userno"]?>);" />
	<input type="button" value="개별메일 보내기" onClick="mnguser.confirmSendMail('<?php echo $TPL_VAR["user"]["email"]?>');" />
<?php if($_SESSION["grade"]> 105){?>	
	<input type="button" value="뉴스레터 수신거부" onClick="mnguser.confirmReceiveEmail(<?php echo $TPL_VAR["user"]["userno"]?>);" />
	<input type="button" value="캐시 지급/차감" onClick="mnguser.confirmCash(<?php echo $TPL_VAR["user"]["userno"]?>);" />
	<input type="button" value="파워블로거" onClick="mnguser.confirmPowerblog(<?php echo $TPL_VAR["user"]["userno"]?>);" />
	<input type="button" value="블랙리스트" onClick="mnguser.confirmBlackList(<?php echo $TPL_VAR["user"]["userno"]?>);" />	
	<input type="button" value="탈퇴처리" onClick="mnguser.confirmSecede(<?php echo $TPL_VAR["user"]["userno"]?>);" />	
<?php }?>	
	<br /><br />
	<input type="button" value="닫기" onClick="common.popupClose();" />
</center>
</form>
<br />