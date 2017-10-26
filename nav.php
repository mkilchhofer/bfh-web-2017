<?php
require_once ('constants.php');

echo "<ul class=\"nav navbar-nav\">";

foreach ($sites as $key => $site) {
    if ($site['pos'] == "left") {
        if ($site['icon'] != null) {
            $icon = "<span class=\"glyphicon " . $site['icon'] . "\"></span> ";
        }
        echo "<li><a href=\"?s=" . $key . "\">" . $icon . $site['title'] . "</a></li>";
    }
}
echo "</ul><ul class=\"nav navbar-nav navbar-right\">";

foreach ($sites as $key => $site) {
    if ($site['pos'] == "right") {
        if ($site['icon'] != null) {
            $icon = "<span class=\"glyphicon " . $site['icon'] . "\"></span> ";
        }
        echo "<li><a href=\"?s=" . $key . "\">" . $icon . $site['title'] . "</a></li>";
    }
}
echo "</ul>";