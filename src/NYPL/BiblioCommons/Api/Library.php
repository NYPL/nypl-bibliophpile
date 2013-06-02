<?php

/**
 * @file
 * Library class 
 */

namespace NYPL\BiblioCommons\Api;

class Library extends ClientResource {

  /**
   * Fetch the library's name.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Fetch the library's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Fetch the URL for the library's on BiblioCommons.
   *
   * @return string
   *   The URL
   */
  public function catalog() {
    return $this->data->catalog_url;
  }

  /**
   * Fetch the library's locations.
   *
   * @return array
   *   List of Location objects
   */
  public function locations() {
    return $this->client->locations($this->id());
  }
}
