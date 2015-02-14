<?php /* Template_ 2.2.4 2012/01/05 17:46:17 /www/revu39/engine/view/V3.9/manager/manager.home.htm 000006306 */ 
$TPL_allianceList_1=empty($TPL_VAR["allianceList"])||!is_array($TPL_VAR["allianceList"])?0:count($TPL_VAR["allianceList"]);
$TPL_powerblogList_1=empty($TPL_VAR["powerblogList"])||!is_array($TPL_VAR["powerblogList"])?0:count($TPL_VAR["powerblogList"]);
$TPL_errorList_1=empty($TPL_VAR["errorList"])||!is_array($TPL_VAR["errorList"])?0:count($TPL_VAR["errorList"]);
$TPL_logList_1=empty($TPL_VAR["logList"])||!is_array($TPL_VAR["logList"])?0:count($TPL_VAR["logList"]);
$TPL_best_1=empty($TPL_VAR["best"])||!is_array($TPL_VAR["best"])?0:count($TPL_VAR["best"]);
$TPL_gradeLogList_1=empty($TPL_VAR["gradeLogList"])||!is_array($TPL_VAR["gradeLogList"])?0:count($TPL_VAR["gradeLogList"]);
$TPL_gradeList_1=empty($TPL_VAR["gradeList"])||!is_array($TPL_VAR["gradeList"])?0:count($TPL_VAR["gradeList"]);?>
<h2>관리자 홈</h2>
<h4>
MYSQL_EVENT_SCHEDULER = <?php echo $TPL_VAR["var"][ 1]?>

<?php if($TPL_VAR["var"][ 1]=="OFF"){?> Warning!!! 이벤트 스케쥴러가 꺼져있습니다. 개발팀에 얘기하세요!!! <?php }?>
</h4>
<div class="clear"></div>

<?php if($_SESSION["grade"]> 104){?>
<div class="home-box">
	<h3>총 통계</h3>
	<table width="100%">
		<tr>
			<th width="120">구분</th>
			<th width="150">수치</th>
			<th>비고</th>
		</tr>
		<tr>
			<th>회원수</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["user_tcnt"]-$TPL_VAR["stats"]["secede_tcnt"])?> 명</td>
			<td>* 현재 회원수</td>
		</tr>
		<tr>
			<th>가입수</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["user_tcnt"])?> 명</td>
			<td></td>
		</tr>
		<tr>
			<th>탈퇴수</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["secede_tcnt"])?> 명</td>
			<td>*오픈이후 탈퇴수</td>
		</tr>
		<tr>
			<th>캐시</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash"])?> 캐시</td>
			<td>*실제회원 총 캐시와 다름</td>
		</tr>
		<tr>
			<th>적립캐시</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash_save"])?> 캐시</td>
			<td></td>
		</tr>
		<tr>
			<th>사용캐시</th>
			<td align="right"><?php echo number_format($TPL_VAR["stats"]["cash_use"])?> 캐시</td>
			<td></td>
		</tr>
	</table>
</div>
<div class="home-box-blank">&nbsp;</div>
<div class="home-box">
	<h3>캐시로그</h3>
	<table width="100%">
		<tr>
			<th width="120">구분</th>
			<th width="100">적립캐시</th>
			<th width="100">지급캐시</th>
		</tr>
		<tr>
			<th><?php echo $TPL_VAR["cashLog"]["pday"]["date"]?></th>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["pday"]["cash_save"])?> 캐시</td>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["pday"]["cash_use"])?> 캐시</td>
		</tr>
		<tr>
			<th><?php echo $TPL_VAR["cashLog"]["nday"]["date"]?></th>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["nday"]["cash_save"])?> 캐시</td>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["nday"]["cash_use"])?> 캐시</td>
		</tr>
		<tr>
			<th><?php echo $TPL_VAR["cashLog"]["pmonth"]["date"]?></th>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["pmonth"]["cash_save"])?> 캐시</td>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["pmonth"]["cash_use"])?> 캐시</td>
		</tr>
		<tr>
			<th><?php echo $TPL_VAR["cashLog"]["nmonth"]["date"]?></th>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["nmonth"]["cash_save"])?> 캐시</td>
			<td align="right"><?php echo number_format($TPL_VAR["cashLog"]["nmonth"]["cash_use"])?> 캐시</td>
		</tr>
	</table>
	
</div>
<div class="clear"></div>

<div class="home-box">
	<h3>제휴문의</h3>
	<ul>
<?php if($TPL_allianceList_1){foreach($TPL_VAR["allianceList"] as $TPL_V1){?>	
		<li><a href="/manager/frontier.partner"><?php echo $TPL_V1["memo"]?>[<?php echo $TPL_V1["company"]?>]</a> | <?php echo $TPL_V1["regdate"]?></li>
<?php }}?>
	</ul>	
</div>
<div class="home-box-blank">&nbsp;</div>
<div class="home-box">
	<h3>파워블로그 신청</h3>
	<ul>
<?php if($TPL_powerblogList_1){foreach($TPL_VAR["powerblogList"] as $TPL_V1){?>
		<li>
			<a href="/manager/user.powerblog"><?php echo $TPL_V1["user"]["nickname"]?></a> - <?php echo $TPL_V1["regdate"]?><br />
			<?php echo $TPL_V1["cate1_text"]?> | <?php echo $TPL_V1["cate2_text"]?> | <?php echo $TPL_V1["cate3_text"]?> | <?php echo $TPL_V1["cate4_text"]?> | <?php echo $TPL_V1["cate5_text"]?>

		</li>
<?php }}?>
	</ul>	
</div>
<div class="clear"></div>
<?php }?>

<?php if($_SESSION["grade"]> 106){?>
<div class="home-box">
	<h3>트랜잭션 에러로그</h3>
	<ul>
<?php if($TPL_errorList_1){foreach($TPL_VAR["errorList"] as $TPL_V1){?>
		<li><?php echo $TPL_V1["content"]?> - <?php echo $TPL_V1["regdate"]?></li>
<?php }}?>
	</ul>
</div>
<div class="home-box-blank">&nbsp;</div>
<div class="home-box">
	<h3>최근크론로그</h3>
	<ul>
<?php if($TPL_logList_1){foreach($TPL_VAR["logList"] as $TPL_V1){?>
		<li><?php echo $TPL_V1["content"]?> - <?php echo $TPL_V1["regdate"]?></li>
<?php }}?>
	</ul>
</div>
<div class="clear"></div>

<div class="home-box">
	<h3>최근 베스트리뷰 지급현황 | <?php echo $TPL_VAR["bestdate"]["sdate"]?>~<?php echo $TPL_VAR["bestdate"]["edate"]?></h3>
	<ol>
<?php if($TPL_best_1){foreach($TPL_VAR["best"] as $TPL_V1){?>
		<li>
			<?php echo $TPL_V1["title"]?><br />
			<?php echo $TPL_V1["user"]["nickname"]?> > <?php if($TPL_V1["cash"]> 0){?><?php echo $TPL_V1["cash"]?>캐시 지급<?php }?>
			<hr />
		</li>
<?php }}?>
	</ol>
</div>
<div class="home-box-blank">&nbsp;</div>
<div class="home-box">
	<h3>회원등급산정표 | 산정일 <?php if($TPL_gradeLogList_1){foreach($TPL_VAR["gradeLogList"] as $TPL_V1){?><?php echo $TPL_V1["regdate"]?><?php }}?></h3>
	<ul>
<?php if($TPL_gradeList_1){foreach($TPL_VAR["gradeList"] as $TPL_V1){?>
		<li><?php echo $TPL_V1["grade"]?>등급 - <?php echo $TPL_V1["spoint"]?> ~ <?php echo $TPL_V1["epoint"]?> [<?php echo $TPL_V1["usernum"]?>명]</li>
<?php }}?>
	</ul>
</div>
<div class="clear"></div>
<?php }?>
<br />