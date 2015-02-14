<?php

	//변수선언 
	$scn = $serverInfo['SCN_CATEGORY2'][0]['value'];
	$srchMthd = $serverInfo['SRCH_METHOD'][0]['value'];
	$orderBy = "";
	$orderNm = "";
	$hilightTxt = "";
	$logInfo = "";
	$query = "";
	$srchFdNm = "text_idx";
	$kwd = $srchParam->getKwd();
	
	$pageNum = $srchParam->getPageNum();
	
	if($srchParam->getCategory() == 'TOTAL'){
                $pageSize = 10;
        }else{
                $pageSize = 20;
        }

	if($kwd != ''){

		//정렬설정
                if($srchParam->getSort() == "d"){
                        $orderBy = "order by regdate desc";
                        $orderNm = "등록일순";
                }else{
                        $orderBy = "";
                        $orderNm = "정확도순";
                }
	
		//로그포맷
		$logInfo = getLogInfo("ReVu", "스타일", $srchParam->getUserId(), $kwd, $pageNum, $srchParam->getReSrchFlag(), $orderNm, $srchParam->getRecKwd());

                // 결과내 재검색
                if($srchParam->getReSrchFlag() == "true"){
                        $query = makePreQuery($srchFdNm, $kwd, $srchParam->getPreKwds(), count($srchParam->getPreKwds()), $srchMthd);
                }

		//기본 키워드 검색
		$query = makeQuery($srchFdNm, $kwd, $srchMthd, $query, "and");
	
		dcSubmitQuery($scn,$query,$logInfo,$hilightTxt,$orderBy,$pageNum,$pageSize,true,$rsbStyle,1,4);	
	
	}
?>
