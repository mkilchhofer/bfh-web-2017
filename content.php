<?php

$s = $_GET['s'];
if(empty($s))
    $s="dashboard";

switch ($s) {
    case "gearview":
        include_once('gearview.php');
        break;
    case "my":
        include_once('gearlist.php');
        break;
    case "add":
        include_once('gearadd.php');
        break;
    case "marketplace":
        echo "marketplace";
        break;
    case "about":
        echo "about";
        break;
    default:
        echo "site not found";
}
