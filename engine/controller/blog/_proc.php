<?php
/***************************************************************************************
 * 블로그 컨트롤러
 * 
 * 작성일 : 2011.09.07
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
$CLASS_BLOG = &Module::singleton("Blog.Blog");
$CLASS_USER = &Module::singleton("User.User");

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
	 * 아이디 중복체크
	 */
	case "check.id.proc" :
		$FRAME = "ajax";
		if($CLASS_USER->checkRepeatID($DB, $_POST['userid']) == false) {			
			$jsonArr['result'] = "success";			
		} else {
			$jsonArr['result'] = "fail";
		}	
		$jsonArr['userid'] = $_POST['userid'];
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