<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Lib\Bootstrap;
use \Kernel\Core;

define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('ENVIRONMENT', 'dev');

define('DS', DIRECTORY_SEPARATOR);
define('FILE_DIR', dirname(__FILE__) . DS);
define('FILE_PATH', basename(FILE_DIR));
define('CONF_PATH', FILE_DIR . '..' . DS . 'conf' . DS);


require_once '../lib/Bootstrap.php';
require_once '../vendor/autoload.php';

new Bootstrap();
new Core();