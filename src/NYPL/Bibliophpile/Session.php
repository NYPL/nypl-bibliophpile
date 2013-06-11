<?php

/**
 * @file
 * Session class 
 */

namespace NYPL\Bibliophpile;

class Session extends ClientResource {

  /**
   * Fetch the name of the user attached to the session.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Fetch the session id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Fetch the session id.
   *
   * @return string
   *   The id
   */
  public function borrowerId() {
    return $this->data->borrower_id;
  }
}
