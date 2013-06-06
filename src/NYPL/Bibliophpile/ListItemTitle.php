<?php

/**
 * @file
 * ListItemTitle class 
 */

namespace NYPL\Bibliophpile;

class ListItemTitle extends ListItem {

  /**
   * Initialize the Title object this ListItemUrl contains.
   */
  protected function initItem($client) {
    $this->item = new Title($this->data->title, $client);
  }
}
