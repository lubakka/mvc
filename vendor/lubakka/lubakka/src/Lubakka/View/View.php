<?php

namespace Lubakka\View;


use Exception;
use Lubakka\Exception\ViewException;
use Lubakka\HTTP\ParameterBag;
use Lubakka\VendorInterface\IView;

/**
 * Description of View
 *
 * @author lubakka
 */
class View implements IView
{

    protected static $layoutsFile = "base.layout.html.twig";
    private static $view = "../src/View/";
    private static $layouts = "../layout/main/";
    private static $cache = "../conf/cache";

    public static function render($bundle, $path = '', $name, $params, $response)
    {
        $app = null;
        $app = (object)ParameterBag::getStaticParameterBag($params)->all();
        $src = str_replace('/', DS, self::$view);
        if (!is_dir($src)) {
            throw new Exception('Dir not exist');
        }

        $path = realpath($src . $bundle . DS . $path . DS . $name . '.php');

        if (!is_file($path)) {
            throw new Exception('File not exist');
        }

        require $path;
    }

    /**
     * @return string
     */
    public function getLayout()
    {
        return $this->layout;
    }

    public static function layout($bundle, $path = '', $name, $params, $response)
    {
        try {
            \Twig_Autoloader::register();
            $loader = new \Twig_Loader_Filesystem(realpath(self::$layouts));
            $loader->addPath(realpath(self::$layouts . '..' . DS . $bundle . DS . $path . DS));

            $twig = new \Twig_Environment($loader, array(
                'cache' => self::$cache
            ));
            $layout = $twig->loadTemplate(self::$layoutsFile);
            echo $twig->display('index.html.twig', array('layout' => $layout, 'view' => $params));
        } catch (Exception $e) {
            throw new ViewException("Some problem whit View");
        }
    }

}
