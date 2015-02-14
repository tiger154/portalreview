<?php
class User
{
	var $flag_activated;
	var $flag_powerblog;
	var $flag_email;
	var $flag_black;
	var $gender;
	var $icon;
	
	public function User()
	{
		$this->flag_activated = array(
			"0"=>"비활동",
			"1"=>"활동"
		);
		$this->flag_powerblog = array(
			"0"=>"-",
			"1"=>"파워블로그"
		);
		$this->flag_email = array(
			"0"=>"미수신",
			"1"=>"수신"
		);
		$this->flag_black = array(
			"0"=>"-",
			"1"=>"블랙리스트"
		);
		$this->gender = array(
			"A"=>"-",
			"M"=>"남성",
			"F"=>"여성"
		);
		$this->flag_lunar = array(
			"0"=>"양력",
			"1"=>"음력"
		);
		$this->icon = array(
			"R"=>"http://"._DOMAIN._DIR_IMAGES_."/common/ico/ico_R.gif",
			"T"=>"http://"._DOMAIN._DIR_IMAGES_."/common/ico/ico_T.gif",
			"F"=>"http://"._DOMAIN._DIR_IMAGES_."/common/ico/ico_F.gif"
		);
	}

	public function getUser($db, $userno)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			userno = '".$userno."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getUserExtra($db, $userno)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account_extra
		WHERE			userno = '".$userno."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getUserAreaCode($db, $userno)
	{
		$sql = "
		SELECT			bcode, mcode, scode
		FROM			Ru_account_area_code 
		WHERE			userno = '".$userno."'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getUserCateCode($db, $userno)
	{
		$sql = "
		SELECT			cate1, cate2, cate3, cate4, cate5, cate6 
		FROM			Ru_account_cate_code 
		WHERE			userno = ".$userno."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getUserByID($db, $userid, $type="R")
	{
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			userid = '".$userid."' 
		AND 			type = '".$type."'
		$_sql
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	/*
	* Added 2012.09.06 by revu
	*/
	public function getUserRelationByID($db, $userid, $type)
	{
		if($type == "F"){
			$typeWhere = "fb_relation";
		}else {
			$typeWhere = "twit_relation";
		}
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			".$typeWhere." = '".$userid."' 	
		$_sql
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	/*
    by revu 2012.09.06
	*/
	public function getUserTwitLogInformByID($db, $userid)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account_twitter
		WHERE		user_id = '".$userid."' 	
		$_sql
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

    /*
	by revu 2012.09.06
	*/
	public function getUserFbLogInformByID($db, $userid)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account_facebook
		WHERE		user_id = '".$userid."' 	
		$_sql
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	

	public function getUserByNick($db, $nickname, $type="R")
	{
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			nickname = '".$nickname."' 
		AND 			type = '".$type."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getUserByEmail($db, $email)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			email = '".$email."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getUserListByEmail($db, $email)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account
		WHERE			email = '".$email."'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function isUser($db, $userno)
	{
		$sql = "
		SELECT			COUNT(userno) as cnt
		FROM			Ru_account
		WHERE			userno = ".$userno."
		";
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserID($db, $userid, $type="R")
	{
		$sql = "
		SELECT			COUNT(userid) as cnt
		FROM			Ru_account
		WHERE			userid = '".$userid."' 
		AND 			type = '".$type."'
		";
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	/*
	* sns-link-account find. 2012.09.06 
	*/
	public function isUserLinkID($db, $userid, $type)
	{
		if($type == "F"){
			$typeWhere = "fb_relation";
		}else {
			$typeWhere = "twit_relation";
		}

		$sql = "
		SELECT			COUNT(fb_relation) as cnt
		FROM			Ru_account		
		WHERE			".$typeWhere." = '".$userid."' 	
		";
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	//public function isUserNick($db, $nickname, $type="R")
	public function isUserNick($db, $nickname)
	{
		/*
		$sql = "
		SELECT			COUNT(nickname) as cnt
		FROM			Ru_account
		WHERE			nickname = '".$nickname."' 
		AND 			type = '".$type."'
		";
		*/
		$sql = "
		SELECT			COUNT(nickname) as cnt
		FROM			Ru_account
		WHERE			nickname = '".$nickname."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserEmail($db, $email)
	{
		$sql = "
		SELECT			COUNT(email) as cnt
		FROM			Ru_account
		WHERE			email = '".$email."'
		";
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserPass($db, $userid, $passwd, $type="R")
	{
		$sql = "
		SELECT			COUNT(*) as cnt
		FROM			Ru_account
		WHERE			userid = '$userid'
		AND				passwd = PASSWORD('$passwd') 
		AND 			type = '".$type."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isUserSNS($db, $id, $type)
	{
		$sql = "
		SELECT		COUNT(*) as cnt
		FROM		Ru_account_sns
		WHERE		type = '".$type."'
		AND			id ='".$id."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkRepeatID($db, $userid, $type="R")
	{
		$denyArr = Module::loadConf(_DIR_CONF."/site.deny.id.ini"); 
		if(in_array($userid, $denyArr) == true) {
			return true;
		}
		$sql = "
		SELECT			COUNT(userid) as cnt
		FROM			Ru_account
		WHERE			userid = '".$userid."'
		AND 			type = '".$type."' 
		";
		//echo $sql;
		$rs = $db->fetch($sql, true);
		if($rs['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function checkRepeatNick($db, $nickname)
	{
		$denyArr = Module::loadConf(_DIR_CONF."/site.deny.nickname.ini"); 
		if(in_array($nickname, $denyArr) == true) {
			return true;
		}
		$sql = "
		SELECT			COUNT(nickname) as cnt
		FROM			Ru_account
		WHERE			nickname = '".$nickname."' 
		";
		//echo $sql;
		$rs = $db->fetch($sql, true);
		if($rs['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserStats($db, $userno)
	{
		$sql = "
		SELECT			*
		FROM			Ru_account_stats
		WHERE			userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function isNew($regdate, $time=24)
	{
		$new = false;
		$cnt = 0;
		foreach($regdate as $key => $val) {
			if((time() - $time*60*60) < strtotime($val)) {
				$cnt++;
			} 
		}
		if($cnt > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isNewByUserno($userno, $time=24)
	{
		$sql = "
		SELECT		login_regdate, review_regdate, talk_regdate
		FROM		Ru_account_stats
		WHERE		blogno = ".$blogno."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql, true);
		return $this->isNew($rs, $time);
	}

	public function getGrade($db, $userno)
	{
		$sql = "
		SELECT		grade 
		FROM		Ru_account_grade 
		WHERE		userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['grade'];
	}

	public function getImage($userno, $userimage) 
	{
		//echo "userno:$userno<br>";
		if($userimage != "") {
			$dir = ceil($userno/10000);
			// http://file.revu.co.kr/userimage/
			// http://file.revu.co.kr/userimage/13/122016.jpg
			$url = "http://"._DOMAIN_FILE."/"._FTP_USERIMAGE."/".$dir."/".$userimage;
		} else {
			//$url = "http://"._DOMAIN._DIR_IMAGES_."/common/thum/thum_080080.gif";
			$url = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";
		}
		return $url;
		
	}

	public function getUserCount($db, $flag, $opt, $keyword) 
	{	
		$sql = "
		SELECT		COUNT(userno) as cnt
		FROM		Ru_account 
		WHERE		
		".$this->getWhere($flag, $opt, $keyword)."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getUserList($db, $limit, $flag, $opt, $keyword) 
	{
		$sql = "
		SELECT		userno, userid, username, nickname, email, type,  
					flag_activated, flag_powerblog, flag_email, flag_black, regdate  
		FROM		Ru_account 
		WHERE		
		".$this->getWhere($flag, $opt, $keyword)."
		ORDER BY 	userno DESC 
		".$limit."
		";
		//echo $sql;
		//echo "<br />";
		$rs = $db->fetch($sql);
		return $rs;		
	}

	private function getWhere($flag, $opt, $keyword)
	{
		$where = " 1 ";
		switch($flag) {
			case "powerblog" : 
				$where .= " AND flag_powerblog = '1' ";
				break;
			case "black" :
				$where .= " AND flag_black = '1' ";
				break; 
			case "email" :
				$where .= " AND flag_email = '1' ";
				break; 
			case "all" :
			default :
				break;
		}		
		if($opt != "") {
			$where .= " AND ".$opt." LIKE '%".$keyword."%'";
		}
		return $where;
	}

	public function getSecedeUserCount($db, $flag, $opt, $keyword) 
	{	
		$sql = "
		SELECT		COUNT(userno) as cnt
		FROM		Ru_account_secede 
		WHERE		
		".$this->getSecedeWhere($flag, $opt, $keyword)."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getSecedeUserList($db, $limit, $flag, $opt, $keyword) 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_account_secede 
		WHERE		
		".$this->getSecedeWhere($flag, $opt, $keyword)."
		ORDER BY 	secdate DESC 
		".$limit."
		";
		//echo $sql;
		//echo "<br />";
		$rs = $db->fetch($sql);
		return $rs;		
	}

	private function getSecedeWhere($flag, $opt, $keyword)
	{
		$where = " 1 ";
		switch($flag) {
			case "powerblog" : 
				$where .= " AND flag_powerblog = '1' ";
				break;
			case "black" :
				$where .= " AND flag_black = '1' ";
				break; 
			case "email" :
				$where .= " AND flag_email = '1' ";
				break; 
			case "all" :
			default :
				break;
		}		
		if($opt != "") {
			$where .= " AND ".$opt." LIKE '".$keyword."%'";
		}
		return $where;
	}	
}
?>