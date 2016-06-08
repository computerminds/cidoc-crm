<?php

namespace ComputerMinds\CIDOC_CRM;

/**
 * Class EntityTraversal
 *
 * Provides methods for traversing the tree of entities.
 */
class EntityTraversal {


  protected $entityFactory;

  /**
   * EntityTraversal constructor.
   */
  public function __construct(EntityFactory $entityFactory) {
    $this->entityFactory = $entityFactory;
  }

  public function getAllSuperclasses(Entity $entity) {
    $all_superclasses = array();
    $to_traverse = array();

    foreach ($entity->superclasses() as $superclass) {
      $to_traverse[] = $superclass;
    }

    while (!empty($to_traverse)) {
      $this_traverse = array_shift($to_traverse);
      $all_superclasses[] = $this_traverse;
      foreach ($this->entityFactory->getEntity($this_traverse)->superclasses() as $superclass) {
        // If we've not traversed this entity, add it to the queue.
        if (!in_array($superclass, $all_superclasses, TRUE)) {
          $to_traverse[] = $superclass;
        }
      }
    }

    return $all_superclasses;
  }

  public function getSubclasses(Entity $entity) {
    foreach ($this->entityFactory->listEntities() as $entity_name) {
//      if (in_array($entity->))
    } 
  }
}