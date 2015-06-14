<?php
/**
 * Created by PhpStorm.
 * User: lubakka
 * Date: 14.06.15
 * Time: 17:49
 */


use Blog\BlogModule;
use Lubakka\Kernel;

class AppKernel extends Kernel {

    public function registerModules(){
        $modules = [
          'Blog' => new BlogModule()
        ];

        return $modules;
    }
}