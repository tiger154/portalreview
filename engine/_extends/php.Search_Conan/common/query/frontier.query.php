<?php

	//변수선언 
	$scn = $serverInfo['SCN_CATEGORY3'][0]['value'];
	$srchMthd = $serverInfo['SRCH_METHOD'][0]['value'];
	$orderBy = "";
	$orderNm = "";
	$hilightTxt = "";
	$logInfo = "";
	$query = "";
	$srchFdNm = "text_idx";
	$kwd = $srchParam->getKwd();
	
	$preKwds = $srchParam->getPreKwds();

	$pageNum = $srchParam->getPageNum();
	
        if($srchParam->getCategory() == 'TOTAL'){
                $pageSize = 2;
        }else{
                $pageSize = 10;
        }

	if($kwd != ''){
	
		//로그포맷
		$logInfo = getLogInfo("ReVu", "프론티어", "", $kwd, $pageNum, $srchParam->getReSrchFlag(), $orderNm, $srchParam->getRecKwd());

                // 결과내 재검색
                if($srchParam->getReSrchFlag() == "true"){
                        $query = makePreQuery($srchFdNm, $kwd, $srchParam->getPreKwds(), count($srchParam->getPreKwds()), $srchMthd);
						for($k=count($preKwds);$k>=0;$k--){
						$hilightTxt = $hilightTxt." ".$preKwds[$k];
					}
			
					$hilightTxt = $hilightTxt." ".$kwd;

				}else{
					$hilightTxt = $kwd;
				}


		//기본 키워드 검색
		$query = makeQuery($srchFdNm, $kwd, $srchMthd, $query, "and");
		$orderBy = "order by ing_state asc, start_date asc";
	
		dcSubmitQuery($scn,$query,$logInfo,$hilightTxt,$orderBy,$pageNum,$pageSize,true,$rsbFrontier,1,4);	
	
	}
?>
