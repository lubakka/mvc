<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-26
 * Time: 18:03
 */

namespace Lubakka\HTTP;


class parameterBag
{

    private $parameters;

    public function __construct(array $parameters = array())
    {
        $this->initialize($parameters);
    }

    public function initialize(array $parameters = array())
    {
        $this->parameters = $parameters;
        return $this;
    }

    public static function getStaticParameterBag(array $parameters = array())
    {
        static $instance = null;
        if (null == $instance) {
            $instance = new static($parameters);
        }
        return $instance;
    }

    public function all()
    {
        return $this->parameters;
    }

    public function keys()
    {
        return array_keys($this->parameters);
    }

    public function add(array $parameters = array())
    {
        $this->parameters = array_replace($this->parameters, $parameters);

        return $this;
    }

    public function set($key, $value)
    {
        $this->parameters[$key] = $value;

        return $this;
    }

    public function hasKey($key)
    {
        return array_key_exists($key, $this->parameters);
    }

    public function remove($key)
    {
        unset($this->parameters[$key]);
    }

    public function get($key)
    {
        return $this->parameters[$key];
    }

    public function count()
    {
        return count($this->parameters);
    }

}