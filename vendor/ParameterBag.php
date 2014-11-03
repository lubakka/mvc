<?php

namespace Vendor;

/**
 * Description of ParameterBag
 *
 * @author lubakka
 */
class ParameterBag {
    private static $registry = array();
 
   private function __construct() {}
 
   static public function set($key, $value) {
      self::$registry[$key] = $value;
   }
 
   static public function get($key) {
      return self::$registry[$key];
   }
   
   static public function getAll() {
      return self::$registry;
   }
   
   public function __set($key, $value) {
       self::$registry[$key] = $value;
   }
   
   public function __get($key) {
       return self::$registry[$key];
   }
}
