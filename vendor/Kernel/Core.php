<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:02
 */

namespace Kernel;

use Kernel\Debug\Debug;

class Core
{
    public function __construct()
    {
        @ini_set ( 'default_charset', 'UTF-8' );
        new FrontController();
        Session::getInstance();
    }
} 