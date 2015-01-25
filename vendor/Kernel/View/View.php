<?php

namespace Kernel\View;


use Kernel\VendorInterface\IView;
use Kernel\ParameterBag;
use Kernel\Helpers;
use Exception;
use Kernel\Request;
use Kernel\Session;

/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView
{

    private $view = "../src/View/";
    private $layouts = "../layout/main/";
    protected $layoutsFile = "base.layout.html.twig";
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

    public function layout($bundle, $path = '', $name, $params, $response)
    {
        $this->checkParams($params);

        $viewBag = Helpers::toObject(ParameterBag::getAll());

        \Twig_Autoloader::register();
        $loader = new \Twig_Loader_Filesystem(realpath($this->layouts));
        $loader->addPath(realpath($this->layouts . '..' . DS . $bundle . DS. $path . DS ));
        $twig = new \Twig_Environment($loader, array(
            'cache' => $this->cache
        ));
        $layout = $twig->loadTemplate($this->layoutsFile);
        echo $twig->display('index.html.twig', array('layout' => $layout, 'app' => $viewBag, 'params' => $params));
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
