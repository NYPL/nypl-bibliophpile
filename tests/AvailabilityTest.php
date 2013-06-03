<?php
/**
 * @file
 * Tests for Location class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class AvailabilityTest extends PHPUnit_Framework_TestCase {

  protected $availability;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_title_short_response;

    $this->availability = new NYPL\BiblioCommons\Api\Location(
      json_decode($_title_short_response)->availability);
  }

  /**
   * Make sure we can we build a location from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Location', $this->availability);
  }

  /**
   * Every Location has a name.
   */
  public function testHasName() {
    $this->assertEquals('Available to borrow', $this->availability->name());
  }

  /**
   * Every Location has an id.
   */
  public function testHasId() {
    $this->assertEquals('AVAILABLE', $this->availability->id());
  }
}
