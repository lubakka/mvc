<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 21:02
 */

namespace Lubakka;

use Lubakka\Exception\FrontControllerException;

/**
 * Class Kernel
 * @package Lubakka
 */
class Kernel
{
    /**
     * @var
     */
    private $request;

    /**
     * @var BundleInterface[]
     */
    protected $modules = array();

    /**
     * @var
     */
    protected $bundleMap;
    /**
     * @var
     */
    protected $container;
    /**
     * @var mixed
     */
    protected $rootDir;
    /**
     * @var string
     */
    protected $environment;
    /**
     * @var bool
     */
    protected $debug;
    /**
     * @var bool
     */
    protected $booted = false;
    /**
     * @var mixed
     */
    protected $name;
    /**
     * @var mixed
     */
    protected $startTime;

    /**
     *
     */
    const VERSION = '1.0.1';
    /**
     *
     */
    const VERSION_ID = '10001';
    /**
     *
     */
    const MAJOR_VERSION = '1';
    /**
     *
     */
    const MINOR_VERSION = '0';
    /**
     *
     */
    const RELEASE_VERSION = '1';
    /**
     *
     */
    const EXTRA_VERSION = '';

    private $inst = null;

    /**
     * Constructor.
     *
     * @param string $environment The environment
     * @param bool   $debug       Whether to enable debugging or not
     *
     * @api
     */
    public function __construct($environment, $debug)
    {
        $this->environment = $environment;
        $this->debug = (bool)$debug;
        $this->rootDir = $this->getRootDir();
        $this->name = $this->getName();

        if ($this->debug) {
            $this->startTime = microtime(true);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getName()
    {
        if (null === $this->name) {
            $this->name = preg_replace('/[^a-zA-Z0-9_]+/', '', basename($this->rootDir));
        }

        return $this->name;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * {@inheritdoc}
     *
     * @api
     */
    public function getRootDir()
    {
        if (null === $this->rootDir) {
            $r = new \ReflectionObject($this);
            $this->rootDir = str_replace('\\', '/', dirname($r->getFileName()));
        }

        return $this->rootDir;
    }

    /**
     * @param $kernel
     */
    public function run($kernel)
    {
        @ini_set('default_charset', 'UTF-8');
        try {
            new FrontController($this->getRequest(), $kernel);
            //Container::getContainer();
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
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     *
     */
    public function registerModules()
    {
        return $this->modules;
    }
} 