<?php

namespace ComputerMinds\CIDOC_CRM;

/**
 * Class PropertyTraversal
 *
 * Provides methods for traversing the tree of entities.
 */
class PropertyTraversal {


  protected $propertyFactory;

  /**
   * PropertyTraversal constructor.
   */
  public function __construct(PropertyFactory $propertyFactory) {
    $this->propertyFactory = $propertyFactory;
  }

  public function getAllSuperproperties(Property $property) {
    $all_superclasses = array();
    $to_traverse = array();

    foreach ($property->superproperties() as $superclass) {
      $to_traverse[] = $superclass;
    }

    while (!empty($to_traverse)) {
      $this_traverse = array_shift($to_traverse);
      $all_superclasses[] = $this_traverse;
      foreach ($this->propertyFactory->getProperty($this_traverse)->superproperties() as $superclass) {
        // If we've not traversed this property, add it to the queue.
        if (!in_array($superclass, $all_superclasses, TRUE)) {
          $to_traverse[] = $superclass;
        }
      }
    }

    return array_unique($all_superclasses);
  }

  public function getSubproperties(Property $property) {
    $subproperties = array();
    $propertyName = $property->getPropertyName();
    foreach ($this->propertyFactory->listProperties() as $property_name) {
      $listProperty = $this->propertyFactory->getProperty($property_name);
      if (in_array($propertyName, $listProperty->superproperties())) {
        $subproperties[] = $listProperty->getPropertyName();
      }
    }
    return $subproperties;
  }

  public function getAllSubproperties(Property $property) {
    $all_subclasses = array();
    $all_entities = array();
    $to_traverse = array();
    $propertyName = $property->getPropertyName();
    foreach ($this->propertyFactory->listProperties() as $property_name) {
      $all_entities[$property_name] = $this->propertyFactory->getProperty($property_name);
      if (in_array($propertyName, $all_entities[$property_name]->superproperties())) {
        $to_traverse[] = $property_name;
      }
    }

    while (!empty($to_traverse)) {
      $this_traverse = array_shift($to_traverse);
      $all_subclasses[$this_traverse] = $this_traverse;
      foreach ($all_entities as $property_name => $list_property) {
        if (in_array($this_traverse, $list_property->superproperties()) && !in_array($property_name, $all_subclasses)) {
          $to_traverse[] = $property_name;
        }
      }
    }

    return array_unique(array_values($all_subclasses));
  }
}
