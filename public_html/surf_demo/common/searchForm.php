<?
	$cateName = "";
	if ($srchParam->getCategory() == "CATEGORY1") {
		$cateName = "바로가기"; 
	} else if ($srchParam->getCategory() == "CATEGORY2") {
		$cateName = "인물"; 
	} else if ($srchParam->getCategory() == "CATEGORY3") {
		$cateName = "사이트";
	} else if ($srchParam->getCategory() == "CATEGORY4") {
		$cateName = "뉴스";
	} else if ($srchParam->getCategory() == "CATEGORY5") {
		$cateName = "전문자료";
	} else if ($srchParam->getCategory() == "CATEGORY6") {
		$cateName = "쇼핑";
	} else {
		$cateName = "통합검색";
	}
?>
<div id="header_logo">
    <h1><a href="#" title="사이트이름"><img src="./image/logo.gif" alt="KONAN TECHNOLOGY" /></a></h1>
    <h2><a href="#"><img src="./image/logo_search.gif" alt="통합검색" /></a></h2>
	<div class="topSearch">
      	<form name="searchForm" id=AKCFrm method="get" onsubmit="return seachKwd(this);">
        <div id="searchSelect" onmouseover="categotyView(true)" onmouseout="categotyView(false)">
        	<ul id="searchSelectList" style="display:none;" onmouseover="categotyView(true)" onmouseout="categotyView(false)">
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('TOTAL','통합검색');">통합검색</a></li>
            	<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY1','바로가기');">바로가기</a></li>
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY2','인물');">인물</a></li>
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY3','사이트');">사이트</a></li>
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY4','뉴스');">뉴스</a></li>
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY5','전문자료');">전문자료</a></li>
   				<li onclick="categotyView(false)"><a href="javascript:selectSearch('CATEGORY6','쇼핑');">쇼핑</a></li>
          	</ul> 
          	<div id="selectedSearch" onclick=""><?=$cateName?></div>
        </div>
        <div class="searchBox">
          	<input type="text" name="kwd" id="AKCKwd" value="<?=$srchParam->getKwd()?>" class="txt" title="검색어 입력" tabindex="3" autocomplete="off" />

          	<img id="AKCArrow" class="acimg" src="./image/ico_search-head-dn.gif" alt="검색어 자동완성" /> </div>
        	<input type="submit" class="searchBtn" value=""/>
        	<div class="research">
         		<input type="checkbox" name="reSrchFlag" value="true" id="reSrchFlag" <?=makeReturnValue("true", $srchParam->reSrchFlag, "checked", "")?> />결과내 재검색<span>|</span> 
         		<a href="javascript:detailview();">상세검색</a>        
         	</div>
         	<input type="hidden" name="category" value="<?=$srchParam->getCategory()?>"/>
         	<input type="hidden" name="pageSize" value="" />
         	<input type="hidden" name="sort" value="<?=$srchParam->getSort()?>" />
         	<?= makeHtmlForPreKwd($srchParam)?>
      	</form>
    </div>
</div>
<div id="AKCDiv" style="DISPLAY: none; Z-INDEX: 300; POSITION: absolute; ">
	<iframe id="AKCIfrm" style="WIDTH: 100%; HEIGHT: 0px" name="AKCIfrm" marginwidth="0" marginheight="0" src="./akc.html" frameborder="0" scrolling="no">
	</iframe>
</div>

