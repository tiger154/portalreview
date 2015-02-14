<?php
/***************************************************************************************
 * 에디터 컨트롤러
 * 
 * 작성일 : 2011.08.10
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
$CLASS_FTP = &Module::singleton("Ftp");
$CLASS_FILE = &Module::singleton("File");
$CLASS_THUMBNAIL = &Module::singleton("Thumbnail");
$CLASS_USER = &Module::singleton("User.User");

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
	 * 이미지업로드
	 */
	case "editor.image.upload.proc" :
		
		if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
			Module::callScript("parent.popup.initImage();");
			break;
		}
		
		if($_FILES['file1']['error'] == "0") {			
			$filename = uniqid().".".$CLASS_FILE->getExtname($_FILES['file1']['name']);
			$CLASS_FILE->upload($_FILES['file1'], $filename, _DIR_TMP);
			$dir = _FTP_TMP;
			$CLASS_FTP->connect("file");
			$CLASS_FTP->makeDir($dir);
			$CLASS_FTP->upload($dir."/".$filename, _DIR_TMP."/".$filename);
			$CLASS_FTP->close();
			$CLASS_FILE->delete(_DIR_TMP."/".$filename);
			$script = "			
			parent.popup.filemime = '".$_FILES['file1']['type']."';
			parent.popup.filename = '".$filename."';
			parent.popup.filename2 = '".$_FILES['file1']['name']."';
			parent.popup.filesize = '".$_FILES['file1']['size']."';
			parent.popup.imagealign = '';
			parent.popup.imageurl = 'http://"._DOMAIN_FILE."/".$dir."/".$filename."';
			parent.popup.originalurl = 'http://"._DOMAIN_FILE."/".$dir."/".$filename."';
			parent.popup.thumburl = 'http://"._DOMAIN_FILE."/".$dir."/".$filename."';
			parent.popup.previewImage();
			";
			Module::callScript($script);
			break;
		}
		Module::callScript("parent.popup.initImage();");
		break;
	
	/**
	 * 파일업로드
	 */
	case "editor.file.upload.proc" :
	
		if($CLASS_FILE->isRunByMime($_FILES['file1']['tmp_name'], "mime") == true) {
			Module::callScript("parent.popup.initType();");
			break;
		}
		if($_FILES['file1']['error'] == "0") {			
			$filename = uniqid().".".$CLASS_FILE->getExtname($_FILES['file1']['name']);
			$CLASS_FILE->upload($_FILES['file1'], $filename, _DIR_TMP);
			$dir = _FTP_TMP;
			$CLASS_FTP->connect("file");
			$CLASS_FTP->makeDir($dir);
			$CLASS_FTP->upload($dir."/".$filename, _DIR_TMP."/".$filename);
			$CLASS_FTP->close();
			$CLASS_FILE->delete(_DIR_TMP."/".$filename);
			$script = "
			parent.popup.filemime = '".$_FILES['file1']['type']."';
			parent.popup.filename = '".$filename."';
			parent.popup.filename2 = '".$_FILES['file1']['name']."';
			parent.popup.filesize = '".$_FILES['file1']['size']."';
			parent.popup.attachurl = 'http://"._DOMAIN_FILE."/".$dir."/".$filename."';
			parent.popup.previewType();
			";
			Module::callScript($script);
			break;
		}
		Module::callScript("parent.popup.initType();");
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