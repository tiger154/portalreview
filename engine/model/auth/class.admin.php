<?php
class Admin
{

	public function Admin()
	{
	}
	
	public function isAdmin($db, $userno)
	{
		$sql = "
		SELECT			COUNT(userno) as cnt 
		FROM			Ra_admin 
		WHERE 			userno = '".$userno."'
		";
		//echo "sql:$sql";
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0){
			return true;
		} else {
			return false;
		}
	}
	
	public function getAdmin($db, $userno)
	{
		$sql = "
		SELECT			*  
		FROM			Ra_admin 
		WHERE 			userno = '".$userno."'
		";
		//echo "sql:$sql";
		$row = $db->fetch($sql, true);
		return $row;
	}
}
?>