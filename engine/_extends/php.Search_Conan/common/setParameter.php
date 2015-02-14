<?php
	// request 값들이 post이거나 get일 경우 모두 처리함
	extract($_POST);
	extract($_GET);
	
	
	// 검색키워드
	if( $kwd != "" ) {
		$kwd = stripslashes($kwd);
		$kwd = getStringReplace($kwd ,"\""," ");
	    	$kwd = getStringReplace($kwd ,"<script","&lt;script");
	    	$kwd = trim($kwd);
	}
	
	// 사이트명
	$srchParam->setSiteName("ReVu");	//프로젝트명으로 교체해서 사용.
	
	// 유저ID
	$srchParam->setUserId("");		//그룹웨어의 경우 사용자 id 값을 받아서 사용.

	// 키워드
	$srchParam->setKwd($kwd);

	// 이전검색어 배열목록
	if($preKwd != null){
		$srchParam->setPreKwds($preKwd);
		$srchParam->setRecKwd($preKwd[0]);
	}
	// 검색 카테고리
	$srchParam->setCategory(null2str($category,"TOTAL"));
	
	// 페이지번호
	$srchParam->setPageNum(null2Int($pageNum, 1));

	// 페이지크기 
	$srchParam->setPageSize(null2Int($pageSize, 20));
	
	if ($srchParam->getCategory() == "TOTAL") {
		$srchParam->setReviewPageSize(10);
		$srchParam->setFrontierPageSize(2);
		$srchParam->setBloggerPageSize(10);
		$srchParam->setBlogPageSize(5);
	}else{
		$srchParam->setReviewPageSize(20);
		$srchParam->setFrontierPageSize(10);
		$srchParam->setBloggerPageSize(20);
		$srchParam->setBlogPageSize(20);
	}

	//하이라이트
		$srchParam->setHilightText($hilightTxt);

	/*if ($srchParam->getCategory() == "TOTAL") {
		$srchParam->setPageSize($serverInfo['PAGESIZE_TOTAL'][0]['value']);
	} else {
		//$srchParam->setPageSize($serverInfo['PAGESIZE'][0]['value']);
	}*/
	
	// 재검색 유무
	if ($reSrchFlag=="true" OR $reSrchFlag=="on") {
		$srchParam->setReSrchFlag("true");
	} else {
		$srchParam->setReSrchFlag("false");
	}
	
	$cateName = "통합검색";
	
	if ($srchParam->getCategory() == "review"){
		$cateName = "리뷰";
	} else if ($srchParam->getCategory() == "style"){
		$cateName = "스타일";
	} else if ($srchParam->getCategory() == "frontier"){
		$cateName = "프론티어";
	} else if ($srchParam->getCategory() == "blogger"){
		$cateName = "블로거";
	} else if ($srchParam->getCategory() == "blog"){
		$cateName = "블로그";
	}
	
	
	// 정렬
	$srchParam->setSort(null2str($sort, "r"));
	
	// 상세검색 유무
	$srchParam->setDetailSearch(null2str($detailSearch, "false"));
	
	// 제외어 검색
	$srchParam->setExclusiveKwd(null2Str($xwd, ""));
	
	// 날짜 검색 - 선택 
	$srchParam->setDate(null2Str($date, ""));
	
	// 날짜 검색 - 시작일 
	$srchParam->setStartDate(null2Str($startDate, ""));
	
	// 날짜 검색 - 종료일 
	$srchParam->setEndDate(null2Str($endDate, ""));
	
	// 검색대상 필드
	$srchParam->setSrchFd($srchFd);
	
?>
