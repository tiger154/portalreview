<?php
class Connect
{
	var $conf;			
	var $changeFlag;	
	var $position;		
	var $dbms;			
	var $host;			
	var $port;			
	var $name;			
	var $id;			
	var $passwd;		
	var $charset;		
	var $rate;			
	var $link;			
	var $linkType;		
	var $result;		
	var $queryString;	
	var $count;			

	public function Connect($conf, $linkType="mysqli")
	{
		$dbConfig			= $this->_getPositionInfo($conf);
		$this->conf			= $conf;
		$this->changeFlag	= 0;
		$this->position		= $dbConfig["POSITION"];
		$this->dbms			= $dbConfig["DBMS"];
		$this->host			= $dbConfig["HOST"];
		$this->port			= $dbConfig["PORT"];
		$this->name			= $dbConfig["NAME"];
		$this->id			= $dbConfig["ID"];
		$this->passwd		= $dbConfig["PASSWD"];
		$this->charset		= $dbConfig["CHARSET"];
		$this->rate			= $dbConfig["RATE"];
		$this->linkType		= (strlen(trim($linkType))>0) ? $linkType : "";
		$this->count		= 0;
		if(trim($this->port) == "") $this->port = "3306";
		$this->_connect();
		register_shutdown_function(array($this, "close"));
		return $this->link;
	}

	public function rConnect()
	{
		$this->_connect();			
	}

	private function _connect()
	{
		switch($this->dbms)
		{
			case "mysql" :
				switch($this->linkType)
				{
					case "mysqli" :
						$this->link = $this->_mysqliConnect();
						if(trim($this->charset) != "") $this->link->query("SET charset ".$this->charset);
						break;
					default :
						$this->link = $this->_mysqlConnect();
						if(trim($this->charset) != "") mysql_query("SET charset ".$this->charset);
						break;
				}
				break;

			case "mssql" :
				$this->link = $this->_mssqlConnect();
				break;

			case "oracle" :
				$this->link = $this->_oracleConnect();
				break;

			default :
				Module::msg("3001");
				return false;
				break;
		}
		$this->_insertConnectInfo();
	}

	private function _mysqlConnect()
	{
		$connect = mysql_connect($this->host.":".$this->port, $this->id, $this->passwd, true) or Module::msg("3002", "$this->dbms >> $name DB 접속설정을 확인하세요.");
		if($connect == true) {
			mysql_select_db($this->name);
		} else {
			//print(mysql_error());
			Module::msg("3002", "$this->dbms >> $name DB 접속설정을 확인하세요.");
		}
		return $connect;
	}

	private function _mysqliConnect()
	{
		if(!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
			Module::msg("3030", "");
		}
		$connect = new mysqli($this->host, $this->id, $this->passwd, $this->name, $this->port);
		
		if($connect == true) {
			return $connect;
		} else {
			Module::msg("3002", "$this->dbms >> $name DB 접속설정을 확인하세요.");
		}
		return $connect;
	}

	private function _mssqlConnect()
	{
		$connect = mssql_connect($this->host.":".$this->port, $this->id, $this->passwd, true) or Module::msg("3002", "$this->dbms >> $name DB 접속설정을 확인하세요.");
		if($connect == true) {
			mssql_select_db($this->name);
		} else {
			print(mssql_error());
		}
		return $connect;
	}

	private function _oracleConnect()
	{
		$connect = oci_connect($this->id, $this->passwd, $this->host.":".$this->port, $this->charset) or Module::msg("3002", "$this->dbms >> $name DB 접속설정을 확인하세요.");
		if($connect == true) {
			mysql_select_db($this->name);
		} else {
			print(oci_error());
		}
		return $connect;
	}

	private function _insertConnectInfo()
	{
		global $CONNECT;
		$CONNECT[$this->conf][$this->name]['link'] = $this->link;
		if($CONNECT[$this->conf][$this->name] != "") return true;
		else return false;
	}

	private function _getConnectInfo()
	{
		$dbConf = parse_ini_file(_DIR_CONF."/db.".$this->conf.".ini", true);
		return $dbConf;
	}		

	private function _getPositionInfo($name, $position="")
	{
		$dbConf = parse_ini_file(_DIR_CONF."/db.".$name.".ini", true);
		if($position=="") {
			return $dbConf['MASTER'];
		} else {
			return $dbConf[$position];
		}
	}

	private function _isSelectQuery($query)
	{
		if(preg_match('/(select)/i',substr(trim($query),0,6))) {
			return true;
		} else {
			return false;
		}
	}

	private function _position()
	{
		$dbConf = $this->_getConnectInfo();
		$_trate = 0;
		$_rate = 0;
		$_rand = 0;
		$position = "MASTER";
		foreach($dbConf as $key => $val) {
			$_trate += $val['RATE'];
		}
		$_rand = rand(1, $_trate);
		foreach($dbConf as $key => $val) {			
			$_rate += $val['RATE'];
			if($_rand <= $_rate) {
				$position = $key;
				break;
			}
		}
		return $position;
	}

	public function error()
	{
		switch($this->dbms)
		{
			case "mysql" :
				switch($this->linkType)
				{
					case "mysqli" : $error = mysqli_error($this->link); break;
					default : $error = mysql_error($this->link); break;
				}
				break;
			case "mssql" : $error = "error"; break; //$error = mssql_error($this->link);
			case "oracle" : $error = oci_error($this->link); break;
			default : break;
		}
		return $error;		
	}

	public function close()
	{
		switch($this->dbms)
		{
			case "mysql" :
				switch($this->linkType)
				{
					case "mysqli" : $result = mysqli_close($this->link); break;
					default : $result = mysql_close($this->link); break;
				}
				break;

			case "mssql" : $result = mssql_close($this->link); break;
			case "oracle" : $result = oci_close($this->link); break;
			default : break;
		}

		if($result == false) {
			Module::msg("3002");
			return false;
		} else {
			GLOBAL $CONNECT;
			unset($CONNECT[$this->name]);
			return true;
		}
	}

	public function change($position, $linkType="")
	{
		if(is_resource($this->link)) $this->close();
		$dbConfig = $this->_getPositionInfo($this->conf, $position);
		$this->position		= $dbConfig["POSITION"];
		$this->dbms			= $dbConfig["DBMS"];
		$this->host			= $dbConfig["HOST"];
		$this->port			= $dbConfig["PORT"];
		$this->name			= $dbConfig["NAME"];
		$this->id			= $dbConfig["ID"];
		$this->passwd		= $dbConfig["PASSWD"];
		$this->charset		= $dbConfig["CHARSET"];
		$this->rate			= $dbConfig["RATE"];
		$this->linkType		= (strlen(trim($linkType))>0) ? $linkType : $this->linkType;
		$this->count		= 0;
		if(trim($this->port) == "") $this->port = "3306";
		$this->_connect();
	}	

	public function query($query)
	{
		$_sTime = Module::getMicroTime();
		//$this->queryString = mysql_real_escape_string($query);
		$this->queryString = $query;
		switch($this->dbms)
		{
			case "mysql" :
				switch($this->linkType)
				{
					//case "mysql" : $this->result = mysql_query($query, $this->link); break;
					case "mysql" : $this->result = $this->link->query($query); break;
					default : $this->result = $this->link->query($query); break;
				}
				break;
			case "mssql" : $this->result = mssql_query($query, $this->link); break;
			case "oracle" : break; // 현재업데이트중
			default : break;
		}
		$_eTime = Module::getMicroTime();
		$_runTime = Module::getRunTime($_sTime, $_eTime);
		
		if($this->result == false) {
			$error = $this->error();
			//Module::debug("4001", "데이터베이스 => $this->name <br/>쿼리 => $query <br/>에러내용 => $error");
			//Module::alert("데이터 베이스 처리가 정상적으로 이루어 지지 않았습니다.");
			//Module::redirect("/notpage");
			return false;
		} else {
			//Module::debug("9002", "데이터베이스 => $this->name <br/>수행시간 => $_runTime sec <br/>쿼리 => $query");
		}
		return true;
	}

	public function fetch($query, $flagRow=false, $flagMaster=false, $isUnion=0)
	{
		$count = 0;
		$retArray = array();
		$this->queryString = $query;
		if($this->_isSelectQuery($query) == false  && $isUnion == 0) {
			$error = $this->error();
			Module::msg("4004", "데이터베이스 => $this->name <br/>쿼리 => $query <br/>에러내용 => $error");
			return false;
		} else {
			if($flagMaster == true) { 
				$this->change("MASTER");
				$this->changeFlag = false;				
			} else {
				$position = $this->_position();
				$this->change($position);
				$this->changeFlag = true;
			}
		}
		switch($this->dbms)
		{
			case "mysql" :				
				switch($this->linkType)
				{
					case "mysql" :
						//print("mysql-fetch");
						$this->query($query);
						if($this->result == true) {
							while($rows = mysql_fetch_assoc($this->result))
							{
								$retArray[$count] = $rows;
								++$count;
							}
							mysql_free_result($this->result);
						} else {
							$error = $this->error();
						}
						unset($rows);
						break;

					default :
						//print("mysqli-fetch");						
						$this->query($query);
						if($this->result == true) {
							while($rows = mysqli_fetch_assoc($this->result))
							{
								$retArray[$count] = $rows;
								++$count;
							}							
							mysqli_free_result($this->result);
						} else {
							$error = $this->error();
						}
						break;
				}
				if($this->result == false) {
					Module::msg("4002", "데이터베이스 => $this->name <br/>쿼리 => $query <br/>에러내용 => $error");
				}
				break;
			case "mssql" : break;
			case "oracle" : break;
			default : break;
		}
		if($this->changeFlag == true) {
			$this->changeFlag = false;
			$this->change("MASTER");
		}
		$this->count = $count;
		
		
		if($flagRow == true) {			
			return $retArray[0];
		} else {
			return $retArray;
		}
	}

	public function call($procName, $dataArray) 
	{
		$_sTime = Module::getMicroTime();
		$query = "CALL ".$procName."(";		
		for($i=0;$i<sizeof($dataArray);$i++) {
			$dataArray[$i] = addslashes($dataArray[$i]);
			$query .= ($i==0) ? "'".$dataArray[$i]."'" : ",'".$dataArray[$i]."'";
		}
		$query.= ");";
		$this->queryString = $query;
		switch($this->dbms)
		{
			case "mysql" :
				switch($this->linkType)
				{
					case "mysql" :
						//$this->result = mysql_query($query, $this->link);
						$this->result = $this->link->query($query);
						if($this->result == true) $row = mysql_fetch_assoc($this->result);
						$error = $this->error();
						break;

					default :
						$this->result = $this->link->query($query);
						if($this->result == true) $row = $this->result->fetch_assoc();
						$error = $this->link->error;
						break;
				}
				if($this->result != true) {
					Module::msg("4005", "데이터베이스 => $this->name <br/>쿼리 => $query <br/>에러내용 => $error");
				}
				break;
			case "mssql" : break;
			case "oracle" : break;
			default : break;
		}
		$_eTime = Module::getMicroTime();
		$_runTime = Module::getRunTime($_sTime, $_eTime);
		Module::debug("9002", "데이터베이스 => $this->name <br/>수행시간 => $_runTime sec <br/>쿼리 => $query");
		return $row;
	}

	public function insertID()
	{
		$query = "SELECT LAST_INSERT_ID() as insertID";
		$this->query($query);
		$this->queryString = $query;
		switch($this->dbms)
		{
			case "mysql" :	
				switch($this->linkType)
				{
					case "mysql" :
						if($this->result == true) {
							$row = mysql_fetch_assoc($this->result);
							mysql_free_result($this->result);
						} else {
							$error = $this->error();
						}						
						break;

					default :
						if($this->result == true) {
							$row = mysqli_fetch_assoc($this->result);
							mysqli_free_result($this->result);
						} else {
							$error = $this->error();
						}						
						break;
				}
				if($this->result == false) {
					Module::msg("4001", "데이터베이스 => $this->name <br/>쿼리 => $query <br/>에러내용 => $error");
				}
				break;
			case "mssql" : 
				break;
			case "oracle" :
				break;
			default :
				break;
		}
		return $row['insertID'];
	}

	public function transaction($val=false)
	{
		switch($this->dbms)
		{
			case "mysql" : $this->link->autocommit($val); break;
			case "mssql" : break;
			case "oracle" : break;
			default : break;
		}
	}

	public function commit($res)
	{
		$err_cnt = 0;
		if(sizeof($res) > 0) {
			foreach($res as $key => $val) {
				if($val == false || empty($val) || !isset($val)) $err_cnt++;
			}
		}
		if($err_cnt < 1) {
			switch($this->dbms)
			{
				case "mysql" : $this->link->commit(); break;
				case "mssql" : break;
				case "oracle" : break;
				default : break;
			}
			return true;
		} else {
			switch($this->dbms)
			{
				case "mysql" : $this->link->rollback(); break;
				case "mssql" : break;
				case "oracle" : break;
				default : break;
			}
			return false;
		}
	}
}
?>
