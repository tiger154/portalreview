<?php
class Cash 
{
	var $flag_sign;
	var $attach_type;
	var $attach_type1;
	var $attach_type2;
	var $flag_pay;
		
	public function Cash() 
	{
		$this->flag_sign = array(
			"0"=>"적립",
			"1"=>"사용"
		);
		$this->attach_type = array(
			"I"=>"신분증사본",
			"A"=>"계좌사본"
		);
		$this->attach_type1 = array(
			"0"=>"팩스/메일",
			"1"=>"파일첨부"
		);
		$this->attach_type2 = array(
			"0"=>"팩스/메일",
			"1"=>"파일첨부"
		);
		$this->flag_pay = array(
			"0"=>"대기",
			"1"=>"지급",
			"2"=>"반려" 
		);
	}

	public function getCash($db, $userno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_account_cash
		WHERE		userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getCashCount($db, $flag_sign="", $userno="") 
	{
		$sql = "
		SELECT		COUNT(idx) as cnt	
		FROM		Ru_log_cash 
		WHERE		1 
		".$this->getWhere($flag_sign, $userno)."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getCashList($db, $limit, $flag_sign="", $userno="") 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_log_cash 
		WHERE		1 
		".$this->getWhere($flag_sign, $userno)." 
		ORDER BY 	idx DESC 
		".$limit."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;		
	}
	
	private function getWhere($flag_sign, $userno) {
		$where = "";
		$flag_array = array("0", "1"); 
		if($flag_sign != "" && in_array($flag_sign, $flag_array)) {			
			$where .= " AND flag_sign = '".$flag_sign."'";
		}		
		if($userno != "") {
			$where .= " AND userno = ".$userno;
		}
		//if($_SESSION['userid'] != "jingeese") {
		//$where .= " AND regdate BETWEEN '2011-10-24 00:00:00' AND '".date("Y-m-d H:i:s")."'";
		//}
		return $where;
	} 
	
	public function getCashSum($db, $flag_sign, $sdate, $edate) 
	{
		$sql = "
		SELECT		SUM(cash) as cash 
		FROM		Ru_log_cash 
		WHERE		flag_sign = '".$flag_sign."' 
		AND 		regdate >= concat(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00')
		AND 		regdate <= concat(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59')
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cash'];		
	}
	
	public function getCashSumCount($db, $sdate, $edate) 
	{
		$sql = "		
		SELECT 		COUNT(idx) as cnt  
		FROM 		Ru_log_cash  
		WHERE 		regdate >= CONCAT(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00') 
		AND 		regdate <= CONCAT(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59')
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cnt'];	
	}
	
	public function getCashSumList($db, $limit, $sdate, $edate) 
	{
		$sql = "		
		SELECT 				RLC.userno, RA.nickname, RCT.state_explain, 
							RLC.flag_sign, RLC.cash, RR.frno, RLC.rno, RC.title, RLC.regdate
		FROM 				Ru_log_cash RLC 
		INNER JOIN 			Rf_cash_type RCT ON(RLC.cash_type = RCT.state) 
		LEFT OUTER JOIN 	Ru_account RA ON(RLC.userno = RA.userno) 
		LEFT OUTER JOIN 	Ru_review RR ON(RLC.rno = RR.rno) 
		LEFT OUTER JOIN 	Ru_review_contents RC ON(RLC.rno = RC.rno) 
		WHERE 		RLC.regdate >= CONCAT(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00') 
		AND 		RLC.regdate <= CONCAT(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59')
		ORDER BY RLC.idx DESC 
		".$limit."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;	
	}

	public function getCashWithdrawSum($db, $sdate, $edate) 
	{
		/*
		$sql = "
		SELECT		SUM(cash) as cash	
		FROM		Ra_cash_withdraw
		WHERE 		regdate >= DATE_FORMAT('".$sdate."', '%Y-%m-%d') 
		AND 		regdate <= DATE_FORMAT('".$edate."', '%Y-%m-%d')  
		";
		*/
		$sql = "
		SELECT		SUM(cash) as cash	
		FROM		Ra_cash_withdraw
		WHERE 		regdate >= concat(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00')
		AND 		regdate <= concat(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59')
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cash'];
	}

	public function getCashWithdrawCount($db, $sdate, $edate) 
	{
		$sql = "
		SELECT		COUNT(wno) as cnt	
		FROM		Ra_cash_withdraw
		WHERE 		regdate >= concat(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00')
		AND 		regdate <= concat(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59') 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getCashWithdrawList($db, $limit, $sdate, $edate) 
	{
		$sql = "
		SELECT		* 
		FROM		Ra_cash_withdraw 
		WHERE 		regdate >= concat(DATE_FORMAT('".$sdate."', '%Y-%m-%d'), ' 00:00:00')
		AND 		regdate <= concat(DATE_FORMAT('".$edate."', '%Y-%m-%d'), ' 23:59:59')
		ORDER BY 	wno DESC 
		".$limit."
		";		
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getCashWithdraw($db, $wno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ra_cash_withdraw 
		WHERE		wno = ".$wno." 
		";		
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getCashWithdrawFile($db, $type, $wno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ra_cash_withdraw_file  
		WHERE		wno = ".$wno." 
		AND 		type = '".$type."'
		".$limit."
		";		
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}
}
