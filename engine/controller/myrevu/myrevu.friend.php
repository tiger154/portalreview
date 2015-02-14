<?php
/***************************************************************************************
 * 친구리스트 컨트롤러
 * 
 * 작성일 : 2011.08.30
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
$CLASS_PAGE = &Module::singleton("Page2", 2);
$CLASS_USER = &Module::singleton("User.User");
$CLASS_FRIEND = &Module::singleton("User.Friend");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
$grouplist = $CLASS_FRIEND->getFriendGroupList($DB, $_SESSION['userno']);
$type = (Module::$param[0] == "") ? "ALL" : Module::$param[0];
$groupno = Module::$param[1];

$CLASS_PAGE->set('page', Module::$param[2]);
//$CLASS_PAGE->set('pageRow', 12);
$CLASS_PAGE->getLimit();

$cnt = $CLASS_FRIEND->getFriendCount($DB, $_SESSION['userno'], $type, $groupno);
$list = $CLASS_FRIEND->getFriendList($DB, $limit, $_SESSION['userno'], $type, $groupno);
for($i=0;$i<sizeof($list);$i++) {
	if($list[$i]['userno'] != $_SESSION['userno']) {
		$userno = $list[$i]['userno'];
		if($list[$i]['flag_eachother'] != "1") {
			$list[$i]['type'] = "ME";
		} else {
			$list[$i]['type'] = "EO";
		}
	} else {
		$userno = $list[$i]['fuserno'];	
		if($list[$i]['flag_eachother'] != "1") {
			$list[$i]['type'] = "MY";
		} else {
			$list[$i]['type'] = "EO";
		}
	}
	$user = $CLASS_USER->getUser($DB, $userno);
	$extra = $CLASS_USER->getUserExtra($DB, $userno);
	$list[$i]['userno'] = $userno;
	$list[$i]['nickname'] = $user['nickname'];
	$list[$i]['userimage'] = $CLASS_USER->getImage($userno, $extra['userimage']);
	unset($user);
	unset($extra);
}
// 페이지생성
$CLASS_PAGE->set('totalRowCount', $cnt);
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
$link = $CLASS_PAGE->getLink();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"grouplist"=>$grouplist,
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"type"=>$type,
	"groupno"=>$groupno,
));
?>