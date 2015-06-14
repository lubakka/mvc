<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 23:09
 */

namespace Lubakka\Controllers;

use Lubakka\Exception\MasterControllerException;
use Lubakka\ParameterBag;
use Lubakka\Service\Container;
use Lubakka\Session;
use Lubakka\VendorInterface\Controllers\IController;
use Lubakka\View\View;

class MasterController implements IController
{

    protected $container;
    protected $get;
    protected $view;

    function __construct()
    {
        $this->container = Container::getContainer();
    }

    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
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

        return $views->render($bundle, $path, $name, $params, $response);
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
            return View::layout($bundle, $path, $name, $params, $response);
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

    public function redirect()
    {
        // TODO: Implement redirect() method.
    }
}