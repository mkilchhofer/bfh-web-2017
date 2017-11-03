<?php

class DB extends mysqli
{
    static private $instance;

    function __construct()
    {
        parent::__construct($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);
    }

    static public function getInstance()
    {
        if (!self::$instance) {
            @self::$instance = new DB();
        }

        if (self::$instance->connect_errno > 0) {
            die("Unable to connect to database: " . self::$instance->connect_error);
        }

        if (!self::$instance->set_charset("utf8")) {
            die("Error loading character set utf8: " . self::$instance->error);
        }

        return self::$instance;
    }

    static public function doQuery($sql)
    {
        return self::getInstance()->query($sql);
    }
}
