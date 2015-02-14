<?php

	/** 검색어에 대한 escape 처리
	* @param kwd 검색어
	* @return escape된 검색어	
	*/
	
        function escapeQuery( $kwd )
        {
            $ret = "";
            for( $i=0; $i<strlen($kwd); $i++ )
            {
                $c = $kwd[$i];
                switch( $c ) {
                    case "\\":  $ret = $ret . "\\\\"; break;
                    case "'" :  $ret = $ret . "\'"; break;
                    case "\"":  $ret = $ret . "\""; break;
                    case "*" :  $ret = $ret . "\*"; break;
                                case "?" :  $ret = $ret . "\?"; break;
                    default:     $ret = $ret . $c; break;
                }
            }
            return $ret;
        }

	/** 검색엔진 로그정보 로그포맷
	* <br> [클래스+사용자ID$|첫검색|페이지번호|정렬방법^키워드]##이전검색어|현재검색어]
	* @param site 사이트명
	* @param nmSchCat 카테고리명
	* @param userId 사용자ID
	* @param kwd 키워드
	* @param pageNum 페이지번호
	* @param reSchFlag 재검색여부(true/false)
	* @param orderNm 정렬방법
	* @param recKwd 추천검색어('이전검색어|현재검색어')
	* @return 검색 로그 String
	*/

        function getLogInfo($site, $nmSchCat, $userId, $kwd, $pageNum, $reSchFlag, $orderNm, $recKwd)
        {
            $reSchFlag = (($reSchFlag == "true") ? "재검색" : "첫검색");

            $logInfo = "";

            if ($pageNum == "1"){
                $logInfo = $site . "@" . $nmSchCat . "+" . $userId . "$|" . $reSchFlag . "|1|";
            }else{
                $logInfo = $site . "@" . $nmSchCat . "+" . $userId . "$||" . $pageNum . "|" ;
            }

                $logInfo = $logInfo . $orderNm. "^" . escapeQuery($kwd) . "##" . $recKwd;

            return $logInfo;
        }

	/** 키워드/코드형식쿼리 생성. 
     	*
     	* @param nmFd 검색대상 필드명 또는 인덱스명
     	* @param kwd 검색어
     	* @param schMethod 검색메소드
     	* @param query 쿼리 String 
     	* @param logicOp 연결 논리연산자 (ex : and, or, and not) 
     	*
     	* @return 쿼리 StringBuffer
     	*/
	
	function makeQuery($nmFd, $kwd, $schMethod, $query, $logicOp)
	{
		if (strlen($query) > 0) {
			$tempQuery = " (" . $query . ") ";
		}
		
		if (strlen($kwd) > 0) {
			if (strlen($tempQuery) > 0) {
				$tempQuery = $tempQuery . " " . $logicOp . " ";
			}
			$tempQuery = $tempQuery . $nmFd . "='" . escapeQuery($kwd) . "' " . $schMethod;
		}
		
		return $tempQuery;
	}
	
	/** 확장형 쿼리 생성.
	*
	* @param nmFd 검색대상 필드명 또는 인덱스명
	* @param op 연산자 (ex : =, >, <) 
	* @param kwd 키워드
	* @param query 쿼리 StringBuffer
	* @param logicOp 논리연산자 (ex : and, or, and not)
	* @param isText 형태소 검색 여부 (default y)
	* @param srchMethod 검색 메소드 
	*
	* @return 검색쿼리 StringBuffer
	*/
	
	function makeExpressionQuery($nmFd, $op, $kwd, $isText, $schMethod, $logicOp, $query)
	{
		if (strlen($query) > 0) {
			$tempQuery = " (" . $query . ") ";
		}
		
		if (strlen($kwd) > 0) {
			if (strlen($tempQuery) > 0) {
				$tempQuery = $tempQuery . " " . $logicOp . " ";
			}
			
			$tempQuery = $tempQuery . $nmFd . $op . "'" . escapeQuery($kwd) . "' ";
			
			if (strtolower($isText) == "true") {
				$tempQuery = $tempQuery . $schMethod;
			}
		}
		
		return $tempQuery;
	}
	
	/** Like 쿼리 생성.
  	 * 
  	 * @param nmFd 검색대상 필드명 또는 인덱스명
  	 * @param kwd 키워드
  	 * @param query 이전 생성 쿼리
  	 * @param option 좌절단 : left, 우절단 : right, 좌우절단 : all
  	 * 
  	 * @return 검색쿼리 StringBuffer
  	 */
	
	function makeLikeQuery($nmFd, $kwd, $option, $query)
	{
		if (strlen($query) > 0) {
			$tempQuery = " (" . $query . ") ";
		}
		
		if (strlen($kwd) > 0) {
			if (strlen($tempQuery) > 0) {
				$tempQuery = $tempQuery . " and ";
			}
			
			$tempQuery = $tempQuery . $nmFd . " like '";
			
			if (strtolower($option) == "all" or strtolower($option) == "left") {
				$tempQuery = $tempQuery . "*";
			} 
			$tempQuery = $tempQuery . escapeQuery($kwd);
			
			if (strtolower($option) == "all" or strtolower($option) == "right") {
				$tempQuery = $tempQuery . "*";
			} 
			$tempQuery = $tempQuery . "'";
		}
		
		return $tempQuery;	
	}
	
	/** IN쿼리 생성.
     	*
     	* @param nmFd 검색대상 필드명 또는 인덱스명
     	* @param code 조회 대상 코드 값
     	* @param isNumber code 값이 숫자값인지 여부 (true : 숫자, false : 문자)
     	* @param query 이전생성 쿼리
     	* @return 검색쿼리 StringBuffer
     	*/
	
	function makeINQuery($nmFd, $code, $isNumber, $query)
	{
		if (strlen($query) > 0) {
			$tempQuery = " (" . $query . ") ";
		}
		
		$i = 0;
		foreach($code as $codeArray) {
			$i++;
			if (strtolower($isNumber) =="true") {
				$inQuery = $inQuery . "'" . $codeArray . "'";
			} else {
				$inQuery = $inQuery . $codeArray ;
			}
			
			if ($i < count($code)) {
				$inQuery = $inQuery . ", ";
			}
		}
		
		if (strlen($inQuery) > 0 and strlen($tempQuery) > 0) {
			$tempQuery = $tempQuery . " AND " . $nmFd . " IN {" . $inQuery . "}";
		} else if (strlen($inQuery) > 0 and strlen($tempQuery) <= 0) {
			$tempQuery = $nmFd . " IN {" . $inQuery . "}";
		}
		
		return $tempQuery;
	}
	
	/** 구간검색 쿼리 생성.
	* 
	* @param nmFd 검색대상 필드명 또는 인덱스명
	* @param startVal 시작값
	* @param endVal 종료값 
	* @param query 이전 생성 쿼리
	* @return 검색 쿼리 StringBuffer
	*/
	
	function makeRangeQuery($nmFd, $startVal, $endVal, $query)
	{
		if (strlen($startVal) > 0) {
			$tempQuery = $tempQuery . " " . $nmFd . ">='" . $startVal . "'";
		}
		
		if (strlen($endVal) > 0) {
			if (strlen($startVal) > 0) {
				$tempQuery = $tempQuery . " AND " ;
			}
			$tempQuery = $tempQuery . " " . $nmFd . "<='" . $endVal . "'";
		}
		
		if (strlen($startVal)>0 and strlen($endVal)>0 and strlen($query)>0) {
			$tempQuery = "(" . $tempQuery . ")";
		}
		
		
		if (strlen($query)>0 and strlen($tempQuery) > 0) {
			$tempQuery = "(" . $query . ") AND " . $tempQuery;
		} else if (strlen($query) > 0 and strlen($tempQuery) <= 0) {
			$tempQuery = $query;
		}
		
		return $tempQuery;
	}
	
	/** 재검색 쿼리 생성. 
	* 
	* @param nmFd 검색대상 필드명 또는 인덱스명
	* @param kwd 키워드
	* @param prevKwd 이전 키워드 배열
	* @param prevKwdLength 이전 키워드 배열 길이
	* @param schMethod 검색 메소드
	* 
	* @return 검색 쿼리 StringBuffer
	*/

	function makePreQuery($nmFd, $kwd, $prevKwd, $prevKwdLength, $schMethod)
	{
		$i = 0;
		if ( count($prevKwd) > 0 and $prevKwdLength > 0 ) {
	
			if ($prevKwd[0] == $kwd and $prevKwdLength > 0) {
				$i = 1;
			}
			
			foreach($prevKwd as $prevKwdArray) {
				if (strlen($tempQuery) > 0) {
					$tempQuery = $tempQuery . " AND ";
				}
				$tempQuery = $tempQuery . $nmFd . " = '" . escapeQuery($prevKwdArray) . "' " . $schMethod;
				$i++;
				
			}
			/*		
			if (strlen($tempQuery) > 0)  {
				//$tempQuery = " AND (" . $tempQuery . ") ";
				$tempQuery = " (" . $tempQuery . ") ";
			}
			*/
		}
		return $tempQuery;
	}
	
	/** 가격 구간검색 쿼리 생성.
	* 
	* @param attrName 속성명
	* @param opNum 옵션값
	* @param value 조건값
	* @return String	
	*/
	
	function getSectionQuery($attrName, $opNum, $value)
	{
		if ($attrName == "PRICE") {
			$op = "PRICE";
			$vl = $value;
			
			if ($opNum == "0") {
				$op = "";
			} else if($opNum == "1") {
				$op = "=";
			} else if($opNum == "2") {
				$op = "<";
			} else if($opNum == "3") {
				$op = "<=";
			} else if($opNum == "4") {
				$op = ">";
			} else if($opNum == "5") {
				$op = ">=";
			}
			$op = $op . $vl;
		}
		
		return $op;
	}

?>
