<?php
session_start();
$_SESSION=[];
setcookie(session_name(),'',1);
header("location:/User/Login");
