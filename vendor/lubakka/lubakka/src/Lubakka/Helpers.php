<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 22:48
 */

namespace Lubakka;

/**
 * Class Helpers
 * @package Lubakka
 */
class Helpers {

    /**
     * @param $array
     *
     * @return object
     */
    public static function toObject($array)
    {
        if (is_array($array)) {
            return (object)$array;
        } else {
            return $array;
        }
    }

} 