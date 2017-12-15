<?php
require_once ('constants.php');

echo "<ul class=\"navbar-nav mr-auto\">";

foreach ($sites as $key => $site) {
    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
}

echo "</ul>";
