<?php
/** ����  ��ƿ. 
 * 
 * @author KONAN Technology
 * @since 2010.01.21
 * @version 1.0
 */


	/** �Է¹��� ���ڿ�Ư�����ڸ� html format���� ��ȯ.
	 *	@param str ��ȯ�� ���ڿ�
	 *	@return ��ȯ�� ���ڿ�
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
	
	
	/** YYYYMMDD ������ ���ڿ��� �Է¹޾� ������ �����ڸ� ����Ͽ� YYYY.MM.DD �������� ��ȯ.
	 *	@param str ��ȯ�� ���ڿ�
	 *	@param delimeter ������	
	 *	@return ��ȯ�� ���ڿ�
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
	 * ���ڿ��� null���� Ȯ���Ͽ� null�� ��� ��ü���ڿ��� ����
	 * @param org - Ȯ���� ���ڿ��ʵ�
	 * @param converted - ��ü�� ���ڿ�
	 * �ۼ���: 2006-11-22
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
	 * ���ڰ� null���� Ȯ���Ͽ� null�� ��� ��ü ���ڸ� ����
	 * @param org - Ȯ���� �����ʵ�
	 * @param converted - ��ü�� ���ڰ�
	 * �ۼ���: 2006-11-22
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
	 * ���ڿ��� �� ��쿡 �Է¹��� ���ڱ��̷� �ڸ���.
	 *	@param str ��ȯ�� ���ڿ�
	 *	@param cutLen ��Ʈ�� ����
	 *	@param tail tail��Ʈ��
	 *	@return ��ȯ�� ���ڿ�
	 */
	function getCutString($str, $cutLen, $tail) 
	{
		$str=strip_tags($str); 
		$count = mb_strlen($str); 
		$cutLen*=2; 
	
		if($cutLen >= $count)
			// --enable-mbstring=kr �ɼ��� ��츸 ��� ���� 
			$str=mb_strcut($str,0,$cutLen,"UTF-8"); 
		else
			$str=mb_strcut($str,0,$cutLen,"UTF-8").$tail;
	
		return $str;
	}
	
	/** ��Ʈ�� ���ڿ��� ������  ###,### ���� ��ȯ�Ͽ� ������.
	 * @param str ���ڹ��ڿ�
	 * @return ��ȯ�� ���ڿ�
	 */
	function formatMoney ($str)
	{
		return Number_Format($str);
	}
	
	/** ���ڿ��� ���ڵ��� ��ȯ�Ͽ� ������.
	 * 
	 * @param str : ���ڵ� ��ȯ�� ��Ʈ��
	 * @param myEnc : ���� ���ڵ�
	 * @param targetEnc : Ÿ�� ���ڵ�
	 * @return ��ȯ�� ���ڿ� 
	 */
	function changeEncode ($str, $myEnc, $targetEnc)
	{
		return mb_convert_encoding($str, $myEnc , $targetEnc); 
	
	}
	
	/** ���� ��¥�κ��� Ư�� �Ⱓ ��, �� ��¥ ���Ͽ� ��ȯ��. 
	 * 
	 * @param iDay ����κ��� ���ϰ��� �ϴ� ��¥ �� int (���� : ����, �̷� : ���)
	 * @return date �� ���ڿ� 
	 */
	function getTargetDate($iDay)
	{
		return date("Ymd", strtotime("$iDay day"));
		//echo "date : " . date_add(date(), 1 day);
	
	}
	
	/** �����˻��� ���� �±� ���� �� ��ȯ.
	 * 
	 * @param srchParam ParameterVO ������Ʈ
	 * @return ���� �˻��� �±� ���ڿ�
	 */
	function makeHtmlForPreKwd($srchParam) 
	{
		$preKwdStr = "<input type='hidden' name='preKwd[0]' value=\"" . $srchParam->getKwd() . "\">\n";
		//$preKwdStr = "<input type='hidden' name='preKwd[0]' value='".$srchParam->getKwd()."'>\n";
		//echo $preKwdStr;
	
		if ($srchParam->getResrchFlag()=="true" or $srchParam->getResrchFlag()=="on") {
			//echo "<br>ddd222";
			$reSrchCnt = 1;
			
			if ($srchParam->getPreKwds() != null) {
				
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
	
	/** target���� �񱳰��� ���� ��� Ư�� ���� ����.
	 *	@param target ���
	 *	@param str �񱳰�
	 *	@param trueVal target ���� �񱳰��� ������ ��� ���ϰ� 
	 *   @param falseVal target ���� �񱳰��� �������� ���� ��� ���ϰ�
	 *	@return trueVal or falseVal ��
	 */
	function makeReturnValue($target, $str, $trueVal, $falseVal) {
		if ($target == $str) {
			return $trueVal;
		} else {
			return $falseVal;
		}
	}
	
	/** ÷�����ϸ� ����  �̹��� ���ϸ��� ������. 
	 * @param fileName ���ϸ� 
	 * @return �̹��� ���ϸ�
	 */
	function getAttachFileImage($fileName) {
		//array_pop : array�� ������ ���� �̾� ���� �� ���� ��ȯ
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
	 * ���ڿ� ġȯ�Լ�
	 * @param str - 
	 * �ۼ���: 2006-11-29
	 */
	function getStringReplace($txt,$src_ptn,$tar_ptn)
	{
	    $match_cnt = preg_match_all("/$src_ptn/i",$txt,$out);
	    $txt = preg_replace("/$src_ptn/i", "$tar_ptn", $txt, $match_cnt);
	    return $txt;
	}

?>
