<?php
class ReviewKeyword extends Review
{
	public function ReviewKeyword()
	{
	}
		
	public function getKeywordListByOrder($db)
	{
		$sql = "
		SELECT		RKS.kno, RK.keyword   
		FROM		Ru_review_keyword_seq RKS 
		INNER JOIN 	Ru_review_keyword RK 
		WHERE 		RKS.kno = RK.kno 
		ORDER BY 	RKS.seq ASC
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getKeyword($db, $kno)
	{
		$sql = "
		SELECT		kno, keyword, regdate 
		FROM		Ru_review_keyword 
		WHERE 		kno = ".$kno."
		";
		// //echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function getKeywordImage($kno, $image) 
	{
		if($image != "") {
			$dir = ceil($kno/1000);
			$url = "http://"._DOMAIN_FILE."/"._FTP_KEYWORDIMAGE."/".$dir."/".$image;
		} else {
			$url = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";
		}
		return $url;
	}
	
	public function getKeywordCount($db, $kno)
	{		
		$sql = "
		SELECT		COUNT(kno) as cnt
		FROM		Ru_review_keyword 
		";
		// //echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	public function getKeywordList($db, $limit)
	{		
		$sql = "
		SELECT		kno, keyword, regdate 
		FROM		Ru_review_keyword
		ORDER BY 	kno DESC 
		".$limit."
		";
		// //echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function isKeywordLink($db, $kno, $rno)
	{		
		$sql = "
		SELECT		COUNT(rno) as cnt 
		FROM		Ru_review_keyword_link  
		WHERE		kno = ".$kno." 
		AND 		rno = ".$rno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getKeywordLinkList($db, $kno, $limit)
	{		
		$sql = "
		SELECT		kno, rno, seq, regdate   
		FROM		Ru_review_keyword_link  
		WHERE		kno = ".$kno."
		ORDER BY 	seq ASC
		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getKeywordSeq($db)
	{
		$sql = "
		SELECT		kno  
		FROM		Ru_review_keyword_seq  
		ORDER BY 	seq ASC
		";
		// //echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
}
