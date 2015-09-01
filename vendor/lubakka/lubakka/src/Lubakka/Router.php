<?php

namespace Lubakka;

use Lubakka\VendorInterface\IRouter;

/**
 * Description of Router
 *
 * @author lubakka
 */
class Router implements IRouter
{

    /**
     * @var array|bool|mixed
     */
    private $routers = array();
    /**
     * @var array
     */
    private $router = array();
    /**
     * @var
     */
    private $path;

    /**
     *
     */
    protected function __construct()
    {
        $this->routers = $this->fetchFileArray('router');
    }

    /**
     * @param $file
     *
     * @return bool|mixed
     */
    private function fetchFileArray($file)
    {
        if (!empty($file)) {
            return include ROOT_DIR . DS . '..' . DS . 'conf' . DS . $file . '.php';
        }

        return false;
    }

    /**
     * @return static
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }

        return $instance;
    }

    /**
     * @return object
     */
    public function getRouterPath()
    {
        foreach ($this->getRouters() as $name) {
            foreach ($name as $key => $value) {
                $this->path[$key] = $value['route'];
            }
        }

        return Helpers::toObject($this->path);
    }

    /**
     * @return object
     */
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

    /**
     * Set Router from other file
     *
     * @param string $file
     *
     * @return $this
     */
    public function setRouters($file)
    {
        $this->router = $this->fetchFileArray($file);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRouterConfig()
    {
        $helper = Helpers::toObject($this->routers);

        return $helper->routers['router'];
    }

    /**
     *
     */
    public function isRouters()
    {

    }

    /**
     * @return $this
     */
    public function getRoute()
    {
        return $this;
    }
}
