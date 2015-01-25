<?php

namespace Kernel;
use Kernel\VendorInterface\IRouter;

/**
 * Description of Router
 *
 * @author lubakka
 */
class Router implements IRouter
{

    private $routers = array();
    private $router = array();
    private $path;

    protected function __construct()
    {
        $this->routers = $this->fetchArray('router');
    }

    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    public function getRouters()
    {
        foreach ($this->routers as $routes) {
            foreach ($routes as $router) {
                foreach ($router as $key => $value) {
                    $this->router[$key] = $value;
                }
            }
        }

        return Helpers::toObject($this->router);
    }

    public function getRouterPath()
    {
        foreach ($this->getRouters() as $name) {
            foreach ($name as $key => $value) {
                    $this->path[$key] = $value['route'];

            }
        }

        return Helpers::toObject($this->path);
    }

    private function fetchArray($file)
    {
        if (!empty($file)) {
            return include FILE_DIR . DS . '..' . DS . 'conf' . DS . $file . '.php';
        }

        return false;
    }

    /**
     * Set Router from other file
     *
     * @param string $file
     */
    public function setRouters($file)
    {
        $this->router = $this->fetchArray($file);

        return $this;
    }

    public function isRouters()
    {

    }

    public function getRoute()
    {
        var_dump($this->getRoutes());

        return;
    }

}
