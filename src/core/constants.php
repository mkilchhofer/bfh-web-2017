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
];

$adminSites = [
    'useradmin' => [
        'title' => $lang['manageUser'],
        'targetUrl' => '/'.$language.'/Admin/manageUsers',
    ],
    'gearadmin' => [
        'title' => $lang['manageGear'],
        'targetUrl' => '/'.$language.'/Admin/manageGear',
    ],
];
