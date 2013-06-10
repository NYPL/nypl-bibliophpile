<?php

/**
 * @file
 * Users class 
 */

namespace NYPL\Bibliophpile;

/**
 * Users represents a list of user search results.
 */
class Users extends PaginatedResource {

  /**
   * Query string used to retrieve this list of users.
   */
  protected $query;

  /**
   * Users object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   * @param string $query
   *   Query string used to retrieve this list of users
   */
  public function __construct($data, $client, $query) {
    parent::__construct($data, $client);
    $this->query = $query;
  }

  /**
   * Initialize the users in this object.
   */
  protected function initItems() {
    $users = array();
    foreach ($this->data->users as $user) {
      $users[] = new User($user, $this->client);
    }
    $this->data->users = $users;
  }

  /**
   * Returns the users contained in this resource.
   *
   * @return array
   *   The users
   */
  public function users() {
    return $this->data->users;
  }

  /**
   * Retrieve a specific page of results.
   *
   * @return array
   *   The users
   * @throws NoSuchPageException
   *   If an attempt is made to retrieve a page less the 1 or greater than the
   *   number of pages in the set.
   */
  public function gotoPage($page) {
    if ($page > $this->pages() || $page < 1) {
      throw new NoSuchPageException();
    }

    $data = $this->client()->users($this->query, $page, $this->limit(), FALSE);

    $this->data = $data;
    $this->initItems();
    return $this->users();
  }
}
