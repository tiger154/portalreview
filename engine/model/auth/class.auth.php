<?php
class Auth
{
	public function Auth()
	{		
	}

	public function isLogin()
	{
		if(($_SESSION['userno'] != "") && (strlen($_SESSION['userno']) > 0) && (sizeof($_SESSION) > 0)) {
			return true;
		} else {
			return false;
		}
	}
}
?>