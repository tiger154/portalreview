<?php
/*
 * Created on 2008. 09. 25
 *
 * 서버와 crx로 통신하기 위한 클라이언트 API
 *
 * @version 1.1.0
 * @author 신동호, 박용기
 */

require_once("CrxUtil.php");

define("g_xor_key0", 0xA9);
define("g_xor_key1", 0xCD);
define("g_xor_key2", 0x19);
define("g_xor_key3", 0x81);

class CrxSocket
{

	// public function
	function Constructor()
	{
		$this->m_msg = "";

		$this->m_socket = FALSE;

		$this->m_recv = "";
		$this->m_recv_size = 0;
		$this->m_send = "";
		$this->m_send_size = 0;

		$this->m_time_out_sec = 5*60;
		$this->m_time_out_usec = 0;
		$this->m_linger_timeout = 0;

		return 0;
	}

	function Destructor()
	{
		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
			$this->m_socket = FALSE;
		}

		$this->m_msg = "";

		$this->m_socket = FALSE;

		$this->m_recv = "";
		$this->m_recv_size = 0;
		$this->m_send = "";
		$this->m_send_size = 0;

		$this->m_time_out_sec = 5*60;
		$this->m_time_out_usec = 0;
		$this->m_linger_timeout = 0;

		return 0;
	}

	function GetMessage()
	{
		return $this->m_msg;
	}

	function SetTimeOut($para_time_out_sec, $para_time_out_usec)
	{
		$this->m_time_out_sec = $para_time_out_sec;
		$this->m_time_out_usec = $para_time_out_usec;
	}

	function SetLingerTimeOut($para_time_out_sec)
	{
		$this->m_linger_timeout = $para_time_out_sec;
	}

	function Connect($para_ip_addr, $para_port_num)
	{
		$rc = 0;
		$socket = FALSE;

		// send through socket
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($socket==FALSE)
		{
			$this->m_msg = "cannot create socket.";
			$rc = -5;
			return $rc;
		}

		if($this->m_linger_timeout>0) {
			$rc = @socket_set_option($socket, SOL_SOCKET, SO_LINGER, array("sec"=>$this->m_linger_timeout, "usec"=>0));
		}

		$rc = @socket_connect($socket, $para_ip_addr, $para_port_num);
		if($rc==FALSE)
		{
			$this->m_msg = "cannot connect to server ".$para_ip_addr.":".$para_port_num." (".socket_last_error().").";
			$rc = -5;
			socket_close($socket);
			return $rc;
		}

		$this->m_socket = $socket;

		$rc = 0;
		return $rc;
	}

	function Disconnect()
	{
		if($this->m_socket != FALSE) {
			socket_close($this->m_socket);
		}
		$this->m_socket = FALSE;

		return 0;
	}

	function GetSocketDescriptor()
	{
		return $this->m_socket;
	}

	function Send1($para_data_size, $para_data_buf, $para_non_block_mode)
	{
		$rc = 0;
		$data_size = 0;

		$n_bytes_to_send = 0;
		$n_send = 0;
		$zero_cnt = 0;
		$erro_cnt = 0;

		$data = $para_data_buf;
		$data_size = $para_data_size;

		if($para_non_block_mode == 1) {
			$rc = socket_set_nonblock($this->m_socket);
			if ($rc==FALSE) {
				$this->m_msg = "cannot set socket to nonblock mode";
				return -1;
			}
		}

		$n_bytes_to_send = $data_size;

		$zero_cnt = 0;
		$erro_cnt = 0;

		while($n_bytes_to_send>0) {
			$n_send = @socket_write($this->m_socket, $data, $n_bytes_to_send);
			if($n_send<0)
			{
				if($erro_cnt>=2) {
					$this->m_msg = "cannot send ".$n_bytes_to_send."/".$data_size." bytes (C8571)";
					$rc = -1;
					return $rc;
				}
				$erro_cnt++;
				sleep(1);
				continue;
			}

			if($n_send==0) {
				if($zero_cnt>20) {
					$this->m_msg = "cannot send ".$n_bytes_to_send."/".$data_size." bytes (C8572)";
					$rc = -1;
					return $rc;
				}
				$zero_cnt++;
				sleep(1);
				continue;
			}

			$data = substr($data, $n_send);
			$n_bytes_to_send -= $n_send;
			$zero_cnt = 0;
			$erro_cnt = 0;
		}

if ($this->m_socket == FALSE) echo "Send1 : null sock\n";
		return 0;

	}

	function Send2($para_ext, $para_code, $para_request_size, $para_request, $para_non_block_mode)
	{
		$rc = 0;

		$data_size = 0;
		$xor_key = 0;
		$data = "";

		$data_size = 4*4 + $para_request_size;

		$xor_key = my_xor($data_size);

		BA_writeInteger( $data, $data_size );
		BA_writeInteger( $data, $xor_key );
		BA_writeInteger( $data, $para_code );
		BA_writeInteger( $data, $para_ext );
		BA_writeNString( $data, $para_request, $para_request_size);

		$this->m_send = $data;
		$this->m_send_size = $data_size;

		$rc = $this->Send1($this->m_send_size, $this->m_send, $para_non_block_mode);
		if ($rc) {
			return -1;
		}
if ($this->m_socket == FALSE) echo "Send2 : null sock\n";
		return 0;
	}

	function Recv(&$para_svr_rc, &$para_data_size, &$para_data)
	{
		$rc = 0;

		$raw_data_size = 0;
		$raw_data = "";
		$data = "";

		$rc = $this->Recv1();
		if ($rc) {
			return -1;
		}

		$raw_data_size = $this->m_recv_size;
		$raw_data = $this->m_recv;

		if ($raw_data_size < 16) {
			$this->m_msg = "cannot receive response header ".$raw_data_size."/16 (C218463)";
			return -1;
		}

		$data = substr($raw_data, 16);

		$para_svr_rc = bytes2int( $raw_data, 8 );
		$para_data_size = $raw_data_size - 16;
		$para_data = $data;

		return 0;
	}

	//private function

	function RecvData(&$para_data, $para_bytes_to_receive)
	{
		$rc = 0;

		$data = "";
		$buf = "";
		$n_recv = 0;
		$n_bytes_to_recv = $para_bytes_to_receive;

		$read = array($this->m_socket);

		if ($this->m_socket == FALSE) echo "null sock\n";
		while($n_bytes_to_recv>0)
		{
			$rc = @socket_select($read, $write=NULL, $except=NULL, $this->m_time_out_sec, $this->m_time_out_usec);
			if($rc == 0) {	// timeout
				$errno = socket_last_error($this->m_socket);
				$this->m_msg = "connection timed out ".$this->m_time_out_sec." ".$this->m_time_out_usec."(C6831)(".socket_strerror($errno).")";
				return -1;
			}

			$n_recv = socket_recv($this->m_socket, $buf, $n_bytes_to_recv, 0);
			if($n_recv < 1) {
				$errno = socket_last_error();
				$this->m_msg = "cannot receive data (".$n_recv."/".$n_bytes_to_recv.")"
							." (".$errno.",".socket_strerror($errno).")";
				return -1;
			}

			$data .= $buf;
			$n_bytes_to_recv -= $n_recv;
		}

		if ($n_bytes_to_recv!=0) {
			$this->m_msg = "cannot receive ".$n_bytes_to_recv." bytes (C6833)";
			return -1;
		}

		$para_data = $data;
		//$para_bytes_to_receive = $n_bytes_to_recv;

		return 0;
	}

	function Recv1()
	{
		$rc = 0;
		$n_bytes_to_recv = 0;
		$xor_key = 0;
		$size_buf = "";
		$data_buf = "";
		$data = "";

		//receive header
		$rc = $this->RecvData($size_buf, 8);
		if ($rc) {
			if ($this->m_msg == "") {
				$this->m_msg = "cannot receive packet header (C6831)";
			}
			return -1;
		}

		$n_bytes_to_recv = bytes2int( $size_buf, 0 );
		$xor_key = bytes2int( $size_buf, 4 );

		$xor_key = my_xor($xor_key);

		if($n_bytes_to_recv != $xor_key)
		{
			$this->m_msg = "incompatible client version";
			return -1;
		}

		$data .= $size_buf;

		//receive body
		$rc = $this->RecvData($data_buf, $n_bytes_to_recv - 8);
		if ($rc) {
			if ($this->m_msg == "") {
				$this->m_msg = "cannot receive packet header (C6831)";
			}
			return -1;
		}

		$data .= $data_buf;

		$this->m_recv = $data;
		$this->m_recv_size = $n_bytes_to_recv;

		return 0;
	}
	
	function GetIPv4SocketAddress()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	//member variable
	var $m_msg;

	var $m_socket;

	var $m_recv;
	var $m_recv_size;
	var $m_send;
	var $m_send_size;

	var $m_time_out_sec;
	var $m_time_out_usec;

	var $m_linger_timeout;
}


?>
