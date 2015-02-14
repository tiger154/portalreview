<?php

class Frontier
{
	public function Frontier()
	{
	}
		
	public function getCate1List($db)
	{
		$sql = "
		SELECT			cate1, cate_desc
		
		FROM			Rf_cate1_code
		";
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function getCate2List($db, $cate1)
	{
		$sql = "
		SELECT			cate2, cate_desc
		FROM			Rf_cate2_code
		WHERE         cate1 = '$cate1'
		";

		$rs = $db->fetch($sql);
		return $rs;
	}
	


	public function getCate3List($db, $cate1, $cate2)
	{
		$sql = "
		SELECT			cate3, cate_desc
		
		FROM			Rf_cate3_code
		
		WHERE         cate1 = '$cate1' 
		
		AND				cate2 = '$cate2'
		";

		$rs = $db->fetch($sql);
		return $rs;
	}
	

	public function getCate4List($db, $cate1, $cate2, $cate3)
	{
		$sql = "
		SELECT			cate4, cate_desc
		
		FROM			Rf_cate4_code
		
		WHERE         cate1 = '$cate1' 
		
		AND				cate2 = '$cate2'
		
		AND				cate3 = '$cate3'
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdmingetCate1List($db)
	{
		$sql = "
		SELECT			cate1, cate_desc
		
		FROM			Rf_cate1_code
		";

		$rs = $db->fetch($sql);
		return $rs;
	}



	public function getListCount($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		

		$today = date("YmdHis");


		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '$flag_delete'";
					}else{
						$where = "WHERE subject like '$frname%'";
						$where .= "AND end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '$flag_delete'";
					}
				break;

				case "B":
				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date > '$today' AND confirm = '$flag_delete'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date > '$today' AND confirm = '$flag_delete'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '$flag_delete'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '$flag_delete'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE end_date < '$today' AND due_edate < '$today' AND confirm = '$flag_delete'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND end_date < '$today' AND due_edate < '$today' AND confirm = '$flag_delete'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE subject like '$frname%' AND confirm = '$flag_delete'";

		}

		$sql = "
		SELECT		COUNT(frno) as cnt

		FROM		Ru_frontier_binfo 

		".$where." 

		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}




	public function AdmingetListCount($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		

		$today = date("YmdHis");


		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}else{
						$where = "WHERE subject like '$frname%'";
						$where .= "AND end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date > '$today' AND confirm = '0'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE subject like '%$frname%' AND confirm = '0'";

		}

		$sql = "
		SELECT		COUNT(frno) as cnt

		FROM		Ru_frontier_binfo 

	
		".$where." 
		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}


	public function getFringListCount($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		

		$today = date("YmdHis");



		if($frname == ""){
			$where = "WHERE end_date < '$today' AND notice_date < '$today' AND due_edate > '$today'";
		}else{
			$where = "WHERE subject like '$frname%'";
			$where .= "AND end_date < '$today' AND notice_date < '$today' AND due_edate > '$today'";
		}
	

		$sql = "
		SELECT		COUNT(frno) as cnt

		FROM		Ru_frontier_binfo

		".$where." 

		AND confirm = '$flag_delete'

		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}



	public function getEndListCount($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		

		$today = date("YmdHis");

		$sql = "
			SELECT COUNT(a.frno) as cnt 
		
			FROM Ru_frontier_binfo a, Ru_frontier_orinfo b 
		
			WHERE a.end_date < '20111023084213' 
		
			AND a.due_edate < '20111023084213' 
		
			AND a.frno = b.frno 
			
			AND a.confirm = '$flag_delete'

			ORDER BY a.frno
		";


		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}




	public function setWhere($code, $flag_delete, $btitle, $sch_opt, $sch_con)
	{
		$sql = "";
		if(!empty($code)) $sql .= " AND code = '$code'";
		if(!empty($flag_delete) || $flag_delete != "") $sql .= " AND flag_delete = '$flag_delete'";
		if(!empty($btitle)) $sql .= " AND btitle = '$btitle'";
		if($sch_opt =='useridx'){
			$sql .= " AND $sch_opt ='$sch_con' ";
		}else{
			if(!empty($sch_opt) && !empty($sch_con)) $sql .= " AND $sch_opt like '%$sch_con%' ";
		}
	
		return $sql;
	}

	public function getList($db, $code, $btitle, $sch_opt, $sch_con, $limitSql, $stat, $frname)
	{
		$today = date("YmdHis");

		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}else{
						$where = "WHERE subject like '$frname%'";
						$where .= "AND end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date > '$today' AND confirm = '0'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '$frname%'";						
						$where .= "AND end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				
					}					
				break;
			}
	
		}else{

			if(!empty($frname)) $where = "WHERE subject like '$frname%' AND confirm = '0'";
			
		}

		$sql = "
		SELECT		frno, frid, subject, etype, cate, entry_count, start_date, end_date, notice_date, due_edate, maindisplay
		
		FROM		Ru_frontier_binfo
		
		".$where." 


		ORDER BY	frno DESC

		$limitSql
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdmingetList($db, $code, $btitle, $sch_opt, $sch_con, $limitSql, $stat, $frname)
	{

		$today = date("YmdHis");


		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}else{
						$where = "WHERE subject like '%$frname%'";
						$where .= "AND end_date < '$today' AND notice_date < '$today' AND due_edate > '$today' AND confirm = '0'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '%$frname%'";						
						$where .= "AND start_date < '$today' AND end_date > '$today' AND confirm = '0'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '%$frname%'";						
						$where .= "AND start_date < '$today' AND end_date < '$today' AND notice_date > '$today' AND confirm = '0'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				

					}else{
						$where = "WHERE subject like '%$frname%'";						
						$where .= "AND end_date < '$today' AND due_edate < '$today' AND confirm = '0'";				
					}					
				break;
			}
	
		}else{

			if($frname != ""){
				$where = "WHERE subject like '%$frname%' AND confirm = '0'";
			}else{
				$where = "WHERE confirm = '0'";
			}
			//$where .= "AND confirm = '0'";
		}

		$sql = "
		SELECT		frno, frid, subject, etype, cate, entry_count, start_date, end_date, notice_date, due_edate, maindisplay
		
		FROM		Ru_frontier_binfo
		
		".$where." 

		ORDER BY	frno DESC

		$limitSql
		";

		//echo "sql:$sql<br>";

		$rs = $db->fetch($sql);
		return $rs;
	}





	
	public function AdminCashgetList($db, $code, $btitle, $sch_opt, $sch_con, $limitSql, $stat, $frname)
	{
	
		$today = date("YmdHis");
			
		if(!empty($frname)) $and = "AND subject like '%$frname%'";
			


		$sql = "
		SELECT		frno, frid, subject, etype, cate, entry_count, start_date, end_date, notice_date, due_edate, maindisplay
		
		FROM		Ru_frontier_binfo
		
		WHERE		end_date < '$today'

		$and

		AND confirm = '0'

		ORDER BY	frno DESC

		$limitSql
		";
	
		$rs = $db->fetch($sql);
		return $rs;
	}


	public function getBcateSelect($db, $b_code, $m_code, $s_code, $ss_code, $table, $type)
	{

		 if($type == "1"){

			$sql = "
			SELECT		cate_desc
			
			FROM		$table
			
			WHERE cate1 = '$b_code'
			";
		 }

		 if($type == "2"){

			$sql = "
			SELECT		cate_desc
			
			FROM		$table
			
			WHERE cate1 = '$b_code' AND cate2 = '$m_code'
			";

		 }

		 if($type == "3"){

			$sql = "
			SELECT		cate_desc
			
			FROM		$table
			
			WHERE cate1 = '$b_code' AND cate2 = '$m_code' AND cate3 = '$s_code'
			";

		 }


		 if($type == "4"){

			$sql = "
			SELECT		cate_desc
			
			FROM		$table
			
			WHERE cate1 = '$b_code' AND cate2 = '$m_code' AND cate3 = '$s_code' AND cate4 = '$ss_code'
			";

		 }


		$rs = $db->fetch($sql, true);
		return $rs['cate_desc'];



	}


	public function areadescSelect($db, $area_code1, $area_code2, $area_code3, $table, $type)
	{

		 if($type == "1"){

			$sql = "
			SELECT		ko_desc
			
			FROM		$table
			
			WHERE bcode = '$area_code1'
			";
		 }

		 if($type == "2"){

			$sql = "
			SELECT		ko_desc
			
			FROM		$table
			
			WHERE bcode = '$area_code1' AND mcode = '$area_code2'
			";

		 }

		 if($type == "3"){

			$sql = "
			SELECT		ko_desc
			
			FROM		$table
			
			WHERE bcode = '$area_code1' AND mcode = '$area_code2' AND scode = '$area_code3'
			";

		 }


		$rs = $db->fetch($sql, true);
		return $rs['ko_desc'];



	}

	public function frontierinsert($db, $etype, $ctype, $catecode, $subject, $sdate, $edate, $review_sdate, $review_edate, $notice_date, $tel, $mobile, $bestreviewer_day, $mcount, $rproduct, $rprice, $area_bcode1, $area_mcode1, $area_scode1, $addr, $map, $homepage, $cashcon, $bigo, $bestrevieweraword, $editorContent, $editorContent2, $titlekeyword, $storykeyword, $tip, $topimage, $bannerimage, $thumbimage, $bannercode)
	{


		

		$sql1 = "
		INSERT	INTO Ru_frontier_binfo 
		
		(frid, subject, description, etype, cate, peoplelimit, start_date, end_date, notice_date, bestrview_notice_date, bestrview_prise, due_sdate, due_edate, keyword, tagword, tip, partner, mission)
		
		VALUES 
		
		('$frontier_id', '$subject', '$editorContent', '$etype', '$catecode', '$mcount', '$sdate', '$edate', '$notice_date', '$bestreviewer_day', '$bestrevieweraword', '$review_sdate', '$review_edate', '$titlekeyword', '$storykeyword', '$tip', '$ctype', '$editorContent2')
		";
		

		$result1 = $db->query($sql1);
		return $result1;
	}



	public function frontierentry_inc($db, $frno, $frid)
	{

		$sql = "
		UPDATE Ru_frontier_binfo 
		
		SET entry_count = entry_count+1

		WHERE frno = '$frno' 

		AND frid = '$frid'
		";
		

		$db->query($sql);
		return $db->result;
	}

	public function frontierentryuser_update($db, $name, $sex, $birth_year, $birth_month, $birth_day, $mobile1, $mobile2, $mobile3, $tel1, $tel2, $tel3, $zipcode, $addr1, $addr2, $userno, $userid)
	{

		$birthday	= $birth_year."-".$birth_month."-".$birth_day;
		$mobile		= $mobile1."-".$mobile2."-".$mobile3;
		$tel			= $tel1."-".$tel2."-".$tel3;

		$sql = "
		UPDATE Ru_account
		
		SET name = '$name'

		WHERE userno = '$userno' 

		";

		$sql2 = "
		UPDATE Ru_account_extra
		
		SET gender = '$sex', birthday = '$birthday', cell = '$mobile', tel = '$tel', zipcode = '$zipcode', addr1 = '$addr1', addr2 = '$addr2'

		WHERE userno = '$userno' 

		";


		$db->query($sql);
		$db->query($sql2);

		return $db->result;
	}


	public function frontiernameSelect($db, $frno)
	{

		$sql = "
		SELECT subject
		
		FROM Ru_frontier_binfo 
		
		WHERE frno = '$frno' 

		";

		$rs = $db->fetch($sql, true);
		return $rs['subject'];

	}


	public function getEntryList($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		if($stat != ""){
			$and = "AND win = '$stat' AND delflag='0'";
		}else{
			$and = "AND delflag='0'";
		}

		$sql = "
		SELECT		frid, userno, userid, name, sex, birthday, mobile, tel, zipcode, addr1,	 addr2, foption, win, regdate
		
		FROM		Ru_frontier_entry
		
		WHERE frno = '$frno' 

		$and
		
		ORDER BY	frno DESC

		$limitSql
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdmingetEntryList($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		if($stat != ""){
			$and = "AND a.win = '$stat' AND a.delflag='0'";
		}else{
			$and = "AND a.delflag='0'";
		}

		$sql = "
		SELECT a.frid, a.userno, a.userid, a.name, a.sex, a.birthday, a.mobile, a.tel, a.zipcode, a.addr1, a.addr2, (select froption from Ru_frontier_opinfo where frno = '$frno' and no = a.foption) options, a.win, a.regdate, b.nickname, b.email

		FROM Ru_frontier_entry a, Ru_account b
		
		WHERE a.frno = '$frno' 

		$and
		
		AND a.userno = b.userno

		ORDER BY	a.regdate DESC

		$limitSql
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdmingetEntryList2($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		if($stat != ""){
			$and = "AND a.delflag='0' AND a.win='$stat'";
		}else{
			$and = "AND a.delflag='0'";
		}

		$sql = "
		SELECT a.frid, a.userno, a.userid, a.name, a.sex, a.birthday, a.mobile, a.tel, a.zipcode, a.addr1, a.addr2, (select froption from Ru_frontier_opinfo where frno = '$frno' and no = a.foption) options, a.win, a.regdate, b.nickname, b.email, b.flag_powerblog, c.content

		FROM Ru_frontier_entry a, Ru_account b, Ru_frontier_entrytalk c
		
		WHERE a.frno = '$frno' 

		AND c.frno = '$frno'

		$and
		
		AND a.userno = b.userno

		AND a.userno = c.userno 
		
		AND b.userno = c.userno

		ORDER BY	a.regdate DESC

		$limitSql
		";
		
		//echo "sql:$sql<br>";
		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdmingetWinList($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		if($stat != ""){
			$and = "AND a.win = '$stat' AND a.delflag='0'";
		}else{
			$and = "AND a.delflag='0'";
		}

		$sql = "
		SELECT a.frid, a.userno, a.userid, a.name, a.sex, a.birthday, a.mobile, a.tel, a.zipcode, a.addr1, a.addr2, (select froption from Ru_frontier_opinfo where frno = '$frno' and no = a.foption) options, a.win, a.paycash, a.regdate, b.nickname, b.email

		FROM Ru_frontier_entry a, Ru_account b
		
		WHERE a.frno = '$frno' 

		$and
		
		AND a.userno = b.userno

		ORDER BY	a.regdate DESC

		$limitSql
		";
		

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdminUserCashPay($db,  $event_no, $userno, $cash)
	{

		$sql = "
		UPDATE Ru_frontier_entry
		
		SET paycash = '$cash'

		WHERE userno = '$userno' 

		AND frno = '$event_no'

		AND win = '1'
		";


		$db->query($sql);
		return $db->result;
	}


	public function AdminUserRnoSelect($db, $frno, $userno)
	{

		$sql = "
		SELECT rno

		FROM Ru_review
		
		WHERE userno = '$userno' 

		AND frno = '$frno'
		";
		

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdminEntryBlogURL($db, $userno)
	{

		$sql = "
		SELECT url

		FROM Ru_account_blog
		
		WHERE userno = '$userno' 

		ORDER BY	blogno DESC
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function AdminFrontierReviewSic($db, $userno, $event_no)
	{

		$sql = "
		SELECT count(rno) as cnt

		FROM Ru_review
		
		WHERE userno = '$userno' 

		AND frno = '$event_no'
		";
		

		$row = $db->fetch($sql, true);
		return $row['cnt'];

	}


	public function AdminFrontierCashCheck($db, $userno, $event_no)
	{

		$sql = "
		SELECT paycash

		FROM Ru_frontier_entry
		
		WHERE userno = '$userno' 

		AND frno = '$event_no'
		";
		

		$row = $db->fetch($sql, true);
		return $row['paycash'];

	}


	public function AdminWinnerReivewURL($db, $userno)
	{

		$sql = "
		SELECT a.userno, b.rno, b.frno, b.url, c.title

		FROM Ru_account a, Ru_review b, Ru_review_contents c
		
		WHERE a.userno = '$userno'

		AND b.userno = '$userno'

		AND b.rno = c.rno
		
		ORDER BY b.pubdate DESC 

		LIMIT 0, 1000
		";

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getEntryWinnerList($db, $frno, $limitSql, $stat)
	{

		if($stat != ""){
			$and = "AND b.win = '$stat' AND a.frno = b.frno AND b.frno = c.frno";
		}else{
			$and = "";
		}

		$sql = "
		SELECT		a.subject, b.frid, b.userno, b.userid, b.name, b.sex, b.birthday, b.mobile, b.tel, b.zipcode, b.addr1, b.addr2, b.foption, b.win, b.regdate, c.bannercode
		
		FROM		Ru_frontier_binfo a, Ru_frontier_entry b, Ru_frontier_orinfo c
		
		WHERE b.frno = '$frno' 

		$and
		
		ORDER BY	b.frno DESC

		$limitSql
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function getEntryWinnerList2($db, $frno, $limitSql, $stat)
	{

		if($stat != ""){
			$and = "AND b.win = '$stat' AND a.frno = b.frno AND b.frno = c.frno AND b.userno = d.userno";
		}else{
			$and = "";
		}

		$sql = "
		SELECT		a.subject, b.frid, b.userno, b.userid, b.name, b.sex, b.birthday, b.mobile, b.tel, b.zipcode, b.addr1, b.addr2, b.foption, b.win, b.regdate, c.bannercode, d.nickname
		
		FROM		Ru_frontier_binfo a, Ru_frontier_entry b, Ru_frontier_orinfo c, Ru_account d
		
		WHERE b.frno = '$frno' 

		$and
		
		ORDER BY	b.frno DESC

		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function getEntryWinnerListNick($db, $userno)
	{


		$sql = "
		SELECT		nickname
		
		FROM		Ru_account
		
		WHERE		userno = '$userno' 

		";
	

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function frontierentry_update($db, $frno, $userno, $type)
	{
	
		if($type == "w"){
			$winval = "P";
		}else{
			$winval = "0";
		}

		$sql = "
		UPDATE Ru_frontier_entry
		
		SET win = '$winval'

		WHERE frno = '$frno' 

		AND userno = '$userno'
		";


		$db->query($sql);
		return $db->result;
	}


	public function frontierentry_update2($db, $frno)
	{


		$sql = "
		UPDATE Ru_frontier_entry
		
		SET win = '1'

		WHERE frno = '$frno' 

		AND win = 'P'
		";


		$db->query($sql);
		return $db->result;
	}

	public function getEntryListCount($db, $event_no, $stat)
	{
		
		if($stat == ""){
			$and = " AND delflag = '0'";
		}else{
			$and = "AND win = '$stat'  AND delflag = '0'";
		}

		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$event_no' 
	
		$and

		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}



	public function AdmingetEntryListCount($db, $event_no, $stat)
	{
		
		if($stat == ""){
			$and = " AND delflag = '0'";
		}else{
			$and = "AND win = '$stat'  AND delflag = '0'";
		}


		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$event_no' 
	

		$and



		";

		$row = $db->fetch($sql, true);


		return $row['cnt'];
	}


	public function AdmingetEntryListCount2($db, $event_no, $stat)
	{
		
		if($stat == ""){
			$and = " AND delflag = '0'";
		}else{
			$and = "AND delflag = '0'";
		}


		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$event_no' 
	
		$and

		";

		$row = $db->fetch($sql, true);

		return $row['cnt'];
	}


	public function WinnerCheck($db, $frno)
	{

		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$frno' 
	

		AND win = '1'  AND delflag = '0'

		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function getEntryWinnerCount($db, $frno, $stat)
	{
		
		if($stat == ""){
			$and = "";
		}else{
			$and = "AND win = '$stat'";
		}

		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$frno' 

		$and

		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}

	public function FrontierListSelectT($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $type)
	{

		$today = date("YmdHis");

		if($type == "T"){
			$limit = "";
			$thumbtype = "A";
		}else{
			$limit = "";
			$thumbtype = "B";
		}

		
		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate > '$today'";
					}else{
						$where = "WHERE a.subject like '$frname%'";
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}
				break;

				case "B":
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date > '$today'";				
					}
				break;

				case "C":

				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				
					}
				break;

				case "D":
					
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate < '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate < '$today'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE a.subject like '$frname%' AND a.thumbstyle = '$thumbtype' ";

		}

		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.areacode, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '$flag_delete'

		ORDER BY	a.frno DESC

		$limit
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;

	}

	public function FrontierListSelectTframe($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $type)
	{
		$today = date("YmdHis");

		if($type == "T"){
			$limit = "";
			$thumbtype = "A";
		}else{
			$limit = "";
			$thumbtype = "B";
		}
		
		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate > '$today'";
					}else{
						$where = "WHERE a.subject like '$frname%'";
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date > '$today'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate < '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = '$thumbtype' AND a.end_date < '$today' AND a.due_edate < '$today'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE a.subject like '$frname%' AND a.thumbstyle = '$thumbtype' ";

		}

		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC

		$limit
		";
		

		//echo "$sql<br>";
		$rs = $db->fetch($sql);
		return $rs;


	}


	public function FrontierListSelectM($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $limit="")
	{
		
		$today = date("YmdHis");
	
		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE a.thumbstyle = 'B' AND a.end_date < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}else{
						$where = "WHERE a.subject like '$frname%'";
						$where .= "AND a.thumbstyle = 'B' AND a.end_date < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = 'B' AND a.start_date < '$today' AND a.end_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.start_date < '$today' AND a.end_date > '$today'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE a.thumbstyle = 'B' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.start_date < '$today' AND a.end_date < '$today' AND a.notice_date > '$today'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE a.thumbstyle = 'B' AND a.end_date < '$today' AND a.due_edate < '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.end_date < '$today' AND a.due_edate < '$today'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE a.subject like '$frname%' AND a.thumbstyle = 'B' ";

		}

		$sql = "
		SELECT		a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.areacode, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 
	
		AND a.frno = b.frno

		AND a.confirm = '$flag_delete'
		
		ORDER BY	a.frno DESC

		$limit
		";

		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;


	}



	public function EndFrontierList($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $limit="")
	{
		

		$today = date("YmdHis");
	

		if($frname == ""){
			$where = "WHERE a.end_date < '$today' AND a.due_edate < '$today'";				

		}else{
			$where = "WHERE a.subject like '$frname%'";						
			$where .= "AND a.end_date < '$today' AND a.due_edate < '$today'";				

		}

		$sql = "
		SELECT		a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 
	
		AND a.frno = b.frno

		AND a.confirm = '$flag_delete'
		
		ORDER BY	a.regdate DESC

		$limit
		";
		//echo $sql;
		$rs = $db->fetch($sql);
		return $rs;


	}



	public function FrontierView($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		$sql = "
		SELECT		a.frno, a.frid, a.subject, a.etype, a.thumbstyle, a.cate, a.peoplelimit, a.entry_count, a.start_date, a.end_date, a.notice_date, a.bestrview_notice_date, a.bestrview_prise, a.bestrview_priseyn, a.bestrviewer_count, a.due_sdate, a.due_edate, a.isverex, a.keyword, a.tagword, a.tip, a.partner, a.mission, b.frproduct, b.linkurl, b.mediafile, b.areacode, b.addr, b.oprice, b.frprice, b.message, b.titleimg, b.maplink, b.sitelink, b.cashpolicy, b.tel, b.mobile, b.rvguide, b.filelink, b.bannercode
		
		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b
		
		WHERE a.frno = '$frno' 

		AND a.frno = b.frno

		AND a.confirm = '0'
		";

		$rs = $db->fetch($sql, true);
		return $rs;
	}


	public function AdminFrontierView($db, $frno, $btitle, $sch_opt, $sch_con, $limitSql, $frname, $stat)
	{

		$sql = "
		SELECT		a.frno, a.frid, a.subject, a.etype, a.thumbstyle, a.cate, a.peoplelimit, a.entry_count, a.start_date, a.end_date, a.notice_date, a.bestrview_notice_date, a.bestrview_prise, a.bestrview_priseyn, a.bestrviewer_count, a.due_sdate, a.due_edate, a.isverex, a.keyword, a.tagword, a.tip, a.partner, a.mission, b.frproduct, b.linkurl, b.mediafile, b.areacode, b.addr, b.oprice, b.frprice, b.message, b.titleimg, b.maplink, b.sitelink, b.cashpolicy, b.tel, b.mobile, b.rvguide, b.filelink, b.bannercode
		
		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b
		
		WHERE a.frno = '$frno' 

		AND a.frno = b.frno

		AND a.confirm = '0'
		";

		$rs = $db->fetch($sql, true);
		return $rs;
	}


	public function FrontierOption($db, $frno)
	{

		$sql = "
		SELECT		froption

		FROM		Ru_frontier_opinfo
		
		WHERE frno = '$frno' 

		";

		$rs = $db->fetch($sql);
		return $rs;
	}

	
	public function FrontierOption2($db, $frno)
	{

		$sql = "
		SELECT		no, froption

		FROM		Ru_frontier_opinfo
		
		WHERE frno = '$frno' 

		";
		

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function FrontierOption2test($db, $frno)
	{

		$sql = "
		SELECT		no, froption

		FROM		Copy_Ru_frontier_opinfo
		
		WHERE frno = '$frno' 

		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}

	public function FrontierOptionCounttest($db, $frno)
	{
		$sql = "
		SELECT		count(no) as cnt

		FROM		Copy_Ru_frontier_opinfo
		
		WHERE frno = '$frno' 

		";

		$row = $db->fetch($sql, true);


		return $row['cnt'];

	}


	public function FrontierOptionCount($db, $frno)
	{

		$sql = "
		SELECT		count(no) as cnt

		FROM		Ru_frontier_opinfo
		
		WHERE frno = '$frno' 

		";

		$row = $db->fetch($sql, true);

		return $row['cnt'];

	}


	public function getBannerImage($frid, $titleimg)
	{
		$img = "";
		$src = "";
		if(empty($frid) || empty($titleimg)) {
			$src = "http://"._DOMAIN._DIR_IMAGES_."/common/noimage.gif";
		} else {
			$src = "http://"._DOMAIN_FILE."/"._FTP_FRONTIERIMAGE."/banner_img/".substr($frid,2,4)."/".$titleimg;
		}
		$img = "<img src='".$src."' />";
		return $img;
	}


	public function frbannerList($db)
	{

		$today = date("YmdHis");

		$sql = "
		SELECT		frno, frid
		
		FROM		Ru_frontier_binfo
		
		WHERE   start_date < '$today' AND end_date > '$today' 

		AND confirm = '0'
		";


		$rs = $db->fetch($sql);
		return $rs;
	}


	public function frbannerimgSelect($db, $frno)
	{


		$sql = "
		SELECT		titleimg
		
		FROM		Ru_frontier_orinfo
		
		WHERE   frno = '$frno' 
		";


		$row = $db->fetch($sql, true);
		return $row['titleimg'];
	}

	public function FrontierEntryListSelectT($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		

		$today = date("YmdHis");


		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE a.due_edate < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}else{
						$where = "WHERE a.subject like '$frname%'";
						$where .= "AND a.thumbstyle = 'A' AND a.due_edate < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE a.due_sdate < '$today' AND a.due_edate > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'A' AND a.due_sdate < '$today' AND a.due_edate > '$today'";				
					}
				break;

				case "C": 

				    if($frname == ""){
						$where = "WHERE a.due_sdate < '$today' AND a.due_edate < '$today' AND a.notice_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'A' AND a.due_sdate < '$today' AND a.due_edate < '$today' AND a.notice_date > '$today'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE a.due_edate < '$today' AND a.due_edate < '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'A' AND a.due_edate < '$today' AND a.due_edate < '$today'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE a.subject like '$frname%' AND a.thumbstyle = 'A' ";

		}

		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.due_sdate,
						a.due_edate, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC
		";
		
		$rs = $db->fetch($sql);
		return $rs;


	}


	public function FrontierEntryListSelectM($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname)
	{
		$today = date("YmdHis");

		if($stat != ""){
			switch($stat)
			{
				case "A": 
					if($frname == ""){
						$where = "WHERE a.due_edate < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}else{
						$where = "WHERE a.subject like '$frname%'";
						$where .= "AND a.thumbstyle = 'B' AND a.due_edate < '$today' AND a.notice_date < '$today' AND a.due_edate > '$today'";
					}
				break;

				case "B": 
				    if($frname == ""){
						$where = "WHERE a.due_sdate < '$today' AND a.due_edate > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.due_sdate < '$today' AND a.due_edate > '$today'";				
					}
				break;

				case "C":

				    if($frname == ""){
						$where = "WHERE a.due_sdate < '$today' AND a.due_edate < '$today' AND a.notice_date > '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.due_sdate < '$today' AND a.due_edate < '$today' AND a.notice_date > '$today'";				
					}
				break;

				case "D": 
					
				    if($frname == ""){
						$where = "WHERE a.due_edate < '$today' AND a.due_edate < '$today'";				

					}else{
						$where = "WHERE a.subject like '$frname%'";						
						$where .= "AND a.thumbstyle = 'B' AND a.due_edate < '$today' AND a.due_edate < '$today'";				
					}					
				break;
			}
	
		}else{

			$where = "WHERE a.subject like '$frname%' AND a.thumbstyle = 'B' ";

		}

		$sql = "
		SELECT		a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.due_sdate,
						a.due_edate, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 
	
		AND a.frno = b.frno

		AND a.confirm = '0'
		
		ORDER BY	a.frno DESC
		";
		

		$rs = $db->fetch($sql);
		return $rs;


	}


	
	public function EntryDuplication($db, $frno, $userno)
	{
		


		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_frontier_entry

		WHERE frno = '$frno' 

		AND userno = '$userno'

		AND delflag = '0'

		";
		
		$row = $db->fetch($sql, true);

		
		return $row['cnt'];
	}






	
	public function FrontierAlli($db, $company, $homepage, $rname, $company_tel, $company_mail, $company_say, $file)
	{


		

		$query = "
		INSERT	INTO Ru_frontier_alliance
		
		(company, homepage, rname, tel, mail, memo, file, regdate)
		
		VALUES 
		
		('$company', '$homepage', '$rname', '$company_tel', '$company_mail', '$company_say', '$file', now())
		";
		
		
		$result1 = $db->query($query);
		return $result1;
	}
	
	
	public function getLoginFrontierList($db, $userno, $stat="A", $num=2) {
		GLOBAL $BASE;
		switch($stat) {
			case "A" : 
				$sql = "
				SELECT		a.no, a.frno, b.subject				
				FROM		Ru_frontier_entry a, Ru_frontier_binfo b				
				WHERE a.userno = '$userno' 
				AND a.win = '1'
				AND a.frno = b.frno				
				AND a.delflag = '0'
				AND b.confirm = '0'
				ORDER BY	a.no DESC
				LIMIT 0,2
				";				
				$row = $db->fetch($sql);
				for($i=0;$i<sizeof($row);$i++) {					
					$frontierInfo1['frontier_list1'][$i]['title'] = $BASE->strLimitUTF($row[$i]['subject'], 22, false, '...');
					$frontierInfo1['frontier_list1'][$i]['frno'] =$row[$i]['frno'];				
				}				
				$frontierInfo1['frontier_cnt1'] = sizeof($row);
				return $frontierInfo1;
				break;
			case "B" :
			default : 
				$sql2 = "
				SELECT		a.no, a.frno, b.subject				
				FROM		Ru_frontier_entry a, Ru_frontier_binfo b				
				WHERE a.userno = '$userno' 
				AND a.win = '0'
				AND a.frno = b.frno				
				AND a.delflag = '0'
				AND b.confirm = '0'
				ORDER BY	a.no DESC
				LIMIT 0,2
				";				
				$row2 = $db->fetch($sql2);
				for($z=0;$z<sizeof($row2);$z++) {					
					$frontierInfo2['frontier_list2'][$z]['title'] = $BASE->strLimitUTF($row2[$z]['subject'], 22, false, '...');
					$frontierInfo2['frontier_list2'][$z]['frno'] =$row2[$z]['frno'];
				}				
				$frontierInfo2['frontier_cnt2'] = sizeof($row2);
				return $frontierInfo2;
				break;
		}
	}


	public function FrontierEntryTalk($db, $frno, $limit)
	{
		$sql = "
		SELECT			no, userno, nickname, division, division_no, content, delflag, regdate
		
		FROM			Ru_frontier_entrytalk
		
		WHERE         frno = '$frno' AND division = 'T'

		ORDER BY     NO DESC

		$limit
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}
	


	
	public function FrontierMainTalk($db)
	{
		$sql = "
		SELECT			no, userno, nickname, division, division_no, content, delflag, regdate
		
		FROM			Ru_frontier_entrytalk
		
		WHERE         division = 'T' 

		AND				delflag = '0'

		ORDER BY     NO DESC

		LIMIT 0,4
		";
		
		$rs = $db->fetch($sql);
		
		return $rs;
	}
	
public function FrontierReviewMainTalk($db)
	{
		$sql = "
 			(SELECT no, userno, nickname, division , division_no, content, delflag,regdate  FROM Ru_frontier_entrytalk where delflag = '0' and  division = 'T' order by no desc limit 0,2) 
                  UNION
              (SELECT tno as no, userno, nickname,'T' as division, 0 as division_no ,  talk as content, flag_del as delflag, regdate   FROM Ru_review_talk where flag_del = '0' order by tno desc limit 0,2)  
                  ORDER BY regdate DESC
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}




	
	public function FrontierEntryTalkCnt($db, $frno)
	{
		$sql = "
		SELECT			COUNT(no) as cnt
		
		FROM			Ru_frontier_entrytalk
		
		WHERE         frno = '$frno'  AND division = 'T'

		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];

	}
	
	
	public function TalkReplyins($db, $reply, $user_num, $usernick, $division, $frno, $talknum)
	{


		

		$query = "
		INSERT	INTO Ru_frontier_entrytalk
		
		(frno, userno, nickname, division, division_no, content, regdate)
		
		VALUES 
		
		('$frno', '$user_num', '$usernick', '$division', '$talknum', '$reply', now())
		";
		
		
		$result1 = $db->query($query);
		return $result1;
	}

	
	public function FrontierTalkReply($db, $frno, $division_no)
	{
		$sql = "
		SELECT			no, userno, nickname, division, division_no, content, regdate
		
		FROM			Ru_frontier_entrytalk
		
		WHERE         division_no = '$division_no' AND division = 'R' AND delflag = '0'

		ORDER BY     NO DESC
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}

	
	
	public function TalkReplyedit($db, $reply, $user_num, $usernick, $division, $frno, $talknum, $mode)
	{

	    if($mode == "E"){
			$sql = "
			UPDATE Ru_frontier_entrytalk
			
			SET content = '$reply'

			WHERE no = '$talknum' 

			AND userno = '$user_num'
			";

		}else{

			$sql = "

			UPDATE Ru_frontier_entrytalk
			
			SET delflag = '1'

			WHERE  no = '$talknum' 

			AND userno = '$user_num'


			";

		}

		
		$db->query($sql);
		return $db->result;
	}


	
	public function EntryCancel($db, $reply, $user_num, $usernick, $division, $frno, $talknum, $mode)
	{

		
		$sql = "

		UPDATE Ru_frontier_entrytalk
		
		SET delflag = '1'

		WHERE  no = '$talknum' 

		AND userno = '$user_num'


		";

		$db->query($sql);

		$sql2 = "

		UPDATE Ru_frontier_entry
		
		SET delflag = '1'

		WHERE  frno = '$frno' 

		AND userno = '$user_num'


		";

		$sql3 = "

		UPDATE Ru_frontier_binfo 
		
		SET entry_count=entry_count-1 
		
		WHERE frno = '89'";

		$db->query($sql3);
		$db->query($sql2);

		return $db->result;
	}

	public function FrontierBannerList($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $type)
	{
		

		$today = date("YmdHis");


		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		WHERE		 a.start_date < '$today' AND a.end_date > '$today' 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC

		$limit
		";
		
		$rs = $db->fetch($sql);
		return $rs;


	}


	
	public function FrontierBannerListCnt($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $stat, $frname, $type)
	{
		

		$today = date("YmdHis");


		$sql = "
		SELECT		COUNT(a.frno) as cnt

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		WHERE		a.start_date < '$today' AND a.end_date > '$today' 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC

		$limit
		";
		
		
		

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}



	
	public function MyFrontierEntrySelect($db, $userno, $type)
	{


		$and = "AND a.win = '$type'";

		$sql = "
		SELECT		a.frno, a.frid, b.subject, b.peoplelimit, b.end_date, b.notice_date, b.due_edate
		
		FROM		Ru_frontier_entry a, Ru_frontier_binfo b
		
		WHERE a.userno = '$userno' 

		$and

		AND a.frno = b.frno

		AND b.confirm = '0'
		
		ORDER BY	frno DESC
		";
	
		$rs = $db->fetch($sql);
		return $rs;
	}


	
	public function MyFrontierEntryWinSelect($db, $userno, $type, $limit)
	{


		$and = "AND a.win = '$type'";

		$sql = "
		SELECT		a.no, a.frno, a.frid, b.subject, b.peoplelimit, b.end_date, b.notice_date, b.due_edate
		
		FROM		Ru_frontier_entry a, Ru_frontier_binfo b
		
		WHERE a.userno = '$userno' 

		$and

		AND a.frno = b.frno

		AND b.confirm = '0'
		
		ORDER BY	a.no DESC

		$limit
		";

		$rs = $db->fetch($sql);
		return $rs;
	}



	
	public function MyFrontierEntryWinSelect4($db, $userno, $type, $limit)
	{


		$and = "AND a.win = '$type'";

		$sql = "
		SELECT		a.no, a.frno, a.frid, b.subject, b.peoplelimit, b.end_date, b.notice_date, b.due_edate
		
		FROM		Ru_frontier_entry a, Ru_frontier_binfo b
		
		WHERE a.userno = '$userno' 

		$and

		AND a.frno = b.frno
		
		AND a.delflag = '0'

		AND b.confirm = '0'

		ORDER BY	a.no DESC

		LIMIT 0,4
		";

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function FrontierReview($db, $frno, $limit)
	{
		$sql = "
		SELECT			rno, userno, cate1, cate2, cate3, cate4, area1, area2, area3, addr, regdate
		
		FROM			Ru_review
		
		WHERE         frno = '$frno'
		
		AND				status = '1'

		ORDER BY     rno DESC

		$limit
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}

		
	public function FrontierReviewendlist($db, $frno, $limit)
	{
		$sql = "
		SELECT			rno, userno
		
		FROM			Ru_review
		
		WHERE         frno = '$frno'

		ORDER BY     rno DESC

		LIMIT 1
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}


		
	public function FrontierReviewendlist2($db, $frno, $userno, $limit)
	{
		$sql = "
		SELECT			a.rno, a.userno, b.content
		
		FROM			Ru_review a, Ru_review_contents b
		
		WHERE         a.frno = '$frno'

		AND				a.userno = '$userno'

		AND				a.rno = b.rno

		AND				a.status = '1'

		ORDER BY     a.rno DESC

		LIMIT 1
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}


	
	public function FrontierReviewCnt($db, $frno)
	{
		$sql = "
		SELECT			COUNT(rno) as cnt
		
		FROM			Ru_review
		
		WHERE         frno = '$frno'

		AND				status = '1'

		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];

	}
	

	
	public function ReviewUserNickname($db, $userno)
	{
		$sql = "
		SELECT			nickname
		
		FROM			Ru_account
		
		WHERE         userno = '$userno'

		";
		
		$rs = $db->fetch($sql,true);
		return $rs['nickname'];
	}



	
	public function ReviewBasicData($db, $frno)
	{
		$sql = "
		SELECT			rno, cate1, cate2, cate3, cate4, area1, area2, area3, addr, regdate
		
		FROM			Ru_review
		
		WHERE         frno = '$frno'



		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}

	
	public function ReviewFileData($db, $reviewno)
	{
		$sql = "
		SELECT			filename
		
		FROM			Ru_review_file
		
		WHERE         rno = '$reviewno'

		AND				flag_del  = '0' 

		AND				type = 'T'

		LIMIT				1


		";
		
		$rs = $db->fetch($sql, true);
		return $rs['filename'];
	}


	
	public function ReviewContentData($db, $reviewno)
	{
		$sql = "
		SELECT			title, content
		
		FROM			Ru_review_contents
		
		WHERE         rno = '$reviewno'



		";
		
		$row = $db->fetch($sql, true);
		return $row;
	}

	
	public function ListimgSelect($db, $frno)
	{
		$sql = "
		SELECT			titleimg
		
		FROM			Ru_frontier_orinfo
		
		WHERE         frno = '$frno'



		";
		
		$rs = $db->fetch($sql, true);
		return $rs['titleimg'];
	}



	
	public function FrontierReviewTframe($db)
	{
		$sql = "
		SELECT			rno, userno, cate1, cate2, cate3, cate4, area1, area2, area3, addr, regdate
		
		FROM			Ru_review
		
		WHERE         frno != ''

		ORDER BY     rno DESC

		LIMIT 0,3
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}




	
	public function FrontierReviewTime($db, $frno)
	{
		$sql = "
		SELECT			due_edate
		
		FROM			Ru_frontier_binfo
		
		WHERE         frno = '$frno'

		AND				confirm = '0'

		";
		
		$rs = $db->fetch($sql, true);
		return $rs['due_edate'];
	}


	
	public function DateCheckFrontier($db, $frno)
	{
		

		$sql = "
		SELECT		end_date, due_edate

		FROM		Ru_frontier_binfo

		WHERE frno = '$frno' 

		AND confirm = '0'
		
		";

		$rs = $db->fetch($sql);
		return $rs;


	}


	public function FrontierWinCount($db, $userno)
	{

		$sql = "
		SELECT		COUNT(a.no) as cnt
		
		FROM		Ru_frontier_entry a, Ru_frontier_binfo b
		
		WHERE a.userno = '$userno' 

		AND a.frno = b.frno

		AND b.confirm = '0'
		
		";

		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}


	public function FrontierMainselect($db, $today)
	{
		
		$where = "WHERE a.maindisplay = '1'";		


		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC

		
		";
		

		$rs = $db->fetch($sql);
		return $rs;
	}



	public function FrontierMainCnt($db, $today)
	{
		

		$where = "WHERE a.start_date < '$today' AND a.end_date > '$today'";				


		$sql = "
		SELECT		 COUNT(a.frno) as cnt

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.frno DESC

		
		";
		
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];



	}


	public function BannerSelect($db, $type)
	{
		

		$sql = "
			SELECT bannerimg, linktype, siteurl

			FROM Ru_banner

			WHERE btype = '$type' 

			AND delflag = '0'

			ORDER BY rand() LIMIT 1; 

		
		";
		

		$row = $db->fetch($sql);
		return $row;

	}


	public function FrontierMainListCount($db, $today)
	{
		

		$where = "WHERE maindisplay != '1' AND a.start_date < '$today' AND a.end_date > '$today'";				


		$sql = "
		SELECT		 COUNT(a.frno) as cnt

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno


		AND a.confirm = '0'


		ORDER BY	a.frno DESC

		
		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];



	}


	public function FrontierMainFourListA($db, $today)
	{
		

		$where = "WHERE a.maindisplay != 1 AND a.start_date < '$today' AND a.due_edate > '$today'";				

		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.end_date DESC

		LIMIT 0,4

		
		";

		$rs = $db->fetch($sql);
		return $rs;



	}


	public function FrontierMainFourListA_count($db, $today)
	{
		

		$where = "WHERE a.maindisplay != 1 AND a.start_date < '$today' AND a.due_edate > '$today'";				

		$sql = "
		SELECT		COUNT(a.frno) as cnt

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'


		ORDER BY	a.end_date DESC

		LIMIT 0,4

		
		";


		$row = $db->fetch($sql, true);
		return $row['cnt'];

	}



	public function FrontierMainFourListAE($db, $today)
	{
		

		$where = "WHERE a.maindisplay != 1 AND a.start_date < '$today'";				

		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.end_date DESC

		LIMIT 0,4

		
		";


		$rs = $db->fetch($sql);
		return $rs;

	}


	public function FrontierMainFourListB($db, $today)
	{
		


		$where = "WHERE a.maindisplay != 1 AND a.start_date < '$today' AND a.end_date > '$today'";				


		$sql = "
		SELECT		 a.frno, a.frid, a.subject, a.description, a.etype, a.cate, a.thumbstyle, a.cate, a.peoplelimit, a.start_date,
						a.end_date, a.notice_date, a.due_sdate, a.due_edate, a.regdate, b.frproduct, b.addr, b.titleimg, b.tel

		FROM		Ru_frontier_binfo a, Ru_frontier_orinfo b


		".$where." 

		AND a.frno = b.frno

		AND a.confirm = '0'

		ORDER BY	a.end_date DESC

	
		LIMIT 0,4	
		";
		

		$rs = $db->fetch($sql);
		return $rs;
	}




	public function MyrevuEntrySelect($db, $userno, $type)
	{


		$and = "AND a.win = '$type'";

		$sql = "
		SELECT		a.frno, a.frid, b.subject, b.peoplelimit, b.end_date, b.notice_date, b.due_edate
		
		FROM		Ru_frontier_entry a, Ru_frontier_binfo b
		
		WHERE a.userno = '$userno' 

		$and

		AND a.frno = b.frno

		AND a.delflag = '0'

		AND b.confirm = '0'

		ORDER BY	frno DESC

		LIMIT 0,4

		";
		
		
		$rs = $db->fetch($sql);
		return $rs;
	}



		
	public function MyrevuEntryTalkSelect($db, $frno, $userno)
	{
		$sql = "

			SELECT			no, content, regdate
			
			FROM			Ru_frontier_entrytalk
			
			WHERE         frno = '$frno'

			AND				userno = '$userno'

			AND				delflag = '0'

			ORDER BY     no DESC

			LIMIT 1
		";
		
		$rs = $db->fetch($sql);
		return $rs;
	}


	
	public function MyrevuEntryReviewSelect($db, $frno, $userno)
	{
		
		$sql = "

			SELECT a.rno, b.content

			FROM Ru_review a, Ru_review_contents b

			WHERE a.userno = '$userno'

			AND a.frno = '$frno'

			AND a.rno = b.rno

			ORDER BY a.rno 
			
			DESC LIMIT 1																						
			";

		
		$rs = $db->fetch($sql);
		return $rs;
	}




	
	public function func119($db)
	{
		
		$sql = "

			DELETE FROM Ru_review_file WHERE filename2 LIKE '%.www%'															
			";

		
		$rs = $db->query($sql);
		return $rs;
	}
	



	
	public function AdminFrontierReviewLink($db, $frno, $userno, $url)
	{


		$sql = "
		UPDATE Ru_review
		
		SET frno = '$frno'

		WHERE userno = '$userno' 

		AND url = '$url'
		";

		
		$db->query($sql);
		return $db->result;
	}




	
	public function RevuLogTemp($db)
	{

		
		$wyear = date("Y");
		$wmonth = date("m");
		$wday	= date("d");


		$sql1 = "
		SELECT		COUNT(no) as cnt

		FROM		Rz_revu_log

		WHERE		wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'

		";
		
		$row = $db->fetch($sql1, true);

		$counting = $row['cnt'];
		if($counting > 0){

			$query = "

			UPDATE Rz_revu_log 

			SET count = count+1

			WHERE wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'

			";
			$result1 = $db->query($query);
			return $result1;


		}else{

			
			
			$query = "
			INSERT	INTO Rz_revu_log
			
			(count, memo, wyear, wmonth, wday)
			
			VALUES 
			
			('1', '', '$wyear', '$wmonth', '$wday')
			";
			

			$result1 = $db->query($query);
			return $result1;

		}
	}



	public function FrontierEntryUser($db, $userno)
	{


		$sql = "
		SELECT a.username, b.gender, b.birthday, b.cell, b.tel, b.zipcode, b.addr1, b.addr2

		FROM Ru_account a, Ru_account_extra b
		
		WHERE a.userno = '$userno' 

		AND b.userno = '$userno'
		
		AND a.userno = b.userno

		";
		
		//echo "sql:$sql<br>";
		$rs = $db->fetch($sql, true);
		return $rs;
	}



}