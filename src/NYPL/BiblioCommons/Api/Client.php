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

  /**
   * Fetch the api key supplied to the Client.
   *
   * @return string
   *   The key
   */
  public function apikey() {
    return $this->apikey;
  }

  /**
   * Fetch HTTP Client this Client this client is using.
   *
   * @return HTTP_Request2
   *   The HTTP client
   */
  public function conn() {
    return $this->conn;
  }

  /**
   * Get an endpoint and parse the JSON.
   *
   * @param string $path
   *   The path fragment for the endpoint that is, the part of the URL 
   *   following the version string. This should not begin with a slash
   * @param array $params
   *   Extra options to be passed the endpoint as query parameters
   *
   * @return StdObj
   *   The parsed JSON
   */
  public function getEndpoint($path, $params = array()) {
    $all_params = array_merge($params, array('api_key' => 'few2vjhmdnhjhw7xnajj9wxt'));
    $url = implode('/', array(
      self::API_BASE,
      self::API_VERSION,
      $path));
    $this->conn->setUrl($url);
    $this->conn->getUrl()->setQueryVariables($all_params);
    $data = $this->conn->send()->getBody();
    return json_decode($data);

  }

  /**
   * Get a Library by ID.
   *
   * @param string $id
   *   The library's id (e.g. 'nypl')
   *
   * @return Library
   *   The Library object
   */
  public function library($id) {
    $path = 'libraries/' . $id;
    return new Library($this->getEndPoint($path)->library, $this);
  }

  /**
   * Get the locations for a library.
   *
   * @param string $id
   *   The library's id (e.g. 'nypl')
   *
   * @return array
   *   Array of Location objects
   */
  public function locations($id) {
    $path = 'libraries/' . $id . '/locations';
    $locations = array();
    foreach ($this->getEndPoint($path)->locations as $l) {
      $locations[] = new Location($l);
    }
    return $locations;
  }
}
