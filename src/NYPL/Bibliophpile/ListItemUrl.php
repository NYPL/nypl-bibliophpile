<?php

/**
 * @file
 * ListItemUrl class 
 */

namespace NYPL\Bibliophpile;

class ListItemUrl extends ListItem {

  /**
   * Initialize the ListUrl object this ListItemUrl contains.
   */
  protected function initItem($client) {
    $this->item = new ListUrl($this->data->url);
  }
}
