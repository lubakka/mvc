<?php
/**
 * Created by PhpStorm.
 * User: lboykov
 * Date: 15-1-27
 * Time: 19:17
 */

namespace Kernel\Doctrine;


class Config
{


    function __construct()
    {
        return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet(EntityManager::getEntityManager());
    }
}