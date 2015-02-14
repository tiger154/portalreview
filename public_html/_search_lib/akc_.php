<?php
	//echo  "ip : " . $serverInfo['akc_ip'][0]['value'];
	//POST Method를 사용하기 위새서는 UTF-8을 EUC-KR로 변환이 필요하다.
	//참고 : ICONV를 이용.

	//header("Content-Type: text/html; charset=euc-kr");

	$query = $_GET['q'];
	$select = $_GET['s'];

	$from="EUC-KR";
	$to="UTF-8";

	$nKwd=0;
	$kwd_list=array(100,10);
	$nDomainNo=0;
	$max_kwd_count=10;
	$seed_str=$query;
	$nFlag=2;
	$cnv_str;
	
	$outTag=array(100,10);
	$outNum=array(100,10);
	$outRank=array(100,10);
	
	if($select=='0')
		$nFlag=0;
	else if($select=='1')
		$nFlag=1;
	else
		$nFlag=2;

	$crz = new DOCRUZER;
	$hc = $crz->CreateHandle();

	$rc = $crz->CompleteKeyword2($hc,
								$serverInfo['DAEMON_SERVICE_ADDRESS'][0]['value'],
								&$nKwd, 
								&$kwd_list, 
								&$outRank,
								&$outTag,
								&$outNum,
								&$cnv_str, 
								$max_kwd_count, 
								$seed_str, 
								$nFlag,
								$nDomainNo);

	//echo "rc : " . $rc ;
	
	if($rc<0)
	{
		header("HTTP/1.1 No Content");
		echo "error:".$crz->GetErrorMessage($hc)."\n";		
		exit;
	}

	$body="var myJSONObject = {\"LIST\": [";
	for($i=0; $i<$nKwd; $i++) 
	{
		if($i!=0)
		{
			$body=$body.",";
		}
		$body = $body."{\"KEYWORD\": \"";
		$body = $body.$kwd_list[$i];
		$body = $body."\"}";
	}
	$body=$body."]};";
	

	$body= $body."var myJSONObject2 = {\"LIST\": [";
	for($i=0; $i<$nKwd; $i++) 
	{
		if($i!=0)
		{
			$body=$body.",";
		}
		$body = $body."{\"RANK\": \"";
		$body = $body.$outRank[$i];
		$body = $body."\"}";
	}
	$body=$body."]};";
	
	if($cnv_str=="")
                $body=$body."eQuery=\"\";";
        else
                $body=$body."eQuery=\"".$cnv_str."\";";

	$crz->DestroyHandle($hc);

	echo $body;    
?>

