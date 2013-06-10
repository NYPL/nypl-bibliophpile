<?php

/**
 * @file
 * PaginatedResource class 
 */

namespace NYPL\Bibliophpile;

/**
 * PaginatedResource is the base class for all resources whose results are 
 * divided up into pages.
 */
abstract class PaginatedResource extends ClientResource {
  /**
   * PaginatedResource object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {
    parent::__construct($data, $client);
    $this->initItems();
  }

  abstract protected function initItems();
  abstract public function gotoPage($page);

  /**
   * Returns the number of items in the resource.
   *
   * @return integer
   *   The count
   */
  public function count() {
    return $this->data->count;
  }

  /**
   * Returns the number of per page.
   *
   * @return integer
   *   The limit
   */
  public function limit() {
    return $this->data->limit;
  }

  /**
   * Returns the number of per pages for all the items.
   *
   * @return integer
   *   The page count
   */
  public function pages() {
    return $this->data->pages;
  }

  /**
   * Returns the current page within the set.
   *
   * @return integer
   *   The page
   */
  public function page() {
    return $this->data->page;
  }

  public function next() {
    try {
      return $this->gotoPage($this->page() + 1);
    } catch (NoSuchPageException $e) {
      throw new EndOfResultsException;
    }
  }
}