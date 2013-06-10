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

  protected $userid;

  public function __construct($data, $client, $userid) {
    parent::__construct($data, $client);
    $this->userid = $userid;
  }

  protected function initItems() {
    $lists = array();
    foreach ($this->data->lists as $list) {
        $lists[] = new ItemList($list, $this->client);
    }
    $this->data->lists = $lists;
  }

  public function lists() {
    return $this->data->lists;
  }

  public function next() {
    if ($this->page() + 1 > $this->pages()) {
      throw new EndOfResultsException();
    }

    $data = $this->client()->userLists($this->userid, $this->page() + 1, $this->limit(), FALSE);

    $this->data = $data;
    $this->initItems();
    return $this->lists();
  }

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