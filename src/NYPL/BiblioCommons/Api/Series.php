<?php

/**
 * @file
 * Location class 
 */

namespace NYPL\BiblioCommons\Api;

class Location extends DataResource {

  /**
   * Returns the series' name.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Returns the series' number.
   *
   * @return string
   *   The number
   */
  public function number() {
    return $this->data->number;
  }
}
