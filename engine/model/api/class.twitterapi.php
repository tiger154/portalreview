<?php
class TwitterAPI
{	
	public function TwitterAPI()
	{
		Module::includeExtends("twitter", "twitteroauth");
	}
	
	public function isConf()
	{
		if (CONSUMER_KEY === '' || CONSUMER_SECRET === '') {
			return false;
		}
		return true;
	}
	
	public function isLogin($db, $user_id)
	{
		//$this->getAccessToken();
		$twitter = $this->getTwitter($db, $user_id);		
		if($this->isConf() == false) return false;				
		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter['oauth_token'], $twitter['oauth_token_secret']);		
		//if($connection->http_code == 200) {
		if(isset($connection->key)) {
			return $connection;
		} else {
			return false;
		}
	}
	
	public function getConnection($db, $user_id)
	{
		//$this->getAccessToken();
		$twitter = $this->getTwitter($db, $user_id);		
		if($this->isConf() == false) return false;
		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter['oauth_token'], $twitter['oauth_token_secret']);
		//print_r($connection);		
		return $connection;
	}
	
	public function initSession()
	{
		//unset($_SESSION['oauth_token']);
		//unset($_SESSION['oauth_token_secret']);
		unset($_SESSION['access_token']);
		unset($_SESSION['api_twitter_todo']);
		unset($_SESSION['api_twitter_param']);
		return true;
	}
	
	public function initJoinSession()
	{
		unset($_SESSION['joinSNSKey']);
		unset($_SESSION['joinType']);
	}
	
	public function getRequestToken()
	{
		if($this->isConf() == false) return false;		
		/* Build TwitterOAuth object with client credentials. */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);		
		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken(OAUTH_CALLBACK);		
		/* Save temporary credentials to session. */
		//$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		return $connection;
	}
	
	public function getAccessToken($db)
	{
		if($this->isConf() == false) return false;		
		/* If the oauth_token is old redirect to the connect page. */
		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
			//$_SESSION['oauth_status'] = 'oldtoken';			
			//header('Location: ./clearsessions.php');
			//$this->initSession();
		}
		/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);		
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);		
		/* Save the access tokens. Normally these would be saved in a database for future use. */
		$_SESSION['access_token'] = $access_token;		
		/* Remove no longer needed request tokens */
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);
		
		if ($connection->http_code == 200) {
			$arr = array();
			$arr[] = $access_token['oauth_token']; // 트위터토큰
			$arr[] = $access_token['oauth_token_secret']; // 트위터비밀토큰
			$arr[] = $access_token['user_id']; // 트위터아이디
			$arr[] = $access_token['screen_name']; // 스크린명
			$db->rConnect();
			$res[] = $db->call("p_account_twitter_ins", $arr);
			return $connection;
		} else {
			return false;
		}
		
	}
	
	public function isResource() 
	{
		//if($_SESSION['api_twitter_type'] == "" || 
		//$_SESSION['api_twitter_method'] == "" || 
		//$_SESSION['api_twitter_todo'] == "") {
		if($_SESSION['api_twitter_todo'] == "") {
			return false;
		} else {
			return true;
		}
	}
	
	public function initResource()
	{
		$_SESSION['api_twitter_todo'] = "";
		$_SESSION['api_twitter_param'] = "";
	}
	public function call($connection, $method="GET", $resource, $data)
	{
		if($method == strtoupper("GET")) {
			$content_object = $connection->get($resource);
		} else {
			$content_object = $connection->post($resource, $data);
		}
		$content = get_object_vars($content_object);
		return $content;
	}
	
	public function getTwitter($db, $user_id)
	{
		$sql = "
		SELECT		* 
		FROM		Ru_account_twitter 
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
		FROM		Ru_account_twitter 
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