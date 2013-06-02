<?php
/**
 * @file
 * Tests for Format class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class FormatTest extends PHPUnit_Framework_TestCase {

  protected $format;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_title_response;

    $this->format = new NYPL\BiblioCommons\Api\Format(
      json_decode($_title_response)->title->format);
  }

  /**
   * Make sure we can we build a location from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Format', $this->format);
  }

  /**
   * Every Location has a name.
   */
  public function testHasName() {
    $this->assertEquals('Paperback', $this->format->name());
  }

  /**
   * Every Location has an id.
   */
  public function testHasId() {
    $this->assertEquals('PAPERBACK', $this->format->id());
  }
}
