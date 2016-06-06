<?php

use ComputerMinds\CIDOC_CRM\PropertyLoader;

class PropertyLoaderTest extends PHPUnit_Framework_TestCase {

  protected $yaml_path;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->yaml_path = __DIR__ . '/../yaml';
  }

  /**
   * @dataProvider propertyYamlProvider
   */
  public function testDomainDefined($yamlfile) {
    $contents = file_get_contents($yamlfile);
    $entity = new PropertyLoader($contents);
    $domain = $entity->domain();
    $this->assertFileExists($this->getYamlPath() . '/entity/' . $domain . '.yml', 'Assert that the entity: '. $domain . ' is defined in YAML.');
  }

  /**
   * @dataProvider propertyYamlProvider
   */
  public function testRangeDefined($yamlfile) {
    $contents = file_get_contents($yamlfile);
    $entity = new PropertyLoader($contents);
    $range = $entity->range();
    $this->assertFileExists($this->getYamlPath() . '/entity/' . $range . '.yml', 'Assert that the entity: '. $range . ' is defined in YAML.');
  }

  /**
   * @dataProvider propertyYamlProvider
   */
  public function testSuperpropertiesDefined($yamlfile) {
    $contents = file_get_contents($yamlfile);
    $entity = new PropertyLoader($contents);
    foreach ($entity->superproperties() as $superproperty) {
      $this->assertFileExists($this->getYamlPath() . '/property/' . $superproperty . '.yml', 'Assert that the superproperty: '. $superproperty . ' is defined in YAML.');
    }
  }

  /**
   * @return mixed
   */
  public function getYamlPath() {
    return $this->yaml_path;
  }

  public function propertyYamlProvider() {
    $entity_directory = realpath($this->getYamlPath()) . '/property/*.yml';
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
