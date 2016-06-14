<?php

use ComputerMinds\CIDOC_CRM\Property;

class PropertyTest extends PHPUnit_Framework_TestCase {

  protected $entityFactory;
  protected $propertyFactory;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $this->entityFactory = new ComputerMinds\CIDOC_CRM\EntityFactory();
    $this->propertyFactory = new ComputerMinds\CIDOC_CRM\PropertyFactory();
  }

  /**
   * @dataProvider propertyProvider
   */
  public function testDomainDefined(\ComputerMinds\CIDOC_CRM\Property $property) {
    $domain = $property->domain();
    $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->entityFactory->getEntity($domain), 'Assert that the domain entity: '. $domain . ' is defined.');
  }

  /**
   * @dataProvider propertyProvider
   */
  public function testRangeDefined(\ComputerMinds\CIDOC_CRM\Property $property) {
    $range = $property->range();
    $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Entity', $this->entityFactory->getEntity($range), 'Assert that the range entity: '. $range . ' is defined.');
  }

  /**
   * @dataProvider propertyProvider
   */
  public function testSuperpropertiesDefined(\ComputerMinds\CIDOC_CRM\Property $property) {
    foreach ($property->superproperties() as $superproperty) {
      $this->assertInstanceOf('\ComputerMinds\CIDOC_CRM\Property', $this->propertyFactory->getProperty($superproperty), 'Assert that the superproperty entity: '. $superproperty . ' is defined.');
    }
  }

  /**
   * @dataProvider propertyProvider
   */
  public function testLabelsDefined(\ComputerMinds\CIDOC_CRM\Property $property) {
    $this->assertNotEmpty($property->getLabel(), 'Assert that the property has a label.');
  }

  /**
   * @dataProvider propertyProvider
   */
  public function testReverseLabelsDefined(\ComputerMinds\CIDOC_CRM\Property $property) {
    $this->assertNotEmpty($property->getReverseLabel(), 'Assert that the property has a reverse label.');
  }

  public function propertyProvider() {
    $loadedProperties = array();
    $properties = $this->propertyFactory->listProperties();
    foreach ($properties as $propertyName) {
      $loadedProperties[$propertyName] = array(
        $this->propertyFactory->getProperty($propertyName)
      );
    }
    return new ArrayIterator($loadedProperties);
  }
}
