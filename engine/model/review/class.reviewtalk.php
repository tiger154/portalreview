<?php
class ReviewTalk extends Review
{
	public function ReviewTalk()
	{
	}
	
	public function transRef($type, $nickname)
	{
		$ref = "";
		switch($type) {
			case "T" : 
				$ref = $nickname." 님이 이 리뷰를 RT했습니다.";
				break;
			case "F" : 
				$ref = $nickname." 님이 이 글을 공유했습니다.";
				break;
			case "R" : 
			default: 
				$ref = $nickname." 님이 이 글에 토크를 남겼습니다.";
				break;
		}
		return $ref;
	}

	public function transIcon($type)
	{
		$url = "http://"._DOMAIN._DIR_IMAGES_;
		$icon = "";
		switch($type) {
			case "T" : 
				$icon = $url."/common/ico/ico_T.gif";
				break;
			case "F" : 
				$icon = $url."/common/ico/ico_F.gif";
				break;
			case "R" : 
			default: 
				$icon = $url."/common/ico/ico_R.gif";
				break;
		}
		return $icon;
	}
	
	public function getTalk($db, $tno)
	{
		$sql = "
		SELECT		* 
		FROM		Ru_review_talk 
		WHERE 		tno = ".$tno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		$row['ref'] = $this->transRef($row['type'], $row['nickname']);
		$row['icon'] = $this->transIcon($row['type']);		
		return $row;
	}
	
	public function getTalkLast($db, $rno)
	{
		$sql = "
		SELECT		* 
		FROM		Ru_review_talk 
		WHERE 		rno = ".$rno." 
		AND 		flag_del = '0' 
		ORDER BY 	tno 
		DESC LIMIT 	1 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getTalkCount($db, $rno, $flag_del="") 
	{
		$sql = "
		SELECT		talk_cnt 
		FROM		Ru_review 
		WHERE 		rno = ".$rno." 
		".$this->getWhere($flag_del, $tno="")." 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	public function getTalkList($db, $rno, $num=15, $flag_del="", $tno="")
	{
		$sql = "
		SELECT		* 
		FROM		Ru_review_talk 
		WHERE 		rno = ".$rno." 
		".$this->getWhere($flag_del, $tno)." 
		ORDER BY 	tno DESC 
		LIMIT 		".$num." 
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getTalkNextTno($db, $rno, $flag_del="", $tno="")
	{
		$sql = "
		SELECT		MAX(tno) as tno
		FROM		Ru_review_talk 
		WHERE 		rno = ".$rno." 
		".$this->getWhere($flag_del, $tno)." 
		ORDER BY 	tno DESC 
		LIMIT 		0, 1
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['tno'];
	}
	
	public function getWhere($flag_del, $tno) 
	{
		$where = "";
		if($flag_del != "") {
			$where .= " AND flag_del = '".$flag_del."'";
		}
		if($tno != "") {
			$where .= " AND tno < ".$tno;
		}
		return $where;
	}

	public function getTalkUserCount($db, $type="", $userno="", $flag_del="") 
	{
		$sql = "
		SELECT		COUNT(tno) as cnt 
		FROM		Ru_review_talk  
		WHERE 		1  
		".$this->getTalkUserWhere($type, $userno, $flag_del)." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	public function getTalkUserList($db, $limit, $type="", $userno="0", $flag_del="")
	{
		$sql = "
		SELECT		* 
		FROM		Ru_review_talk 
		WHERE 		1 
		".$this->getTalkUserWhere($type, $userno, $flag_del)." 
		ORDER BY 	tno DESC 
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getTalkUserWhere($type, $userno, $flag_del)
	{
		$where = "";
		if($type != "" && $userno != "") {
			switch($type) {
				case "1" : 
					$where .= " AND ruserno = '".$userno."'";
					break;
				case "0" : 
				default : 
					$where .= " AND userno = '".$userno."'";
					break;
			}
		}
		if($flag_del != "") {
			$where .= " AND flag_del = '".$flag_del."'";
		}		
		return $where;
	}
	
	public function getTalkDataBind($db, $list)
	{
		$CLASS_BASE = &Module::singleton("Base");
		$CLASS_USER = &Module::singleton("User.User");
		$CLASS_BLOG = &Module::singleton("Blog.Blog");
		$size = sizeof($list);
		for($i=0; $i<$size; $i++) {	
			$list[$i]['review'] = $this->getReview($db, $list[$i]['rno']);
			$list[$i]['content'] = $CLASS_BASE->strLimitUTF(strip_tags($list[$i]['review']['content']), 400, false, '...');
			$list[$i]['title'] = $CLASS_BASE->strLimitUTF(htmlspecialchars($list[$i]['review']['title']), 60, false, '...');
			if($list[$i]['userno'] != 0) {
				$_user = $CLASS_USER->getUser($db, $list[$i]['userno']);
				$_extra = $CLASS_USER->getUserExtra($db, $list[$i]['userno']);
				$list[$i]['userimage'] = $CLASS_USER->getImage($list[$i]['userno'], $_extra['userimage']);
			} else {
				$list[$i]['userimage'] = $CLASS_USER->getImage("", "");
			}
			$_file = $this->getReviewFile($db, $list[$i]['rno'], "T");
			if($list[$i]['review']['rid'] == ""){
				$list[$i]['thumbimage_url'] = $this->getThumbimage($_file[0]['filename'], $list[$i]['review']['regdate']);
				$list[$i]['thumbimage110_url'] = $this->getThumbimage($_file[0]['filename'], $list[$i]['review']['regdate'], "110");
			} else {
				$list[$i]['thumbimage_url'] = $this->getThumbimageOld($_file[0]['filename'], $list[$i]['review']['regdate'], $list[$i]['review']['rid']);
			}
			$list[$i]['is_thumb'] = ($_file[0]['filename'] == "") ? "0" : "1";
			$list[$i]['blog_icon'] = $CLASS_BLOG->getBlogIcon($list[$i]['review']['url']);
			$list[$i]['icon'] = $this->transIcon($list[$i]['type']);
			$list[$i]['ref'] = $this->transRef($list[$i]['type'], $list[$i]['nickname']);
		}
		return $list;
	}
}
