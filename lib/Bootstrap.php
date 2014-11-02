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
        $split = explode("\\", $className);
        $path = '';
        
        if (in_array('Vendor', $split)){
            $split[0] = strtolower($split[0]);
        }
        
        foreach ($split as $value) {
            $path .= $value . DIRECTORY_SEPARATOR;
        }
        
        require_once '..' . DIRECTORY_SEPARATOR . substr($path, 0, strlen($path) -1 ) . '.php';
    }
}