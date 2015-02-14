<?php
/***************************************************************************************
* Module Name			:	관리자 - 뉴스 레터 발송
* Created Date			:	2011.09.07
* Created by				:	RevU 박상선 
* Modify History			:   2011.10.10 - 그룹, 프론티어 당첨 그룹메일 추가
****************************************************************************************/


//===============================================================
//CLASS
//===============================================================
$CLASS_BASIC = &Module::singleton("Mail.Mailcla");
$CLASS_BASE = &Module::singleton("Base");		

//===============================================================
//DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");

//===============================================================
//VARS
//===============================================================

$nowyear			= date("Y");
$nowmonth		= date("m");
$nowday			= date("d");

$startyear			= array();
$startmonth		= array();
$startday			= array();
$startnowtime	= array();

$endyear			= array();
$endmonth		= array();
$endday			= array();
$endnowtime		= array();


for($i=$nowyear; $i<=2020; $i++) {
	$startyear[]		= $i;
	$endyear[]		= $i;
}

for($i=1; $i<=12; $i++) {
	$startmonth[]	= $i;
	$endmonth[]		= $i;
}

for($i=1; $i<=31; $i++) {
	$startday[]		= $i;
	$endday[]			= $i;
}

for($i=1; $i<=24; $i++) {
	$starttime[]		= $i;
	$endtime[]		= $i;
}


$limitCnt							= 200;					// 발송 단위수
$dmailStepNext					= 10000;				// 다음 발송 단위수
$breakNum						= 5;					// DB커넥션이 끊어졌거나 DB정보가 없을때 카운트 하여 break
$breakCnt							= 200;					// break 카운트수


$mail_list = $CLASS_BASIC->getReserveMailSelect($DB);

for($i=0; $i<sizeof($mail_list); $i++){
	// subject, sendname, recipient, memo
	$mno			= $mail_list[$i]['no'];
	$subject		= $mail_list[$i]['subject'];
	$sendname	= $mail_list[$i]['sendname'];
	$sendtype		= $mail_list[$i]['sendtype'];  //sendtype = A 이면 그룹메일 전송, B이면 당첨메일, C이면개별메일 예약정보
	$recipient		= $mail_list[$i]['recipient'];
	$editor			= $mail_list[$i]['memo'];
	$groupcode	= $mail_list[$i]['recipientgroup'];

	$sendCnt		= $mail_list[$i]['sendcount'];				// 현재발송수
	$totalCnt		= $mail_list[$i]['totalcount'];				// 총발송할 수
	


	/////////////////////////////////
	//그룹 전송
	/////////////////////////////////
	if($sendtype == "A"){




			
		//STEP 1. 메일 전송 대기중으로 상태값 변경
		if($sendCnt >= $totalCnt){
			$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "2");
			$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
			exit;

		}else{
			$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "1");

			//echo "현재보낸수:$sendCnt<br>";

			//echo "echo ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒ RevU ReserveNewsLetter Sending Start ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒<br>";

				
			//그룹코드별로 상세데이타 셀렉팅(Ru_account, Ru_account_extra 테이블)
			$mailgroup_selecting = $CLASS_BASIC->MailGroupSelectAll($DB, $groupcode, $sendCnt, $limitCnt);



			$CLASS_EMAIL = &Module::singleton("Email");
			$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

			for($i=0;$i<sizeof($mailgroup_selecting);$i++) {
		

					if($i > 0){
						$DB->rConnect();
					}
					$email = $mailgroup_selecting[$i]['email'];

					//이메일 유효성 검사
					if(!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email)) {

						// 이메일이 정확한 것들만 sending 처리
					}else{
						$CLASS_EMAIL->to($email); 
						$CLASS_EMAIL->subject($subject);
						$CLASS_EMAIL->message($editor);
						$result = $CLASS_EMAIL->send();		
					}
						
					//if($sendCnt == 0){
					//	$sendCnt = $sendCnt+1;
					//}else{
					//	$sendCnt = $sendCnt;
					//}

		


			}

			//echo "$i<br>";
			$statusupdate2	= $CLASS_BASIC->MailGroupStus2($DB, $mno, $i);
			sleep(5);
			break;


		}



				 



	/////////////////////////////////
	//프론티어 당첨 메일일 경우
	/////////////////////////////////
	}else if($sendtype == "B"){ //


			//보낼 메일이 프론티어 당첨 안내 메일 일 경우 보내지 않은 메일중에  frno를 셀렉팅
			$frno_list = $CLASS_BASIC->FrnoSelecting($DB);
			
			
			for($q=0;$q<sizeof($frno_list);$q++) {

				

				$frno = $frno_list[$q]['frno'];
				
				if($frno != ""){  //프론티어 번호가 null인것은 제외시킴

					//프론티어번호로 당첨자 userno를  응모테이블에서 셀렉팅
					$user_list = $CLASS_BASIC->frontierGroupSelect($DB, $frno);
					
									
					$CLASS_EMAIL = &Module::singleton("Email");
					$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);


					for($i=0;$i<sizeof($user_list);$i++) {
						
						$userno = $user_list[$i]['userno'];
						//응모테이블에서 셀렉트한 userno로 회원정보에서 메일주소를 셀렉팅
						$frontiergroup_selecting = $CLASS_BASIC->frontierWinSelect($DB, $userno); //당첨된 회원의 메일정보를 가져옴

							for($j=0;$j<sizeof($frontiergroup_selecting);$j++) {

								//echo "$j<br>";


								$email = $frontiergroup_selecting[$j]['email'];  //당첨된 회원의 이메일 정보
								

								if($email != ""){ //이메일이 없는 놈은 제외시킴

									if($j> 0){ //두번째부터 DB리컨넥션
										$DB->rConnect();
									}
							
									$CLASS_EMAIL->to($email); 
									$CLASS_EMAIL->subject($subject);
									$CLASS_EMAIL->message($editor);
									$result = $CLASS_EMAIL->send();		

								}

							}
						
					}
				}
			}


	/////////////////////////////////
	//개별 메일일경우
	/////////////////////////////////
	}else{ //
		//echo "subject:$subject";
		$tomail = trim($recipient); //수신자 공백제거
		$marr=explode('|' , $tomail); // . 를 구분자로하여 문자열을 분리, 배열로 리턴,,,
		$tono=sizeof($marr);
		$tonocheck = $tono-1;
		//$recipientimp= implode('|' , $marr); 


		/////////////////////////////////
		//개별 메일 : 수신자 한명일때
		/////////////////////////////////
		if($tonocheck == 1 || $tonocheck == 0){ //수신자가 한명일때 (찾기 : ^&^)

					
				$CLASS_EMAIL = &Module::singleton("Email");
				$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

				$CLASS_EMAIL->to($recipient); 
				$CLASS_EMAIL->subject($subject);
				$CLASS_EMAIL->message($editor);
				$result = $CLASS_EMAIL->send();		
				


		/////////////////////////////////
		//개별 메일 : 수신자 한명 이상일때
		/////////////////////////////////
		}else{ //수신자가 여러명일때

				for ($i=0 ; $i<$tono ; $i++) {
						//$marr[$i];
						//echo "$marr[$i]<br>";
						$CLASS_EMAIL = &Module::singleton("Email");
						$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

						$CLASS_EMAIL->to($marr[$i]); 
						$CLASS_EMAIL->subject($subject);
						$CLASS_EMAIL->message($editor);
						$result = $CLASS_EMAIL->send();			

				}
		}
	}
	
	//메일 보냈다는 플래그 처리 : sending 컬럼 Y로 업데이트 처리
	//$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
	

}


?>
