<?php
/**
 * @file
 * Tests for Location class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class LocationTest extends PHPUnit_Framework_TestCase {

  protected $location;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_locations_response;

    $this->location = new NYPL\BiblioCommons\Api\Location(
      json_decode($_locations_response)->locations[0]);
  }

  /**
   * Make sure we can we build a location from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Location', $this->location);
  }

  /**
   * Every Location has a name.
   */
  public function testHasName() {
    $this->assertEquals('115th Street', $this->location->name());
  }

  /**
   * Every Location has an id.
   */
  public function testHasId() {
    $this->assertEquals('52-HU', $this->location->id());
  }
}
