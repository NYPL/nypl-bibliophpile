<?php
/**
 * @file
 * Tests for Titles class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class TitlesTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $urlStub;
  protected $client;
  protected $titles;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_titles_search_response;

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
    $this->titles = new NYPL\Bibliophpile\Titles(
      json_decode($_titles_search_response),
      $this->client,
      'query',
      'library',
      'search_type');
  }

  /**
   * Make sure we can we build from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Titles', $this->titles);
  }

  /**
   * Every List of titles has a count.
   */
  public function testHasCount() {
    $this->assertEquals(412, $this->titles->count());
  }

  /**
   * Every List of titles has a limit.
   */
  public function testHasLimit() {
    $this->assertEquals(2, $this->titles->limit());
  }

  /**
   * Every List of titles has a current page.
   */
  public function testHasPage() {
    $this->assertEquals(1, $this->titles->page());
  }

  /**
   * Every List of titles has a page count.
   */
  public function testHasPages() {
    $this->assertEquals(206, $this->titles->pages());
  }

  /**
   * Every List of titles has a list of titles.
   */
  public function testHasUsers() {
    $this->assertInternalType('array', $this->titles->titles());
  }

  /**
   * Every List of titles has a list of titles that is an array of Title objects.
   */
  public function testUsersAreUsers() {
    $titles = $this->titles->titles();
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $titles[0]);
  }

  /**
   * Titles are paginated, so there should be a next page of lists
   */
  public function testCanGetNextPage() {
    global $_titles_search_response_p2;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/titles'));
    $this->urlStub->expects($this->any())
      ->method('setQueryVariables');
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_titles_search_response_p2));

    $next = $this->titles->next();

    $this->assertInternalType('array', $next);
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $next[0]);
    $this->assertEquals(2, $this->titles->page());

  }

  public function testCanGetSpecificPage() {
    global $_titles_search_response_p206;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/titles'));
    $this->urlStub->expects($this->any())
      ->method('setQueryVariables');
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_titles_search_response_p206));

    $page = $this->titles->gotoPage(206);

    $this->assertInternalType('array', $page);
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $page[0]);
    $this->assertEquals(206, $this->titles->page());
  }

  /**
   * @expectedException \NYPL\Bibliophpile\NoSuchPageException
   */
  public function testRaisesExceptionForPageTooHigh() {
    $this->titles->gotoPage(999);
  }

  /**
   * @expectedException \NYPL\Bibliophpile\NoSuchPageException
   */
  public function testRaisesExceptionForPageTooLow() {
    $this->titles->gotoPage(0);
  }

  /**
   * @expectedException \NYPL\Bibliophpile\EndofResultsException
   */
  public function testWillNotGoPastLastPage() {
    global $_titles_search_response_p206;
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_titles_search_response_p206));

    $page = $this->titles->gotoPage(206);
    $this->titles->next();
  }
}
