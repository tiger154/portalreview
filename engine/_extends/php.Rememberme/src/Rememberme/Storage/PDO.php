<?php
/* 
 * 
 */

/**
 * Store login tokens in database with PDO class
 *
 * @author birke
 */
class Rememberme_Storage_PDO extends Rememberme_Storage_DB {
    
  /**
   *
   * @var PDO
   * Changed to mysqli by revu 2012.08.27
   */
  protected $connection;

  public function findTriplet($credential, $token, $persistentToken) {
    // We don't store the sha1 as binary values because otherwise we could not use
    // proper XML test data
//	echo $token."</br>";
//	echo $persistentToken."</br>";
    $sql = "SELECT IF(SHA1(?) = {$this->tokenColumn}, 1, -1) AS token_match " .
           "FROM {$this->tableName} WHERE {$this->credentialColumn} = ? " .
           "AND {$this->persistentTokenColumn} = SHA1(?) LIMIT 1 "; 
	
    $query = $this->connection->prepare($sql);
	$query->bind_param('sss',$token, $credential, $persistentToken);
  	$query->execute();	
    $query->bind_result($token_match);
    $result = $query->fetch();	 
	
	$query->close();

    if(!$result) {
	//	echo 0;
      return self::TRIPLET_NOT_FOUND;
	  
    }
    elseif ($result == 1) {
		//echo 1;
      return self::TRIPLET_FOUND;
	  
    }
    else {
	//	echo -1;
      return self::TRIPLET_INVALID;
	  
    }
  }



  public function storeTriplet($credential, $token, $persistentToken, $expire=0) {
    $sql = "INSERT INTO {$this->tableName}({$this->credentialColumn}, " .
           "{$this->tokenColumn}, {$this->persistentTokenColumn}, " .
           "{$this->expiresColumn}) VALUES(?, SHA1(?), SHA1(?), ?)";
    $query = $this->connection->prepare($sql);
	$date_expire= date('Y-m-d H:i:s', $expire);
	$query->bind_param('ssss',$credential, $token, $persistentToken, $date_expire);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  }

  // made by revu 2012.08.31 for FB
  public function storeTriplet_fb($credential, $token, $persistentToken, $expire=0 , $sns_id) {
    $sql = "INSERT INTO {$this->tableName}({$this->credentialColumn}, " .
           "{$this->tokenColumn}, {$this->persistentTokenColumn}, " .
           "{$this->expiresColumn},{$this->fbColumn}) VALUES(?, SHA1(?), SHA1(?), ?,?)";
    $query = $this->connection->prepare($sql);
	$date_expire= date('Y-m-d H:i:s', $expire);
	$query->bind_param('sssss',$credential, $token, $persistentToken, $date_expire, $sns_id);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  }

   // made by revu 2012.08.31 for twit
  public function storeTriplet_twit($credential, $token, $persistentToken, $expire=0 , $sns_id) {
    $sql = "INSERT INTO {$this->tableName}({$this->credentialColumn}, " .
		"{$this->tokenColumn}, {$this->persistentTokenColumn}, " .
           "{$this->expiresColumn},{$this->twitColumn}) VALUES(?, SHA1(?), SHA1(?), ?,?)";
    $query = $this->connection->prepare($sql);
	$date_expire= date('Y-m-d H:i:s', $expire);
	$query->bind_param('sssss',$credential, $token, $persistentToken, $date_expire, $sns_id);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  }

    // made by revu 2012.08.31 for FB
  public function updateTriplet_twit($sns_id, $expire=0,$credential, $persistentToken, $token) {
	//echo $sns_id."</br>".$expire."</br>".$credential."</br>".$persistentToken."</br>".$token;	
	$sql =  "UPDATE {$this->tableName} SET ".
				"{$this->twitColumn} = ?, ".
			    "{$this->expiresColumn} = ? ".
				 "WHERE {$this->credentialColumn} = ? " .
				"AND {$this->persistentTokenColumn} = SHA1(?) " .
				 "AND {$this->tokenColumn} = SHA1(?)";

    $query = $this->connection->prepare($sql);
	$date_expire= date('Y-m-d H:i:s', $expire);
	$query->bind_param('sssss',$sns_id, $date_expire,$credential, $persistentToken, $token);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  } 



       // made by revu 2012.08.31 for FB
  public function updateTriplet_fb($sns_id, $expire=0,$credential, $persistentToken, $token) {
	//echo $sns_id."</br>".$expire."</br>".$credential."</br>".$persistentToken."</br>".$token;	
	$sql =  "UPDATE {$this->tableName} SET ".
				"{$this->fbColumn} = ?, ".
			    "{$this->expiresColumn} = ? ".
				 "WHERE {$this->credentialColumn} = ? " .
				"AND {$this->persistentTokenColumn} = SHA1(?) " .
				 "AND {$this->tokenColumn} = SHA1(?)";

    $query = $this->connection->prepare($sql);
	$date_expire= date('Y-m-d H:i:s', $expire);
	$query->bind_param('sssss',$sns_id, $date_expire,$credential, $persistentToken, $token);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  } 

  public function cleanTriplet($credential, $persistentToken) {
    $sql = "DELETE FROM {$this->tableName} WHERE {$this->credentialColumn} = ? " .
           " AND {$this->persistentTokenColumn} = SHA1(?)";
    $query = $this->connection->prepare($sql);
	$query->bind_param('ss',$credential, $persistentToken);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  }

  public function cleanAllTriplets($credential) {
    $sql = "DELETE FROM {$this->tableName} WHERE {$this->credentialColumn} = ? ";
    $query = $this->connection->prepare($sql);
	$query->bind_param('s',$credential);
    $query->execute();
	//printf("%d Row inserted.\n", $query->affected_rows);
  }

  public function getConnection() {
    return $this->connection;
  }

  public function setConnection(mysqli $connection) {
    $this->connection = $connection;
  }

}
?>
