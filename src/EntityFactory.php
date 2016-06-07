<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 06/06/2016
 * Time: 14:52
 */

namespace ComputerMinds\CIDOC_CRM;


class EntityFactory extends YamlFactory {

  public function getEntity($entityName) {
    // Search the Yaml directories for a matching name.
    if ($filename = $this->findFile($entityName)) {
      // Load the File and pop the result into a class.
      return new Entity(file_get_contents($filename));
    }
    else {
      throw new FactoryException('Could not locate file containing entity: ' . $entityName);
    }
  }

  protected function getSubfolder() {
    return 'entity';
  }
  
  public function listEntities() {
    return array_keys($this->listFiles());
  }


}