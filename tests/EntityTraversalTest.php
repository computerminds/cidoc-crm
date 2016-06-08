<?php

use ComputerMinds\CIDOC_CRM\Entity;

class EntityTraversalTest extends PHPUnit_Framework_TestCase {

  protected $entityFactory;
  protected $propertyFactory;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $searchDirectories = array(
      __DIR__ . '/yaml',
    );
    $this->entityFactory = new ComputerMinds\CIDOC_CRM\EntityFactory($searchDirectories);
    $this->propertyFactory = new ComputerMinds\CIDOC_CRM\PropertyFactory($searchDirectories);
  }

  public function testGetAllSuperclasses() {
    $traversal = new ComputerMinds\CIDOC_CRM\EntityTraversal($this->entityFactory);

    $entity = $this->entityFactory->getEntity('e1_top_level');
    $this->assertEmpty($traversal->getAllSuperclasses($entity), 'Assert that our top level class has no superclasses.');

    $entity = $this->entityFactory->getEntity('e4_subclass');
    $all_superclasses = $traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our subclass class has a single superclasses.');
    $this->assertCount(1, $all_superclasses, 'Assert that our subclass class has a single superclasses.');

    $entity = $this->entityFactory->getEntity('e5_subsubclass');
    $all_superclasses = $traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our subsubclass class has two superclasses.');
    $this->assertTrue(in_array('e4_subclass', $all_superclasses, TRUE), 'Assert that our subsubclass class has two superclasses.');
    $this->assertCount(2, $all_superclasses, 'Assert that our subclass class has two superclasses.');

    $entity = $this->entityFactory->getEntity('e6_other_subsubclass');
    $all_superclasses = $traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertTrue(in_array('e4_subclass', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertTrue(in_array('e5_subsubclass', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertCount(3, $all_superclasses, 'Assert that our subclass class has three superclasses.');
  }
}
