<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Lib\Bootstrap;
use Vendor\Core;

@ini_set ( 'error_reporting', E_ALL );
@ini_set ( 'display_errors', 'On' );
@ini_set ( 'default_charset', 'UTF-8' );

define( 'DS', DIRECTORY_SEPARATOR );
define( 'FILE_DIR', dirname ( __FILE__ ) . DS );
define( 'FILE_PATH', basename ( FILE_DIR ) );
define( 'CONF_PATH', FILE_DIR . '..' . DS . 'conf' . DS );
define( 'ROOT_URL', 'http://' . $_SERVER[ 'HTTP_HOST' ] . '/' );

require_once '../lib/Bootstrap.php';
require_once '../vendor/autoload.php';

new Bootstrap();
new Core();