<?php

class Manager
{
	public function Manager()
	{
	}
		

	public function BannerInsert($db, $bannertype, $linktype, $campaign, $spon, $linurl, $filename)
	{

		$query = "
		INSERT	INTO Ru_banner
		
		(btype, linktype, campaign, spon, bannerimg, siteurl, regdate)
		
		VALUES 
		
		('$bannertype', '$linktype', '$campaign', '$spon', '$filename', '$linurl',now())
		";
		
		$result1 = $db->query($query);
		return $result1;
	}




	
	public function BannerListCnt($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $type, $name)
	{
		
		$today = date("YmdHis");

		if($type == ""){
			$and = "";
		}else{
			$and = "AND btype = '$type'";
		}
		$where = "WHERE delflag = '0' AND campaign like '$name%' ".$and."";

		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_banner

		".$where." 
		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}



	
	public function BannerListSelect($db, $code, $flag_delete, $btitle, $sch_opt, $sch_con, $type, $name)
	{
		
		$today = date("YmdHis");

		if($type == ""){
			$and2 = "";
		}else{
			$and2 = "AND btype = '$type'";
		}

		$and = "AND campaign like '%$name%' ".$and2."";

		$sql = "
		SELECT		no, btype, linktype, campaign, spon, bannerimg, idx, siteurl, regdate

		FROM		Ru_banner 

		WHERE delflag = '0'

		".$and." 
		";
		
		//echo $sql;
		$row = $db->fetch($sql);
		return $row;
	}




	
	public function FrontierMaindisplay($db, $frno, $flag)
	{

		$sql = "
		UPDATE Ru_frontier_binfo
		
		SET maindisplay = '$flag'

		WHERE frno = '$frno' 

		";
	
		$db->query($sql);
		return $db->result;
	}


	public function adminfrontierdel($db, $frno)
	{

		$sql = "
		UPDATE Ru_frontier_binfo
		
		SET confirm = '1'

		WHERE frno = '$frno' 

		";
	
		$db->query($sql);
		return $db->result;
	}



	
	public function AfileCount($db)
	{
		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_alliance_file

		";
		
		$row = $db->fetch($sql, true);
		return $row['cnt'];
	}




	
	public function AfileList($db)
	{
		$sql = "
		SELECT		no, title, file, regdate

		FROM		Ru_alliance_file

		ORDER BY no DESC

		";
		
		$row = $db->fetch($sql);
		return $row;
	}




	
	public function AfileInsert($db, $title, $filename)
	{
		$query = "
		INSERT	INTO Ru_alliance_file
		
		(title, file, regdate)
		
		VALUES 
		
		('$title', '$filename',now())
		";
		
		$result1 = $db->query($query);
		return $result1;
	}

	
	public function AfileDelete($db, $no)
	{
		$query = "
		DELETE FROM Ru_alliance_file

		WHERE no = '$no'
		";
	
		$result1 = $db->query($query);
		return $result1;
	}


	
	public function AfileSelect($db, $no)
	{
		$query = "
		SELECT file
		
		FROM Ru_alliance_file

		WHERE no = '$no'
		";
		
		$row = $db->fetch($query);
		return $row;
	}




	
	public function BannerDel($db, $no)
	{
		$sql = "
		UPDATE Ru_banner 

		SET delflag = '1'

		WHERE no = '$no'

		";
		
		$result = $db->query($sql);
		return $result;
	}


	
	public function adminlog($db, $adminno, $mno, $rcode1, $rcode2, $rcode3, $log_message)
	{
		$query = "
		INSERT	INTO Ra_admin_log
		
		(userno, mno, rcode1, rcode2, rcode3, memo, regdate)
		
		VALUES 

		('$adminno', '$mno', '$rcode1', '$rcode2', '$rcode3', '$log_message',now())
		";
		
		$result1 = $db->query($query);
		return $result1;
	}



	
	public function AdminPartnerCnt($db)
	{

		$sql = "
		SELECT		count(no) as count

		FROM		Ru_frontier_alliance

		";
		
		$row = $db->fetch($sql, true);
		return $row['count'];
	}



	
	public function AdminPartnerselect($db, $type)
	{
		
		if($type == ""){
			$and = "";
		}else{
			$and = "AND contirm = '$type'";
		}

		$sql = "
		SELECT		no, company, homepage, rname, tel, mail, memo, file, confirm, confirm_name, regdate

		FROM		Ru_frontier_alliance 

		ORDER BY NO DESC

		".$and." 
		";
		//echo $sql;
		$row = $db->fetch($sql);
		return $row;
	}



	
	public function AdminPartnermemo($db, $no)
	{
		
		$sql = "
		SELECT		memo

		FROM		Ru_frontier_alliance 

		WHERE no = '$no'

		";
		
		$row = $db->fetch($sql, true);
		return $row['memo'];
	}

	public function AdminfridSelect($db, $no)
	{
		
		$sql = "
		SELECT		frid

		FROM		Ru_frontier_binfo

		WHERE frno = '$no'

		";
		
		$row = $db->fetch($sql, true);
		return $row['frid'];
	}


	public function AdminfileSelect($db, $no)
	{
		
		$sql = "
		SELECT		filelink

		FROM		Ru_frontier_orinfo

		WHERE frno = '$no'

		";
		
		$row = $db->fetch($sql, true);
		return $row['filelink'];
	}
	
	public function Modify_cate($db, $frno, $cate1, $cate2, $cate3, $cate4)
	{

		$cate = $cate1.$cate2.$cate3.$cate4;
		$sql = "
		UPDATE Ru_frontier_binfo
		
		SET cate = '$cate'

		WHERE frno = '$frno' 

		";

		
		$db->query($sql);
		return $db->result;
	}



	
	public function Modify_addr($db, $frno, $addr, $areacode)
	{

		$cate = $cate1.$cate2.$cate3.$cate4;
		$sql = "
		UPDATE Ru_frontier_orinfo
		
		SET areacode = '$areacode', addr = '$addr'

		WHERE frno = '$frno' 

		";
		
		$db->query($sql);
		return $db->result;
	}

	
	public function Modify_tel($db, $frno, $tel, $mobile)
	{

		$sql = "
		UPDATE Ru_frontier_orinfo
		
		SET tel = '$tel', mobile = '$mobile'

		WHERE frno = '$frno' 

		";

		$db->query($sql);
		return $db->result;
	}

	
	public function Modify_setfrontier($db, $element, $frno, $flag)
	{

		if($flag == "TY"){
			$setquery = "etype = '$element'";
		}

		if($flag == "CT"){
			$setquery = "partner = '$element'";
		}

		if($flag == "ST"){
			$setquery = "thumbstyle = '$element'";
		}

		if($flag == "SJ"){

			$element = addslashes($element);
			$setquery = "subject = '$element'";
		}

		if($flag == "PL"){

			$setquery = "peoplelimit = '$element'";
		}

		if($flag == "BC"){

			$setquery = "bestrviewer_count = '$element'";
		}


		if($flag == "ND"){

			$setquery = "notice_date = '$element'";
		}


		if($flag == "BD"){

			$setquery = "bestrview_notice_date = '$element'";
		}

		if($flag == "MS"){
			$element = addslashes($element);
			$setquery = "bestrview_prise = '$element'";
		}

		if($flag == "SS"){
			$element = addslashes($element);
			$setquery = "mission = '$element'";
		}

		if($flag == "KW"){
			$element = addslashes($element);
			$setquery = "keyword= '$element'";
		}

		if($flag == "TW"){
			$element = addslashes($element);
			$setquery = "tagword= '$element'";
		}

		if($flag == "TP"){
			$element = addslashes($element);
			$setquery = "tip= '$element'";
		}


		$sql = "
		UPDATE Ru_frontier_binfo
		
		SET $setquery

		WHERE frno = '$frno' 

		";

		//echo "sql:$sql<br>";

		$db->query($sql);
		return $db->result;
	}



	
	public function Modify_setfrontierorinfo($db, $element, $frno, $flag)
	{
		if($flag == "PD"){

			$element = addslashes($element);
			$setquery = "frproduct = '$element'";
		}

		if($flag == "PE"){

			$setquery = "oprice = '$element'";
		}


		if($flag == "MP"){

			$setquery = "maplink = '$element'";
		}

		if($flag == "WE"){

			$setquery = "sitelink = '$element'";
		}

		if($flag == "CP"){
			$element = addslashes($element);
			$setquery = "cashpolicy = '$element'";
		}

		if($flag == "ME"){
			$element = addslashes($element);
			$setquery = "message = '$element'";
		}


		if($flag == "BN"){
			$element = addslashes($element);
			$setquery = "bannercode = '$element'";
		}



		$sql = "
		UPDATE Ru_frontier_orinfo
		
		SET $setquery

		WHERE frno = '$frno' 

		";

		//echo "sql:$sql<br>";exit;

		$db->query($sql);
		return $db->result;
	}


	
	public function Modify_frontierjdate($db, $frno, $sdate, $edate, $flag)
	{

		if($flag == "RD"){

			$sql = "
			UPDATE Ru_frontier_binfo
			
			SET due_sdate = '$sdate', due_edate = '$edate'

			WHERE frno = '$frno' 

			";

		}else{


			$sql = "
			UPDATE Ru_frontier_binfo
			
			SET start_date = '$sdate', end_date = '$edate'

			WHERE frno = '$frno' 

			";

		}

		$db->query($sql);
		return $db->result;
	}




	
	public function Modify_optionreset($db, $frno)
	{
		
		$sql = "

			DELETE FROM Ru_frontier_opinfo WHERE frno = '$frno'															
			";

		$rs = $db->query($sql);
		return $rs;
	}
	

	
	public function Modify_optioninsert($db, $frid, $opno, $opval, $frno)
	{

		$query = "
		INSERT	INTO Ru_frontier_opinfo
		
		(frno, frid, froption, regdate)
		
		VALUES 

		('$frno', '$frid', '$opval', now())
		";
		
		$result1 = $db->query($query);
		return $result1;
	}


	
	public function Select_frid($db, $frno)
	{

		$sql = "
		SELECT frid

		FROM Ru_frontier_binfo
		
		WHERE frno = '$frno' 

		";
		
		$row = $db->fetch($sql, true);
		return $row['frid'];

	}
	
	public function getFrontierAllianceList($db, $limit)
	{
		$where = "";
		$sql = "
		SELECT		no, company, homepage, rname, tel, mail, memo, file, confirm, confirm_name, regdate		
		FROM		Ru_frontier_alliance
		WHERE 		1 
		".$where." 
		ORDER BY NO DESC
		".$limit."
		";
		//echo $sql;
		$row = $db->fetch($sql);
		return $row;
	}


	public function FrontierReviewDel($db, $frno, $reviewno)
	{
	

		$sql = "
		UPDATE Ru_review
		
		SET frno = ''

		WHERE rno = '$reviewno' 

		AND frno = '$frno'
		";


		$db->query($sql);
		return $db->result;
	}


	public function FrontierReviewModify($db, $frno, $ofrno, $reviewno)
	{
	

		$sql = "
		UPDATE Ru_review
		
		SET frno = '$frno'

		WHERE rno = '$reviewno' 

		AND frno = '$ofrno'
		";


		$db->query($sql);
		return $db->result;
	}
	
	public function getAdminUserList($db)
	{
		$sql = "
		SELECT 		* 
		FROM 		Ra_admin 
		WHERE 		grade <= '900' 
		ORDER BY grade
		";
		$rs = $db->fetch($sql);
		return $rs;
	}
	
	public function registAdminUser($db, $user)
	{
		$sql = "
		INSERT INTO Ra_admin
		SET 		userno = ".$user['userno'].",  
					grade = ".$user['grade'].",
					admin_desc = '".$user['admin_desc']."' 
		";
		//echo $sql;
		$res = $db->query($sql);
		if($res == true) {
			return true;
		} else {
			return false;
		}
	}
	
	public function deleteAdminUser($db, $userno)
	{
		$sql = "
		DELETE 		 
		FROM 		Ra_admin
		WHERE 		userno = ".$userno."
		";
		$res = $db->query($sql);
		if($res == true) {
			return true;
		} else {
			return false;
		}
	}

}