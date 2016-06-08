<?php

use ComputerMinds\CIDOC_CRM\Entity;

class EntityTraversalTest extends PHPUnit_Framework_TestCase {

  protected $entityFactory;
  protected $traversal;

  public function __construct($name = '', array $data = array(), $dataName = '') {
    parent::__construct($name, $data, $dataName);
    $searchDirectories = array(
      __DIR__ . '/yaml',
    );
    $this->entityFactory = new ComputerMinds\CIDOC_CRM\EntityFactory($searchDirectories);
  }

  protected function setUp() {
    parent::setUp();
    $this->traversal = new ComputerMinds\CIDOC_CRM\EntityTraversal($this->entityFactory);
  }


  public function testGetAllSuperclasses() {
    $entity = $this->entityFactory->getEntity('e1_top_level');
    $this->assertEmpty($this->traversal->getAllSuperclasses($entity), 'Assert that our top level class has no superclasses.');

    $entity = $this->entityFactory->getEntity('e4_subclass');
    $all_superclasses = $this->traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our subclass class has a single superclasses.');
    $this->assertCount(1, $all_superclasses, 'Assert that our subclass class has a single superclasses.');

    $entity = $this->entityFactory->getEntity('e5_subsubclass');
    $all_superclasses = $this->traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our subsubclass class has two superclasses.');
    $this->assertTrue(in_array('e4_subclass', $all_superclasses, TRUE), 'Assert that our subsubclass class has two superclasses.');
    $this->assertCount(2, $all_superclasses, 'Assert that our subclass class has two superclasses.');

    $entity = $this->entityFactory->getEntity('e6_other_subsubclass');
    $all_superclasses = $this->traversal->getAllSuperclasses($entity);
    $this->assertTrue(in_array('e1_top_level', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertTrue(in_array('e4_subclass', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertTrue(in_array('e5_subsubclass', $all_superclasses, TRUE), 'Assert that our other subsubclass class has three superclasses.');
    $this->assertCount(3, $all_superclasses, 'Assert that our subclass class has three superclasses.');
  }

  public function testGetSubclasses() {
    $entity = $this->entityFactory->getEntity('e1_top_level');
    $all_subclasses = $this->traversal->getSubclasses($entity);
    $this->assertTrue(in_array('e4_subclass', $all_subclasses, TRUE), 'Assert that our superclass class has a single subclasses.');
    $this->assertCount(1, $all_subclasses, 'Assert that our subclass class has a single superclasses.');

    $entity = $this->entityFactory->getEntity('e6_other_subsubclass');
    $all_subclasses = $this->traversal->getSubclasses($entity);
    $this->assertEmpty($all_subclasses, 'Assert that our bottom level class has no subclasses.');
  }

  public function testGetAllSubclasses() {
    $entity = $this->entityFactory->getEntity('e1_top_level');
    $all_subclasses = $this->traversal->getAllSubclasses($entity);
    $this->assertTrue(in_array('e4_subclass', $all_subclasses, TRUE), 'Assert that e1_top_level class has a subclasses of e4_subclass.');
    $this->assertTrue(in_array('e5_subsubclass', $all_subclasses, TRUE), 'Assert that e1_top_level class has a subclasses of e5_subsubclass.');
    $this->assertTrue(in_array('e6_other_subsubclass', $all_subclasses, TRUE), 'Assert that e1_top_level class has a subclasses of e6_other_subsubclass.');
    $this->assertCount(3, $all_subclasses, 'Assert that our subclass class has superclasses.');

    $entity = $this->entityFactory->getEntity('e5_subsubclass');
    $all_subclasses = $this->traversal->getAllSubclasses($entity);
    $this->assertTrue(in_array('e6_other_subsubclass', $all_subclasses, TRUE), 'Assert that e5_subsubclass class has a subclasses of e6_other_subsubclass.');
    $this->assertCount(1, $all_subclasses, 'Assert that our subclass class has superclasses.');

    $entity = $this->entityFactory->getEntity('e6_other_subsubclass');
    $all_subclasses = $this->traversal->getAllSubclasses($entity);
    $this->assertEmpty($all_subclasses, 'Assert that our bottom level class has no subclasses.');
  }
}
