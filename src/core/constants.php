<?php

$sites = [
    'dashboard' => [
        'title' => $lang['nav_dashboard'],
        'targetUrl' => '/'.$language.'/Dashboard/show',
        'showLoggedIn' => true,
        'showLoggedOut' => false,
    ],
    'my' => [
        'title' => $lang['nav_mygear'],
        'targetUrl' => '/'.$language.'/MyGear/showList',
        'showLoggedIn' => true,
        'showLoggedOut' => false,
    ],
    'marketplace' => [
        'title' => $lang['nav_marketplace'],
        'targetUrl' => '/'.$language.'/Marketplace/showList',
        'showLoggedIn' => true,
        'showLoggedOut' => true,
    ],

    'login' => [
        'title' => $lang['nav_login'],
        'targetUrl' => '/'.$language.'/User/Login',
        'showLoggedIn' => false,
        'showLoggedOut' => true,
    ],
    'logout' => [
        'title' => $lang['nav_logout'].' ('.$_SESSION['firstName'].')',
        'targetUrl' => '/'.$language.'/User/Logout',
        'showLoggedIn' => true,
        'showLoggedOut' => false,
    ],
    'register' => [
        'title' => $lang['nav_register'],
        'targetUrl' => '/'.$language.'/User/Register',
        'showLoggedIn' => false,
        'showLoggedOut' => true,
    ],
    'admin' => [
        'title' => $lang['nav_admin'],
        'targetUrl' => '/'.$language.'/Admin/showUsers',
        'showLoggedIn' => false,
        'showLoggedOut' => false,
    ],
];
