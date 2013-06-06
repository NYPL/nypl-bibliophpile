<?php

/**
 * @file
 * ListITem class 
 */

namespace NYPL\Bibliophpile;

/**
 * Base class for items that can be in user lists and can have annotations.
 */
abstract class ListItem extends DataResource {

  protected $item;

  /**
   * ListItem object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {

    parent::__construct($data);
    $this->initOptionalProperties();
    $this->initItem($client);
  }

  /**
   * Initialize optional properties.
   */
  protected function initOptionalProperties() {
    $this->initOptionalProperty('annotation', 'string');
  }

  /**
   * Initialize the object this ListItem contains.
   */
  abstract protected function initItem($client);

  /**
   * Returns the annotation of the item.
   *
   * @return string
   *   The annotation
   */
  public function annotation() {
    return $this->data->annotation;
  }
  /**
   * Returns the item contained in the list item contents.
   *
   * @return mixed
   *   The item
   */
  public function item() {
    return $this->item;
  }
}
