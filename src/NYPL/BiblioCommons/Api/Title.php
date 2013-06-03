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
    $this->initOptionalProperty('statement_of_responsibility', 'string');
    $this->initOptionalProperty('number', 'string');
    $this->initOptionalProperty('physical_description', 'array', array());

    if ($this->data->availability !== NULL) {
      $this->data->availability = new Availability($this->data->availability);
    }

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
   * Returns the title's languages.
   *
   * @return array
   *   The languages
   */
  public function languages() {
    return $this->data->languages;
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
}
