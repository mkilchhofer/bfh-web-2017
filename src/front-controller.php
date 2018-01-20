<?php

session_start();
require_once('controller/MyGearController.php');
require_once('controller/DashboardController.php');
require_once('controller/UserController.php');
require_once('controller/MarketplaceController.php');
require_once('controller/AttachmentController.php');
require_once('controller/AdminController.php');
$errorMessage="";

//Version
$mygearVersion = substr(getenv('OPENSHIFT_BUILD_COMMIT'),0,7);

//Parse URL
$path = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
$urlComponents = explode('/', $path);

// Serve requirements of lecturer
if($urlComponents[1] === "source.zip") {
    header("Location: https://github.com/mkilchhofer/bfh-web-2017/archive/development.zip", true, 301);
    exit;
}
if($urlComponents[1] === "db.sql") {
    header("Location: https://github.com/mkilchhofer/bfh-web-2017/raw/development/db/mygear.sql", true, 301);
    exit;
}

// Language
if(!empty($urlComponents[1])) {
    $urlLanguage = $urlComponents[1];
} else {
    // Take Browser Language
    $urlLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

    if(isset($_SESSION['userId'])) {
        header("Location: http://".$_SERVER['HTTP_HOST']."/$urlLanguage/Dashboard/show", true, 301);
        exit;
    } else {
        header("Location: http://".$_SERVER['HTTP_HOST']."/$urlLanguage/Marketplace/showList",true, 301);
        exit;
    }
}

switch ($urlLanguage) {
    case 'en':
        $language='en';
        break;
    case 'de':
        $language='de';
        break;
    default:
        $language='en';
}

require_once ('languages/lang.'.$language.'.php');

//Check for controller
if (!empty($urlComponents[2])) {
    $controllerName = $urlComponents[2] . 'Controller';
} else {
    $errorMessage .= "- Controller unset<br />";
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
    $errorMessage .= "- Controller class does not exist<br />";
}

//Invoke Controller with action and action parameter
if (isset($action) and isset($actionParam)) {
    if (method_exists($controller, $action)) {
        $controller->{$action}($actionParam);
    } else {
        $errorMessage .= "- Invoke Controller with action and action parameter failed<br />";
    }
}

//Invoke Controller with action only
if (isset($action) and !isset($actionParam)) {
    if (method_exists($controller, $action)) {
        $controller->{$action}();
    } else {
        $errorMessage .= "- Invoke Controller with action only failed<br />";
    }
}

//Display error(s)
if (!empty($errorMessage)){
    $view = new ViewBase();
    $view->showError($errorMessage);
}
