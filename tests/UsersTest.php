<?php
/**
 * @file
 * Tests for User class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class UsersTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $urlStub;
  protected $client;
  protected $users;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_users_response;

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
    $this->users = new NYPL\Bibliophpile\Users(
      json_decode($_users_response),
      $this->client,
      'xyz');
  }

  /**
   * Make sure we can we build a user from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Users', $this->users);
  }

  /**
   * Every List of users has a count.
   */
  public function testHasCount() {
    $this->assertEquals(1, $this->users->count());
  }

  /**
   * Every List of users has a limit.
   */
  public function testHasLimit() {
    $this->assertEquals(1, $this->users->limit());
  }

  /**
   * Every List of users has a current page.
   */
  public function testHasPage() {
    $this->assertEquals(1, $this->users->page());
  }

  /**
   * Every List of users has a page count.
   */
  public function testHasPages() {
    $this->assertEquals(1, $this->users->pages());
  }

  /**
   * Every List of users has a list of users.
   */
  public function testHasUsers() {
    $this->assertInternalType('array', $this->users->users());
  }

  /**
   * Every List of users has a list of users that is an array of User objects.
   */
  public function testUsersAreUsers() {
    $users = $this->users->users();
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $users[0]);
  }

  public function testCanGetSpecificPage() {
    global $_users_response;
    $this->connStub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/users'));
    $this->urlStub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->logicalAnd(
        $this->arrayHasKey('api_key'),
        $this->arrayHasKey('page'),
        $this->arrayHasKey('limit'))
      );
    $this->responseStub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_users_response));

    $page = $this->users->gotoPage(1);

    $this->assertInternalType('array', $page);
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $page[0]);
    $this->assertEquals(1, $this->users->page());
  }

}
