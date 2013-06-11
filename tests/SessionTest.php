<?php
/**
 * @file
 * Tests for Session class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class SessionTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $session;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_session_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->session = new NYPL\Bibliophpile\Session(
      json_decode($_session_response)->session,
      $this->client);
  }

  /**
   * Make sure we can we build a session from JSON.
   */
  public function testConstructorWorks() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Session', $this->session);
  }

  /**
   * Every Session has a username.
   */
  public function testHasName() {
    $this->assertEquals('exampleuser', $this->session->name());
  }

  /**
   * Every Session has an id.
   */
  public function testHasId() {
    $this->assertEquals('2412321', $this->session->id());
  }

  /**
   * Every Session has a borrower id.
   */
  public function testHasBorrowerId() {
    $this->assertEquals('123456', $this->session->borrowerId());
  }
}
