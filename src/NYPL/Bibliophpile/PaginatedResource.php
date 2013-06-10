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

  /**
   * Initialize the items that this list is made of.
   *
   * Each class derived from PaginateResource will be a container of a 
   * different type of item, so each derived class will have to tailor the 
   * initialization of those items.
   */
  abstract protected function initItems();

  /**
   * Retrieve a specific page from the paginated set.
   *
   * Each class derived from PaginateResource will need to call a different 
   * endpoint and may need to perform initialization of contained items. This
   * method will update the objects data in place (i.e., the object will return
   * a differnt page number after this method is called and a list of different
   * items).
   *
   * @param int $page
   *   The desired page.
   *
   * @return array
   *   An array of the items that the PaginatedResource contains
   * @throws NoSuchPageException
   *   If an attempt is made to retrieve a page less the 1 or greater than the
   *   number of pages in the set.
   */
  abstract public function gotoPage($page);

  /**
   * Returns the number of items in the resource.
   *
   * @return int
   *   The count
   */
  public function count() {
    return $this->data->count;
  }

  /**
   * Returns the number of per page.
   *
   * @return int
   *   The limit
   */
  public function limit() {
    return $this->data->limit;
  }

  /**
   * Returns the number of per pages for all the items.
   *
   * @return int
   *   The page count
   */
  public function pages() {
    return $this->data->pages;
  }

  /**
   * Returns the current page within the set.
   *
   * @return int
   *   The page
   */
  public function page() {
    return $this->data->page;
  }

  /**
   * Retrieve the next page of items.
   *
   * This method calls gotoPage() and updates all the same data in the object.
   *
   * @return array
   *   The next page's worth of items.
   * @throws EndOfResultsException
   *   When there is no next page to retrieve.
   */
  public function next() {
    try {
      return $this->gotoPage($this->page() + 1);
    }
    catch (NoSuchPageException $e) {
      throw new EndOfResultsException();
    }
  }
}
