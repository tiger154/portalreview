<?php
class Encrypter
{
	public function Encrypter()
	{
	}
	
    public function encryptMD5($buf, $key="password")
    {
		$key1 = pack("H*",md5($key));
		while($buf)
		{
			$m = substr($buf, 0, 16);
			$buf = substr($buf, 16);
			$c = "";
			for($i=0;$i<16;$i++) $c .= $m{$i}^$key1{$i};
			$ret_buf .= $c;
			$key1 = pack("H*",md5($key.$key1.$m));
		}
		$len = strlen($ret_buf);
		for($i=0; $i<$len; $i++) $hex_data .= sprintf("%02x", ord(substr($ret_buf, $i, 1)));
		return($hex_data);
    }
	
	public function decryptMD5($hex_buf, $key="password")
    {
		$len = strlen($hex_buf);
		for ($i=0; $i<$len; $i+=2) $buf .= chr(hexdec(substr($hex_buf, $i, 2)));
		$key1 = pack("H*", md5($key));
		while($buf)
		{
			$m = substr($buf, 0, 16);
			$buf = substr($buf, 16);           
			$c = "";
			for($i=0;$i<16;$i++) $c .= $m{$i}^$key1{$i};           
			$ret_buf .= $m = $c;
			$key1 = pack("H*",md5($key.$key1.$m));
		}
		return($ret_buf);
    }
	
	public function byteXorMD5($str1, $str2)
	{
		$string = "";
		for($i=0; $i<16; $i++)
			$string .= $str1{$i}^$str2{$i};
		return $string;
	}

	public function encryptSha1($msg)
	{
		for($i=1; $i<=10; $i++) $key .= substr('0123456789abcdef', rand(0,15), 1);
		$string = sha1($key.$msg.$key).$key;
		return $string;
	}

	public function encryptSha1Check($msg, $encrypt_msg)
	{
		if (strlen($encrypt_msg) != 50) return false;
		$encrypt_key = substr($encrypt_msg,40,10);
		$decrypt_msg = sha1($encrypt_key.$msg.$encrypt_key).$encrypt_key;
		if ($decrypt_msg == $encrypt_msg) return true;
		else return false;
	}

	public function encryptSha256($msg)
	{
		for($i=1; $i<=10; $i++) $key .= substr('0123456789abcdef', rand(0,15), 1);
		$string = sha256($key.$msg.$key).$key;
		return $string;
	}

	public function encryptSha256Check($msg, $encrypt_msg)
	{
		if (strlen($encrypt_msg) != 50) return false;
		$encrypt_key = substr($encrypt_msg,40,10);
		$decrypt_msg = sha256($encrypt_key.$msg.$encrypt_key).$encrypt_key;
		if ($decrypt_msg == $encrypt_msg) return true;
		else return false;
	}
	
	public function createGUID() {
    	if(function_exists('com_create_guid')) {
    		echo "1<br />";
    		return com_create_guid();
		} else {
			echo "2<br />";
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45); // "-"
			$uuid = chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12)
            .chr(125);// "}"
            return $uuid;
		}
	}
}
?>