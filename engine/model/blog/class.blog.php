<?php
class Blog
{
	public function Blog()
	{
	}

	public function createAuthKey() {
		mt_srand((double)microtime()*10000);
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$authkey = substr($charid, 0, 8);
		$authkey .= substr($charid, 8, 4);
        $authkey .= substr($charid, 12, 4);
        $authkey .= substr($charid, 16, 4);
        $authkey .= substr($charid, 20,12);
        return $authkey;
	}
	
	public function getRSSURL($content) {
		preg_match_all(
		'@<([a-zA-Z]+)\s+
			((?:[\w]+[\s]*=[\s]*			
			(?:"(?(?=\\\\")\\\\"|.*?)*?"	
			|\'(?(?=\\\\\')\\\\\'|.*?)*?\'	
			|[^\s<>]+)						
			\s*)*?)							
		/?>@xs', $content, $match);
		for($i=0; $i<sizeof($match[2]); $i++) {
			$var = $match[2][$i];
			if(substr_count($var, "application/rss+xml") > 0 || (substr_count($var, "application/rss xml") > 0 && substr_count($var, "alternate") > 0)) {
				$pattern = "/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
				preg_match($pattern, $var, $match2);
				$rssurl = $match2[0];
				$url = parse_url($rssurl);
				switch($url['host']) {
					case "feeds.feedburner.com" : 
						$rssurl .= "?format=xml";
						break;
					default : 
						break;
				}
				if($rssurl != "") break;
			}
		}
		return $rssurl;
	}
	
	public function getTitle($content) {
		preg_match_all(
		'@<([a-zA-Z]+)\s+
			((?:[\w]+[\s]*=[\s]*			
			(?:"(?(?=\\\\")\\\\"|.*?)*?"	
			|\'(?(?=\\\\\')\\\\\'|.*?)*?\'	
			|[^\s<>]+)						
			\s*)*?)							
		/?>@xs', $content, $match);
		for($i=0; $i<sizeof($match[2]); $i++) {
			$var = $match[2][$i];
			if(substr_count($var, "application/rss+xml") > 0 || (substr_count($var, "application/rss xml") > 0 && substr_count($var, "alternate") > 0)) {
				$pattern = "/\b(?:(?:https?|http):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
				preg_match($pattern, $var, $match2);
				$rssurl = $match2[0];
			}
		}
		return $title;		
	}
	
	public function transdate($pubdate) {		
		$date = strftime("%Y-%m-%d %H:%M:%S", strtotime($pubdate));
		return $date;
	}	
	
	public function getLoginBlogList($db, $userno, $limit="") 
	{
		$where = "";
		$where .= ($limit != "") ? "LIMIT ".$limit : ""; 
		$sql = "
		SELECT		blogno, url, name, review_cnt, upddate 
		FROM		Ru_account_blog
		WHERE		userno = ".$userno."
		AND			flag_activated = '1'
		".$where."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		$size = sizeof($rs);
		$arr = array();
		
		GLOBAL $BASE;
		$_blogNew = false;		
		for($i=0; $i<$size; $i++) {
			$rs[$i]['name'] = htmlspecialchars($BASE->strLimitUTF($rs[$i]['name'], 18, false, '...'));
			$rs[$i]['review_cnt'] = number_format($rs[$i]['review_cnt']);
			if($this->isNew($rs[$i]['upddate'], $time=24) == true) $_blogNew = true;
		}
		$arr['blog_new'] = $_blogNew;		
		$arr['blog_list'] = $rs;
		$arr['blog_cnt'] = $size;
		
		return $arr;
	}
	
	public function isBlog($db, $blogno) 
	{
		$blog = $this->getBlog($db, $blogno);
		if($blog['flag_activated'] == "1") {
			return true;
		} else {
			return false;
		}
	}
	
	public function isBlogByURL($db, $url) 
	{
		$sql = "
		SELECT		COUNT(blogno) as cnt 
		FROM		Ru_account_blog
		WHERE		url = '".$url."' 
		AND 		flag_activated = '1' 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getBlogIcon($url) 
	{
		$arr = array(
			"etc"=>"http://"._DOMAIN."/images/common/ico/ico_etc.gif",
			"revu"=>"http://"._DOMAIN."/images/common/ico/ico_revu.gif",
			"naver"=>"http://"._DOMAIN."/images/common/ico/ico_naver.gif",
			"blog.me"=>"http://"._DOMAIN."/images/common/ico/ico_naver.gif", 
			"tistory"=>"http://"._DOMAIN."/images/common/ico/ico_tistory.gif",
			"daum"=>"http://"._DOMAIN."/images/common/ico/ico_daum.gif",
			"egloos"=>"http://"._DOMAIN."/images/common/ico/ico_egloos.gif", 
		);		
		if(trim($url) != "") {
			$_url = parse_url($url);		
			foreach($arr as $key => $val) {
				if($key != "etc") {
					preg_match("/".$key."/", $_url['host'], $match);
					if($match[0] != "") {
						return $val;
					}
				}
				unset($match);
			}		
			if($match[0] == "") {
				return $arr['etc'];
			}
		} else {
			return $arr['revu'];
		}
	}
	
	public function isNew($upddate, $time=24)
	{
		if((time() - $time*60*60) < strtotime($upddate)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isNewByBlogno($blogno, $time=24)
	{
		$sql = "
		SELECT		upddate
		FROM		Ru_account_blog
		WHERE		blogno = ".$blogno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $this->isNew($row['upddate'], $time);
	}
	
	public function isMyBlog($db, $userno, $url, $flag_return_blogno=false) 
	{
		$blog = $this->getBlogList($db, $userno);
		for($i=0; $i<sizeof($blog); $i++) {
			ereg($blog[$i]['url'], $url, $pattern);
		}
		if($flag_return_blogno == true) {			
			$blogno = "";
			for($i=0; $i<sizeof($blog); $i++) {
				if($blog[$i]['url'] == $pattern[0]) {
					$blogno = $blog[$i]['blogno'];
					return $blogno; 
				}
			}			
		} else {
			if(sizeof($pattern) > 0) {
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function getBlog($db, $blogno) 
	{ 
		$sql = "
		SELECT		blogno, userno, url, name, flag_activated, review_cnt, talk_cnt, cash, regdate, upddate
		FROM		Ru_account_blog
		WHERE		blogno = ".$blogno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getBlogByURL($db, $userno, $url, $flag_activated="1") 
	{
		$_sql = "";
		$_sql .= ($flag_activated != "") ? " AND flag_activated = '".$flag_activated."'" : ""; 
		$sql = "
		SELECT		blogno, url, name, flag_activated, review_cnt, talk_cnt, cash, regdate, upddate
		FROM		Ru_account_blog
		WHERE		userno = ".$userno." 
		AND			url = '".trim($url)."'
		".$_sql."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getBlogList($db, $userno, $flag_activated="1", $limit="") 
	{
		$_sql = "";
		$_sql .= ($flag_activated != "") ? "AND flag_activated = '".$flag_activated."'" : ""; 
		$_sql .= ($limit != "") ? $limit : "";
		$sql = "
		SELECT		blogno, url, name, flag_activated, review_cnt, talk_cnt, cash, regdate, upddate	
		FROM		Ru_account_blog
		WHERE		userno = ".$userno."
		".$_sql."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getBlogCount($db, $userno, $flag_activated="1", $limit="") 
	{
		$_sql = "";
		$_sql .= ($flag_activated != "") ? "AND flag_activated = '".$flag_activated."'" : ""; 
		$_sql .= ($limit != "") ? $limit : "";
		$sql = "
		SELECT		count(blogno) as cnt
		FROM		Ru_account_blog
		WHERE		userno = '$userno'
		".$_sql."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql, true);
		return $rs['cnt'];
	}
	
}