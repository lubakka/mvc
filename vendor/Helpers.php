<?php
/**
 * Created by PhpStorm.
 * User: Lboikov
 * Date: 14-9-30
 * Time: 22:48
 */

namespace Vendor;


class Helpers {

    public static function toObject($array)
    {
        if (is_array($array)) {
            return (object)$array;
        } else {
            return $array;
        }
    }

} 