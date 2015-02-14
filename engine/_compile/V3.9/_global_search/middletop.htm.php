<?php /* Template_ 2.2.4 2012/06/11 15:14:21 /www/revu39/engine/view/V3.9/_global_search/middletop.htm 000003528 */ 
$TPL_recommendKwdList_1=empty($TPL_VAR["recommendKwdList"])||!is_array($TPL_VAR["recommendKwdList"])?0:count($TPL_VAR["recommendKwdList"]);?>
<!--<div class="s">가변대응을위한영역으로꼭필요합니다</div>-->
<?php if($TPL_VAR["reSrchFlag"]=='false'){?>
<div class="section_t search01">
	<h2>기본검색</h2>
	<div class="suggest_txt">
		<p><strong><?php echo $TPL_VAR["keyword"]?></strong>에 대한 검색 결과입니다.</p>
	</div>
</div>
<?php }?>

<?php if($TPL_VAR["reSrchFlag"]=='true'){?>
<div class="section_t research">
	<h2>재검색결과</h2>
	<div class="suggest_txt">
		<p><strong><?php echo $TPL_VAR["firstKwd"]?></strong> 결과 내 재검색 <strong><?php echo $TPL_VAR["endKwd"]?></strong>에 대한 검색 결과입니다.</p>
	</div>
</div>
<?php }?>

<?php if($TPL_VAR["arrCorrectedKwd"]!=''){?>
<div class="section_t suggestion">
	<h2>검색어제안</h2>
	<div class="suggest_txt">
		<!--<p><strong><?php echo $TPL_VAR["keyword"]?></strong>를(을) <strong><?php echo $TPL_VAR["arrCorrectedKwd"]?></strong>(으)로 검색한 결과입니다.</p>-->
		<p><strong>'<?php echo $TPL_VAR["arrCorrectedKwd"]?>'</strong>(으)로 검색하시겠습니까?</p>
		<span><a href="javascript:goKwd('<?php echo $TPL_VAR["arrCorrectedKwd"]?>');">'<?php echo $TPL_VAR["arrCorrectedKwd"]?>' 검색 결과 보기</a></span>
	</div>
</div>
<?php }?>

<?php if($TPL_VAR["recommendKwdList"]!=''){?>
<div class="section_t relate_word">
	<h2>유사검색어</h2>
	<ul class="rword_list">
<?php if($TPL_recommendKwdList_1){foreach($TPL_VAR["recommendKwdList"] as $TPL_V1){?>
		<li><a href="javascript:goKwd('<?php echo $TPL_V1["kre"]?>');"><?php echo $TPL_V1["kre"]?></a></li>
<?php }}?>
	</ul>
</div>
<?php }?>


<!-- ad -->
<script language="javascript" type="text/javascript" src="http://svc.wisenut.co.kr/service_utf8.asp?keyword=<?php echo $TPL_VAR["keyword"]?>&partner=W_P_revu_5
&width=700"></script>
<script language="javascript" type="text/javascript" src="http://adsvc.wisenut.co.kr/service_utf8.asp?keyword=<?php echo $TPL_VAR["keyword"]?>&scode=19&width=700"></script>


<script language="javascript">	

	var sponsorlink1_array = getSponsorLinkArray1();					// 스폰서링크 광고 정보를 받아온다.

	if(sponsorlink1_array.length >0){
		document.write("<div class='section sps_ad'>");
		document.write("<div class='section_title'>");
		document.write("<h2>스폰서링크</h2>");
		document.write("<p class='ad_desc'><img src='images/search/icon_ad.gif' alt='AD' width='17' height='11'></p>");
		document.write("</div>");
		document.write("<ul class='search_txt_list'>");
		document.write("<li>");
		document.write("<dl>");
		
		for(i=0; i<sponsorlink1_array.length; ++i){
			document.write("<dt><a href='"+sponsorlink1_array[i]["click_url"]+"' target='_blank'>"+sponsorlink1_array[i]["title"]+"</a></dt>");			// 제목
			document.write("<dd class='txt_inline'><a href='"+sponsorlink1_array[i]["url"]+"' target='_blank'>"+sponsorlink1_array[i]["url"]+"</a></dd>");			// 사이트 주소
			document.write("<dd class='txt_block'><a href='"+sponsorlink1_array[i]["click_url"]+"' target='_blank'>"+sponsorlink1_array[i]["description"]+"</a></dd>");	// 설명
		}

		document.write("</dl>");
		document.write("</li>");
		document.write("</ul>");
		document.write("</div>");
}
</script>
<!-- // ad -->