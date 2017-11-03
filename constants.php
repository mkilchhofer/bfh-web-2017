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
        'pos' => 'left',
        'icon' => 'glyphicon-dashboard'
    ],
    'my' => [
        'title' => 'My Gear',
        'pos' => 'left',
        'icon' => 'glyphicon-list'
    ],
    'marketplace' => [
        'title' => 'Marketplace',
        'pos' => 'left',
        'icon' => 'glyphicon-shopping-cart'
    ],
    'about' => [
        'title' => 'About',
        'pos' => 'right',
        'icon' => 'glyphicon-info-sign'
    ],
    'login' => [
        'title' => 'Login',
        'pos' => 'right',
        'icon' => 'glyphicon-user'
    ],
    'logout' => [
        'title' => 'Logout',
        'pos' => 'right',
        'icon' => 'glyphicon-log-in'
    ],
];

$strings = [
    'de' =>   [
        'name' => 'Name',
        'category' => 'Kategorie',
        'price' => 'Preis',
        'picture' => 'Bild',
        'currency' => 'Währung',
        'id' => 'Id',
        'purchaseDate' => 'Gekauft am',
        'purchasePrice' => 'Kaufpreis',
        'purchasePlace' => 'Gekauft bei',
        'receiptImageId' => 'Quittung',
    ],
    'en' =>   [
        'name' => 'Name',
        'category' => 'Category',
        'price' => 'Price',
        'picture' => 'Picture',
        'currency' => 'Currency',
        'id' => 'Id',
        'purchaseDate' => 'Purchase',
        'purchasePrice' => 'Purchase Price',
        'purchasePlace' => 'Purchased from',
        'receiptImageId' => 'Receipt',
    ],
];
