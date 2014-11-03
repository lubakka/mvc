<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace src\Controllers;


use Vendor\Controllers\Master_Controller;

class Artists_Controller extends Master_Controller {
    
    public function indexAction($id){
        $this->render('@Artists:Artists/index', array('d' => $id));
    }
    
    public function viewAction($id) {
        $this->render('@Artists:Artists/view', array('d' => $id, 'requests' => 'l'));
    }
} 