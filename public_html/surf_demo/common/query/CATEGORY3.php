<?php
	$scn = $serverInfo['SCN_CATEGORY3'][0]['value'];
	$orderBy = "";
	$orderNm = "";
	$pageNum = $srchParam->getPageNum();
	$pageSize = "";
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
	
		// 정렬 설정 (ex : order by regdate desc)
		if ($srchParam->getSort() == "r") {
			$orderBy = "";
			$orderNm = "정확도순";
		} else { 
			$orderBy = "";
			$orderNm = "등록일순";
		}
		
		// 로그 생성 		
		if ($srchParam->getCategory() == "CATEGORY3") {
			$logInfo = getLogInfo($srchParam->getSiteName(), $srchParam->getCategory(), "id", $srchParam->getKwd(), 
							$pageNum, $srchParam->getReSrchFlag(), $orderNm, $srchParam->getRecKwd());								
		}								
		
		if ($srchParam->getReSrchFlag()=="true") {
			$query = makePreQuery($srchFdNm, $srchParam->getKwd(), $srchParam->getPreKwds(), count($srchParam->getPreKwds()), "allword");
		}
		
		// 쿼리 생성
		$query = makeQuery($srchFdNm, $srchParam->getKwd(), "allword", $query, "and");
		
		// 조건 쿼리 추가 
		$query = makeQuery("category_cd", "CATEGORY3", "", $query, "and");
				
		if ($srchParam->getDetailSearch() == "true") {
			// 날짜 쿼리 추가
			if ($srchParam->getStartDate() != "" || $srchParam->getEndDate() != "") {
				if ($srchParam->getStartDate() != "") {
					$startVal = $srchParam->getStartDate() . "000000";
				}
				if ($srchParam->getEndDate() != "") {
					$endVal = $srchParam->getEndDate() . "999999";
				}
				
				$query = makeRangeQuery("regdate", $startVal, $endVal, $query);
			}

			// 제외어 검색
			if ($srchParam->getExclusiveKwd() != "") {
				$query = makeQuery($srchFdNm, $srchParam->getExclusiveKwd(), "", $query, "and not");
			}
		}
		
		dcSubmitQuery($scn, $query, $logInfo, $hilightTxt, 
					$orderBy, $pageNum, $srchParam->getPageSize(), true, $rsbCATEGORY3, 1, 1);
	}
	
?>
