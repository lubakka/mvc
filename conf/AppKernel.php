<?php
/**
 * Created by PhpStorm.
 * User: lubakka
 * Date: 14.06.15
 * Time: 17:49
 */


use Modules\Blog\BlogModule;
use Lubakka\Kernel;

/**
 * Class AppKernel
 */
class AppKernel extends Kernel
{

    /**
     * @return array
     */
    public function registerModules()
    {
        $this->modules = [
            'Blog' => new BlogModule(),
        ];

        return $this->modules;
    }
}