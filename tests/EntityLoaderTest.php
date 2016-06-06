<?php

use ComputerMinds\CIDOC_CRM\EntityLoader;

class EntityLoaderTest extends PHPUnit_Framework_TestCase {

  protected $yaml_path;
  protected $entityFactory;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->yaml_path = __DIR__ . '/../yaml';
    $this->entityFactory = new ComputerMinds\CIDOC_CRM\EntityFactory();
  }

  /**
   * @dataProvider entityProvider
   */
  public function testSuperclassesDefined($entity) {
    foreach ($entity->superclasses() as $superclass) {
      $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\EntityLoader', $this->entityFactory->getEntity($superclass), 'Assert that the superclass: '. $superclass . ' is defined.');
    }
  }

  /**
   * @dataProvider entityProvider
   */
  public function testPropertiesDefined($entity) {
    foreach ($entity->properties() as $property) {
      $this->assertFileExists($this->getYamlPath() . '/property/' . $property . '.yml', 'Assert that the property: '. $property . ' is defined in YAML.');
    }
  }

  /**
   * @return mixed
   *
   * @deprecated 
   */
  public function getYamlPath() {
    return $this->yaml_path;
  }

  /**
   * @return array
   * @deprecated
   */
  public function entityYamlProvider() {
    $entity_directory = realpath($this->getYamlPath()) . '/entity/*.yml';
    $iterator = new GlobIterator($entity_directory);
    $files = array();
    foreach ($iterator as $file) {
      $files[$file->getFilename()] = array(
        (string) $file,
      );
    }
    return $files;
  }

  public function entityProvider() {
    $loadedEntities = array();
    $entities = $this->entityFactory->listEntities();
    foreach ($entities as $entityName) {
      $loadedEntities[$entityName] = array(
        $this->entityFactory->getEntity($entityName)
      );
    }
    return new ArrayIterator($loadedEntities);
  }
}
