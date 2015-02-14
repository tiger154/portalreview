<?php
class Review
{
	var $status;
	var $flag_best;
	public function Review()
	{
		$this->status = array(
			"0"=>"비공개",
			"1"=>"공개",
			"2"=>"삭제"
		);
		$this->flag_best = array(
			"0"=>"-",
			"1"=>"베스트리뷰"
		);
	}
	
	public function isReview($db, $blogno, $url) 
	{ 
		$sql = "
		SELECT		COUNT(blogno) as cnt	
		FROM		Ru_review
		WHERE		url = '".$url."'
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isReviewByRno($db, $rno) 
	{ 
		$sql = "
		SELECT		COUNT(rno) as cnt	
		FROM		Ru_review
		WHERE		rno = ".$rno." 
		AND 		status = '1' 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function isReviewByURL($db, $blogno, $userno, $url) 
	{ 
		$sql = "
		SELECT		COUNT(rno) as count	
		FROM		Ru_review
		WHERE		status = '1' 
		AND 		blogno = '$blogno'
		AND 		userno = '$userno' 
		AND 		url = '$url' 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		if($row['count'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getThumbname($thumbname, $type)
	{
		if($thumbname != "" && $type != "") {
			$_filename = substr($thumbname, 0, strrpos($thumbname,"."));
			$_extname = substr(strrchr($thumbname,"."),1);		
			$thumbname = $_filename."_".$type.".".$_extname;
		}
		return $thumbname;
	}
	
	public function getThumbimage($thumbimage, $regdate, $type="") 
	{
		$thumbimage = $this->getThumbname($thumbimage, $type);
		$url = "";
		if(!empty($thumbimage)) {			
			$url = "http://"._DOMAIN_FILE."/"._FTP_REVIEWIMAGE."/".date("Y/m/d", strtotime($regdate))."/".$thumbimage;

			//echo "$url<br>";
		} else {
			$url = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";
			//$url = "http://"._DOMAIN."/images"."/common/noimage.gif";
		}
		return $url;		
	}
	
	public function getThumbimageOld($thumbimage, $regdate, $reviewid) 
	{

		$CLASS_SNOOPY = &Module::singletonExtends("Snoopy");
		$url = "";					
		//이미지가 있는지 체크
		//$url = "http://"._DOMAIN_IMAGE_OLD."/ReviewImage/Thumbnails/".$reviewid.".jpg";		
		//if(!@fopen($url,"r")) //--> 파일과 같은 것을 찾는다. 
		//{ 
			$url = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";	//더미 이미지
		//}else{
		//	$url = "http://"._DOMAIN_IMAGE_OLD."/ReviewImage/Thumbnails/".$reviewid.".jpg";	
		//}
		//이미지가 있는지 체크 -끝	
		return $url;		
	}
	
	public function getReviewContent($db, $rno) 
	{
		$sql = "
		SELECT		*
		FROM		Ru_review_contents 
		WHERE		rno = ".$rno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getReview($db, $rno) 
	{
		$sql = "
		SELECT		*
		FROM		Ru_review R 
		LEFT JOIN 	Ru_review_contents RC ON(R.rno = RC.rno)
		WHERE		R.rno = ".$rno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getReviewCate($db, $rno) 
	{ 
		$sql = "
		SELECT		* 	
		FROM		Ru_review_cate_code
		WHERE		rno = ".$rno." 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getReviewFile($db, $rno, $type="", $flag_del="") 
	{
		$where = "";
		$where .= ($type != "") ? " AND type = '".$type."'" : "";
		$where .= ($flag_del != "") ? " AND flag_del = '".$flag_del."'" : ""; 
		$sql = "
		SELECT		*
		FROM		Ru_review_file 
		WHERE		rno = ".$rno." 
		".$where."
		";
		//echo $sql;		 
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getReviewDelete($db, $rno) 
	{
		$sql = "
		SELECT		rno, upddate
		FROM		Ru_review  
		WHERE		rno = ".$rno." 
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		
		$row['title'] = $row['upddate']."에 삭제된 리뷰입니다.";
		$row['content'] = $row['upddate']."에 삭제된 리뷰입니다.";
		return $row;
	}

	public function getReviewCount($db, $type="", $cate=array(), $status="", $date=array()) 
	{
		//if((sizeof($cate) < 1) && (sizeof(date) < 1) && $status == "1") {
		if(($type != "F") && ($cate[0] == "") && ($date[0] == "") && $status="1") {
			$sql = "
			SELECT		review_cnt as cnt  
			FROM		Ru_review_stats 
			LIMIT		1
			";	
		} else {
			$sql = "
			SELECT		COUNT(rno) as cnt	
			FROM		Ru_review 
			WHERE		1
			".$this->getWhere($type, $cate, $status, $date)."
			";	
		}	
		//echo $sql;
		//echo "<Br/><br />";
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
										
	public function getReviewList($db, $limit, $type="", $cate=array(), $status="", $date=array(), $order="", $desc="") 
	{
		$order = (empty($order)) ? "rno" : $order;
		$desc = (empty($desc)) ? "DESC" : $desc;
		/*
		$sql = "
		SELECT		rno, blogno, userno, url, recom_cnt, talk_cnt, view_cnt, cash, point, 
					cate1, cate2, cate3, cate4, area1, area2, area3, regdate
		*/
		$sql = "
		SELECT		rno 
		FROM		Ru_review 
		WHERE		1
		".$this->getWhere($type, $cate, $status, $date, $order, $desc)."
		".$limit."
		";
		//echo $sql;
		//echo "<br />";
		$rs = $db->fetch($sql);
		return $rs;		
	}

	public function getReviewListByImage($db, $limit, $cate=array(), $date=array()) 
	{		
		if(is_array($cate) == true && sizeof($cate) > 0) {			
			$arr = array();
			foreach($cate as $key => $val) {
				if(!empty($val)) {
					$arr[] = "R.cate".($key+1)." = '".$val."'";
				}
			}
			if(sizeof($arr) > 0) {
				$where .= " AND ".implode(" AND ", $arr);
			}
		} else {
			$where .= " AND R.cate1 IN ('10','11','12','13','14','99')";
		}
				
		if(is_array($date) && $date[0] != "" && $date[1] != "")
			$where .= " AND R.regdate BETWEEN '".$date[0]."' AND '".$date[1]."'";
		
		$sql = "
		SELECT		DISTINCT R.rno
		FROM		Ru_review R
		INNER JOIN 	Ru_review_file RF 
		WHERE		R.rno = RF.rno 
		AND 		R.status = '1' 
		AND 		RF.flag_del = '0' 
		AND 		RF.type = 'T' 
		".$where."
		ORDER BY 	R.point DESC 
		".$limit."
		";
		//echo $sql;
		//echo "<br />";
		$rs = $db->fetch($sql);
		return $rs;		
	}
	
	private function getWhere($type, $cate, $status, $date, $order="", $desc="") 
	{
		$where = "";	
		switch($type) {
			case "F" : // 프론티어일경우 frno != ""
				$where .= " AND frno != ''"; 
				break;
			case "B" :
			case "U" :
			case "R" :
				$where .= " AND type = '".$type."'";  
				break;
			default :
				break;
		} 		
		if(is_array($cate) == true && sizeof($cate) > 0) {			
			$arr = array();
			foreach($cate as $key => $val) {
				if(!empty($val)) {
					$arr[] = "cate".($key+1)." = '".$val."'";
				}
			}
			if(sizeof($arr) > 0) {
				$where .= " AND ".implode(" AND ", $arr);
			}
		} else {
			$where .= " AND cate1 IN ('10','11','12','13','14','99')";
		}
		if(!empty($status)) $where .= " AND status = '".$status."'";	
		if(is_array($date) && $date[0] != "" && $date[1] != "")
			$where .= " AND regdate BETWEEN '".$date[0]."' AND '".$date[1]."'";
		switch($order) {
			case "point" :
				//$where .= " AND point > 0 ";
				$where .= " ORDER BY point ".$desc; 
				break;
			case "rno" :
				$where .= " ORDER BY rno ".$desc;
				break; 
			default : 
				break; 
		}
		return $where;
	}
    /*
	 @param : titlemaxlen
	*/
	public function getReviewDataBind($db, $list, $titlemaxlenUse=false,$titlemaxlen=10)
	{
		$CLASS_BASE = &Module::singleton("Base");
		$CLASS_CODE = &Module::singleton("Code.Code");
		$CLASS_USER = &Module::singleton("User.User");
		$CLASS_BLOG = &Module::singleton("Blog.Blog");
		$size = sizeof($list);
		for($i=0; $i<$size; $i++) {
			$list[$i] = $this->getReview($db, $list[$i]['rno']); // rno를 이용한 리뷰 정보 가져오기
			//echo $list[$i]; 
			$list[$i]['content'] = $CLASS_BASE->strLimitUTF(strip_tags($list[$i]['content']), 400, false, '...');	

			if(!$titlemaxlenUse) {
				$list[$i]['title'] = $CLASS_BASE->strLimitUTF(htmlspecialchars($list[$i]['title']), 60, false, '...');
			}else{
				//$list[$i]['title'] = $CLASS_BASE->strLimitUTF(htmlspecialchars($list[$i]['title']), $titlemaxlen, false, '...');
				$list[$i]['title'] = $CLASS_BASE->utf8_strcut(htmlspecialchars($list[$i]['title']), 24 );
			}
			$_user = $CLASS_USER->getUser($db, $list[$i]['userno']);
			$list[$i]['nickname'] = $_user['nickname'];
			$_cate = $CLASS_CODE->transCate($list[$i]['cate1'],$list[$i]['cate2'],$list[$i]['cate3'],$list[$i]['cate4'],$list[$i]['cate5'],$list[$i]['cate6']);
			$list[$i]['cate_desc'] = $CLASS_CODE->getCateDesc($db, $_cate);

			$_file = $this->getReviewFile($db, $list[$i]['rno'], "T"); // 썸네일 가져오기
			if($list[$i]['rid'] == ""){ //리뉴얼 이후 이미지
				$list[$i]['thumbimage_url'] = $this->getThumbimage($_file[0]['filename'], $list[$i]['regdate']);
				$list[$i]['thumbimage110_url'] = $this->getThumbimage($_file[0]['filename'], $list[$i]['regdate'], "110");
			} else { // 리뉴얼 이전 이미지 
				$list[$i]['thumbimage_url'] = $this->getThumbimageOld($_file[0]['filename'], $list[$i]['regdate'], $list[$i]['rid']);
			}
			$list[$i]['is_thumb'] = ($_file[0]['filename'] == "") ? "0" : "1";
			$list[$i]['blog_icon'] = $CLASS_BLOG->getBlogIcon($list[$i]['url']);
		}
		return $list;
	}

	public function isRecomTime($regdate, $day) 
	{
		$time1 = strtotime($regdate);
		$time2 = mktime(date("H"),date("i"),date("s"), date("m"), date("d")-$day, date("Y"));
		//echo date("Y-m-d H:i:s", $time);
		//echo "<br />";
		//echo $regdate; 
		if($time1 < $time2) {
			return true;
		} else {
			return false;
		}
	}

	public function isRecomDay($db, $rno, $userno, $day="1") 
	{		
		$where = "";
		if(!empty($day)) {
			$date = date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$day, date("Y")));
			$where .= " AND regdate >= '".$date."' ";
		}
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_recom 
		WHERE		rno = ".$rno." 
		AND 		userno = ".$userno."
		".$where."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isRecomUser($db, $userno, $ruserno, $day="1", $num="1") 
	{		 
		$where = "";
		if(!empty($day)) {
			$date = date("Y-m-d H:i:s", mktime(23,59,59, date("m"), date("d")-$day, date("Y")));
			$where .= " AND regdate >= '".$date."' ";
		}
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_recom 
		WHERE		userno = ".$userno." 
		AND 		ruserno = ".$ruserno."
		".$where."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] >= $num) {
			return true;
		} else {
			return false;
		}
	}

	public function isRecomIP($db, $rno, $ip) 
	{
		$ip = trim($ip);
		if(substr_count($ip, ".") != 3 || $ip == "") {
			return true;
		}		
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_recom 
		WHERE		rno = ".$rno." 
		AND 		ip = '".$ip."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getMyReviewCount($db, $userno, $blogno="") 
	{
		$sql = "
		SELECT		COUNT(rno) as cnt	
		FROM		Ru_review 
		WHERE		status = '1' 
		".$this->getMyWhere($userno, $blogno)."
		".$limit."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getMyReviewList($db, $limit, $userno, $blogno="") 
	{
		$sql = "
		SELECT		rno 
		FROM		Ru_review 
		WHERE		status = '1'  
		".$this->getMyWhere($userno, $blogno)."
		ORDER BY 	rno DESC 
		".$limit."		 
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	private function getMyWhere($userno, $blogno) 
	{		
		$where = "";		
		$where .= " AND userno = ".$userno;
		$where .= ($blogno != "") ? " AND blogno = ".$blogno : "";
		return $where;
	}

	public function getFriendUserno($db, $userno, $groupno="")
	{
		$where = "";
		$where .= ($groupno != "") ? " AND groupno = ".$groupno : "";
		$sql = "
		SELECT		userno, fuserno
		FROM		Ru_friend 
		WHERE 		(userno = ".$userno." OR fuserno = ".$userno.")
		".$where."
		"; 
		//echo $sql;
		$rs = $db->fetch($sql);		
		$fuserno = array();
		for($i=0; $i<sizeof($rs); $i++) {
			if($rs[$i]['userno'] != $userno) {
				$fuserno[] = $rs[$i]['userno']; 
			}
			if($rs[$i]['fuserno'] != $userno) {
				$fuserno[] = $rs[$i]['fuserno']; 
			}
		}
		//$fuserno[] = "93"; 
		return $fuserno;
	}

	public function getFriendReviewCount($db, $fuserno)
	{
		if(sizeof($fuserno) > 0) {
			$sql = "
			SELECT		COUNT(rno) as cnt 
			FROM		Ru_review 
			WHERE		status = '1'  
			".$this->getFriendWhere($fuserno)."
			";
			//echo $sql;		 
			$row = $db->fetch($sql, true);
			return $row['cnt'];
		} else {
			return 0;
		}
	}

	public function getFriendReviewList($db, $limit, $fuserno)
	{
		if(sizeof($fuserno) > 0) {
			$sql = "
			SELECT		rno  
			FROM		Ru_review
			WHERE		status = '1'  
			".$this->getFriendWhere($fuserno)."
			ORDER BY 	rno DESC 
			".$limit."		 
			";
			//echo $sql;
			$rs = $db->fetch($sql);
			return $rs;
		} 
	} 

	public function getFriendWhere($fuserno)
	{		
		$where = "";
		$where .= " AND userno IN(".implode(",", $fuserno).")";
		return $where;
	}

	public function getRecomReviewCount($db, $userno)
	{
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_recom  
		WHERE 		userno = ".$userno."
		"; 
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getRecomReviewList($db, $limit, $userno)
	{
		$sql = "
		SELECT		rno  
		FROM		Ru_review_recom 
		WHERE		userno = ".$userno." 
		ORDER BY 	rno DESC 
		".$limit."		 
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getOrderReviewListByRecom($db, $num=5, $day=1) 
	{
		$date = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"), date("m"), date("d")-$day, date("Y")));
		$sql = "
		SELECT		rno, recom_cnt   
		FROM		Ru_review  
		WHERE 		cate1 IN ('10','11','12','13','14','99')
		AND 		regdate BETWEEN '".$date."' AND '".date("Y-m-d H:i:s")."'
		ORDER BY 	recom_cnt DESC 
		LIMIT 		".$num."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;		
	}

	public function getChartBarPercent($recom_cnt)
	{
		$size = array();
		if(sizeof($recom_cnt) > 0) {
			arsort($recom_cnt);
			$max = $recom_cnt[0];
			$min = $recom_cnt[sizeof($recom_cnt)-1];
		}
		if($max == 0) {
			for($i=0; $i<sizeof($recom_cnt); $i++) {
				$size[$i] = 0;
			}
		} else {
			$unit = round(100/$max);
			for($i=0; $i<sizeof($recom_cnt); $i++) {
				$size[$i] = $unit * $recom_cnt[$i];
				if($size[$i] > 100) $size[$i] = 100;
				else if($size[$i] < 1) $size[$i] = 0;
			}
		}
		
		return $size;
	}

	public function getManagerReviewCount($db, $opt="", $keyword="") 
	{
		$whereArr = $this->getManagerWhere($db, $opt, $keyword);		
		$sql = "
		SELECT		COUNT(rno) as cnt	
		FROM		".$whereArr['table']." 
		WHERE		1 
		".$whereArr['where']."
		";	
		//echo $sql;
		//echo "<Br/><br />";
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getManagerReviewList($db, $limit, $opt="", $keyword="") 
	{
		$whereArr = $this->getManagerWhere($db, $opt, $keyword);		
		$sql = "
		SELECT		rno 
		FROM		".$whereArr['table']." 
		WHERE		1 
		".$whereArr['where']."
		".$limit."
		";
		//echo $sql;
		//echo "<br />";
		$rs = $db->fetch($sql);
		return $rs;		
	}

	private function getManagerWhere($db, $opt, $keyword) 
	{
		$where = "";		
		$table = "";
		if(!empty($keyword)) {
			switch($opt) {
				case "title" : 
					$table = "Ru_review_contents"; 
					$where .= " AND title like '".$keyword."%' ";				
					break;
				case "nickname" : 
					$sql = "
					SELECT 		userno 
					FROM 		Ru_account 
					WHERE 		nickname = '".trim($keyword)."'
					";
					$user = $db->fetch($sql, true);
					$table = "Ru_review"; 
					$where .= " AND userno = '".$user['userno']."'";
					break;
				default : 
					break;
			}
		}
		$whereArr = array();
		$whereArr['where'] = $where;
		$whereArr['table'] = $table;
		return $whereArr;
	}
}