<?php

/**
 * @file
 * Client class 
 */

namespace NYPL\BiblioCommons\Api;

class Client {

  const API_BASE = 'https://api.bibliocommons.com';
  const API_VERSION = 'v1';

  protected $apikey = NULL;
  protected $conn = NULL;

  /**
   * Client object constructor.
   *
   * @param string $key 
   *   Your API key
   */
  public function __construct($key, $conn = NULL) {
    $this->apikey = $key;
    if ($conn === NULL) {
      $this->conn = new \HTTP_Request2();
    }
    else {
      $this->conn = $conn;
    }
  }

  public function apikey() {
    return $this->apikey;
  }

  public function conn() {
    return $this->conn;
  }

  public function getEndpoint($path, $params=array()) {
    $all_params = array_merge($params, array('api_key' => 'few2vjhmdnhjhw7xnajj9wxt'));
    $url = implode('/', array(
      self::API_BASE,
      self::API_VERSION,
      $path));
    $this->conn->setUrl($url);
    $this->conn->getUrl()->setQueryVariables($all_params);
    $data =  $this->conn->send()->getBody();
    return json_decode($data);

  }

  public function library($id) {
    $path = 'libraries/' . $id;
    return new Library($this->getEndPoint($path)->library, $this);
  }
}
