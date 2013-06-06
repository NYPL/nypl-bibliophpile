<?php

/**
 * @file
 * ListUrl class 
 */

namespace NYPL\Bibliophpile;

class ListUrl extends DataResource {

  /**
   * Url object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   */
  public function __construct($data) {
    parent::__construct($data);
  }

  /**
   * Returns the url's title.
   *
   * @return string
   *   The title
   */
  public function title() {
    return $this->data->title;
  }

  /**
   * Returns the url.
   *
   * @return string
   *   The url
   */
  public function url() {
    return $this->data->url;
  }
}
