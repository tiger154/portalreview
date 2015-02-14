<?php

class Wizwget
{
	public function Wizwget()
	{
	}
		
	public function Wizwgetlog($db, $url, $check)
	{

		$wyear = date("Y");
		$wmonth = date("m");
		$wday	= date("d");

		if($check > 0){
			
			$query = "
			UPDATE Rz_wizwget_log 

			SET count = count+1

			WHERE url like '%$url%' and wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'

			";


		}else{
			
			$query = "
			INSERT	INTO Rz_wizwget_log
			
			(rfile, url, count, memo, wyear, wmonth, wday, regdate)
			
			VALUES 
			
			('', '$url', '1', '', '$wyear', '$wmonth', '$wday', now())
			";
			
			//echo "sql:$sql";exit;

		}
		$result1 = $db->query($query);
		return $result1;
	}
	


	public function WizwgetlogDup($db, $url)
	{


		$wyear = date("Y");
		$wmonth = date("m");
		$wday	= date("d");



		$sql = "
		SELECT		COUNT(no) as cnt

		FROM		Rz_wizwget_log

		WHERE url like '%$url%' and wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'

		";
		//echo "sql:$sql<br>";
		$row = $db->fetch($sql, true);

		//echo "카운트:$count<br>";
		return $row['cnt'];


	}

}