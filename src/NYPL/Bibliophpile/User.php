<?php

/**
 * @file
 * User class 
 */

namespace NYPL\Bibliophpile;

class User extends ClientResource {

  /**
   * Fetch the user's name.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Fetch the user's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Fetch the URL for the user's profile on BiblioCommons.
   *
   * @return string
   *   The URL
   */
  public function profile() {
    return $this->data->profile_url;
  }
}
