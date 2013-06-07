<?php
/**
 * @file
 * Tests for ItemLists class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class ItemListsTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $lists;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_lists_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->lists = new NYPL\Bibliophpile\ItemLists(
      json_decode($_lists_response),
      $this->client);
  }

  /**
   * Make sure we can we build an ItemLIsts from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemLists', $this->lists);
  }

  /**
   * Every List of lists has a count.
   */
  public function testHasCount() {
    $this->assertEquals(2, $this->lists->count());
  }

  /**
   * Every List of lists has a limit.
   */
  public function testHasLimit() {
    $this->assertEquals(10, $this->lists->limit());
  }

  /**
   * Every List of lists has a current page.
   */
  public function testHasPage() {
    $this->assertEquals(1, $this->lists->page());
  }

  /**
   * Every List of lists has a page count.
   */
  public function testHasPages() {
    $this->assertEquals(1, $this->lists->pages());
  }

  /**
   * Every List of lists has a list of ItemList.
   */
  public function testHasLists() {
    $this->assertInternalType('array', $this->lists->lists());
  }

  /**
   * Every List of lists has a list of lists that is an array of ItemList objects.
   */
  public function testListsAreItemLists() {
    $lists = $this->lists->lists();
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemList', $lists[0]);
  }

  /**
   * Lists that are items in lists of lists are only partial.
   */
  public function testListsArePartial() {
    $lists = $this->lists->lists();
    $this->assertFalse($lists[0]->isComplete());
  }
}
