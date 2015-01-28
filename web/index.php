<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Kernel\Core;
use Kernel\Debug\Debug;
use Kernel\Exception\BootstrapException;
use Kernel\HTTP\Request;
use Lib\Bootstrap;

define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('ENVIRONMENT', 'dev');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__FILE__) . DS);
define('FILE_PATH', basename(ROOT_DIR));
define('CONF_PATH', ROOT_DIR . '..' . DS . 'conf' . DS);

require_once '../lib/Bootstrap.php';
require_once '../vendor/autoload.php';

try {
    new Bootstrap();
    if (ENVIRONMENT == 'dev') {
        $debug = Debug::getInstance();
        $debug->clear();
    }
    $kernel = new Core();
    $kernel->setRequest(Request::createFromGolobal());
    $kernel->run();
} catch (BootstrapException $e) {
    var_dump($e);
}