<?php

require 'vendor/autoload.php';



class ClientTest extends PHPUnit_Framework_TestCase
{
  const NYPL_RESP = '
  {
      "library": {
          "catalog_url": "http://nypl.bibliocommons.com",
          "id": "nypl",
          "name": "New York Public Library"
      }
  }';


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
    $conn_stub = $this->getMock('HTTP_Request2');
    $response_stub = $this->getMockBuilder('HTTP_Request2_Response')
      ->disableOriginalConstructor()
      ->getMock();
    $url_stub = $this->getMockBuilder('Net_URL2')
      ->disableOriginalConstructor()
      ->getMock();


    $conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/libraries/nypl'));
    $conn_stub->expects($this->any())
      ->method('send')
      ->will($this->returnValue($response_stub));
    $conn_stub->expects($this->any())
      ->method('getUrl')
      ->will($this->returnValue($url_stub));
    $url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue(self::NYPL_RESP));

    $client = new NYPL\BiblioCommons\Api\Client('abcdef', $conn_stub);

    $this->assertEquals(
      'New York Public Library', 
      $client->getEndpoint('libraries/nypl')->library->name);
  }
}

