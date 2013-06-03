<?php

/**
 * @file
 * Location class 
 */

namespace NYPL\Bibliophpile;

class Series extends DataResource {

  /**
   * Series object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   */
  public function __construct($data) {
    parent::__construct($data);
    $this->initOptionalProperties();
  }

  /**
   * Initialize optional properties.
   */
  protected function initOptionalProperties() {
    $this->initOptionalProperty('number', 'string');
  }

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
