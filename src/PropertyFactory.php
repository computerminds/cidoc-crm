<?php

namespace ComputerMinds\CIDOC_CRM;

/**
 * A property factory.
 */
class PropertyFactory extends YamlFactory {

  /**
   * An internal cache of the loaded properties.
   *
   * @var array
   *  The internally cached properties.
   */
  protected $propertyCache = array();

  /**
   * A cache of the files available to this factory.
   *
   * @var array|null
   *   The cached files.
   */
  protected $listCache;

  /**
   * @param string $propertyName
   *   The CRM property name to load.
   *
   * @return \ComputerMinds\CIDOC_CRM\Property|null
   *   The loaded CRM Property object or null if a YAML representation cannot
   *   be found.
   */
  public function getProperty($propertyName) {
    if (!isset($this->propertyCache[$propertyName])) {
      // Search the Yaml directories for a matching name.
      if ($filename = $this->findFile($propertyName)) {
        // Load the File and pop the result into a class.
        $this->propertyCache[$propertyName] = new Property($this->getNameFromFilename($filename), file_get_contents($filename));
      }
      else {
        throw new FactoryException('Could not locate file containing property: ' . $propertyName);
      }
    }

    return $this->propertyCache[$propertyName];
  }

  /**
   * The folder to search for properties in.
   *
   * @return string
   *   The string 'property'.
   */
  protected function getSubfolder() {
    return 'property';
  }

  /**
   * The properties available to this factory.
   *
   * @return string[]
   *   An array of property names available to from this factory.
   */
  public function listProperties() {
    if (!isset($this->listCache)) {
      $this->listCache = array_keys($this->listFiles());
    }
    return $this->listCache;
  }

}
