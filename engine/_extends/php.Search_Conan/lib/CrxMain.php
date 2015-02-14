<?php
/*
 * Created on 2009. 09. 07
 *
 * 서버와 crx로 통신하기 위한 클라이언트 API
 *
 * @version 1.1.0
 * @author 신동호, 박용기
 */

require_once("CrxParam.php");
require_once("CrxSocket.php");
require_once("CrxUtil.php");

define("REXT_NORM",               0);
define("REXT_URGT",               1);
define("REXT_CTRL",               2);
define("REXT_NOOP",               3);

define("REQUEST_CRX",                                     67);      // from cz-def.h
define("CRX_REQUEST_UNIVERSAL_PARAMETER",                 0);       //
define("CRX_REQUEST_XML",                                 1);       // from cx-def.h
define("CRX_REQUEST_EXTRACT_KEYWORD_FROM_QUERY",          2);       // from cx-def.h
define("CRX_REQUEST_EXTRACT_KEYWORD_FROM_DOCUMENT",       3);       // from cx-def.h

$__g_encrypt_key = "\xA7\x18\x5F\x89\x03\xBC\x55\x26";


function EncodeDecodeCrxRequest($para_data_size, &$para_data_buf)
{
	global $__g_encrypt_key;
	$i=4;
	$j=0;

	if(is_string($para_data_buf) == FALSE) {
		return -1;
	}

	for($i=4; $i<$para_data_size; $i++)
	{
		if($j>=8){
			$j = 0;
		}
		$para_data_buf[$i] = $para_data_buf[$i] ^ $__g_encrypt_key[$j];
		$j++;
	}

	return 0;
}


class CrxMain
{
	function Constructor()
	{
		$this->m_sck = new CrxSocket;
		$this->m_sck->Constructor();
		$this->m_param = new CrxParam;
		$this->m_param->Constructor();

		$this->m_msg = "";

		$this->m_saddr = "";
		$this->m_id = "";
		$this->m_pwd = "";
		$this->m_copt = "";

		$this->m_worker_address = "";
		$this->m_worker_time = -1;
		$this->m_response_time = -1;

		$this->m_response_size = 0;
		$this->m_response = "";

		$this->m_request_size = 0;
		$this->m_request = "";

		$this->m_f_response_received = 0;

		$this->ClearOption();

		return 0;
	}

	function Destructor()
	{
		$this->m_sck->Destructor();
		$this->m_param->Destructor();

		$this->m_msg = "";

		$this->m_saddr = "";
		$this->m_id = "";
		$this->m_pwd = "";
		$this->m_copt = "";

		$this->m_worker_address = "";
		$this->m_worker_time = -1;
		$this->m_response_time = -1;

		$this->m_response_size = 0;
		$this->m_response = "";

		$this->m_request_size = 0;
		$this->m_request = "";

		$this->m_f_response_received = 0;

		$this->ClearOption();
		
		return 0;
	}

	function GetMessage()
	{
		return $this->m_msg;
	}

	function Connect($para_saddr, $para_id, $para_pwd, $para_copt)
	{
		if (strlen($para_id) > 15) {
			$this->m_msg = "userid too long (C97172)";
			return -1;
		}
		if (strlen($para_pwd) > 15) {
			$this->m_msg = "password too long (C97173)";
			return -1;
		}
		$this->m_saddr = $para_saddr;
		$this->m_id = $para_id;
		$this->m_pwd = $para_pwd;
		$this->m_copt = $para_copt;

		return 0;
	}

	function Disconnect()
	{
		$rc = 0;
		
		$rc = $this->m_sck->Disconnect();

		$this->m_saddr             = "";
		$this->m_id                = "";
		$this->m_pwd               = "";
		$this->m_copt              = "";

		return $rc;
	}

	function ClearOption()
	{
		$this->m_timeout_request   = 0;
		$this->m_timeout_linger    = 0;
		$this->m_3way_mode         = 0;
		$this->m_tcp_nodelay       = 0;
		
		return 0;
	}

	function SetOption( $para_name, $para_value )
	{
		$rc = 0;

		if(!strcmp($para_name, "TIMEOUT_REQUEST")) {
			$this->m_timeout_request = para_value;
		} else if(!strcmp($para_name, "TIMEOUT_LINGER")) {
			$this->m_timeout_linger = para_value;
		} else if(!strcmp($para_name, "3WAY_MODE")) {
			$this->m_3way_mode = para_value;
		} else if(!strcmp($para_name, "TCP_NODELAY")) {
			$this->m_tcp_nodelay = para_value;
		} else {
			$msg = "unknown option '%s' (C18732)".para_name;
			$rc = -1;
		}

		return $rc;
	}

	function SendRequest($para_crx_cmd, $para_request_size, $para_request_buf)
	{
		$rc = 0;

		$addr = "";
		$port = 0;

		$ba_out = "";

		$rc = my_Parse($this->m_saddr, $addr, $port);
		if ($rc < 0) {
			$this->m_msg = "invalid service address ''".$this->m_saddr."' (C18735)";
			return -1;
		}

		$rc = $this->m_sck->Connect($addr, $port);
		if ($rc < 0 ) {
			$this->m_msg = $this->m_sck->m_msg;
			return -1;
		}

		if ($this->m_timeout_linger > 0) {
			$rc = $this->m_sck->SetLingerTimeOut($this->m_timeout_linger);
		}

		$crx_request_size = 4+12+16+16+16+4+4+$para_request_size; // VERSION, padding, CLIENT_IP, ID, PWD, CRX_CMD, padding, request

		// ver
		$ver = 302010; // 3.2.10
		BA_writeInteger( $ba_out, $ver );
		// padding
		BA_writeNString( $ba_out, "", 12 );
		// ip
		$ip = $this->m_sck->GetIPv4SocketAddress();
		BA_writeNString( $ba_out, $ip, 16 );
		// id
		BA_writeNString( $ba_out, $this->m_id, 16 );
		// password
		BA_writeNString( $ba_out, $this->m_pwd, 16 );
		// cmd
		BA_writeInteger( $ba_out, $para_crx_cmd);
		//padding
		BA_writeNString( $ba_out, "", 4 );
		// request buffer
		BA_writeNString( $ba_out, $para_request_buf, $para_request_size );

		EncodeDecodeCrxRequest($crx_request_size, $ba_out);

		$this->m_request = $ba_out;
		$this->m_request_size = $crx_request_size;

		$rc = $this->m_sck->Send2(REXT_NORM, REQUEST_CRX, $this->m_request_size, $this->m_request, 1);
		if ($rc < 0 ) {
			$this->m_msg = $this->m_sck->m_msg;
			$this->m_sck->Disconnect();
			return -1;
		}

		$rc = 0;

		return $rc;
	}

	function PutRequest($para_request)
	{
		$rc = 0;

		$this->m_msg = "";

		$request_size = strlen($para_request) + 1;
		$request = $para_request . "\0";

		$rc = $this->SendRequest(CRX_REQUEST_XML, $request_size, $request);

		return $rc;
	}

	function ReadResponse()
	{
		$rc = 0;
		$svr_rc = 0;
		$data = "";
		$data_size = 0;

		if ($this->m_f_response_received == 1) {
			$rc = 0;
			$this->m_sck->Disconnect();
			return $rc;
		}

		if ($this->m_timeout_request > 0) {
			$this->m_sck->SetTimeOut($this->m_timeout_request, 0);
		}

		$rc = $this->m_sck->Recv($svr_rc, $data_size, $data);
		if ($rc) {
			$this->m_msg = $this->m_sck->m_msg;
			$this->m_sck->Disconnect();
			return $rc;
		}

		if ($this->m_3way_mode == 1) {
			$this->m_sck->Send1(0, "ACK", 3);
		}

		if ($svr_rc) {
			$this->m_msg = $data;
			$rc = $svr_rc;
			$this->m_sck->Disconnect();
			return $rc;
		}

		EncodeDecodeCrxRequest($data_size, $data);

		$location = 0;

		// 8-bytes, use first 4 bytes only
		$location = 4;
		$this->m_worker_time = bytes2int( $data, $location );
		$location = 16;
		$slen = bytes2str( $data, $location, 16 );
		$this->m_worker_address = substr( $data, $location, $slen);
		$this->m_response_size = $data_size - 72;
		$location = 72;
		$this->m_response = substr($data, $location);

		$this->m_f_response_received = 1;

		$this->m_sck->Disconnect();

		return 0;
	}

	function GetResponse(&$para_response)
	{
		$para_response = "";

		$rc = $this->ReadResponse();
		if ($rc < 0 ) {
			return $rc;
		}

		$para_response = $this->m_response;

		return 0;
	}

	/*-------------------------------------------------------------------------*/
	/*----------------------------- crx param api -----------------------------*/
	/*-------------------------------------------------------------------------*/

	function ClearRequest()
	{
		$this->m_request_size = 0;
		$this->m_request = "";

		$rc = $this->m_param->ClearRequest();
		if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
	}

	function PutRequestName($para_name)
	{
		$rc =  $this->m_param->SetRequestName($para_name);
		if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
	}
    function PutRequestFamily($para_family)
    {
    	$rc = $this->m_param->SetRequestFamily($para_family);
		if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
    }
    function PutRequestVersion($para_version)
    {
    	$rc = $this->m_param->SetRequestVersion($para_version);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
    }
    function PutRequestParam($para_param_name, $para_param_type, $para_element_count, $para_param_value)
    {
    	$rc = $this->m_param->SetRequestParam($para_param_name, $para_param_type, $para_element_count, $para_param_value);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc; 	
    }
    function PutRequestParam2D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_param_value)
    {
    	$rc = $this->m_param->SetRequestParam2D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_param_value);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
    }
    function PutRequestParam3D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value)
    {
    	$rc = $this->m_param->SetRequestParam3D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg; 
		
		return $rc;
    }

    function SubmitRequest()
    {
    	$rc = 0;
    	$request_size = 0;
    	$request = "";

    	$this->m_tv_begin = time();

    	$rc = $this->m_param->GetPackedRequest($request_size, $request);
    	if ($rc) {
    		$this->m_msg = $this->m_param->m_msg;
    		return -1;
    	}

		$this->m_f_response_received = 0;
		$rc = $this->SendRequest(CRX_REQUEST_UNIVERSAL_PARAMETER, $request_size, $request);

		return $rc;
    }
    function ReceiveResponse()
    {
    	$rc = 0;
    	
    	$rc = $this->ReadResponse();
    	if ($rc != 0) return -1;

    	
    	$rc = $this->m_param->SetPackedResponse($this->m_response_size, $this->m_response);
    	if ($rc != 0) {
    		$this->m_msg = $this->m_param->m_msg;
    		return -1;
    	}
    
    	$tv_end = time();
    	
    	$this->m_response_time = ($tv_end - $this->m_tv_begin);
    	
    	return $rc;
    }

    function GetWorkerAddress(&$para_address)
    {
    	$para_address = $this->m_worker_address;
    	return 0;
    }
    function GetWorkerTime(&$para_worker_time_ms)
    {
    	$para_worker_time_ms = $this->m_worker_time;
    	return 0;
    }
    function GetResponseTime(&$para_response_time_ms)
    {
    	$para_response_time_ms = $this->m_response_time;
    	return 0;
    }

    function GetResponseName(&$para_name)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseName($para_name);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseFamily(&$para_family)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseFamily($para_family);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseVersion(&$para_version)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseVersion($para_version);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseParamCount(&$para_param_count)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamCount($para_param_count);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }

    function GetResponseParamName(&$para_param_name, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamName($para_param_name, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseParamType(&$para_param_type, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamType($para_param_type, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseParamValueDimension(&$para_dimension, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamValueDimension($para_dimension, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }

    function GetResponseParamElementCount(&$para_element_count, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamElementCount($para_element_count, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseParamElementCount2D(&$para_2d_element_count, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamElementCount2D($para_2d_element_count, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    function GetResponseParamElementCount3D(&$para_3d_element_count, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamElementCount3D($para_3d_element_count, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }

    function GetResponseParamValue(&$para_param_value, $para_param_no)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamValue($para_param_value, $para_param_no);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    
    function GetResponseParamValueByName(&$para_param_value, $para_param_name)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->GetResponseParamValueByName($para_param_value, $para_param_name);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;
    }
    
    function PrintResponse($para_max_element_count)
    {
    	$rc = 0;
    	
    	$rc = $this->m_param->PrintResponse($para_max_element_count);
    	if ($rc != 0) $this->m_msg = $this->m_param->m_msg;
    	
    	return $rc;    	
    }



	//member variable
	var $m_msg;

	var $m_sck;
	var $m_adr;
	var $m_param;
	var $m_parser;

	var $m_saddr;
	var $m_id;
	var $m_pwd;
	var $m_copt;

	var $m_tv_begin;
	var $m_worker_address;
	var $m_worker_time;
	var $m_response_time;

	var $m_timeout_request;
	var $m_timeout_linger;
	var $m_3way_mode;
	var $m_tcp_nodelay;

	var $m_response_size;
	var $m_response;

	var $m_request_size;
	var $m_request;

	var $m_f_response_received;

}
?>
