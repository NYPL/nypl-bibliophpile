<?php

/**
 * @file
 * Titles class 
 */

namespace NYPL\Bibliophpile;

/**
 * Users represents a list of user search results.
 */
class Titles extends PaginatedResource {

  /**
   * Query string used to retrieve this list of titles.
   */
  protected $query;
  protected $library;
  protected $search_type;

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
  public function __construct($data, $client, $query, $library, $search_type) {
    parent::__construct($data, $client);
    $this->query = $query;
    $this->library = $library;
    $this->search_type = $search_type;
  }

  /**
   * Initialize the users in this object.
   */
  protected function initItems() {
    $titles = array();
    foreach ($this->data->titles as $title) {
      $titles[] = new Title($title, $this->client);
    }
    $this->data->titles = $titles;
  }

  /**
   * Returns the users contained in this resource.
   *
   * @return array
   *   The users
   */
  public function titles() {
    return $this->data->titles;
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

    $data = $this->client()->titles($this->query, 'a', 'b', $page, $this->limit(), FALSE);
    $this->data = $data;
    $this->initItems();
    return $this->titles();
  }
}
