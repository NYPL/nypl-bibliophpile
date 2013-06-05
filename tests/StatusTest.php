<?php
/**
 * @file
 * Tests for Status class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class StatusTest extends PHPUnit_Framework_TestCase {

  protected $status;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_status_response;

    $this->status = new NYPL\Bibliophpile\Status(
      json_decode($_status_response));
  }

  /**
   * Make sure we can we build a location from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Status', $this->status);
  }

  /**
   * Every Status has a name.
   */
  public function testHasName() {
    $this->assertEquals('Available', $this->status->name());
  }

  /**
   * Every Status has an id.
   */
  public function testHasId() {
    $this->assertEquals('AVAILABLE', $this->status->id());
  }
}
