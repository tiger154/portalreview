<?php
class ReviewBest extends Review
{
	public function ReviewBest()
	{
	}

	public function isBestReview($db, $wno, $rno)
	{
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best 
		WHERE		wno = ".$wno."
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

	public function isBestCandReview($db, $wno, $rno)
	{		
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best_cand 
		WHERE		wno = ".$wno."
		AND 		rno = ".$rno." 
		";
		// //echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isBestCandUser($db, $wno, $userno)
	{
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best 
		WHERE		wno = ".$wno."
		AND 		userno = ".$userno." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isBestUserPrev($db, $wno, $userno)
	{
		$prev_wno = $this->getBestWeekPrev($db, $wno);
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best 
		WHERE		wno = ".$prev_wno."
		AND 		userno = ".$userno." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isBestUser($db, $wno, $userno)
	{
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best 
		WHERE		wno = ".$wno."
		AND 		userno = ".$userno." 
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function isBestRecomUser($db, $wno, $rno, $userno) 
	{		 
		$where = "";
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best_recom 
		WHERE		wno = ".$wno." 
		AND 		rno = ".$rno."
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

	public function isBestRecomIP($db, $wno, $cate1, $ip) 
	{
		$ip = trim($ip);
		if(substr_count($ip, ".") != 3 || $ip == "") {
			return true;
		}
		
		$sql = "
		SELECT		COUNT(rno) as cnt
		FROM		Ru_review_best_recom 
		WHERE		wno = ".$wno." 
		AND 		cate1 = '".$cate1."'
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

	public function getBestWeekCount($db) 
	{
		$sql = "
		SELECT		COUNT(wno) as cnt
		FROM		Ru_review_best_week
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getBestWeekList($db, $limit) 
	{
		$sql = "
		SELECT		*
		FROM		Ru_review_best_week
		ORDER BY	wno DESC 
		".$limit."
		
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestCandReview($db, $wno, $rno) 
	{
		$sql = "
		SELECT		* 
		FROM		Ru_review_best_cand 
		WHERE		wno = ".$wno."
		AND 		rno = ".$rno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getBestList($db, $wno, $num=6) 
	{
		$sql = "
		SELECT		RB.wno, RB.userno, RB.rno, RB.recom_cnt, RB.rank, RB.regdate, 
					R.point, R.recom_cnt, R.talk_cnt, R.view_cnt, RC.title,    						
					A.userno, A.userid, A.nickname, A.regdate, AC.cash
		FROM		Ru_review_best RB 
		INNER JOIN	Ru_review R ON(RB.rno = R.rno)
		INNER JOIN	Ru_review_contents RC ON(R.rno = RC.rno)
		INNER JOIN	Ru_account A ON(RB.userno = A.userno)
		INNER JOIN	Ru_account_cash AC ON(A.userno = AC.userno)
		WHERE 		RB.wno = '".$wno."'
		AND 		RB.rank > 0 
		LIMIT		".$num."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestVoteList($db, $wno, $cate, $num=6) 
	{
		GLOBAL $BASE;
		$CLASS_USER = &Module::singleton("User.User");
		$CLASS_CODE = &Module::singleton("Code.Code");
		
		$size = sizeof($cate);
		$rs = array();
		
		for($i=0; $i<$size; $i++) {
			$rs[$i]['wno'] = $wno;
			$rs[$i]['cate1'] = $cate[$i];
			$rs[$i]['cate_desc'] = $CLASS_CODE->getCateDesc($db, $CLASS_CODE->transCate($cate[$i]));
			$sql = "
			SELECT		RB.wno, RB.rno, RB.cate1, RB.recom_cnt as best_recom_cnt, RB.regdate, 
						R.url, R.point, R.recom_cnt, R.talk_cnt, R.view_cnt, RC.title, 
						A.userno, A.userid, A.nickname, AC.cash  
						
			FROM		Ru_review_best_cand RB 
			INNER JOIN	Ru_review R ON(RB.rno = R.rno)
			INNER JOIN	Ru_review_contents RC ON(R.rno = RC.rno)
			INNER JOIN	Ru_account A ON(RB.userno = A.userno) 
			INNER JOIN	Ru_account_cash AC ON(A.userno = AC.userno)
			WHERE 		RB.wno = '".$wno."'
			AND 		RB.cate1 = '".$cate[$i]."' 
			ORDER BY	RB.recom_cnt
			LIMIT		".$num."
			";
			//echo $sql;
			$rs[$i]['list'] = $db->fetch($sql);
		}
		return $rs;
	}

	public function getBestCandRankList($db, $wno, $limit=6) 
	{
		$sql = "
		SELECT		wno, userno, rno, cate1, recom_cnt  
		FROM		Ru_review_best_cand 
		WHERE		wno = ".$wno." 
		ORDER BY 	recom_cnt  DESC
		LIMIT 		".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestCandRankCateList($db, $wno, $rno) 
	{
		$sql = "
		SELECT 		RBC1.wno, RBC1.userno, RBC1.rno, RBC1.cate1, RBC1.recom_cnt
		FROM 		Ru_review_best_cand RBC1 
		JOIN 		(
					SELECT cate1, MAX(recom_cnt) AS recom_cnt 
					FROM Ru_review_best_cand
					WHERE wno = ".$wno." 
					AND rno NOT IN(".$rno.") 
					GROUP BY cate1 
					ORDER BY recom_cnt DESC 
		) AS RBC2 ON RBC1.cate1 = RBC2.cate1 
		AND 		RBC1.recom_cnt = RBC2.recom_cnt 
		WHERE 		RBC1.wno = ".$wno."
		GROUP BY 	RBC1.cate1 
		ORDER BY 	RBC1.recom_cnt DESC;
		";
		//echo $sql;
		$row = $db->fetch($sql);
		return $row;
	}

	public function getBestCandSimpleList($db, $wno) 
	{
		$sql = "
		SELECT		rno 
		FROM		Ru_review_best_cand 
		WHERE		wno = ".$wno."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestCandList($db, $wno, $cate, $num=20) 
	{
		GLOBAL $BASE;
		$CLASS_USER = &Module::singleton("User.User");
		$CLASS_CODE = &Module::singleton("Code.Code");		
		$_review = $this->getBestCandSimpleList($db, $wno);
		$rArr = array();
		for($i=0; $i<sizeof($_review); $i++) {
			$rArr[] = $_review[$i]['rno'];
		}		
		$_wno = $this->getBestWeekPrev($db, $wno);
		$_review = $this->getBestReview($db, $_wno);
		$uArr = array();
		for($i=0; $i<sizeof($_review); $i++) {
			$uArr[] = $_review[$i]['userno'];
		}
		$date = $this->getBestWeekDate($db, $wno);
		$size = sizeof($cate);
		$rs = array();		
		for($i=0; $i<$size; $i++) {
			$rs[$i]['wno'] = $wno;
			$rs[$i]['cate1'] = $cate[$i];
			$rs[$i]['cate_desc'] = $CLASS_CODE->getCateDesc($db, $CLASS_CODE->transCate($cate[$i]));
			$sql = "
			SELECT		R.rno, R.url, R.point, R.recom_cnt, R.talk_cnt, R.view_cnt, R.regdate, RC.title, 						
						A.userno, A.userid, A.nickname, AC.cash  
			FROM		Ru_review R
			INNER JOIN	Ru_review_contents RC ON(R.rno = RC.rno)
			INNER JOIN	Ru_account A ON(R.userno = A.userno)
			INNER JOIN	Ru_account_cash AC ON(A.userno = AC.userno)
			WHERE 		R.cate1 = '".$cate[$i]."' 
			AND 		R.regdate BETWEEN '".$date['sdate']." 00:00:00' AND '".$date['edate']." 23:59:59'
			AND 		R.point > 0
			ORDER BY	R.point DESC 
			LIMIT		".$num."
			";
			// concat(SUBSTRING(RC.title,1,30),'...') as title, 
			//INNER JOIN	Ru_account_stats AST ON(A.userno = AST.userno)
			//INNER JOIN	Ru_account_point AP ON(AC.userno = AP.userno)
			//AND 		point > 0
			//echo $sql;
			$rs[$i]['list'] = $db->fetch($sql);			
			for($j=0; $j<sizeof($rs[$i]['list']); $j++) {
				
				//if($this->isBestReview($db, $wno, $rs[$i]['list'][$j]['rno']) == true) {
				if(in_array($rs[$i]['list'][$j]['rno'], $rArr) == true) {
					$rs[$i]['list'][$j]['flag_best'] = "1";
					$rs[$i]['list'][$j]['flag_best_text'] = "<b>선정</b>";
				} else {
					$rs[$i]['list'][$j]['flag_best'] = "0";
					$rs[$i]['list'][$j]['flag_best_text'] = "";
				}
				
				if(in_array($rs[$i]['list'][$j]['userno'], $uArr) == true) {
					$rs[$i]['list'][$j]['flag_user'] = "1";
					$rs[$i]['list'][$j]['flag_user_text'] = "<b><font color='red'>지난주베스트회원</font></b>";
				} else {
					$rs[$i]['list'][$j]['flag_user'] = "0";
					$rs[$i]['list'][$j]['flag_user_text'] = "";
				} 
			}
		}
		return $rs;
	}

	public function getBestCandRecomList($db, $wno, $rno) 
	{					
		$sql = "
		SELECT		wno, userno, rno, regdate  
		FROM		Ru_review_best_recom  
		WHERE		wno = ".$wno." 
		AND 		rno = ".$rno."
		ORDER BY 	regdate DESC  
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestWeekWno($db, $date) 
	{
		$sql = "
		SELECT		wno 
		FROM		Ru_review_best_week
		WHERE		sdate <= '".$date."' 
		AND			edate >= '".$date."'
		";

//		$sql = "
//		SELECT	 wno 
//		FROM		Ru_review_best
//		order by wno desc
//		limit 0,1
//		";

		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['wno'];
	}

	public function getBestWeekDate($db, $wno) 
	{
		$sql = "
		SELECT		sdate, edate 
		FROM		Ru_review_best_week
		WHERE		wno = ".$wno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}

	public function getBestWeekPrev($db, $wno)
	{
		$sql = "
		SELECT		MAX(wno) as wno
		FROM		Ru_review_best_week
		WHERE		wno < ".$wno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);		
		return $row['wno'];
	}

	public function getBestWeekNext($db, $wno)
	{
		$sql = "
		SELECT		MIN(wno) as wno
		FROM		Ru_review_best_week
		WHERE		wno > ".$wno."
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);		
		return $row['wno'];
	}

	public function getBestWeekLast($db)
	{
		$sql = "
		SELECT		MAX(wno) as wno
		FROM		Ru_review_best_week
		";
		//echo $sql;		 
		$row = $db->fetch($sql, true);		
		return $row['wno'];
	}

	public function getBestReview($db, $wno, $limit=6) 
	{
		$sql = "
		SELECT		wno, userno, rno, rank, recom_cnt as best_recom_cnt, regdate
		FROM		Ru_review_best
		WHERE		wno = ".$wno."
		ORDER BY	rank ASC  
		LIMIT		0, ".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getBestReviewCountByUser($db, $userno) 
	{
		$sql = "
		SELECT		COUNT(wno) as cnt 
		FROM		Ru_review_best
		WHERE		userno = ".$userno."
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}
	
	public function getBestReviewByUser($db, $userno, $limit=6) 
	{
		$sql = "
		SELECT		wno, userno, rno, rank, recom_cnt as best_recom_cnt, regdate
		FROM		Ru_review_best
		WHERE		userno = ".$userno."
		ORDER BY	rno DESC  
		LIMIT		0, ".$limit."
		";
		//echo $sql;
		$rs = $db->fetch($sql);		
		for($i=0; $i<sizeof($rs); $i++) {
			$date = $this->getBestWeekDate($db, $rs[$i]['wno']);
			$rs[$i]['sdate'] = $date['sdate'];
			$rs[$i]['edate'] = $date['edate'];
			$rs[$i]['review'] = $this->getReview($db, $rs[$i]['rno']);
		}
		//print_r($rs);
		return $rs;
	}
}
