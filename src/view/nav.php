<?php
require_once ('constants.php');

foreach ($sites as $key => $site) {
    if($site['loginRequired'] == isset($_SESSION[userId])) {
        echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
    }
}
