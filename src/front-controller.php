<?php

require_once('controller/MyGearController.php');
require_once('controller/UserController.php');

//Parse URL
$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$urlComponents = explode('/', $path);

//Check for controller
if (isset($urlComponents[1])) {
    $controllerName = $urlComponents[1] . 'Controller';
} else {
    http_response_code(404);
    die();
}

//Check for action
if (isset($urlComponents[2])) {
    $action = $urlComponents[2];
}

//Check for action parameter
if (isset($urlComponents[3])) {
    $actionParam = $urlComponents[3];
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
