<?php

namespace ComputerMinds\CIDOC_CRM;


abstract class YamlFactory {

  protected $searchDirectories;

  /**
   * YamlFactory constructor.
   *
   * @param array $searchDirectories
   *   Directories to search for when looking for Yaml.
   */
  public function __construct(array $searchDirectories = NULL) {
    // Fallback to a default.
    if (is_null($searchDirectories)) {
      $searchDirectories[] = realpath(__DIR__ . '/../yaml');
    }

    $this->searchDirectories = $searchDirectories;
  }

  abstract protected function getSubfolder();

  protected function findFile($basename) {
    // TODO: Only scan directories once and cache the results statically.
    foreach ($this->searchDirectories as $directory) {
      if (is_dir($directory . '/' . $this->getSubfolder())) {
        $directoryIterator = new \RecursiveDirectoryIterator($directory . '/' . $this->getSubfolder());
        $iterator = new \RecursiveIteratorIterator($directoryIterator);
        $yamlFiles = new \RegexIterator($iterator, '/^.*' . preg_quote($basename, '/') . '\.y(a)?ml$/i', \RecursiveRegexIterator::GET_MATCH);
        foreach ($yamlFiles as $file) {
          return $file[0];
        }
      }
    }
    return FALSE;
  }

  protected function listFiles() {
    $files = array();
    // TODO: Only scan directories once and cache the results statically.
    foreach ($this->searchDirectories as $directory) {
      if (is_dir($directory . '/' . $this->getSubfolder())) {
        $directoryIterator = new \RecursiveDirectoryIterator($directory . '/' . $this->getSubfolder());
        $iterator = new \RecursiveIteratorIterator($directoryIterator);
        $yamlFiles = new \RegexIterator($iterator, '/^.+\.y(a)?ml$/i', \RecursiveRegexIterator::GET_MATCH);
        foreach ($yamlFiles as $file) {
          $files[$this->getNameFromFilename($file[0])] = $file[0];
        }
      }
    }
    return $files;
  }

  protected function getNameFromFilename($filename) {
    return pathinfo($filename, PATHINFO_FILENAME);
  }





}