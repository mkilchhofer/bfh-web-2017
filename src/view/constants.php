<?php

$sites = [
    'dashboard' => [
        'title' => 'Dashboard',
        'targetUrl' => '/Dashboard',
        'loginRequired' => true,
    ],
    'my' => [
        'title' => 'My Gear',
        'targetUrl' => '/MyGear/showList',
        'loginRequired' => true,
    ],
    'marketplace' => [
        'title' => 'Marketplace',
        'targetUrl' => '/Marketplace',
        'loginRequired' => true,
    ],

    'login' => [
        'title' => 'Login',
        'targetUrl' => '/User/Login',
        'loginRequired' => false,
    ],
    'logout' => [
        'title' => 'Logout ('.$_SESSION['userId'].')',
        'targetUrl' => '/logout.php',
        'loginRequired' => true,
    ],
    'register' => [
        'title' => 'Register',
        'targetUrl' => '/User/Register',
        'loginRequired' => false,
    ],
];
