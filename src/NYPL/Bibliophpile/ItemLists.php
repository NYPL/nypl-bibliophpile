<?php

/**
 * @file
 * ItemLists class 
 */

namespace NYPL\Bibliophpile;

/**
 * ItemLists represents a list of user lists.
 */
class ItemLists extends PaginatedResource {

  /**
   * The ID of the user whose lists are contained in this resource.
   */
  protected $userid;

  /**
   * ItemLists object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   * @param string $userid
   *   The ID of the user whose lists are contained in this resource. Required
   *   for subsequent requests for more pages.
   */
  public function __construct($data, $client, $userid) {
    parent::__construct($data, $client);
    $this->userid = $userid;
  }

  /**
   * Initialize the lists in this ItemsLists object.
   */
  protected function initItems() {
    $lists = array();
    foreach ($this->data->lists as $list) {
      $lists[] = new ItemList($list, $this->client);
    }
    $this->data->lists = $lists;
  }

  /**
   * Returns the lists contained in this resource.
   *
   * @return array
   *   The lists
   */
  public function lists() {
    return $this->data->lists;
  }

  /**
   * Retrieve a specific page of results.
   *
   * @return array
   *   The lists
   * @throws NoSuchPageException
   *   If an attempt is made to retrieve a page less the 1 or greater than the
   *   number of pages in the set.
   */
  public function gotoPage($page) {
    if ($page > $this->pages() || $page < 1) {
      throw new NoSuchPageException();
    }

    $data = $this->client()->userLists($this->userid, $page, $this->limit(), FALSE);

    $this->data = $data;
    $this->initItems();
    return $this->lists();
  }
}
