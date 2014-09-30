<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:02
 */

namespace Vendor;

use Vendor\Controllers;

class Core
{
    public function __construct(){
        new FrontControoler();
    }
} 