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
		
		//echo "sql:$sql";exit;
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
		$where = "WHERE campaign like '$name%' ".$and."";

		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_banner

		".$where." 
		";
		//echo "sql:$sql";
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


		$and = "AND campaign like '$name%' ".$and2."";

		$sql = "
		SELECT		btype, linktype, campaign, spon, bannerimg, idx, siteurl, regdate

		FROM		Ru_banner 

		WHERE delflag = '0'

		".$and." 
		";
		//echo "sql:$sql";
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

		//echo "sql:$sql";exit;
		$db->query($sql);
		return $db->result;
	}



	public function AfileCount($db)
	{
		


		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Ru_alliance_file

		";
		//echo "sql:$sql<br>";
		$row = $db->fetch($sql, true);

		//echo "카운트:$count<br>";
		return $row['cnt'];
	}


	public function AfileList($db)
	{
		


		$sql = "
		SELECT		no, title, file, regdate

		FROM		Ru_alliance_file

		";
		//echo "sql:$sql<br>";
		$row = $db->fetch($sql);

		//echo "카운트:$count<br>";
		return $row;
	}




}