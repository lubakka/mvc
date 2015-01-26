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

    public static $cacheDir = 'cache/';

    protected function __construct(){
        @ini_set ( 'error_reporting', E_ALL );
        @ini_set ( 'display_errors', 'On' );
        FileSystem::mkdir(CONF_PATH . self::$cacheDir);
    }

    public static function getInstance() {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function clear(){
        $file = new FileSystem();
        $file->deleteDir(CONF_PATH . self::$cacheDir);
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }
}