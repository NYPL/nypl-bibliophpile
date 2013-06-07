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
}