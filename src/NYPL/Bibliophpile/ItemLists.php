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
}