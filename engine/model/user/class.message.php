<?php
class Message
{
	public function Message()
	{
	}
	
	/**
	 * 쪽지정보
	 * 
	 * @param	int $idx 쪽지일련번호
	 * @access	public
	 */
	public function getMessage($db, $idx)
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
	
	/**
	 * 발송수 카운틑
	 * 
	 * @param	string $sender 회원번호
	 * @param	string $flag_sender_del 삭제여부
	 * @access	public
	 */
	public function getSendCount($db, $sender, $flag_sender_del='0')
	{
		$sql = "
		SELECT		COUNT(idx) as cnt
		FROM		Ru_message
		WHERE		sender = ".$sender."
		AND			flag_sender_del = '".$flag_sender_del."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	/**
	 * 쪽지발송리스트
	 * 
	 * @param	string $sender 회원번호
	 * @param	string $flag_sender_del 삭제여부
	 * @param	string $limit limit구문
	 * @access	public
	 */
	public function getSendList($db, $sender, $flag_sender_del='0', $limit)
	{
		$sql = "
		SELECT		*
		FROM		Ru_message
		WHERE		sender = ".$sender."
		AND			flag_sender_del = '".$flag_sender_del."'
		ORDER BY	idx DESC 
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
}
?>