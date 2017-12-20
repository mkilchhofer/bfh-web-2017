<?php
require_once 'core/language.php';
session_start();
$_SESSION=[];
setcookie(session_name(),'',1);
header("location:/$language/User/Login");
