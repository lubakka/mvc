<?php

namespace Vendor\VendorInterface;
/**
 *
 * @author lubakka
 */
interface IView {
    public function render($view, $params, $response);
    
}
