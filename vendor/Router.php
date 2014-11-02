<?php

namespace Vendor;

use Vendor\VendorInterface\IRouter;

/**
 * Description of Router
 *
 * @author lubakka
 */
class Router implements IRouter {

    private $router = array();
    private static $instance;

    protected function __construct() {
        
        $this->router = $this->fetchArray('router');
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function getRouters() {
        return $this->router;
    }

    private function fetchArray($file) {
        if (!empty($file)) {
            return include FILE_DIR . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . $file . '.php';
        }
        return false;
    }

    /**
     * Set Router from other file
     * @param string $file
     */
    public function setRouters($file) {
        $this->router = $this->fetchArray($file);
    }

    public function isRouters() {
        
    }

    public function getRoute() {
        var_dump($this->getRoutes());

        return;
    }

}
