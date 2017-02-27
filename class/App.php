<?php

class App{

    static $db = null;

    static function getDatabase()
    {
        $config = Config::getInstance('config/database.php');

        if(!self::$db)
        {
            self::$db = new Database($config->get('db_name'), $config->get('db_user'), $config->get('db_pass'), $config->get('db_host'));

        }
        return self::$db;
    }

    static function getAuth()
    {
        return new Auth(Session::getInstance(), ['restriction_msg' => 'Acces Denied!']);
    }

    static function redirect($page)
    {
        header("Location: $page");
        exit();
    }
}