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

  /**
   * authors() should return a list
   */
  public function testAuthorsReturnsArray() {
    $this->assertInternalType('array', $this->title->authors());
  }

  /**
   * additional_contributors() should return a list
   */
  public function testAdditionalContributorsReturnsArray() {
    $this->assertInternalType('array', $this->title->additionalContributors());
  }

  /**
   * publishers() should return a list
   */
  public function testPublishersReturnsArray() {
    $this->assertInternalType('array', $this->title->publishers());
  }

  /**
   * languages() should return a list
   */
  public function testLanguagesReturnsArray() {
    $this->assertInternalType('array', $this->title->languages());
  }

  /**
   * performers() should return a list
   */
  public function testPerformersReturnsArray() {
    $this->assertInternalType('array', $this->title->performers());
  }

  /**
   * suitabilities() should return a list
   */
  public function testSuitabilitiesReturnsArray() {
    $this->assertInternalType('array', $this->title->suitabilities());
  }

  /**
   * Lists of "single-property" objects should be flattened into lists of the
   * values of the single properties.
   */
  public function testListOfAuthorsIsFlattened() {
    $list = $this->title->authors();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * additional_contributors() should return a flattened list
   */
  public function testListOfAdditionalContributorsIsFlattened() {
    $list = $this->title->additionalContributors();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * publishers() should return a flattened list
   */
  public function testListOfPublishersIsFlattened() {
    $list = $this->title->publishers();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * languages() should return a flattened list
   */
  public function testListOfLanguagesIsFlattened() {
    $list = $this->title->languages();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * performers() should return a flattened list
   */
  public function testListOfPerformersIsFlattened() {
    $list = $this->title->performers();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * suitabilities() should return a flattened list
   */
  public function testListOfSuitabilitiesIsFlattened() {
    $list = $this->title->suitabilities();
    $this->assertInternalType('string', $list[0]);
  }
}
