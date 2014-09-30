<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:16
 */
namespace Lib;

class Bootstrap {
    public function __construct() {
        spl_autoload_register(array($this, 'loader'));
    }
    private function loader($className) {
        include '..' . DIRECTORY_SEPARATOR . $className . '.php';
    }
}