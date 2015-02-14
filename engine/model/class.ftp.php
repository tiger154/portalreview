<?php
class Ftp
{
	var $connect;
	var $login;

	public function Ftp()
	{
	}

	public function _getConnectInfo($name)
	{
		$cfile = _DIR_ENGINE."/_conf/ftp.".$name.".ini";
		if(!is_file($cfile)) {
			Module::msg("3006");
		}
		$ftpConf = parse_ini_file(_DIR_ENGINE."/_conf/ftp.".$name.".ini");
		return $ftpConf;
	}
	
	public function connect($name)
	{
		$ftpConf = $this->_getConnectInfo($name);		
		$this->close();
		$this->connect = ftp_connect($ftpConf['IP'], $ftpConf['PORT'], $ftpConf['TIMEOUT']);
		$this->login = ftp_login($this->connect, $ftpConf['ID'], $ftpConf['PASSWD']);		
		if ((!$this->connect) || (!$this->login)) {
			Module::msg("3007", "FTP정보=>$name 서버<br/><hr />");
		}
		$this->_passive();
	}
	
	public function connect2($name)
	{
		$ftpConf = $this->_getConnectInfo($name);		
		$this->close();
		$this->connect = ftp_connect($ftpConf['IP'], $ftpConf['PORT'], $ftpConf['TIMEOUT']);
		$this->login = ftp_login($this->connect, $ftpConf['ID'], $ftpConf['PASSWD']);		
		if ((!$this->connect) || (!$this->login)) {
			Module::msg("3007", "FTP정보=>$name 서버<br/><hr />");
		}
		$this->_passive();
	}

	public function sconnect($name)
	{
		$ftpConf = $this->_getConnectInfo($name);		
		$this->close();
		$this->connect = @ftp_ssl_connect($ftpConf['IP'], $ftpConf['PORT'], $ftpConf['TIMEOUT']);
		$this->login = @ftp_login($this->connect, $ftpConf['ID'], $ftpConf['PASSWD']);
		if ((!$this->connect) || (!$this->login)) {
			Module::msg("3007", "FTP정보=>$name 서버<br/><hr />");
		}
		$this->_passive();
	}
	
	public function close()
	{
		if(!empty($this->connect)) {
			@ftp_close($this->connect);
		}
	}

	private function _passive()
	{
		 if(!@ftp_pasv($this->connect, true)) {
			 return true;
		 } else {
			 return false;
		 }

	}
	
	public function rlist($dir='.')
    { 
        return @ftp_rawlist($this->connect, $dir); 
    } 

	public function nlist($dir) 
	{ 
		return @ftp_nlist($this->connect, $dir.'/'); 
	}

	public function nlist2($dir) 
	{ 
		//echo "dir:$dir<br>";
		return @ftp_nlist($this->connect, $dir.'/'); 
	}	

	public function rename($oName, $nName) 
	{
		if(@ftp_rename($this->connect, $oName, $nName)) {
			$this->mdtm($newnm);
			return true;
		} else {
			return false;
		}
	}

	public function upload($file1, $file2, $mode="FTP_BINARY")
	{
		if($mode == "FTP_BINARY") {
			$res = @ftp_put($this->connect, $file1, $file2, FTP_BINARY);
		} else {
			$res = @ftp_put($this->connect, $file1, $file2, FTP_ASCII);
		}
		return $res;
	}
	
	public function mdtm($file) 
	{ 
		if(!$file) {
			return false; 
		}
		$res = @ftp_mdtm($this->connect, $file); 
		if($res == -1) {
			return ''; 
		} else {
			return $res; 
		}
	}
	
	public function delete($file) 
	{ 
		if(@ftp_delete($this->connect, $file)) {
			return true;
		} else {
			return false;
		}
	}

	public function makeDir($dir)
	{
		if(@ftp_mkdir($this->connect, $dir)) {
			return true;
		} else {
			//echo "실패"
			return false;
		}
	}

	public function getFile($file1, $file2)
	{
		$fp = fopen($file2, 'w');
		$res = @ftp_fget($this->connect, $fp, $file1, FTP_BINARY);
		return $res;
	}
	
	public function move($file1, $file2)
	{
		$res = @ftp_rename($this->connect, $file1, $file2);
		return $res;
	}
	
	public function pwd() 
	{
		$dir = @ftp_pwd($this->connect);
		return $dir;
	}

}
?>