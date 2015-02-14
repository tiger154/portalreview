<?php
/***************************************************************************************
 * 메세지(쪽지) 컨트롤러
 * 
 * 작성일 : 2011.07.08
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
$CLASS_PAGE = &Module::singleton("Page");
$CLASS_MESSAGE = &Module::singleton("User.Message");

/**
 * DB OBJECT
 */
$DB = &Module::loadDb("revu");

/**
 * VAR / PROC
 */
GLOBAL $PRIV;
$PRIV->isPriv(Module::$module, Module::$todo, $_SESSION, $xml="");
 	
$CLASS_PAGE->set('page', Module::$param[0]);
$CLASS_PAGE->set('pageNum', Module::$param[1]);
$CLASS_PAGE->set('pageRow', Module::$param[2]);
$param = array();
$param[] = "파라미터1";
$param[] = "파라미터2";

// 총카운트
$cnt = $CLASS_MESSAGE->getSendCount($DB, $sender=$_SESSION['userno'], $flag_sender_del='0');
$CLASS_PAGE->set('totalRowCount', $cnt);

// 리스트
$list = $CLASS_MESSAGE->getSendList($DB, $sender=$_SESSION['userno'], $flag_sender_del='0', $CLASS_PAGE->getLimit());

for($i=0;$i<sizeof($list);$i++) {
	$message = $CLASS_MESSAGE->getMessage($DB, $list[$i]['idx']);
	$list[$i]['title'] = $message['title'];
	$list[$i]['content'] = $message['content'];
}

// 페이지생성
$CLASS_PAGE->pageLink("/".Module::$module."/".Module::$todo, $param);
$link = $CLASS_PAGE->getLink();

/**
 * TEMPLATE VARS
 */
$TPL->setValue(array(
	"page"=>$CLASS_PAGE->page,
	"page_row"=>$CLASS_PAGE->pageRow,
	"cnt"=>$cnt,
	"list"=>$list,
	"link"=>$link,
	"param"=>$param,
));
?>