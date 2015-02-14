<?php
/******************************************
* FTP 파일 다운로드 테스트
*
* 레뷰 박상선
*******************************************/
//GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;

//===============================================================
//GLOBAL VARS
//===============================================================
//GLOBAL $FRAME;



$CLASS_MANAGER	= &Module::singleton("Manager.Manager");
$CLASS_FTP					= &Module::singleton("Ftp");

$DB = &Module::loadDb("revu");

$no = Module::$param[0];




$file_name = $CLASS_MANAGER->AfileSelect($DB, $no);
for($i=0;$i<sizeof($file_name);$i++) {
	$ftpfile	= $file_name[$i]['file'];
}


$dir1 = _FTP_CP;	

// 스토리지서버 접속 
$CLASS_FTP->connect("file");

$CLASS_FTP->getFile2($ftpfile, $dir1);



ftp_close($conn_id);  
fclose($fp);  


?>
