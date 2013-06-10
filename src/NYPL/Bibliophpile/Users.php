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

  protected $query;

  public function __construct($data, $client, $query) {
    parent::__construct($data, $client);
    $this->query = $query;
  }

  protected function initItems() {
    $users = array();
    foreach ($this->data->users as $user) {
        $users[] = new User($user, $this->client);
    }
    $this->data->users = $users;
  }

  public function users() {
    return $this->data->users;
  }

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