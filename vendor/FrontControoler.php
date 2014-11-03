<?php

/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:08
 */

namespace Vendor;

use Vendor\Core;

class FrontControoler extends Core {

    private $controller = 'master';
    private $method = 'index';
    private $param = array('');
    private $request;
    protected $router;

    public function __construct() {
        $this->router = Router::getInstance()->getRouters();
        $this->request = Request::init();
        $request = $this->request->getRequest();
        $scriptName = $this->request->getScriptName();
        if (!empty($request)) {
            if (0 === strpos($request, FILE_PATH)) {
                $request = substr($request, strlen(FILE_PATH));
            } else {
                $request = substr($request, 1);
            }
        } else {
            throw new \Exception("Request is empty");
        }
        $components = explode('/', $request, 3);
        $scriptName = explode('/', substr($scriptName, 1, -10));
        
        if (count($scriptName) > 0) {
            foreach ($scriptName as $key => $value) {
                if (in_array($value, $components)) {
                    unset($components[$key]);
                }
            }
        }
        
        $components = array_values($components);
        
        if (count($components) == 1) {
            $components = explode('/', $components[0]);
        }
        
        if (1 < count($components)) {
            $this->controller = ucfirst($components[0]);
            $this->method = $components[1];

            if (isset($components[2])) {
                $this->param = explode('/', $components[2]);
            }         
            $controller_class = 'src\Controllers\\' . $this->controller . '_Controller';
            $method = $this->method . 'Action';
        } else {
            $controller_class = 'Vendor\Controllers\\' . ucfirst($this->controller) . '_Controller';
            $method = $this->method;
        }

        $instance = new $controller_class();
        if (method_exists($instance, $method)){
            call_user_func_array(array($instance, $method), $this->param);
        }
    }

}
