<?php
/***************************************************************************************
 * 컨트롤러명
 * 
 * 작성일 : 2011.07.28
 * 작성자 : 작성자
 * 히스토리 : 
 * 
 * 2011.XX.XX (작성자)
 * > 수정내용1
 * > 수정내용2 
 * 
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
//$CLASS_FTP = &Module::singleton("Ftp");

/**
 * DB OBJECT
 */
//$DB = &Module::loadDb("revu");

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
	 * 일반처리
	 */
	case "todo1.proc" :
		break;
		
	/**
	 * AJAX처리
	 */
	case "todo1.todo2.proc" :
		$FRAME = "ajax";
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