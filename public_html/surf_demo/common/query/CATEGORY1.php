<?php
	$scn = $serverInfo['SCN_CATEGORY1'][0]['value']; 	//설정 파일로 부터 읽어오거나 하드코딩 가능.
	$orderBy = "";								//정렬절
	$orderNm = "";								//정렬명 (로그에 남길 정렬명)
	$pageNum = $srchParam->getPageNum();		//검색 결과 페이지 번호 
	$pageSize = "";								//검색 결과 
	$hilightTxt = $srchParam->getKwd();
	$logInfo = "";
	$query = "";
	$srchFdNm = "text_idx";

	if ($srchParam->getKwd() != "") {		
		// 검색 대상 필드
		if ($srchParam->getSrchFd() == "title") {
			$srchFdNm = "title"; 
		} else if ($srchParam->getSrchFd() == "contents") {
			$srchFdNm = "contents"; 
		} else if ($srchParam->getSrchFd() == "writer") {
			$srchFdNm = "writer"; 
		} else if ($srchParam->getSrchFd() == "file") {
			$srchFdNm = "file_contents"; 
		}
	
		//정렬 설정 (ex : order by regdate desc)
		if ($srchParam->getSort() == "r") {
			$orderBy = "";
			$orderNm = "정확도순";
		} else { 
			$orderBy = "";
			$orderNm = "등록일순";
		}
		
		//로그 생성 		
		$logInfo = getLogInfo($srchParam->getSiteName(), $srchParam->getCategory(), "id", $srchParam->getKwd(), 
							$pageNum, $srchParam->getReSrchFlag(), $orderNm, $srchParam->getRecKwd());								
		
		if ($srchParam->getReSrchFlag()=="true") {
			$query = makePreQuery($srchFdNm, $srchParam->getKwd(), $srchParam->getPreKwds(), count($srchParam->getPreKwds()), "allword");
		}
		
		// 쿼리 생성
		$query = makeQuery($srchFdNm, $srchParam->getKwd(), "allword", $query, "and");
		
		// 조건 쿼리 추가 
		$query = makeQuery("category_cd", "CATEGORY1", "", $query, "and");
		
		if ($srchParam->getDetailSearch() == "true") {
			//날짜 쿼리 추가
			if ($srchParam->getStartDate() != "" || $srchParam->getEndDate() != "") {
				if ($srchParam->getStartDate() != "") {
					$startVal = $srchParam->getStartDate() . "000000";
				}
				if ($srchParam->getEndDate() != "") {
					$endVal = $srchParam->getEndDate() . "999999";
				}
				
				$query = makeRangeQuery("regdate", $startVal, $endVal, $query);
			}

			//제외어 검색
			if ($srchParam->getExclusiveKwd() != "") {
				$query = makeQuery($srchFdNm, $srchParam->getExclusiveKwd(), "", $query, "and not");
			}
		}
		
		dcSubmitQuery($scn, $query, $logInfo, $hilightTxt, 
					$orderBy, $pageNum, $srchParam->getPageSize(), true, $rsbCATEGORY1, 1, 1);
	}
	
?>
