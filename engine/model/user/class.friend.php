<?php
class Friend
{
	public function Friend()
	{	
	}

	public function isFriendGroupDesc($db, $userno, $gdesc) {
		$sql = "
		SELECT		COUNT(groupno) as cnt
		FROM		Ru_friend_group  
		WHERE		userno = ".$userno." 
		AND 		gdesc = '".$gdesc."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt']> 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getFriendType($db, $userno, $fuserno)
	{
		$type = "";
		$sql = "
		SELECT		userno, flag_eachother 
		FROM		Ru_friend 
		WHERE		userno = ".$userno." 
		AND 		fuserno = ".$fuserno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);		
		if($row['userno'] != "") {
			if($row['flag_eachother'] == "1") {
				$type = "EO";
			} else if($row['flag_eachother'] == "0") {
				$type = "MY";
			}
		} else {
			$sql = "
			SELECT		userno, flag_eachother 
			FROM		Ru_friend 
			WHERE		userno = ".$fuserno." 
			AND 		fuserno = ".$userno."
			";
			//echo $sql;
			$row = $db->fetch($sql, true);
			if($row['userno'] != "") {
				$type = "ME";
			}
		}
		if($type == "") $type = "NOT";
		return $type;
	}

	public function getUsernoByType($session_userno, $userno, $fuserno)
	{
		if($session_userno != $fuserno) {
			$_userno = $fuserno;
		} else {
			$_userno = $userno;
		}
		//echo $_userno;
		return $_userno; 
	}

	public function getFriendCount($db, $userno, $type="", $groupno="")
	{		
		$sql = "
		SELECT		COUNT(userno) as cnt
		FROM		Ru_friend 
		WHERE		1
		".$this->getWhere($userno, $type, $groupno)." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getFriendList($db, $limit, $userno, $type="", $groupno="")
	{
		$sql = "
		SELECT		*
		FROM		Ru_friend 
		WHERE		1
		".$this->getWhere($userno, $type, $groupno)." 
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	private function getWhere($userno, $type, $groupno) {
		$where = "";
		switch($type) {
			case "ME" : 
				$where .= " AND fuserno = ".$userno." AND flag_eachother = '0' ";
				break;
			case "MY" :
				$where .= " AND userno = ".$userno." AND flag_eachother = '0' ";
				break;
			case "EO" :  
				$where .= " AND userno = ".$userno." AND flag_eachother = '1' "; 
				break;
			default : 
				//$where .= " AND ((userno = ".$userno." OR fuserno = ".$userno.") ";
				$where .= " AND ((userno = ".$userno." AND flag_eachother = '0') OR fuserno = ".$userno.")"; 
				break;				
		}
		
		if($groupno != "") {
			$where .= " AND groupno = ".$groupno;
		}
		
		return $where;
	}

	public function getFriendGroupList($db, $userno) {
		$sql = "
		SELECT		*
		FROM		Ru_friend_group  
		WHERE		userno = ".$userno."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getFriendByNick($db, $nickname)
	{
		$sql = "
		SELECT			userno, nickname 
		FROM			Ru_account
		WHERE			nickname like '".$nickname."%'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getFriendByEmail($db, $email)
	{
		$sql = "
		SELECT			userno, nickname 
		FROM			Ru_account
		WHERE			email like '".$email."%'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
}
?>