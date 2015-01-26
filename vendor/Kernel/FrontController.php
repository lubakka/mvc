<?php

namespace Kernel;

/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:08
 */
use Kernel\Controllers\Master_Controller;
use Kernel\Exception\FrontControllerException;
use Kernel\Exception\MasterControllerException;
use Kernel\HTTP\Request;

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
     * Constructor for FrontController
     */
    public function __construct(Request $request)
    {
        Session::getInstance();
        $router = Router::getInstance();
        $this->path = $router->getRouterPath();
        $this->router = $router->getRouterConfig();
        $this->request = $request;
        $this->init();
    }

    /**
     *
     */
    private function init()
    {
        $request = $this->getRequest();
//        var_dump($request->getServer());
//        exit;
        $components = $this->getCleanComponents($request);
        $controller_class = '';
        $method = $this->method;

        if ($this->isMasterController($components)) {
            $this->method = (isset($components[1]) ? $components[1] : $this->method);
            $controller_class = 'Kernel\Controllers\\' . ucfirst($this->controller) . '_Controller';
            $method = $this->method;
        } else {
            if (!array_key_exists($components[0], $this->router)) {
                throw new FrontControllerException('Not match route');
            }
            $rout = array();
            foreach ($this->router as $key) {
                foreach ($key as $rout) {
                    $rout = $rout;
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
                    $controller_class = 'src\Controllers\\' . $this->controller . '_Controller';
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
                        $controller_class = 'src\Controllers\\' . $this->controller . '_Controller';
                        $method = $this->method . 'Action';
                        break;
                    }
                }
            }
        }

        $this->run($controller_class, $method);
    }

    private function getRequest()
    {
        $uri = $this->request->getServer()->get('REQUEST_URI');
        if (!$this->isEmptyRequest()) {
            if (0 === strpos($uri, FILE_PATH)) {
                $request = substr($uri, strlen(FILE_PATH));
            } else {
                $request = substr($uri, 1);
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

        $components = explode('/', $components[0]);
        $components = $this->clean($components);

        return $components;
    }

    /**
     * @return array
     */
    private function getScriptName()
    {
        $subs = substr($this->request->getServer()->get('SCRIPT_NAME'), 1, -10);
        $scName = explode('/', $subs);
        return $scName;
    }

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
            try {
                $instance = new $controller_class();
                if (!$instance instanceof Master_Controller) {
                    throw new MasterControllerException("Controller is not instance of 'Master_Controller'");
                }
                if (method_exists($instance, $method)) {
                    $class = call_user_func_array(array($instance, $method), $this->param);
                    if (null == $class || !is_object($class)) {
                        throw new \Exception(sprintf("Controller %s must returnet value", $instance));
                    }
                } else {
                    $class = call_user_func_array(array($instance, 'index'), array(''));
                    if (null == $class || !is_object($class) || !$class instanceof Master_Controller) {
                        throw new \Exception(sprintf("Controller %s must returnet value", $instance));
                    }
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

}
