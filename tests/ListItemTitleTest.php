<?php
/**
 * @file
 * Tests for User class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class ListItemTitleTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $item;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_list_item_title_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->item = new NYPL\Bibliophpile\ListItemTitle(
      json_decode($_list_item_title_response),
      $this->client);
  }

  /**
   * Make sure we can we build an item from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\ListItemTitle', $this->item);
  }

  /**
   * Every ListItemUrl has an item that is a Title.
   */
  public function testHasItemThatIsUrl() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $this->item->item());
    $this->assertEquals('Alice in Wonderland', $this->item->item()->name());
  }

  /**
   * A ListItemUrl can have an annotation, but this one doesn't
   */
  public function testCanHaveNoAnnotation() {
    $this->assertNull($this->item->annotation());
  }
}
