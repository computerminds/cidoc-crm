<?php

namespace ComputerMinds\CIDOC_CRM;

use Symfony\Component\Yaml\Yaml;

class Entity {

  protected $crm_yaml;
  protected $parsed;

  protected $entityName;
  /**
   * Entity constructor.
   */
  public function __construct($entityName, $crm_yaml) {
    $this->entityName = $entityName;
    $this->crm_yaml = $crm_yaml;
    $this->parsed = Yaml::parse($crm_yaml);
  }

  /**
   * @return string
   *   Entity name.
   */
  public function getEntityName() {
    return $this->entityName;
  }

  public function superclasses() {
    if (isset($this->parsed['superclasses'])) {
      return $this->parsed['superclasses'];
    }
    else {
      return array();
    }
  }

  public function properties() {
    if (isset($this->parsed['properties'])) {
      return $this->parsed['properties'];
    }
    else {
      return array();
    }
  }

  public function getLabel() {
    if (isset($this->parsed['label'])) {
      return $this->parsed['label'];
    }
    else {
      return '';
    }
  }

  /**
   * @return mixed
   */
  public function getCrmYaml() {
    return $this->crm_yaml;
  }

  public function getDescription() {
    if (isset($this->parsed['description'])) {
      return $this->parsed['description'];
    }
    else {
      return '';
    }
  }

  public function getExamples() {
    if (isset($this->parsed['examples'])) {
      return $this->parsed['examples'];
    }
    else {
      return '';
    }
  }

}
