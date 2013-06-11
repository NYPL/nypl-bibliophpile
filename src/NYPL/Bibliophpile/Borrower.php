<?php

/**
 * @file
 * Borrower class 
 */

namespace NYPL\Bibliophpile;

class Borrower extends ClientResource {

  /**
   * Borrower object constructor.
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
    $this->data->expiry_date
      = new \DateTime($this->data->expiry_date, new \DateTimeZone('utc'));
    $this->data->birth_date
      = new \DateTime($this->data->birth_date, new \DateTimeZone('utc'));
    $this->data->location = new Location($this->data->location);
    $this->data->user = new User($this->data->user, $client);

    $this->initOptionalProperties($client);
  }

  /**
   * Initialize optional properties.
   */
  protected function initOptionalProperties($client) {
    $this->initOptionalProperty('interest_groups', 'array', array());

    if (count($this->data->interest_groups) > 0) {
      $interest_groups = array();
      foreach ($this->data->interest_groups as $group) {
        $interest_groups[] = new interestGroup($group);
      }
      $this->data->interest_groups = $interest_groups;
    }
  }

  /**
   * Returns the borrower's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Returns the borrower's barcode.
   *
   * @return string
   *   The barcode
   */
  public function barcode() {
    return $this->data->barcode;
  }

  /**
   * Returns the borrower's type.
   *
   * @return string
   *   The type
   */
  public function borrowerType() {
    return $this->data->library_borrower_type;
  }

  /**
   * Returns the borrower's email.
   *
   * @return string
   *   The email
   */
  public function email() {
    return $this->data->email;
  }

  /**
   * Returns the borrower's first name.
   *
   * @return string
   *   The first name
   */
  public function firstName() {
    return $this->data->first_name;
  }

  /**
   * Returns the borrower's last name.
   *
   * @return string
   *   The last name
   */
  public function lastName() {
    return $this->data->last_name;
  }

  /**
   * Returns the borrower's expiry date.
   *
   * @return DateTime
   *   The expiry date
   */
  public function expires() {
    return $this->data->expiry_date;
  }

  /**
   * Returns the borrower's birth date.
   *
   * @return DateTime
   *   The birth date
   */
  public function birthDate() {
    return $this->data->birth_date;
  }

  /**
   * Returns the borrower's preferred location.
   *
   * @return Location
   *   The location
   */
  public function location() {
    return $this->data->location;
  }

  /**
   * Returns the user attached to the borrower.
   *
   * @return User
   *   The user
   */
  public function user() {
    return $this->data->user;
  }

  /**
   * Returns the borrower's interest groups.
   *
   * @return array
   *   The interest groups
   */
  public function interestGroups() {
    return $this->data->interest_groups;
  }
}
