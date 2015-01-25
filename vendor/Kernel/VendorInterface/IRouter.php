<?php

/**
 *
 * @author lubakka
 */

namespace Kernel\VendorInterface;

interface IRouter {

    public function getRouters();

    public function setRouters($file);

    /**
     * Return bool
     */
    public function isRouters();
}
