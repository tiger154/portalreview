<?php
class Login
{
	public function Login()
	{
	}

	public function setSession($userInfo)
	{
		$this->initSession();
		$exceptArr = array("passwd");
		foreach($userInfo as $key => $value)
		{
			if(!in_array($key, $exceptArr)) {
				$_SESSION[$key] = $value;
			}
		}
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['grade'] = "1";
	}


	public function setSnsLoginSession($userInfo)
	{
		//$this->initSession();
		$exceptArr = array("passwd");
		foreach($userInfo as $key => $value)
		{
			if(!in_array($key, $exceptArr)) {
				$_SESSION[$key] = $value;
			}
		}
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['grade'] = "1";
	}
	
	public function addSession($userInfo) 
	{
		$exceptArr = array("userno", "userid", "username", "nickname", "email");
		foreach($userInfo as $key => $value)
		{
			if(!in_array($key, $exceptArr)) {
				$_SESSION[$key] = $value;
			}
		}
	}

	public function setSessionAdmin($userInfo) 
	{
		$exceptArr = array("adminid", "rtype");
		foreach($userInfo as $key => $value)
		{
			if(!in_array($key, $exceptArr)) {
				$_SESSION[$key] = $value;
			}
		}
	}

	public function initSession()
	{
		$_SESSION = array();
		return true;
	}

	public function insertLoginLog($db, $userInfo, $info)
	{
		$ip = $_SERVER["REMOTE_ADDR"];
		$regtime = time();
		$sql = "
		INSERT INTO Rl_login
		SET			userno = '".$userInfo['userno']."',
					userid = '".$userInfo['userid']."',
					passwd = '".$userInfo['passwd']."',
					username = '".$userInfo['username']."',
					ip = '".$ip."',
					referer = '".$info[referer]."',
					login_type = '".$info[login_type]."',
					login_result = '".$info[login_result]."',
					regtime = '".$regtime."',
					regate = NOW()
		";
		$db->query($sql);
		return $db->result;
	}

	public function getLoginLogCount($db, $userInfo, $limitDay)
	{
		$limitTime = time() - 60*60*24*$limitDay;
		$sql = "
		SELECT		COUNT(idx) as cnt
		FROM		__log_login
		WHERE		ref_idx = ".$userInfo['idx']."
		AND			regtime > ".$limitTime."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getLoginLogList($db, $userInfo, $limitDay, $limitSql)
	{
		$limitTime = time() - 60*60*24*$limitDay;
		$sql = "
		SELECT		idx, ref_idx, userid, nickname, uNo, ip, referer, login_type, login_result, regtime, regdate
		FROM		__log_login
		WHERE		idx = $userInfo[idx]
		AND			regtime > ".$limitTime."
		ORDER BY	regtime DESC
		".$limitSql."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function isLoginPastTime($db, $userno, $time=24)
	{
		$ctime = $time * 60 * 60;
		$sql = "
		SELECT 		COUNT(userno) AS cnt
		FROM 		Ru_account_stats 
		WHERE 		UNIX_TIMESTAMP(login_regdate) > (UNIX_TIMESTAMP() - ".$ctime.") 
		AND 		userno = '".$userno."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return false;
		} else {
			return true;
		}
	}
}
?>