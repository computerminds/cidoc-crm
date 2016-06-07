<?php

use ComputerMinds\CIDOC_CRM\Entity;

class EntityTest extends PHPUnit_Framework_TestCase {

  protected $entityFactory;
  protected $propertyFactory;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->entityFactory = new ComputerMinds\CIDOC_CRM\EntityFactory();
    $this->propertyFactory = new ComputerMinds\CIDOC_CRM\PropertyFactory();
  }

  /**
   * @dataProvider entityProvider
   */
  public function testSuperclassesDefined(\ComputerMinds\CIDOC_CRM\Entity $entity) {
    foreach ($entity->superclasses() as $superclass) {
      $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->entityFactory->getEntity($superclass), 'Assert that the superclass: '. $superclass . ' is defined.');
    }
  }

  /**
   * @dataProvider entityProvider
   */
  public function testPropertiesDefined(\ComputerMinds\CIDOC_CRM\Entity $entity) {
    foreach ($entity->properties() as $property) {
      $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Property', $this->propertyFactory->getProperty($property), 'Assert that the property: '. $property . ' is defined.');
    }
  }

  /**
   * @dataProvider entityProvider
   */
  public function testLabelsDefined(\ComputerMinds\CIDOC_CRM\Entity $entity) {
    $this->assertNotEmpty($entity->getLabel(), 'Assert that the entity has a label.');
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
