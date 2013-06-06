<?php
/**
 * @file
 * Tests for User class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class ListItemUrlTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $item;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_list_item_url_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->item = new NYPL\Bibliophpile\ListItemUrl(
      json_decode($_list_item_url_response),
      $this->client);
  }

  /**
   * Make sure we can we build an item from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\ListItemUrl', $this->item);
  }

  /**
   * Every ListItemUrl has an item that is a Url.
   */
  public function testHasItemThatIsUrl() {
    $this->assertInstanceOf('NYPL\Bibliophpile\ListUrl', $this->item->item());
    $this->assertEquals(
      'http://www.online-literature.com/dickens/olivertwist/', 
      $this->item->item()->url());
  }

  /**
   * A ListItemUrl can have an annotation.
   */
  public function testHasAnnotation() {
    $this->assertEquals(
      'Check out this cool online version of Oliver Twist.', 
      $this->item->annotation());
  }
}
