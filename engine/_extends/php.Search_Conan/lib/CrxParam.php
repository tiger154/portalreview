<?php
/*
 * Created on 2009. 09. 07
 *
 * 서버와 crx로 통신하기 위한 클라이언트 API
 *
 * @version 1.1.0
 * @author 신동호, 박용기
 */
 
 require_once('CrxUtil.php');
 

class CrxParamStruc
{
	var $m_name;
	var $m_type;
	var $m_dimension;
	var $m_element_count;
	var $m_2d_element_count;
	var $m_3d_element_count;
	var $m_value;
}

class CrxParam
{
	function InitMemberVariable()
	{
		$m_pck = '';
		$m_req_param = NULL;

		$m_request_name = '';
		$m_request_family = '';
		$m_request_version = '';

		$m_response_name = '';
		$m_response_family = '';
		$m_response_version = '';
		$m_response_param_count = 0;
		$m_response_param = NULL;
		
		$m_msg = '';

		return 0;
	}

	function Constructor()
	{
		return $this->InitMemberVariable();
	}

	function Destructor()
	{
		return $this->InitMemberVariable();
	}

	function ReleaseResource($para_resource_limit)
	{
		return $this->InitMemberVariable();
	}

	function ClearRequest()
	{
		return $this->InitMemberVariable();
	}

    function SetRequestName($para_name)
    {
    	$this->m_request_name = $para_name;

    	return 0;
    }
    function SetRequestFamily($para_family)
    {
    	$this->m_request_family = $para_family;

    	return 0;
    }
    function SetRequestVersion($para_version)
    {
    	$this->m_request_version = $para_version;

    	return 0;
    }
    function AddParamStruc($para_param_name, $para_param_type, $para_dimension, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value)
    {
    	$rc = 0;
    	$i = 0;

    	$param = new CrxParamStruc;

    	$param->m_name = $para_param_name;
    	$param->m_type = $para_param_type;
    	$param->m_dimension = $para_dimension;
    	$param->m_element_count = $para_element_count;
    	$param->m_2d_element_count = $para_2d_element_count;
    	$param->m_3d_element_count = $para_3d_element_count;
    	$param->m_value = $para_param_value;

    	$this->m_req_param[] = $param;

    	return 0;
    }
    function SetRequestParam($para_param_name, $para_param_type, $para_element_count, $para_param_value)
    {
    	return $this->AddParamStruc($para_param_name, $para_param_type, 1, $para_element_count, NULL, NULL, $para_param_value);
    }
    function SetRequestParam2D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_param_value)
    {
    	return $this->AddParamStruc($para_param_name, $para_param_type, 2, $para_element_count, $para_2d_element_count, NULL, $para_param_value);
    }
    function SetRequestParam3D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value)
    {
    	return $this->AddParamStruc($para_param_name, $para_param_type, 3, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value);
    }
    
    function ParamToBytes1D(&$para_bytes, $para_type, $para_element_count, $para_value)
    {
    	$i = 0;
    	
    	if (count($para_value) == 1) {
    		
    		if ($para_type == 'CHAR' || $para_type == 'UCHAR') {
    			if (!is_string($para_value)) {
    				$this->m_msg = 'param_value is not string type (C14001)';
    				return -1;
    			}
    			BA_writeString($para_bytes, $para_value);
    		}
    		else if ($para_type == 'BYTE' || $para_type == 'INT8' || $para_type == 'UINT8') {
    			if (!is_numeric($para_value)) {
    				$this->m_msg = 'param_value is not numeric type (C14002)';
    				return -1;
    			}
    			BA_writeByte($para_bytes, $para_value);
    		}
    		else if ($para_type == 'INT16' || $para_type == 'UINT16') {
    			if (!is_numeric($para_value)) {
    				$this->m_msg = 'param_value is not numeric type (C14003)';
    				return -1;
    			}
    			BA_writeShort($para_bytes, $para_value);
    		}
    		else if ($para_type == 'INT32' || $para_type == 'UINT32') {
    			if (!is_numeric($para_value)) {
    				$this->m_msg = 'param_value is not numeric type (C14004)';
    				return -1;
    			}
    			BA_writeInteger($para_bytes, $para_value);
    		}
    		else if ($para_type == 'INT64' || $para_type == 'UINT64') {
    			if (!is_numeric($para_value)) {
    				$this->m_msg = 'param_value is not numeric type (C14005)';
    				return -1;
    			}
    			BA_writeLong($para_bytes, $para_value);
    		}
    	}
    	else {
    		for ($i = 0; $i<$para_element_count; $i++)
    		{
	    		if ($para_type == 'CHAR' || $para_type == 'UCHAR') {
	    			if (!is_string($para_value[$i])) {
    					$this->m_msg = 'param_value is not string type (C14006)';
    					return -1;
    				}
	    			BA_writeString($para_bytes, $para_value[$i]);
	    		}
	    		else if ($para_type == 'BYTE' || $para_type == 'INT8' || $para_type == 'UINT8') {
	    			if (!is_numeric($para_value[$i])) {
    					$this->m_msg = 'param_value is not numeric type (C14007)';
    					return -1;
    				}
	    			BA_writeByte($para_bytes, $para_value[$i]);
	    		}
	    		else if ($para_type == 'INT16' || $para_type == 'UINT16') {
	    			if (!is_numeric($para_value[$i])) {
    					$this->m_msg = 'param_value is not numeric type (C14008)';
    					return -1;
    				}
	    			BA_writeShort($para_bytes, $para_value[$i]);
	    		}
	    		else if ($para_type == 'INT32' || $para_type == 'UINT32') {
	    			if (!is_numeric($para_value[$i])) {
    					$this->m_msg = 'param_value is not numeric type (C14009)';
    					return -1;
    				}
	    			BA_writeInteger($para_bytes, $para_value[$i]);
	    		}
	    		else if ($para_type == 'INT64' || $para_type == 'UINT64') {
	    			if (!is_numeric($para_value[$i])) {
    					$this->m_msg = 'param_value is not numeric type (C14010)';
    					return -1;
    				}
	    			BA_writeLong($para_bytes, $para_value[$i]);
	    		}
    		}
    	}

		return 0;
    }
    
    function ParamToBytes(&$para_bytes, $para_idx)
    {
    	$rc = 0;
    	$i = 0;
    	$j = 0;
    	
		// m_name
		BA_writeString($para_bytes, $this->m_req_param[$para_idx]->m_name);
		
		// m_type
		BA_writeString($para_bytes, $this->m_req_param[$para_idx]->m_type);
		
		// align
    	BA_writeAlignSize($para_bytes);
    	
    	// m_dimension
    	BA_writeInteger($para_bytes, $this->m_req_param[$para_idx]->m_dimension);
    	
    	// m_element_count
    	BA_writeInteger($para_bytes, $this->m_req_param[$para_idx]->m_element_count);
    	
    	// m_2d_element_count
    	if ($this->m_req_param[$para_idx]->m_dimension >= 2) {
    		if ($this->m_req_param[$para_idx]->m_element_count != count($this->m_req_param[$para_idx]->m_2d_element_count)) {
    			$this->m_msg = 'wrong size or dimension para_2d_element_count (C14101)';
    			return -1;
    		}
    		
    		for($i=0; $i < $this->m_req_param[$para_idx]->m_element_count; $i++)
    		{
    			BA_writeInteger($para_bytes, $this->m_req_param[$para_idx]->m_2d_element_count[$i]);
    		}
    	}
    	
    	// m_3d_element_count
    	if ($this->m_req_param[$para_idx]->m_dimension >= 3) {
			if ($this->m_req_param[$para_idx]->m_element_count != count($this->m_req_param[$para_idx]->m_3d_element_count)) {
    			$this->m_msg = 'wrong para_3d_element_count (C14102)';
    			return -1;
    		}
    		
    		for($i=0; $i < $this->m_req_param[$para_idx]->m_element_count; $i++)
    		{
    			if ($this->m_req_param[$para_idx]->m_2d_element_count[$i] != count($this->m_req_param[$para_idx]->m_3d_element_count[$i])) {
    				$this->m_msg = 'wrong para_3d_element_count (C14103)';
    				return -1;
    			}
    			
    			for($j=0; $j < $this->m_req_param[$para_idx]->m_2d_element_count[$i]; $j++)
    			{
    				BA_writeInteger($para_bytes, $this->m_req_param[$para_idx]->m_3d_element_count[i][j]);	
    			}
    		}
    	}
    	
    	// m_value
    	if ($this->m_req_param[$para_idx]->m_dimension == 1) {
    		$rc = $this->ParamToBytes1D($para_bytes, $this->m_req_param[$para_idx]->m_type, 
    			$this->m_req_param[$para_idx]->m_element_count, $this->m_req_param[$para_idx]->m_value);
    		if ($rc != 0) return -1; 
    	}
    	else if ($this->m_req_param[$para_idx]->m_dimension == 2) {
     		for($i=0; $i < $this->m_req_param[$para_idx]->m_element_count; $i++)
    		{
    			$rc = $this->ParamToBytes1D($para_bytes, $this->m_req_param[$para_idx]->m_type, 
    				$this->m_req_param[$para_idx]->m_2d_element_count[$i], $this->m_req_param[$para_idx]->m_value[$i]); 
    			if ($rc != 0) return -1;    			
    		}   		
    	}
    	else if ($this->m_req_param[$para_idx]->m_dimension == 3) {
     		for($i=0; $i < $this->m_req_param[$para_idx]->m_element_count; $i++)
    		{
    			for($j=0; $j < $this->m_req_param[$para_idx]->m_2d_element_count[$i]; $j++)
    			{
    				$rc = $this->ParamToBytes1D($para_bytes, $this->m_req_param[$para_idx]->m_type, 
    					$this->m_req_param[$para_idx]->m_3d_element_count[$i][$j], $this->m_req_param[$para_idx]->m_value[$i][$j]);
    				if ($rc != 0) return -1;   	
    			}
    		}   		
    	}
    	
		// align
    	BA_writeAlignSize($para_bytes);    	
    	
    	return 0;
    }

    function GetPackedRequest(&$para_p_request_size, &$para_pp_request)
    {
    	$rc = 0;
    	$i = 0;
    	$cnt = 0;
    	$param_bytes = '';
    	
    	if ($this->m_request_name == NULL) {
			$this->m_msg = 'request name not specified (C14283)';
			return -1;
    	}
    	
    	if ($this->m_request_family == NULL) {
			$this->m_msg = 'request family not specified (C14284)';
			return -1;
    	}
    	
    	if ($this->m_request_version == NULL) {
    		$this->m_request_version = '';
    	}
    	
    	// m_request_name
    	BA_writeString($param_bytes, $this->m_request_name);
    	
      	// m_request_family
    	BA_writeString($param_bytes, $this->m_request_family);
    	
    	// m_request_version
    	BA_writeString($param_bytes, $this->m_request_version);
    	
    	// align
    	BA_writeAlignSize($param_bytes);
    	
    	$cnt = count($this->m_req_param);
    	
    	// param_value_count
    	BA_writeInteger($param_bytes, $cnt);
    	
    	// align
    	BA_writeAlignSize($param_bytes);
    	
    	for($i=0; $i<$cnt; $i++) {
    		$rc = $this->ParamToBytes($param_bytes, $i);
    		if ($rc != 0) {
    			return -1;
    		} 
    	}
    	
    	$para_p_request_size = strlen($param_bytes);
    	$para_pp_request = $param_bytes;
    	    	
    	return 0;
    }
    
    function ResolveParamValue1D($para_type, $para_element_count, $para_response_size, $para_response_buf, &$para_offset)
    {
    	$rc = 0;
    	$i = 0;
    	$slen = 0;
    	
    	$param_value = NULL;

	    if ($para_type == 'CHAR' || $para_type == 'UCHAR') {
	    	$slen = bytes2str($para_response_buf, $para_offset, $para_response_size);
	    	$param_value = substr($para_response_buf, $para_offset, $slen);
	    	$para_offset += ($slen+1);
		}
		else if ($para_type == 'BYTE' || $para_type == 'INT8' || $para_type == 'UINT8') {
			$param_value = array();
			for($i=0; $i<$para_element_count; $i++) {
				$param_value[$i] = bytes2byte($para_response_buf, $para_offset);
	    		$para_offset += 1;
			}
		}
		else if ($para_type == 'INT16' || $para_type == 'UINT16') {
			$param_value = array();
			for($i=0; $i<$para_element_count; $i++) {
				$param_value[$i] = bytes2short($para_response_buf, $para_offset);
    			$para_offset += 2;
			}
		}
		else if ($para_type == 'INT32' || $para_type == 'UINT32') {
			$param_value = array();
			for($i=0; $i<$para_element_count; $i++) {
				$param_value[$i] = bytes2int($para_response_buf, $para_offset);
    			$para_offset += 4;
			}
		}
		else if ($para_type == 'INT64' || $para_type == 'UINT64') {
			$param_value = array();
			for($i=0; $i<$para_element_count; $i++) {
				$param_value[$i] = bytes2long($para_response_buf, $para_offset);
    			$para_offset += 8;
			}
		}
		
		return $param_value;
    }
    
    function GetParamStruc($para_response_size, $para_response_buf, &$para_offset)
    {
    	$rc = 0;
    	$i = 0;
    	$j = 0;
    	
    	$param = new CrxParamStruc;

		//m_name		
    	$slen = bytes2str($para_response_buf, $para_offset, $para_response_size);
    	$param->m_name = substr($para_response_buf, $para_offset, $slen);
    	$para_offset += ($slen+1);

		//m_type		
    	$slen = bytes2str($para_response_buf, $para_offset, $para_response_size);
    	$param->m_type = substr($para_response_buf, $para_offset, $slen);
    	$para_offset += ($slen+1);

    	//align
    	$para_offset += alignWordSize($para_offset);

    	//m_dimension
    	$param->m_dimension = bytes2int($para_response_buf, $para_offset);
    	$para_offset += 4;

    	//m_element_count
    	$param->m_element_count = bytes2int($para_response_buf, $para_offset);
    	$para_offset += 4;

		//m_2d_element_count
		$param->m_2d_element_count = NULL;
		if ($param->m_dimension >= 2) {
			$param->m_2d_element_count = array();
			
			for($i=0; $i<$param->m_element_count; $i++)
			{
				$param->m_2d_element_count[$i] = bytes2int($para_response_buf, $para_offset);
				$para_offset += 4;
			}
		}
		
		//m_3d_element_count
		$param->m_3d_element_count = NULL;
		if ($param->m_dimension >= 3) {
			$param->m_3d_element_count = array();
			
			for($i=0; $i<$param->m_element_count; $i++)
			{
				$param->m_3d_element_count[$i] = array();
				for($j=0; $j<$param->m_2d_element_count[$i]; $j++)
				{
					$param->m_3d_element_count[$i][$j] = bytes2int($para_response_buf, $para_offset);
					$para_offset += 4;	
				}
			}
		}
		
		//m_value
    	if ($param->m_dimension == 1) {
    		$param->m_value = 
    			$this->ResolveParamValue1D($param->m_type, $param->m_element_count, $para_response_size, $para_response_buf, $para_offset);
    	}
    	else if ($param->m_dimension == 2) {
    		$param->m_value = array();
     		for($i=0; $i < $param->m_element_count; $i++)
    		{
    			$param->m_value[$i] = 
    				$this->ResolveParamValue1D($param->m_type, $param->m_2d_element_count[$i], $para_response_size, $para_response_buf, $para_offset);
    		}   		
    	}
    	else if ($param->m_dimension == 3) {
    		$param->m_value = array();
     		for($i=0; $i < $param->m_element_count; $i++)
    		{
    			$param->m_value[$i][$j] = array();
    			for($j=0; $j < $param->m_2d_element_count[$i]; $j++)
    			{
    				//$param->m_value[$i][$j] = NULL;
    				$param->m_value[$i][$j] = 
    					$this->ResolveParamValue1D($param->m_type, $param->m_3d_element_count[$i][$j], $para_response_size, $para_response_buf, $para_offset);
    			}
    		}   		
    	}
    	
    	//align
    	$para_offset += alignWordSize($para_offset);

		return $param;
    }

    function SetPackedResponse($para_response_size, $para_response_buf)
    {
    	$rc = 0;
    	$i = 0;
    	$param_count = 0;
    	$slen = 0;
    	$offset = 0;
    	
    	$this->ClearRequest();
    	
    	//response_name
    	$slen = bytes2str($para_response_buf, $offset, $para_response_size);
    	$this->m_response_name = substr($para_response_buf, $offset, $slen);
    	$offset += ($slen+1);
    	
    	//response_family
    	$slen = bytes2str($para_response_buf, $offset, $para_response_size);
    	$this->m_response_family = substr($para_response_buf, $offset, $slen);
    	$offset += ($slen+1);
    	
    	//response_version
    	$slen = bytes2str($para_response_buf, $offset, $para_response_size);
    	$this->m_response_version = substr($para_response_buf, $offset, $slen);
    	$offset += ($slen+1);
    	
    	//align
    	$offset += alignWordSize($offset);
    	
    	//param_count
    	$param_count = bytes2int($para_response_buf, $offset);
    	$offset += 4;

    	//align
    	$offset += alignWordSize($offset);
    	
		if ($param_count > 0) {
			$this->m_response_param = array();
			
			for ($i = 0; $i < $param_count; $i++)
			{
				$this->m_response_param[$i] = $this->GetParamStruc($para_response_size, $para_response_buf, $offset);
				if ($this->m_response_param[$i] == NULL) {
					return -1;
				}
			}
		}
		else {
			$this->m_response_param = NULL;
		}
		
		$this->m_response_param_count = $param_count;
    	
    	return $rc;
    }

    function GetResponseName(&$para_name)
    {
    	$para_name = $this->m_response_name;
    	return 0;
    }
    function GetResponseFamily(&$para_family)
    {
    	$para_family = $this->m_response_family;
    	return 0;
    }
    function GetResponseVersion(&$para_version)
    {
    	$para_version = $this->m_response_version;
    	return 0;
    }
    function GetResponseParamCount(&$para_param_count)
    {
    	$para_param_count = $this->m_response_param_count;
    	return 0;
    }

    function GetResponseParamName(&$para_param_name, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14401)';
    		return -1;
    	}
    	$para_param_name = $this->m_response_param[$para_param_no]->m_name;
    	return 0;
    }
    function GetResponseParamType(&$para_param_type, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14402)';
    		return -1;
    	}
    	$para_param_type = $this->m_response_param[$para_param_no]->m_type;
    	return 0;
    }
    function GetResponseParamValueDimension(&$para_dimension, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14403)';
    		return -1;
    	}
    	$para_dimension = $this->m_response_param[$para_param_no]->m_dimension;
    	return 0;
    }

    function GetResponseParamElementCount(&$para_element_count, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14404)';
    		return -1;
    	}
    	$para_element_count = $this->m_response_param[$para_param_no]->m_element_count;
    	return 0;
    }
    function GetResponseParamElementCount2D(&$para_2d_element_count, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14405)';
    		return -1;
    	}
    	$para_2d_element_count = $this->m_response_param[$para_param_no]->m_2d_element_count;
    	return 0;
    }
    function GetResponseParamElementCount3D(&$para_3d_element_count, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14406)';
    		return -1;
    	}
    	$para_3d_element_count = $this->m_response_param[$para_param_no]->m_3d_element_count;
    	return 0;
    }

    function GetResponseParamValue(&$para_param_value, $para_param_no)
    {
    	if ($para_param_no < 0 || $para_param_no>=$this->m_response_param_count) {
    		$this->m_msg = 'param_no out of range (' . $para_param_no . ', ' . $this->m_response_param_count . ') (C14407)';
    		return -1;
    	}
    	$para_param_value = $this->m_response_param[$para_param_no]->m_value;
    	return 0;
    }
    
    function GetResponseParamValueByName(&$para_param_value, $para_param_name)
    {
    	$rc = 0;
    	$i = 0;
    	$param_no = 0;
    	
    	$found = 0;
    	
    	for($i=0; $i<$this->m_response_param_count; $i++)
    	{
    		if($para_param_name == $this->m_response_param[$i]->m_name) {
    			$param_no = $i;
    			$found++;
    		}
    	}
    	
    	if ($found == 0) {
    		$rc = -1;
    		$this->m_msg = 'no param name exists. ('.$para_param_name.') (C14408)';
    		return -1;
    	}
    	else if ($found > 1) {
    		$rc = -1;
    		$this->m_msg = $found.'param name exists. (C14409)';
    		return -1;
    	}
    	
    	$para_param_value = $this->m_response_param[$param_no]->m_value;
    	return 0;
    }
    
    function PrintResponse($para_max_element_count)
    {
		$rc = 0;
		$i = 0;
		$j = 0;
		$k = 0;
		$l = 0;
		$name = NULL;
		$family = NULL;
		$param_count = 0;
		
		$param_name = NULL;
		$param_type = NULL;
		$param_dimension = 0;
		$element_count = 0;
		$element_2d_count = NULL;
		$element_3d_count = NULL;
		$param_value = NULL;
	
		$rc = $this->GetResponseName($name);
		if($rc) return -1;
	
		printf("+--------------------------------------------------------------------------+\n");
		printf("| CRX response name        = '%s'\n", $name);
	
		$rc = $this->GetResponseFamily($family);
		if($rc) return -1;
	
		printf("| CRX response family      = '%s'\n", $family);
	
		$rc = $this->GetResponseParamCount($param_count);
		if($rc) return -1;
	
		printf("| CRX response param count = %d\n", $param_count);
		printf("+--------------------------------------------------------------------------+\n");
	
		for($i=0;$i<$param_count;$i++) {
			$rc = $this->GetResponseParamName($param_name, $i);
			if($rc) return -1;
	
			$rc = $this->GetResponseParamType($param_type, $i);
			if($rc) return -1;
	
			$rc = $this->GetResponseParamValueDimension($param_dimension, $i);
			if($rc) return -1;
	
			$rc = $this->GetResponseParamElementCount($element_count, $i);
			if($rc) return -1;
	
			printf("[%d] param : name='%s', type='%s', dimension=%d, element_count=%d\n", $i, $param_name, $param_type, $param_dimension, $element_count);

			$rc = $this->GetResponseParamElementCount2D($element_2d_count, $i);
			if($rc) return -1;

			$rc = $this->GetResponseParamElementCount3D($element_3d_count, $i);
			if($rc) return -1;
	
			$rc = $this->GetResponseParamValue($param_value, $i);
			if($rc) return -1;
	
			if ($param_dimension == 1) {
				if ($param_type == 'CHAR') {
					printf("%s\n", $param_value);
				}
				else {
					echo "\t";
					for($j=0; is_array($param_value) && $j<$element_count; $j++) {
						echo $param_value[$j].' ';
					}
					echo "\n";
				}
			} else if ($param_dimension == 2) {
				if ($param_type == 'CHAR') {
					for($j=0; is_array($param_value) && $j<$element_count; $j++) {
						printf("%s\n", $param_value[$j]);
					}
				}
				else {
					for($j=0; is_array($param_value) && $j<$element_count; $j++) {
						echo "\t";
						for($k=0; is_array($param_value[$j]) && $k<$element_2d_count[$j]; $k++) {
							echo $param_value[$j][$k].' ';
						}
						echo "\n";
					}
				}
			} else if ($param_dimension == 3) {
				if ($param_type == 'CHAR') {
					for($j=0; is_array($param_value) && $j<$element_count; $j++) {
						echo "\t";
						for($k=0; is_array($param_value[$j]) && $k<$element_2d_count[$j]; $k++) {
							printf("%s\t", $param_value[$j][$k]);
						}
						echo "\n";
					}
				}

			} else {
				$this->m_msg = 'unknown param dimension '.$param_dimension.' (C81475)';
				return -1;
			}
	
			printf("+--------------------------------------------------------------------------+\n");
		}
		
		return 0;
    }

	// member variable
	var $m_pck;
	var $m_req_param;

	var $m_request_name;
	var $m_request_family;
	var $m_request_version;

	var $m_response_name;
	var $m_response_family;
	var $m_response_version;
	var $m_response_param_count;
	var $m_response_param;
	
	var $m_msg;

}

?>
