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

    public function __construct(){
        echo 'Artists in the House';
    }
    
    public function indexAction(){
        echo 'Artists in the House In INDEX';
    }
    
    public function viewAction() {
        echo 'Artists in the House In VIEW';
    }
} 