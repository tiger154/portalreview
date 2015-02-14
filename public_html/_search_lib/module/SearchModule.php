<?php

define("DAEMON_SERVICE_IP", $serverInfo['DAEMON_SERVICE_IP'][0]['value']);
define("DAEMON_SERVICE_PORT", $serverInfo['DAEMON_SERVICE_PORT'][0]['value']);
define("DAEMON_SERVICE_ADDRESS", $serverInfo['DAEMON_SERVICE_ADDRESS'][0]['value']);


/** ���� �˻��� ó���ϴ� �޼ҵ� (SubmitQuery)
 * @param scn �ó�����
 * @param query �˻�����
 * @param logInfo �α�����
 * @param hilightTxt ���̶���Ʈ Ű����
 * @param orderBy ������
 * @param pageNum ��������ȣ
 * @param pageSize ������������
 * @param flag rowid ��� ���� �÷���
 * @param dcb ������� ���� bean
 * @param nLanguage ����
 * @param nCharset ĳ���ͼ�
 * @return �����(int)
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


/** ���� �˻��� ó���ϴ� �޼ҵ� (Search-�л꺼��, String List GroupBy)
 * @param scn �ó�����
 * @param query �˻�����
 * @param logInfo �α�����
 * @param hilightTxt ���̶���Ʈ Ű����
 * @param orderBy ������
 * @param pageNum ��������ȣ
 * @param pageSize ������������
 * @param flag rowid ��� ���� �÷���
 * @param dcb ������� ���� bean
 * @param nLanguage ����
 * @param nCharset ĳ���ͼ�
 * @return �����(int)
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
    
    //���� ��ġ ����
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
 * ��Ÿ ���� (��->��, ��->��)
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

/** �α�˻��� ( �������� ���� ).
 *
 * @param doaminNo ������(����)��ȣ
 * @param count ������ ����
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

/** ��õ �˻���
 *
 * @param kwd Ű����
 * @param doaminNo ������(����)��ȣ
 * @param count ������ �ִ� ����
 *
 * @return ArrayList ��õ�� �迭
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
