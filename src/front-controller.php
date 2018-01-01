<?php

require_once('controller/MyGearController.php');
require_once('controller/DashboardController.php');
require_once('controller/UserController.php');
require_once('controller/MarketplaceController.php');

//Parse URL
$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$urlComponents = explode('/', $path);



// Language
if(isset($urlComponents[1])) {
    $language = $urlComponents[1];
    //var_dump($urlComponents[1]);
} else {
    $language = 'en';
}

switch ($language) {
    case 'en':
        $language_file = 'lang.en.php';
        break;
    case 'de':
        $language_file = 'lang.de.php';
        break;
    default:
        $language_file = 'lang.en.php';
}

require_once ('languages/'.$language_file);



//Check for controller
if (isset($urlComponents[2])) {
    $controllerName = $urlComponents[2] . 'Controller';
} else {
    http_response_code(404);
    die();
}

//Check for action
if (isset($urlComponents[3])) {
    $action = $urlComponents[3];
}

//Check for action parameter
if (isset($urlComponents[4])) {
    $actionParam = $urlComponents[4];
}

//Build controller
if (class_exists($controllerName)) {
    $controller = new $controllerName();
} else {
    http_response_code(404);
    die();
}

//Invoke Controller with action and action parameter
if (isset($action) and isset($actionParam)) {
    if (method_exists($controller, $action)) {
        $controller->{$action}($actionParam);
    } else {
        http_response_code(404);
        die();
    }
}

//Invoke Controller with action only
if (isset($action) and !isset($actionParam)) {
    if (method_exists($controller, $action)) {
        $controller->{$action}();
    } else {
        http_response_code(404);
        die();
    }
}
