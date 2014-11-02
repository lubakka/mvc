<?php

namespace Vendor\View;

use Vendor\VendorInterface\IView;
/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView {
    public function render($view, $params, $response) {
        $view = explode(':', $view);
        require_once '../src/View/' . $view[0] . '/'. $view[1] .'.php';
    }

}
