<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-27
 * Time: 19:03
 */

namespace Kernel\Doctrine;

use Doctrine\ORM\EntityManager as Entity;
use Doctrine\ORM\Tools\Setup;


class EntityManager
{

    private $isDevMode;

    private $config = array();

    private $conn = array();

    private $driver = 'pdo_mysql';

    private $em;

    private function __construct()
    {
        $this->isDevMode = false;
        $this->setConn();
        $this->init();
    }

    public static function getEntityManager()
    {
        static $instance = null;
        if (null == $instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function init()
    {
        $vendorDir = dirname(dirname(dirname(dirname(__FILE__))));

        $config = Setup::createXMLMetadataConfiguration(array($vendorDir . '/conf/doctrine'), self::getIsDevMode());

        $conn = $this->getConn();
        $this->em = Entity::create($conn, $config);
    }

    /**
     * @return boolean
     */
    public function getIsDevMode()
    {
        return $this->isDevMode;
    }

    /**
     * @param boolean $isDevMode
     */
    public function setIsDevMode($isDevMode)
    {
        $this->isDevMode = $isDevMode;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return array
     */
    public function getConn()
    {
        return $this->conn;
    }

    /**
     * @param array $conn
     */
    public function setConn(array $conn = array())
    {
        $default = array(
            'driver' => $this->getDriver(),
            'user' => 'root',
            'password' => 'test',
            'dbname' => 'mvc',
        );
        $result = array_merge($default, $conn);

        $this->conn = $result;

        return $this;
    }

    /**
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param string $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }

}