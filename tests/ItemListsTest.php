<?php
/**
 * @file
 * Tests for ItemLists class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class ItemListsTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $urlStub;
  protected $responseStub;
  protected $client;
  protected $lists;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_lists_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->responseStub = $this->getMockBuilder('HTTP_Request2_Response')
      ->disableOriginalConstructor()
      ->getMock();
    $this->urlStub = $this->getMockBuilder('Net_URL2')
      ->disableOriginalConstructor()
      ->getMock();

    $this->connStub->expects($this->any())
      ->method('send')
      ->will($this->returnValue($this->responseStub));
    $this->connStub->expects($this->any())
      ->method('getUrl')
      ->will($this->returnValue($this->urlStub));


    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->lists = new NYPL\Bibliophpile\ItemLists(
      json_decode($_lists_response),
      $this->client,
      '123456789');
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
    $this->assertEquals(13, $this->lists->count());
  }

  /**
   * Every List of lists has a limit.
   */
  public function testHasLimit() {
    $this->assertEquals(2, $this->lists->limit());
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
    $this->assertEquals(7, $this->lists->pages());
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

  /**
   * ItemLists are paginated, so there should be a next page of lists
   */
  public function testCanGetNextPage() {
    global $_lists_response_p2;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/users/123456789/lists'));
    $this->urlStub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->logicalAnd(
        $this->arrayHasKey('api_key'),
        $this->arrayHasKey('page'),
        $this->arrayHasKey('limit'))
      );
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_lists_response_p2));

    $next = $this->lists->next();

    $this->assertInternalType('array', $next);
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemList', $next[0]);
    $this->assertEquals(2, $this->lists->page());

  }

  public function testCanGetSpecificPage() {
    global $_lists_response_p7;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/users/123456789/lists'));
    $this->urlStub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->logicalAnd(
        $this->arrayHasKey('api_key'),
        $this->arrayHasKey('page'),
        $this->arrayHasKey('limit'))
      );
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_lists_response_p7));

    $page = $this->lists->gotoPage(7);

    $this->assertInternalType('array', $page);
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemList', $page[0]);
    $this->assertEquals(7, $this->lists->page());
  }
}
