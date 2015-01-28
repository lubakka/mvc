<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 23:09
 */

namespace Kernel\Controllers;

use Kernel\Exception\MasterControllerException;
use Kernel\ParameterBag;
use Kernel\Service\Container;
use Kernel\Session;
use Kernel\View\View;

class Master_Controller
{

    protected $container;
    protected $get;

    function __construct()
    {
        $this->container = Container::getContainer();
    }


    public function index()
    {
        echo "Default";
        return $this;
    }

    public function render($view, array $params = array(), $response = 200)
    {
        if ('@' !== $view[0]) {
            throw new \Exception(sprintf('A resource name must start with @ ("%s" given).', $view));
        }

        $views = new View();

        $bundle = substr($view, 1);

        $path = '';
        if (false !== strpos($bundle, '/')) {
            list($bundle, $name) = explode('/', $bundle, 2);
        }
        if (false !== strpos($bundle, ':')) {
            list($bundle, $path) = explode(':', $bundle);
        }

        $views->render($bundle, $path, $name, $params, $response);
    }

    public function layout($view, array $params = array(), $response = 200)
    {
        if ('@' !== $view[0]) {
            throw new \Exception(sprintf('A resource name must start with @ ("%s" given).', $view));
        }

        $views = new View();

        $bundle = substr($view, 1);

        $path = '';
        if (false !== strpos($bundle, '/')) {
            list($bundle, $name) = explode('/', $bundle, 2);
        }
        if (false !== strpos($bundle, ':')) {
            list($bundle, $path) = explode(':', $bundle);
        }

        try {
            $views->layout($bundle, $path, $name, $params, $response);
            return $this;
        } catch (MasterControllerException $e) {
            throw new MasterControllerException("Problem");
        }
    }

    public function getSession()
    {
        return Session::getInstance()->getSession();
    }

    public function getUser()
    {
        return null === '' ? '' : 'Anonymous';
    }

    public function get($id)
    {
        return $this->getContainer($id);
    }

    public function getContainer($id)
    {
        return $this->container->getServices($id);
    }

    function __toString()
    {
        $class = get_called_class();
        return $class;
    }

} 