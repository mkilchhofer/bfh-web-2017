<?php

if(isset($_GET['lang'])) {
    setcookie ( 'language', $_GET['lang'], time() + 60*60*24*30);
    $language=$_GET['lang'];
} elseif(isset( $_COOKIE["language"] )) {
    $language=$_COOKIE["language"];
} else {
    $language= "de";
    setcookie ( 'language', $language, time() + 60*60*24*30);
}


$sites = [
    'dashboard' => [
        'title' => 'Dashboard',
        'targetUrl' => '/Dashboard'
    ],
    'my' => [
        'title' => 'My Gear',
        'targetUrl' => '/MyGear'
    ],
    'marketplace' => [
        'title' => 'Marketplace',
        'targetUrl' => '/Marketplace'

    ],

    'login' => [
        'title' => 'Login',
        'targetUrl' => '/User/Login'
    ],
    'logout' => [
        'title' => 'Logout',
        'targetUrl' => '/User/Logout'
    ],
    'register' => [
        'title' => 'Register',
        'targetUrl' => '/User/Register'
    ],
];
