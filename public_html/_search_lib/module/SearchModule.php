<?php

define("DAEMON_SERVICE_IP", $serverInfo['DAEMON_SERVICE_IP'][0]['value']);
define("DAEMON_SERVICE_PORT", $serverInfo['DAEMON_SERVICE_PORT'][0]['value']);
define("DAEMON_SERVICE_ADDRESS", $serverInfo['DAEMON_SERVICE_ADDRESS'][0]['value']);


/** 실제 검색을 처리하는 메소드 (SubmitQuery)
 * @param scn 시나리오
 * @param query 검색쿼리
 * @param logInfo 로그정보
 * @param hilightTxt 하이라이트 키워드
 * @param orderBy 정렬절
 * @param pageNum 페이지번호
 * @param pageSize 페이지사이즈
 * @param flag rowid 사용 유무 플래그
 * @param dcb 결과셋을 담을 bean
 * @param nLanguage 언어셋
 * @param nCharset 캐릭터셋
 * @return 결과값(int)
 */

function dcSubmitQuery($scn, $query, $logInfo, $hilightTxt, $orderBy, $pageNum, $pageSize, $flag, $dcb, $nLanguage, $nCharset)
{
    if($crz == NULL) $crz = new DOCRUZER;
    if($hc == NULL) {
        $hc = $crz->CreateHandle();
       
	if($hc < 0){
            echo "msg : cannot create handle<BR>\n";
            exit;
        }
    }
	
    //$rc = $crz->SetOption($hc, OPTION_SOCKET_ASYNC_REQUEST, 1);
    //$rc = $crz->SetOption($hc, OPTION_SOCKET_TIMEOUT_REQUEST, 10);
    
    $startNum = ($pageNum -1) * $pageSize;
    $userid = "";

    $rc = $crz->SubmitQuery(
        $hc,
        DAEMON_SERVICE_IP,
        DAEMON_SERVICE_PORT,
        $userid,
        $logInfo,
        $scn,
        $query,
        $orderBy,
        $hilightTxt,
        $startNum,
        $pageSize,
        $nLanguage,
        $nCharset);
    
    if( $rc < 0 ) {
        echo "msg : " . $crz->GetErrorMessage($hc);
        echo "<br>query was " . $query;
    } else {
    	$cols = 0;
	$rows = 0;
	$total = 0;
	$fdata = NULL;
	$tmp_fdata = NULL;
	$rowIds = NULL;
	$scores = NULL;
	//$n_search_time;

	$total = $crz->GetResult_TotalCount($hc);
	$rows = $crz->GetResult_RowSize($hc);
	$cols = $crz->GetResult_ColumnSize($hc);
	//$n_search_time = $crz->GetResult_SearchTime($crzClient);
    	
	if ($flag) {
		$crz->GetResult_ROWID($hc, $rowIds, $scores);
	}
		
	for($i = 0; $i < $rows; $i++) {
		//echo $i;
		$crz->GetResult_ROW($hc, $tmp_fdata, $i);
		for($j = 0; $j < $cols; $j++) {
 		  	$dcb->setFdata($tmp_fdata[$j], $i, $j );
			//$fdata[$i][$j] = $tmp_fdata[$j];
			//echo "i : " . $i . " | j : " . $j . "[" . $fdata[$i][$j];
		}
	}
		
	$dcb->setTotal($total);
	$dcb->setRows($rows);
	$dcb->setCols($cols);
      	$dcb->setRowIds($rowIds);		
        $dcb->setScores($scores);
		
	$crz->DestroyHandle($hc);
    } 
    return $dcb;
}


/** 실제 검색을 처리하는 메소드 (Search-분산볼륨, String List GroupBy)
 * @param scn 시나리오
 * @param query 검색쿼리
 * @param logInfo 로그정보
 * @param hilightTxt 하이라이트 키워드
 * @param orderBy 정렬절
 * @param pageNum 페이지번호
 * @param pageSize 페이지사이즈
 * @param flag rowid 사용 유무 플래그
 * @param dcb 결과셋을 담을 bean
 * @param nLanguage 언어셋
 * @param nCharset 캐릭터셋
 * @return 결과값(int)
 * @throws IOException
 * @throws Exception
 * @throws KonanException
 */
function dcSearch($scn, $query, $logInfo, $hilightTxt, $orderBy, $pageNum, $pageSize, $flag, &$dcb, $nLanguage, $nCharset)
{
    if($crz == NULL) $crz = new DOCRUZER;
    if($hc == NULL) {
        $hc = $crz->CreateHandle();
        if($hc < 0){
            echo "msg : cannot create handle<BR>\n";
            exit;
        }
    }

	//$rc = $crz->SetOption($hc, OPTION_SOCKET_ASYNC_REQUEST, 1);
    //$rc = $crz->SetOption($hc, OPTION_SOCKET_TIMEOUT_REQUEST, 10);
    
    //시작 위치 결정
    $startNum = ($pageNum-1) * $pageSize;

    $rc = $crz->Search(
        $hc,
        DAEMON_SERVICE_ADDRESS,
        $scn,
        $query,
        $orderBy,
        $hilightTxt,
        $logInfo,
        $startNum,
        $pageSize,
        $nLanguage,
        $nCharset
    );
    
    $nGroupCount = 0;
    $nGroupKeyCount = 0;	
    $groupKeyVal = NULL;
    $groupSize = NULL; 
    
    $cols = 0;
	$rows = 0;
	$total = 0;
	$fdata = NULL;
	$tmp_fdata = NULL;
	$rowIds = NULL;
	$score = NULL;
	//$n_search_time;
	
    if( $rc < 0 ){
        echo "msg : " . $crz->GetErrorMessage($hc);
        echo "<br>query was " . $whereClause;
        exit;
    } else {
	    
    	if ($flag) {
			$crz->GetResult_GroupBy($hc, $nGroupCount, $nGroupKeyCount, $groupKeyVal, $groupSize, $pageSize);
			if ($rc < 0) {
				echo "msg : " . $crz->GetErrorMessage($hc);
			} else {
				
				for ($i=0; $i<$nGroupCount; $i++) {
					$fData[$i][0] = $groupKeyVal[$i][0];
					$fData[$i][1] = $groupSize[$i];
					$total += $groupSize[i];
					//echo "0 : " . $fData[$i][0] . " |   1 : " . $fData[$i][1] . "<br>";  
				}
				echo "total : " . $nGroupCount;
			}
		} else {
			$total = $crz->GetResult_TotalCount($hc);
			$rows = $crz->GetResult_RowSize($hc);
			$cols = $crz->GetResult_ColumnSize($hc);
			//$n_search_time = $crz->GetResult_SearchTime($crzClient);
			
	      	$crz->GetResult_ROWID($hc, $rowIds, $score);
	      	
			for($i = 0; $i < $rows; $i++) {
				$crz->GetResult_ROW($hc, $tmp_fdata, $i);
				for($j = 0; $j < $cols; $j++) {
	 			  	$dcb->setFdata($tmp_fdata[$j], $i, $j );
					//$fdata[$i][$j] = $tmp_fdata[$j];
				}
				//echo $fdata[$i][1] . "<br>";
				//echo "==================================<br>";
			}
		}
		$dcb->setTotal($total);
		$dcb->setRows($rows);
      		$dcb->setCols($cols);
      		$dcb->setRowIds($rowIds);		
        	$dcb->setScores($scores);
		
		$crz->DestroyHandle($hc);
    } 
    return $dcb;
}


/**
 * 오타 교정 (한->영, 영->한)
 * @param kwd
 *
 * @return corrected kwd
 * @throws IOException
 * @throws KonanException
 **/
function getCorrectedKwd($kwd){
    $temp = $kwd;
    if(strlen($kwd) == 0) return $temp;
    
    $maxOutCount = 20;
    $crz = new DOCRUZER;
    $hc = $crz->CreateHandle();
    $rc = $crz->SpellCheck(
                $hc,
                DAEMON_SERVICE_ADDRESS,
                $outCount,
                $outWord,
                $maxOutCount, $kwd );
    
    if($rc < 0){
        echo "msg : ".$crz->GetErrorMessage($hc)."\n";
        exit;
    } else {
        for($i=0; $i<$outCount; ++$i) {
            //echo "    [".$i."] ".$out_word[$i]."\n";
            if(strlen($outWord[$i])>0){
                $temp = $outWord[$i];
                break;
            }
        }
    }
    $crz->DestroyHandle($crzClient);
    return $temp;
}

/** 인기검색어 ( 순위정보 있음 ).
 *
 * @param doaminNo 도메인(사전)번호
 * @param count 가져올 개수
 *
 * @return ArrayList
 * @throws Exception
 */
function getPopularKwdAndTag($domainNo, $count)
{
    $nOutCount = 0;
    $maxOutCount = 10;
	
    if ($count != 0) {
    	$maxOutCount = $count;
    } 
    
    $crz = new DOCRUZER;
    $hc = $crz->CreateHandle();
  
    $outStr = NULL;
    $rc = $crz->GetPopularKeyword2(
    	$hc, 
    	DAEMON_SERVICE_ADDRESS, 
    	$outCount, 
    	$outStr, 
    	$outTag, 
    	$maxOutCount, 
    	$domainNo
    );
	
    if($rc < 0)
    {
        echo "msg : '".$crz->GetErrorMessage($hc)."'<BR>\n";
        //echo "rc : " . $rc;
        exit;
    } else {
    	for($i=0; $i<$outCount; $i++) {
    		$arrPpk[$i][0] = $outStr[$i];
    		$arrPpk[$i][1] = $outTag[$i];
    	}
    }
    $crz->DestroyHandle($hc);
    
	return $arrPpk;
}

/** 추천 검색어
 *
 * @param kwd 키워드
 * @param doaminNo 도메인(사전)번호
 * @param count 가져올 최대 개수
 *
 * @return ArrayList 추천어 배열
 * @throws Exception
 */
function getRecommendKwd($kwd, $domainNo, $count)
{
	$crz = new DOCRUZER;
	
	$hc = $crz->CreateHandle();
	$nOutCount = 0;
    	$maxOutCount = 10;
	
	if ($count != 0) {
    		$maxOutCount = $count;
    	} 
    
    	$outStr = NULL;
    		
	$rc = $crz->RecommendKeyword(
            $hc,
	    DAEMON_SERVICE_ADDRESS,
            $outCount, 
            $outStr, 
            $maxOutCount, 
            $kwd, 
            $domainNo
    	);
	
	if($rc < 0)
    	{
        	echo "msg : '".$crz->GetErrorMessage($hc)."'<BR>\n";
        	exit;
	} else {
    		for($i=0; $i<$outCount; $i++) {
			$arrKre[$i] = $outStr[$i];
		}
    	}
    	
	$crz->DestroyHandle($hc);
	return $arrKre;
}

?>
