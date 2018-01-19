<?php

global $language;
global $lang;
require_once  'core/constants.php';

echo <<< NAV1
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">MyGear.</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
NAV1;

if (isset($_SESSION['userId'])) {
    foreach ($sites as $key => $site) {
        if( $site['showLoggedIn']) {
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
        }
    }
} else {
    foreach ($sites as $key => $site) {
        if( $site['showLoggedOut']) {
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
        }
    }
}

if( $_SESSION['isAdmin']) {
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $sites['admin']['targetUrl'] . ">"  . $sites['admin']['title'] . "</a></li>";
}

$url = substr($_SERVER['REQUEST_URI'], 3);

echo <<< NAV2
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{$lang['nav_language']} ({$language})</a>
            <div class="dropdown-menu" aria-labelledby="dropdown_language">
              <a class="dropdown-item" href="/de{$url}">Deutsch</a>
              <a class="dropdown-item" href="/en{$url}">English</a>
            </div>
          </li>
        </ul>
    </div>

</nav>
NAV2;
