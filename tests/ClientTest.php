<?php

require 'vendor/autoload.php';
include_once('response_helpers.inc');


class ClientTest extends PHPUnit_Framework_TestCase
{
  protected $conn_stub;
  protected $response_stub;
  protected $url_stub;

  protected function setUp() {
    $this->conn_stub = $this->getMock('HTTP_Request2');
    $this->response_stub = $this->getMockBuilder('HTTP_Request2_Response')
      ->disableOriginalConstructor()
      ->getMock();
    $this->url_stub = $this->getMockBuilder('Net_URL2')
      ->disableOriginalConstructor()
      ->getMock();

    $this->conn_stub->expects($this->any())
      ->method('send')
      ->will($this->returnValue($this->response_stub));
    $this->conn_stub->expects($this->any())
      ->method('getUrl')
      ->will($this->returnValue($this->url_stub));
  }

  public function testMinimalConstructorWorks() {
    $client = new NYPL\BiblioCommons\Api\Client('abcdef');

    # It saved the key we passed
    $this->assertEquals('abcdef', $client->apikey());

    # created it own HTTP client
    $this->assertInstanceOf('HTTP_Request2', $client->conn());
  }

  public function testOptionalConstructorWorks() {
    $conn = new \HTTP_Request2();

    $client = new NYPL\BiblioCommons\Api\Client('abcdef', $conn);

    # It saved the key we passed
    $this->assertEquals('abcdef', $client->apikey());

    # It saved the HTTP client we passed
    $this->assertSame($conn, $client->conn());
  }

  public function testClientRetrievesAnEndpoint() {
    global $_library_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/test/url'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_library_response));

    $client = new NYPL\BiblioCommons\Api\Client('abcdef', $this->conn_stub);

    $this->assertEquals(
      'New York Public Library', 
      $client->getEndpoint('test/url')->library->name);
  }

  /**
   * @expectedException JsonException
   */
  public function testRaisesExceptionForBadJson() {
    $conn_stub = $this->getMock('HTTP_Request2');
    $client = new NYPL\BiblioCommons\Api\Client('abcdef', $this->conn_stub);
    $client->getEndpoint('libraries/nypl');
  }

  public function testRetrievesLibraryById() {
    // $conn_stub = $this->getMock('HTTP_Request2');

    global $_library_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/libraries/nypl'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_library_response));

    $client = new \NYPL\BiblioCommons\Api\Client('abcdef', $this->conn_stub);
    $library = $client->library('nypl');

    # It should be a Library
    $this->assertInstanceOf('NYPL\BiblioCommons\Api\Library', $library);

    # It should have the right name
    $this->assertEquals('New York Public Library', $library->name());
  }
}

