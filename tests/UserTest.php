<?php
/**
 * @file
 * Tests for User class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class UserTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $user;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_users_by_id_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->user = new NYPL\Bibliophpile\User(
      json_decode($_users_by_id_response)->user,
      $this->client);
  }

  /**
   * Make sure we can we build a user from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $this->user);
  }

  /**
   * Every User has a name.
   */
  public function testHasName() {
    $this->assertEquals('fakeuser', $this->user->name());
  }

  /**
   * Every User has an id.
   */
  public function testHasId() {
    $this->assertEquals('123456789', $this->user->id());
  }

  /**
   * Every User has a link to his or her profile.
   */
  public function testHasProfileUrl() {
    $this->assertEquals(
      'http://any.bibliocommons.com/collection/show/123456789',
      $this->user->profile()
    );
  }
}
