<?php
class PowerBlog
{
	var $cate;
	var $flag;
	
	public function PowerBlog()
	{
		$this->cate = array(
			"1"=>"디지털/가전/휴대폰",
			"2"=>"맛집/요리",
			"3"=>"여행",
			"4"=>"영화/TV/연극/공연",
			"5"=>"스포츠",
			"6"=>"자동차/바이크/자전거",
			"7"=>"패션/인테리어",
			"8"=>"도서",
			"9"=>"음악",
			"10"=>"시사",
			"11"=>"육아/와이프로거",
			"12"=>"레포츠/레저",
			"13"=>"화장품/미용",
			"14"=>"애완동물",
			"15"=>"취미/게임"
		);
		
		$this->flag = array(
			"0"=>"심사중",
			"1"=>"파워블로그선정",
			"2"=>"거절"
		);
	}
	
	public function getPowerBlog($db, $userno) 
	{	
		$sql = "
		SELECT		ano, userno, cate1, cate2, cate3,  
					cate4, cate5, flag_app, regdate  
		FROM		Ra_powerblog_application  
		WHERE		userno = ".$userno." 
		AND 		flag_app = '1' 
		ORDER BY 	regdate DESC 
		LIMIT 		1 
		";
		$row = $db->fetch($sql, true);
		if($row['cate1'] != "") $row['cate_desc1'] = $this->cate[$row['cate1']];
		if($row['cate2'] != "") $row['cate_desc2'] = $this->cate[$row['cate2']];
		if($row['cate3'] != "") $row['cate_desc3'] = $this->cate[$row['cate3']];
		if($row['cate4'] != "") $row['cate_desc4'] = $this->cate[$row['cate4']];
		if($row['cate5'] != "") $row['cate_desc5'] = $this->cate[$row['cate5']];
		return $row;
	}
	
	public function getPowerBlogCount($db, $flag="", $cate="", $opt, $keyword) 
	{	
		$sql = "
		SELECT		COUNT(ano) as cnt
		FROM		Ra_powerblog_application  
		WHERE		
		".$this->getWhere($flag, $cate, $opt, $keyword)."
		";		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}	
	
	public function getPowerBlogList($db, $limit, $flag="", $cate="", $opt, $keyword) 
	{
		$sql = "
		SELECT		ano, userno, cate1, cate2, cate3,  
					cate4, cate5, flag_app, regdate  
		FROM		Ra_powerblog_application  
		WHERE		
		".$this->getWhere($flag, $cate, $opt, $keyword)."
		ORDER BY 	ano DESC 
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;	
	}	
	
	private function getWhere($flag, $cate, $opt, $keyword)
	{
		$where = " 1 ";
		if($flag != "" && $flag != "all") $where .= " AND flag_app = '".$flag."' ";		
		if($cate != "") $where .= " AND (cate1 = '".$cate."' OR cate2 = '".$cate."' OR cate3 = '".$cate."' OR cate4 = '".$cate."' OR cate5 = '".$cate."' ) ";
		switch($opt) {
			case "nickname" :				 
				break; 
			default : 
				break;
		}
		return $where;
	}
}
?>