<?php

class Search
{
	public function Search()
	{
	}
		

    public function SearchFrendType($db,$userid,$fuserid){
	
		//@서로등록한 프렌즈
		$query1 = "SELECT * FROM Ru_friend WHERE 1 AND userno = ".$userid." AND fuserno = ".$fuserid." AND flag_eachother = '1' ";
		//@내가등록한 프렌즈
		$query2 = "SELECT * FROM Ru_friend WHERE 1 AND userno = ".$userid." AND fuserno = ".$fuserid." AND flag_eachother = '0' ";
		//@나를등록한 프렌즈
		$query3 = "SELECT * FROM Ru_friend WHERE 1 AND fuserno = ".$userid." AND userno = ".$fuserid." AND flag_eachother = '0' 	";

		//'echo $query2; 

		//122016(호랭총각1), 126494(호랭총각2)   , 113843(이레네) 
		/* public function fetch($query, $flagRow=false, $flagMaster=false)
			@query = 쿼리내용
			@flagRow = True : 리턴배열값중 최상단 Row 1열 리턴, False : 전체 Row열 리턴
			  > 기본값 : False
			@flagMaster
			 >
		*/	
			$row1 = $db->fetch($query1, true);
			$row2 = $db->fetch($query2, true);
			$row3 = $db->fetch($query3, true);


			if(sizeof($row1) > 0){ // 서로등록한 프렌즈
				$type = 0;
			}else if(sizeof($row2)> 0){ // 내가등록한 프렌즈
				$type = 1;
			}else if(sizeof($row3)> 0){ // 나를 등록한 프렌즈
			    $type = 2;
			}else{
				$type = 3;
			}

	
	return $type;

	}

//	public function Searchlog($db, $url, $check)
//	{
//
//		$wyear = date("Y");
//		$wmonth = date("m");
//		$wday	= date("d");
//
//		if($check > 0){
//			
//			$query = "
//			UPDATE Rz_wizwget_log 
//
//			SET count = count+1
//
//			WHERE url like '%$url%' and wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'
//
//			";
//
//
//		}else{
//			
//			$query = "
//			INSERT	INTO Rz_wizwget_log
//			
//			(rfile, url, count, memo, wyear, wmonth, wday, regdate)
//			
//			VALUES 
//			
//			('', '$url', '1', '', '$wyear', '$wmonth', '$wday', now())
//			";
//			
//			//echo "sql:$sql";exit;
//
//		}
//		$result1 = $db->query($query);
//		return $result1;
//	}
//	
//
//
//	public function SearchDup($db, $url)
//	{
//
//
//		$wyear = date("Y");
//		$wmonth = date("m");
//		$wday	= date("d");
//
//
//
//		$sql = "
//		SELECT		COUNT(no) as cnt
//
//		FROM		Rz_wizwget_log
//
//		WHERE url like '%$url%' and wyear = '$wyear' and wmonth = '$wmonth' and wday = '$wday'
//
//		";
//		//echo "sql:$sql<br>";
//		$row = $db->fetch($sql, true);
//
//		//echo "카운트:$count<br>";
//		return $row['cnt'];
//
//
//	}

}