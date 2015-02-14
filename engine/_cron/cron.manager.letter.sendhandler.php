#!/usr/local/php5/bin/php
<?php
echo "echo '11111111111111111111111'";
//#!/usr/local/php5/bin/php -q
/***************************************************************************************
* Module Name			:	관리자 - 뉴스 레터 발송
* Created Date			:	2011.09.07
* Created by				:	RevU 박상선 
* Modify History			:   2011.10.10 - 그룹, 프론티어 당첨 그룹메일 추가
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
$CLASS_BASE = &Module::singleton("Base");
$CLASS_BASIC = &Module::singleton("Mail.Mailcla");

//===============================================================
//EXTEND_CLASS
//===============================================================

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


$post['confirm_status']		= "S";				// 검수상태값 (N:취소, W:대기, A:승인, C:완료, S:전송중, R:발송대기 )
$limitCnt							= 50;					// 발송 단위수
$dmailStep							= 0;					// 초기 발송수
$dmailStepNext					= 10000;				// 다음 발송 단위수
$breakNum						= 5;					// DB커넥션이 끊어졌거나 DB정보가 없을때 카운트 하여 break
$breakCnt							= 50;					// break 카운트수
$sendCnt							= 0;					// 현재발송수
$sendModule						= "/usr/bin/php ".$PROGRAM_ROOT."/cron/cron.manager.letter.sendhandler.excu.php";		// 발송모듈 사용 안됨
$sendState						= false;





//$mail_list = $CLASS_BASIC->getReserveMail($DB); 예약 메일 가져오기임
$mail_list = $CLASS_BASIC->getReserveMailSelect($DB); // 예약메일 가져오기 구문 추가됨

for($i=0; $i<sizeof($mail_list); $i++){
	// subject, sendname, recipient, memo
	$mno			= $mail_list[$i]['no'];
	$subject		= $mail_list[$i]['subject'];
	$sendname	= $mail_list[$i]['sendname'];
	$sendtype		= $mail_list[$i]['sendtype'];  //sendtype = A 이면 그룹메일 전송, B이면 당첨메일, C이면개별메일 예약정보
	$recipient		= $mail_list[$i]['recipient'];
	$editor			= $mail_list[$i]['memo'];
	$recipientgroup			= $mail_list[$i]['recipientgroup'];
	
	




	/////////////////////////////////
	//그룹 전송
	/////////////////////////////////
	if($sendtype == "A"){




			
		//STEP 1. 메일 전송 대기중으로 상태값 변경
		$statusupdate	= $CLASS_BASIC->MailGroupStus1($DB, $mno, $sendtype);



		echo "echo ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒ RevU ReserveNewsLetter Sending Start ▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒▒";

			
		//그룹코드별로 상세데이타 셀렉팅(Ru_account, Ru_account_extra 테이블)
		if($recipientgroup	== "1"){
			$mailgroup_selecting = $CLASS_BASIC->SpecialMailGroupSelect($DB, "1", $sendCnt, $limitCnt);			
		}else{
			$mailgroup_selecting = $CLASS_BASIC->MailGroupSelectAll($DB, "A", $sendCnt, $limitCnt);
		}
		

		$CLASS_EMAIL = &Module::singleton("Email");
		$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

		for($i=0;$i<sizeof($mailgroup_selecting);$i++) {
	
				++$sendCnt;

				echo "echo $sendCnt";
				if($i > 0){
					$DB->rConnect();
				}
				
				if($recipientgroup	== "1"){
					$email = $mailgroup_selecting[$i]['mail'];
				}else{
					$email = $mailgroup_selecting[$i]['email'];
				}
			
		
				$CLASS_EMAIL->to($email); 
				$CLASS_EMAIL->subject($subject);
				$CLASS_EMAIL->message($editor);
				$result = $CLASS_EMAIL->send();		

				

		}


				 



	/////////////////////////////////
	//프론티어 당첨 안내 메일일 경우
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
	$mailreserve_update = $CLASS_BASIC->ReserveMailUpdate($DB, $mno, "Y");
	

}

/**
 * CRON LOG
 */
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
?>
