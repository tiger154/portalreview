<?php
class Memo
{
	public function Memo()
	{
	}
	
	public function getMemo($db, $idx)
	{
		$sql = "
		SELECT			*
		FROM			Ru_message_contents
		WHERE			idx = ".$idx."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getMemoCount($db, $userno)
	{
		$sql = "
		SELECT		COUNT(mno) as cnt 
		FROM		Ra_account_memo
		WHERE		userno = ".$userno." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getMemoList($db, $limit, $userno)
	{
		$sql = "
		SELECT		*  
		FROM		Ra_account_memo
		WHERE		userno = ".$userno." 
		ORDER BY	mno DESC 
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
}
?>