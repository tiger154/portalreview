<?php
class Site
{
	public function Site()
	{
	}

/*
  2012.07.06 1) A	 dded ko-locale replace logic, 2) Added result time format define 
*/	
function getPastTime($regdate)
{
	// replace ko-locale to null
	$string = $regdate;
	$pattern = '/[ㄱ-ㅎㅏ-ㅣ가-힣]/';
	$replacement = '';
	$return_regdate= preg_replace($pattern, $replacement, $string);

	// start time cal [WAS and DB time distance maby 8minute]
	$ptime = time()+(60*9) - strtotime($return_regdate);
	$time = array();
	$time['day'] = floor($ptime/60/60/24);
	$time['hour'] =  ($ptime/60/60)%24;
	$time['min2'] = ($ptime/60)%60;
	$time['min'] = floor($ptime / 60);
	$time['sec'] = round($ptime % 60);

	
	if($time['day'] <= 0){		
		if($time['hour'] <= 0){
			$time['result_time'] = $time['min2']."분 ".$time['sec']."초 전";
		}else{
			$time['result_time'] =$time['hour']."시간 ".$time['min2']."분 ".$time['sec']."초 전";
		}		
	}else{
		$time['result_time'] = $time['day']."일 ".$time['hour']."시간 ".$time['min2']."분 ".$time['sec']."초 전";
	}	

	return $time;
}
/*
	DiffDatetime cal 
	@return Array sample : print_r(otherDiffDate('2020-01-01 20:30:00',true));
		Array
		(
			[Years] => 07
			[Months] => 08
			[Days] => 15
			[Hours] => 03
			[Minutes] => 3
			[Seconds] => 48
		)
*/
	function otherDiffDate($end='2012-06-12 10:30:00', $out_in_array=false)
	{
        $intervalo = date_diff(date_create(), date_create($end));
        $out = $intervalo->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
        if(!$out_in_array)
            return $out;
        $a_out = array();
        array_walk(explode(',',$out),
        function($val,$key) use(&$a_out){
            $v=explode(':',$val);
            $a_out[$v[0]] = $v[1];
        });
        return $a_out;
	}

	public function getNotice($db, $num=4)
	{
		$where = "";
		if(is_int($num) && $num != "") $where .= "LIMIT ".$num;
		$sql = "
		SELECT		bno, title, url, pubdate, regdate 
		FROM		Ru_cache_notice
		".$where."
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getKeywordReview($db, $kno, $num=3)
	{
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$CLASS_REVIEWKEYWORD = &Module::singleton("Review.ReviewKeyword");		
		$limit = "LIMIT ".$num;
		$list = $CLASS_REVIEWKEYWORD->getKeywordLinkList($db, $kno, $limit);
		$list = $CLASS_REVIEW->getReviewDataBind($db, $list);
		$recom_cnt = array(); 
		for($i=0; $i<$num; $i++) {			
			$list[$i]['thumbimage_url'] = $CLASS_REVIEWKEYWORD->getKeywordImage($kno, $list[$i]['rno'].".jpg");
			$recom_cnt[] = $list[$i]['recom_cnt'];
		}
		$size = $CLASS_REVIEW->getChartBarPercent($recom_cnt);
		for($i=0; $i<$num; $i++) {
			$list[$i]['size'] = $size[$i];
		}
		return $list;
	}

	public function getRecomReviewByOrder($db, $num=5)
	{
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$sql = "
		SELECT		rno  
		FROM		Ru_cache_review_recom  
		ORDER BY 	bno ASC 
		LIMIT 		".$num."
		";
		//echo $sql;
		$list = $db->fetch($sql);
		$list = $CLASS_REVIEW->getReviewDataBind($db, $list);
		$recom_cnt = array(); 
		for($i=0; $i<$num; $i++) {
			$recom_cnt[] = $list[$i]['recom_cnt'];
		}		
		$size = $CLASS_REVIEW->getChartBarPercent($recom_cnt);
		for($i=0; $i<$num; $i++) {
			$list[$i]['size'] = $size[$i];
		}
		return $list;
	}

	public function getRecomReviewByRegdate($db, $num=5) 
	{
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$sql = "
		SELECT		DISTINCT rno  
		FROM		Ru_review_recom  
		ORDER BY 	regdate DESC 
		LIMIT 		".$num."
		";
		//echo $sql;
		$list = $db->fetch($sql);
		$recom_cnt = array(); 
		$list = $CLASS_REVIEW->getReviewDataBind($db, $list);
		$recom_cnt = array(); 
		for($i=0; $i<$num; $i++) {
			$recom_cnt[] = $list[$i]['recom_cnt'];
		}
		$size = $CLASS_REVIEW->getChartBarPercent($recom_cnt);
		for($i=0; $i<$num; $i++) {
			$list[$i]['size'] = $size[$i];
		}
		return $list;	
	}

	public function getNoticeReview($db, $cate)
	{
		$sql = "
		SELECT		*   
		FROM		Ru_cache_review_notice
		WHERE 		cate = '".$cate."'
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getBestReview($db,$titlemaxlenUse=false,$titlemaxlen=20)
	{
		$CLASS_BASE = &Module::singleton("Base");
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");
		$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($db,date("Y-m-d"));//now wno from Ru_review_best_week

		// $wno_now = $CLASS_REVIEWBEST->getBestWeekWno($db, date("Y-m-d"));//now wno from Ru_review_best_week
		//		echo $wno_now;
		$wno = $CLASS_REVIEWBEST->getBestWeekPrev($db, $wno_now); //Prev wno from  Ru_review_best_week
		// 2012.05.30 start
		$prev_wno = $CLASS_REVIEWBEST->getBestWeekPrev($db, $wno); 
		$next_wno = $CLASS_REVIEWBEST->getBestWeekNext($db, $wno);
		$prev_wno = ($prev_wno == "") ? $wno : $prev_wno;
		$next_wno = ($next_wno == "") ? $wno : $next_wno;
		// 2012.05.30 end
		$_list = $CLASS_REVIEWBEST->getBestReview($db, $wno, $limit=6);
		if(!$titlemaxlenUse) {
			$list = $CLASS_REVIEW->getReviewDataBind($db, $_list);
		}else{
			$list = $CLASS_REVIEW->getReviewDataBind($db, $_list, $titlemaxlenUse, $titlemaxlen);
		}
		for($i=0; $i<sizeof($list); $i++) {
			$list[$i]['best_recom_cnt'] = $_list[$i]['best_recom_cnt'];
		}
		$bestdate = $CLASS_REVIEWBEST->getBestWeekDate($db, $wno);
		$bestdate['sdate'] = $CLASS_BASE->transDate($bestdate['sdate'], "E");
		$bestdate['edate'] = $CLASS_BASE->transDate($bestdate['edate'], "E");
		$data = array();
		$data['list'] = $list;
		$data['date'] = $bestdate;
		$data['prev_wno'] = $prev_wno; //2012.05.30
		$data['next_wno'] = $next_wno; //2012.05.30
		return $data;
	}

   public function getBestReviewSearch($db,$titlemaxlenUse=false,$titlemaxlen=20,$wno)
	{
		$CLASS_BASE = &Module::singleton("Base");
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$CLASS_REVIEWBEST = &Module::singleton("Review.ReviewBest");

//		$wno_now = $CLASS_REVIEWBEST->getBestWeekWno($db, date("Y-m-d"));//now wno from Ru_review_best_week
//		$wno = $CLASS_REVIEWBEST->getBestWeekPrev($db, $wno_now); //Prev wno from  Ru_review_best_week
		// 2012.05.30 start
		$prev_wno = $CLASS_REVIEWBEST->getBestWeekPrev($db, $wno); 
		$next_wno = $CLASS_REVIEWBEST->getBestWeekNext($db, $wno);
		$prev_wno = ($prev_wno == "") ? $wno : $prev_wno;
		$next_wno = ($next_wno == "") ? $wno : $next_wno;
		// 2012.05.30 end
		$_list = $CLASS_REVIEWBEST->getBestReview($db, $wno, $limit=6);
		if(!$titlemaxlenUse) {
			$list = $CLASS_REVIEW->getReviewDataBind($db, $_list);
		}else{
			$list = $CLASS_REVIEW->getReviewDataBind($db, $_list, $titlemaxlenUse, $titlemaxlen);
		}
		for($i=0; $i<sizeof($list); $i++) {
			$list[$i]['best_recom_cnt'] = $_list[$i]['best_recom_cnt'];
		}
		$bestdate = $CLASS_REVIEWBEST->getBestWeekDate($db, $wno);
		$bestdate['sdate'] = $CLASS_BASE->transDate($bestdate['sdate'], "E");
		$bestdate['edate'] = $CLASS_BASE->transDate($bestdate['edate'], "E");
		$data = array();
		$data['list'] = $list;
		$data['date'] = $bestdate;
		$data['prev_wno'] = $prev_wno; //2012.05.30
		$data['next_wno'] = $next_wno; //2012.05.30
		return $data;
	}


	public function getRealtimeReview($db, $type, $cate, $num=3)
	{
		$CLASS_REVIEW = &Module::singleton("Review.Review");
		$CLASS_CODE = &Module::singleton("Code.Code");
		$limit = "LIMIT 0, ".$num;
		$date[0] = date("Y-m-d H:i:s", mktime(date("H"),date("i"),date("s"), date("m"), date("d")-7, date("Y"))); 
		$date[1] = date("Y-m-d H:i:s");
		if($type != "F") {
			$cateArr = $CLASS_CODE->transCate($cate);
		} else {
			$cateArr = array();
		}
		$list = $CLASS_REVIEW->getReviewList($db, $limit, $type, $cateArr, $status="1", $date);
		$list = $CLASS_REVIEW->getReviewDataBind($db, $list);
		for($i=0; $i<sizeof($list); $i++) {
			$time = $this->getPastTime($list[$i]['regdate']);
			$list[$i]['pasttime'] = $time['min']."분 ".$time['sec']."초 전";
		}
		return $list;
	}

	public function getRealtimeTalk($db)
	{
		$CLASS_FRONTIER = &Module::singleton("Frontier.Frontier");
		$CLASS_USER = &Module::singleton("User.User");
		$list = $CLASS_FRONTIER->FrontierMainTalk($db);
		for($i=0; $i<sizeof($list); $i++) {
			$list[$i]['content'] = strip_tags($list[$i]['content']); 
			$time = $this->getPastTime($list[$i]['regdate']);
			$list[$i]['pasttime'] = $time['result_time'];
			$user = $CLASS_USER->getUser($db, $list[$i]['userno']);
			$extra = $CLASS_USER->getUserExtra($db, $list[$i]['userno']);
			$list[$i]['userimage'] = $CLASS_USER->getImage($list[$i]['userno'], $extra['userimage']);  
		}
		return $list;
	}


	

	public function getRealtimeTalkByAll($db)
	{
		$CLASS_USER = &Module::singleton("User.User");
		$sql = "
		(SELECT no, userno, nickname, content, delflag, division as t_from,regdate FROM Ru_frontier_entrytalk where delflag = '0' and  division = 'T' order by no desc limit 0,2)
			union
		(SELECT tno as no, userno, nickname, talk as content, flag_del as delflag, blogno as t_from, regdate FROM Ru_review_talk where flag_del = '0' order by tno desc limit 0,2)  
			order by regdate desc
		";		

		$list = $db->fetch($sql,false,false,1);


		for($i=0; $i<sizeof($list); $i++) {
			$list[$i]['content'] = strip_tags($list[$i]['content']); 
			$time = $this->getPastTime($list[$i]['regdate']);
			$list[$i]['pasttime'] = $time['result_time']; //substr($list[$i]['regdate'],0,10); // $result_date //$time['min']."분 ".$time['sec']."초 전";
			$user = $CLASS_USER->getUser($db, $list[$i]['userno']);
			$extra = $CLASS_USER->getUserExtra($db, $list[$i]['userno']);
			$list[$i]['userimage'] = $CLASS_USER->getImage($list[$i]['userno'], $extra['userimage']);  
		}
		return $list;
	}
}
?>