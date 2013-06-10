<?php

/**
 * @file
 * List class 
 */

namespace NYPL\Bibliophpile;

class ItemList extends ClientResource {

  protected $items;
  protected $fullyInitialized;

  /**
   * List object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {
    parent::__construct($data, $client);

    $this->initialize($client);
  }

  /**
   * Initialize object data.
   */
  protected function initialize($client) {
    $this->data->created
      = new \DateTime($this->data->created, new \DateTimeZone('utc'));
    $this->data->updated
      = new \DateTime($this->data->updated, new \DateTimeZone('utc'));

    $this->initOptionalProperties($client);

    if ($this->data->list_type !== NULL) {
      $this->data->list_type = new ListType($this->data->list_type);
    }

    $this->initItems($client);

  }

  /**
   * Initialize optional properties.
   */
  protected function initOptionalProperties($client) {
    $this->initOptionalProperty('list_type', 'object');
    $this->initOptionalProperty('user', 'object');
    $this->initOptionalProperty('list_items', 'array', array());

    if ($this->data->user !== NULL) {
      $this->data->user = new User($this->data->user, $client);
    }

    if (count($this->data->list_items) === 0) {
      $this->fullyInitialized = FALSE;
    }
    else {
      $this->fullyInitialized = TRUE;
    }
  }

  /**
   * Initialize the list of items.
   */
  protected function initItems($client) {
    $this->items = array();
    foreach ($this->data->list_items as $item) {
      if ($item->list_item_type === 'title') {
        $this->items[] = new ListItemTitle($item, $client);
      }
      else {
        $this->items[] = new ListItemUrl($item, $client);
      }
    }
  }

  /**
   * Returns the list's name.
   *
   * @return string
   *   The name
   */
  public function name() {
    return $this->data->name;
  }

  /**
   * Returns the list's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Returns the count of items in the list.
   *
   * @return int
   *   The item count
   */
  public function itemCount() {
    return $this->data->item_count;
  }

  /**
   * Returns the date the list was created.
   *
   * @return DateTime
   *   The date
   */
  public function created() {
    return $this->data->created;
  }

  /**
   * Returns the date the list was last updated.
   *
   * @return DateTime
   *   The date
   */
  public function updated() {
    return $this->data->updated;
  }

  /**
   * Returns the list type.
   *
   * @return \NYPL\Bibliophpile\ListType
   *   The list type
   */
  public function listType() {
    return $this->data->list_type;
  }

  /**
   * Returns the user who created this list.
   *
   * @return \NYPL\Bibliophpile\User
   *   The user
   */
  public function user() {
    return $this->data->user;
  }

  /**
   * Returns the URL for the list on BiblioCommons.
   *
   * @return string
   *   The URL
   */
  public function details() {
    return $this->data->details_url;
  }

  /**
   * Returns the items in the list.
   *
   * @return array
   *   An Array of ListItemTitle and ListItemUrl objects
   */
  public function items() {
    return $this->items;
  }

  /**
   * Indicates whether the item list has been fully initialized.
   *
   * When returned as items in lists of lists, the lists themselves are partial
   * (they don't have any items, for instance)
   *
   * @return bool
   *   True if the object has been fully initialized
   */
  public function isComplete() {
    return $this->fullyInitialized;
  }

  /**
   * Retrieve the full version of the ItemList.
   *
   * When returned as items in lists of lists, the lists themselves are partial
   * (they don't have any items, for instance). This method return the full
   * ItemList as a separate object.
   *
   * @return ItemList
   *   True fully initialized ItemList
   */
  public function getFullList() {
    if ($this->isComplete()) {
      return $this;
    }

    return $this->client->list($this->id());
  }
}
