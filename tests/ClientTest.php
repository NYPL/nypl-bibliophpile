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
    $client = new NYPL\Bibliophpile\Client('abcdef');

    # It saved the key we passed
    $this->assertEquals('abcdef', $client->apikey());

    # created it own HTTP client
    $this->assertInstanceOf('HTTP_Request2', $client->conn());
  }

  public function testOptionalConstructorWorks() {
    $conn = new \HTTP_Request2();

    $client = new NYPL\Bibliophpile\Client('abcdef', $conn);

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

    $client = new NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);

    $this->assertEquals(
      'New York Public Library', 
      $client->getEndpoint('test/url')->library->name);
  }

  /**
   * @expectedException \NYPL\Bibliophpile\JsonException
   */
  public function testRaisesExceptionForBadJson() {
    // $conn_stub = $this->getMock('HTTP_Request2');
    global $_bad_json;
    $this->conn_stub->expects($this->any())
      ->method('setUrl');
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_bad_json));
    $client = new NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
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

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $library = $client->library('nypl');

    # It should be a Library
    $this->assertInstanceOf('NYPL\Bibliophpile\Library', $library);

    # It should have the right name
    $this->assertEquals('New York Public Library', $library->name());
  }

  public function testRetrievesLibraryLocations() {
    global $_locations_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/libraries/nypl/locations'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_locations_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $locations = $client->locations('nypl');

    // It should return an array
    $this->assertInternalType('array', $locations);

    // It should be an array of Location objects
    $this->assertInstanceOf('NYPL\Bibliophpile\Location', $locations[0]);

    // It should be an array of the right Location objects
    $this->assertEquals('115th Street', $locations[0]->name());
  }

  public function testRetrievesListById() {

    global $_list_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/lists/170265611'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_list_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $list = $client->itemList('170265611');

    # It should be an ItemList
    $this->assertInstanceOf('NYPL\Bibliophpile\ItemList', $list);

    # It should have the right name
    $this->assertEquals('Recommended by our librarians 4', $list->name());
  }

  public function testRetrievesTitleById() {

    global $_title_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/titles/18708779052907'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_title_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $title = $client->title('18708779052907');

    # It should be a Library
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $title);

    # It should have the right name
    $this->assertEquals('Moby-Dick', $title->name());
  }

  public function testRetrievesCopies() {

    global $_title_copies_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/titles/18708779052907/copies'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_title_copies_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $copies = $client->copies('18708779052907');

    # It should return an array
    $this->assertInternalType('array', $copies);

    // It should be an array of Copy objects
    $this->assertInstanceOf('NYPL\Bibliophpile\Copy', $copies[0]);

    // It should be an array of the right Copy objects
    $this->assertEquals('Fort Washington Fiction', $copies[0]->collection());
  }

  public function testRetrievesUserById() {

    global $_users_by_id_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/users/123456789'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->arrayHasKey('api_key'));
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_users_by_id_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $user = $client->user('123456789');

    # It should be a Library
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $user);

    # It should have the right name
    $this->assertEquals('fakeuser', $user->name());
  }

  public function testSearchesUsersByUsername() {

    global $_users_response;
    $this->conn_stub->expects($this->any())
      ->method('setUrl')
      ->with($this->equalTo('https://api.bibliocommons.com/v1/users'));
    $this->url_stub->expects($this->any())
      ->method('setQueryVariables')
      ->with($this->logicalAnd(
        $this->arrayHasKey('api_key'),
        $this->arrayHasKey('q'))
      );
    $this->response_stub->expects($this->any())
      ->method('getBody')
      ->will($this->returnValue($_users_response));

    $client = new \NYPL\Bibliophpile\Client('abcdef', $this->conn_stub);
    $users = $client->users('123456789');

    # It should be a list of users
    $this->assertInstanceOf('NYPL\Bibliophpile\Users', $users);
    $userlist = $users->users();
    $this->assertInstanceOf('NYPL\Bibliophpile\User', $userlist[0]);
  }
}

