<?php
/**
 * @file
 * Tests for Library class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class LibraryTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $client;
  protected $library;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_library_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\BiblioCommons\Api\Client('abcdef', $this->connStub);
    $this->library = new NYPL\BiblioCommons\Api\Library(
      json_decode($_library_response)->library,
      $this->client);
  }

  /**
   * Make sure we can we build a library from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Library', $this->library);
  }

  /**
   * Every Library has a name.
   */
  public function testHasName() {
    $this->assertEquals('New York Public Library', $this->library->name());
  }

  /**
   * Every Library has an id.
   */
  public function testHasId() {
    $this->assertEquals('nypl', $this->library->id());
  }

  /**
   * Every Library has a link to its catalog.
   */
  public function testCatalogUrl() {
    $this->assertEquals(
      'http://nypl.bibliocommons.com',
      $this->library->catalog()
    );
  }
}
