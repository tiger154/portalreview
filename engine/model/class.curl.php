<?php
class Curl
{
	private $url;
	private $instance = null;
	private $headers = array();	
    private $cookies = array();    
    private $postParams = array();
	private $type = '';
	
	public function Curl() 
	{
	}
	
    private function getCookieString()
	{
		$finalString = '';		
		foreach ($this->cookies as $cookie)
		{
			$finalString .= $cookie->CookieName . '=' . $cookie->CookieValue . '; ';
		}		
		$finalString = rtrim($finalString, '; ');		
		array_splice($this->cookies, 0);		
		return $finalString;
    }
    
    private function getPostParams()
    {
		$finalArray = array();		
		foreach ($this->postParams as $postParam)
		{
			$finalArray[$postParam->ParamName] = $postParam->ParamValue;
		}		
		array_splice($this->postParams, 0);		
		return $finalArray;
    }
    
    private function getHeaders()
    {
		$finalArray = array();		
		foreach($this->headers as $header)
		{
			$finalArray[] = $header->HeaderName . ': ' . $header->HeaderValue;
		}
		array_splice($this->headers, 0);
		return $finalArray;
    }
    
    private function attachCookies()
    {
		if(count($this->cookies) > 0) {
			curl_setopt($this->instance, CURLOPT_COOKIE, $this->getCookieString());
		}
    }
    
    private function attachPostParameters()
	{
		if ($this->type == "POST") {
			if (count($this->postParams) > 0) {
				curl_setopt($this->instance, CURLOPT_POSTFIELDS, $this->getPostParams());
			}
		}
    }
	
    private function attachHeaders()
    {
        if (count($this->headers) > 0)
            curl_setopt($this->instance, CURLOPT_HTTPHEADER, $this->getHeaders());
    }
	/*
	- @@ CURL init Setting
	- CURLOPT_RETURNTRANSFER : to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	- CURLOPT_HEADER : to include the header in the output.
	- CURLOPT_COOKIEJAR : The name of a file to save all internal cookies to when the handle is closed, e.g. after a call to curl_close.
	*/
	public function init($url, $type="GET", $redirect=true, $cookie=null)
	{
		$this->url = $url;
		$this->instance = curl_init($url);
		curl_setopt($this->instance, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->instance, CURLOPT_HEADER, TRUE);
		if(substr_count($url , "https://") > 0) {
			$this->setSSL();
		}
		if($cookie != null) {
			curl_setopt($this->instance, CURLOPT_COOKIEJAR, $cookie);
		}
		$this->type = $type;
		switch($type) {
			case "POST" :
				curl_setopt($this->instance, CURLOPT_POST, TRUE);
				break;
			case "GET" :
			default :  
				curl_setopt($this->instance, CURLOPT_HTTPGET, TRUE);
				break;
		}
		if($redirect) {
			$this->setRedirect();
		}
	}
	
	public function setURL($url)
    {
    	curl_setopt($this->instance, CURLOPT_URL, $url);
		$this->url = $url;
		if(substr_count($url, "https://") > 0) {
			$this->setSSL();
        }
    }
	
	public function setCURLOption($option, $value)
    {
    	curl_setopt($this->instance, $option, $value);
    }
	
	public function setCURLOptions($options)
    {
    	curl_setopt_array($this->instance, $options);
    }
	
	/*
	CURLOPT_AUTOREFERER : to automatically set the Referer: field in requests where it follows a Location: redirect.
	*/
	public function setAutoReferer($value = true)
    {
        curl_setopt($this->instance, CURLOPT_AUTOREFERER, $value);
    }
	
	private function setSSL($value = false)
    {
        curl_setopt($this->instance, CURLOPT_SSL_VERIFYPEER, $value);
    }
	
	private function setRedirect($value=true, $auth=false, $maxRedirects=0)
    {
    	curl_setopt($this->instance, CURLOPT_FOLLOWLOCATION, $value);
		curl_setopt($this->instance, CURLOPT_UNRESTRICTED_AUTH, $auth);
		if($maxRedirects != 0) {
			curl_setopt($this->instance, CURLOPT_MAXREDIRS, $maxRedirects);
		}
    }
	
	public function returnRawOutput($value = true)
    {
    	curl_setopt($this->instance, CURLOPT_BINARYTRANSFER, $value);
    }
	
	public function forceGetFileModification($value = true)
    {
    	curl_setopt($this->instance, CURLOPT_FILETIME, $value);
    }
	
	public function setConnectionTimeOut($value = 0)
    {
    	curl_setopt($this->instance, CURLOPT_CONNECTTIMEOUT, $value);
    }
	
	public function setExecutionTimeOut($value = 0)
    {
    	curl_setopt($this->instance, CURLOPT_TIMEOUT_MS, $value);
    }
	
	public function setHttpVersion($version="")
    {
    	switch($version) {
			case "1.0" : 
				$httpVersion = CURL_HTTP_VERSION_1_0;
				break;
			case "1.1" :
				$httpVersion = CURL_HTTP_VERSION_1_1;
				break;
			default : 
				$httpVersion = CURL_HTTP_VERSION_NONE;
				break;
    	}	
        curl_setopt($this->instance, CURLOPT_HTTP_VERSION, $httpVersion);
    }
	
	public function setReferer($referer)
    {
    	curl_setopt($this->instance, CURLOPT_REFERER, $referer);
    }
	
	public function setUserAgent($userAgent)
    {
    	curl_setopt($this->instance, CURLOPT_USERAGENT, $userAgent);
    }
	
	public function setProxy($proxyAddress, $proxyPort, $proxyUser, $proxyPass)
    {
    	if ($proxyAddress && $proxyPort)
			curl_setopt($this->instance, CURLOPT_PROXY, trim($proxyAddress) . ":" . trim($proxyPort));
		if ($proxyUser && $proxyPass)
			curl_setopt($this->instance, CURLOPT_PROXYUSERPWD, trim($proxyUser) . ":" . trim($proxyPass));
	}
	
	public function addCookie($cookie)
    {
    	if ($cookie instanceof CurlCookie)
			$this->cookies[] = $cookie;
		else
			throw new CurlCookieException("Expecting type CURLCookie.");
    }
	
	public function addPostParameter($parameter)
    {
		if ($this->type == "POST") {
			if ($parameter instanceof CurlPostParameter) {
			    $this->postParams[] = $parameter;
			} else {
			    throw new CurlPostParameterException("Expecting type CURLPostParameter.");
			}
		} else {
			throw new CurlRequestTypeException("AddPostParameter works with type CURLRequestType::POST, please verify the type.");
		}
    }
	
	public function addHeader($header)
    {
		if ($header instanceof CurlHeader)
			$this->headers[] = $header;
		else
			throw new CurlHeaderException("Expecting type CURLHeader.");
    }
	
	public function getInstance()
    {
        return $this->instance;
    }
	
	public function getURL()
    {
        return $this->url;
    }
	
	public function finalizeRequest()
    {
        $this->attachHeaders();
        $this->attachCookies();
        $this->attachPostParameters();
    }
	
	public function execute()
    {
		$this->finalizeRequest(); //나머지 옵션값 처리(헤더,쿠키,파라미터 값(get,post))
		$result = curl_exec($this->instance);   //   setted instance exec
		if ($result === false) {  
			//return new CurlError($this->instance);
			return false;
		} else {
			return new CurlResponse($this->instance, $result);
		}
	}
	
	public function close()
    {
        curl_close($this->instance);
    }
	
}

class CurlCookie
{
	const DOMAIN_ATTR = 'domain';
	const PATH_ATTR = 'path';
	const EXPIRES_ATTR = 'expires';
	const MAX_AGE_ATTR = 'max-age';
	const VERSION_ATTR = 'version';
	const SECURE_ATTR = 'secure';
	const HTTPONLY_ATTR = 'httponly';
	
	public $Domain;
	public $Expires = null;
	public $Path;
	public $Version;
	public $IsSecure;
	public $HttpOnly;
	public $CookieName;
	public $CookieValue;
    
	public function __construct($name, $value)
	{
		if (is_string($name) && is_string($value)) {
		    $this->CookieName = $name;
		    $this->CookieValue = $value;
		}
		else
		{
		    throw new CurlCookieException("Name and value provided for cookie must be of type string.");
		}
	}
	
	public function SetMaxAge($seconds)
	{
		$this->Expires = time() + $seconds;
	}
	
	public function SetExpires($expiresValue)
	{
		$this->Expires = strtotime($expiresValue);
	}
	
	public function SetSecure($value = true)
	{
		$this->IsSecure = $value;
	}
	
	public function SetHttpOnly($value = true)
	{
		$this->HttpOnly = $value;
	}
	
	public function GetDateWithFormat($format)
	{
		if ($this->Expires)
		{
		    return date($format, $this->Expires);
		}
		
		return null;
	}
}
class CurlCookieExtractor
{
	public static function ExtractCookies($headers)
	{
		if (!is_array($headers))
			throw new CurlCookieExtractorException("Array expected.");
		$cookies = array();
		foreach ($headers as $header)
		{
			if (!($header instanceof CurlHeader))
				throw new CurlCookieExtractorException("Expecting type CurlHeader.");
			$cookie = self::ExtractIndivisualCookie($header);
			if ($cookie != null)
				$cookies[] = $cookie;
		}
		return $cookies;
	}
	private static function ExtractIndivisualCookie($cookieHeader)
	{
		if (strcasecmp($cookieHeader->HeaderName, "set-cookie") == 0) {
			$cookiePairs = explode(";", $cookieHeader->HeaderValue);
			$cookieToReturn = null;
	
			foreach ($cookiePairs as $cookiePair)
			{
				$equalToIndex = strpos($cookiePair, '=');
				$keyValue = null;			            
	            if ($equalToIndex === FALSE) {
					$keyValue = array(
					    0 => trim($cookiePair)
					);
	            } else {
					$keyValue = array(
						0 => trim(substr($cookiePair, 0, $equalToIndex)),
						1 => substr($cookiePair, ($equalToIndex + 1))
					);
	            }
	            if (count($keyValue) == 2) {
					if (strcasecmp($keyValue[0], CurlCookie::DOMAIN_ATTR) == 0) {
						$cookieToReturn->Domain = $keyValue[1];
					} else if (strcasecmp($keyValue[0], CurlCookie::EXPIRES_ATTR) == 0) {
					    $cookieToReturn->SetExpires($keyValue[1]);
					} else if (strcasecmp($keyValue[0], CurlCookie::MAX_AGE_ATTR) == 0) {
					    $cookieToReturn->SetMaxAge($keyValue[1]);
					} else if (strcasecmp($keyValue[0], CurlCookie::PATH_ATTR) == 0) {
					    $cookieToReturn->Path = $keyValue[1];
					} else if (strcasecmp($keyValue[0], CurlCookie::VERSION_ATTR) == 0) {
					    $cookieToReturn->Version = $keyValue[1];
					} else {
					    $cookieToReturn = new CurlCookie($keyValue[0], $keyValue[1]);
					}
				} else {
					if (strcasecmp($keyValue[0], CurlCookie::SECURE_ATTR) == 0) {
						$cookieToReturn->SetSecure();
					} else if (strcasecmp($keyValue[0], CurlCookie::HTTPONLY_ATTR) == 0) {
						$cookieToReturn->SetHttpOnly();
					}
				}
			}
			return $cookieToReturn;
		}
		return null;
	}
}
class CurlPostParameter
{
	public $ParamName;
	public $ParamValue;
	private $ParamType;
	
	const VALUE_PARAMETER = 1;
	const FILE_PARAMETER = 2;
	
	public function __construct($name, $value, $type = CurlPostParameter::VALUE_PARAMETER)
	{
		$this->ParamType = $type;		
		if ($type == self::FILE_PARAMETER) {
			$this->ParamName = $name;
			$this->ParamValue = '@' . $value;
		} else if ($type == self::VALUE_PARAMETER) {
			$this->ParamName = $name;
			$this->ParamValue = $value;
		} else {
			throw new CurlPostParameterException("Unknown type of parameter specified.");
		}
	}
}
class CurlHeader
{
	public $HeaderName;
	public $HeaderValue;
	public function __construct($name, $value)
	{
		$this->HeaderName = $name;
		$this->HeaderValue = $value;
	}
}
class CurlError
{
	private static $CURL_ERROR_CODES = array(
	1 => 'CURLE_UNSUPPORTED_PROTOCOL', 
	2 => 'CURLE_FAILED_INIT', 
	3 => 'CURLE_URL_MALFORMAT', 
	4 => 'CURLE_URL_MALFORMAT_USER', 
	5 => 'CURLE_COULDNT_RESOLVE_PROXY', 
	6 => 'CURLE_COULDNT_RESOLVE_HOST', 
	7 => 'CURLE_COULDNT_CONNECT', 
	8 => 'CURLE_FTP_WEIRD_SERVER_REPLY',
	9 => 'CURLE_REMOTE_ACCESS_DENIED',
	11 => 'CURLE_FTP_WEIRD_PASS_REPLY',
	13 => 'CURLE_FTP_WEIRD_PASV_REPLY',
	14 => 'CURLE_FTP_WEIRD_227_FORMAT',
	15 => 'CURLE_FTP_CANT_GET_HOST',
	17 => 'CURLE_FTP_COULDNT_SET_TYPE',
	18 => 'CURLE_PARTIAL_FILE',
	19 => 'CURLE_FTP_COULDNT_RETR_FILE',
	21 => 'CURLE_QUOTE_ERROR',
	22 => 'CURLE_HTTP_RETURNED_ERROR',
	23 => 'CURLE_WRITE_ERROR',
	25 => 'CURLE_UPLOAD_FAILED',
	26 => 'CURLE_READ_ERROR',
	27 => 'CURLE_OUT_OF_MEMORY',
	28 => 'CURLE_OPERATION_TIMEDOUT',
	30 => 'CURLE_FTP_PORT_FAILED',
	31 => 'CURLE_FTP_COULDNT_USE_REST',
	33 => 'CURLE_RANGE_ERROR',
	34 => 'CURLE_HTTP_POST_ERROR',
	35 => 'CURLE_SSL_CONNECT_ERROR',
	36 => 'CURLE_BAD_DOWNLOAD_RESUME',
	37 => 'CURLE_FILE_COULDNT_READ_FILE',
	38 => 'CURLE_LDAP_CANNOT_BIND',
	39 => 'CURLE_LDAP_SEARCH_FAILED',
	41 => 'CURLE_FUNCTION_NOT_FOUND',
	42 => 'CURLE_ABORTED_BY_CALLBACK',
	43 => 'CURLE_BAD_FUNCTION_ARGUMENT',
	45 => 'CURLE_INTERFACE_FAILED',
	47 => 'CURLE_TOO_MANY_REDIRECTS',
	48 => 'CURLE_UNKNOWN_TELNET_OPTION',
	49 => 'CURLE_TELNET_OPTION_SYNTAX',
	51 => 'CURLE_PEER_FAILED_VERIFICATION',
	52 => 'CURLE_GOT_NOTHING',
	53 => 'CURLE_SSL_ENGINE_NOTFOUND',
	54 => 'CURLE_SSL_ENGINE_SETFAILED',
	55 => 'CURLE_SEND_ERROR',
	56 => 'CURLE_RECV_ERROR',
	58 => 'CURLE_SSL_CERTPROBLEM',
	59 => 'CURLE_SSL_CIPHER',
	60 => 'CURLE_SSL_CACERT',
	61 => 'CURLE_BAD_CONTENT_ENCODING',
	62 => 'CURLE_LDAP_INVALID_URL',
	63 => 'CURLE_FILESIZE_EXCEEDED',
	64 => 'CURLE_USE_SSL_FAILED',
	65 => 'CURLE_SEND_FAIL_REWIND',
	66 => 'CURLE_SSL_ENGINE_INITFAILED',
	67 => 'CURLE_LOGIN_DENIED',
	68 => 'CURLE_TFTP_NOTFOUND',
	69 => 'CURLE_TFTP_PERM',
	70 => 'CURLE_REMOTE_DISK_FULL',
	71 => 'CURLE_TFTP_ILLEGAL',
	72 => 'CURLE_TFTP_UNKNOWNID',
	73 => 'CURLE_REMOTE_FILE_EXISTS',
	74 => 'CURLE_TFTP_NOSUCHUSER',
	75 => 'CURLE_CONV_FAILED',
	76 => 'CURLE_CONV_REQD',
	77 => 'CURLE_SSL_CACERT_BADFILE',
	78 => 'CURLE_REMOTE_FILE_NOT_FOUND',
	79 => 'CURLE_SSH',
	80 => 'CURLE_SSL_SHUTDOWN_FAILED',
	81 => 'CURLE_AGAIN',
	82 => 'CURLE_SSL_CRL_BADFILE',
	83 => 'CURLE_SSL_ISSUER_ERROR',
	84 => 'CURLE_FTP_PRET_FAILED',
	84 => 'CURLE_FTP_PRET_FAILED',
	85 => 'CURLE_RTSP_CSEQ_ERROR',
	86 => 'CURLE_RTSP_SESSION_ERROR',
	87 => 'CURLE_FTP_BAD_FILE_LIST',
	88 => 'CURLE_CHUNK_FAILED'
	);
	public $ErrorNumber;
	public $ErrorMessage;
	public $ErrorShortDescription;
	public function __construct($curlObject)	{
		$this->ErrorNumber = curl_errno($curlObject);
		$this->ErrorMessage = curl_error($curlObject);		
		if ($this->ErrorNumber > 0) {
			$this->ErrorShortDescription = self::$CURL_ERROR_CODES[$this->ErrorNumber];
		}
	}
}
class CurlResponse
{
	public $CurrentUrl;
	public $HttpResponseCode;
	public $HttpResponseCodeDescription;
	public $LastModifiedTime;
	public $ContentType;
	public $Cookies;
	public $Headers;
	public $ResposeBody;
	public function __construct($curlObject, $response)
	{	
		$curlInfo = curl_getinfo($curlObject);
		$this->CurrentUrl = $curlInfo['url'];
		$this->HttpResponseCode = $curlInfo['http_code'];
		$this->HttpResponseCodeDescription = CurlHTTPCodeInfo::$RESPONSE_MESSAGES[$this->HttpResponseCode]; //Http응답 코드 설명값 
		$this->LastModifiedTime = $curlInfo['filetime']; // 마지막 수정시간 
		$this->ContentType = $curlInfo['content_type']; //콘텐츠 타입
		$this->Headers = array();
		$this->Cookies = array();		
		// Match the previous item at least n times but no more than m times
		// Grouping: group all together for repetition operators
		// 2이상2이하번 반복 해서 엔터나 나오는 경우 , 배열 길이 3으로 제한(xml버젼표시,rss버젼표시,내용) 
		$respDoc = preg_split("/(\r\n){2,2}/", $response, 3);	
		if (count($respDoc) == 1) { // rss버젼표시 내용이면~
			$this->ParseHeaders($respDoc[0]); //헤더 파싱후, 쿠키에 헤더값 저장
		} else {
			// ori
			/*
			for($i = 0; $i < count($respDoc) - 1; $i++)
			{
				$this->ParseHeaders($respDoc[$i]);				
			}
			$this->ResposeBody = $respDoc[count($respDoc) - 1];
			*/
			
			for($i = 0; $i < count($respDoc) -1; $i++)
			{
				$matches = array();
				$this->ParseHeaders($respDoc[$i]); //헤더 파싱후, 쿠키에 헤더값 저장
				preg_match('/1.1 200 OK/', $respDoc[$i], $matches); //작업 수행 성공 여부 
				if(sizeof($matches) > 0) {
					$rcnt = $i;
					break;
				}	
			}
			for($i = $rcnt+1; $i < count($respDoc); $i++) {
				$this->ResposeBody .= $respDoc[$i];
			}
		}
		
	}
	/*
		\s = white space (탭, 띄어쓰기, \n, \r)
		* = 0번이상 반복
	*/
	private function ParseHeaders($headers)
	{
	    $headersArray = preg_split("/(\r\n)+/", $headers);	    
	    foreach ($headersArray as $header)
	    {
	        $headerParts = preg_split("/\s*:\s*/", $header, 2);
	        if (count($headerParts) == 2)
	        {
	            $ech = new CurlHeader($headerParts[0], $headerParts[1]);
	            $this->Headers[] = $ech;
	        }
	    }	    
	    $this->Cookies = array_merge($this->Cookies, CurlCookieExtractor::ExtractCookies($this->Headers));
	}
}
class CurlHTTPCodeInfo
{
	public static $RESPONSE_MESSAGES = array(
	//[Informational 1xx]
	100 => "Continue",
	101 => "Switching Protocols",
	
	//[Successful 2xx]
	200 => "OK",
	201 => "Created",
	202 => "Accepted",
	203 => "Non-Authoritative Information",
	204 => "No Content",
	205 => "Reset Content",
	206 => "Partial Content",
	
	//[Redirection 3xx]
	300 => "Multiple Choices",
	301 => "Moved Permanently",
	302 => "Found",
	303 => "See Other",
	304 => "Not Modified",
	305 => "Use Proxy",
	306 => "(Unused)",
	307 => "Temporary Redirect",
	
	//[Client Error 4xx]
	400 => "Bad Request",
	401 => "Unauthorized",
	402 => "Payment Required",
	403 => "Forbidden",
	404 => "Not Found",
	405 => "Method Not Allowed",
	406 => "Not Acceptable",
	407 => "Proxy Authentication Required",
	408 => "Request Timeout",
	409 => "Conflict",
	410 => "Gone",
	411 => "Length Required",
	412 => "Precondition Failed",
	413 => "Request Entity Too Large",
	414 => "Request-URI Too Long",
	415 => "Unsupported Media Type",
	416 => "Requested Range Not Satisfiable",
	417 => "Expectation Failed",
	
	//[Server Error 5xx]
	500 => "Internal Server Error",
	501 => "Not Implemented",
	502 => "Bad Gateway",
	503 => "Service Unavailable",
	504 => "Gateway Timeout",
	505 => "HTTP Version Not Supported"
	);
}

class CurlRequestTypeException extends Exception {}
class CurlCookieException extends Exception {}
class CurlPostParameterException extends Exception {}
class CurlHeaderException extends Exception {}
class CurlCookieExtractorException extends Exception {}
class CurlExecuterCallbackException extends Exception {}
class CurlExecuterException extends Exception {}
?>