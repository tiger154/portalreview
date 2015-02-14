<?php
// VERSION: 3.6.x

define("eOK",             0);
define("eERR",           -1);
define("eTIMEOUT",       -2);
define("eONUPDATE",      -3);
define("eSERVICESTOP",   -4);
define("eNETWORKERR",    -5);

define("REQUEST_SUBMIT_QUERY", 1);

define("REQUEST_EXTRACT_KEYWORD", 17);
define("REQUEST_EXTRACT_KEYWORD2", 27);

define("REQUEST_INSERT", 32);
define("REQUEST_DELETE", 33);
define("REQUEST_UPDATE", 34);
define("REQUEST_SEARCH", 35);

define("REQUEST_MODULE_LOAD", 39);
define("REQUEST_MODULE_UNLOAD", 40);
define("REQUEST_MODULE_RELOAD", 41);

define("REQUEST_GET_QUERY_ATTRIBUTE", 48);
define("REQUEST_COMPLETE_KEYWORD", 49);
define("REQUEST_SPELL_CHECK", 50);
define("REQUEST_RECOMMEND_KEYWORD", 51);
define("REQUEST_GET_POPULAR_KEYWORD", 52);
define("REQUEST_ANCHOR_TEXT", 53);
define("REQUEST_GET_SYNONYM_LIST", 54);
define("REQUEST_GET_REAL_TIME_POPULAR_KEYWORD", 55);
define("REQUEST_CENSOR_SEARCH_WORDS", 56);
define("REQUEST_TRANSLITERATE", 57);
define("REQUEST_FILTER_TEXT", 58);
define("REQUEST_PUT_CACHE", 59);
define("REQUEST_GET_CACHE", 60);

//define("g_xor_key",      0xA9CD3981);//2.10.2
//define("g_xor_key",      0xA9CD1981);//2.11.x
define("g_xor_key0", 0xA9);
define("g_xor_key1", 0xCD);
define("g_xor_key2", 0x19);
define("g_xor_key3", 0x81);

// query expand flag
define("QEXP_K2K", 0x01);
define("QEXP_K2E", 0x02);
define("QEXP_E2E", 0x04);
define("QEXP_E2K", 0x08);
define("QEXP_TRL", 0x10);
define("QEXP_RCM", 0x20);

// set option flag
define("OPTION_SOCKET_TIMEOUT_REQUEST",	1);
define("OPTION_SOCKET_TIMEOUT_LINGER",	2);
define("OPTION_SOCKET_3WAY_MODE",		3);
define("OPTION_SOCKET_ASYNC_REQUEST",	4);
define("OPTION_SOCKET_CONNECTION_TIMEOUT_MSEC", 6); //(issue#425) connect()에 timeout기능 추가
define("OPTION_REQUEST_PRIORITY",		10);
define("OPTION_REQUEST_CHARSET_UTF8",	11);
define("OPTION_RETRY_ON_NETWORK_ERROR",	20);
define("OPTION_REPORT_CLIENT_ERROR",	30);

// query attribute flag
define("QPP_OP_NONE", 0);
define("QPP_OP_EQ", 1);
define("QPP_OP_LT", 2);
define("QPP_OP_LE", 3);
define("QPP_OP_GT", 4);
define("QPP_OP_GE", 5);
define("QPP_DOMAIN_NONE", 0);
define("QPP_DOMAIN_CAR", 1);


class CrzClient
{
function CrzClient()
{
	$this->m_msg = "";

	$this->ClearSearchCondition();
	$this->ClearSearchResult();

	$this->m_socket = FALSE;
	$this->m_timeout = 5*60;

	$this->m_authcode = "";
	$this->m_log = "";

	// set option parameters
	$this->m_linger_timeout = 0;
	$this->m_use_socket_3way_mode = 0;
	$this->m_request_timeout = 15;
	$this->m_request_priority = 0;
	$this->m_retry_on_network_error = 0;
	$this->m_connection_timeout_msec = -1;
}

function Cleanup()
{
	$this->m_authcode = "";
	$this->m_log = "";
	$this->ClearSearchCondition();
	$this->ClearSearchResult();
}

function ClearNetworkStatistics()
{
	$this->m_n_connect			= 0;
	$this->m_n_err_connect		= 0;
	$this->m_n_err_send			= 0;
	$this->m_n_err_recv			= 0;
	$this->m_n_err_acpt_full	= 0;
	$this->m_n_err_cli_recv		= 0;
	$this->m_n_err_recv_full	= 0;
	$this->m_n_err_timeout		= 0;
}

function GetMessage()
{
	return $this->m_msg;
}
function SetTimeOut($sec)
{
	if($sec<0) return -1;
	$this->m_timeout = $sec;
	return 0;
}

//----- clear condition/result -----------

function ClearSearchCondition()
{
	$this->m_max_n_cluster = 0;
	$this->m_max_n_clu_record = 0;
	$this->m_field_list = "";

	$this->m_prev_title = NULL;
	//$this->m_n_prev_title = 0;
	$this->m_key_list = NULL;
	$this->m_clu_flag = 0;

	$this->m_max_n_related_term = 0;

	$this->m_exp_query = NULL;
	$this->m_exp_flag = 0;
}

function ClearSearchResult()
{
	$this->m_f_data_received = 0;

	$this->m_searchTime = 0;

	$this->m_n_total = 0;
	$this->m_n_row = 0;
	$this->m_n_col = 0;

	$this->m_record_no = NULL;
	$this->m_score = NULL;

	$this->m_field_data = NULL;
	$this->m_field_size = NULL;

	$this->m_n_out_cluster = 0;
	$this->m_out_rec_cnt_per_class = NULL;
	$this->m_out_class_record_no = NULL;

	$this->m_n_rec_term = 0;
	$this->m_rec_term = NULL;

	$this->m_n_exp_k2k = 0;
	$this->m_exp_k2k = NULL;
	$this->m_n_exp_k2e = 0;
	$this->m_exp_k2e = NULL;
	$this->m_n_exp_e2k = 0;
	$this->m_exp_e2k = NULL;
	$this->m_n_exp_e2e = 0;
	$this->m_exp_e2e = NULL;
	$this->m_n_exp_trl = 0;
	$this->m_exp_trl = NULL;
	$this->m_n_exp_rcm = 0;
	$this->m_exp_rcm = NULL;

	$this->m_matchfield = NULL;
	$this->m_userkey_idx = NULL;
	$this->m_f_function_type = 0;
}

//----- set condition -----------

function SetClusterCondition(
	$nMaxCluster, $nMaxRecordToCluster,
	$fieldList, $prevTitle, $keyList, $nFlag )
{
	$this->m_max_n_cluster = $nMaxCluster;
	$this->m_max_n_clu_record = $nMaxRecordToCluster;
	$this->m_field_list = $fieldList;

	$this->m_prev_title = array();
	for( $i=0; $i<sizeof($prevTitle); $i++ )
		$this->m_prev_title[$i] = $prevTitle[$i];

	$this->m_key_list = $keyList;
	$this->m_clu_flag = $nFlag;
}

function SetRelatedTermCondition( $num )
{
	$this->m_max_n_related_term = $num;
}
function SetExpandQueryCondition( $query, $nFlag )
{
	$this->m_exp_query = $query;
	$this->m_exp_flag = $nFlag;
}

function SetOption( $nOpt, $nVal )
{
	$rc = 0;

	switch($nOpt) {
		case OPTION_SOCKET_TIMEOUT_REQUEST:
			$this->m_request_timeout = $nVal;
			break;
		case OPTION_SOCKET_TIMEOUT_LINGER:
			$this->m_linger_timeout = $nVal;
			break;
		case OPTION_SOCKET_3WAY_MODE:
			// not implemented
			$this->m_use_socket_3way_mode = $nVal;
			break;
		case OPTION_SOCKET_ASYNC_REQUEST:
			$this->m_socket_async_request = $nVal;
			break;
		case OPTION_REQUEST_PRIORITY:
			$this->m_request_priority = $nVal;
			break;
		case OPTION_REQUEST_CHARSET_UTF8:
			$this->m_msg = "specified option not available in PHP";
			$rc = -1;
			break;
		case OPTION_RETRY_ON_NETWORK_ERROR:
			$this->m_retry_on_network_error = $nVal;
			break;
		case OPTION_REPORT_CLIENT_ERROR:
			// not implemented yet
			break;
		case OPTION_SOCKET_CONNECTION_TIMEOUT_MSEC:
			$this->m_connection_timeout_msec = $nVal;
			break;
		default:
			break;
	}

	return $rc;
}

//----- main API -----------

//----- submitquery -----------

function SubmitQuery(
	$saddr, $port,
	$authCode, $logInfo, $scn,
	$whereClause, $sortClause, $highlight,
	$startOffset, $count, $language, $charset )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();
	$this->ClearSearchResult();

	$ba_out = "";

	$snd_data_size = 13*4
		+ 8
		+ strlen($authCode)
		+ strlen($logInfo)
		+ strlen($scn)
		+ strlen($whereClause)
		+ strlen($sortClause)
		+ strlen($highlight)
		+ strlen($this->m_field_list)
		+ strlen($this->m_key_list);

	for($i=0;$i<sizeof($this->m_prev_title);$i++) {
		$snd_data_size += strlen($this->m_prev_title[$i]) + 1;
	}

	//expand query를 위해 추가된 부분
	$snd_data_size += $this->alignWordSize($snd_data_size);
	$snd_data_size += 4;
	$snd_data_size += (strlen($this->m_exp_query) + 1);

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_SUBMIT_QUERY ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $this->m_max_n_cluster);
	$this->BA_writeInteger( $ba_out, $this->m_max_n_clu_record );
	$this->BA_writeInteger( $ba_out, $this->m_prev_title==NULL ? 0 : sizeof($this->m_prev_title) );
	$this->BA_writeInteger( $ba_out, $this->m_clu_flag );
	$this->BA_writeInteger( $ba_out, $startOffset );
	$this->BA_writeInteger( $ba_out, $count );
	$this->BA_writeInteger( $ba_out, $this->m_max_n_related_term );
	$this->BA_writeInteger( $ba_out, $language );
	$this->BA_writeInteger( $ba_out, $charset );

	// string data
	$this->BA_writeString( $ba_out, $authCode );
	$this->BA_writeString( $ba_out, $logInfo );
	$this->BA_writeString( $ba_out, $scn );
	$this->BA_writeString( $ba_out, $whereClause );
	$this->BA_writeString( $ba_out, $sortClause );
	$this->BA_writeString( $ba_out, $highlight );
	$this->BA_writeString( $ba_out, $this->m_field_list );
	$this->BA_writeString( $ba_out, $this->m_key_list );

	if( $this->m_prev_title != NULL ) {
		for( $i=0; $i<sizeof($this->m_prev_title); $i++ )
			$this->BA_writeString( $ba_out, $this->m_prev_title[$i] );
	}

	//for expand query

	// align
	$align_size = $this->alignWordSize(strlen($ba_out));

	$dataToSend = $ba_out;
	for($i=0; $i < $align_size; $i++)
	{
		$this->BA_writeNull($ba_out);
	}

	$this->BA_writeInteger( $ba_out, $this->m_exp_flag );
	if($this->m_exp_flag==0)
	{
		$this->BA_writeNull( $ba_out );
	} else
	{
		$this->BA_writeString( $ba_out, $this->m_exp_query );
	}

	// now data is prepared.

	$dataToSend = $ba_out;

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {
			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}

			// SubmitQuery
			$this->m_f_function_type = 0;

			// async 옵션이 켜져 있으면 결과가 나올 때까지 기다리지 않는다.
			if($this->m_socket_async_request == 1) {
				return 0;
			}

			$rc = $this->GetResponse($svr_rc, $tv_start);
			break;

		} // inner while

// error:
		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
							. $this->m_n_connect . ","
							. $this->m_request_timeout . ","
							. ($tv_end-$tv_start)
							. ") E(N:"
							. $this->m_n_err_connect . ","
							. $this->m_n_err_send . ","
							. $this->m_n_err_recv . " T:"
							. $this->m_n_err_timeout . " S:"
							. $this->m_n_err_acpt_full . ","
							. $this->m_n_err_cli_recv . ","
							. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

//----- search -----------

function Search(
	$serviceAddr,
	$scn, $whereClause, $sortClause, $searchWords, $logInfo,
	$startOffset, $count, $language, $charset )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();
	$this->ClearSearchResult();

	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$ba_out = "";

	$snd_data_size = 16
		+ 8*4
		+ strlen($this->m_authcode)
		+ strlen($scn)
		+ strlen($whereClause)
		+ strlen($sortClause)
		+ strlen($searchWords)
		+ strlen($logInfo)
		+ 6;

	//expand query를 위해 추가된 부분
	$snd_data_size += $this->alignWordSize($snd_data_size);
	$snd_data_size += 4;
	$snd_data_size += (strlen($this->m_exp_query) + 1);

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_SEARCH ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	//여분 건너뜀
	for( $i=0; $i<16; $i++ )
		$this->BA_writeNull( $ba_out );

	// integer data
	$this->BA_writeInteger( $ba_out, $startOffset );
	$this->BA_writeInteger( $ba_out, $count );
	$this->BA_writeInteger( $ba_out, $language );
	$this->BA_writeInteger( $ba_out, $charset );

	// string data
	$this->BA_writeString( $ba_out, $this->m_authcode );
	$this->BA_writeString( $ba_out, $scn );
	$this->BA_writeString( $ba_out, $whereClause );
	$this->BA_writeString( $ba_out, $sortClause );
	$this->BA_writeString( $ba_out, $searchWords );
	$this->BA_writeString( $ba_out, $logInfo );

	// align
	$align_size = $this->alignWordSize(strlen($ba_out));

	$dataToSend = $ba_out;
	for($i=0; $i < $align_size; $i++)
	{
		$this->BA_writeNull($ba_out);
	}

	$this->BA_writeInteger( $ba_out, $this->m_exp_flag );
	if($this->m_exp_flag==0)
	{
		$this->BA_writeNull( $ba_out );
	} else
	{
		$this->BA_writeString( $ba_out, $this->m_exp_query );
	}

	// now data is prepared.

	$dataToSend = $ba_out;

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {
			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}

			// Search
			$this->m_f_function_type = 1;

			// async 옵션이 켜져 있으면 결과가 나올 때까지 기다리지 않는다.
			if($this->m_socket_async_request == 1) {
				return 0;
			}

			$rc = $this->GetResponse($svr_rc, $tv_start);
			break;

		} // inner while

// error:
		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
							. $this->m_n_connect . ","
							. $this->m_request_timeout . ","
							. ($tv_end-$tv_start)
							. ") E(N:"
							. $this->m_n_err_connect . ","
							. $this->m_n_err_send . ","
							. $this->m_n_err_recv . " T:"
							. $this->m_n_err_timeout . " S:"
							. $this->m_n_err_acpt_full . ","
							. $this->m_n_err_cli_recv . ","
							. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

//----- select -----------

function Select(
	$serviceAddr,
	$scn, $whereClause, $sortClause, $highlight,
	$startOffset, $count, $language, $charset )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();
	$this->ClearSearchResult();

	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$ba_out = "";

	$snd_data_size = 13*4
		+ 8
		+ strlen($this->m_authcode)
		+ strlen($this->m_log)
		+ strlen($scn)
		+ strlen($whereClause)
		+ strlen($sortClause)
		+ strlen($highlight)
		+ strlen($this->m_field_list)
		+ strlen($this->m_key_list);

	for($i=0;$i<sizeof($this->m_prev_title);$i++) {
		$snd_data_size += strlen($this->m_prev_title[$i]) + 1;
	}

	//expand query를 위해 추가된 부분
	$snd_data_size += $this->alignWordSize($snd_data_size);
	$snd_data_size += 4;
	$snd_data_size += (strlen($this->m_exp_query) + 1);

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_SUBMIT_QUERY ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $this->m_max_n_cluster);
	$this->BA_writeInteger( $ba_out, $this->m_max_n_clu_record );
	$this->BA_writeInteger( $ba_out, $this->m_prev_title==NULL ? 0 : sizeof($this->m_prev_title) );
	$this->BA_writeInteger( $ba_out, $this->m_clu_flag );
	$this->BA_writeInteger( $ba_out, $startOffset );
	$this->BA_writeInteger( $ba_out, $count );
	$this->BA_writeInteger( $ba_out, $this->m_max_n_related_term );
	$this->BA_writeInteger( $ba_out, $language );
	$this->BA_writeInteger( $ba_out, $charset );

	// string data
	$this->BA_writeString( $ba_out, $this->m_authcode );
	$this->BA_writeString( $ba_out, $this->m_log );
	$this->BA_writeString( $ba_out, $scn );
	$this->BA_writeString( $ba_out, $whereClause );
	$this->BA_writeString( $ba_out, $sortClause );
	$this->BA_writeString( $ba_out, $highlight );
	$this->BA_writeString( $ba_out, $this->m_field_list );
	$this->BA_writeString( $ba_out, $this->m_key_list );

	if( $this->m_prev_title != NULL ) {
		for( $i=0; $i<sizeof($this->m_prev_title); $i++ )
			$this->BA_writeString( $ba_out, $this->m_prev_title[$i] );
	}

	//for expand query

	// align
	$align_size = $this->alignWordSize(strlen($ba_out));

	$dataToSend = $ba_out;
	for($i=0; $i < $align_size; $i++)
	{
		$this->BA_writeNull($ba_out);
	}

	$this->BA_writeInteger( $ba_out, $this->m_exp_flag );
	if($this->m_exp_flag==0)
	{
		$this->BA_writeNull( $ba_out );
	} else
	{
		$this->BA_writeString( $ba_out, $this->m_exp_query );
	}

	// now data is prepared.

	$dataToSend = $ba_out;

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}

            // SubmitQuery
			$this->m_f_function_type = 0;

			if($this->m_socket_async_request == 1) {
				return 0;
			}

			$rc = $this->GetResponse( $svr_rc, $tv_start );
			break;

		} // inner while

	// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
							. $this->m_n_connect . ","
							. $this->m_request_timeout . ","
							. ($tv_end-$tv_start)
							. ") E(N:"
							. $this->m_n_err_connect . ","
							. $this->m_n_err_send . ","
							. $this->m_n_err_recv . " T:"
							. $this->m_n_err_timeout . " S:"
							. $this->m_n_err_acpt_full . ","
							. $this->m_n_err_cli_recv . ","
							. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

//----- insert -----------

function Insert(
	$serviceAddr, $fullTableName,
	$fieldName, $fieldData, $numFields,
	$language, $charset, $nFlag )
{
	$recv_timeout		= 0;

	$i = 0;
	$saddr = "";
	$port = 0;

	$this->ClearNetworkStatistics();
	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);

	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$ba_out = "";

	$snd_data_size = 4*4	/* 4-integer header */
		+ 3*4    /* language, charset, n_field */
		+ $numFields*4
		+ strlen($this->m_authcode) + 1
		+ strlen($this->m_log) + 1
		+ strlen($fullTableName) + 1;

	for($i=0;$i<$numFields;$i++) {
		$snd_data_size += strlen($fieldName[$i]) + 1;
		$snd_data_size += strlen($fieldData[$i]) + 1;
	}

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_INSERT); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $language );
	$this->BA_writeInteger( $ba_out, $charset );
	$this->BA_writeInteger( $ba_out, $numFields );

	for( $i=0; $i<$numFields; $i++ ) {
		$b = strlen($fieldData[$i]);
		$this->BA_writeInteger( $ba_out, $b );
	}

	$this->BA_writeString( $ba_out, $this->m_authcode );
	$this->BA_writeString( $ba_out, $this->m_log );
	$this->BA_writeString( $ba_out, $fullTableName );

	for( $i=0; $i<$numFields; $i++ )
	{
		$this->BA_writeString( $ba_out, $fieldName[$i] );
		$this->BA_writeString( $ba_out, $fieldData[$i] );
	}

	// now data is prepared.

	$dataToSend = $ba_out;

	// send through socket

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);


			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}


			// decode result

			break;

			//debug

		} // inner while

// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	// finish

	return $rc;
}

//----- delete -----------
// returns # of affected rows ( < 0 on error)

function Delete(
		$serviceAddr, $fullTableName, $expr,
		$language, $charset, $nFlag )
{
	$i = 0;
	$saddr = "";
	$port = 0;

	$recv_timeout		= 0;
	$this->ClearNetworkStatistics();

	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$ba_out = "";

	$snd_data_size = 4*4	/* 4-integer header */
		+ 2*4    /* language, charset */
		+ strlen($this->m_authcode) + 1
		+ strlen($this->log) + 1
		+ strlen($fullTableName) + 1
		+ strlen($expr) + 1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);


	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_DELETE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)


	// integer data
	$this->BA_writeInteger( $ba_out, $language ); // total size
	$this->BA_writeInteger( $ba_out, $charset ); // xor-key

	// string data
	$this->BA_writeString( $ba_out, $this->m_authcode );
	$this->BA_writeString( $ba_out, $this->log );
	$this->BA_writeString( $ba_out, $fullTableName );
	$this->BA_writeString( $ba_out, $expr);

	// now data is prepared.

	$dataToSend = $ba_out;

	// send through socket

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}


			// decode result

			if( $rcv_data_size - $location < 4 ) {
				$this->m_msg = "cannot receive result count (C081)";
				return eNETWORKERR;
			}
			$affected = $this->bytes2int( $dataRcvd, $location ); $location += 4;

			break;
		} // inner while

// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		return $affected;

	} // outer while


	// finish

	return $rc;
}

//----- update -----------

function Update(
		$serviceAddr, $fullTableName, $expr,
		$fieldName, $fieldData, $numFields,
		$language, $charset, $nFlag )
{
	$i = 0;
	$saddr = "";
	$port = 0;

	$recv_timeout		= 0;
	$this->ClearNetworkStatistics();

	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$ba_out = "";
	$snd_data_size = 4*4	/* 4-integer header */
		+ 3*4 /* language, charset, nField */
		+ $numFields*4
		+ strlen($this->authcode) + 1
		+ strlen($this->log) + 1
		+ strlen($fullTableName) + 1
		+ strlen($expr) + 1;

	for($i=0;$i<$numFields;$i++) {
		$snd_data_size += strlen($fieldName[$i]) + 1;
		$snd_data_size += strlen($fieldData[$i]) + 1;
	}

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_UPDATE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	$this->BA_writeInteger( $ba_out, $language );
	$this->BA_writeInteger( $ba_out, $charset );
	$this->BA_writeInteger( $ba_out, $numFields );

	for( $i=0; $i<$numFields; $i++ ) {
		$b = strlen($fieldData[$i]);
		$this->BA_writeInteger( $ba_out, $b );
	}

	$this->BA_writeString( $ba_out, $this->authcode );
	$this->BA_writeString( $ba_out, $this->log );
	$this->BA_writeString( $ba_out, $fullTableName );
	$this->BA_writeString( $ba_out, $expr );

	for( $i=0; $i<$numFields; $i++ )
	{
		$this->BA_writeString( $ba_out, $fieldName[$i] );
		$this->BA_writeString( $ba_out, $fieldData[$i] );
	}

	// now data is prepared.

	$dataToSend = $ba_out;

	// send through socket

	$tv_start = time();

// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);


			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}


			// decode result

			if( $rcv_data_size - $offset < 4 ) {
				$this->m_msg = "cannot receive result count (C081)";
				return eNETWORKERR;
			}
			$affected = $this->bytes2int( $dataRcvd, $location ); $location += 4;

			break;
		} // inner while

// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		return $affected;

	} // outer while


	// finish

	return $rc;
}


//----- get search results -----------

// async 옵션시 처리와 일반 처리 겸용임.
function GetResponse( &$svr_rc, $tv_start )
{
	if ($this->m_f_data_received == 1) {
		return 0;
	}

	while(1) {
		while(1) {
			// receive result
			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$this->m_searchTime = $this->bytes2int($dataRcvd, $location ); $location += 4;
			$this->m_n_total = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_row = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_col = $this->bytes2int( $dataRcvd, $location ); $location += 4;

			$this->m_record_no = array();
			for( $i=0; $i<$this->m_n_row; $i++ ) {
				$this->m_record_no[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
			}

			$this->m_score = array();
			for( $i=0; $i<$this->m_n_row; $i++ ) {
				$this->m_score[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
			}

			$this->m_field_data = array();
			$this->m_field_size = array();
			for( $i=0; $i<$this->m_n_row; $i++ )
			{
				$this->m_field_data[$i] = array();
				$this->m_field_size[$i] = array();
				for( $j=0; $j<$this->m_n_col; $j++ )
				{
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$this->m_field_data[$i][$j] = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}
				$location += $this->alignWordSize($location);

				for( $j=0; $j<$this->m_n_col; $j++ )
				{
					$this->m_field_size[$i][$j] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}
			}
			$location += $this->alignWordSize($location);

			$this->m_n_out_cluster = $this->bytes2int( $dataRcvd, $location );
			$location += 4;

			$this->m_out_rec_cnt_per_class = array();
			for( $i=0; $i<$this->m_n_out_cluster; $i++ ) {
				$this->m_out_rec_cnt_per_class[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
			}

			$this->m_out_class_record_no = array();
			for( $i=0; $i<$this->m_n_out_cluster; $i++ )
			{
				$this->m_out_class_record_no[$i] = array();
				for( $j=0; $j<$this->m_out_rec_cnt_per_class[$i]; $j++ ) {
					$this->m_out_class_record_no[$i][$j] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}
			}

			$this->m_cluster_title = array();
			for( $i=0; $i<$this->m_n_out_cluster; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_cluster_title[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}
			$location += $this->alignWordSize($location);

			$this->m_n_rec_term = $this->bytes2int( $dataRcvd, $location );
			$location += 4;

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_rec_term = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);


			//for expand query
			$location += $this->alignWordSize($location);
			$this->m_n_exp_k2k = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_exp_k2e = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_exp_e2e = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_exp_e2k = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_exp_trl = $this->bytes2int( $dataRcvd, $location ); $location += 4;
			$this->m_n_exp_rcm = $this->bytes2int( $dataRcvd, $location ); $location += 4;

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_k2k = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_k2e = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_e2e = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_e2k = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_trl = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
			$this->m_exp_rcm = substr( $dataRcvd, $location, $slen );
			$location += ($slen+1);

			//for column name
			$location += $this->alignWordSize($location);
			$this->m_col_name_count = $this->bytes2int( $dataRcvd, $location );
			$location += 4;

			$this->m_col_name = array();
			for( $i=0; $i<$this->m_col_name_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
				$this->m_col_name[$i] = substr( $dataRcvd, $location, $slen );
				$location += ($slen+1);
			}

			if ( $location + 4 > $rcv_data_size) break;

			if ( $this->m_f_function_type == 0) { 
				//SubmitQuery

				if ((( $rcv_data_size - $loacation ) / 4) < $this->m_n_row) break;

				$location += $this->alignWordSize($location);

				$this->m_matchfield = array();
				for( $i=0; $i<$this->m_n_row; $i++ ) {
					$this->m_matchfield[$i] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}

				$this->m_userkey_idx = array();
				for( $i=0; $i<$this->m_n_row; $i++ ) {
					$this->m_userkey_idx[$i] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}

			} //end SubmitQuery
			else if ( $this->m_f_function_type == 1) {
				//Search 

				$location += $this->alignWordSize($location);

				// UnionEncodeTableName
				$this->m_union_table_count = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
	
				for ( $i=0; $i<$this->m_union_table_count; $i++)
				{
					for ( $j=0; $j<3; $j++)
					{
						$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
						$this->m_union_table_name[$i][$j] = substr( $dataRcvd, $location, $slen );
						$location += ($slen+1);
					}
				}
				$location += $this->alignWordSize($location);

				// UnionEncodeTableNo
				$this->m_tabno_count = $this->bytes2int( $dataRcvd, $location );
				$location += 4;

				for( $i=0; $i<$this->m_tabno_count; $i++)
				{
					$this->m_tabno[$i] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}
				$location += $this->alignWordSize($location);

				// UnionEncodeGroupBy
				$this->m_group_count = $this->bytes2int( $dataRcvd, $location );
				$location += 4;

				$this->m_group_key_count = $this->bytes2int( $dataRcvd, $location );
				$location += 4;

				for ( $i=0; $i<$this->m_group_count; $i++)
				{
					$this->m_group_size[$i] = $this->bytes2int( $dataRcvd, $location );
					$location += 4;
				}

				for ( $i=0; $i<$this->m_group_count; $i++)
				{
					for ( $j=0; $j<$this->m_group_key_count; $j++)
					{
						$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size );
						$this->m_group_key_val[$i][$j] = substr( $dataRcvd, $location, $slen );
						$location += ($slen+1);
					}
				}

				$location += $this->alignWordSize($location);
			} //end Search

			break;

		} // inner while

// error:
		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
							. $this->m_n_connect . ","
							. $this->m_request_timeout . ","
							. ($tv_end-$tv_start)
							. ") E(N:"
							. $this->m_n_err_connect . ","
							. $this->m_n_err_send . ","
							. $this->m_n_err_recv . " T:"
							. $this->m_n_err_timeout . " S:"
							. $this->m_n_err_acpt_full . ","
							. $this->m_n_err_cli_recv . ","
							. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while

	// async 처리시 현재 소켓에 대해 데이타를 recv했는지를 알고 있어야
	// 중복해서 recv()를 호출하지 않게 된다.
	$this->m_f_data_received = 1;

	return $rc;
}

function GetTotalCount()
{
	$rc = $this->GetResponse($svr_rc, time());

	return $this->m_n_total;
}

function GetRowSize()
{
	$rc = $this->GetResponse($svr_rc, time());

	return $this->m_n_row;
}

function GetColumnSize()
{
	$rc = $this->GetResponse($svr_rc, time());

	return $this->m_n_col;
}

function GetSearchTime()
{
	$rc = $this->GetResponse($svr_rc, time());

	return $this->m_searchTime;
}

function GetRecordNoArray( &$recordNo, &$score )
{
	$rc = $this->GetResponse($svr_rc, time());

	if( $this->m_n_row == 0 ) return 0;

	for($i=0; $i<$this->m_n_row; $i++)
	{
		$recordNo[$i] = $this->m_record_no[$i];
		$score[$i] = $this->m_score[$i];
	}
	return 0;
}

function GetRow( &$field_data, $row_no )
{
	$rc = $this->GetResponse($svr_rc, time());

	if( $this->m_n_col == 0 ) return 0;
	if( $row_no < 0 || $row_no >= $this->m_n_row ) {
		$this->m_msg = "GetRow: invalid row number";
		return eERR;
	}
	for($i=0; $i<$this->m_n_col; $i++)
	{
		$field_data[$i] = $this->m_field_data[$row_no][$i];
	}
	return 0;
}

function GetColumnName( &$col_name, $col_size )
{
	$rc = $this->GetResponse($svr_rc, time());

	if( $this->m_n_col == 0 ) return 0;
	if( $col_size != $this->m_n_col ) {
		$this->m_msg = "GetColumnName: invalid column size";
		return eERR;
	}
	if( $col_size != $this->m_col_name_count ) {
		$this->m_msg = "GetColumnName: column size mismatch";
		return eERR;
	}

	$col_name = array();
	for($i=0; $i<$col_size; $i++)
	{
		$col_name[$i] = $this->m_col_name[$i];
	}
	return 0;
}

function GetClusters( &$title,
	&$class_record_no, &$rec_cnt_per_class )
{
	$rc = $this->GetResponse($svr_rc, time());

	if( $this->m_n_out_cluster == 0 ) return 0;
	for($i=0; $i<$this->m_n_out_cluster; $i++)
	{
		$rec_cnt_per_class[$i] = $this->m_out_rec_cnt_per_class[$i];
		$title[$i] = $this->m_cluster_title[$i];
		for($j=0; $j<$this->m_out_rec_cnt_per_class[$i]; $j++)
		{
			$class_record_no[$i][$j] = $this->m_out_class_record_no[$i][$j];
		}
	}

	return $this->m_n_out_cluster;
}

function GetRelatedTerms( &$rec_word )
{
	$rc = $this->GetResponse($svr_rc, time());

	$rec_word = $this->m_rec_term;
	return $this->m_n_rec_term;
}

function GetExpandQuery( &$words, $nFlag )
{
	$rc = $this->GetResponse($svr_rc, time());

	if($nFlag==QEXP_K2K) {
		$words = $this->m_exp_k2k;
		return $this->m_n_exp_k2k;
	}
	elseif($nFlag==QEXP_K2E) {
		$words = $this->m_exp_k2e;
		return $this->m_n_exp_k2e;
	}
	elseif($nFlag==QEXP_E2K) {
		$words = $this->m_exp_e2k;
		return $this->m_n_exp_e2k;
	}
	elseif($nFlag==QEXP_E2E) {
		$words = $this->m_exp_e2e;
		return $this->m_n_exp_e2e;
	}
	elseif($nFlag==QEXP_TRL) {
		$words = $this->m_exp_trl;
		return $this->m_n_exp_trl;
	}
	elseif($nFlag==QEXP_RCM) {
		$words = $this->m_exp_rcm;
		return $this->m_n_exp_rcm;
	}
	return -1;
}

function GetExpandQueryCount( $nFlag )
{
	$rc = $this->GetResponse($svr_rc, time());

	if($nFlag==QEXP_K2K) {
		return $this->m_n_exp_k2k;
	}
	elseif($nFlag==QEXP_K2E) {
		return $this->m_n_exp_k2e;
	}
	elseif($nFlag==QEXP_E2K) {
		return $this->m_n_exp_e2k;
	}
	elseif($nFlag==QEXP_E2E) {
		return $this->m_n_exp_e2e;
	}
	elseif($nFlag==QEXP_TRL) {
		return $this->m_n_exp_trl;
	}
	elseif($nFlag==QEXP_RCM) {
		return $this->m_n_exp_rcm;
	}
	return -1;
}

// 2007.07.25 추가
function GetResultGroupBy(
		&$out_group_count, &$out_key_count, &$out_group_key_val, &$out_group_size,
		$max_group_count)
{
	$rc = $this->GetResponse($svr_rc, time());

	$out_group_count = $this->m_group_count;
	$out_key_count = $this->m_group_key_count;

	if ($out_group_count < 0)
		return -1;

	for($i=0; $i<$this->m_group_count && $i<$max_group_count; $i++)
	{
		$out_group_size[$i] = $this->m_group_size[$i];
		for($j=0; $j<$this->m_group_key_count; $j++)
		{
			$out_group_key_val[$i][$j] = $this->m_group_key_val[$i][$j];
		}
	}

	$out_group_count = $i;

	return 0;
}

// 2009.12.14 추가
function GetMatchfieldArray( &$matchfield )
{
	$rc = $this->GetResponse($svr_rc, time());

	$matchfield = $this->m_matchfield;
	return $this->m_n_row;
}

// 2009.12.14 추가
function GetUserKeyIndexArray( &$userkey_index )
{
	$rc = $this->GetResponse($svr_rc, time());

	$userkey_index = $this->m_userkey_idx;
	return $this->m_n_row;
}



function SetAuthCode( $authcode )
{
	$this->m_authcode = $authcode;
	return 0;
}
function SetLog ($log )
{
	$this->m_log = $log;
	return 0;
}

function GetQueryAttribute(
		$serviceAddr, &$attr_count, &$attr_name,
		&$lb_op, &$lb_val, &$ub_op, &$ub_val,
		&$remained_str,
		$query, $max_attr_count, $domain )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 2*4
		+ strlen($query) +1;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_GET_QUERY_ATTRIBUTE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_attr_count );
	$this->BA_writeInteger( $ba_out, $domain );

	// string data
	$this->BA_writeString( $ba_out, $query );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$attr_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$lb_op = array();
			$ub_op = array();
			for( $i=0; $i<$attr_count; $i++ ) {
				$lb_op[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;

				$ub_op[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
			}

			$attr_name = array();
			$lb_val = array();
			$ub_val = array();
			for( $i=0; $i<$attr_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$attr_name[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);

				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$lb_val[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);

				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$ub_val[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}
			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
			$remained_str = substr($dataRcvd, $location, $slen);
			$location += ($slen+1);

			return $attr_count;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socet = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	// finish

	return $rc;
}

function CompleteKeyword(
		$serviceAddr, &$nKwd, &$kwd_list, &$rank, &$tag, &$num, &$cnv_str,
		$max_kwd_count, $seed_str, $nFlag, $nDomainNo )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 3*4
		+ strlen($seed_str) +1;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_COMPLETE_KEYWORD ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_kwd_count );
	$this->BA_writeInteger( $ba_out, $nFlag );
	$this->BA_writeInteger( $ba_out, $nDomainNo );

	// string data
	$this->BA_writeString( $ba_out, $seed_str );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$nKwd = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$kwd_list = array();
			for( $i=0; $i<$nKwd; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$kwd_list[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
			$cnv_str  = substr($dataRcvd, $location, $slen);
			$location += ($slen+1);

			// for compatibility

			$rank = array();
			$tag = array();
			$num = array();

			if( $rcv_data_size > $location ) {
				$location += $this->alignWordSize($location);

				for( $i=0; $i<$nKwd; $i++) {
					$rank[$i] = $this->bytes2int($dataRcvd, $location );
					$location += 4;
				}

				for( $i=0; $i<$nKwd; $i++) {
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$tag[$i]  = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}

				for( $i=0; $i<$nKwd; $i++) {
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$num[$i]  = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}
			} else {
				for( $i=0; $i<$nKwd; $i++) {
					$rank[$i] = 0;
				}

				for( $i=0; $i<$nKwd; $i++) {
					$tag[$i]  = "";
				}

				for( $i=0; $i<$nKwd; $i++) {
					$num[$i]  = "";
				}
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function SpellCheck( $serviceAddr, &$out_count, &$out_word, $max_out_count, $in_word )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 4
		+ strlen($in_word) +1;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_SPELL_CHECK ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_out_count );

	// string data
	$this->BA_writeString( $ba_out, $in_word );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$out_count = $this->bytes2int( $dataRcvd, $location );
			$location += 4;

			$out_word = array();
			for($i=0; $i<$out_count; $i++) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_word[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function RecommendKeyword(
		$serviceAddr, &$out_count, &$out_str,
		$max_out_count, $in_str, $domain_no )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 2*4
		+ strlen($in_str) +1;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_RECOMMEND_KEYWORD ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_out_count );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $in_str );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$out_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_str = array();
			for( $i=0; $i<$out_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_str[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function GetPopularKeyword(
		$serviceAddr, &$out_count, &$out_str, &$out_tag,
		$max_out_count, $domain_no )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 2*4;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_GET_POPULAR_KEYWORD ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_out_count );
	$this->BA_writeInteger( $ba_out, $domain_no );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$out_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_str = array();
			for( $i=0; $i<$out_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_str[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$out_tag = array();

			if( $rcv_data_size > $location ) {
				for( $i=0; $i<$out_count; $i++ ) {
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$out_tag[$i] = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}
			} else {
				for( $i=0; $i<$out_count; $i++ ) {
					$out_tag[$i] = "";
				}
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function GetRealTimePopularKeyword(
		$serviceAddr, &$out_count, &$out_str, &$out_tag,
		$max_out_count, $opt_online, $domain_no )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 3*4;


	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_GET_REAL_TIME_POPULAR_KEYWORD ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_out_count );
	$this->BA_writeInteger( $ba_out, $opt_online );
	$this->BA_writeInteger( $ba_out, $domain_no );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$out_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_str = array();
			for( $i=0; $i<$out_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_str[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$out_tag = array();

			if( $rcv_data_size > $location ) {
				for( $i=0; $i<$out_count; $i++ ) {
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$out_tag[$i] = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}
			} else {
				for( $i=0; $i<$out_count; $i++ ) {
					$out_tag[$i] = "";
				}
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function AnchorText( $serviceAddr,
		&$out_text, $in_text, $tag_scheme, $option, $domain_no )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 1*4
		+ strlen($in_text) +1
		+ strlen($tag_scheme) +1
		+ strlen($option) +1;


	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_ANCHOR_TEXT ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $in_text );
	$this->BA_writeString( $ba_out, $tag_scheme );
	$this->BA_writeString( $ba_out, $option );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
			$out_text  = substr($dataRcvd, $location, $slen);
			$location += ($slen+1);

			return 0;

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function GetSynonymList( $serviceAddr,
		&$term_count, &$synonym_count, &$synonym_list,
		$max_term_count, $in_str, $opt_part_exp, $opt_morph_exp,
		$nLanguage, $nCharset, $compound_level, $domain_no )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 7*4
		+ strlen($in_str) +1;


	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_GET_SYNONYM_LIST ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_term_count );
	$this->BA_writeInteger( $ba_out, $opt_part_exp );
	$this->BA_writeInteger( $ba_out, $opt_morph_exp );
	$this->BA_writeInteger( $ba_out, $nLanguage );
	$this->BA_writeInteger( $ba_out, $nCharset );
	$this->BA_writeInteger( $ba_out, $compound_level );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $in_str );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$term_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$synonym_count = array();
			for( $i=0; $i<$term_count; $i++ ) {
				$synonym_count[$i] = $this->bytes2int( $dataRcvd, $location );
				$location += 4;
			}

			$synonym_list = array();
			for( $i=0; $i<$term_count; $i++ ) {
				$synonym_list[$i] = array();

				for( $j=0; $j<$synonym_count[$i]; $j++ ) {
					$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
					$synonym_list[$i][$j] = substr($dataRcvd, $location, $slen);
					$location += ($slen+1);
				}
			}

			return 0;

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function ExtractKeyword(
		$serviceAddr, &$out_keyword_count, &$out_keyword,
		$max_keyword_count, $link_name, $input_text,
		$nOption, $nLanguage, $nCharset, $compound_level )
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 5*4
		+ strlen($link_name) +1
		+ strlen($input_text) +1;

	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_EXTRACT_KEYWORD2 ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_keyword_count );
	$this->BA_writeInteger( $ba_out, $nOption );
	$this->BA_writeInteger( $ba_out, $nLanguage );
	$this->BA_writeInteger( $ba_out, $nCharset );
	$this->BA_writeInteger( $ba_out, $compound_level );

	// string data
	$this->BA_writeString( $ba_out, $link_name );
	$this->BA_writeString( $ba_out, $input_text );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$out_keyword_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_keyword = array();
			for( $i=0; $i<$out_keyword_count; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_keyword[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			return 0;

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function GetROWID2( &$out_rowid_count, &$out_table_no,
			&$out_link_name, &$out_volume_name, &$out_table_name, &$out_rowid, &$out_score,
			$max_rowid_count)
{
	$rc = $this->GetResponse($svr_rc, time());

	if( $this->m_n_row == 0 ) return 0;

	if( $this->m_tabno_count != $this->m_n_row)
	{
		$this->m_msg = "incorrect row count "
				. $this->m_tabno_count
				. ":"
				. $this->m_n_row
				. "(C218762)";
		return -1;
	}

	for($i=0; $i<$this->m_n_row && $i<$max_rowid_count; $i++)
	{
		$tabno = $this->m_tabno[$i];

		if ($this->m_tabno_count==0 || $this->m_union_table_count==0
			|| $tabno<0 || $tabno>=$this->m_union_table_count)
		{
			$out_link_name[$i] = "";
			$out_volume_name[$i] = "";
			$out_table_name[$i] = "";
		}
		else
		{
			$out_link_name[$i] = $this->m_union_table_name[$tabno][0];
			$out_volume_name[$i] = $this->m_union_table_name[$tabno][1];
			$out_table_name[$i] = $this->m_union_table_name[$tabno][2];
		}

		$out_table_no[$i] = $this->m_tabno[$i];
		$out_rowid[$i] = $this->m_record_no[$i];
		$out_score[$i] = $this->m_score[$i];
	}

	$out_rowid_count = $i;

	return 0;
}

function CensorSearchWords( $serviceAddr,
			&$out_censored_word_count, &$out_censored_word,
			$max_censor_word_count, $search_words, $domain_no)
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 2*4
		+ strlen($search_words) +1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_CENSOR_SEARCH_WORDS ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_censor_word_count );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $search_words );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$censored_word_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_censored_word = array();
			for( $i=0; $i<$censored_word_count && $i<$max_censor_word_count ; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_censored_word[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);

			$out_censored_word_count = $i;

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function Transliterate( $serviceAddr,
			&$out_transliterated_word_count, &$out_transliterated_word,
			$max_transliterate_word_count, $search_words, $target_language, $domain_no)
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	$snd_data_size = 4*4
		+ 3*4
		+ strlen($search_words) +1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_TRANSLITERATE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $max_transliterate_word_count );
	$this->BA_writeInteger( $ba_out, $target_language );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $search_words );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result

			$transliterated_word_count = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			$out_transliterated_word = array();
			for( $i=0; $i<$transliterated_word_count && $i<$max_transliterate_word_count ; $i++ ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_transliterated_word[$i] = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}

			$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);

			$out_transliterated_word_count = $i;

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function FilterText	( $serviceAddr,
			&$out_text_size, &$out_text,
			$in_doc_buf_size, $in_doc_buf,
			$out_file_name, $in_file_name,
			$doc_type, $run_mode, $domain_no)
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	if ($in_doc_buf==NULL) $in_doc_buf = "";
	if ($out_file_name==NULL) $out_file_name = "";
	if ($in_file_name==NULL) $in_file_name = "";

	$snd_data_size = 4*4
		+ 4		// (int)in_doc_buf_size
		+ 4		// (int)doc_type
		+ 4		// (int)run_mode
		+ 4		// (int)domain_no
		+ strlen($out_file_name) +1
		+ strlen($in_file_name) +1
		+ $in_doc_buf_size +1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_FILTER_TEXT ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $in_doc_buf_size );
	$this->BA_writeInteger( $ba_out, $doc_type );
	$this->BA_writeInteger( $ba_out, $run_mode );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $out_file_name );
	$this->BA_writeString( $ba_out, $in_file_name );
	$in_doc_buf_size_tmp = $in_doc_buf_size;
	if ($in_doc_buf_size>strlen($in_doc_buf))
		$in_doc_buf_size_tmp = strlen($in_doc_buf);
	$in_doc_buf_tmp = substr($in_doc_buf, 0, $in_doc_buf_size_tmp);
	$this->BA_writeString( $ba_out, $in_doc_buf_tmp );


	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result
			$out_text_size = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			if( $rcv_data_size > $location ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_text = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}
			else {
				$out_text = "";
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function PutCache	( $serviceAddr,
			$in_key_size, $in_key,
			$in_data_size, $in_data,
			$in_priority_key, $domain_no)
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	if ($in_key==NULL) $in_key = "";
	if ($in_data==NULL) $in_data = "";
	if ($in_priority_key==NULL) $in_priority_key = "";

	$snd_data_size = 4*4
		+ 4		// (int)in_key_size
		+ 4		// (int)in_data_size
		+ 4		// (int)domain_no
		+ strlen($in_key) +1
		+ strlen($in_data) +1
		+ strlen($in_priority_key) +1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_PUT_CACHE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $in_key_size );
	$this->BA_writeInteger( $ba_out, $in_data_size );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $in_key );
	$this->BA_writeString( $ba_out, $in_data );
	$this->BA_writeString( $ba_out, $in_priority_key );

	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result
			
			// do nothing.
			
			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function GetCache	( $serviceAddr, 
			&$out_hit_flag, &$out_data_size, &$out_data,
			$in_key_size, $in_key,
			$domain_no)
{
	$recv_timeout		= 0;

	$this->ClearNetworkStatistics();

	$ba_out = "";

	if ($in_key==NULL) $in_key = "";

	$snd_data_size = 4*4
		+ 4		// (int)in_key_size
		+ 4		// (int)domain_no
		+ strlen($in_key) +1;

	//$snd_xor_key = $snd_data_size ^ g_xor_key;
	$snd_xor_key = $this->my_xor($snd_data_size);

	// 4-integer header
	$this->BA_writeInteger( $ba_out, $snd_data_size ); // total size
	$this->BA_writeInteger( $ba_out, $snd_xor_key ); // xor-key
	$this->BA_writeInteger( $ba_out, REQUEST_GET_CACHE ); // request_code
	$this->BA_writeInteger( $ba_out, $this->m_request_priority ); // not used (8-byte padding)

	// integer data
	$this->BA_writeInteger( $ba_out, $in_key_size );
	$this->BA_writeInteger( $ba_out, $domain_no );

	// string data
	$this->BA_writeString( $ba_out, $in_key );

	// now data is prepared.

	$dataToSend = $ba_out;


	$ret = $this->my_Parse($serviceAddr, &$saddr, &$port);
	if($ret==FALSE)
	{
		$this->m_msg = "cannot parse service address.";
		return -1;
	}

	$tv_start = time();

	// state_connect
	while(1) {

		$svr_rc = 0;

		while(1) {

			// send through socket
			$this->m_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			if($this->m_socket==FALSE)
			{
				$this->m_msg = "cannot create socket.";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			if($this->m_linger_timeout>0) {
				$rc = @socket_set_option($this->m_socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
			}

			$rc = $this->Connect($this->m_socket, $saddr, $port);
			if($rc==FALSE)
			{
				$this->m_msg = "cannot connect to server(".socket_last_error().").";
				$rc = -5;
				$this->m_n_err_connect++;
				break;
			}

			$rc = @socket_write($this->m_socket, $dataToSend);
			if($rc!=$snd_data_size)
			{
				$this->m_msg = "cannot send data completely. (".$rc.",".$snd_data_size.",".socket_last_error().")";
				$this->m_n_err_send++;
				$rc = -1;
				break;
			}


			// receive result

			$tv_curr = time();
			if($this->m_request_timeout <= 7) {
				$recv_timeout = $this->m_request_timeout;
			} else {
				$recv_timeout = $this->m_request_timeout - ($tv_curr-$tv_start);
				if($recv_timeout < 7) {
					$recv_timeout = 7;
				}
			}

			// size & xor key

			$this->SetTimeOut($recv_timeout);
			$rc = $this->RecvData($dataRcvd, $rcv_data_size);

			if($rc!=0) {
				if($rc==1) {
					$this->m_n_err_timeout++;
				} else {
					$this->m_n_err_recv++;
				}

				$rc = -1;
				break;
			}

			socket_close($this->m_socket);
			$this->m_socket = FALSE;

			$location = 0;

			// 8-bytes, use first 4 bytes only
			$svr_rc = $this->bytes2int( $dataRcvd, $location );
			$location += 8;

			/* svr_rc 의 값
			   -11 : acpt queue full
			   -12 : acpt queue 에 쓰기 실패
			   -13 : 클라이언트로부터 데이터를 못 받음
			   -14 : recv queue full
			   -15 : recv queue 에 쓰기 실패
			   -16 : 일반적인 검색 오류 발생
			   -17 : 메모리 부족 오류
			 */

			if($svr_rc != 0) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$this->m_msg = substr($dataRcvd, $location, $slen);

				if(strncmp($dataRcvd, "volume busy", 11) == 0) {
					$rc = -3;
				} else {
					$rc = -5;
				}

				if($svr_rc == -11) {
					$this->m_n_err_acpt_full++;
				} else if($svr_rc == -13) {
					$this->m_n_err_cli_recv++;
				} else if($svr_rc == -14) {
					$this->m_n_err_recv_full++;
				}

				break;
			}

			// decode result
			$out_hit_flag = $this->bytes2int($dataRcvd, $location );
			$location += 4;
			$out_data_size = $this->bytes2int($dataRcvd, $location );
			$location += 4;

			if( $rcv_data_size > $location ) {
				$slen = $this->bytes2str( $dataRcvd, $location, $rcv_data_size);
				$out_data = substr($dataRcvd, $location, $slen);
				$location += ($slen+1);
			}
			else {
				$out_data = "";
			}

			return 0;

			//debug

		} // inner while

		// error:

		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		if($this->m_retry_on_network_error>0) {
			if($rc!=0&&($svr_rc==0||($svr_rc>=-15&&$svr_rc<=-11))) {
				$this->m_n_connect++;
				$tv_end = time();

				if($this->m_request_timeout <= ($tv_end-$tv_start)) {
					$this->m_msg = "request timeout ("
						. $this->m_n_connect . ","
						. $this->m_request_timeout . ","
						. ($tv_end-$tv_start)
						. ") E(N:"
						. $this->m_n_err_connect . ","
						. $this->m_n_err_send . ","
						. $this->m_n_err_recv . " T:"
						. $this->m_n_err_timeout . " S:"
						. $this->m_n_err_acpt_full . ","
						. $this->m_n_err_cli_recv . ","
						. $this->m_n_err_recv_full . ")";
					break;
				} else {
					sleep(1);
				}

				continue;
			}
		}

		break;

	} // outer while


	$this->ClearSearchCondition();

	// finish

	return $rc;
}

function SetClientLogLocation( $path, $nOption1, $nOption2 )
{

	// finish

	return $rc;
}

// helpers
// write data to ByteArrayOutputStream

function BA_writeInteger(&$out, $num)
{
	$b = " ";
	$this->int2bytes( $num, $b, 0 );
	$out = $out . $b;
}
function BA_writeString(&$out, $s)
{
	$out = $out . $s;
	$out = $out . "\0";
}
function BA_writeNull(&$out)
{
	$out[strlen($out)] = NULL;
}
function int2bytes( $num, &$b, $offset )
{
	//printf("num:%d(%d,%d,%d,%d)", $num, $num>>24, $num>>16, $num>>8, $num);
	$tmp0 = $num>>24;
	$tmp1 = $num>>16;
	$tmp2 = $num>>8;
	$tmp3 = $num;
	$b = substr_replace($b, chr($tmp0&0x000000ff), $offset+0, 1);
	$b = substr_replace($b, chr($tmp1&0x000000ff), $offset+4, 1);
	$b = substr_replace($b, chr($tmp2&0x000000ff), $offset+8, 1);
	$b = substr_replace($b, chr($tmp3&0x000000ff), $offset+12, 1);
	//printf("(%d,%d,%d,%d)\n", $tmp0&0x000000ff, $tmp1&0x000000ff, $tmp2&0x000000ff, $tmp3&0x000000ff);
}
function bytes2str( $b, $offset, $maxlen )
{
	$i = 0;
	for($i=$offset; substr($b, $i, 1)!="\0"; $i++)
	{
		if($i>=$maxlen)
			break;
	}
	return $i-$offset;
}
function bytes2int( $b, $offset )
{
	return
		((((int)ord($b[$offset+0]))&0xff)<<24) +
		((((int)ord($b[$offset+1]))&0xff)<<16) +
		((((int)ord($b[$offset+2]))&0xff)<<8) +
		(((int)ord($b[$offset+3]))&0xff);
}
function alignWordSize( $offset )
{
	//return (($offset-1) & 0xfffffff8) + 8 - $offset;
	$tmp0 = (($offset-1)>>24) & 0xff;
	$tmp1 = (($offset-1)>>16) & 0xff;
	$tmp2 = (($offset-1)>>8) & 0xff;
	$tmp3 = ($offset-1) & 0xf8;
	return (($tmp0<<24) | ($tmp1<<16) | ($tmp2<<8) | $tmp3) + 8 - $offset;
}
function my_xor( $val )
{
	if($val>=0)
	{
		$tmp0 = (($val & 0xFF000000)>>24) ^ g_xor_key0;
		$tmp1 = (($val & 0x00FF0000)>>16) ^ g_xor_key1;
		$tmp2 = (($val & 0x0000FF00)>>8) ^ g_xor_key2;
		$tmp3 = ($val & 0x000000FF) ^ g_xor_key3;

		return $tmp0<<24 | $tmp1<<16 | $tmp2<<8 | $tmp3;
	}
	else
	{
		$tmp0 = (256+($val>>24)) ^ g_xor_key0;
		$tmp1 = (($val&0x00FF0000)>>16) ^ g_xor_key1;
		$tmp2 = (($val&0x0000FF00)>>8) ^ g_xor_key2;
		$tmp3 = ($val&0x000000FF) ^ g_xor_key3;
		return $tmp0<<24 | $tmp1<<16 | $tmp2<<8 | $tmp3;
	}
}
function my_Parse($serviceAddr, &$saddr, &$port)
{
	$pos = strpos($serviceAddr, ":");
	if($pos==FALSE)
	{
		return FALSE;
	}

	if($pos==0 || $pos+1==strlen($serviceAddr))
	{
		return FALSE;
	}
	$substr1 = substr($serviceAddr, 0, $pos);
	$substr2 = substr($serviceAddr, $pos+1, strlen($serviceAddr));
	$saddr = $substr1;
	$port = $substr2;
	return TRUE;
}

function IS_WHITE_SPACE( $ch )
{
	return ($ch==' '||$ch=='\t'||$ch=='\r'||$ch=='\n');
}

function RecvData(&$data, &$data_size )
{

	$data = "";
	$data_size = 0;

	$tv_start = time();

	$timeout = $this->m_timeout;

	$read = array($this->m_socket);
	$rc = socket_select($read, $write=NULL, $except=NULL, $timeout);

	if($rc == 0) {	// timeout
		$this->m_msg = "request timeout (".$timeout.") seconds";
		return 1;
	}

	$size_buf = socket_read($this->m_socket, 8);
	if($rc == FALSE) {
		$errno = socket_last_error();
		$this->m_msg = "cannot receive 8-bytes (".$errno.",".socket_strerror($errno).")";
		return -1;
	}

	$n_bytes_to_recv = $this->bytes2int($size_buf, 0);
	$rcv_xor_key = $this->bytes2int($size_buf, 4);

	//$rcv_xor_key ^= g_xor_key;
	$rcv_xor_key = $this->my_xor($rcv_xor_key);

	if($n_bytes_to_recv != $rcv_xor_key)
	{
		$this->m_msg = "incompatible client version";
		return -1;
	}

	$n_bytes_to_recv -= 8;


	// receive body
	$data = "";
	$rcv_data_size = $n_bytes_to_recv;

	while(strlen($data)<$rcv_data_size)
	{
		$tv_curr = time();

		$timeout = $timeout - ($tv_curr-$tv_start);
		if ($timeout < 7) $timeout = 7;

		$read = array($this->m_socket);

		$rc = socket_select($read, $write=NULL, $except=NULL, $timeout);
		if($rc == 0) {	// timeout
			$this->m_msg = "request timeout (".$timeout.") seconds";
			return 1;
		}

		$rc = socket_read($this->m_socket, $n_bytes_to_recv);
		if($rc == FALSE) {
			$errno = socket_last_error();
			$this->m_msg = "cannot receive data (".strlen($data)."/".$rcv_data_size.")"
						." (".$errno.",".socket_strerror($errno).")";
			return -1;
		}

		$data .= $rc;
		$n_bytes_to_recv -= strlen($rc);
	}

	$data_size = strlen($data);

	return 0;
}

function Connect($socket, $remote, $port)
{
	if ($this->m_connection_timeout_msec <= 0) {
		return  @socket_connect($socket, $remote, $port+0);
	}
	else {
		$timeout_usec = $this->m_connection_timeout_msec * 1000;
		@socket_set_nonblock($socket);
		@socket_connect($socket, $remote, $port+0);
		@socket_set_block($socket);

		switch(@socket_select($r = array($socket), $w = array($socket), $f = array($socket), 0, $timeout_usec))
		{
			case 2:
				// CONNECTION REFUSE
				return FALSE;
			case 1:
				// CONNECTED
				return TRUE;
			case 0:
				// TIMEOUT
				return FALSE;
		}

		return TRUE;
	}

	return TRUE;
}

//----- member data

// flags
var $m_f_data_received;

// common stuff
var $m_socket;
var $m_timeout;
var $m_msg;

var $m_searchTime;
var $m_n_total;
var $m_n_row;
var $m_n_col;

var $m_record_no;
var $m_score;

var $m_field_data;
var $m_field_size;

// clustering option
var $m_max_n_cluster;
var $m_max_n_clu_record;
var $m_field_list;
var $m_prev_title;
var $m_key_list;
var $m_clu_flag;

// expand query option
var $m_exp_query;
var $m_exp_flag;

var $m_authcode;
var $m_log;

// column name
var $m_col_name;
var $m_col_name_count;

// related term option
var $m_max_n_related_term;

// result for cluster
var $m_n_out_cluster;
var $m_out_rec_cnt_per_class;
var $m_out_class_record_no;
var $m_cluster_title;

// result for related terms
var $m_n_rec_term;
var $m_rec_term; //string array

// result for expand query
var $m_n_exp_k2k;
var $m_exp_k2k;
var $m_n_exp_k2e;
var $m_exp_k2e;
var $m_n_exp_e2k;
var $m_exp_e2k;
var $m_n_exp_e2e;
var $m_exp_e2e;
var $m_n_exp_trl;
var $m_exp_trl;
var $m_n_exp_rcm;
var $m_exp_rcm;

// set option parameters
var $m_linger_timeout;
var $m_use_socket_3way_mode;
var $m_request_timeout;
var $m_request_priority;
var $m_retry_on_network_error;
var $m_socket_async_request;
var $m_connection_timeout_msec;

// network errors
var	$m_n_connect;
var	$m_n_err_connect;
var	$m_n_err_send;
var	$m_n_err_recv;
var	$m_n_err_acpt_full;
var	$m_n_err_cli_recv;
var	$m_n_err_recv_full;
var	$m_n_err_timeout;

// result for group by, etc
// 2007.07.25
var $m_union_table_count;
var $m_union_table_name;
var $m_tabno_count;
var $m_tabno;

var $m_group_count;
var $m_group_key_count;
var $m_group_key_val;
var $m_group_size;

// 2009.12.14
var $m_matchfield;
var $m_userkey_idx;

// 2009.12.14
// 0:SubmitQuery, 1:Search
var $m_f_function_type;
}

?>


