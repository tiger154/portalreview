<?php

/**
 * Wrapper around setcookie function for better testability
 */ 
class Rememberme_Cookie {

  /**
   * @var string
   */
  protected $path = "/";

  /**
   * @var string
   */
  protected $domain = false;

  protected $secure = false;

  protected $httpOnly = false;


  public function setCookie($name, $value = "",  $expire = 0) {
    return setcookie($name, $value,  $expire, $this->path, $this->domain, $this->secure, $this->httpOnly);
  }

  public function getPath() {
    return $this->path;
  }

  public function setPath(string $path) {
    $this->path = $path;
  }

  public function getDomain() {
    return $this->domain;
  }

  public function setDomain($domain) {
    $this->domain = $domain;
  }

  public function getSecure() {
    return $this->secure;
  }

  public function setSecure($secure) {
    $this->secure = $secure;
  }

  public function getHttpOnly() {
    return $this->httpOnly;
  }

  public function setHttpOnly($httponly) {
    $this->httpOnly = $httponly;
  }
}
  
