<?php

const HOST="db";
const USER="mygear";
const PW="mygear";
const DB_NAME="mygear";

$db=new mysqli(HOST, USER, PW, DB_NAME);

if($db->connect_errno > 0)
    die("Unable to connect to database: ".$db->connect_error);

if(!$db->set_charset("utf8"))
    die("Error loading character set utf8: ".$db->error);
