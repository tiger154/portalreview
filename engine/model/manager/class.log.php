<?php
class Log
{	
	public function Log()
	{
	}
	
	
	public function getStats($db) 
	{
		$sql = "
		SELECT		* 
		FROM		Rs_count 
		LIMIT 		1
		";
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	
	public function getStatsSum($db, $type, $sdate, $edate)
	{
		$sql = "
		SELECT		SUM(".$type.") as sum
		FROM		Rs_count_date 
		WHERE 		DATE <= DATE_FORMAT(NOW(), '%Y-%m-%d')  
		AND 		date >= DATE_FORMAT('".$sdate."', '%Y-%m-%d') 
		AND 		date <= DATE_FORMAT('".$edate."', '%Y-%m-%d')  
		";
		
		$row = $db->fetch($sql, true);
		return $row['sum'];
	}
	
	
	public function getStatsCount($db, $sdate, $edate)
	{
		$sql = "
		SELECT		COUNT(date) as cnt
		FROM		Rs_count_date 
		WHERE 		DATE <= DATE_FORMAT(NOW(), '%Y-%m-%d')  
		AND 		date >= DATE_FORMAT('".$sdate."', '%Y-%m-%d') 
		AND 		date <= DATE_FORMAT('".$edate."', '%Y-%m-%d')  
		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	
	public function getStatsList($db, $limit, $sdate, $edate)
	{
		$sql = "
		SELECT		* 
		FROM		Rs_count_date 
		WHERE 		DATE <= DATE_FORMAT(NOW(), '%Y-%m-%d') 
		AND 		date >= DATE_FORMAT('".$sdate."', '%Y-%m-%d') 
		AND 		date <= DATE_FORMAT('".$edate."', '%Y-%m-%d')  
		ORDER BY 	date DESC 
		".$limit."
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	
	
	public function getCashByDate($db, $type, $sdate, $edate)
	{
		$sql = "
		SELECT		SUM(".$type.") as cash
		FROM		Rs_count_date  
		WHERE		date >= '".$sdate."' 
		AND 		date <= '".$edate."'
		";
		
		$row = $db->fetch($sql, true);
		return $row['cash'];
	}
	
	
	public function getCronLogCount($db, $name)
	{
		$sql = "
		SELECT		COUNT(idx) as cnt
		FROM		Rl_cron 
		WHERE		
		".$this->getCronLogWhere($name)."
		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	
	public function getCronLogList($db, $limit, $name="")
	{
		$sql = "
		SELECT		idx, cron_name, cron_src, content, regtime, regdate 
		FROM		Rl_cron 
		WHERE		
		".$this->getCronLogWhere($name)."
		ORDER BY 	regtime DESC 
		".$limit."
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	
	private function getCronLogWhere($name)
	{
		$where = " 1 ";
		if($name != "") $where .= " AND cron_name = '".$name."' ";
		return $where;
	}
	
	
	public function getErrorLogCount($db, $type="", $name="")
	{
		$sql = "
		SELECT		COUNT(idx) as cnt
		FROM		Rl_transaction_error  
		WHERE		
		".$this->getErrorLogWhere($type, $name)."
		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	
	public function getErrorLogList($db, $limit, $type="", $name="")
	{
		$sql = "
		SELECT		idx, transaction_type, transaction_name, content, regdate 
		FROM		Rl_transaction_error  
		WHERE		
		".$this->getErrorLogWhere($type, $name)."
		ORDER BY 	regdate DESC 
		".$limit."
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	
	private function getErrorLogWhere($type, $name)
	{
		$where = " 1 ";
		if($type != "") $where .= " AND transaction_type = '".$type."' ";
		if($name != "") $where .= " AND transaction_name = '".$name."' ";
		return $where;
	}
	
	
	public function getBestReviewCash($db, $userno, $rno) 
	{
		$sql = "
		SELECT		userno, rno, cash 
		FROM		Ru_log_cash 
		WHERE		userno = ".$userno."
		AND 		rno = ".$rno." 
		AND 		cash_type = '302' 
		";
		
		$row = $db->fetch($sql, true);
		return $row;
	}
}