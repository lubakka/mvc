<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:16
 */
namespace Lib;

class Bootstrap
{
    public function __construct()
    {
        spl_autoload_register(array($this, 'loader'));
    }

    private function loader($className)
    {
        $split = explode("\\", $className);
        $path = '';

        if (in_array('Kernel', $split)) {
            $split[0] = ucfirst($split[0]);
        }

        foreach ($split as $value) {
            $path .= $value . DS;
        }

        if ($split[0] === 'src'){
            $file = '..' . DS . substr($path, 0, strlen($path) - 1) . '.php';
        }

        if ($split[0] === 'Kernel'){
            $file = '../vendor' . DS . substr($path, 0, strlen($path) - 1) . '.php';
        }

        if (is_file($file)) {
            require_once $file;
        } else {
            throw new \Exception("File not exist " . $file);
        }
    }
}