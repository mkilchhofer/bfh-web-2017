<?php

class DB extends mysqli
{
    static private $instance;

    function __construct()
    {
        parent::__construct(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_NAME'));
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
