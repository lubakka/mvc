<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 23:09
 */

namespace Vendor\Controllers;

use Vendor\View\View;

class Master_Controller {

    public function index(){
        echo "Defaults";            
    }
    
    public function render($view, $params = null, $response = 200){
        $views = new View();
        $views->render($view, $params, $response);
    }
} 