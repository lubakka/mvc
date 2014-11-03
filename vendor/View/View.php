<?php

namespace Vendor\View;

use Vendor\VendorInterface\IView;
use Vendor\ParameterBag;
use Vendor\Helpers;
use Exception;

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
                case 'server':
                case 'cookie':
                case 'requestAll':
                    throw new Exception('You use save word, please rename', 500);
                default:
                    break;
            }
            ParameterBag::set($key, $value);
        }
        ParameterBag::set('request', \Vendor\Request::init()->getHeaders());
        ParameterBag::set('server', \Vendor\Request::init()->getServer());
        ParameterBag::set('cookie', \Vendor\Request::init()->getCookies());
        ParameterBag::set('requestAll', \Vendor\Request::init()->getRequestAll());

        $viewBag = Helpers::toObject(ParameterBag::getAll());

        require_once '..' . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View' . DIRECTORY_SEPARATOR . $bundle . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $name . '.php';
    }

}
