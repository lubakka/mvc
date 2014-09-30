<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:08
 */

namespace Vendor;


class FrontControoler {

    private $controller = 'master';
    private $method = 'index';
    private $param = array();

    public function __construct(){
        $request = Request::init();
        $request = $request->getServer()->REQUEST_URI;
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

        if ( 1 < count($components) ){
            $this->controller = ucfirst($components[0]);
            $this->method = $components[1];

            if ( isset($components[2]) ){
                $this->param = explode('/', $components[2]);
            }
            $file = FILE_DIR .  '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $this->controller . '.php';
            $controller_class = '\src\Controllers\\' . $this->controller . '_Controller';
        } else {
            $file = FILE_DIR .  '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'Controllers' . DIRECTORY_SEPARATOR . $this->controller . '_Controller.php';
            $controller_class = '\Vendor\Controllers\\' . $this->controller . '_Controller';
        }

        require_once $file;
        $instanc = new $controller_class();
    }
} 