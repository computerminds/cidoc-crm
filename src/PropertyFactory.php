<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 06/06/2016
 * Time: 14:52
 */

namespace ComputerMinds\CIDOC_CRM;


class PropertyFactory extends YamlFactory {

  public function getProperty($propertyName) {
    // Search the Yaml directories for a matching name.
    if ($filename = $this->findFile($propertyName)) {
      // Load the File and pop the result into a class.
      return new PropertyLoader(file_get_contents($filename));
    }
    else {
      throw new LoaderException('Could not locate file containing property: ' . $propertyName);
    }
  }

  protected function getSubfolder() {
    return 'property';
  }
  
  public function listProperties() {
    return array_keys($this->listFiles());
  }


}