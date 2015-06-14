<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Lubakka\Debug\Debug;
use Lubakka\Exception\BootstrapException;
use Lubakka\HTTP\Request;

define('ROOT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('ENVIRONMENT', 'dev');

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', dirname(__FILE__) . DS);
define('FILE_PATH', basename(ROOT_DIR));
define('CONF_PATH', ROOT_DIR . '..' . DS . 'conf' . DS);

$loader = require_once '../vendor/autoload.php';

try {
    require_once "../lib/Bootstrap.php";
    new \Lib\Bootstrap();
    if (ENVIRONMENT == 'dev') {
        Debug::enable();
    }

    $kernel = new AppKernel('dev', true);
    $kernel->setRequest(Request::createFromGolobal());
    $kernel->run($kernel);
} catch (BootstrapException $e) {
    var_dump($e);
}