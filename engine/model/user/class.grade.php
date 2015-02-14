<?php
class Grade
{
	public function Grade()
	{
	}

	public function getPoint($db, $userno)
	{
		$sql = "
		SELECT			point 
		FROM			Ru_account_point 
		WHERE 			userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['point'];
	}

	public function getMaxPoint($db)
	{
		$sql = "
		SELECT			MAX(point) as point
		FROM			Ru_account_point 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['point'];
	}

	public function getMinPoint($db)
	{
		$sql = "
		SELECT			MIN(point) as point
		FROM			Ru_account_point 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['point'];
	}

	public function getMediumPoint($db, $num)
	{
		if($num > 1) {
			$sql = "
			SELECT			point 
			FROM			Ru_account_point
			ORDER BY 		point DESC 
			LIMIT 			".$num." 
			";
			//echo $sql;
			$rs = $db->fetch($sql);
			return $rs[$num-1]['point'];
		} else {
			return 0;
		}
	}

	public function getGradeArray($maxPoint, $mediumPoint, $minPoint=1000, $grade=18, $sq=1.5) 
	{
		if($maxPoint <= $mediumPoint) return false;
		if($mediumPoint <= $minPoint) return false;
		$gapPoint = $mediumPoint - $minPoint;		
		while(true) {
			$sq = ($sq < 1) ? 1.1 : $sq; 
			$gapGrade = 0; 
			for($i=1; $i<$grade-1; $i++) {
				$gapGrade += pow($i, $sq);
			}
			$gap = floor($gapPoint/$gapGrade);
			if(intval($gap) > 0) {
				break;
			} else {
				$sq--;
			}
		}		
		$gradeArr = array();
		for($i=0; $i<$grade; $i++) {
			if($i == 0) {
				$gradeArr[$i]['spoint'] = 0;
				$gradeArr[$i]['epoint'] = $minPoint;
			} else if($i == $grade-2){
				$gradeArr[$i]['spoint'] = $gradeArr[$i-1]['epoint'] + 1;
				$gradeArr[$i]['epoint'] = $mediumPoint-1;
			} else if($i == $grade-1){
				$gradeArr[$i]['spoint'] = $gradeArr[$i-1]['epoint'] + 1;
				$gradeArr[$i]['epoint'] = 10000000000;
			} else {
				$gradeArr[$i]['spoint'] = $gradeArr[$i-1]['epoint'] + 1;
				$gradeArr[$i]['epoint'] = ceil($gradeArr[$i]['spoint'] + $gap*(pow($i, $sq)));
			}
			$gradeArr[$i]['gap'] =  $gradeArr[$i]['epoint'] - $gradeArr[$i]['spoint'];
		}
		return $gradeArr;
		
		//$gradeArr = $CLASS_USER->getGradeArray($maxPoint=274000, $mediumPoint=25000, $minPoint=1000, $grade=18, $sq=1.5);
		//echo "<pre>";
		//print_r($gradeArr);
		//echo "</pre>";
	}

	public function getUsernum($db, $spoint, $epoint)
	{
		$sql = "
		SELECT			COUNT(userno) as cnt
		FROM			Ru_account_point 
		WHERE 			point between ".$spoint." AND ".$epoint."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getGrade($db, $userno)
	{
		$point = $this->getPoint($db, $userno);
		$sql = "
		SELECT			grade 
		FROM			Ru_grade  
		WHERE 			spoint <= ".$point." 
		AND 			epoint >= ".$point."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['grade'];
	}
	
	public function getGradeList($db)
	{
		$sql = "
		SELECT			grade, spoint, epoint, gap, usernum, usernum 
		FROM			Ru_grade 
		ORDER BY 		grade DESC 
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
}
?>