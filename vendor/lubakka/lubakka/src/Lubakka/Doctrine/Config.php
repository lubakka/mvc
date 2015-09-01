<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-27
 * Time: 19:17
 */

namespace Lubakka\Doctrine;

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Lubakka\Doctrine\EntityManager;

/**
 * Class Config
 * @package Lubakka\Doctrine
 */
class Config
{


    /**
     *
     */
    function __construct()
    {
        return ConsoleRunner::createHelperSet(EntityManager::getEntityManager());
    }
}