<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:10
 */

namespace Vendor;

class Request
{

    private static $instance = null;

    public $user_agent;

    /**
     * Request body parameters ($_POST)
     */
    public $request;

    /**
     * Query string parameters ($_GET)
     */
    public $query;

    /**
     * Server and execution environment parameters ($_SERVER)
     */
    public $server;

    /**
     * Uploaded files ($_FILES)
     */
    public $files;

    /**
     * Cookies ($_COOKIE)
     */
    public $cookies;

    /**
     * Headers (taken from the $_SERVER)
     */
    public $headers;
    
    public $scriptName;

    private function __construct()
    {
        $this->setRequest($_SERVER['REQUEST_URI']);
        $this->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $this->setScriptName($_SERVER['SCRIPT_NAME']);
        $this->setServer(Helpers::toObject($_SERVER));
        $this->setCookies(Helpers::toObject($_COOKIE));
        $this->setHeaders(Helpers::toObject(apache_request_headers()));
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

    /**
     * @param mixed $user_agent
     */
    public function setUserAgent($user_agent)
    {
        $this->user_agent = $user_agent;
        return $this;
    }

    /**
     * @return $_SERVER['HTTP_USER_AGENT']
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }

    public static function init()
    {
        if (self::$instance == null) {
            $instance = new Request();
        }
        return $instance;
    }

    /**
     * @param mixed $cookies
     */
    public function setCookies($cookies)
    {
        $this->cookies = $cookies;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCookies()
    {
        return $this->cookies;
    }

    /**
     * @param mixed $files
     */
    public function setFiles($files)
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        foreach ($_GET as $key => $value) {
            echo 'Key = ' . $key . '<br />';
            echo 'Value= ' . $value;
        }
        return $this->query;
    }

    /**
     * @param mixed $server
     */
    public function setServer($server)
    {
        $this->server = $server;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServer()
    {
        return $this->server;
    }
    
    function getScriptName() {
        return $this->scriptName;
    }

    function setScriptName($scriptName) {
        $this->scriptName = $scriptName;
        return $this;
    }


} 