<?php
/**
 * @file
 * Tests for Library class 
 */

require 'vendor/autoload.php';
include_once 'response_helpers.inc';

class TitleTest extends PHPUnit_Framework_TestCase {

  protected $connStub;
  protected $responseStub;
  protected $client;
  protected $title;
  protected $shortTitle;

  /**
   * Set up tests.
   */
  protected function setUp() {

    global $_title_response;
    global $_title_short_response;

    $this->connStub = $this->getMock('HTTP_Request2');
    $this->client
      = new NYPL\Bibliophpile\Client('abcdef', $this->connStub);
    $this->title = new NYPL\Bibliophpile\Title(
      json_decode($_title_response)->title,
      $this->client);

    // When returned as part of a list of titles, many fields are left out of
    // the response.
    $this->shortTitle = new NYPL\Bibliophpile\Title(
      json_decode($_title_short_response),
      $this->client);
  }

  /**
   * Make sure we can we build a title from JSON.
   */
  public function testConstructorWorksForShortObject() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $this->shortTitle);
  }

  /**
   * Make sure we can we build a title from JSON.
   */
  public function testConstructorWorksForFullObject() {
    $this->assertInstanceOf('NYPL\Bibliophpile\Title', $this->title);
  }

  /**
   * Every Title has a name (title).
   */
  public function testHasName() {
    $this->assertEquals('Moby-Dick', $this->title->name());
  }

  /**
   * Every Title has an id.
   */
  public function testHasId() {
    $this->assertEquals('18708779052907', $this->title->id());
  }

  /**
   * Every Title has a details link.
   */
  public function testHasDetailsUrl() {
    $this->assertEquals(
      'http://any.bibliocommons.com/item/show/18708779052907',
      $this->title->details()
    );
  }

  /**
   * Every Title has a format.
   */
  public function testHasFormat() {
    // It should be a Format object.
    $this->assertInstanceOf('NYPL\Bibliophpile\Format', $this->title->format());

    // It should be the right Format.
    $this->assertEquals('Paperback', $this->title->format()->name());
    $this->assertEquals('PAPERBACK', $this->title->format()->id());
  }

  /**
   * Some Titles have subtitles...
   */
  public function testHasSubtitle() {
    $this->assertEquals(
      'With a subtitle',
      $this->title->subtitle()
    );
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoSubtitle() {
    $this->assertNull($this->shortTitle->subtitle());
  }

  /**
   * Availability should return the right kind of object.
   */
  public function testReturnsAvailability() {
    // It should be an Availability object.
    $this->assertInstanceOf(
      'NYPL\Bibliophpile\Availability',
      $this->title->availability());

    // It should be the right Availability.
    $this->assertEquals('Available', $this->title->availability()->name());
    $this->assertEquals('AVAILABLE', $this->title->availability()->id());
  }

  /**
   * authors() should return a list
   */
  public function testAuthorsReturnsArray() {
    $list = $this->title->authors();
    $this->assertInternalType('array', $list);
    $this->assertEquals("Melville, Herman", $list[0]);
  }

  /**
   * Some Titles have isbns...
   */
  public function testIsbnsReturnsArray() {
    $list = $this->title->isbns();
    $this->assertInternalType('array', $list);
    $this->assertEquals('0553213113', $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoIsbns() {
    $this->assertEmpty($this->shortTitle->isbns());
  }

  /**
   * Some Titles have UPCS...
   */
  public function testUpcsReturnsArray() {
    $list = $this->title->upcs();
    $this->assertInternalType('array', $list);
    $this->assertEquals('1234567890', $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoUpcs() {
    $this->assertEmpty($this->shortTitle->upcs());
  }

  /**
   * Some Titles have Call numbers...
   */
  public function testHasCallNumber() {
    $this->assertEquals('CLASSICS FIC M', $this->title->callNumber());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoCallNumber() {
    $this->assertNull($this->shortTitle->callNumber());
  }

  /**
   * Some Titles have a description...
   */
  public function testHasDescription() {
    $this->assertEquals('A description', $this->title->description());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoDescription() {
    $this->assertNull($this->shortTitle->description());
  }

  /**
   * Some Titles have a list of additional_contributors...
   */
  public function testAdditionalContributorsReturnsArray() {
    $list = $this->title->additionalContributors();
    $this->assertInternalType('array', $list);
    $this->assertEquals("Walcutt, Charles Child", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoAdditionalContributors() {
    $this->assertEmpty($this->shortTitle->additionalContributors());
  }

  /**
   * Some Titles have a list of publishers...
   */
  public function testPublishersReturnsArray() {
    $list = $this->title->publishers();
    $this->assertInternalType('array', $list);
    $this->assertEquals("Bantam Classic", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoPublishers() {
    $this->assertEmpty($this->shortTitle->publishers());
  }

  /**
   * Some Titles have a number of pages...
   */
  public function testHasPages() {
    $this->assertEquals(670, $this->title->pages());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoPages() {
    $this->assertNull($this->shortTitle->pages());
  }

  /**
   * The number of pages should be an integer
   */
  public function testPagesReturnsAnInteger() {
    $this->assertInternalType('integer', $this->title->pages());
  }

  /**
   * Some Titles have a list of series...
   */
  public function testSeriesReturnsArray() {
    $list = $this->title->series();
    $this->assertInternalType('array', $list);
    $this->assertEquals("Series Title", $list[0]->name());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoSeries() {
    $this->assertEmpty($this->shortTitle->series());
  }

  /**
   * The list of series should contain the right type of objects
   */
  public function testSeriesReturnsArrayOfSeries() {
    $list = $this->title->series();
    $this->assertInstanceOf('\NYPL\Bibliophpile\Series', $list[0]);
  }
 
  /**
   * Some Titles have an edition...
   */
  public function testHasEdition() {
    $this->assertEquals('The Edition', $this->title->edition());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoEdition() {
    $this->assertNull($this->shortTitle->edition());
  }

  /**
   * Some Titles have a primary language...
   */
  public function testHasPrimaryLanguage() {
    $this->assertEquals('English', $this->title->primaryLanguage());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoPrimaryLanguage() {
    $this->assertNull($this->shortTitle->primaryLanguage());
  }

  /**
   * Some titles have a list of languages...
   */
  public function testLanguagesReturnsArray() {
    $list = $this->title->languages();
    $this->assertInternalType('array', $list);
    $this->assertEquals("English", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoLanguages() {
    $this->assertEmpty($this->shortTitle->languages());
  }

  /**
   * Some titles have a list of contents...
   */
  public function testContentsReturnsArray() {
    $list = $this->title->contents();
    $this->assertInternalType('array', $list);
    $this->assertEquals("First contents line", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoContents() {
    $this->assertEmpty($this->shortTitle->contents());
  }

  /**
   * Some titles have a list of performers...
   */
  public function testPerformersReturnsArray() {
    $list = $this->title->performers();
    $this->assertInternalType('array', $list);
    $this->assertEquals("Performer One", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoPerformers() {
    $this->assertEmpty($this->shortTitle->performers());
  }

  /**
   * Some titles have a list of suitabilities...
   */
  public function testSuitabilitiesReturnsArray() {
    $list = $this->title->suitabilities();
    $this->assertInternalType('array', $list);
    $this->assertEquals("First Suitability", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoSuitabilities() {
    $this->assertEmpty($this->shortTitle->suitabilities());
  }

  /**
   * Some titles have a list of notes...
   */
  public function testNotesReturnsArray() {
    $list = $this->title->notes();
    $this->assertInternalType('array', $list);
    $this->assertEquals("\"First published in 1851.\"", $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoNotes() {
    $this->assertEmpty($this->shortTitle->notes());
  }

  /**
   * Some Titles have a statement of responsibility...
   */
  public function testHasStatementOfResponsibility() {
    $this->assertEquals(
      'Herman Melville ; edited and with an introduction by Charles Child Walcutt', 
      $this->title->statementOfResponsibility());
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoStatementOfResponsibility() {
    $this->assertNull($this->shortTitle->statementOfResponsibility());
  }

  /**
   * Some titles have a list of physical description...
   */
  public function testPhysicalDescriptionReturnsArray() {
    $list = $this->title->physicalDescription();
    $this->assertInternalType('array', $list);
    $this->assertEquals('xxvii, 670 p. ;,18 cm.', $list[0]);
  }

  /**
   * ...this one doesn't
   */
  public function testCanHaveNoPhysicalDescription() {
    $this->assertEmpty($this->shortTitle->physicalDescription());
  }

  /**
   * Lists of "single-property" objects should be flattened into lists of the
   * values of the single properties.
   */
  public function testListOfAuthorsIsFlattened() {
    $list = $this->title->authors();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * additional_contributors() should return a flattened list
   */
  public function testListOfAdditionalContributorsIsFlattened() {
    $list = $this->title->additionalContributors();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * publishers() should return a flattened list
   */
  public function testListOfPublishersIsFlattened() {
    $list = $this->title->publishers();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * languages() should return a flattened list
   */
  public function testListOfLanguagesIsFlattened() {
    $list = $this->title->languages();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * performers() should return a flattened list
   */
  public function testListOfPerformersIsFlattened() {
    $list = $this->title->performers();
    $this->assertInternalType('string', $list[0]);
  }

  /**
   * suitabilities() should return a flattened list
   */
  public function testListOfSuitabilitiesIsFlattened() {
    $list = $this->title->suitabilities();
    $this->assertInternalType('string', $list[0]);
  }
}
