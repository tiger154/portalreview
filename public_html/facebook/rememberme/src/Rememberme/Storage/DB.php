<?php
/* 
 * 
 */

/**
 * This abstract class contains properties with getters and setters for all
 * database storage classes
 *
 * @author Gabriel Birke
 */
abstract class Rememberme_Storage_DB implements Rememberme_Storage_StorageInterface {
  
  /**
   *
   * @var string
   */
  protected $tableName = "";

  /**
   *
   * @var string
   */
  protected $credentialColumn = "";

  /**
   *
   * @var string
   */
  protected $tokenColumn = "";

  /**
   *
   * @var string
   */
  protected $persistentTokenColumn = "";

  /**
   *
   * @var string
   */
  protected $expiresColumn = "";

  public function __construct($options) {
    foreach($options as $prop => $value) {
      $setter = "set".ucfirst($prop);
      if(method_exists($this, $setter)) {
        $this->$setter($value);
      }
    }
  }

  public function getTableName() {
    return $this->tableName;
  }

  public function setTableName($tableName) {
    $this->tableName = $tableName;
    return $this;
  }

  public function getCredentialColumn() {
    return $this->credentialColumn;
  }

  public function setCredentialColumn($credentialColumn) {
    $this->credentialColumn = $credentialColumn;
    return $this;
  }

  public function getTokenColumn() {
    return $this->tokenColumn;
  }

  public function setTokenColumn($tokenColumn) {
    $this->tokenColumn = $tokenColumn;
    return $this;
  }

  public function getPersistentTokenColumn() {
    return $this->persistentTokenColumn;
  }

  public function setPersistentTokenColumn($persistentTokenColumn) {
    $this->persistentTokenColumn = $persistentTokenColumn;
    return $this;
  }

  public function getExpiresColumn() {
    return $this->expiresColumn;
  }

  public function setExpiresColumn($expiresColumn) {
    $this->expiresColumn = $expiresColumn;
    return $this;
  }



}
?>
