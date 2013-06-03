<?php
/**
 * @file
 * Tests for Library class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class TitleTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $title;
  protected $shortTitle;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_title_response;
    global $_title_short_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\BiblioCommons\Api\Client('abcdef', $this->connStub);
    $this->title = new NYPL\BiblioCommons\Api\Title(
      json_decode($_title_response)->title,
      $this->client);

    // When returned as part of a list of titles, many fields are left out of
    // the response.
    $this->shortTitle = new NYPL\BiblioCommons\Api\Title(
      json_decode($_title_short_response),
      $this->client);
  }

  /**
   * Make sure we can we build a title from JSON.
   */
  public function testConstructorWorksForShortObject() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Title', $this->shortTitle);
  }

  /**
   * Make sure we can we build a title from JSON.
   */
  public function testConstructorWorksForFullObject() {
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Title', $this->title);
  }

  /**
   * Every Title has a name (title).
   */
  public function testHasName() {
    $this->assertEquals('Moby-Dick', $this->title->name());
  }

  /**
   * Every Title has an id.
   */
  public function testHasId() {
    $this->assertEquals('18708779052907', $this->title->id());
  }

  /**
   * Every Title has a details link.
   */
  public function testHasDetailsUrl() {
    $this->assertEquals(
      'http://any.bibliocommons.com/item/show/18708779052907',
      $this->title->details()
    );
  }

  /**
   * Every Title has a format.
   */
  public function testHasFormat() {
    // It should be a Format object.
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Format', $this->title->format());

    // It should be the right Format.
    $this->assertEquals('Paperback', $this->title->format()->name());
    $this->assertEquals('PAPERBACK', $this->title->format()->id());
  }

  /**
   * Availability should return the right kind of object.
   */
  public function testReturnsAvailability() {
    // It should be an Availability object.
    $this->assertInstanceOf(
      'NYPL\BiblioCommons\Api\Availability',
      $this->title->availability());

    // It should be the right Availability.
    $this->assertEquals('Available', $this->title->availability()->name());
    $this->assertEquals('AVAILABLE', $this->title->availability()->id());
  }
}
