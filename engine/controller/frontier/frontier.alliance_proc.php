<?php
GLOBAL $TPL;
GLOBAL $BASE;
GLOBAL $LOGIN;
GLOBAL $FRAME;

$CLASS_CATECODE = &Module::singleton("Frontier.Frontier");
$CLASS_ZIPCODE = &Module::singleton("Zipcode");

$DB = &Module::loadDb("revu");

$TPL->setValue(array(
	"userno"=>$userno,
	"userid"=>$userid,
));
?>