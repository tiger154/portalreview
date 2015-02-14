<?php
class FacebookAPI
{
	public $facebook;
	public $scope = "read_stream, publish_stream, offline_access";
	public $page = "page"; // popup, touch, page
	public $loginURL;
	public $logoutURL;
	public $FFFuserID;
	
	public function FacebookAPI()//__Constructor
	{
		Module::includeExtends("facebook", "facebook");		
		if($this->isConf() == false) {
			return false;
		}
		$this->facebook = new Facebook(array('appId'=>FACEBOOK_KEY, 'secret'=>FACEBOOK_SECRET, 'cookie' => true));		
     	$this->loginURL = $this->facebook->getLoginUrl( array( "api_key"=>FACEBOOK_KEY, "scope" => "read_stream, publish_stream, offline_access, publish_actions", "display" => "page", "next"=>FACEBOOK_CALLBACK ) );
		$this->logoutURL = $this->facebook->getLogoutUrl();
		
       
		return true;
	}
	
	public function isConf()
	{
		if (FACEBOOK_KEY === '' || FACEBOOK_SECRET === '') {
			return false;
		}
		return true;
	}
	
	public function getSessionField()
	{
		$field = array();
		$field['code'] = "fb_".FACEBOOK_KEY."_code";
		$field['access_token'] = "fb_".FACEBOOK_KEY."_access_token";
		$field['user_id'] = "fb_".FACEBOOK_KEY."_user_id";
		$field['state'] = "fb_".FACEBOOK_KEY."_state";
		return $field;
	}
	
	public function initSession()
	{
		$field = $this->getSessionField();
		foreach($field as $key =>  $val) {
			unset($_SESSION[$key]);
		}
		return true;
	}

	public function initSession_slink()
	{
		$field = $this->getSessionField();
		foreach($field as $key =>  $val) {
			unset($_SESSION[$val]);
		}
		return true;
	}
	
	public function initJoinSession()
	{
		unset($_SESSION['joinSNSKey']);
		unset($_SESSION['joinType']);
	}
	
	public function isLogin()
	{
		if($this->isConf() == false) return false;
		$field = $this->getSessionField();
		foreach($field as $key =>  $val) {
			if($_SESSION[$val] == "") {
				return false;				
			}
			//if($_SESSION[$key] == "") return false;
		}
		return true;
	}
	
	public function getUser($db, $user_id)
	{
		$sql = "
		SELECT		* 
		FROM		Ru_account_facebook 
		WHERE		user_id = '".$user_id."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		return $row;
	}
	
	public function isUser($db, $user_id)
	{
		$sql = "
		SELECT		COUNT(user_id) as cnt 
		FROM		Ru_account_facebook 
		WHERE		user_id = '".$user_id."'
		";
		//echo $sql;
		$row = $db->fetch($sql, true);
		if($row['cnt'] > 0) {
			return true;
		} else {
			return false;
		}
	}
}
?>