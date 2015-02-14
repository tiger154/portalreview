<?php
/***************************************************************************************
 * 인포 컨트롤러
 * 
 * 작성일 : 2011.10.20
 * 작성자 : 이종학
 * 히스토리 : 
 ***************************************************************************************/ 

/**
 * GLOBAL CLASS / VAR
 */
GLOBAL $TPL;
GLOBAL $BASE;
// var
GLOBAL $SITE;
GLOBAL $FRAME;

/**
 * CLASS
 */
//$CLASS_REVIEW = &Module::singleton("Review.Review");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$jsonArr = array();

/**
 * TODO
 */
switch(Module::$todo)
{	
	/**
	 * 실시간 리뷰카운트
	 */
	case "powerblog.application.proc" :	
		
		if($_SESSION['userno'] == "") {
			Module::alert("로그인 후 파워블로그에 지원하실 수 있습니다.");
			Module::redirect("/info/powerblog");
		} else {
			$arr = array();
			$arr[] = $_SESSION['userno'];
			$arr[] = $_POST['cate'][0];
			$arr[] = $_POST['cate'][1];
			$arr[] = $_POST['cate'][2];
			$arr[] = $_POST['cate'][3];
			$arr[] = $_POST['cate'][4];
			$res = array();
			$res[] = $DB->call("p_powerblog_application_ins", $arr);		
			if($res[0]['orcode'] == "1") {
				if($res[0]['ocnt'] > 0) {
					if($res[0]['oflag_app'] == "1") {
						Module::alert("이미 파워블로그에 선정되셨습니다.");
					} else {
						Module::alert("현재 심사중입니다.");
					}
				} else {
					Module::alert("레뷰 파워블로그에 지원되었습니다.");
				}
			} else {
				Module::alert("파워블로그 지원이 실패하였습니다.");
			} 
			Module::redirect("/info/powerblog");
		}		
		break;

	/**
	 * 디폴트
	 */
	default :
		Module::alert("잘못된 경로입니다.");
		//Module::redirectModule("index", $param="");
		break;

}

/**
 * AJAX OUTPUT 
 */
if($FRAME == "ajax") {
	$output = json_encode($jsonArr);
	print($output);
}

/**
 * MODULE & DB CONNECT CLOSE
 */
Module::exitModule();
?>