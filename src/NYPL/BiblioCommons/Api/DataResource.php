<?php

/**
 * @file
 * DataResource class 
 */

namespace NYPL\BiblioCommons\Api;

class DataResource {

  /**
   * The parsed JSON data.
   *
   * @var StdObj
   */
  protected $data;

  /**
   * SimpleResource object constructor.
   *
   * @param StdObj $data 
   *   Parsed JSON for the object.
   */
  public function __construct($data) {
    $this->data = $data;
  }

  /**
   * Tests for and converts empty values.
   *
   * The BiblioCommons API has a serious design flaw in that there is no 
   * standard for null data. Sometimes properties are null, sometimes they are
   * empty strings or lists and sometimes they are just not present. For 
   * instance, when titles are returned as part of a search by the titles/ 
   * endpoint, they are missing many of the fields that would be returned for 
   * the same title by the titles/{id} endpoint. Within the title JSON object,
   * lack of an 'availability' is expressed as null, lack of authors as an
   * empty array, and lack of a subtitle as an empty string. 
   *
   * In order to smooth over this unmethodical variety, this method takes the 
   * name of a property its expected type and optional null value (default 
   * NULL), then tests the various possibilies. If a property with the given
   * name exists and is of the given type, the value is returned. Otherwise, the
   * given null or empty value is returned.
   *
   * @param mixed $value 
   *   Name of property to be looked up in the object's $data property.
   * @param string $class 
   *   Expected class for the property.
   * @param mixed $null_value 
   *   Value to be returned if the property is null, empty, or missing.
   */
  protected function initOptionalProperty($value, $class, $null_value = NULL) {
    if (!property_exists($this->data, $value)) {
      $this->data->$value = $null_value;
      return;
    }

    if (gettype($this->data->$value) === $class) {
      if ($class === 'string') {
        if (($this->data->$value === '') or ($this->data->$value === NULL)) {
          $this->data->$value = $null_value;
        }

        // Leave value as is.
        return;
      }

      if ($class == 'array') {
        if ((count($this->data->$value) === 0) or ($this->data->$value === NULL)) {
          $this->data->$value = $null_value;
        }

        // Leave value as is.
        return;
      }

      if ($class == 'object') {
        if ($this->data->$value === NULL) {
          $this->data->$value = $null_value;
        }

        // Leave value as is.
        return;
      }

      if ($class == 'integer') {
        if ($this->data->$value === NULL) {
          $this->data->$value = $null_value;
        }

        // Leave value as is.
        return;
      }

      throw new \Exception('Did not test variable of type ' .
        gettype($this->data->$value));
    }
    else {
      throw new \Exception('WRONG TYPE (' . $class . ') for ' . $value . '(' . gettype($this->data->$value) . ')');
    }
  }

  /**
   * Flattens lists of single-property items.
   *
   * The BiblioCommons API returns many properties, the 'authors' property of
   * Title objects, for instance, as lists of objects with a single property 
   * (usually) name. Take a list of single-property objects and return a list
   * of only the values of the single properties. E.g.:
   *
   * "authors": [
   *   {
   *     "name": "First Author"  
   *   },
   *   {
   *     "name": "Second Author"  
   *   }
   * ]
   *
   * becomes:
   *
   * ["First Author", "Second Author"]
   *
   * @param array $list
   *   The list to flatten
   * @param string $prop
   *   The property to pick out of the object
   *
   * @return array
   *   The flattened list of properties
   * @throws \NYPL\BiblioCommons\API\PropertyNotFoundException
   *   When the given property does not exist in the object 
   */
  protected function flattenSingleProperties($list, $prop = 'name') {
    // NULL lists should stay NULL. Avoid error. Do nothing.
    if ($list === NULL) {
      return;
    }

    $flattened = array();

    foreach ($list as $item) {
      if (!property_exists($item, $prop)) {
        throw new PropertyNotFoundException("Flattening object but it does "
          . "not have a \"" . $prop . "\" property.");
      }

      $flattened[] = $item->$prop;
    }
    return $flattened;
  }
}
