<?php
class Point {
	
	public function Point() 
	{	
	}

	public function getPoint($db, $userno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_account_point
		WHERE		userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getPointCount($db, $userno) 
	{
		$sql = "
		SELECT		COUNT(idx) as cnt	
		FROM		Ru_log_point
		WHERE		1 
		".$this->getWhere($userno)."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getPointList($db, $limit, $userno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_log_point 
		WHERE		1 
		".$this->getWhere($userno)."
		ORDER BY 	idx DESC 
		".$limit."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;		
	}

	private function getWhere($userno) {
		$where = "";		
		if($userno != "") {
			$where .= " AND userno = ".$userno;
		}
		return $where;
	}
}
