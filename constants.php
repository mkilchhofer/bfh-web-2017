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

$mygear = [
    '1e4e0fae-c4ac-4caf-9731-80b4096fe01d' => [
        'title' => 'iPod',
        'category' => 'Multimedia',
        'purchase_price' => 1121.00,
        'currency' => 'CHF',
        'purchase_date' => "01.01.2010",
        'purchase_location' => "Mediamarkt",
        'picture' => "<svg width=\"100\" height=\"100\"><circle cx=\"50\" cy=\"50\" r=\"40\" stroke=\"green\" stroke-width=\"4\" fill=\"blue\" /></svg>",
    ],
    'ec15264c-5506-468f-ad00-4ee64237ad2a' => [
        'title' => 'Macbook',
        'category' => 'Multimedia',
        'purchase_price' => 444.00,
        'currency' => 'CHF',
        'purchase_date' => "02.03.2011",
        'purchase_location' => "Grosis Brockenstube",
        'picture' => "<svg width=\"100\" height=\"100\"><circle cx=\"50\" cy=\"50\" r=\"40\" stroke=\"green\" stroke-width=\"4\" fill=\"yellow\" /></svg>",
    ],
    'ec15264c-5506-468f-ad00-4ee64237ad2f' => [
        'title' => 'Schmudis Laptop',
        'category' => 'Multimedia',
        'purchase_price' => 2.00,
        'currency' => 'EUR',
        'purchase_date' => "03.03.2011",
        'purchase_location' => "Privatverkauf von Schmudi",
        'picture' => "<svg width=\"100\" height=\"100\"><circle cx=\"50\" cy=\"50\" r=\"40\" stroke=\"green\" stroke-width=\"4\" fill=\"red\" /></svg>",
    ],

];

$strings = [
    'de' =>   [
        'title' => 'Name',
        'category' => 'Kategorie',
        'price' => 'Preis',
        'picture' => 'Bild',
        'currency' => 'Währung',
        'id' => 'Id',
        'purchase_date' => 'Gekauft am',
        'purchase_price' => 'Kaufpreis',
        'purchase_location' => 'Gekauft bei',
        'receipt' => 'Quittung',
    ],
    'en' =>   [
        'title' => 'Name',
        'category' => 'Category',
        'price' => 'Price',
        'picture' => 'Picture',
        'currency' => 'Currency',
        'id' => 'Id',
        'purchase_date' => 'Purchase',
        'purchase_price' => 'Purchase Price',
        'purchase_location' => 'Purchased from',
        'receipt' => 'Receipt',
    ],
];
