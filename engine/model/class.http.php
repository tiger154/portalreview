<?php
class Http
{
	var $socket;
	
	var $url;
	var $scheme;
	var $host;
	var $port;
	var $user;
	var $pass;
	var $path;
	var $query;
	var $fragment;

	var $request;
	var $response;

	var $requestHeader;
	var $requestBody;
	var $requestPath;
	var $requestVar;

	var $responseHeader;
	var $responseBody;

	var $errno;
	var $errstr;

	public function Http()
	{
	}

	public function connect($url)
	{
		$_parts = parse_url($url);
		$this->scheme = $_parts['scheme'];
		$this->host	 = $_parts['host'];
		$this->port = (!$_parts['port']) ? 80 : $_parts['port'];
		$this->user = $_parts['user'];
		$this->pass = $_parts['pass'];
		$this->path = $_parts['path'];
		$this->query = $_parts['query'];
		$this->fragment = $_parts['fragment'];
		@parse_str($_parts['query'],$_query);
		$this->setRequestHeader('Host', $_parts['host']);
		$this->setRequestPath($_parts['path']);
		$this->setRequestVar($_query);
	}

	public function post()
	{
		$this->_connect();
		$this->setRequestHeader('Content-type','application/x-www-form-urlencoded');
		@fputs($this->socket,$this->buildRequest('POST'));
		return $this->result();
	}

	public function get()
	{
		$this->_connect();
		@fputs($this->socket, $this->buildRequest('GET'));
		return $this->result();
	}

	public function result()
	{
		while(($line = @fgets($this->socket,1024)) && trim($line) != "") {
			$header.= $line;
		}
		while(!@feof($this->socket)) {
			$body.= @fgets($this->socket,1024);
			if($body == "") break;
		}
		$this->httpResponse($header, $body);
		//$this->response = $this->httpResponse($header, $body);
		//return $this->response;
		//$this->_close();
		return array($header, $body);
	}

	public function _connect()
	{
		$fp = @fsockopen($this->host, $this->port, &$this->errno, &$this->errstr, 10);
		if(!$fp) return $this->setError($this->host."로의 접속에 실패했습니다. $this->errno, $this->errstr");
		$this->socket = $fp;
	}

	public function reset()
	{
		$this->request = $this->response = null;
	}

	public function setError($msg='')
	{
		//if ($msg) echo $msg;		
		return false;
	}

	public function httpRequest($requestHeader='',$requestBody='')
	{
		$this->requestHeader = array();
		$this->requestBody = '';
	}

	public function setRequestPath($path='/')
	{
		$this->requestPath = $path;
	}

	public function setRequestHeader($key,$value='')
	{
		if (is_array($key)) {
			$this->requestHeader = array_merge($this->requestHeader,$key);
		} else {
			$this->requestHeader[$key] = $value;
		}
	}

	public function setRequestVar($key,$value='')
	{
		if (is_array($key)) {
			$this->var = @array_merge($this->var,$key);
		} else {
			$this->var[$key] = $value;
		}
	}

	public function setRequestBody($msg='')
	{
		$this->requestBody = urlencode($msg);
	}

	public function buildRequest($method='GET')
	{
		if ($this->requestHeader) {
			while (list($_key, $_val) = each($this->requestHeader)) {
				$header.= $_key.": ".$_val."\r\n";
			}
		}
		if ($this->var) {
			while (list($_key, $_val) = each($this->var)) {
				$query.= $_key."=".urlencode($_val)."&";
			}
		}
		$body = $this->requestBody;
		if ($query) $body.= (($body) ? $body.'&' : '').substr($query,0,-1);
		else $body = $this->requestBody;

		switch (strtoupper($method)) {
			case "GET":
				$str = "GET ".$this->requestPath.'?'.$query. " HTTP/ 1.0\r\n";
				$str.= $header."\r\n";
				break;
			case "POST":
				$str = "POST ".$this->requestPath."?HTTP/ 1.0\r\n";
				$str.= "Content-length: ".strlen($body)."\r\n";
				$str.= $header."\r\n";
				$str.= $body;
				break;
		}
		return $str;
	}

	public function httpResponse($header='',$body='')
	{
		$lines = split("\r\n",trim($header));
		if ($lines) {
			$arr = array();
			foreach ($lines as $line) {
				list($key,$value) = explode(':',$line,2);
				$arr[$key] = $value;
			}
		}
		$this->responseHeader = $arr;
		$this->responseBody = $body;
	}
}
?>