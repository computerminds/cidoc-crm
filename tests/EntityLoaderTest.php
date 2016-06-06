<?php

use ComputerMinds\CIDOC_CRM\EntityLoader;

class EntityLoaderTest extends PHPUnit_Framework_TestCase {

  protected $yaml_path;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->yaml_path = __DIR__ . '/../yaml';
  }


  /**
   * @dataProvider entityYamlProvider
   */
  public function testSuperclassesDefined($yamlfile) {
    $contents = file_get_contents($yamlfile);
    $entity = new EntityLoader($contents);
    foreach ($entity->superclasses() as $superclass) {
      $this->assertFileExists($this->getYamlPath() . '/entity/' . $superclass . '.yml', 'Assert that the superclass: '. $superclass . ' is defined in YAML.');
    }
  }

  /**
   * @dataProvider entityYamlProvider
   */
  public function testPropertiesDefined($yamlfile) {
    $contents = file_get_contents($yamlfile);
    $entity = new EntityLoader($contents);
    foreach ($entity->properties() as $property) {
      $this->assertFileExists($this->getYamlPath() . '/property/' . $property . '.yml', 'Assert that the property: '. $property . ' is defined in YAML.');
    }
  }

  /**
   * @return mixed
   */
  public function getYamlPath() {
    return $this->yaml_path;
  }

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
}
