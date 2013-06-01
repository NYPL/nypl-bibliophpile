<?php

/**
 * @file
 * SimpleResource class 
 */

namespace NYPL\BiblioCommons\Api;

class SimpleResource {

  protected $data;

  /**
   * SimpleResource object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   */
  public function __construct($data) {
    $this->data = $data;
  }

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
