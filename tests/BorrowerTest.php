<?php
/**
 * @file
 * Tests for Borrower class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class BorrowerTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $borrower;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_borrower_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->borrower = new NYPL\Bibliophpile\Borrower(
      json_decode($_borrower_response)->borrower,
      $this->client);
  }

  /**
   * Make sure we can we build a Borrower from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Borrower', $this->borrower);
  }

  /**
   * Every Borrower has an id.
   */
  public function testHasId() {
    $this->assertEquals('654321', $this->borrower->id());
  }

  /**
   * Every Borrower has a barcode.
   */
  public function testHasBarcode() {
    $this->assertEquals('123456789012', $this->borrower->barcode());
  }

  /**
   * Every Borrower has a type.
   */
  public function testHasBorrowerType() {
    $this->assertEquals('p', $this->borrower->borrowerType());
  }

  /**
   * Every Borrower has an email.
   */
  public function testHasEmail() {
    $this->assertEquals('example@example.com', $this->borrower->email());
  }

  /**
   * Every Borrower has a first name.
   */
  public function testHasFirstName() {
    $this->assertEquals('Example', $this->borrower->firstName());
  }

  /**
   * Every Borrower has a last name.
   */
  public function testHasLastName() {
    $this->assertEquals('User', $this->borrower->lastName());
  }

  /**
   * Every Borrower has an expiry date.
   */
  public function testHasExpiryDate() {
    $this->assertInstanceOf('DateTime', $this->borrower->expires());
    $this->assertEquals('2013-01-31', $this->borrower->expires()->format('Y-m-d'));
  }

  /**
   * Every Borrower has an birth date.
   */
  public function testHasBirthDate() {
    $this->assertInstanceOf('DateTime', $this->borrower->birthDate());
    $this->assertEquals('1973-01-01', $this->borrower->birthDate()->format('Y-m-d'));
  }

  /**
   * Every Borrower has a location.
   */
  public function testHasLocation() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Location', $this->borrower->location());
    $this->assertEquals('Anytown Library', $this->borrower->location()->name());
  }

  /**
   * Every Borrower has a user.
   */
  public function testHasUser() {
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $this->borrower->user());
    $this->assertEquals('exampleuser', $this->borrower->user()->name());
  }

  /**
   * Every Borrower has interest groups.
   */
  public function testHasInterestGroups() {
    $groups = $this->borrower->interestGroups();
    $this->assertInternalType('array', $groups);
    $this->assertInstanceOf('NYPL\Bibliophpile\InterestGroup', $groups[0]);
    $this->assertEquals('Teacher - High School', $groups[0]->name());
  }
}
