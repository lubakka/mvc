<?php
/**
 * Created by PhpStorm.
 * User: lubakka
 * Date: 14.06.15
 * Time: 22:07
 */

namespace Lubakka\VendorInterface\Controllers;


interface IController {
    public function index();
    public function render($view, array $params, $response = 200);
    public function layout($view, array $params, $response = 200);
    public function getSession();
    public function getUser();
    public function get($id);
    public function getContainer($id);
    public function redirect();
}