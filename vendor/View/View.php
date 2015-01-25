<?php

namespace Vendor\View;

use Vendor\VendorInterface\IView;
use Vendor\ParameterBag;
use Vendor\Helpers;
use Exception;
use Vendor\Request;
use Vendor\Session;

/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView
{

    private $view = "../src/View/";
    private $layouts = "../layout/";
    protected $layoutsFile = "base.layout.php";
    private $cache = "../conf/cache/";

    public function render($bundle, $path = '', $name, $params, $response)
    {
        $this->checkParams($params);
        $viewBag = Helpers::toObject(ParameterBag::getAll());

        $src = str_replace('/', DS, $this->view);
        if (!is_dir($src)) {
            throw new Exception('Dir not exist');
        }

        $path = realpath($src . $bundle . DS . $path . DS . $name . '.php');

        if (!is_file($path)) {
            throw new Exception('File not exist');
        }

        require_once $path;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public function layout()
    {
        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem(realpath($this->layouts));
        $twig = new \Twig_Environment($loader, array(
            'cache' => $this->cache
        ));

        echo $twig->render($this->layoutsFile, array('name' => 'Fabien'));
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout) {

        return $this;
    }

    private function checkParams(array $params) {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'request':
                case 'cookie':
                case 'session':
                case 'allRequest':
                    throw new Exception('You use save word, please rename', 500);
                default:
                    break;
            }
            ParameterBag::set($key, $value);
        }

        ParameterBag::set('request', Request::init()->getHeaders());
        ParameterBag::set('cookie', Request::init()->getCookies());
        ParameterBag::set('allRequest', Request::init()->getRequestAll());
        ParameterBag::set('session', Session::getInstance()->getSession());
    }

}
