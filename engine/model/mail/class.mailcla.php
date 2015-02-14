<?php
class Mailcla
{
	public function Mailcla()
	{
	}
	

	public function getEntryList($db)
	{



		$sql = "
			SELECT frno, subject

			FROM Ru_frontier_binfo 

			WHERE frno = (select DISTINCT frno from Ru_frontier_entry where win='1')
		";
		
		
		//echo "sql:$sql";

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getFrontierWinMailList($db)
	{



		$sql = "
			SELECT frno, subject

			FROM Ru_frontier_binfo 

			WHERE confirm = '0'

			ORDER BY regdate DESC LIMIT 0,30
		";
		
		
		//echo "sql:$sql";

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getReserveMail($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT no, subject, sendname, sendtype, recipient, recipientgroup, memo

			FROM Ru_mailreserve

			WHERE sending = 'N' 

			AND reserve_date <= '$nowtime'
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function ReserveMailUpdate($db, $mno, $flag)
	{

		$nowtime = date('YmdH');

		$sql = "
			UPDATE Ru_mailreserve

			SET sending = '$flag', regdate = now()

			WHERE no = '$mno' 

		";
		
		
		//echo "sql:$sql";exit;


		$db->query($sql);
		return $db->result;
	}


	public function MailGroupSelect($db, $group)
	{

		if($group == "A"){
			$and = "AND a.flag_black = '0' AND a.email != '' AND a.flag_email = '1'";
		}else if($group == "B"){
			$and = "AND a.flag_black = '0' AND b.gender = 'M' AND a.email != '' AND a.flag_email = '1'";
		}else if($group == "C"){
			$and = "AND a.flag_black = '0' AND b.gender = 'F' AND a.email != '' AND a.flag_email = '1'";
		}else{
			$and = "AND a.flag_black = '1' AND a.email != '' AND a.flag_email = '1'";
		}
	
		$sql = "
			SELECT a.email

			FROM Ru_account a, Ru_account_extra b

			WHERE a.flag_email = '1' 

			$and

			AND a.userno = b.userno

		
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}


	public function SendingCount($db, $group)
	{

		if($group == "A"){
			$and = "AND a.flag_black = '0' AND a.email != '' AND a.flag_email = '1' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)' ";
		}else if($group == "B"){
			$and = "AND a.flag_black = '0' AND b.gender = 'M' AND a.email != '' AND a.flag_email = '1' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)' ";
		}else if($group == "C"){
			$and = "AND a.flag_black = '0' AND b.gender = 'F' AND a.email != '' AND a.flag_email = '1' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)' ";
		}else{
			$and = "AND a.flag_black = '1' AND a.email != '' AND a.flag_email = '1' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)'";
		}
	
		$sql = "
			SELECT count(distinct a.email) as count

			FROM Ru_account a, Ru_account_extra b

			WHERE a.flag_email = '1' 

			$and

			AND a.userno = b.userno
			
		";
		
		
		//echo "sql:$sql";exit;

		$row = $db->fetch($sql, true);
		return $row['count'];
	}

	public function GroupSendingCount($db, $group)
	{

		$sql = "
			SELECT count(no) as count

			FROM Ru_mailgroup

			WHERE groupno = '$group' 

		";
		
		
		//echo "sql:$sql";exit;

		$row = $db->fetch($sql, true);
		return $row['count'];
	}

	public function frontierGroupSelect($db, $frno)
	{

	
		$sql = "
			SELECT userno, userid

			FROM Ru_frontier_entry

			WHERE frno = '$frno' 

			AND win = '1'
			
		";
		
		
		//echo "sql:$sql<br>";

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function frontierWinSelect($db, $userno)
	{

	
		$sql = "
			SELECT a.email

			FROM Ru_account a, Ru_account_extra b

			WHERE a.userno = '$userno' 

			AND a.email != ''

			AND a.userno = b.userno
			
		";
		
		
		//echo "sql:$sql<br>";

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function FrnoSelecting($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT frno

			FROM Ru_mailreserve

			WHERE sending = 'N' 

			AND reserve_date <= '$nowtime'
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function MailGroupSelecting($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT recipientgroup

			FROM Ru_mailreserve

			WHERE sending = 'N' 

			AND reserve_date <= '$nowtime'
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function getReserveMailSelect($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT no, subject, sendname, sendtype, recipient, recipientgroup, memo, sendcount, totalcount

			FROM Ru_mailreserve

			WHERE sending = 'N' 

			AND stat != '2'

			AND reserve_date <= '$nowtime'
		";
		

		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function MailGroupStus1($db, $no, $sendtype, $statflag)
	{
		$nowtime = date('YmdHis');


		$sql = "
		UPDATE Ru_mailreserve
		
		SET stat = '$statflag'

		WHERE no = '$no' 

		AND sendtype = '$sendtype'
		";

		//echo "sql:$sql";exit;
		$db->query($sql);
		return $db->result;
	}

	public function MailGroupStusStart($db, $no, $sendtype, $statflag)
	{
		$nowtime = date('YmdHis');


		$sql = "
		UPDATE Ru_mailreserve
		
		SET stat = '$statflag', startdate = now()

		WHERE no = '$no' 

		AND sendtype = '$sendtype'
		";

		//echo "sql:$sql";exit;
		$db->query($sql);
		return $db->result;
	}

	public function MailGroupStus2($db, $no,$sendCnt)
	{


		$sql = "
		UPDATE Ru_mailreserve
		
		SET sendcount = sendcount+$sendCnt

		WHERE no = '$no' 
		";

		//echo "sql:$sql";exit;
		$db->query($sql);
		return $db->result;
	}

	public function MailGroupSelectAll($db, $group, $sendCnt, $limitCnt)
	{

		if($group == "A"){  
			$and = "AND flag_black = '0' AND email != ''";
			
			$sql = "
				SELECT userno, email

				FROM Ru_account

				WHERE flag_email = '1' 

				$and

				ORDER BY userno ASC

				LIMIT $sendCnt, $limitCnt
				
			";
		}else if($group == "B"){ 
			$and = "AND a.flag_black = '0' AND b.gender = 'M' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC

				LIMIT $sendCnt, $limitCnt

			";
		}else if($group == "C"){ 
			
			$and = "AND a.flag_black = '0' AND b.gender = 'F' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC
			
				LIMIT $sendCnt, $limitCnt

			
			";

		}else{ 


			$and = "AND a.flag_black = '1' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC
			
				LIMIT $sendCnt, $limitCnt

			
			";


		}
		
		
		//echo "echo sql:$sql<br>";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}


/*
	Opt Add_1 : Distinct
	Opt Add_2 : Regexp
*/



public function MailGroupSelectAll_distinct($db, $group, $sendCnt, $limitCnt)
	{

		if($group == "A"){  
			$and = "AND flag_black = '0' AND email != '' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)' ";
			
			$sql = "
				
				SELECT distinct email

				FROM Ru_account

				WHERE flag_email = '1' 

				$and

				ORDER BY userno ASC

				LIMIT $sendCnt, $limitCnt
				
			";
			//echo $sql;
		}else if($group == "B"){ 
			$and = "AND a.flag_black = '0' AND b.gender = 'M' AND a.email != ''";
	
			$sql = "
				SELECT distinct a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC

				LIMIT $sendCnt, $limitCnt

			";
		}else if($group == "C"){ 
			
			$and = "AND a.flag_black = '0' AND b.gender = 'F' AND a.email != ''";
	
			$sql = "
				SELECT distinct a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC
			
				LIMIT $sendCnt, $limitCnt

			
			";

		}else{ 


			$and = "AND a.flag_black = '1' AND a.email != ''";
	
			$sql = "
				SELECT distinct a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno

				ORDER BY userno ASC
			
				LIMIT $sendCnt, $limitCnt

			
			";


		}
		
		
		//echo "echo sql:$sql<br>";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

/*
	2012.06.11(Mon)
	Discription : Check count 
	Add 1 : distinct
	Add 2 : Regexp
*/

public function MailGroupSelectAll_distinct_cnt($db, $group)
	{

		if($group == "A"){  
			$and = "AND flag_black = '0' AND email != '' and  email REGEXP '(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)' ";
			
			$sql = "
				
				SELECT count(distinct email) as cnt

				FROM Ru_account

				WHERE flag_email = '1' 

				$and
				
			";
		}else if($group == "B"){ 
			$and = "AND a.flag_black = '0' AND b.gender = 'M' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno
			";
		}else if($group == "C"){ 
			
			$and = "AND a.flag_black = '0' AND b.gender = 'F' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno
							
			";

		}else{ 

			$and = "AND a.flag_black = '1' AND a.email != ''";
	
			$sql = "
				SELECT a.email

				FROM Ru_account a, Ru_account_extra b

				WHERE a.flag_email = '1' 

				$and

				AND a.userno = b.userno
			";
		}
		
		
		//echo "echo sql:$sql<br>";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}



	public function SpecialMailGroupSelect($db, $groupno, $sendCnt, $limitCnt)
	{

		$sql = "
				SELECT mail

				FROM Ru_mailgroup

				WHERE groupno = '$groupno'
			
				LIMIT $sendCnt, $limitCnt

			
			";
			
		$rs = $db->fetch($sql);
		return $rs;

	}


	public function AdminGroupMailCnt($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT count(no) as count

			FROM Ru_mailreserve

			ORDER BY NO DESC
		";
		
		
		//echo "sql:$sql";exit;
		$row = $db->fetch($sql, true);
		return $row['count'];
	}


	public function AdminMailCnt($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT count(no) as count

			FROM Ru_mailsend_history

			ORDER BY NO DESC
		";
		
		
		//echo "sql:$sql";exit;
		$row = $db->fetch($sql, true);
		return $row['count'];
	}


	public function AdminGroupMailselect($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT mailkind, subject, sendname, sendtype, recipient, recipientgroup, reserve_year, reserve_month, reserve_day, reserve_hour, reserve_date, frno, startdate, regdate, sending, stat, sendcount, totalcount

			FROM Ru_mailreserve

			ORDER BY NO DESC
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

	public function AdminMailselect($db)
	{

		$nowtime = date('YmdH');

		$sql = "
			SELECT mailkind, subject, sendname, sendtype, membercount, regdate

			FROM Ru_mailsend_history

			ORDER BY NO DESC
		";
		
		
		//echo "sql:$sql";exit;

		$rs = $db->fetch($sql);
		return $rs;
	}

}
