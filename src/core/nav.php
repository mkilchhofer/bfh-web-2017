<?php

global $language;
global $lang;
require_once  'core/constants.php';
$url = substr($_SERVER['REQUEST_URI'], 3);

$adminMenu = '';
if( $_SESSION['isAdmin']) {
    $adminMenu .= '<li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" 
                         aria-haspopup="true" aria-expanded="false">'.$lang['nav_admin'].'
                     </a>
                     <div class="dropdown-menu" aria-labelledby="dropdown_admin">';
    foreach ($adminSites as $key => $site) {
            $adminMenu .= '<a class="dropdown-item" href="' . $site['targetUrl'] . '">'  . $site['title'] . '</a>';
    }
    $adminMenu .= '</div></li>';
}

$menu = '';
if (isset($_SESSION['userId'])) {
    foreach ($sites as $key => $site) {
        if( $site['showLoggedIn']) {
            $menu .= "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
        }
    }
} else {
    foreach ($sites as $key => $site) {
        if( $site['showLoggedOut']) {
            $menu .= "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
        }
    }
}

echo <<< NAV
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">MyGear.</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          {$menu}
          {$adminMenu}
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
NAV;
