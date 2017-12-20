<?php
session_start();
header('Cache-control: private'); // IE 6 FIX

if(isSet($_GET['language'])) {
    $language = $_GET['language'];

// register the session and set the cookie
    $_SESSION['language'] = $language;

    setcookie('language', $language, time() + (3600 * 24 * 30));
} else if(isSet($_SESSION['language'])) {
    $language = $_SESSION['language'];
} else if(isSet($_COOKIE['language'])) {
    $language = $_COOKIE['language'];
} else {
    $language = 'en';
}

switch ($language) {
    case 'en':
        $language_file = 'lang.en.php';
        break;
    case 'de':
        $language_file = 'lang.de.php';
        break;
    default:
        $language_file = 'lang.en.php';

}

require_once ('languages/'.$language_file);
