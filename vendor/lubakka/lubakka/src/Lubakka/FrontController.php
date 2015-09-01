<?php

namespace Lubakka;

/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:08
 */
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Lubakka\Controllers\MasterController;
use Lubakka\Exception\FrontControllerException;
use Lubakka\Exception\MasterControllerException;
use Lubakka\HTTP\Request;
use Lubakka\VendorInterface\Controllers\IController;
use Lubakka\View\View;

/**
 * Class FrontController
 *
 * @package Vendor
 */
class FrontController extends FrontControllerException
{

    /**
     * @var
     */
    protected $router;
    /**
     * @var array
     */
    protected $path = array();
    /**
     * Defaults value
     *
     * @var string
     */
    private $controller = 'Master';
    /**
     * Defaults value
     *
     * @var string
     */
    private $method = 'index';
    /**
     * @var array
     */
    private $param = array('');
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * Constructor for FrontController
     *
     * @param Request $request
     * @param int     $kernel
     *
     * @throws FrontControllerException
     */
    public function __construct(Request $request, $kernel)
    {
        Session::getInstance();
        $router = Router::getInstance();
        $this->path = $router->getRouterPath();
        $this->router = $router->getRouterConfig();
        $this->request = $request;
        $this->kernel = $kernel;
        $this->init();
    }

    /**
     *
     */
    private function init()
    {
        $request = $this->getRequest();
        $components = $this->getCleanComponents($request);
        $controller_class = '';
        $method = $this->method;

        if ($this->isMasterController($components)) {
            $this->method = (isset($components[1]) ? $components[1] : $this->method);
            $controller_class = __NAMESPACE__ . '\Controllers\\' . ucfirst($this->controller) . 'Controller';
            $method = $this->method;
        } else {
            if (!array_key_exists($components[0], $this->router)) {
                throw new FrontControllerException('Not match route');
            }
            $rout = array();
            foreach ($this->router as $key) {
                foreach ($key as $router) {
                    $rout = $router;
                }
            }

            $realpath = '/' . $components[0] . (isset($components[1]) ? '/' . (is_numeric($components[1]) ? 'index' : $components[1]) : '');
            $clear = false;
            if (false !== strpos($realpath, '?')) {
                $realpath = explode('/?', $realpath)[0];
                $clear = true;
            }
            foreach ($this->path as $name => $path) {
                if (($path === $realpath)) {
                    if (count($components) == 1) {
                        $components = explode('/', $components[0]);
                    }
                    if ($clear) {
                        unset($components[1]);
                    }
                    $this->controller = trim(ucfirst($components[0]));
                    $this->method = (isset($components[1]) ? trim($components[1]) : $this->method);

                    if (isset($components[2])) {
                        $this->param = explode('/', $components[2]);
                    }
                    $controller_class = 'src\Controllers\\' . $this->controller . 'Controller';
                    $method = $this->method . 'Action';
                    break;
                } else {
                    if (preg_match('/' . $rout['parameters'] . '$/i', $path)) {
                        if (count($components) == 1) {
                            $components = explode('/', $components[0]);
                        }
                        $this->controller = trim(ucfirst($components[0]));
                        $this->method = (isset($components[1]) ? (is_numeric(trim($components[1])) ? 'index' : $components[1]) : $this->method);
                        if (isset($components[2])) {
                            $this->param = explode('/', $components[2]);
                        }
                        if (isset($components[1])) {
                            if (is_numeric($components[1])) {
                                $this->param = explode('/', trim($components[1]));
                            }
                        }
                        $controller_class = 'src\Controllers\\' . $this->controller . 'Controller';
                        $method = $this->method . 'Action';
                        break;
                    }
                }
            }
        }

        return $this->run($controller_class, $method);
    }

    /**
     * @return string
     * @throws \Exception
     */
    private function getRequest()
    {
        $uri = $this->request->getServer()->get('REQUEST_URI');
        if (!$this->isEmptyRequest()) {
            if (0 === strpos($uri, FILE_PATH)) {
                $request = substr($uri, strlen(FILE_PATH));
            } else {
                $request = $uri;
            }
        } else {
            throw new \Exception("Request is empty");
        }
        return $request;
    }

    /**
     * @return bool
     */
    private function isEmptyRequest()
    {
        if (empty($this->request)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $request
     *
     * @return array
     */
    private function getCleanComponents($request)
    {
        $components = explode('/', $request, 3);
        if (count($this->getScriptName()) > 0) {
            foreach ($this->getScriptName() as $key => $value) {
                if (in_array($value, $components)) {
                    unset($components[$key]);
                }

            }
        }

        $components = array_values($components);

        if (isset($components[1])) {
            if (preg_match('/\//', $components[1])) {
                $second = explode('/', $components[1]);
                unset($components[1]);
                foreach ($second as $values) {
                    $components[] = $values;
                }
            }
        }
        $components = array_values($components);

        $components = $this->clean($components);

        return $components;
    }

    /**
     * @return array
     */
    private function getScriptName()
    {
        $subs = substr($this->request->getServer()->get('SCRIPT_NAME'), 1, -9);
        $scName = explode('/', $subs);
        return $scName;
    }

    /**
     * @param $elem
     *
     * @return array|string
     */
    private function clean($elem)
    {
        if (!is_array($elem)) {
            $elem = htmlentities($elem, ENT_QUOTES, "UTF-8");
        } else {
            foreach ($elem as $key => $value) {
                $elem[$key] = $this->clean($value);
            }
        }

        return $elem;
    }

    /**
     * @param $components
     *
     * @return bool
     */
    private function isMasterController($components)
    {
        if ($components[0] === '' || false !== strpos($components[0], '?')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Include Class and Method if exist
     *
     * @param $controller_class
     * @param $method
     *
     * @throws \Exception
     */
    private function run($controller_class, $method)
    {
        if (empty($controller_class)) {
            throw new \Exception("This route is not in router.php config");
        } else {
            foreach ($this->router as $key => $path) {
                if (strtolower($this->controller) === $key) {
                    $router = $this->router[$key];
                    foreach ($router as $routKey => $routeValue) {
                        if (true == strpos($routKey, $this->method)) {
                            if (isset($routeValue['controller'])) {
                                $controllerString = $routeValue['controller'];
                                if ('@' !== $controllerString[0]) {
                                    throw new \Exception(sprintf('A resource name must start with @ ("%s" given).', $view));
                                }

                                $module = '';
                                $className = '';
                                if (false !== strpos($controllerString, "\\")) {
                                    $controllerString = mb_substr($controllerString, 1);
                                    list($module, $className) = explode("\\", $controllerString, 2);
                                }

                                if (false !== strpos($controllerString, ':')) {
                                    list($module, $className) = explode(':', $controllerString);
                                }

                                $namespace = $this->getModules()[mb_substr($module, 0, strpos($module, 'Module'))]->getNameSpace();
                                $allClass = $namespace . '\\Controllers\\' . $className . 'Controller';
                                $methodName = $method;

                                $instance = new $allClass();
                                call_user_func_array(array($instance, $methodName), $this->param);
                            } else {
                                throw new \Exception(sprintf('Not match router %s', $routKey));
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     *
     */
    private function getModules()
    {
        if (isset($this->kernel)) {
            return $this->kernel->registerModules();
        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        if (isset($this->controller)) {
            return $this->controller;
        }
    }

}
