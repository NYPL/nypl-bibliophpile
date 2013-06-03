<?php

/**
 * @file
 * SimpleResource class 
 */

namespace NYPL\Bibliophpile;

class SimpleResource extends DataResource {

  /**
   * Fetch the resource's name.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Fetch the resource's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }
}
