<?php

/**
 * @file
 * Copy class 
 */

namespace NYPL\Bibliophpile;

class Copy extends DataResource {

  /**
   * Title object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   */
  public function __construct($data) {
    parent::__construct($data);
    $data->location = new Location($data->location);
    $data->status = new Status($data->status);
  }


  /**
   * Returns the collection the copy belongs to.
   *
   * @return string
   *   The collection
   */
  public function collection() {
    return $this->data->collection;
  }

  /**
   * Returns the copy's call number.
   *
   * @return string
   *   The call number
   */
  public function callNumber() {
    return $this->data->call_number;
  }

  /**
   * Returns the copy's library status.
   *
   * @return string
   *   The library status
   */
  public function libraryStatus() {
    return $this->data->library_status;
  }

  /**
   * Returns the copy's location.
   *
   * @return \NYPL\Bibliophpile\Location
   *   The status
   */
  public function location() {
    return $this->data->location;
  }

  /**
   * Returns the copy's status.
   *
   * @return \NYPL\Bibliophpile\Status
   *   The status
   */
  public function status() {
    return $this->data->status;
  }
}
