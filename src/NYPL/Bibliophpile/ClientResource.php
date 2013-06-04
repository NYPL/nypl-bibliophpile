<?php

/**
 * @file
 * ClientResource class 
 */

namespace NYPL\Bibliophpile;

/**
 * ClientResource is the base class for all resources that have a reference to
 * to the master client and can therefore make additional API requests.
 */
class ClientResource extends DataResource {

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
    parent::__construct($data);
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
