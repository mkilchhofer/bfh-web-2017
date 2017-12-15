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
        'targetUrl' => '/?s=dashboard',
        'pos' => 'left',
        'icon' => 'glyphicon-dashboard'
    ],
    'my' => [
        'title' => 'My Gear',
        'targetUrl' => '/?s=my',
        'pos' => 'left',
        'icon' => 'glyphicon-list'
    ],
    'marketplace' => [
        'title' => 'Marketplace',
        'targetUrl' => '/?s=marketplace',
        'pos' => 'left',
        'icon' => 'glyphicon-shopping-cart'
    ],
    'about' => [
        'title' => 'About',
        'targetUrl' => '/?s=about',
        'pos' => 'right',
        'icon' => 'glyphicon-info-sign'
    ],
    'login' => [
        'title' => 'Login',
        'targetUrl' => '/login.php',
        'pos' => 'right',
        'icon' => 'glyphicon-user'
    ],
    'logout' => [
        'title' => 'Logout',
        'targetUrl' => '/logout.php',
        'pos' => 'right',
        'icon' => 'glyphicon-log-in'
    ],
];
