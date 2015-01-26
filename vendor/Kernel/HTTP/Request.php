<?php

/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:10
 */

namespace Kernel\HTTP;

class Request
{

    /**
     * Request body parameters ($_POST)
     */
    private $request;

    /**
     * Query string parameters ($_GET)
     */
    private $query;

    /**
     * Uploaded files ($_FILES)
     */
    private $files;

    /**
     * Cookies ($_COOKIE)
     */
    private $cookies;

    private $attributes;
    private $server;
    private $content;
    private $languages;
    private $charsets;
    private $encodings;
    private $pathInfo;
    private $requestUri;
    private $baseUrl;
    private $basePath;
    private $method;
    private $format;


    private function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->initialize($query, $request, $attributes, $cookies, $files, $server, $content);
    }

    public function initialize(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->request = new ParameterBag($request);
        $this->query = new ParameterBag($query);
        $this->attributes = new ParameterBag($attributes);
        $this->cookies = new ParameterBag($cookies);
        $this->server = new ParameterBag($server);
        $this->files = new ParameterBag($files);

        $this->content = $content;
        $this->languages = null;
        $this->charsets = null;
        $this->encodings = null;
        $this->pathInfo = null;
        $this->requestUri = null;
        $this->baseUrl = null;
        $this->basePath = null;
        $this->method = null;
        $this->format = null;
    }

    public static function createFromGolobal()
    {
        static $instance = null;
        if (null == $instance) {
            $request = new static($_GET, $_POST, array(), $_COOKIE, $_FILES, $_SERVER, $content = null);
        }
        return $request;
    }

    /**
     * @return $_SERVER['REQUEST_URI']
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

    public function getSession()
    {
        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return mixed
     */
    public function getCharsets()
    {
        return $this->charsets;
    }

    /**
     * @return mixed
     */
    public function getEncodings()
    {
        return $this->encodings;
    }

    /**
     * @return mixed
     */
    public function getPathInfo()
    {
        return $this->pathInfo;
    }

    /**
     * @return mixed
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @return mixed
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->format;
    }
}
