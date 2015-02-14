<?
 /** 공통유틸.
 * @author KONAN Technology
 * @since 2010.01.21
 * @version 1.0
 */


	/** 입력받은 문자열특수문자를 html format으로 변환.
	 *	@param str 변환할 문자열
	 *	@return 변환된 문자열
	 */
	function formatHtml( $str )
	{
	    $ret = "";
	    for( $i=0; $i<strlen($str); $i++ )
	    {
	        $c = $str[$i];
	        switch( $c ) {
	            case "<":  $ret = $ret . "&lt;"; break;
	            case ">" :  $ret = $ret . "&gt;"; break;
				case "&" :  $ret = $ret . "&amp;"; break;
				case "\"" :  $ret = $ret . "quot;"; break;
				case "\'" :  $ret = $ret . "\\\'"; break;
	            case "\n" :  $ret = $ret . "<br>\n"; break;
				//case "\r":  $ret = $ret . "\""; break;
	            default:     $ret = $ret . $c; break;
	        }
	    }
	    return $ret;
	}
	
	
	/** YYYYMMDD 포멧의 문자열을 입력받아 정의한 구분자를 사용하여 YYYY.MM.DD 포멧으로 변환.
	 *	@param str 변환할 문자열
	 *	@param delimeter 구분자	
	 *	@return 변환된 문자열
	 */
	function formatDateStr( $str , $delimeter)
	{
		if( strlen($str) < 8 ) {
			return $str;
		} else { 
			//$yy = substr($str,0,4);
			//$mm = substr($str,4,2);
			//$dd = substr($str,6,2);
	
			$ret = substr($str,0,4) . $delimeter . substr($str,4,2) . $delimeter . substr($str,6,2);
			return $ret;
		}
	}
	
	/********************************************************
	 * 문자열이 null인지 확인하여 null일 경우 대체문자열을 리턴
	 * @param org - 확인할 문자열필드
	 * @param converted - 대체할 문자열
	 * 작성일: 2006-11-22
	 ********************************************************/
	function null2str($org, $converted) 
	{
		if (strlen($org) == 0) {
			return $converted;
		} else {
			return $org;
		}
	}
	
	/********************************************************
	 * 숫자가 null인지 확인하여 null일 경우 대체 숫자를 리턴
	 * @param org - 확인할 숫자필드
	 * @param converted - 대체할 숫자값
	 * 작성일: 2006-11-22
	 ********************************************************/
	function null2int($org, $converted) 
	{
		if (strlen($org) == 0) {
			return $converted;
		} else {
			return $org;
		}
	}
	
	/**
	 * 문자열이 긴 경우에 입력받은 문자길이로 자른다.
	 *	@param str 변환할 문자열
	 *	@param cutLen 스트링 길이
	 *	@param tail tail스트링
	 *	@return 변환된 문자열
	 */
	function getCutString($str, $cutLen, $tail) 
	{
		$str=strip_tags($str); 
		$count = mb_strlen($str); 
		$cutLen*=2; 
	
		if($cutLen >= $count)
			// --enable-mbstring=kr 옵션일 경우만 사용 가능 
			$str=mb_strcut($str,0,$cutLen,"UTF-8"); 
		else
			$str=mb_strcut($str,0,$cutLen,"UTF-8").$tail;
	
		return $str;
	}
	
	/** 스트링 숫자열의 포맷을  ###,### 으로 변환하여 리턴함.
	 * @param str 숫자문자열
	 * @return 변환된 문자열
	 */
	function formatMoney ($str)
	{
		return Number_Format($str);
	}
	
	/** 문자열의 인코딩을 변환하여 리턴함.
	 * 
	 * @param str : 인코딩 변환할 스트링
	 * @param myEnc : 현재 인코딩
	 * @param targetEnc : 타겟 인코딩
	 * @return 변환된 문자열 
	 */
	function changeEncode ($str, $myEnc, $targetEnc)
	{
		return mb_convert_encoding($str, $myEnc , $targetEnc); 
	
	}
	
	/** 현재 날짜로부터 특정 기간 전, 후 날짜 구하여 반환함. 
	 * 
	 * @param iDay 현재로부터 구하고자 하는 날짜 수 int (과거 : 음수, 미래 : 양수)
	 * @return date 값 문자열 
	 */
	function getTargetDate($iDay)
	{
		return date("Ymd", strtotime("$iDay day"));
		//echo "date : " . date_add(date(), 1 day);
	
	}
	
	/** 이전검색어 히든 태그 생성 후 반환.
	 * 
	 * @param srchParam ParameterVO 오브젝트
	 * @return 이전 검색어 태그 문자열
	 */
	function makeHtmlForPreKwd($srchParam) 
	{
		//echo "ddd";
		$preKwdStr = "<input type='hidden' name='preKwd[0]' value=\"" . $srchParam->getKwd() . "\">\n";
		if ($srchParam->getResrchFlag()=="true" or $srchParam->getResrchFlag()=="on") {
			//echo "<br>ddd222";
			$reSrchCnt = 1;
			
			if ($srchParam->getPreKwds() != null) {
				//echo "<br>ddd333";	
				foreach ($srchParam->getPreKwds() as $item) {
					if ($item == $srchParam->getKwd()) {
						continue;
					}
					//echo "===" . $preKwdStr . "<input type='hidden' name='preKwd[" . $reSrchCnt. "]' value=\"" . $item . "\">\n";
					$preKwdStr = $preKwdStr . "<input type='hidden' name='preKwd[" . $reSrchCnt. "]' value=\"" . $item . "\">\n";
					$reSrchCnt++;
				}
			}
		}
		return $preKwdStr;
	}
	
	/** target값과 비교값이 같을 경우 특정 값을 리턴.
	 *	@param target 대상값
	 *	@param str 비교값
	 *	@param trueVal target 값과 비교값이 동일할 경우 리턴값 
	 *   @param falseVal target 값과 비교값이 동일하지 않을 경우 리턴값
	 *	@return trueVal or falseVal 값
	 */
	function makeReturnValue($target, $str, $trueVal, $falseVal) {
		if ($target == $str) {
			return $trueVal;
		} else {
			return $falseVal;
		}
	}
	
	/** 첨부파일명에 따른  이미지 파일명을 리턴함. 
	 * @param fileName 파일명 
	 * @return 이미지 파일명
	 */
	function getAttachFileImage($fileName) {
		//array_pop : array의 마지막 값을 뽑아 내고 그 값을 반환
		$fileExt=array_pop(explode(".",$fileName)); 
		
		if ($fileExt == "doc" || $fileExt == "docx") {
	    	$imgFile = "ico_doc.gif";
	    } else if ($fileExt == "ppt" || $fileExt == "pptx") {
	    	$imgFile = "ico_ppt.gif";
	    } else if ($fileExt == "xls" || $fileExt == "xlsx") {
	    	$imgFile = "ico_xls.gif";
	    } else if ($fileExt == "hwp") {
	    	$imgFile = "ico_hwp.gif";
	    } else if ($fileExt == "zip" || $fileExt == "gzip" 
	    		|| $fileExt == "tar" || $fileExt == "azip" || $fileExt == "bzip") {
	    	$imgFile = "ico_zip.gif";
	    } else if ($fileExt == "pdf") {
	    	$imgFile = "ico_pdf.gif";
	    } else {
	    	$imgFile = "ico_etc.gif";
	    }
	    	
	    return $imgFile;
	}
	
	
	function selectFromDB() 
	{
	}
	
	/**
	 * 문자열 치환함수
	 * @param str - 
	 * 작성일: 2006-11-29
	 */
	function getStringReplace($txt,$src_ptn,$tar_ptn)
	{
	    $match_cnt = preg_match_all("/$src_ptn/i",$txt,$out);
	    $txt = preg_replace("/$src_ptn/i", "$tar_ptn", $txt, $match_cnt);
	    return $txt;
	}

?>
