<?php
/**
 * Created by PhpStorm.
 * User: steven
 * Date: 06/06/2016
 * Time: 14:52
 */

namespace ComputerMinds\CIDOC_CRM;


class EntityFactory extends YamlFactory {

  protected $entityCache = array();
  protected $listCache;

  public function getEntity($entityName) {
    if (!isset($this->entityCache[$entityName])) {
      // Search the Yaml directories for a matching name.
      if ($filename = $this->findFile($entityName)) {
        // Load the File and pop the result into a class.
        $this->entityCache[$entityName] = new Entity($this->getNameFromFilename($filename), file_get_contents($filename));
      }
      else {
        throw new FactoryException('Could not locate file containing entity: ' . $entityName);
      }
    }

    return $this->entityCache[$entityName];
  }

  protected function getSubfolder() {
    return 'entity';
  }

  public function listEntities() {
    if (!isset($this->listCache)) {
      $this->listCache = array_keys($this->listFiles());
    }
    return $this->listCache;
  }


}
