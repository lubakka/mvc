<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-26
 * Time: 16:37
 */

namespace Kernel\Exception;


class FrontControllerException extends \Exception
{

    protected $message;

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}