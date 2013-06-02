<?php

/**
 * @file
 * Library class 
 */

namespace NYPL\BiblioCommons\Api;

class Title extends ClientResource {

  protected $format;

  /**
   * Title object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {
    parent::__construct($data, $client);
    $this->format = new Format($this->data->format);
  }

  /**
   * Returns the titles's name (i.e. title).
   *
   * This method is not called title() so that there will be no confusion
   * about it being a constructor.
   *
   * @return string
   *   The title
   */
  public function name() {
    return $this->data->title;
  }

  /**
   * Returns the titles's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Returns the URL for the title on BiblioCommons.
   *
   * @return string
   *   The URL
   */
  public function details() {
    return $this->data->details_url;
  }

  /**
   * Returns the titles's format.
   *
   * @return \NYPL\BiblioCommons\Api\Format
   *   The format
   */
  public function format() {
    return $this->format;
  }
}
