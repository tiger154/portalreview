<?php
$mysqli = new mysqli("121.189.18.73", "revu39", "revu39#1212!", "revu39");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



$zip_query2 = " 
	 (SELECT no, userno, nickname, division , division_no, content, delflag,regdate  FROM Ru_frontier_entrytalk where delflag = '0' and  division = 'T' order by no desc limit 0,2) 
      UNION
     (SELECT tno as no, userno, nickname,'T' as division, 0 as division_no ,  talk as content, flag_del as delflag, regdate   FROM Ru_review_talk where flag_del = '0' order by tno desc limit 0,2)  
     ORDER BY regdate DESC
";


//echo $zip_query2;

//$rs = $mysqli->fetch($zip_query2);


//echo sizeof($rs);
$retArray = array();
$count = 0;
$result = $mysqli->query($zip_query2);

while($rows = mysqli_fetch_assoc($result))
	{
		$retArray[$count] = $rows;
		++$count;
	}

//echo $count;

//if ($result = $mysqli->query($zip_query2)) {
//
//    /* fetch associative array */
//    while ($row = $result->mysqli_fetch_assoc()) {
//        //printf ("%s \n", $row["addr"]);
////		echo  $row["userno"]."<br>";
////		$arr[] = $row["addr"];
////
////		$postarr_left = substr($row["zipcode"],0,3);
////		$postarr_lright= substr($row["zipcode"],3,3);
////		$postarr[] = $postarr_left."-".$postarr_lright;
//		
//    }

//
//
//	echo sizeof($result);
//
//
//    $result->free();
//}

/* close connection */
$mysqli->close();


function getPastTime($regdate)
{
	// replace ko-locale to null
	$string = $regdate;
	$pattern = '/[ㄱ-ㅎㅏ-ㅣ가-힣]/';
	$replacement = '';
	$return_regdate= preg_replace($pattern, $replacement, $string);

	// start time cal
	$ptime = time() - strtotime($return_regdate);
	$time = array();
	$time['day'] = floor($ptime/60/60/24);
	$time['hour'] =  ($ptime/60/60)%24;
	$time['min2'] = ($ptime/60)%60;
	$time['min'] = floor($ptime / 60);
	$time['sec'] = round($ptime % 60);

	
	if($time['day'] <= 0){		
		if($time['hour'] <= 0){
			$time['result_time'] = $time['min2']."분".$time['sec']."초";
		}else{
			$time['result_time'] =$time['hour']."시간".$time['min2']."분".$time['sec']."초";
		}		
	}else{
		$time['result_time'] = $time['day']."일".$time['hour']."시간".$time['min2']."분".$time['sec']."초";
	}	

	return $time;
}
//echo date('Y F jS a h:i:s')."<br>";
//echo time()."<br>";
//echo strtotime("2012-07-06 12:37:58")."<br>";

?>

 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko">
<head>
<title>레뷰 - 세상 모든 것에 대한 리뷰:::</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
</head>
<body>
<?php
	
	



	$time = getPastTime("2012-07-06 오후 12:30:58");
	echo $time['result_time']."<br>";
	//echo $time['day']."일".$time['hour']."시간".$time['min2']."분".$time['sec']."초"."<br>"; 

	$time = getPastTime("2012-07-06 오후 12:03:37");
	echo $time['result_time'];
	//echo $time['day']."일".$time['hour']."시간".$time['min2']."분".$time['sec']."초"."<br>"; 

	$time = getPastTime("2012-07-06 오전 11:40:34");
	echo $time['result_time'];
	//echo $time['day']."일".$time['hour']."시간".$time['min2']."분".$time['sec']."초"."<br>"; 

	$time = getPastTime("2012-07-06 오전 11:40:23");
	echo $time['result_time'];
	//echo $time['day']."일".$time['hour']."시간".$time['min2']."분".$time['sec']."초"."<br>"; 
?>
</body>


