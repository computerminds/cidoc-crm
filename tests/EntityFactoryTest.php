<?php

/**
 * Created by PhpStorm.
 * User: steven
 * Date: 06/06/2016
 * Time: 15:03
 */
class EntityFactoryTest extends PHPUnit_Framework_TestCase {

  protected $factory;

  protected function setUp() {
    // Set up a factory to search our test directories.
    $searchDirectories = array(
      __DIR__ . '/yaml',
    );
    $this->factory = new \ComputerMinds\CIDOC_CRM\EntityFactory($searchDirectories);
    parent::setUp();
  }


  public function testGetEntity() {
    $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->factory->getEntity('e1_top_level'), 'Factory can load test entity.');
    $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->factory->getEntity('e2_sub_directory'), 'Factory can load test entity in subdirectory.');
    $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->factory->getEntity('e3_yaml_not_yml'), 'Factory can load entity in .yaml not .yml file.');

  }

  /**
   * @expectedException \ComputerMinds\CIDOC_CRM\FactoryException
   */
  public function testFailToGetEntity() {
    $this->factory->getEntity('e2_entity_not_present');
  }

  public function testListEntities() {
    $entities = $this->factory->listEntities();
    $this->assertTrue(in_array('e1_top_level', $entities, TRUE), 'Factory can list test entities.');
    $this->assertTrue(in_array('e2_sub_directory', $entities, TRUE), 'Factory can list test entities.');
    $this->assertTrue(in_array('e3_yaml_not_yml', $entities, TRUE), 'Factory can list test entities.');
    $this->assertFalse(in_array('e2_entity_not_present', $entities, TRUE), 'Factory cannot list test entities that do not exist.');
  }
}
