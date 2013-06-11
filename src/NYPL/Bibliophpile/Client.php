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
    // $data = $this->conn->send()->getBody();
    $response = $this->conn->send();
    $data = $response->getBody();
    if ($response->getStatus() === 200) {
      $parsed = json_decode($data);

      if ($parsed !== NULL) {
        return $parsed;
      }

      throw new JsonException('Error parsing JSON');
    }
    throw new RequestException('Request failed with code ' . $response->getStatus());
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
   * Get a list by ID.
   *
   * @param string $id
   *   The list's id (e.g. 'nypl')
   *
   * @return ItemList
   *   The ItemList object
   */
  public function itemList($id) {
    $path = 'lists/' . $id;
    return new ItemList($this->getEndPoint($path)->list, $this);
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

  public function titles($q, $library, $search_type = 'keyword', $page = 1, $limit = 10, $as_object = TRUE) {
    $path = 'titles';
    $result = $this->getEndPoint($path,
      array(
        'q' => $q,
        'library' => $library,
        'search_type' => $search_type,
        'page' => $page,
        'limit' => $limit,
      ));
    if ($as_object === TRUE) {
      return new Titles($result, $this, $q, $library, $search_type);
    }
    return $result;
  }

  /**
   * Query users by username.
   *
   * Currently, this endpoint only looks for exact matches and returns 0 or 1
   * result. The form of the response however indicates the possibility of 
   * substring searches with multiple results.
   *
   * @param string $q
   *   The string to search
   *
   * @return User
   *   The User object
   */
  public function users($q, $page = 1, $limit = 10, $as_object = TRUE) {
    $path = 'users';
    if ($as_object === TRUE) {
      return new Users($this->getEndPoint($path,
        array(
          'q' => $q,
          'page' => $page,
          'limit' => $limit,
        )), $this, $q);
    }
    return $this->getEndPoint($path,
      array(
        'q' => $q,
        'page' => $page,
        'limit' => $limit,
      ));
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

  /**
   * Get a User's lists by ID.
   *
   * @param string $id
   *   The users's id
   * @param int $page
   *   The desired page from the paginated response
   * @param int $limit
   *   The desired items per page in the paginated response
   *
   * @return User
   *   The User object
   */
  public function userLists($id, $page = 1, $limit = 10, $as_object = TRUE) {
    $path = 'users/' . $id . '/lists';
    if ($as_object === TRUE) {
      return new ItemLists($this->getEndPoint($path,
        array(
          'page' => $page,
          'limit' => $limit,
        )), $this, $id);
    }

    return $this->getEndPoint($path, array('page' => $page, 'limit' => $limit));

  }

  /**
   * Get a Session by ID.
   *
   * @param string $id
   *   The session id
   *
   * @return Session
   *   The Session object
   */
  public function session($id) {
    $path = 'sessions/' . $id;
    return new Session($this->getEndPoint($path)->session, $this);
  }

  /**
   * Get the borrower.
   *
   * @param string $library_id
   *   The library's id (e.g. 'nypl')
   *
   * @param string $borrower_id
   *   The library's id
   *
   * @return Borrower
   *   The borrower
   */
  public function borrower($library_id, $borrower_id) {
    $path = 'libraries/' . $library_id . '/borrowers/' . $borrower_id;
    return new Borrower($this->getEndPoint($path)->borrower, $this);
  }
}
