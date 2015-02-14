<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $SITE;
GLOBAL $FRAME;

$CLASS_AUTH = &Module::singleton("Auth.Auth");
$CLASS_LOGIN = &Module::singleton("Auth.Login");
$CLASS_ADMIN = &Module::singleton("Auth.Admin");

$DB = &Module::loadDb("revu");

if($_SERVER['HTTP_HOST'] != "mng.revu.co.kr") {
	Module::redirect("http://www.revu.co.kr");
} else {
	if($_SESSION['userno']) {
		if($CLASS_ADMIN->isAdmin($DB, $_SESSION['userno']) == false) {
			Module::redirect("/");
		} else {
			$admin = $CLASS_ADMIN->getAdmin($DB, $_SESSION['userno']);
			$sess['grade'] = $admin['grade'];
			$CLASS_LOGIN->addSession($sess);	
			if($_SESSION['grade'] > 106) {
				Module::redirect("/manager/home");
			}
		}
	}
}

$TPL->setValue(array(
	"grouplist"=>$grouplist,
));
?>