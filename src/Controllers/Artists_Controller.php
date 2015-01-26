<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-10-1
 * Time: 0:17
 */

namespace src\Controllers;

use Kernel\Controllers\Master_Controller;

class Artists_Controller extends Master_Controller {
    
    public function indexAction($id){
        return $this->layout('@Artists:Artists/index', array('d' => 'test', 'id' => $id));
    }
    
    public function viewAction($id) {
        return $this->render('@Artists:Artists/view', array('d' => $id, 'requests' => 'да става', 'ses' => $this->getSession()));
    }
} 