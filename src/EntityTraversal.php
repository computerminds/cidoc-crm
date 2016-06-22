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

    return array_unique($all_superclasses);
  }

  public function getSubclasses(Entity $entity) {
    $subclasses = array();
    $entityName = $entity->getEntityName();
    foreach ($this->entityFactory->listEntities() as $entity_name) {
      $listEntity = $this->entityFactory->getEntity($entity_name);
      if (in_array($entityName, $listEntity->superclasses())) {
        $subclasses[] = $listEntity->getEntityName();
      }
    }
    return $subclasses;
  }

  public function getAllSubclasses(Entity $entity) {
    $all_subclasses = array();
    $all_entities = array();
    $to_traverse = array();
    $entityName = $entity->getEntityName();
    foreach ($this->entityFactory->listEntities() as $entity_name) {
      $all_entities[$entity_name] = $this->entityFactory->getEntity($entity_name);
      if (in_array($entityName, $all_entities[$entity_name]->superclasses())) {
        $to_traverse[] = $entity_name;
      }
    }

    while (!empty($to_traverse)) {
      $this_traverse = array_shift($to_traverse);
      $all_subclasses[$this_traverse] = $this_traverse;
      foreach ($all_entities as $entity_name => $list_entity) {
        if (in_array($this_traverse, $list_entity->superclasses()) && !in_array($entity_name, $all_subclasses)) {
          $to_traverse[] = $entity_name;
        }
      }
    }

    return array_unique(array_values($all_subclasses));
  }
}
