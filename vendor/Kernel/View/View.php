<?php

namespace Kernel\View;


use Exception;
use Kernel\Exception\ViewException;
use Kernel\HTTP\ParameterBag;
use Kernel\VendorInterface\IView;

/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView
{

    protected $layoutsFile = "base.layout.html.twig";
    private $view = "../src/View/";
    private $layouts = "../layout/main/";
    private $cache = "../conf/cache";

    public function render($bundle, $path = '', $name, $params, $response)
    {
        $app = (object)ParameterBag::getStaticParameterBag($params)->all();
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
        try {
            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem(realpath($this->layouts));
            $loader->addPath(realpath($this->layouts . '..' . DS . $bundle . DS . $path . DS));

            $twig = new \Twig_Environment($loader, array(
                'cache' => $this->cache
            ));
            $layout = $twig->loadTemplate($this->layoutsFile);
            echo $twig->display('index.html.twig', array('layout' => $layout, 'view' => $params));
            return true;
        } catch (Exception $e) {
            throw new ViewException("Some problem");
        }
    }

}
