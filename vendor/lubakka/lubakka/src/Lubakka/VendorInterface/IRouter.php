<?php

/**
 *
 * @author lubakka
 */

namespace Lubakka\VendorInterface;

interface IRouter {

    public function getRouters();

    public function setRouters($file);

    /**
     * Return bool
     */
    public function isRouters();
}
