<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:02
 */

namespace Vendor;

class Core
{    
    public function __construct(){
//		header('Content-Type: text/html; charset="utf-8"');
//		header('Content-Type: text/html; charset=utf-8');
        new FrontController();
        Session::getInstance();
    }
} 