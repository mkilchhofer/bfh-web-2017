<?php

$sites = [
    'dashboard' => [
        'title' => $lang['nav_dashboard'],
        'targetUrl' => '/'.$language.'/Dashboard',
        'loginRequired' => true,
    ],
    'my' => [
        'title' => $lang['nav_mygear'],
        'targetUrl' => '/'.$language.'/MyGear/showList',
        'loginRequired' => true,
    ],
    'marketplace' => [
        'title' => $lang['nav_marketplace'],
        'targetUrl' => '/'.$language.'/Marketplace/showList',
        'loginRequired' => true,
    ],

    'login' => [
        'title' => $lang['nav_login'],
        'targetUrl' => '/'.$language.'/User/Login',
        'loginRequired' => false,
    ],
    'logout' => [
        'title' => $lang['nav_logout'].' ('.$_SESSION['userId'].')',
        'targetUrl' => '/logout.php',
        'loginRequired' => true,
    ],
    'register' => [
        'title' => $lang['nav_register'],
        'targetUrl' => '/'.$language.'/User/Register',
        'loginRequired' => false,
    ],
];
