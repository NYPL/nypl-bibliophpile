<?php

/**
 * @file
 * Client class
 */

namespace NYPL\Bibliophpile;

/**
 * Client provides for all the communication between the BiblioCommons API and
 * other classes in this library. Objects returned by methods of this class
 * hold their own references to the Client through which they were retrieved,
 * so all communication is made through a single instance of this class.
 */
class Client {

  /**
   * Base for all BiblioCommons API URLs.
   *
   * @var string
   */
  const API_BASE = 'https://api.bibliocommons.com';

  /**
   * Version of the BiblioCommons API used by this library
   *
   * @var string
   */
  const API_VERSION = 'v1';

  /**
   * The user's api key, supplied by BiblioCommons.
   *
   * @var string
   */
  protected $apikey = NULL;

  /**
   * HTTP client used by the Client
   *
   * @var \HTTP_Request2
   */
  protected $conn = NULL;

  /**
   * Client object constructor.
   *
   * @param string $key 
   *   Your API key
   * @param \HTTP_Request2 $conn 
   *   An \HTTP_Request2 object. If not supplied, the Client will create its
   *   own. A use for this parameter might be to supply the Client with a 
   *   an object of a custom class derived from HTTP_Request2
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
   *
   * @throws NYPL\Bibliophpile\JsonException 
   *   When the JSON response cannot be parsed
   */
  public function getEndpoint($path, $params = array()) {
    $all_params = array_merge($params, array('api_key' => $this->apikey));
    $url = implode('/', array(
      self::API_BASE,
      self::API_VERSION,
      $path));
    $this->conn->setUrl($url);
    $this->conn->getUrl()->setQueryVariables($all_params);
    $data = $this->conn->send()->getBody();
    $parsed = json_decode($data);

    if ($parsed !== NULL) {
      return $parsed;
    }

    throw new JsonException('Error parsing JSON');
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

  /**
   * Get a Title by ID.
   *
   * @param string $id
   *   The title's id
   *
   * @return Title
   *   The Title object
   */
  public function title($id) {
    $path = 'titles/' . $id;
    return new Title($this->getEndPoint($path)->title, $this);
  }

  /**
   * Get a Copies of a title by title ID.
   *
   * @param string $id
   *   The title's id
   *
   * @return array
   *   Array of Copy objects
   */
  public function copies($id) {
    $path = 'titles/' . $id . '/copies';
    $data = $this->getEndPoint($path);
    $copies = array();
    foreach ($data->copies as $copy) {
      $copies[] = new Copy($copy);
    }
    return $copies;
  }

  /**
   * Get a User by ID.
   *
   * @param string $id
   *   The users's id
   *
   * @return User
   *   The User object
   */
  public function user($id) {
    $path = 'users/' . $id;
    return new User($this->getEndPoint($path)->user, $this);
  }


}
