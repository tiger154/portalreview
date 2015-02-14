#!/usr/local/php5/bin/php -q

<?php
//#!/usr/local/php5/bin/php -q
/***************************************************************************************
* Module Name			:	관리자 - 뉴스 레터 발송
* Created Date			:	2011.09.07
* Created by				:	RevU 박상선 
* Modify History			:   2011.10.10 - 그룹, 프론티어 당첨 그룹메일 추가
									2012.06.05 - 센딩시 loof 변수 값 변경 처리(전체 loof와 동일 변수 사용으로 인한 오류) by Won jeonhwan
									2012.06.05 - 회원목록 중복 이메일 사용자 제거(동일 이메일 사용시 1번만 발송되게 처리) by Won jeonhwan 
									2012.06.11 - 센딩 카운트 로그 추적 추가(DB에서 셀렉팅해온 카운트 값 Echo 처리) by Won jeonhwan
									2012.06.19 - 센드메일 상태 체크 로직 추가(발송중일시 _cron/mail/XXX.txt 파일 생성, 발송 완료시 파일제거, 크론시작시 파일 존재시 exit 미존재시 정상진행 : 전체메일에만 해당) by Won jeonhwan
****************************************************************************************/
//===============================================================
//클론설정
//===============================================================
error_reporting(0);

include "/www/revu39/engine/_sys/sys.conf.cron.php";
include "/www/revu39/engine/_sys/sys.module.php";


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
// FUNCTION
//===============================================================
function mailSendingFileAdd($filename){
	$fp = fopen($filename,"w+");
	fwrite($fp,"Y");
	$returnfile = fgets($fp, 1024);
	fclose($fp);
}

function mailSendingFileDel($filename){
	unlink($filename);
}


//===============================================================
//VARS
//===============================================================
$sendingCheckFile = "/www/revu39/engine/_cron/mail/sendingCheck.txt"; 

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



$limitCnt							= 200;					// 발송 단위수;
$dmailStepNext					= 10000;				// 다음 발송 단위수
$breakNum						= 5;					// DB커넥션이 끊어졌거나 DB정보가 없을때 카운트 하여 break
$breakCnt							= 200;					// break 카운트수


//===============================================================
// Mail Check for sending or not 
//===============================================================
if (is_file($sendingCheckFile)){
	echo "[sending status : busy.] ";
	exit;
}else{
	echo "[sending status : free.] ";
}


/************************** Program logic start ***************************/


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

	$sendCnt		= $mail_list[$i]['sendcount'];				// 현재발송수(바로 전 까지 발송된 수)
	$totalCnt		= $mail_list[$i]['totalcount'];				// 총발송할 수
	


	/////////////////////////////////
	//그룹 전송
	/////////////////////////////////
	if($sendtype == "A"){




			
		//STEP 1. 메일 전송 대기중으로 상태값 변경
		if($sendCnt >= $totalCnt){
			$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "2");
			$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
			//메일발송 성공 로그
			$CLASS_BASE->insertCronLog($DB_LOG, "뉴스레터-".$subject."[".$sendtype."]", __FILE__, "발송완료");
			//************ Sending Check File Del
			mailSendingFileDel($sendingCheckFile);
			echo " [File del final : OK]";
			exit;

		}else{

			//특정그룹 메일 전송처리
			if($groupcode != "A" and $groupcode != "B" and $groupcode != "C" and $groupcode != "D"){
				$statusupdate	= $CLASS_BASIC->MailGroupStusStart($DB, $mno, $sendtype, "1");
				
				$mailgroup_selecting = $CLASS_BASIC->SpecialMailGroupSelect($DB, $groupcode, $sendCnt, $limitCnt);

				$CLASS_EMAIL = &Module::singleton("Email");
				$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

				for($m=0;$m<sizeof($mailgroup_selecting);$m++) {
			
						
							
						if($m > 0){
							$DB->rConnect();
						}
						$email = $mailgroup_selecting[$m]['mail'];

						//이메일 유효성 검사
						if(!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email)) {

							// 이메일이 정확한 것들만 sending 처리
						}else{
							$CLASS_EMAIL->to($email); 
							$CLASS_EMAIL->subject($subject);
							$CLASS_EMAIL->message($editor);
							$result = $CLASS_EMAIL->send();		
						}
							
					
						


				}
				
				if(sizeof($mailgroup_selecting) == 0){
					$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "2");
					$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
					//메일발송 성공 로그
					$CLASS_BASE->insertCronLog($DB_LOG, "뉴스레터-".$subject."[".$sendtype."]", __FILE__, "발송완료");
					exit;
				}
				
				//echo "$m<br>";
				$statusupdate2	= $CLASS_BASIC->MailGroupStus2($DB, $mno, $m);
				//sleep(5);
				break;


			}else{
				$statusupdate	= $CLASS_BASIC->MailGroupStusStart($DB, $mno, $sendtype, "1");

				echo "_nowStartSendCnt:$sendCnt<br>";
				//********** sending Check File ADD
				mailSendingFileAdd($sendingCheckFile); // Sendig check File is Added in 2012.06.19 

							//echo "echo ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒ RevU ReserveNewsLetter Sending Start ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒<br>";

								
							//그룹코드별로 상세데이타 셀렉팅(Ru_account, Ru_account_extra 테이블)
							$mailgroup_selecting = $CLASS_BASIC->MailGroupSelectAll_distinct($DB, $groupcode, $sendCnt, $limitCnt);

							if(sizeof($mailgroup_selecting) == 0){
								$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "2");
								$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
								//메일발송 성공 로그
								$CLASS_BASE->insertCronLog($DB_LOG, "뉴스레터-".$subject."[".$sendtype."]", __FILE__, "발송완료");
								
								//************ Sending Check File Del
								mailSendingFileDel($sendingCheckFile);
								echo " [File del final : OK]";
								echo "메일발송 완료";
								exit;
							}				

							$CLASS_EMAIL = &Module::singleton("Email");
							$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

							for($k=0;$k<sizeof($mailgroup_selecting);$k++) {			
									
										
									if($k > 0){
										$DB->rConnect(); // DB reconnection (ready for disconnect db)
									}
									$email = $mailgroup_selecting[$k]['email'];

									//이메일 유효성 검사 2012.06.18
			//						if(!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)", $email)) {
			//
			//							// 이메일이 정확한 것들만 sending 처리
			//						}else{
			//							$CLASS_EMAIL->to($email); 
			//							$CLASS_EMAIL->subject($subject);
			//							$CLASS_EMAIL->message($editor);
			//							$result = $CLASS_EMAIL->send();		
			//						}
									$CLASS_EMAIL->to($email); 
									$CLASS_EMAIL->subject($subject);
									$CLASS_EMAIL->message($editor);
									$result = $CLASS_EMAIL->send();		

							}				

				
				
						$statusupdate2	= $CLASS_BASIC->MailGroupStus2($DB, $mno, $k); //send count Update
						echo ", _nowEndSendCnt:$k<br>";
				//************ Sending Check File Del
				mailSendingFileDel($sendingCheckFile);
					    echo " [File del : OK]";

				//sleep(5);
				break;
			}


		}



				 



	/////////////////////////////////
	//프론티어 당첨 메일일 경우
	/////////////////////////////////
	}else if($sendtype == "B"){ //


			//보낼 메일이 프론티어 당첨 안내 메일 일 경우 보내지 않은 메일중에  frno를 셀렉팅
			$frno_list		= $CLASS_BASIC->FrnoSelecting($DB);
			$statusstart	= $CLASS_BASIC->MailGroupStusStart($DB, $mno, $sendtype, "");
	
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

					$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype, "2");
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
/**
 * CRON LOG
 */
/*
if(sizeof($mail_list) > 0) {
	switch($sendtype) {
		case "A" : $title = "그룹전송"; break;
		case "B" : $title = "프론티어 당첨 안내 메일일 경우"; break;
		default : $title = "개별메일"; break;
	}
	if($mailreserve_update == false) {
		$msg = "뉴스레터-".$title." 발송 실패";	
	} else {
		$msg = "뉴스레터-".$title." 발송  성공";
	}		
	$CLASS_BASE->insertCronLog($DB_LOG, "뉴스레터-".$title, __FILE__, $msg);
}
*/
// Module close, DBconnection close
Module::exitModule();
?>
