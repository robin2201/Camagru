<?php
/**
 * Created by PhpStorm.
 * User: rberthie
 * Date: 11/30/16
 * Time: 10:19 AM
 */
class Str{

    static function random($length)
    {
        $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
    }

}