<?php

/**
 * @file
 * ClientResource class 
 */

namespace NYPL\BiblioCommons\Api;

/**
 * ClientResource is the base class for all resources that have a reference to
 * to the master client and can therefor make additional API requests
 */
class ClientResource {


  /**
   * The parsed JSON data.
   *
   * @var StdObj
   */
  protected $data;

  /**
   * The client.
   *
   * @var \HTTP_Request2
   */
  protected $client;

  /**
   * ClientResource object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {
    $this->data = $data;
    $this->client = $client;
  }

  /**
   * Returns the resources's client.
   *
   * @return \HTTP_Request2
   *   The client
   */
  public function client() {
    return $this->client;
  }
}
