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
  protected $client;
  protected $users;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_users_response;

    $this->connStub = $this->getMock('HTTP_Request2');
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
}
