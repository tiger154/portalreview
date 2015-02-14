<?php
/*
 * Created on 2009. 09. 07
 *
 * 서버와 crx로 통신하기 위한 클라이언트 API
 *
 * @version 1.1.0
 * @author 신동호, 박용기
 */

require("CrxMain.php");

function crx_connect(&$hd, $para_saddr, $para_id, $para_pwd, $para_copt)
{
	$hd = new CrxMain;

	$rc = $hd->Constructor();
	$rc = $hd->Connect($para_saddr, $para_id, $para_pwd, $para_copt);

	return $rc;
}

function crx_disconnect( &$hd )
{
	if($hd==NULL)
	{
		return -1;
	}

	$hd->Disconnect();
	$hd->Destructor();

	return 0;
}

function crx_get_error_message( &$hd )
{
	if($hd==NULL) {
		return "";
	}

	return $hd->GetMessage();
}

function crx_clear_option( &$hd )
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->ClearOption();
}

function crx_set_option( &$hd, $para_name, $para_value )
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->SetOption( $para_name, $para_value );
}

/*----------------------------------- xml api -----------------------------------*/

function crx_put_request( &$hd, $para_request )
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequest( $para_request );
}
function crx_get_response( &$hd, &$para_response )
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponse( $para_response );
}

/*----------------------------------- xml api -----------------------------------*/

function crx_clear_request(&$hd)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->ClearRequest();
}
function crx_put_request_name(&$hd, $para_name)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestName($para_name);
}
function crx_put_request_family(&$hd, $para_family)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestFamily($para_family);
}
function crx_put_request_version(&$hd, $para_version)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestVersion($para_version);
}

function crx_put_request_param(&$hd, $para_param_name, $para_param_type, $para_element_count, $para_param_value)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestParam($para_param_name, $para_param_type, $para_element_count, $para_param_value);
}
function crx_put_request_param_2d(&$hd, $para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_param_value)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestParam2D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_param_value);
}
function crx_put_request_param_3d(&$hd, $para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PutRequestParam3D($para_param_name, $para_param_type, $para_element_count, $para_2d_element_count, $para_3d_element_count, $para_param_value);
}

function crx_submit_request(&$hd)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->SubmitRequest();
}
function crx_receive_response(&$hd)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->ReceiveResponse();
}

function crx_get_worker_address(&$hd, &$para_address)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetWorkerAddress($para_address);
}
function crx_get_worker_time(&$hd, &$para_worker_time_ms)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetWorkerTime($para_worker_time_ms);
}
function crx_get_response_time(&$hd, &$para_response_time_ms)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseTime($para_response_time_ms);
}

function crx_get_response_name(&$hd, &$para_name)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseName($para_name);
}
function crx_get_response_family(&$hd, &$para_family)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseFamily($para_family);
}
function crx_get_response_version(&$hd, &$para_version)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseVersion($para_version);
}
function crx_get_response_param_count(&$hd, &$para_param_count)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamCount($para_param_count);
}

function crx_get_response_param_name(&$hd, &$para_param_name, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamName($para_param_name, $para_param_no);
}
function crx_get_response_param_type(&$hd, &$para_param_type, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamType($para_param_type, $para_param_no);
}
function crx_get_response_param_value_dimension(&$hd, &$para_dimension, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamValueDimension($para_dimension, $para_param_no);
}

function crx_get_response_param_element_count(&$hd, &$para_element_count, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamElementCount($para_element_count, $para_param_no);
}
function crx_get_response_param_element_count_2d(&$hd, &$para_2d_element_count, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamElementCount2D($para_2d_element_count, $para_param_no);
}
function crx_get_response_param_element_count_3d(&$hd, &$para_3d_element_count, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamElementCount3D($para_3d_element_count, $para_param_no);
}

function crx_get_response_param_value(&$hd, &$para_param_value, $para_param_no)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamValue($para_param_value, $para_param_no);
}

function crx_get_response_param_value_by_name(&$hd, &$para_param_value, $para_param_name)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->GetResponseParamValueByName($para_param_value, $para_param_name);
}

function crx_print_response(&$hd, $para_max_element_count)
{
	if( $hd == NULL ) {
		return -1;
	}

	return $hd->PrintResponse($para_max_element_count);
}

?>
