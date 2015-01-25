<?php
namespace Kernel\VendorInterface;
/**
 *
 * @author lubakka
 */
interface IView {
    public function render($bundle, $path, $name, $params, $response);
    
}
