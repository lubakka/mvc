<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-25
 * Time: 17:50
 */

namespace Kernel\Debug;

use Kernel\FileSystem\FileSystem;

class Debug {

    private $cacheDir = 'cache/';

    protected function __construct(){
        @ini_set ( 'error_reporting', E_ALL );
        @ini_set ( 'display_errors', 'On' );
    }

    private function __clone(){}

    private function __wakeup(){}

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function clear(){
        $file = new FileSystem();
        $file->deleteDir(CONF_PATH . $this->cacheDir);
    }
}