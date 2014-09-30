<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Lib\Bootstrap;
use Vendor\Core;

define('FILE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('FILE_PATH', basename(FILE_DIR));
define('DIR_SRC_CONTROLLERS', FILE_DIR . '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controllers'. DIRECTORY_SEPARATOR);

require_once '../lib/Bootstrap.php';

new Bootstrap();
$core = new Core();
