<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-28
 * Time: 12:47
 */

namespace Kernel\Service;

class Container
{

    protected $services = array();
    private $path = ROOT_DIR;
    private $pathService = '../conf/service/';
    private $fileService = 'service.xml';
    private $xmlService;
    private $pathParameters = '../conf/service/';
    private $fileParameters = 'parameters.xml';
    private $xmlParameter;
    private $parameters;
    private $namespace = 'Kernel';

    private function __construct()
    {
        $xmlFileService = file_get_contents(realpath($this->path . $this->pathService . $this->fileService));
        $xmlFileParameters = file_get_contents(realpath($this->path . $this->pathParameters . $this->fileParameters));

        $this->xmlService = new \SimpleXMLElement($xmlFileService);
        $this->xmlParameter = new \SimpleXMLElement($xmlFileParameters);

        $this->setParameters($this->xmlParameter);
        $this->setServices($this->xmlService);

    }

    private function setParameters(\SimpleXMLElement $xml)
    {
        $param = array();
        if ($xml->xpath('/parameters/sql[@name="mysql"]')) {
            $param['driver'] = (string)$this->query_attribute($xml->sql, "name", "mysql")->attributes()->driver;
            $param['user'] = (string)$this->query_attribute($xml->sql, "name", "mysql")->user;
            $param['host'] = (string)$this->query_attribute($xml->sql, "name", "mysql")->host;
            $param['dbname'] = (string)$this->query_attribute($xml->sql, "name", "mysql")->dbname;
            $param['password'] = (string)$this->query_attribute($xml->sql, "name", "mysql")->password;

        } elseif ($xml->xpath('/parameters/sql[@name="mssql"]')) {
            $param['driver'] = (string)$this->query_attribute($xml->sql, "name", "mssql")->attributes()->driver;
            $param['user'] = (string)$this->query_attribute($xml->sql, "name", "mssql")->user;
            $param['host'] = (string)$this->query_attribute($xml->sql, "name", "mssql")->host;
            $param['dbname'] = (string)$this->query_attribute($xml->sql, "name", "mssql")->dbname;
            $param['password'] = (string)$this->query_attribute($xml->sql, "name", "mssql")->password;
        }

        $this->parameters = $param;
    }

    private function query_attribute($xmlNode, $attr_name, $attr_value)
    {
        foreach ($xmlNode as $node) {
            switch ($node[$attr_name]) {
                case $attr_value:
                    return $node;
            }
        }
    }

    private function setServices(\SimpleXMLElement $xml)
    {
        $service = array();
        if ($xml->xpath('/service-container/services/service[@id="service"]')) {

            $class_name = $this->namespace .
                '\\' .
                ucfirst((string)$xml->services->service->set->attributes()->id) .
                '\\' .
                ucfirst($this->camelCase((string)$xml->services->service->set->attributes()->name));

            $service [(string)$xml->services->service->set->attributes()->id] = $class_name;
        }
        $this->services = $service;
    }

    public static function camelCase($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }

    public static function getContainer()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function getServices($id)
    {
        return new $this->services[$id];
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string
     */
    public function getFileService()
    {
        return $this->fileService;
    }

    /**
     * @param string $fileService
     */
    public function setFileService($fileService)
    {
        $this->fileService = $fileService;

        return $this;
    }

    /**
     * @return string
     */
    public function getPathParameters()
    {
        return $this->pathParameters;
    }

    /**
     * @param string $pathParameters
     */
    public function setPathParameters($pathParameters)
    {
        $this->pathParameters = $pathParameters;

        return $this;
    }

    /**
     * @return string
     */
    public function getPathService()
    {
        return $this->pathService;
    }

    /**
     * @param string $pathService
     */
    public function setPathService($pathService)
    {
        $this->pathService = $pathService;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileParameters()
    {
        return $this->fileParameters;
    }

    /**
     * @param string $fileParameters
     */
    public function setFileParameters($fileParameters)
    {
        $this->fileParameters = $fileParameters;

        return $this;
    }

    /**
     * Namespace for where is call service
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Namespace for where is call service
     *
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }
}