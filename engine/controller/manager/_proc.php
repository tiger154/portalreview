<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $AUTH;
GLOBAL $LOGIN;
GLOBAL $SITE;
GLOBAL $FRAME;

$CLASS_AUTH					= &Module::singleton("auth.admin");  
$CLASS_LOGIN					= &Module::singleton("auth.login");  
$CLASS_FRONTIER				= &Module::singleton("frontier.frontier");  
$CLASS_FTP						= &Module::singleton("Ftp");
$CLASS_FILE						= &Module::singleton("File");
$CLASS_THUMBNAIL			= &Module::singleton("Thumbnail");
$CLASS_EMAIL 					= &Module::singleton("Email");
$CLASS_REVIEW				= &Module::singleton("Review.Review");
$CLASS_REVIEWBEST		= &Module::singleton("Review.ReviewBest");
$CLASS_REVIEWKEYWORD	= &Module::singleton("Review.ReviewKeyword");
$CLASS_MANAGER			= &Module::singleton("manager.manager");
$CLASS_BASIC					= &Module::singleton("Mail.Mailcla");
$CLASS_USER					= &Module::singleton("User.User");
$CLASS_CASH					= &Module::singleton("User.Cash");
$CLASS_MANAGER			= &Module::singleton("Manager.Manager");

$DB = &Module::loadDb("revu");
$DB_LOG = &Module::loadDb("revulog");
$adminno = $_SESSION["userno"];

$jsonArr = array();

switch(Module::$todo)
{

	case "logout.proc" : 		
		$_POST['referer'] = ($_POST['referer'] != "") ? $_POST['referer'] : $_SERVER['HTTP_REFERER'];
		$_POST['login_type'] = $_SESSION['type']."O";
		$CLASS_LOGIN->insertLoginLog($DB_LOG, $_SESSION, $_POST);
		$CLASS_LOGIN->initSession();
		Module::redirect("/manager");
		break;
	
	case "user.info" : 
		$FRAME = "ajax"; 
		$user = $CLASS_USER->getUser($DB, $_POST['userno']);
		if($user['userno'] != "") {
			$jsonArr['result'] = "success";
			$jsonArr['user'] = $user;
		} else {
			$jsonArr['result'] = "fail";
			$jsonArr['user'] = $user;
		}
		break;
	
	case "user.flag.black.proc" :
		$adminno = $_SESSION["userno"];
		$message = "회원 블랙리스트 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1001", $_POST['userno'], "", "", $log_message);
		$FRAME = "ajax";
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['flag_black']; 
		$res = array();
		$res[] = $DB->call("p_account_flag_black_upd", $arr);
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
			$jsonArr['flag_black'] = $_POST['flag_black'];
		}
		break;
	
	case "user.flag.powerblog.proc" :
		$adminno = $_SESSION["userno"];
		$message = "회원 파워블로거 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1001", $_POST['userno'], "", "", $log_message);
		$FRAME = "ajax";
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['flag_powerblog']; 
		$res = array();
		$res[] = $DB->call("p_account_flag_powerblog_upd", $arr);
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
			$jsonArr['flag_powerblog'] = $_POST['flag_powerblog'];
		}
		break;

	case "user.flag.email.proc" :
		$adminno = $_SESSION["userno"];
		$message = "회원-이메일수신여부처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1001", $_POST['userno'], $_POST['flag_email'], "", $log_message);
		$FRAME = "ajax";
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['flag_email']; 
		$res = array();
		$res[] = $DB->call("p_account_flag_email_upd", $arr);
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
			$jsonArr['flag_email'] = $_POST['flag_email'];
		}
		break;
	
	case "user.email.send.proc" : 
		$FRAME = "ajax";
		$CLASS_EMAIL->from('no-reply@revu.co.kr', $_POST['sender']);
		$CLASS_EMAIL->to($_POST['email']);
		$CLASS_EMAIL->subject($_POST['subject']);
		$CLASS_EMAIL->message($_POST['content']);
		if($CLASS_EMAIL->send() == true) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}	
		break;
	
	case "user.powerblog.proc" : 
		$adminno = $_SESSION["userno"];
		$message = "회원-파워블로그 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1002", $_POST['ano'], "", "", $log_message);

		$FRAME = "ajax";
		$arr = array();
		$arr[] = $_POST['ano'];
		$arr[] = $_POST['flag']; 
		$res = array();
		$res[] = $DB->call("p_powerblog_application_upd", $arr);
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
		}
		break;
	
	case "user.memo.proc" :			
		$admin_log = $CLASS_MANAGER->adminlog($DB, $_SESSION["userno"], "1003", $_POST['userno'], "", "", "회원-메모 처리");
		
		$FRAME = "ajax";
		$arr = array();		
		$arr[] = $_POST['userno'];
		$arr[] = $_SESSION['userno'];
		$arr[] = $_POST['content'];								
		$res = array();
		$res[] = $DB->call("p_account_memo_ins", $arr);
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
		}
		break;

	case "user.secede.proc" : 
		$adminno = $_SESSION["userno"];
		$message = "회원-탈퇴 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1003", $_POST['userno'], "", "", $log_message);	

		$FRAME = "ajax";
		$arr = array();		
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['secede_type'];
		$arr[] = $_POST['content'];								
		$res = array();
		$res[] = $DB->call("p_account_del", $arr);				
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
		}
		break;
	
	case "user.cash.proc" : 
		$adminno = $_SESSION["userno"];
		$message = "회원-캐시지급 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1003", $_POST['userno'], $_POST['cash'], $_POST['cash_type'], $log_message);

		$FRAME = "ajax";
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = $_POST['flag_sign'];
		$arr[] = $_POST['cash_type'];
		$arr[] = $_POST['cash'];
		$arr[] = $_POST['rno'];
		$res = array();
		$res[] = $DB->call("p_cash_ins", $arr);	
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
			$jsonArr['flag_sign'] = $_POST['flag_sign'];
			$jsonArr['cash'] = number_format($_POST['cash']);
		}
		break;
	
	case "user.admin.regist.proc" : 
		$FRAME = "ajax"; 
		$user = array();
		$user['userno'] = $_POST['userno'];
		$user['grade'] = $_POST['grade'];
		$user['admin_desc'] = $_POST['admin_desc'];
		if($user['userno'] == "" || $user['grade'] == "" || $user['admin_desc'] == "") {
			$jsonArr['result'] = "fail";
			break;
		}
		if($CLASS_USER->isUser($DB, $user['userno']) == false) {
			$jsonArr['result'] = "exist";
			break;
		}
		$user['grade'] = "10".$user['grade'];
		if($CLASS_MANAGER->registAdminUser($DB, $user) == true) {		
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "user.admin.delete.proc" : 
		$FRAME = "ajax"; 
		if($CLASS_MANAGER->deleteAdminUser($DB, $_POST['userno']) == true) {		
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;

	case "mail.sending.proc" :

		$subject			= $_POST["subject"];
		$sendname		= $_POST["sendname"];
		$mtype				= $_POST["mtype"];
		$recipient			= $_POST["recipient"]; 
		$mailgroup			= $_POST["mailgroup"];
		$frontier			= $_POST["frontiergroup"];
		$editor				= $_POST["editor"];
		$sending			= $_POST["sending"];
		$reserve_year	= $_POST["reserve_year"];
		$reserve_month	= $_POST["reserve_month"];
		$reserve_date	= $_POST["reserve_date"];
		$reserve_time		= $_POST["reserve_time"];
		$command		= $_POST["command"];

		if($sending == "R"){ 

			$mailkind = "N"; 
			$tomail = trim($recipient); 
			$marr=explode(';', $tomail); 
			$tono=sizeof($marr);
			$tonocheck = $tono-1;
			$recipientimp= implode('|' , $marr); 

			$daylan = strlen($reserve_time);
			if($daylan < 2){
					$reserve_time = "0".$reserve_time;
			}

			$monthlan = strlen($reserve_month);
			if($monthlan < 2){
					$reserve_month = "0".$reserve_month;
			}

			$datelan = strlen($reserve_date);
			if($datelan < 2){
					$reserve_date = "0".$reserve_date;
			}

			$reserve_result = $reserve_year.$reserve_month.$reserve_date.$reserve_time;
			
			if($mailgroup == "A" || $mailgroup == "B" || $mailgroup == "C" || $mailgroup == "D"){

				
				$message = "그룹".$mailgroup." 예약발송처리";
				$log_message = $message;
				$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "2002", $subject, $userno, '', $log_message);
				


				$mailcount = $CLASS_BASIC->SendingCount($DB, $mailgroup);  
				
			}

			
			$MailArr = array();		
			$MailArr[] = $mailkind;
			$MailArr[] = $subject;			
			$MailArr[] = $sendname;			
			$MailArr[] = $mtype;		
			
			
			if($tono < 2){ 
				$MailArr[] = $recipient;						
			}else{ 
				$MailArr[] = $recipientimp;			
			}	

			$MailArr[] = $mailgroup;
			$MailArr[] = $editor;			
			$MailArr[] = $reserve_year;			
			$MailArr[] = $reserve_month;			
			$MailArr[] = $reserve_date;			
			$MailArr[] = $reserve_time;			
			$MailArr[] = $reserve_result;
			$MailArr[] = "N"; 
			$MailArr[] = $frontier;
			$MailArr[] = $mailcount; 

			$result = array();		
			$result[] = $DB->call("p_mail_reserve", $MailArr);

			echo "
						<script>
							alert('메일이 예약되었습니다.');
						</script>
				";	   
			Module::redirect("/manager/letter.step1");


		}else{ 

			
			$mailkind = "N"; 

			switch($mtype)
			{
				case "E":
				
				$tomail = trim($recipient); 
				$marr=explode(';', $tomail); 
				$tono=sizeof($marr);
				$tonocheck = $tono-1;
				$recipientimp=implode('|' , $marr); 
				
				if($tonocheck == 1 || $tonocheck == 0){ 

					$message = "메일 개별전송";
					$log_message = $message;
					$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "2001", $subject, $userno, '', $log_message);

					$MailArr = array();		
					$MailArr[] = $mailkind;
					$MailArr[] = $subject;			
					$MailArr[] = $sendname;			
					$MailArr[] = $mtype;			
					$MailArr[] = $recipient;			
					$MailArr[] = $mailgroup;			
					$MailArr[] = $editor;			
					$MailArr[] = $tono;
					$MailArr[] = $frontier;

					$result = array();		
					
					$result[] = $DB->call("p_mail_history", $MailArr);
				
					
					$CLASS_EMAIL = &Module::singleton("Email");
					$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

					$CLASS_EMAIL->to($recipient); 


					$CLASS_EMAIL->subject($subject);
					$CLASS_EMAIL->message($editor);
					$result = $CLASS_EMAIL->send();		

					if($result != "1"){
						echo "
					   <script>
						alert('메일전송 실패');
					   </script>
						";
					}else{
						echo "
						<script>
							alert('개별 메일이 전송되었습니다.');
						</script>
						";	   
					}
					Module::redirect("/manager/letter.step1");


				}else{ 
					
				
					$message = "메일 개별메일 다수 수신자 전송";
					$log_message = $message;
					$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "2001", $subject, $userno, '', $log_message);
										
					 for ($i=0 ; $i<$tono ; $i++) {
					
						
						
						
						$CLASS_EMAIL = &Module::singleton("Email");
						$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

						if($i == 0){ 

							$MailArr = array();		
							$MailArr[] = $mailkind;
							$MailArr[] = $subject;			
							$MailArr[] = $sendname;			
							$MailArr[] = $mtype;			
							$MailArr[] = $recipientimp;			
							$MailArr[] = $mailgroup;			
							$MailArr[] = $editor;			
							$MailArr[] = $tono;
							$MailArr[] = $frontier;

							$result = array();		

							$result[] = $DB->call("p_mail_history", $MailArr);

						}
						$CLASS_EMAIL->to($marr[$i]); 
						$CLASS_EMAIL->subject($subject);
						$CLASS_EMAIL->message($editor);
						$result = $CLASS_EMAIL->send();			

					 }
					 

					 if($result != "1"){
						echo "
					   <script>
						alert('메일전송 실패');
					   </script>
						";
					}else{
						echo "
						<script>
							alert('그룹 메일이 전송되었습니다.');
						</script>
						";	   
					}

					Module::redirect("/manager/letter.step2");

				}
				break;


				case "A":
								
				$mailkind = "N"; 
			
				$tomail = trim($recipient); 
				$marr=explode(';', $tomail); 
				$tono=sizeof($marr);
				$tonocheck = $tono-1;
				$recipientimp= implode('|' , $marr); 

				$daylan = strlen($reserve_time);
				if($daylan < 2){
						$reserve_time = "0".$reserve_time;
				}

				$monthlan = strlen($reserve_month);
				if($monthlan < 2){
						$reserve_month = "0".$reserve_month;
				}

				$datelan = strlen($reserve_date);
				if($datelan < 2){
						$reserve_date = "0".$reserve_date;
				}

				$reserve_result = $reserve_year.$reserve_month.$reserve_date.$reserve_time;
				
				
				
				if($mailgroup == "A" || $mailgroup == "B" || $mailgroup == "C"){
					$mailcount = $CLASS_BASIC->SendingCount($DB, $mailgroup);  
					
				}else{
					
					if($mailgroup == "1"){ 
						// 테스트 메일 그룹
						$mailcount = $CLASS_BASIC->GroupSendingCount($DB, $mailgroup);  
					}
				}

				$message = "메일 그룹전송";
				$log_message = $message;
				$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "2002", $subject, $userno, '', $log_message);
								
				$MailArr = array();		
				$MailArr[] = $mailkind;
				$MailArr[] = $subject;			
				$MailArr[] = $sendname;			
				$MailArr[] = $mtype;		
				
				
				if($tono < 2){ 
					$MailArr[] = $recipient;						
				}else{ 
					$MailArr[] = $recipientimp;			
				}	


				$MailArr[] = $mailgroup;		
				
				$MailArr[] = $editor;			
				$MailArr[] = $reserve_year;			
				$MailArr[] = $reserve_month;			
				$MailArr[] = $reserve_date;			
				$MailArr[] = $reserve_time;			
				$MailArr[] = $reserve_result;
				$MailArr[] = "N"; 
				$MailArr[] = $frontier;
				$MailArr[] = $mailcount; 

				$result = array();		
				
				$result[] = $DB->call("p_mail_reserve", $MailArr);
				
				Module::alert("발송처리 되었습니다.");

				Module::redirect("/manager/letter.step1");

				break;

				case "B":
				
				$user_list = $CLASS_BASIC->frontierGroupSelect($DB, $frontier);
				
								
				$CLASS_EMAIL = &Module::singleton("Email");
				$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);


				$message = "메일 프론티어 당첨 메일 전송";
				$log_message = $message;
				$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "2003", $subject, $userno, '', $log_message);
				

				for($i=0;$i<sizeof($user_list);$i++) {
					
					$userno = $user_list[$i]['userno'];
					$frontiergroup_selecting = $CLASS_BASIC->frontierWinSelect($DB, $userno); 

						for($j=0;$j<sizeof($frontiergroup_selecting);$j++) {

							$email = $frontiergroup_selecting[$j]['email'];  

							if($email != ""){ 

								if($j> 0){ 
									$DB->rConnect();
								}
								$MailArr = array();		
								$MailArr[] = $mailkind;
								$MailArr[] = $subject;			
								$MailArr[] = $sendname;			
								$MailArr[] = $mtype;			
								$MailArr[] = $email;			
								$MailArr[] = $mailgroup;			
								$MailArr[] = $editor;			
								$MailArr[] = $tono;
								$MailArr[] = $frontier;

								$result = array();		
								
								$result[] = $DB->call("p_mail_history", $MailArr);
						
								$CLASS_EMAIL->to($email); 
								$CLASS_EMAIL->subject($subject);
								$CLASS_EMAIL->message($editor);
								$result = $CLASS_EMAIL->send();		

							}

						}
					
				}


						echo "
						<script>
							alert('프론티어 당첨 메일이 전송되었습니다.');
						</script>
						";	   


				Module::redirect("/manager/letter.step3");
				break;

				default :
				Module::alert("메일전송오류.");
				break;

			}

		}
		break;
	
	case "cash.withdraw.proc" : 

		$adminno = $_SESSION["userno"];
		$message = "회원-캐시지급 처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "4001", $withdraw['userno'], $withdraw['cash'], "", $log_message);

		$FRAME = "ajax";			
		$arr = array();
		$arr[] = $_POST['wno'];
		$arr[] = $_POST['flag_pay']; 
		$res = array();
		$res[] = $DB->call("p_cash_withdraw_upd", $arr);		
		if($res[0]['orcode'] == '1') {
			if($_POST['flag_pay'] == "2") {		
				$withdraw = $CLASS_CASH->getCashWithdraw($DB, $_POST['wno']);			
				$arr = array();
				$arr[] = $withdraw['userno'];
				$arr[] = "0"; 
				$arr[] = "900"; 
				$arr[] = $withdraw['cash'];
				$arr[] = "";
				$DB->rConnect();
				$res[] = $DB->call("p_cash_ins", $arr);
			}
		}		
		if(Module::result($res, "err", "-1") == false) {
			$jsonArr['result'] = "fail";
		} else {
			$jsonArr['result'] = "success";
		}
		break;


	
	case "frontier.regist.proc" :
	
		if($_SESSION["userno"] <= 0) {
			Module::alert("잘못된 방법으로 접근하셨습니다. 관리자에게 문의하세요");
			break;
		}
		$message = "프론티어 등록";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "7002", "", "", "", $log_message);
	
		$etype							= $_POST["etype"]; 
		$thumbtype					= $_POST["thumbtype"]; 
		$ctype							= $_POST["ctype"]; 
		$cate1							= $_POST["cate1"]; 
		$cate2							= $_POST["cate2"]; 
		$cate3							= $_POST["cate3"]; 
		$cate4							= $_POST["cate4"]; 

		$subject						= $_POST["subject"]; 
		$subject						= str_replace("'","\'",$subject);
		
		$sdate1							= $_POST["sdate1"]; 
		$sdate2							= $_POST["sdate2"]; 
		$sdate3							= $_POST["sdate3"]; 
		$sdate4							= $_POST["sdate4"]; 
		$edate1							= $_POST["edate1"]; 
		$edate2							= $_POST["edate2"]; 
		$edate3							= $_POST["edate3"]; 
		$edate4							= $_POST["edate4"]; 
		$mcount						= $_POST["mcount"]; 
		$ndate1							= $_POST["ndate1"]; 
		$ndate2							= $_POST["ndate2"]; 
		$ndate3							= $_POST["ndate3"]; 
		$review_sdate1				= $_POST["review_sdate1"]; 
		$review_sdate2				= $_POST["review_sdate2"]; 
		$review_sdate3				= $_POST["review_sdate3"]; 
		$review_edate1				= $_POST["review_edate1"]; 
		$review_edate2				= $_POST["review_edate2"]; 
		$review_edate3				= $_POST["review_edate3"]; 
		$rproduct						= $_POST["rproduct"]; 
		$rproduct						= str_replace("'","\'",$rproduct);

		$rprice							= $_POST["rprice"]; 
		if($rprice	== "0"){
			$rprice = "";
		}
		$area_bcode1				= $_POST["area_bcode1"]; 
		$area_mcode1				= $_POST["area_mcode1"]; 
		$area_scode1				= $_POST["area_scode1"]; 
		$addr							= $_POST["addr2"]; 

		$addr							= str_replace("'","\'",$addr);

		$map							= $_POST["map"]; 
		$tel1								= $_POST["tel1"]; 
		$tel2								= $_POST["tel2"];
		$tel3								= $_POST["tel3"];
		$mobile1						= $_POST["mobile1"];
		$mobile2						= $_POST["mobile2"];
		$mobile3						= $_POST["mobile3"];
		$homepage					= $_POST["homepage"];
		$homepage					= str_replace("'","\'",$homepage);

		$cashcon						= $_POST["cashcon"]; 
		$bigo							= $_POST["bigo"]; 
		$bestreviewerday1			= $_POST["bestreviewerday1"];
		$bestreviewerday2			= $_POST["bestreviewerday2"];
		$bestreviewerday3			= $_POST["bestreviewerday3"];
		$bestrevieweraword		= $_POST["bestrevieweraword"];
		
		$editorContent				= $_POST["editor"];			
		$editorContent				= str_replace("'","\'",$editorContent);


		$titlekeyword					= $_POST["titlekeyword"]; 
		$titlekeyword					= str_replace("'","\'",$titlekeyword);

		$storykeyword				= $_POST["storykeyword"]; 
		$storykeyword				= str_replace("'","\'",$storykeyword);

		$tip								= $_POST["tip"]; 
		$tip								= str_replace("'","\'",$tip);

		$topimage						= $_POST["topimage"]; 
		$thumbimage					= $_POST["thumbimage"]; 
		$bannerimage				= $_POST["bannerimage"]; 
		$bannercode					= $_POST["bannercode"]; 
		$bestreviewer_count		= $_POST["bestreviewer_count"]; 

		$sdate = $sdate1."-".$sdate2."-".$sdate3." ".$sdate4; 

		$edate = $edate1."-".$edate2."-".$edate3." ".$edate4; 
		$review_sdate = $review_sdate1."-".$review_sdate2."-".$review_sdate3; 
		$review_edate = $review_edate1."-".$review_edate2."-".$review_edate3; 
		$notice_date = $ndate1."-".$ndate2."-".$ndate3;  
		$bestreviewer_day = $bestreviewerday1."-".$bestreviewerday2."-".$bestreviewerday3; 

		if($cate3 == "")$cate3 = "000";
		if($cate2 == "")$cate2 = "000";
		$catecode = $cate1.$cate2.$cate3.$cate4; 

		
		$frontier_id = "F_".date('YmdHis');

		if($thumbtype == ""){
			$thumbtype = "B";
		}

		$ftbArr = array();		
		$ftbArr[] = $frontier_id;
		$ftbArr[] = $subject;
		$ftbArr[] = $etype;
		$ftbArr[] = $thumbtype;
		$ftbArr[] = $catecode;
		$ftbArr[] = $mcount;
		$ftbArr[] = $sdate;
		$ftbArr[] = $edate;
		$ftbArr[] = $notice_date; 
		$ftbArr[] = $bestreviewer_day;
		$ftbArr[] = $bestrevieweraword;
		$ftbArr[] = $bestreviewer_count;
		$ftbArr[] = $review_sdate;
		$ftbArr[] = $review_edate;
		$ftbArr[] = $titlekeyword;
		$ftbArr[] = $storykeyword;
		$ftbArr[] = $tip;
		$ftbArr[] = $ctype;
		$ftbArr[] = $editorContent;
		

		$res = array();		
		
		$res[] = $DB->call("p_frontier_ins", $ftbArr);

		if($res[0]['orcode'] == '1') {  
			
			
			$frontier_No = $res[0]['frno']; 

			$dirname = date("Y");

			#########################################################
			#########################################################
			$dir1 = _FTP_FRONTIERIMAGE."/"."title_img"."/".$dirname;			
			$dir2 = _FTP_FRONTIERIMAGE."/"."list_img"."/".$dirname;			
			$dir3 = _FTP_FRONTIERIMAGE."/"."banner_img"."/".$dirname;		
			$dir4 = _FTP_FRONTIERIMAGE."/"."rel_file"."/".$dirname;				
			$dir5 = _FTP_FRONTIERIMAGE."/"."list_simg"."/".$dirname;				
			$dir6 = _FTP_FRONTIERIMAGE."/"."list_mimg"."/".$dirname;				

			#########################################################
			#########################################################
			
			
			$file1 = $res[0]['frno'].".gif"; 
			$title_img = $file1;
		
			$CLASS_FILE->upload($_FILES['file1'], $file1, _DIR_TMP); 
			$CLASS_FTP->connect("file"); 
			$CLASS_FTP->makeDir($dir1); 
			$CLASS_FTP->upload($dir1."/".$file1, _DIR_TMP."/".$file1); 


			if($CLASS_FILE->isRunByMime($_FILES['file2']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			
			if($_FILES['file2']['error'] == "0") {
				$tmp = $_FILES['file2']['tmp_name'];
				$mime = $_FILES['file2']['type'];
				$size = $_FILES['file2']['size'];			
				$file1 = $_FILES['file2']['name'];
				$file2 =  $res[0]['frno'].".gif";
				
				
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 224, 224) == true) {
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir2);
					$CLASS_FTP->upload($dir2."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir2."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
				
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 66, 66) == true) {
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir5);
					$CLASS_FTP->upload($dir5."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir5."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}

				
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 110, 110) == true) {
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir6);
					$CLASS_FTP->upload($dir6."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir6."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}

			if($CLASS_FILE->isRunByMime($_FILES['file3']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			if($_FILES['file3']['error'] == "0") {
				$tmp = $_FILES['file3']['tmp_name'];
				$mime = $_FILES['file3']['type'];
				$size = $_FILES['file3']['size'];			
				$file1 = $_FILES['file3']['name'];
				$file2 =  $res[0]['frno'].".gif";
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 225, 90) == true) {
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir3);
					$CLASS_FTP->upload($dir3."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir3."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}

			$rel_file = $CLASS_FILE->getExtname($_FILES['file4']['name']);
			if ($rel_file != ""){

				$file4 = $res[0]['frno'].".".strtolower($CLASS_FILE->getExtname($_FILES['file4']['name'])); 
				$CLASS_FILE->upload($_FILES['file4'], $file4, _DIR_TMP); 
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir4); 
				$CLASS_FTP->upload($dir4."/".$file4, _DIR_TMP."/".$file4); 
				$CLASS_FTP->close(); 
				$CLASS_FILE->delete(_DIR_TMP."/".$file4);

			}			
			
			$ftoArr = array();
			$ftoArr[] = $frontier_No; 
			$ftoArr[] = $frontier_id; 
			$ftoArr[] = $rproduct; 
			$ftoArr[] = $area_bcode1.$area_mcode1.$area_scode1; 
			$ftoArr[] = $addr; 
			$ftoArr[] = $rprice; 
			$ftoArr[] = $bigo; 
			$ftoArr[] = $title_img; 
			$ftoArr[] = $map; 
			$ftoArr[] = $homepage; 
			$ftoArr[] = $cashcon; 
			

			if($tel2 == ""){
				$ftoArr[] = "";
			}else{
				$ftoArr[] = $tel1."-".$tel2."-".$tel3; 
			}
			if($mobile2 == ""){
				$ftoArr[] = "";
			}else{
				$ftoArr[] = $mobile1."-".$mobile2."-".$mobile3;  
			}


			$ftoArr[] = $file4;
			$ftoArr[] = $bannercode;

			$DB->rConnect();

			$res2 = array();		


			$res2[] = $DB->call("p_frontierorter_ins", $ftoArr);

			reset($_POST["option"]);
			while (list($option,$val) = each($_POST["option"])) {
				
				if($option != "0"){
					$optionArr = array();
					$optionArr[] = $frontier_No; 
					$optionArr[] = $frontier_id; 
					$optionArr[] = $val; 
					
					if($val != ""){
						$DB->rConnect();

						$res3 = array();		


						$res3[] = $DB->call("p_frontieroption_ins", $optionArr);

						if($res3[0]['orcode'] == '1') {  
							
						}else{
							echo "옵션정보 입력 실패<br>";
						}
					}
				}

			}


		}else{	 
			echo "오류";
		}
		



		Module::redirect("/manager/frontier.list");
		break;

	

	case "frontier.registbanner.proc" :
		$bannertype = $_POST["btype"]; 
		$linktype		= $_POST["link"]; 
		$campaign		= $_POST["subject"]; 
		$campaign		= str_replace("'","\'",$campaign);

		$spon			= $_POST["spon"]; 
		$spon			= str_replace("'","\'",$spon);

		$linurl			= $_POST["homepage"]; 



		
		$message = "배너등록";
		$log_message = $message;
		if($adminno <= 0) {
			Module::redirect("/manager/");
			break;
		}
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "6003", "", "", "", $log_message);

		#########################################################
		#########################################################
		$dir1 = _FTP_BANNERIMAGE;			
		#########################################################
		#########################################################
		
		$filename = date("Ymdhis").".gif"; 

		if($bannertype == "M"){

			if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			
			if($_FILES['file1']['error'] == "0") {
				$tmp = $_FILES['file1']['tmp_name'];
				$mime = $_FILES['file1']['type'];
				$size = $_FILES['file1']['size'];			
				$file1 = $_FILES['file1']['name'];
				$file2 =  $filename;

				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 714, 134) == true) {
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir1);
					$CLASS_FTP->upload($dir1."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir1."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}
		}else{

			if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			if($_FILES['file1']['error'] == "0") {
				$tmp = $_FILES['file1']['tmp_name'];
				$mime = $_FILES['file1']['type'];
				$size = $_FILES['file1']['size'];			
				$file1 = $_FILES['file1']['name'];
				$file2 =  $filename;

				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 225, 172) == true) {  
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir1);
					$CLASS_FTP->upload($dir1."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir1."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}
		}
		


		$res = $CLASS_MANAGER->BannerInsert($DB, $bannertype, $linktype, $campaign, $spon, $linurl, $filename);
		
		if($res == true) {
		    Module::alert("배너가 등록되었습니다.");
			Module::redirect("/manager/regist.banner");
		} else {
		    Module::alert("오류");
			Module::redirectModule("manager");
		}
	break;

	case "review.status.proc" :

		$adminno = $_SESSION["userno"];
		$message = "리뷰 상태값 변경";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['rno'], $_POST['status'], "", $log_message);

		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['rno'];
		$arr[] = $_POST['status'];
		$res = array();
		$res[] = $DB->call("p_review_status_upd", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
			$jsonArr['status'] = $_POST['status'];
		} else {
			$jsonArr['result'] = "fail";
		}
		break;

	case "review.keyword.app.proc" :

		$adminno = $_SESSION["userno"];
		$message = "노출키워드 적용";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], "", "", $log_message);
	
		$FRAME = "ajax";		
		$_kno = explode("|", $_POST['kno']);
		$seq = sizeof($_kno);
		if($seq < 1) {
			$jsonArr['result'] = "not";
			break;
		}
		$res = array();
		for($i=0; $i<$seq; $i++) {
			$arr = array();
			$arr[] = trim($_kno[$i]);
			$arr[] = $i+1;
			$DB->rConnect();
			$res[] = $DB->call("p_review_keyword_seq_upd", $arr);
		}
		$arr = array();
		$arr[] = $seq+1;
		$DB->rConnect();
		$res[] = $DB->call("p_review_keyword_seq_del", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	
	case "review.keyword.register.proc" :
	
		$adminno = $_SESSION["userno"];
		$message = "키워드 입력처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['keyword'], "", "", $log_message);

		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['keyword'];
		$res = array();
		$res[] = $DB->call("p_review_keyword_ins", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.keyword.delete.proc" :

		$adminno = $_SESSION["userno"];
		$message = "키워드 삭제처리";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], "", "", $log_message);

		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['kno'];
		$res = array();
		$res[] = $DB->call("p_review_keyword_del", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.keyword.link.proc" :

		$adminno = $_SESSION["userno"];
		$message = "키워드리뷰링크정보";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], $keyword['keyword'], "", $log_message);

		$FRAME = "ajax";
		$list = $CLASS_REVIEWKEYWORD->getKeywordLinkList($DB, $_POST['kno'], "LIMIT 10");
		$keyword = $CLASS_REVIEWKEYWORD->getKeyword($DB, $_POST['kno']);
		$jsonArr['keyword'] = $keyword['keyword'];
		$jsonArr['kno'] = $_POST['kno'];		
		if(sizeof($list) > 0) {						
			$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);
			for($i=0; $i<sizeof($list); $i++) {				
				$image = $CLASS_REVIEWKEYWORD->getKeywordImage($_POST['kno'], $list[$i]['rno'].".jpg");
				$list[$i]['image'] = $image;
			}
			$jsonArr['list'] = $list;			
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.keyword.link.register.proc" :

		$adminno = $_SESSION["userno"];
		$message = "키워드링크입력";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], $_POST['rno'], "", $log_message);

		$FRAME = "ajax";

		if($CLASS_REVIEW->isReviewByRno($DB, $_POST['rno']) == false) {
			$jsonArr['result'] = "not";
			break;
		}
		if($CLASS_REVIEWKEYWORD->isKeywordLink($DB, $_POST['kno'], $_POST['rno']) == true) {
			$jsonArr['result'] = "repeat";
			break;
		}
		$arr = array();
		$arr[] = $_POST['kno'];
		$arr[] = $_POST['rno'];
		$res = array();
		$res[] = $DB->call("p_review_keyword_link_ins", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
			$jsonArr['review'] = $CLASS_REVIEW->getReview($DB, $_POST['rno']);
			$jsonArr['kno'] = $_POST['kno'];
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.keyword.link.delete.proc" :

		$adminno = $_SESSION["userno"];
		$message = "키워드링크삭제";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], $_POST['rno'], "", $log_message);

		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['kno'];
		$arr[] = $_POST['rno'];
		$res = array();
		$res[] = $DB->call("p_review_keyword_link_del", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
			$jsonArr['kno'] = $_POST['kno'];
			$jsonArr['rno'] = $_POST['rno'];
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.keyword.image.upload.proc" :

		$adminno = $_SESSION["userno"];
		$message = "키워드이미지업로드";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "5001", $_POST['kno'], "", "", $log_message);

		if($_FILES['file1']['error'] == "0") {
			
			$dir = _FTP_KEYWORDIMAGE."/".ceil($_POST['kno']/1000);			
			$file1 = $_POST['rno'].".jpg";			
	
			if($CLASS_FILE->upload($_FILES['file1'], $file1, _DIR_TMP) == true) {			
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir);
				$CLASS_FTP->upload($dir."/".$file1, _DIR_TMP."/".$file1);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file1);
			} 
		}
		Module::callScript("parent.mngreview.getKeywordLink(".$_POST['kno'].");");
		exit;
		break;
	
	case "review.keyword.link.search.proc" :
		$FRAME = "ajax";
		$list = $CLASS_REVIEW->getManagerReviewList($DB, "LIMIT 20", "title", $_POST['title']);
		if(sizeof($list) > 0) {
			$list = $CLASS_REVIEW->getReviewDataBind($DB, $list);
			$jsonArr['list'] = $list;
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.best.list.proc" :
		$FRAME = "ajax";
		$bestlist = $CLASS_REVIEWBEST->getBestList($DB, $_POST['wno']);
		if(sizeof($bestlist) > 0) {
			for($i=0; $i<sizeof($bestlist); $i++) {
				$rlist = $CLASS_REVIEWBEST->getBestCandRecomList($DB, $_POST['wno'], $bestlist[$i]['rno']);
				for($j=0; $j<sizeof($rlist); $j++) {
					$bestlist[$i]['user'][$j] = $CLASS_USER->getUser($DB, $rlist[$j]['userno']);
				}
			}
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $bestlist;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	case "review.best.paycash.proc" :

		$adminno = $_SESSION["userno"];
		$message = "베스트리뷰 추천회원 캐시지급";
		$log_message = $message;
		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "1001", $_POST['userno'], "303", "", $log_message);


		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = "0"; 
		$arr[] = "303"; 
		$arr[] = ""; 
		$arr[] = "";
		$res = array();
		$res[] = $DB->call("p_cash_ins", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	

	case "review.best.candlist.proc" :
		$FRAME = "ajax";		
		$cate = array("10", "11", "12", "13", "14");
		$candlist = $CLASS_REVIEWBEST->getBestCandList($DB, $_POST['wno'], $cate, 1000);		
		if(sizeof($candlist) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $candlist;
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	

	case "review.best.votelist.proc" :
		$FRAME = "ajax";		
		$cate = array("10", "11", "12", "13", "14");
		$votelist = $CLASS_REVIEWBEST->getBestVoteList($DB, $_POST['wno'], $cate);	
		if(sizeof($votelist) > 0) {
			$jsonArr['result'] = "success";
			$jsonArr['list'] = $votelist;
		} else {
			$jsonArr['result'] = "fail";
		}		
		break;
	

	case "review.choose.proc" :
		$FRAME = "ajax";		
		if(empty($_POST['wno']) || empty($_POST['rno']) || empty($_POST['userno'])) {
			$jsonArr['result'] = "info";
			break;
		}		
		if($CLASS_REVIEWBEST->isBestCandReview($DB, $_POST['wno'], $_POST['rno']) == true) {
			$arr = array();		
			$arr[] = $_POST['rno'];	
			$res = array();
			$res[] = $DB->call("p_review_best_cand_del", $arr);
			$jsonArr['type'] = "delete";
			if(Module::result($res, 'err', '-1') == false) {
				$jsonArr['result'] = "fail";
			} else {
				$jsonArr['result'] = "success";
				$jsonArr['wno'] = $_POST['wno'];
				$jsonArr['rno'] = $_POST['rno'];				
			}
		} else {
			if($CLASS_REVIEWBEST->isBestCandUser($DB, $_POST['wno'], $_POST['userno']) == true) {
				$jsonArr['result'] = "repeat";
				break;
			} 
			$arr = array();
			$arr[] = $_POST['wno'];
			$arr[] = $_POST['rno'];	
			$res = array();
			$res[] = $DB->call("p_review_best_cand_ins", $arr);
			$jsonArr['type'] = "insert";
			if(Module::result($res, 'err', '-1') == false) {
				$jsonArr['result'] = "fail";
			} else {
				$jsonArr['result'] = "success";
				$jsonArr['wno'] = $_POST['wno'];
				$jsonArr['rno'] = $_POST['rno'];
			}
		}
		break;
		
	case "frontier.cpfile.proc" :
	
		$adminno = $_SESSION["userno"];
		$message = "제휴사 파일 등록";
		$log_message = $message;
		
		if($_SESSION["userno"] <= 0) {
			Module::alert("잘못된 방법으로 접근하셨습니다. 관리자에게 문의하세요");
			break;
		}

		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $_POST['subject'], "", "", $log_message);


		$subject = $_POST["subject"]; 

		$dir1 = _FTP_CP;				
		$rel_file = $CLASS_FILE->getExtname($_FILES['file4']['name']);
		if ($rel_file != ""){
			$CLASS_FTP->connect("file");	
			$file4 = date("Ymdhis").".".strtolower($CLASS_FILE->getExtname($_FILES['file4']['name'])); 
			$CLASS_FILE->upload($_FILES['file4'], $file4, _DIR_TMP); 
			$CLASS_FTP->upload($dir1."/".$file4, _DIR_TMP."/".$file4); 
			$CLASS_FILE->delete(_DIR_TMP."/".$file2);		
			$CLASS_FTP->close(); 
		}			

		$res = $CLASS_MANAGER->AfileInsert($DB, $subject, $file4);
		
		if($res == true) {
		    Module::alert("파일이 등록되었습니다.");
			Module::redirect("/manager/cp.file");
		} else {
		    Module::alert("오류");
			Module::redirectModule("/manager/cp.file");
		}
	break;


	case "manager.cpfiledel.proc" :

		$adminno = $_SESSION["userno"];
		$message = "제휴사 파일 삭제";
		$log_message = $message;
		
		if($_SESSION["userno"] <= 0) {
			Module::alert("잘못된 방법으로 접근하셨습니다. 관리자에게 문의하세요");
			break;
		}

		$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $_POST['subject'], "", "", $log_message);

		$file = Module::$param[3];
		$no = Module::$param[4];
		$filename = $CLASS_MANAGER->AfileSelect($DB, $no);	

		for($z=0;$z<sizeof($filename);$z++) {
				$filename = $filename[$z]['file'];
		}
		$dir1 =_FTP_CP;			
		$CLASS_FTP->connect("file");
		$CLASS_FTP->delete($dir1."/".$filename);
		$CLASS_FTP->close();

		$res = $CLASS_MANAGER->AfileDelete($DB, $no);
		
		if($res == true) {
		    Module::alert("파일이 삭제되었습니다.");
			Module::redirect("/manager/cp.file");
		} else {
		    Module::alert("오류");
			Module::redirectModule("/manager/cp.file");
		}
		break;




	case "frontier.frontierdel.proc" :
	
		//phpinfo();exit;
		$frno = Module::$param[0];

		//echo "frno:$frno<br>";exit;

		
		$adminno = $_SESSION["userno"];
		$message = "프론티어 삭제처리";
		$log_message = $message;

		if($_SESSION["userno"] > 0) { 

			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->adminfrontierdel($DB, $frno);
		
			if($result == true) {
				Module::alert("프론티어가 삭제처리 되었습니다.");
			} else {
				Module::alert("오류");
			}
		}else{
			Module::alert("잘못된 방법으로 접근하셨습니다. 관리자에게 문의하세요");
		}
		
		Module::redirectModule("/mng.revu.co.kr/manager/frontier.list");
	break;


	case "frontier.modify1.proc" :
	
		//phpinfo();exit;
		$flag = Module::$param[0];

		//echo "flag:$flag<br>";exit;

		if($flag == "CA"){
			$frno		= $_POST["frno"];
			$cate1	= $_POST["cate1"];
			$cate2	= $_POST["cate2"];
			$cate3	= $_POST["cate3"];
			$cate4	= $_POST["cate4"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 카테고리 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_cate($DB, $frno, $cate1, $cate2, $cate3, $cate4);

			if($result == true) {
				Module::alert("프론티어 카테고리가 수정되었습니다.");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		
		if($flag == "TY"){

			$frno		= Module::$param[1];
			$etype	= $_POST["etype"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 타입 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $etype, $frno, $flag);
		
			if($result == true) {
				$flag = "";
				Module::alert("타입이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "CT"){
			$frno		= Module::$param[1];
			$ctype	= $_POST["ctype"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 출처 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $ctype, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("출처가 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "ST"){
			$frno		= Module::$param[1];
			$type	= $_POST["thumbtype"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 리스트 타입 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $type, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("리스트 프로모션이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "SJ"){
			$frno			= Module::$param[1];
			$element	= $_POST["subject"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 제목 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("제목이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "JD"){

			$frno = $_POST["frno"];
			$sdate1 = $_POST["sdate1"];
			$sdate2 = $_POST["sdate2"]; 
			$sdate3 = $_POST["sdate3"];
			$sdate4 = $_POST["sdate4"];
			$edate1 = $_POST["edate1"];
			$edate2 = $_POST["edate2"];
			$edate3 = $_POST["edate3"];
			$edate4 = $_POST["edate4"];



			$sdate = $sdate1."-".$sdate2."-".$sdate3." ".$sdate4; 
			$edate = $edate1."-".$edate2."-".$edate3." ".$edate4; 
			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 모집기간 수정";
			$log_message = $message;
			if($adminno <= 0) {
				Module::redirect("/manager/");
				break;
			}
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_frontierjdate($DB, $frno, $sdate, $edate, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("모집기간이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

	
		if($flag == "PL"){
			$frno			= Module::$param[1];
			$element	= $_POST["mcount"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 모집인원 수정";
			$log_message = $message;
			if($adminno <= 0) {
				Module::redirect("/manager/");
				break;
			}
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("모집인원이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "BC"){
			$frno			= Module::$param[1];
			$element	= $_POST["bestrviewer_count"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 베스트리뷰어 인원 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("베스트 리뷰어 인원이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}



		if($flag == "ND"){

			$frno = $_POST["frno"];
			$ndate1							= $_POST["ndate1"]; 
			$ndate2							= $_POST["ndate2"]; 
			$ndate3							= $_POST["ndate3"]; 
			$notice_date = $ndate1."-".$ndate2."-".$ndate3;  
			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 발표일 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $notice_date, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("발표일이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "BD"){

			$frno = $_POST["frno"];
			$ndate1							= $_POST["ndate1"]; 
			$ndate2							= $_POST["ndate2"]; 
			$ndate3							= $_POST["ndate3"]; 
			$notice_date = $ndate1."-".$ndate2."-".$ndate3;  
			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 베스트리뷰어 발표일 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $notice_date, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("베스트 리뷰어 발표일이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}



		if($flag == "RD"){

			$frno = $_POST["frno"];
			$review_sdate1				= $_POST["review_sdate1"]; 
			$review_sdate2				= $_POST["review_sdate2"]; 
			$review_sdate3				= $_POST["review_sdate3"]; 
			$review_edate1				= $_POST["review_edate1"]; 
			$review_edate2				= $_POST["review_edate2"]; 
			$review_edate3				= $_POST["review_edate3"]; 

			$review_sdate = $review_sdate1."-".$review_sdate2."-".$review_sdate3; 
			$review_edate = $review_edate1."-".$review_edate2."-".$review_edate3; 
			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 모집기간 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_frontierjdate($DB, $frno, $review_sdate, $review_edate, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("모집기간이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "PD"){
			$frno			= Module::$param[1];
			$element	= $_POST["rproduct"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 상품 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("체험상품이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "PE"){
			$frno			= Module::$param[1];
			$element	= $_POST["rprice"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 소비자가격 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("소비자가격이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "AD"){

			$frno		= $_POST["frno"];
			$area_bcode1				= $_POST["area_bcode1"]; 
			$area_mcode1				= $_POST["area_mcode1"]; 
			$area_scode1				= $_POST["area_scode1"]; 
			$addr							= $_POST["addr2"]; 

			$addr							= str_replace("'","\'",$addr);
			$areacode						= $area_bcode1.$area_mcode1.$area_scode1; 

			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 주소 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			

			
			$result		= $CLASS_MANAGER->Modify_addr($DB, $frno, $addr, $areacode);

			if($result == true) {
			
		    Module::alert("프론티어 주소가 변경되었습니다.");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		
		if($flag == "MP"){
			$frno			= Module::$param[1];
			$element	= $_POST["map"];

			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 약도 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			
			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("체험상품이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "OP"){

			$frno		= $_POST["frno"];
			$frid = $CLASS_MANAGER->Select_frid($DB, $frno);

			$adminno = $_SESSION["userno"];
			$message = "프론티어 옵션 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			$del_result		= $CLASS_MANAGER->Modify_optionreset($DB, $frno);

			if($del_result == true) {
				reset($_POST["option"]);
				while (list($option,$val) = each($_POST["option"])) {
					if($option != "0"){
						$optionArr = array();
						$opno = $frontier_No; 
						$opval = $val; 
						
						$result = $CLASS_MANAGER->Modify_optioninsert($DB, $frid, $opno, $opval, $frno);
						
					}

				}
			}
			

			if($result == true) {
			    Module::alert("프론티어 옵션정보가 변경되었습니다.");

			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}


		if($flag == "WE"){
			$frno			= Module::$param[1];
			$element	= $_POST["homepage"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 홈페이지 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("홈페이지 주소가 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}



		if($flag == "TL"){

			$frno		= $_POST["frno"];
			$tel1								= $_POST["tel1"]; 
			$tel2								= $_POST["tel2"];
			$tel3								= $_POST["tel3"];
			$mobile1						= $_POST["mobile1"];
			$mobile2						= $_POST["mobile2"];
			$mobile3						= $_POST["mobile3"];


			$tel = $tel1."-".$tel2."-".$tel3; 

			$mobile = $mobile1."-".$mobile2."-".$mobile3;  

			
			$adminno = $_SESSION["userno"];
			$message = "프론티어 전화번호 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);
			

			
			$result		= $CLASS_MANAGER->Modify_tel($DB, $frno, $tel, $mobile);

			if($result == true) {
				Module::alert("프론티어 전화번호가 변경되었습니다.");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}

		if($flag == "CP"){
			$frno			= Module::$param[1];
			$element	= $_POST["cashcon"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 캐시지급여부 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 캐시지급 항목이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}
		



		if($flag == "ME"){
			$frno			= Module::$param[1];
			$element	= $_POST["bigo"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 비고 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 비고 내용이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}
		
		if($flag == "MS"){
			$frno			= Module::$param[1];
			$element	= $_POST["bestrview_prise"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 베스트 리뷰어 혜택 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 베스트 리뷰어 혜택이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		

		if($flag == "SS"){
			$frno			= Module::$param[1];
			$element	= $_POST["mission"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 리뷰미션 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 리뷰미션 내용이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		


		if($flag == "KW"){
			$frno			= Module::$param[1];
			$element	= $_POST["titlekeyword"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 제목 삽입 키워드 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 제목 삽입 키워드가 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		


		if($flag == "TW"){
			$frno			= Module::$param[1];
			$element	= $_POST["storykeyword"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 본문 삽입 키워드 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 본문 삽입 키워드가 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		


		if($flag == "TP"){
			$frno			= Module::$param[1];
			$element	= $_POST["tip"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 당첨TIP 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontier($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 당첨TIP이 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		

		if($flag == "BN"){
			$frno			= Module::$param[1];

			//phpinfo();exit;
			$element	= $_POST["bannercode"];

			$adminno = $_SESSION["userno"];
			$message = "프론티어 배너코드 수정";
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);

			$result		= $CLASS_MANAGER->Modify_setfrontierorinfo($DB, $element, $frno, $flag);
			if($result == true) {
				$flag = "";
				Module::alert("프론티어 배너코드가 수정되었습니다.");
				Module::redirect("/manager/detailview.adminpopup.editer//$frno//");
			} else {
				Module::alert("수정시 오류가 발생했습니다_레뷰개발 문의");
			}
			break;
		}		


		if($flag == "IM1"){
			$frno			= Module::$param[1];
			
			$frid = $CLASS_MANAGER->AdminfridSelect($DB, $frno);

			$dirname				= substr($frid,2,4);
			//phpinfo();exit;
			$element	= $_POST["file1"];
			$adminno = $_SESSION["userno"];
			$message = "프론티어 상단 이미지 수정 수정";
			$dir1 = _FTP_FRONTIERIMAGE."/"."title_img"."/".$dirname;			

			$file1 = $frno.".gif"; 
			$title_img = $file1;
			
			//echo "dir1:$dir1<br>";
			//phpinfo();exit;
			$CLASS_FTP->connect("file"); 
			$CLASS_FTP->delete($dir1."/".$file1);

			$CLASS_FILE->upload($_FILES['file1'], $file1, _DIR_TMP); 
//			$CLASS_FTP->connect("file");
			$CLASS_FTP->makeDir($dir1); 
			$CLASS_FTP->upload($dir1."/".$file1, _DIR_TMP."/".$file1); 
//			$CLASS_FTP->close();


			
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);



			Module::alert("프론티어 상단이미지가 수정되었습니다.");
			Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			
			break;
		}		



		if($flag == "IM2"){
			$frno			= Module::$param[1];
			
			$frid = $CLASS_MANAGER->AdminfridSelect($DB, $frno);

			$dirname				= substr($frid,2,4);
			//phpinfo();exit;
			$element	= $_POST["file2"];
			$adminno = $_SESSION["userno"];
			$message = "프론티어 리스트 이미지 수정 수정";
			
			$dir2 = _FTP_FRONTIERIMAGE."/"."list_img"."/".$dirname;			
			$dir5 = _FTP_FRONTIERIMAGE."/"."list_simg"."/".$dirname;				
			$dir6 = _FTP_FRONTIERIMAGE."/"."list_mimg"."/".$dirname;				

			$file2 = $frno.".gif"; 
			

			//phpinfo();exit;
			$CLASS_FTP->connect("file"); 
			$CLASS_FTP->delete($dir2."/".$file2);
			$CLASS_FTP->delete($dir5."/".$file2);
			$CLASS_FTP->delete($dir6."/".$file2);

			if($CLASS_THUMBNAIL->create($_FILES['file2']['tmp_name'], _DIR_TMP."/".$file2, 224, 224) == true) {
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir2);
				$CLASS_FTP->upload($dir2."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir2."/".$_POST['thumbname']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
			}
			
			if($CLASS_THUMBNAIL->create($_FILES['file2']['tmp_name'], _DIR_TMP."/".$file2, 66, 66) == true) {
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir5);
				$CLASS_FTP->upload($dir5."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir5."/".$_POST['thumbname']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
			}

			
			if($CLASS_THUMBNAIL->create($_FILES['file2']['tmp_name'], _DIR_TMP."/".$file2, 110, 110) == true) {
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir6);
				$CLASS_FTP->upload($dir6."/".$file2, _DIR_TMP."/".$file2);
				$CLASS_FTP->delete($dir6."/".$_POST['thumbname']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file2);
			}
			
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);



			Module::alert("프론티어 리스트 이미지가 수정되었습니다.");
			Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			
			break;
		}		




		if($flag == "IM3"){
			$frno			= Module::$param[1];
			
			$frid = $CLASS_MANAGER->AdminfridSelect($DB, $frno);

			$dirname				= substr($frid,2,4);
			//phpinfo();exit;
			$element	= $_POST["file3"];
			$adminno = $_SESSION["userno"];
			$message = "프론티어 배너 이미지 수정 수정";
			
			$dir3 = _FTP_FRONTIERIMAGE."/"."banner_img"."/".$dirname;		

			$file3 = $frno.".gif"; 
			

			//phpinfo();exit;
			$CLASS_FTP->connect("file"); 
			$CLASS_FTP->delete($dir3."/".$file3);

			if($CLASS_THUMBNAIL->create($_FILES['file3']['tmp_name'], _DIR_TMP."/".$file3, 225, 90) == true) {
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir3);
				$CLASS_FTP->upload($dir3."/".$file3, _DIR_TMP."/".$file3);
				$CLASS_FTP->delete($dir3."/".$_POST['thumbname']);
				$CLASS_FTP->close();
				$CLASS_FILE->delete(_DIR_TMP."/".$file3);
			}
			
			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);



			Module::alert("프론티어 배너 이미지가 수정되었습니다.");
			Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			
			break;
		}		






		if($flag == "IM4"){
			$frno			= Module::$param[1];
			
			$frid			= $CLASS_MANAGER->AdminfridSelect($DB, $frno);
			$filename	= $CLASS_MANAGER->AdminfileSelect($DB, $frno);

			$dirname				= substr($frid,2,4);
			//phpinfo();exit;
			$element	= $_POST["file1"];
			$adminno = $_SESSION["userno"];
			$message = "프론티어 관련 파일 수정";
			
			$dir4 = _FTP_FRONTIERIMAGE."/"."rel_file"."/".$dirname;				

			if($filename == ""){

				$CLASS_FTP->connect("file"); 
				$CLASS_FTP->delete($dir4."/".$filename);
			}

			$rel_file = $CLASS_FILE->getExtname($_FILES['file4']['name']);

			
			if ($rel_file != ""){

				$file4 = $frno.".".strtolower($CLASS_FILE->getExtname($_FILES['file4']['name'])); 
				$CLASS_FILE->upload($_FILES['file4'], $file4, _DIR_TMP); 
				$CLASS_FTP->connect("file");
				$CLASS_FTP->makeDir($dir4); 
				$CLASS_FTP->upload($dir4."/".$file4, _DIR_TMP."/".$file4); 
				$CLASS_FTP->close(); 
				$CLASS_FILE->delete(_DIR_TMP."/".$file4);

			}	


			$log_message = $message;
			$admin_log = $CLASS_MANAGER->adminlog($DB, $adminno, "0000", $frno, "", "", $log_message);



			Module::alert("프론티어 관련 파일이 신규로 등록되었습니다.");
			Module::redirect("/manager/detailview.adminpopup.editer//$frno//");

			
			break;
		}	






		//
		break;
		//	






	default :
		Module::alert("잘못된 경로입니다.");
		break;
}

if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}

Module::exitModule();
?>