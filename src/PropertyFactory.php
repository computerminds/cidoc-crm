<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 06/06/2016
 * Time: 14:52
 */

namespace ComputerMinds\CIDOC_CRM;


class PropertyFactory extends YamlFactory {

  protected $propertyCache = array();
  protected $listCache;

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

  protected function getSubfolder() {
    return 'property';
  }

  public function listProperties() {
    if (!isset($this->listCache)) {
      $this->listCache = array_keys($this->listFiles());
    }
    return $this->listCache;
  }


}
