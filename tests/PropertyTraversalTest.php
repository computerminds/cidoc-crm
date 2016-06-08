<?php

use ComputerMinds\CIDOC_CRM\Property;

class PropertyTraversalTest extends PHPUnit_Framework_TestCase {

  protected $propertyFactory;
  protected $traversal;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $searchDirectories = array(
      __DIR__ . '/yaml',
    );
    $this->propertyFactory = new ComputerMinds\CIDOC_CRM\PropertyFactory($searchDirectories);
  }

  protected function setUp() {
    parent::setUp();
    $this->traversal = new ComputerMinds\CIDOC_CRM\PropertyTraversal($this->propertyFactory);
  }

  public function testGetAllSuperproperties() {
    $property = $this->propertyFactory->getProperty('p1_level_one');
    $this->assertEmpty($this->traversal->getAllSuperproperties($property), 'Assert that our top level class has no superclasses.');

    $property = $this->propertyFactory->getProperty('p2_level_two');
    $all_superproperties = $this->traversal->getAllSuperproperties($property);
    $this->assertTrue(in_array('p1_level_one', $all_superproperties, TRUE), 'Assert that our property p2_level_two has a single superproperty p1_level_one.');
    $this->assertCount(1, $all_superproperties, 'Assert that our property p2_level_two has a single superproperty.');

    $property = $this->propertyFactory->getProperty('p3_level_three');
    $all_superproperties = $this->traversal->getAllSuperproperties($property);
    $this->assertTrue(in_array('p1_level_one', $all_superproperties, TRUE), 'Assert that our property p3_level_three has a superproperty p1_level_one.');
    $this->assertTrue(in_array('p2_level_two', $all_superproperties, TRUE), 'Assert that our property p3_level_three has a superproperty p2_level_two.');
    $this->assertCount(2, $all_superproperties, 'Assert that our property p3_level_three has two superproperties.');
  }

  public function testGetSubproperties() {
    $property = $this->propertyFactory->getProperty('p1_level_one');
    $all_subproperties = $this->traversal->getSubproperties($property);
    $this->assertTrue(in_array('p2_level_two', $all_subproperties, TRUE), 'Assert that p1_level_one property has a subproperty of p2_level_two.');
    $this->assertCount(1, $all_subproperties, 'Assert that our property has a single supproperty.');

    $property = $this->propertyFactory->getProperty('p3_level_three');
    $all_subproperties = $this->traversal->getSubproperties($property);
    $this->assertEmpty($all_subproperties, 'Assert that our bottom level property has no subproperties.');
  }

  public function testGetAllSubproperties() {
    $property = $this->propertyFactory->getProperty('p1_level_one');
    $all_subproperties = $this->traversal->getAllSubproperties($property);
    $this->assertTrue(in_array('p2_level_two', $all_subproperties, TRUE), 'Assert that p1_level_one property has a subclasses of p2_level_two.');
    $this->assertTrue(in_array('p3_level_three', $all_subproperties, TRUE), 'Assert that p1_level_one property has a subclasses of p3_level_three.');
    $this->assertCount(2, $all_subproperties, 'Assert that our property has 2 subproperties.');

    $property = $this->propertyFactory->getProperty('p2_level_two');
    $all_subproperties = $this->traversal->getAllSubproperties($property);
    $this->assertTrue(in_array('p3_level_three', $all_subproperties, TRUE), 'Assert that p2_level_two property has a subclasses of p3_level_three.');
    $this->assertCount(1, $all_subproperties, 'Assert that our property has 1 subproperty.');

    $property = $this->propertyFactory->getProperty('p3_level_three');
    $all_subproperties = $this->traversal->getAllSubproperties($property);
    $this->assertCount(0, $all_subproperties, 'Assert that our property has 0 subproperties.');
  }
}
