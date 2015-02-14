<?php
GLOBAL $TPL;
GLOBAL $BASE;

GLOBAL $SITE;
GLOBAL $POPUP;

$CLASS_FTP					= &Module::singleton("Ftp");
$CLASS_FILE					= &Module::singleton("File");
$CLASS_THUMBNAIL		= &Module::singleton("Thumbnail");
$CLASS_FRONTIER			= &Module::singleton("Frontier.Frontier");
$CLASS_FTP					= &Module::singleton("Ftp");
$CLASS_FILE					= &Module::singleton("File");


$DB = &Module::loadDb("revu");
$jsonArr = array();

switch(Module::$todo)
{
	


	case "frontier.entry1.proc" :


	$frno	 				= $_POST["frno"]; 
	$frid	 				= $_POST["frid"]; 
	$name				= $_POST["name"]; 
	$sex					= $_POST["sex"];
	$birth_year			= $_POST["birth_year"];
	$birth_month		= $_POST["birth_month"];
	$birth_day			= $_POST["birth_day"];
	$mobile1			= $_POST["mobile1"];
	$mobile2			= $_POST["mobile2"];
	$mobile3			= $_POST["mobile3"];
	$tel1					= $_POST["tel1"];
	$tel2					= $_POST["tel2"];
	$tel3					= $_POST["tel3"];
	$zipcode			= $_POST["addrzip"];
	$addr1				= $_POST["addr1"];
	$addr2				= $_POST["addr2"];
	$option1			= $_POST["option1"];
	$editor				= $_POST["editor"];
	$agree				= $_POST["agree"];
	$userno			= $_SESSION["userno"];
	$userid				= $_SESSION["userid"];
	$usernick			= $_SESSION["nickname"];

	$editor				=str_replace("'","\'",$editor);
	$birthday			= $birth_year."/".$birth_month."/".$birth_day;


	$mobile				= $mobile1."-".$mobile2."-".$mobile3;
	$tel					= $tel1."-".$tel2."-".$tel3;


	$dupcnt = $CLASS_FRONTIER->EntryDuplication($DB, $frno, $userno);
	if($dupcnt > 0){
		
		Module::alert("이미 응모하신 프론티어 입니다. 중복 응모는 하실 수 없습니다.");
		break;

	}

	$res = $CLASS_FRONTIER->frontierentry_inc($DB, $frno, $frid);
	$res2 = $CLASS_FRONTIER->frontierentryuser_update($DB, $name, $sex, $birth_year, $birth_month, $birth_day, $mobile1, $mobile2, $mobile3, $tel1, $tel2, $tel3, $zipcode, $addr1, $addr2, $userno, $userid);



	$ftbArr = array();		


	$ftbArr[] = $frno;
	$ftbArr[] = $frid;
	$ftbArr[] = $name;
	$ftbArr[] = $sex;
	$ftbArr[] = $birthday;
	$ftbArr[] = $mobile; 
	$ftbArr[] = $tel;
	$ftbArr[] = $zipcode;
	$ftbArr[] = $addr1;
	$ftbArr[] = $addr2;
	$ftbArr[] = $option1;
	$ftbArr[] = $userno;
	$ftbArr[] = $userid;
	

	
	$res = array();		
	
	$res[] = $DB->call("p_frontier_entry", $ftbArr);

	
	if($res[0]['orcode'] == '1') { 



		$division = "T";
		$division_no = "0";


	    $ftetAry = array();
		$ftetAry[] = $frno;
		$ftetAry[] = $userno;
		$ftetAry[] = $usernick;
		$ftetAry[] = $division;
		$ftetAry[] = $division_no;
		$ftetAry[] = $editor;


		$DB->rConnect();
		$result[] = $DB->call("p_frontier_talkins", $ftetAry);


		// Check ActionGraph status which is active or not
		// If its active DO Recommend action
		// or not  review : 'http://www.revu.co.kr/1304795'
		$CLASS_FACEBOOK = &Module::singleton("API.FacebookAPI");
		$CLASS_USER = &Module::singleton("User.User");
		$action_user = $CLASS_USER->getUser($DB, $_SESSION['userno']);
		
		if($action_user["flag_opengraph"] == "1"){
			try {					
					$CLASS_FACEBOOK->facebook->api("/me/revulove:Participate?access_token=".$_SESSION[$field['access_token']], "POST", 
					array("access_token"=>$_SESSION[$field['access_token']], "frontier" =>"http://www.revu.co.kr/frontier/detailview/1/".$frno."/A/", "message"=>$editor));
					//$jsonArr['opengraph_result'] = "success";
			} catch (FacebookApiException $e) {
				// Log Exception error
					//$jsonArr['opengraph_result'] = "fail";
			}	
		}else{
					//$jsonArr['opengraph_result'] = "disabled";
		}		


		Module::alert("응모하셨습니다. 감사합니다.");
		Module::redirect("/frontier/detailview//$frno");

		
	}else{
		echo "프론티어 응모 실패<br>";
	}
	break;


  	case "frontier.alliance.proc" :

	$dir = _FTP_FRONTIERIMAGE."/"."alliance_file"."/";				

	$company			= $_POST["company"];							
	$homepage		= $_POST["homepage"];							
	$rname				= $_POST["rname"];								
	$company_tel		= $_POST["company_tel"];						
	$company_mail	= $_POST["company_mail"];					
	$company_say	= $_POST["company_say"];					
	


	$rel_file = $CLASS_FILE->getExtname($_FILES['file']['name']);

	if ($rel_file != ""){

		
		$filename			= date("Ymd")."_ac";

		$file = $filename.".".strtolower($CLASS_FILE->getExtname($_FILES['file']['name']));		
		$CLASS_FILE->upload($_FILES['file'], $file, _DIR_TMP);													
		$CLASS_FTP->connect("file");																						
		$CLASS_FTP->makeDir($dir);																						
		$CLASS_FTP->upload($dir."/".$file, _DIR_TMP."/".$file);													
		$CLASS_FTP->close();																								
	}

	$res = $CLASS_FRONTIER->FrontierAlli($DB, $company, $homepage, $rname, $company_tel, $company_mail, $company_say, $file);

	Module::alert("프론티어 제휴문의가 등록되었습니다. 감사합니다.");
	Module::redirect("/frontier/alliance");


	break;



	
  	case "frontier.talkreply.proc" :


	$talknum		= $_POST["replyno"];							

	$reply			= $_POST["reply{$_POST[replyno]}"];							
	$user_num		= $_POST["user_num"];							
	$usernick		= $_SESSION["nickname"];
	$division		= "R";
	$frno				= $_POST["frno"];							

	$reply				=str_replace("'","\'",$reply);


	$res = $CLASS_FRONTIER->TalkReplyins($DB, $reply, $user_num, $usernick, $division, $frno, $talknum);

	Module::redirect("/frontier/detailview//$frno/C//M");


	break;





	
  	case "frontier.replyedit.proc" :

	
	$talknum		= $_POST["replyeditno"];							

	$reply			= $_POST["replyedit{$_POST[replyeditno]}"];							

	$user_num		= $_POST["user_num"];							
	$usernick		= $_SESSION["nickname"];
	$division		= "R";
	$frno				= $_POST["frno"];							



	$res = $CLASS_FRONTIER->TalkReplyedit($DB, $reply, $user_num, $usernick, $division, $frno, $talknum, "E");

	Module::redirect("/frontier/detailview//$frno/C//M");

	break;




	
  	case "frontier.replydel.proc" :


	$talknum		= $_POST["delreplyno"];							


	$user_num		= $_POST["user_num"];							
	$usernick		= $_SESSION["nickname"];
	$division		= "R";
	$frno				= $_POST["frno"];							



	$res = $CLASS_FRONTIER->TalkReplyedit($DB, $reply, $user_num, $usernick, $division, $frno, $talknum, "D");

	Module::redirect("/frontier/detailview//$frno/C//M");

	break;


	
  	case "frontier.entrydel.proc" :


	$talknum		= $_POST["delreplyno"];							


	$user_num		= $_POST["user_num"];							
	$usernick		= $_SESSION["nickname"];
	$division		= "R";
	$frno				= $_POST["frno"];							



	$res = $CLASS_FRONTIER->EntryCancel($DB, $reply, $user_num, $usernick, $division, $frno, $talknum, "D");

	
	Module::redirect("/frontier/detailview//$frno/C//M");

	break;


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