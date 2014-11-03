<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 20:08
 */

use Lib\Bootstrap;
use Vendor\Core;

@ini_set('error_reporting', E_ALL);
@ini_set('display_errors', 'On');

define('FILE_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('FILE_PATH', basename(FILE_DIR));

require_once '../lib/Bootstrap.php';

new Bootstrap();
new Core();