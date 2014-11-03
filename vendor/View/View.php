<?php

namespace Vendor\View;

use Vendor\VendorInterface\IView;
use Vendor\ParameterBag;
use Vendor\Helpers;
use Exception;
use Vendor\Request;
use Vendor\Session;

/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView {

    public function render($bundle, $path = '', $name, $params, $response) {

        foreach ($params as $key => $value) {
            switch ($key) {
                case 'request':
                case 'cookie':
                case 'session':
                case 'allRequest':
                    throw new Exception('You use save word, please rename', 500);
                default:
                    break;
            }
            ParameterBag::set($key, $value);
        }

        ParameterBag::set('request', Request::init()->getHeaders());
        ParameterBag::set('cookie', Request::init()->getCookies());
        ParameterBag::set('allRequest', Request::init()->getRequestAll());
        ParameterBag::set('session', Session::getInstance()->getSession());

        $viewBag = Helpers::toObject(ParameterBag::getAll());

        require_once '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $bundle . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name . '.php';
    }

}
