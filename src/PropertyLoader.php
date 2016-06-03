<?php

namespace ComputerMinds\CIDOC_CRM;

use Symfony\Component\Yaml\Yaml;

class PropertyLoader {

  protected $crm_yaml;
  protected $parsed;

  /**
   * EntityLoader constructor.
   */
  public function __construct($crm_yaml) {
    $this->crm_yaml = $crm_yaml;
    $this->parsed = Yaml::parse($crm_yaml);
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
