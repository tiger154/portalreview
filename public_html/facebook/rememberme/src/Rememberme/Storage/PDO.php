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
      return self::TRIPLET_NOT_FOUND;
    }
    elseif ($result == 1) {
      return self::TRIPLET_FOUND;
    }
    else {
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
	printf("%d Row inserted.\n", $query->affected_rows);
  }

  public function cleanTriplet($credential, $persistentToken) {
    $sql = "DELETE FROM {$this->tableName} WHERE {$this->credentialColumn} = ? " .
           " AND {$this->persistentTokenColumn} = SHA1(?)";
    $query = $this->connection->prepare($sql);
	$query->bind_param('ss',$credential, $persistentToken);
    $query->execute();
	printf("%d Row inserted.\n", $query->affected_rows);
  }

  public function cleanAllTriplets($credential) {
    $sql = "DELETE FROM {$this->tableName} WHERE {$this->credentialColumn} = ? ";
    $query = $this->connection->prepare($sql);
	$query->bind_param('s',$credential);
    $query->execute();
	printf("%d Row inserted.\n", $query->affected_rows);
  }

  public function getConnection() {
    return $this->connection;
  }

  public function setConnection(mysqli $connection) {
    $this->connection = $connection;
  }

}
?>
