<?php
/***************************************************************************************
* Module Name			:	관리자 페이지 로그인
* Created Date			:	2011.07.01
* Created by				:	RevU팀 박상선 
* Modify History			:
****************************************************************************************/

//===============================================================
//GLOBAL CLASS
//===============================================================
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $AUTH;
GLOBAL $LOGIN;

//===============================================================
//GLOBAL VARS
//===============================================================
GLOBAL $SITE;
GLOBAL $FRAME;

//===============================================================
//CLASS
//===============================================================
$CLASS_AUTH				= &Module::singleton("auth.admin");  //모듈(경로).클래스명
$CLASS_LOGIN				= &Module::singleton("auth.login");  //모듈(경로).클래스명
$CLASS_FRONTIER			= &Module::singleton("frontier.frontier");  //모듈(경로).클래스명
$CLASS_FTP					= &Module::singleton("Ftp");
$CLASS_FILE					= &Module::singleton("File");
$CLASS_THUMBNAIL		= &Module::singleton("Thumbnail");
//$CLASS_MAILLET = &Module::singleton("mail.mailcla");  //모듈(경로).클래스명
$CLASS_REVIEW			= &Module::singleton("Review.Review");
$CLASS_REVIEWBEST			= &Module::singleton("Review.ReviewBest");
$CLASS_MANAGER		= &Module::singleton("manager.manager");
$CLASS_BASIC				= &Module::singleton("Mail.Mailcla");
$CLASS_USER				= &Module::singleton("User.User");

//===============================================================
//EXTEND_CLASS
//===============================================================
//$EXTEND_JSON = &Module::singletonExtends("Services_JSON");

//===============================================================
//DB OBJECT
//===============================================================
$DB = &Module::loadDb("revu");

//===============================================================
//VARS
//===============================================================
//$_todo = &Module::getModuleInfo($_REQUEST['_module'], $type="todo");
$jsonArr = array();

//===============================================================
//TODO
//===============================================================
switch(Module::$todo)
{
	/**
	 * 관리자 로그인
	 */
	case "login.proc" :		
		
		break;
	/**
	 * 관리자 로그아웃
	 */
	case "logout.proc" :
		$_POST['referer'] = ($_POST['referer'] != "") ? $_POST['referer'] : $_SERVER['HTTP_REFERER'];
		$_POST['login_type'] = $_SESSION['type']."O";
		$CLASS_LOGIN->insertLoginLog($DB_LOG, $_SESSION, $_POST);
		$CLASS_LOGIN->initSession();
		Module::redirect("/");
		break;



	//===============================================================
	// 메일전송처리
	//===============================================================	
	case "mail.sending.proc" :
		//print_r($_POST);exit;
		//phpinfO();exit;
		$subject			= $_POST["subject"];
		$sendname		= $_POST["sendname"];
		$mtype				= $_POST["mtype"];
		$recipient			= $_POST["recipient"]; //수신자
		$mailgroup			= $_POST["mailgroup"];
		$frontier			= $_POST["frontiergroup"];
		$editor				= $_POST["editor"];
		$sending			= $_POST["sending"];
		$reserve_year	= $_POST["reserve_year"];
		$reserve_month	= $_POST["reserve_month"];
		$reserve_date	= $_POST["reserve_date"];
		$reserve_time		= $_POST["reserve_time"];
		$command		= $_POST["command"];

		//echo "sending:$sending";exit;
		//**********************************************************************************//	
		//	메일종류코드  N : 뉴스레터, E : 이벤트알림, W : 이벤트 당첨							//
		// 전송타입  E : 개별발송, A : 그룹발송, B : 프론티어 당첨 발송							//
		// 수신그룹 A : 전체, B : 남성회원, C : 여성회원,  D : 블랙리스트회원					//
		// 전송구분 : R : 예약발송, N : 즉시발송															//
		//*********************************************************************************//
		if($sending == "R"){ //예약발송
			$mailkind = "N"; //뉴스레터 코드 N 하드코딩
			
			$tomail = trim($recipient); //수신자 공백제거
			$marr=explode(';', $tomail); // . 를 구분자로하여 문자열을 분리, 배열로 리턴,,,
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
			
			//echo "reserve_result:$reserve_result";exit;
			$MailArr = array();		
			$MailArr[] = $mailkind;
			$MailArr[] = $subject;			
			$MailArr[] = $sendname;			
			$MailArr[] = $mtype;		
			
			//echo "tono:$tono";exit;
			if($tono < 2){ //예약 : 수신자가 한명일때 
				$MailArr[] = $recipient;						
			}else{ //예약 : 수신자가 한명 이상일때(여러년놈)
				$MailArr[] = $recipientimp;			
			}	
			$MailArr[] = $mailgroup;			
			$MailArr[] = $editor;			
			$MailArr[] = $reserve_year;			
			$MailArr[] = $reserve_month;			
			$MailArr[] = $reserve_date;			
			$MailArr[] = $reserve_time;			
			$MailArr[] = $reserve_result;
			$MailArr[] = "N"; //전송구분 전송전이니까 "N"로 하드코딩
			$MailArr[] = $frontier;

			$result = array();		
			//step1. 프론티어 기본 정보 인서트 처리
			$result[] = $DB->call("p_mail_reserve", $MailArr);


		}else{ //즉시발송

			//echo "mtype:$mtype";exit;
			$mailkind = "N"; //뉴스레터 코드 N 하드코딩

			switch($mtype)
			{
				case "E":
				//////////////////////////////////////////////
				//개별전송 
				//////////////////////////////////////////////
				$tomail = trim($recipient); //수신자 공백제거
				$marr=explode(';', $tomail); // . 를 구분자로하여 문자열을 분리, 배열로 리턴,,,
				$tono=sizeof($marr);
				$tonocheck = $tono-1;
				$recipientimp=implode('|' , $marr); 

				//echo "tono:$tono";exit;

				
				if($tonocheck == 1 || $tonocheck == 0){ //수신자가 한명일때 (찾기 : ^&^)
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
					//step1. 프론티어 기본 정보 인서트 처리
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
							alert('메일전송 성공');
						</script>
						";	   
					}
					Module::redirect("/manager/letter.step1");


				}else{ //수신자가 여러명일때  (찾기 : ^&^)
					
					
					
					 for ($i=0 ; $i<$tono ; $i++) {
						//$marr[$i];
						
						//echo "$marr[$i]<br>";
						
						$CLASS_EMAIL = &Module::singleton("Email");
						$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

						if($i == 0){ //처음 한번만 Ru_mailsend_history에 넣는다
							

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
							//step1. 프론티어 기본 정보 인서트 처리
							$result[] = $DB->call("p_mail_history", $MailArr);
					

						}
						$CLASS_EMAIL->to($marr[$i]); 
						$CLASS_EMAIL->subject($subject);
						$CLASS_EMAIL->message($editor);
						$result = $CLASS_EMAIL->send();			

					 }
					 //exit;

					 if($result != "1"){
						echo "
					   <script>
						alert('메일전송 실패');
					   </script>
						";
					}else{
						echo "
						<script>
							alert('메일전송 성공');
						</script>
						";	   
					}

					Module::redirect("/manager/letter.step1");

				}
				break;

				case "A":
				//////////////////////////////////////////////
				//그룹전송
				//////////////////////////////////////////////		
				//phpinfo();exit;	
				if($mailgroup == "A"){ //전체메일
					$mailgroup_selecting = $CLASS_BASIC->MailGroupSelect($DB, "A");
				}else if($mailgroup == "B"){  //남성회원
					$mailgroup_selecting = $CLASS_BASIC->MailGroupSelect($DB, "B");
				}else if($mailgroup == "C"){ //여성회원
					$mailgroup_selecting = $CLASS_BASIC->MailGroupSelect($DB, "C");
				}else{ //블랙리스트회원
					$mailgroup_selecting = $CLASS_BASIC->MailGroupSelect($DB, "D");
				}

				$CLASS_EMAIL = &Module::singleton("Email");
				$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);

				for($i=0;$i<sizeof($mailgroup_selecting);$i++) {
	

						if($i > 0){
							$DB->rConnect();
						}
						$email = $mailgroup_selecting[$i]['email'];
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
						//step1. 프론티어 기본 정보 인서트 처리
						$result[] = $DB->call("p_mail_history", $MailArr);
				
						$CLASS_EMAIL->to($email); 
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
						alert('메일전송 성공');
					</script>
					";	   
				}

				Module::redirect("/manager/letter.step1");

				break;

				case "B":
				//////////////////////////////////////////////
				//프론티어 당첨메일 전송
				//////////////////////////////////////////////
				

				//프론티어 당첨자 userno를 셀렉팅
				$user_list = $CLASS_BASIC->frontierGroupSelect($DB, $frontier);
				
								
				$CLASS_EMAIL = &Module::singleton("Email");
				$CLASS_EMAIL->from('no-reply@revu.co.kr', $sendname);


				for($i=0;$i<sizeof($user_list);$i++) {
					
					$userno = $user_list[$i]['userno'];
					$frontiergroup_selecting = $CLASS_BASIC->frontierWinSelect($DB, $userno); //당첨된 회원의 메일정보를 가져옴

						for($j=0;$j<sizeof($frontiergroup_selecting);$j++) {

							//echo "$j<br>";


							$email = $frontiergroup_selecting[$j]['email'];  //당첨된 회원의 이메일 정보
							

							if($email != ""){ //이메일이 없는 놈은 제외시킴

								if($j> 0){ //두번째부터 DB리컨넥션
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
								//step1. 프론티어 기본 정보 인서트 처리
								$result[] = $DB->call("p_mail_history", $MailArr);
						
								$CLASS_EMAIL->to($email); 
								$CLASS_EMAIL->subject($subject);
								$CLASS_EMAIL->message($editor);
								$result = $CLASS_EMAIL->send();		

							}

						}
					
				}

				break;

				default :
				Module::alert("메일전송오류.");
				//Module::redirectModule("index", $param="");
				break;

			}
			

		}



		
		break;


	// 프론티어 등록
	case "frontier.regist.proc" :
	//print_r($_POST);
	//phpinfo();exit;

		$etype							= $_POST["etype"]; //이벤트 타입
		$thumbtype					= $_POST["thumbtype"]; //리스트 큰썸네일 구분 프로모션 구분값
		$ctype							= $_POST["ctype"]; //출처
		$cate1							= $_POST["cate1"]; //1차 카테고리
		$cate2							= $_POST["cate2"]; //2차 카테고리
		$cate3							= $_POST["cate3"]; //3차 카테고리
		$cate4							= $_POST["cate4"]; //4차 카테고리

		$subject						= $_POST["subject"]; //제목

		$subject						= str_replace("'","\'",$subject);
		


		$sdate1							= $_POST["sdate1"]; //2011 
		$sdate2							= $_POST["sdate2"]; //1 
		$sdate3							= $_POST["sdate3"]; //1 
		$sdate4							= $_POST["sdate4"]; //1 
		$edate1							= $_POST["edate1"]; //2011 
		$edate2							= $_POST["edate2"]; //1 
		$edate3							= $_POST["edate3"]; //1 
		$edate4							= $_POST["edate4"]; //1 
		$mcount						= $_POST["mcount"]; //모집인원
		$ndate1							= $_POST["ndate1"]; //2011 
		$ndate2							= $_POST["ndate2"]; //1 
		$ndate3							= $_POST["ndate3"]; //1 
		$review_sdate1				= $_POST["review_sdate1"]; //2011 
		$review_sdate2				= $_POST["review_sdate2"]; //1 
		$review_sdate3				= $_POST["review_sdate3"]; //1 
		$review_edate1				= $_POST["review_edate1"]; //2011 
		$review_edate2				= $_POST["review_edate2"]; //1 
		$review_edate3				= $_POST["review_edate3"]; //1 
		$rproduct						= $_POST["rproduct"]; // 체험상품
		$rproduct						= str_replace("'","\'",$rproduct);

		$rprice							= $_POST["rprice"]; //상품가격 
		if($rprice	== "0"){
			$rprice = "";
		}
		$area_bcode1				= $_POST["area_bcode1"]; //지역코드1
		$area_mcode1				= $_POST["area_mcode1"]; //지역코드2 
		$area_scode1				= $_POST["area_scode1"]; //지역코드3 
		$addr							= $_POST["addr2"]; //상세주소 11 

		$addr							= str_replace("'","\'",$addr);

		$map							= $_POST["map"]; //맵지도 URL
		$tel1								= $_POST["tel1"]; // 02 
		$tel2								= $_POST["tel2"];// 22 
		$tel3								= $_POST["tel3"];// 2212 
		$mobile1						= $_POST["mobile1"];// 010 
		$mobile2						= $_POST["mobile2"];// 8549 
		$mobile3						= $_POST["mobile3"];// 9594 
		$homepage					= $_POST["homepage"];//관련 홈페이지
		$homepage							= str_replace("'","\'",$homepage);

		$cashcon						= $_POST["cashcon"]; // 캐시지급
		$bigo							= $_POST["bigo"]; // 비고 
		$bestreviewerday1			= $_POST["bestreviewerday1"];// 2011 
		$bestreviewerday2			= $_POST["bestreviewerday2"];// 1 
		$bestreviewerday3			= $_POST["bestreviewerday3"];// 1 
		$bestrevieweraword		= $_POST["bestrevieweraword"];// 베스트 리뷰어 혜택 
		//$editorContent				= $_POST["editorContent"];			// 리뷰미션 
		$editorContent				= $_POST["editor"];			// 리뷰미션 
		$editorContent				= str_replace("'","\'",$editorContent);


		$titlekeyword					= $_POST["titlekeyword"]; // 제목 삽입 키워드 
		$titlekeyword					= str_replace("'","\'",$titlekeyword);

		$storykeyword				= $_POST["storykeyword"]; // 본문 삽입 키워드 
		$storykeyword				= str_replace("'","\'",$storykeyword);

		$tip								= $_POST["tip"]; // 당첨TIP 
		$tip								= str_replace("'","\'",$tip);

		$topimage						= $_POST["topimage"]; // no value 
		$thumbimage					= $_POST["thumbimage"]; // no value 
		$bannerimage				= $_POST["bannerimage"]; // no value 
		$bannercode					= $_POST["bannercode"]; // <font color=red>배너코드</font> 
		$bestreviewer_count		= $_POST["bestreviewer_count"]; // <font color=red>배너코드</font> 

		$sdate = $sdate1."-".$sdate2."-".$sdate3." ".$sdate4; //시작일

		$edate = $edate1."-".$edate2."-".$edate3." ".$edate4; //종료일
		$review_sdate = $review_sdate1."-".$review_sdate2."-".$review_sdate3; //리뷰작성기간 시작
		$review_edate = $review_edate1."-".$review_edate2."-".$review_edate3; //리뷰작성기간 종료
		$notice_date = $ndate1."-".$ndate2."-".$ndate3;  //발표일
		$tel = $tel1.$tel2.$tel3; //전화번호
		$mobile = $mobile1.$mobile2.$mobile3; //휴대폰 번호
		$bestreviewer_day = $bestreviewerday1."-".$bestreviewerday2."-".$bestreviewerday3; //베스트 리뷰어 발표일

		if($cate3 == "")$cate3 = "000";
		if($cate2 == "")$cate2 = "000";
		$catecode = $cate1.$cate2.$cate3.$cate4; 

		//$res = $CLASS_FRONTIER->frontierinsert($DB, $etype, $ctype, $catecode, $subject, $sdate, $edate, $review_sdate, $review_edate, $notice_date, $tel, $mobile, $bestreviewer_day, $mcount, $rproduct, $rprice, $area_bcode1, $area_mcode1, $area_scode1, $addr, $map, $homepage, $cashcon, $bigo, $bestrevieweraword, $editorContent, $editorContent2, $titlekeyword, $storykeyword, $tip, $topimage, $bannerimage, $thumbimage, $bannercode);


		$frontier_id = "F_".date('YmdHis');

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
		//step1. 프론티어 기본 정보 인서트 처리
		$res[] = $DB->call("p_frontier_ins", $ftbArr);

		if($res[0]['orcode'] == '1') {  //성공일때
			
			//배열 입력 변수 셋팅
			$frontier_No = $res[0]['frno']; // 프로시저에서 리턴받은 입력값(auto  순번값)

			//phpinfo();exit;
			$dirname = date("Y");

			#########################################################
			#########################################################
			$dir1 = _FTP_FRONTIERIMAGE."/"."title_img"."/".$dirname;			//파일서버 이미지 경로(타이틀 이미지)
			$dir2 = _FTP_FRONTIERIMAGE."/"."list_img"."/".$dirname;			//파일서버 이미지 경로(리스트 썸네일 이미지)
			$dir3 = _FTP_FRONTIERIMAGE."/"."banner_img"."/".$dirname;		//파일서버 이미지 경로(배너 이미지)
			$dir4 = _FTP_FRONTIERIMAGE."/"."rel_file"."/".$dirname;				//파일서버 관련 파일 경로(포스팅용 관련 자료파일)
			#########################################################
			#########################################################
			
			//타이틀 이미지 처리
			//$file1 = $res[0]['frno'].".".strtolower($CLASS_FILE->getExtname($_FILES['file1']['name'])); //파일 리네임


			//본문 이미지처리
			$file1 = $res[0]['frno'].".gif"; //파일 리네임
			$title_img = $file1;
		
			$CLASS_FILE->upload($_FILES['file1'], $file1, _DIR_TMP); //웹서버에 업로드 처리
			$CLASS_FTP->connect("file"); //웹서버에서 파일서버 ftp connect
			$CLASS_FTP->makeDir($dir1); // 파일서버에 해당 디렉토리 생성
			$CLASS_FTP->upload($dir1."/".$file1, _DIR_TMP."/".$file1); //웹서버에서 파일서버로 업로드 처리


			if($CLASS_FILE->isRunByMime($_FILES['file2']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			//리스트용 이미지처리
			// 디렉토리생성
			if($_FILES['file2']['error'] == "0") {
				$tmp = $_FILES['file2']['tmp_name'];
				$mime = $_FILES['file2']['type'];
				$size = $_FILES['file2']['size'];			
				$file1 = $_FILES['file2']['name'];
				$file2 =  $res[0]['frno'].".gif";
				// 썸네일 생성
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 224, 224) == true) {
					// 업로드
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir2);
					$CLASS_FTP->upload($dir2."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir2."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					// 업로드 후 썸네일 이미지 삭제
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}

			/*
			$title_img = $file1;
			$file2 = $res[0]['frno'].".jpg"; //파일 리네임

			$CLASS_FILE->upload($_FILES['file2'], $file2, _DIR_TMP); //웹서버에 업로드 처리
			$CLASS_FTP->makeDir($dir2); // 파일서버에 해당 디렉토리 생성
			$CLASS_FTP->upload($dir2."/".$file2, _DIR_TMP."/".$file2); //웹서버에서 파일서버로 업로드 처리
			*/



			if($CLASS_FILE->isRunByMime($_FILES['file3']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			//배너 이미지처리
			// 디렉토리생성
			if($_FILES['file3']['error'] == "0") {
				$tmp = $_FILES['file3']['tmp_name'];
				$mime = $_FILES['file3']['type'];
				$size = $_FILES['file3']['size'];			
				$file1 = $_FILES['file3']['name'];
				$file2 =  $res[0]['frno'].".gif";
				// 썸네일 생성
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 225, 90) == true) {
					// 업로드
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir3);
					$CLASS_FTP->upload($dir3."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir3."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					// 업로드 후 썸네일 이미지 삭제
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}

	
			/*
			//배너 이미지 처리
			$file3 = $res[0]['frno'].".jpg"; //파일 리네임

			$CLASS_FILE->upload($_FILES['file3'], $file3, _DIR_TMP); //웹서버에 업로드 처리
			$CLASS_FTP->makeDir($dir3); // 파일서버에 해당 디렉토리 생성
			$CLASS_FTP->upload($dir3."/".$file3, _DIR_TMP."/".$file3); //웹서버에서 파일서버로 업로드 처리
			*/



			
			// 관련 파일이 없을때 처리
			$rel_file = $CLASS_FILE->getExtname($_FILES['file4']['name']);
			if ($rel_file != ""){

			
				//프론티어 자료처리
				$file4 = $res[0]['frno'].".".strtolower($CLASS_FILE->getExtname($_FILES['file4']['name'])); //파일 리네임
				$CLASS_FILE->upload($_FILES['file4'], $file4, _DIR_TMP); //웹서버에 업로드 처리
				$CLASS_FTP->makeDir($dir4); // 파일서버에 해당 디렉토리 생성
				$CLASS_FTP->upload($dir4."/".$file4, _DIR_TMP."/".$file4); //웹서버에서 파일서버로 업로드 처리						
				
				$CLASS_FTP->close(); //스토리지 서버  ftp 디스컨넥팅
			}			
			
			//phpinfo();exit;

			/*
			echo "frontier_No:$frontier_No<br>";
			echo "frontier_id:$frontier_id<br>";
			echo "rproduct:$rproduct<br>";
			echo "area_bcode1:$area_bcode1$area_mcode1$area_scode1<br>";
			echo "addr:$addr<br>";
			echo "rprice:$rprice<br>";

			echo "bigo:$bigo<br>";
			echo "file1:$file1<br>";
			echo "map:$map<br>";
			echo "homepage:$homepage<br>";
			echo "cashcon:$cashcon<br>";
			echo "tel1:$tel1$tel2$tel3<br>";
			echo "mobile1:$mobile1$mobile2$mobile3<br>";
			exit;
			*/		


			//step2. 프론티어 옵션 정보 인서트 처리
			$ftoArr = array();
			$ftoArr[] = $frontier_No; //리턴받은 기본정보 순번값
			$ftoArr[] = $frontier_id; // 프론티어 아이디
			$ftoArr[] = $rproduct; 
			$ftoArr[] = $area_bcode1.$area_mcode1.$area_scode1; 
			$ftoArr[] = $addr; 
			$ftoArr[] = $rprice; 
			$ftoArr[] = $bigo; 
			$ftoArr[] = $title_img; 
			$ftoArr[] = $map; 
			$ftoArr[] = $homepage; 
			$ftoArr[] = $cashcon; 
			$ftoArr[] = $tel1."-".$tel2."-".$tel3; 
			$ftoArr[] = $mobile1."-".$mobile2."-".$mobile3; 
			$ftoArr[] = $file4;

			$DB->rConnect();

			$res2 = array();		


			$res2[] = $DB->call("p_frontierorter_ins", $ftoArr);


			//$option = each($_POST["option"]);

			reset($_POST["option"]);
			while (list($option,$val) = each($_POST["option"])) {
				//echo "$option$val<br>";

				if($option != "0"){
					$optionArr = array();
					$optionArr[] = $frontier_No; //리턴받은 기본정보 순번값
					$optionArr[] = $frontier_id; // 프론티어 아이디
					$optionArr[] = $val; 

					$DB->rConnect();

					$res3 = array();		


					$res3[] = $DB->call("p_frontieroption_ins", $optionArr);

					if($res3[0]['orcode'] == '1') {  //성공일때
						
						//echo "옵션정보 입력 성공<br>";
					}else{
						echo "옵션정보 입력 실패<br>";
					}
				}

			}
			//exit;
	
			/*
			if($res2[0]['orcode'] == '1') {  //성공일때
				
				echo "기타정보 입력 성공";exit;
			}else{
				echo "기타정보 입력 실패";exit;
			}*/

			//step3. 프론티어 기타 정보 인서트 처리

		}else{	 // 실패
			echo "오류";
		}
		
		Module::redirect("/manager/frontier.list");
		//Module::redirect("/manager/regist.banner");

		break;

	
	// 배너등록
	case "frontier.registbanner.proc" :
	//print_r($_POST);
	//phpinfo();exit;
		$bannertype = $_POST["btype"]; //배너 타입  M메인배너, L우측배너 
		$linktype		= $_POST["link"]; //링크타입 T새창  P 현재창 
		$campaign		= $_POST["subject"]; // 캠페인명 
		$campaign		= str_replace("'","\'",$campaign);

		$spon			= $_POST["spon"]; // 광고주명 
		$spon			= str_replace("'","\'",$spon);

		$linurl			= $_POST["homepage"]; //링크주고 http://www.revu.co.kr 



		#########################################################
		#########################################################
		$dir1 = _FTP_BANNERIMAGE;			//파일서버 배너 이미지 경로(타이틀 이미지)
		#########################################################
		#########################################################
		
		//타이틀 이미지 처리
		//$file1 = $res[0]['frno'].".".strtolower($CLASS_FILE->getExtname($_FILES['file1']['name'])); //파일 리네임
		$filename = date("Ymdhis").".gif"; //파일 리네임

		//$CLASS_FILE->upload($_FILES['file1'], $file1, _DIR_TMP); //웹서버에 업로드 처리
		//$CLASS_FTP->connect("file"); //웹서버에서 파일서버 ftp connect
		//$CLASS_FTP->makeDir($dir1); // 파일서버에 해당 디렉토리 생성
		//$CLASS_FTP->upload($dir1."/".$file1, _DIR_TMP."/".$file1); //웹서버에서 파일서버로 업로드 처리


		if($bannertype == "M"){

			if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			//메인 배너 이미지처리
			// 디렉토리생성
			if($_FILES['file1']['error'] == "0") {
				$tmp = $_FILES['file1']['tmp_name'];
				$mime = $_FILES['file1']['type'];
				$size = $_FILES['file1']['size'];			
				$file1 = $_FILES['file1']['name'];
				$file2 =  $filename;

			
				// 썸네일 생성
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 714, 134) == true) {
					// 업로드
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir1);
					$CLASS_FTP->upload($dir1."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir1."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					// 업로드 후 썸네일 이미지 삭제
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}
		}else{

			if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
				Module::callScript("parent.reviewManager.checkImage();");
				break;
			}
			
			//우측배너 이미지처리
			// 디렉토리생성
			if($_FILES['file1']['error'] == "0") {
				$tmp = $_FILES['file1']['tmp_name'];
				$mime = $_FILES['file1']['type'];
				$size = $_FILES['file1']['size'];			
				$file1 = $_FILES['file1']['name'];
				$file2 =  $filename;
				// 썸네일 생성
				if($CLASS_THUMBNAIL->create($tmp, _DIR_TMP."/".$file2, 224, 172) == true) {
					// 업로드
					$CLASS_FTP->connect("file");
					$CLASS_FTP->makeDir($dir1);
					$CLASS_FTP->upload($dir1."/".$file2, _DIR_TMP."/".$file2);
					$CLASS_FTP->delete($dir1."/".$_POST['thumbname']);
					$CLASS_FTP->close();
					// 업로드 후 썸네일 이미지 삭제
					$CLASS_FILE->delete(_DIR_TMP."/".$file2);
				}
			}
		}
		


		$res = $CLASS_MANAGER->BannerInsert($DB, $bannertype, $linktype, $campaign, $spon, $linurl, $filename);
		
		if($res == true) {
			//echo "1";
		    Module::alert("배너가 등록되었습니다.");
			Module::redirect("/manager/regist.banner");

		} else {
		    Module::alert("오류");
			Module::redirectModule("manager");
		}
	break;
	
	/**
	 * 베스트 리스트
	 */
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
	
	/**
	 * 베스트리뷰 추천회원 캐시지급
	 */
	case "review.best.paycash.proc" :
		$FRAME = "ajax";		
		$arr = array();
		$arr[] = $_POST['userno'];
		$arr[] = "0"; // 적립
		$arr[] = "303"; // 캐시코드(베스트리뷰:100)
		$arr[] = ""; // Rf_cash_type참조됨
		$arr[] = "";
		$res = array();
		$res[] = $DB->call("p_cash_ins", $arr);		
		if(Module::result($res, "err", "-1") != false) {
			$jsonArr['result'] = "success";
		} else {
			$jsonArr['result'] = "fail";
		}
		break;
	
	/**
	 * 베스트 후보리스트
	 */
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
	
	/**
	 * 베스트 후보리스트
	 */
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
	
	
	/**
	 * 베스트 후보 선정
	 */
	case "review.choose.proc" :
		$FRAME = "ajax";		
		if(empty($_POST['wno']) || empty($_POST['rno']) || empty($_POST['userno'])) {
			$jsonArr['result'] = "info";
			break;
		}		
		// 베스트 리뷰후보인지 체크
		if($CLASS_REVIEWBEST->isBestCandReview($DB, $_POST['wno'], $_POST['rno']) == true) {
			// 후보삭제 처리
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
				// 테스트후 주석삭제
				$jsonArr['result'] = "repeat";
				break;
			} 
			// 입력처리
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

	//===============================================================
	// 디폴트
	//===============================================================
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		break;

}

if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}
//===============================================================
//MODULE & DB CONNECT CLOSE
//===============================================================
Module::exitModule();
?>