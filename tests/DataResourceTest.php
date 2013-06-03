<?php
/**
 * @file
 * Tests for DataResource class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class DataResourceTest extends PHPUnit_Framework_TestCase {


  /**
   * Set up tests.
   */
  protected function setUp() {

    // We're going to use Series as an example DataResource.
    global $_series_response_no_number;

    $this->resource = new NYPL\Bibliophpile\Series(
      json_decode($_series_response_no_number));
  }

  /**
   * Make sure we can we build a resource from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Series', $this->resource);
  }

  /**
   * Make sure optional property is converted from empty string to null.
   */
  public function testInitializationOfEmptyOptionalProperties() {
    $this->assertNull($this->resource->number());
  }
}
