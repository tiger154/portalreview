<?php
class Code
{
	public function Code()
	{
	}
	
	public function isCate($db, $cate)
	{
		$length = sizeof($cate);
		if($length < 1) return false;
		$where = "";
		for($i=0; $i<$length; $i++) {
			$where .= " AND cate".($i+1)." = '".$cate[$i]."'";
		}	
		$sql = "
		SELECT			COUNT(cate_desc) as cnt   
		FROM			Rf_cate".$length."_code 
		WHERE			1 
		".$where."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}		
	}

	public function getCateDesc($db, $cate)
	{
		$length = sizeof($cate);
		$where = "";
		if($length > 0) {
			for($i=0; $i<$length; $i++) {
				$where .= " AND cate".($i+1)." = '".$cate[$i]."'";
			}	
			$sql = "
			SELECT			cate_desc 
			FROM			Rf_cate".$length."_code 
			WHERE			1 
			".$where."
			";
			//echo $sql;
			$row = $db->fetch($sql, true);
			return $row['cate_desc'];
		} else {
			return "";
		}
	}
	
	public function transCate($cate) 
	{
		if(is_string($cate)) {
			$arr = array();
			$cate = trim($cate);
			$length = strlen($cate);
			if($length >= 2) $arr[] = substr($cate, 0, 2);
			if($length >= 5) $arr[] = substr($cate, 2, 3);
			if($length >= 8) $arr[] = substr($cate, 5, 3);
			if($length >= 11) $arr[] = substr($cate, 8, 3);
			if($length >= 14) $arr[] = substr($cate, 11, 3);
			if($length >= 17) $arr[] = substr($cate, 14, 3);
			return $arr;
		} 
		if(is_array($cate)) {
			$str = "";
			foreach($cate as $key => $val) {
				$str .= $val;
			}
			$str = trim($str);
			return $str;
		}
	}
	
	public function transCateArray($cate1="", $cate2="", $cate3="", $cate4="", $cate5="", $cate6="")
	{
		$cate = array();		
		if(!empty($cate1) && $cate1 != "") $cate[] = $cate1; else return $cate;
		if(!empty($cate2) && $cate2 != "") $cate[] = $cate2; else return $cate;
		if(!empty($cate3) && $cate3 != "") $cate[] = $cate3; else return $cate;
		if(!empty($cate4) && $cate4 != "") $cate[] = $cate4; else return $cate;
		if(!empty($cate5) && $cate5 != "") $cate[] = $cate5; else return $cate;
		if(!empty($cate6) && $cate6 != "") $cate[] = $cate6; else return $cate;
	}
	
	public function getCate1List($db)
	{
		$sql = "
		SELECT			cate1, cate_desc
		FROM			Rf_cate1_code
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}	

	public function getCate2List($db, $cate1)
	{
		$sql = "
		SELECT			cate2, cate_desc
		FROM			Rf_cate2_code
		WHERE			cate1 = '$cate1'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}	

	public function getCate3List($db, $cate1, $cate2)
	{
		$sql = "
		SELECT			cate3, cate_desc		
		FROM			Rf_cate3_code		
		WHERE			cate1 = '$cate1' 
		AND				cate2 = '$cate2'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getCate4List($db, $cate1, $cate2, $cate3)
	{
		$sql = "
		SELECT			cate4, cate_desc
		FROM			Rf_cate4_code
		WHERE			cate1 = '$cate1' 		
		AND				cate2 = '$cate2'		
		AND				cate3 = '$cate3'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function isArea($db, $area)
	{
		$length = sizeof($area);
		$where = "";
		if($length < 1) return false;
		switch($length) {
			case 2 : 
				$table = "mcode";
				$where = " AND bcode = '".$area[0]."' AND mcode = '".$area[1]."'";
				break;
			case 3 : 
				$table = "scode";
				$where = " AND bcode = '".$area[0]."' AND mcode = '".$area[1]."' AND scode = '".$area[2]."'"; 
				break;
			case 1 :
			default : 
				$table = "bcode"; 
				$where = " AND bcode = '".$area[0]."'"; 
				break;
		}
		$sql = "
		SELECT			COUNT(*) as cnt   
		FROM			Rf_area_".$table." 
		WHERE			1
		".$where."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAreaDesc($db, $area)
	{
		$length = sizeof($area);
		$desc = "";
		if($length > 0) {			
			for($i=0; $i<$length; $i++) {
				if($i == 0) {
					$sql = "
					SELECT			ko_desc 
					FROM			Rf_area_bcode  
					WHERE			bcode = '".$area[0]."'
					";
					//echo $sql;
					$row = $db->fetch($sql, true);
					$desc .= $row['ko_desc'];
				}
				if($i == 1) {
					$sql = "
					SELECT			ko_desc 
					FROM			Rf_area_mcode  
					WHERE			mcode = '".$area[1]."'
					";
					//echo $sql;
					$row = $db->fetch($sql, true);
					$desc .= " ".$row['ko_desc'];
				}
				if($i == 2) {
					$sql = "
					SELECT			ko_desc 
					FROM			Rf_area_scode  
					WHERE			scode = '".$area[2]."'
					";
					//echo $sql;
					$row = $db->fetch($sql, true);
					$desc .= " ".$row['ko_desc'];
				}
			}
			return $desc;
		} else {
			return "";
		}
	}
	
	public function getBcodeList($db)
	{
		$sql = "
		SELECT			bcode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_bcode
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}	                 
                 
	public function getMcodeList($db, $bcode)
	{
		$sql = "
		SELECT			bcode, mcode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_mcode
		WHERE			bcode = '$bcode'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}	

	public function getScodeList($db, $bcode, $mcode)
	{
		$sql = "
		SELECT			bcode, mcode, scode, ko_desc, en_desc, ch_desc 
		FROM			Rf_area_scode		
		WHERE			bcode = '$bcode' 
		AND				mcode = '$mcode'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function transArea($area) 
	{
		if(is_string($area)) {
			$arr = array();
			$area = trim($area);
			$length = strlen($area);
			if($length >= 2) $arr[] = substr($area, 0, 2);
			if($length >= 5) $arr[] = substr($area, 2, 3);
			if($length >= 8) $arr[] = substr($area, 5, 3);
			return $arr;
		} 
		if(is_array($area)) {
			$str = "";
			foreach($area as $key => $val) {
				$str .= $val;
			}
			$str = trim($str);
			return $str;
		}
	}
	
	public function getSecedeType($db, $state)
	{
		$sql = "
		SELECT			state_explain 
		FROM			Rf_account_secede_type 
		WHERE			state = '".$state."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getSecedeTypeList($db)
	{
		$sql = "
		SELECT			state, state_explain 
		FROM			Rf_account_secede_type
		ORDER BY		state DESC
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getCashType($db, $state)
	{
		$sql = "
		SELECT			state_explain, state_old 
		FROM			Rf_cash_type
		WHERE			state = '".$state."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getCashTypeList($db)
	{
		$sql = "
		SELECT			state, state_explain, state_old 
		FROM			Rf_cash_type
		ORDER BY		state DESC
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getPointType($db, $state)
	{
		$sql = "
		SELECT			state_explain, state_old 
		FROM			Rf_point_type
		WHERE			state = '".$state."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getPointTypeList($db)
	{
		$sql = "
		SELECT			state, state_explain, value, state_old 
		FROM			Rf_point_type
		ORDER BY		state DESC
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getBankCode($db, $code)
	{
		$sql = "
		SELECT			code, code_desc  
		FROM			Rf_bank_code 
		WHERE 			code = '".$code."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getBankCodeList($db)
	{
		$sql = "
		SELECT			code, code_desc  
		FROM			Rf_bank_code 
		ORDER BY		code ASC 
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
}