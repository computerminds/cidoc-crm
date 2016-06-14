<?php

namespace ComputerMinds\CIDOC_CRM;

use Symfony\Component\Yaml\Yaml;

class Property {

  protected $crm_yaml;
  protected $parsed;
  protected $propertyName;

  /**
   * Entity constructor.
   */
  public function __construct($propertyName, $crm_yaml) {
    $this->propertyName = $propertyName;
    $this->crm_yaml = $crm_yaml;
    $this->parsed = Yaml::parse($crm_yaml);
  }

  /**
   * @return string
   *   The property name.
   */
  public function getPropertyName() {
    return $this->propertyName;
  }

  public function getLabel() {
    if (isset($this->parsed['label'])) {
      return $this->parsed['label'];
    }
    else {
      return '';
    }
  }

  public function getReverseLabel() {
    if (isset($this->parsed['reverse label'])) {
      return $this->parsed['reverse label'];
    }
    else {
      return $this->getLabel();
    }
  }

  public function domain() {
    if (isset($this->parsed['domain'])) {
      return $this->parsed['domain'];
    }
  }

  public function range() {
    if (isset($this->parsed['range'])) {
      return $this->parsed['range'];
    }
  }

  public function superproperties() {
    if (isset($this->parsed['superproperties'])) {
      return $this->parsed['superproperties'];
    }
    else {
      return array();
    }
  }

  /**
   * @return mixed
   */
  public function getCrmYaml() {
    return $this->crm_yaml;
  }
}
