<?php
/**
 * @file
 * Tests for User class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class ListTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $list;
  protected $shortList;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_list_response;
    global $_list_short_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->list = new NYPL\Bibliophpile\ItemList(
      json_decode($_list_response)->list,
      $this->client);
    $this->shortList = new NYPL\Bibliophpile\ItemList(
      json_decode($_list_short_response)->list,
      $this->client);
  }

  /**
   * Make sure we can we build a user from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemList', $this->list);
  }

  /**
   * Every List has a name.
   */
  public function testHasName() {
    $this->assertEquals('Recommended by our librarians 4', $this->list->name());
  }

  /**
   * Every List has an id.
   */
  public function testHasId() {
    $this->assertEquals('170265611', $this->list->id());
  }

  /**
   * Every List has a link to its details.
   */
  public function testHasDetailsUrl() {
    $this->assertEquals(
      'http://any.bibliocommons.com/list/show/169884281/170265611',
      $this->list->details()
    );
  }

  /**
   * Every List has a count of the items it contains.
   */
  public function testHasItemCount() {
    $this->assertEquals(5, $this->list->itemCount());
    $this->assertInternalType('int', $this->list->itemCount());
  }

  /**
   * Every List has a creation date.
   */
  public function testHasDateCreated() {
    $this->assertInstanceOf('DateTime', $this->list->created());
    $this->assertEquals('2013-05-04', $this->list->created()->format('Y-m-d'));
  }

  /**
   * Every List has an updated date.
   */
  public function testHasDateUpdated() {
    $this->assertInstanceOf('DateTime', $this->list->updated());
    $this->assertEquals('2013-05-05', $this->list->updated()->format('Y-m-d'));
  }

  /**
   * Every List has a user date.
   */
  public function testHasUser() {
    $this->assertInstanceOf('\NYPL\Bibliophpile\User', $this->list->user());
    $this->assertEquals('BCD2013', $this->list->user()->name());
  }

  /**
   * A List can have a list type...
   */
  public function testHasListType() {
    $this->assertInstanceOf('\NYPL\Bibliophpile\ListType', $this->list->listType());
    $this->assertEquals('Other', $this->list->listType()->name());
  }

  /**
   * ...but this one doesn't.
   */
  public function testCanHaveNoListType() {
    $this->assertNull($this->shortList->listType());
  }

  /**
   * Every list has items
   */
  public function testHasItems() {
    $items = $this->list->items();

    // it should be an array.
    $this->assertInternalType('array', $items);
    // It should have the right number of items.
    $this->assertEquals(5, count($items));
    // Items should be of the right type

  }

  /**
   * Each items must be either a ListItemTitle or a ListItemUrl
   */
  public function testItemsAreTheRightType() {
    $items = $this->list->items();
    $this->assertInstanceOf('\NYPL\Bibliophpile\ListItemTitle', $items[0]);
    $this->assertInstanceOf('\NYPL\Bibliophpile\ListItemUrl', $items[4]);
  }

  public function testTitlesAreTitles() {
    $items = $this->list->items();
    $this->assertInstanceOf('\NYPL\Bibliophpile\Title', $items[0]->item());
    $this->assertEquals('On the Road to Babadag', $items[0]->item()->name());
  }

  public function testUrlsAreUrls() {
    $items = $this->list->items();
    $this->assertInstanceOf('\NYPL\Bibliophpile\ListUrl', $items[4]->item());
    $this->assertEquals(
      'http://www.online-literature.com/dickens/olivertwist/', 
      $items[4]->item()->url());
  }

  public function testListIsFullyInitialized() {
    $this->assertTrue($this->list->isComplete());
  }
}
