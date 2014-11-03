<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 23:09
 */

namespace Vendor\Controllers;

use Vendor\ParameterBag;
use Vendor\View\View;

class Master_Controller {

    public function index(){
        echo "Defaults";            
    }
    
    public function render($view, array $params = array(), $response = 200){
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
} 