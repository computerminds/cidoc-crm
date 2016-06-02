<?php

namespace ComputerMinds\CIDOC_CRM;

use Symfony\Component\Yaml\Yaml;

class EntityLoader {

  protected $crm_yaml;
  protected $parsed;

  /**
   * EntityLoader constructor.
   */
  public function __construct($crm_yaml) {
    $this->crm_yaml = $crm_yaml;
    $this->parsed = Yaml::parse($crm_yaml);
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

  /**
   * @return mixed
   */
  public function getCrmYaml() {
    return $this->crm_yaml;
  }


}
