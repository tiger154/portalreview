<?php

define("DAEMON_SERVICE_IP", $serverInfo['DAEMON_SERVICE_IP'][0]['value']);
define("DAEMON_SERVICE_PORT", $serverInfo['DAEMON_SERVICE_PORT'][0]['value']);
define("DAEMON_SERVICE_ADDRESS", $serverInfo['DAEMON_SERVICE_ADDRESS'][0]['value']);

require(_DIR_EXTENDS."/php.Search_Conan/lib/CrxClient.php");


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
 * 오타교정 
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
                	$maxOutCount,$kwd);
	
	if($rc < 0){
        	echo "msg : ".$crz->GetErrorMessage($hc)."\n";
        	exit;
    	} else {
		for($i=0; $i<=$outCount; ++$i) {
		//echo "[".$i."] ".$outWord[$i]."\n";	
			$len = strlen($outWord[$i]);	
			if($len>0){
				$temp = $outWord[$i];
                		break;
            		}else{
				$temp = '';
			}
        	}
    	}
	
	$crz->DestroyHandle($crzClient);
	
	return $temp;

}

/**
 * 오타교정  CRX 용
 * @param kwd
 *
 * @return corrected kwd
 * @throws IOException
 * @throws KonanException
 **/
function getCorrectedKwd_CRX($kwd){

	$rc = crx_connect($hd, "121.189.18.89:7577", "konan", "konan", "");

	if ($rc<0) {
		echo "error : ".crx_get_error_message($hd)."\n";
		crx_disconnect($hd);
		exit;
	} else {
		$request_name = "SPELL_CHECK";
		$request_family = "SPC";

		$rc = crx_clear_request($hd);
		if ($rc<0) {
		echo "error clear : ".crx_get_error_message($hd)."\n";
		crx_disconnect($hd);
		exit;
		}

		$rc = crx_put_request_name($hd, $request_name);
		if ($rc<0) {
		echo "error name : ".crx_get_error_message($hd)."\n";
		crx_disconnect($hd);
		exit;
		}

		crx_put_request_family($hd, $request_family);
		crx_put_request_param($hd, "INPUT_WORD", "CHAR", 1, $kwd);
		crx_put_request_param($hd, "LANGUAGE", "INT32", 1, 1);
		crx_put_request_param($hd, "CHARSET", "INT32", 1, 4);

		$rc = crx_submit_request($hd);		//	 이부분 에러난다..
		$rc = crx_receive_response($hd);

	}

/*
$rc_crx = crx_connect($hd_crx, "121.189.18.89:7577", "konan", "konan", "");

if ($rc_crx<0) {
	echo "error : ".crx_get_error_message($hd_crx)."\n";
	crx_disconnect($hd_crx);
	exit;
} else {
	$request_name = "SPELL_CHECK";
	$request_family = "SPC";

	$rc_crx = crx_clear_request($hd_crx);
	$rc_crx = crx_put_request_name($hd_crx, $request_name);

	$strKwd =	$srchParam->getKwd();
	//$strKwd = iconv('euc-kr','utf-8',$srchParam->getKwd());

	//echo "@@@".$strKwd."<br>";

	crx_put_request_family($hd_crx, $request_family);
	crx_put_request_param($hd_crx, "INPUT_WORD", "CHAR", 2, $strKwd);
	crx_put_request_param($hd_crx, "LANGUAGE", "INT32", 1, 1);
	crx_put_request_param($hd_crx, "CHARSET", "INT32", 1, 4);

	$rc_crx = crx_submit_request($hd_crx);
	

	//$rc_crx = crx_receive_response($hd_crx);

//	crx_disconnect($hd_crx);

	//echo "count:".$crx_param_count."<br>";
}
*/

	
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

