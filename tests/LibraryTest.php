<?php
/**
 * @file
 * Tests for Library class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class LibraryTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $library;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_library_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('few2vjhmdnhjhw7xnajj9wxt', $this->connStub);
    $this->library = new NYPL\Bibliophpile\Library(
      json_decode($_library_response)->library,
      $this->client);
  }

  /**
   * Make sure we can we build a library from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Library', $this->library);
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
  public function testHasCatalogUrl() {
    $this->assertEquals(
      'http://nypl.bibliocommons.com',
      $this->library->catalog()
    );
  }

  /**
   * A Library can return it's Locations.
   */
  public function testReturnsLocations() {
    global $_locations_response;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/libraries/nypl/locations'));
    $this->responseStub = $this->getMockBuilder('HTTP_Request2_Response')
      ->disableOriginalConstructor()
      ->getMock();
    $this->url_stub = $this->getMockBuilder('Net_URL2')
      ->disableOriginalConstructor()
      ->getMock();

    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_locations_response));

    $this->connStub->expects($this->any())
      ->method('send')
      ->will($this->returnValue($this->responseStub));
    $this->connStub->expects($this->any())
      ->method('getUrl')
      ->will($this->returnValue($this->url_stub));

    $locations = $this->library->locations();

    // It should return an array.
    $this->assertInternalType('array', $locations);

    // It should be an array of Location objects.
    $this->assertInstanceOf('NYPL\Bibliophpile\Location', $locations[0]);

    // It should be an array of the right Location objects.
    $this->assertEquals('115th Street', $locations[0]->name());
  }
}
