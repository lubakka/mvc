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
    public function __construct($prepend = false)
    {
        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array($this, 'loader'), true, $prepend);
        } else {
            spl_autoload_register(array($this, 'loader'));
        }
    }

    private function loader($className)
    {
        $file = "";
        $split = explode("\\", $className);
        $path = '';

        if($className === "AppKernel"){
            require_once __DIR__ . "/../conf/" . "AppKernel.php";
            return true;
        }

        foreach ($split as $value) {
            $path .= $value . DS;
        }

        if ($split[0] === 'src'){
            $file = __DIR__ . DS .'..' . DS . substr($path, 0, strlen($path) - 1) . '.php';
        }

        if ($split[0] === 'Modules' || $split[0] === 'Entities'){
            $file = __DIR__ . DS .'..' . DS . 'src' . DS . substr($path, 0, strlen($path) - 1) . '.php';
        }

        if (is_file($file) && is_readable($file)) {
            $this->includeFile($file);
            return true;
        }

        return false;
    }

    private function includeFile($file)
    {
        require $file;
    }
}