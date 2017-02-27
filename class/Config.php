<?php

/**
 * Created by PhpStorm.
 * User: robin
 * Date: 11/20/16
 * Time: 11:49 AM
 */
class Config
{
    private $settings = [];
    private static $_instance;

    public static function getInstance($file)
    {
        if (!self::$_instance)
        {
            self::$_instance = new Config($file);
        }
        return self::$_instance;
    }

    public function __construct($file)
    {
        $this->settings = require($file);

    }

    public function get($key)
    {
        if (!isset($this->settings[$key]))
        {
            return null;
        }
        return $this->settings[$key];
    }
}