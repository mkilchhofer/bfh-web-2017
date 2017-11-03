<?php

$db=new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

if($db->connect_errno > 0)
    die("Unable to connect to database: ".$db->connect_error);

if(!$db->set_charset("utf8"))
    die("Error loading character set utf8: ".$db->error);
