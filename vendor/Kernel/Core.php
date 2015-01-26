<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:02
 */

namespace Kernel;

use Kernel\Exception\FrontControllerException;

class Core
{
    private $request;

    public function __construct($request = null)
    {
//        $this->setRequest($request);
    }

    public function run()
    {
        @ini_set ( 'default_charset', 'UTF-8' );
        try {
            new FrontController($this->getRequest());
        } catch (FrontControllerException $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param mixed $request
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
} 