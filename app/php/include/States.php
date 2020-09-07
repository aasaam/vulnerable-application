<?php

class States
{
  static public $props = [];

  static public function set($name, $value)
  {
    self::$props[$name] = $value;
  }

  static public function get($name, $default)
  {
    if (isset(self::$props[$name])) {
      return self::$props[$name];
    }
    return $default;
  }
}
