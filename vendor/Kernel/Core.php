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
        $front = new FrontController();
        Session::getInstance();
        if (ENVIRONMENT == 'dev') {
            $debug = Debug::getInstance();
            $master = $front->getController();
            if ($master != 'Master') {
                $debug->clear();
            }
        }
    }
} 