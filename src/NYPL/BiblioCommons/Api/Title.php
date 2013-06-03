<?php

/**
 * @file
 * Library class 
 */

namespace NYPL\BiblioCommons\Api;

class Title extends ClientResource {

  protected $format;
  protected $availability;

  /**
   * Title object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   * @param Client $client
   *   Client for future connections
   */
  public function __construct($data, $client) {
    parent::__construct($data, $client);
    $this->data->format = new Format($this->data->format);
    $this->initOptionalProperties();
    $this->initSingleProperties();
    $this->initSeries();
  }

  /**
   * Initialize optional properties.
   */
  protected function initOptionalProperties() {
    $this->initOptionalProperty('sub_title', 'string');
    $this->initOptionalProperty('availability', 'object');
    $this->initOptionalProperty('authors', 'array', array());
    $this->initOptionalProperty('isbns', 'array', array());
    $this->initOptionalProperty('upcs', 'array', array());
    $this->initOptionalProperty('call_number', 'string');
    $this->initOptionalProperty('description', 'string');
    $this->initOptionalProperty('additional_contributors', 'array', array());
    $this->initOptionalProperty('publishers', 'array', array());
    $this->initOptionalProperty('pages', 'integer');
    $this->initOptionalProperty('series', 'array', array());
    $this->initOptionalProperty('edition', 'string');
    $this->initOptionalProperty('primary_language', 'object');
    $this->initOptionalProperty('languages', 'array', array());
    $this->initOptionalProperty('contents', 'array', array());
    $this->initOptionalProperty('performers', 'array', array());
    $this->initOptionalProperty('suitabilities', 'array', array());
    $this->initOptionalProperty('notes', 'array', array());
    $this->initOptionalProperty('statement_of_responsibility', 'string');
    $this->initOptionalProperty('physical_description', 'array', array());

    if ($this->data->availability !== NULL) {
      $this->data->availability = new Availability($this->data->availability);
    }
  }

  /**
   * Flatten lists of single-property objects
   */
  protected function initSingleProperties() {
    $this->data->authors
      = $this->flattenSingleProperties($this->data->authors);
    $this->data->additional_contributors
      = $this->flattenSingleProperties($this->data->additional_contributors);
    $this->data->publishers
      = $this->flattenSingleProperties($this->data->publishers);
    $this->data->languages
      = $this->flattenSingleProperties($this->data->languages);
    $this->data->performers
      = $this->flattenSingleProperties($this->data->performers);
    $this->data->suitabilities
      = $this->flattenSingleProperties($this->data->suitabilities);
  }

  /**
   * Convert series in objects of proper class
   */ 
  protected function initSeries() {
    $seriesObjects = array();
    foreach ($this->data->series as $s) {
      $seriesObjects[] = new Series($s);
    }
    $this->data->series = $seriesObjects;
  }

  /**
   * Returns the titles's name (i.e. title).
   *
   * This method is not called title() so that there will be no confusion
   * about it being a constructor.
   *
   * @return string
   *   The title
   */
  public function name() {
    return $this->data->title;
  }

  /**
   * Returns the titles's id.
   *
   * @return string
   *   The id
   */
  public function id() {
    return $this->data->id;
  }

  /**
   * Returns the URL for the title on BiblioCommons.
   *
   * @return string
   *   The URL
   */
  public function details() {
    return $this->data->details_url;
  }

  /**
   * Returns the title's format.
   *
   * @return \NYPL\BiblioCommons\Api\Format
   *   The format
   */
  public function format() {
    return $this->data->format;
  }

  /**
   * Returns the title's subtitle.
   *
   * @return string
   *   The name
   */
  public function subtitle() {
    return $this->data->sub_title;
  }

  /**
   * Returns the title's availability.
   *
   * @return \NYPL\BiblioCommons\Api\Availability
   *   The availability
   */
  public function availability() {
    return $this->data->availability;
  }

  /**
   * Returns the title's authors.
   *
   * @return array
   *   The authors
   */
  public function authors() {
    return $this->data->authors;
  }

  /**
   * Returns the title's isbns.
   *
   * @return array
   *   The isbns
   */
  public function isbns() {
    return $this->data->isbns;
  }

  /**
   * Returns the title's upcs.
   *
   * @return array
   *   The upcs
   */
  public function upcs() {
    return $this->data->upcs;
  }

  /**
   * Returns the title's call number.
   *
   * @return string
   *   The call number
   */
  public function callNumber() {
    return $this->data->call_number;
  }

  /**
   * Returns the title's description.
   *
   * @return string
   *   The description
   */
  public function description() {
    return $this->data->description;
  }

  /**
   * Returns the title's additional contributors.
   *
   * @return array
   *   The additional contributors
   */
  public function additionalContributors() {
    return $this->data->additional_contributors;
  }

  /**
   * Returns the title's publishers.
   *
   * @return array
   *   The publishers
   */
  public function publishers() {
    return $this->data->publishers;
  }

  /**
   * Returns the title's pages.
   *
   * @return integer
   *   The pages
   */
  public function pages() {
    return $this->data->pages;
  }

  /**
   * Returns the title's series.
   *
   * @return array
   *   The series
   */
  public function series() {
    return $this->data->series;
  }

  /**
   * Returns the title's edition.
   *
   * @return string
   *   The edition
   */
  public function edition() {
    return $this->data->edition;
  }

  /**
   * Returns the title's primary language.
   *
   * @return string
   *   The language
   */
  public function primaryLanguage() {
    if ($this->data->primary_language === NULL) {
      return NULL;      
    }
    return $this->data->primary_language->name;
  }

  /**
   * Returns the title's languages.
   *
   * @return array
   *   The languages
   */
  public function languages() {
    return $this->data->languages;
  }

  /**
   * Returns the title's contents.
   *
   * @return array
   *   The contents
   */
  public function contents() {
    return $this->data->contents;
  }

  /**
   * Returns the title's performers.
   *
   * @return array
   *   The performers
   */
  public function performers() {
    return $this->data->performers;
  }

  /**
   * Returns the title's suitabilities.
   *
   * @return array
   *   The suitabilities
   */
  public function suitabilities() {
    return $this->data->suitabilities;
  }

  /**
   * Returns the title's notes.
   *
   * @return array
   *   The notes
   */
  public function notes() {
    return $this->data->notes;
  }

  /**
   * Returns the title's statement of responsibility.
   *
   * @return string
   *   The statement of responsibility
   */
  public function statementOfResponsibility() {
    return $this->data->statement_of_responsibility;
  }

  /**
   * Returns the title's physical description.
   *
   * @return array
   *   The physical description
   */
  public function physicalDescription() {
    return $this->data->physical_description;
  }
}
