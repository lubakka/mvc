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
    private $param = array();
    private $request;
    protected $router;

    public function __construct(){
        $this->router = Router::getInstance()->getRouters();
        $this->request = Request::init();
        $request = $this->request->getServer()->REQUEST_URI;
        $scriptName = $this->request->getServer()->SCRIPT_NAME;
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
        foreach ($scriptName as $key => $value) {
            if (in_array($value, $components)){
                unset($components[$key]);
                array_keys($components);
            }
        }
        $components = explode('/', $components[2], 3);
        if ( 1 < count($components) ){
            $this->controller = ucfirst($components[0]);
            $this->method = $components[1];

            if ( isset($components[2]) ){
                $this->param = explode('/', $components[2]);
            }
            $file = FILE_DIR .  '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $this->controller . '_Controller.php';
            $controller_class = 'src\Controllers\\' . $this->controller . '_Controller';
        } else {
            $file = FILE_DIR .  '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . ucfirst($this->controller) . '_Controller.php';
            $controller_class = 'Vendor\Controllers\\' . ucfirst($this->controller) . '_Controller';
        }

        require_once $file;
        $instanc = new $controller_class();
    }
} 