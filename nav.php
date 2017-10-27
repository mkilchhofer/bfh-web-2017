<?php
require_once ('constants.php');

echo "<ul class=\"nav navbar-nav\">";

render_navigation($sites,"left");

echo "</ul><ul class=\"nav navbar-nav navbar-right\">";

render_navigation($sites,"right");

echo "</ul>";

function render_navigation($nav, $pos) {
    foreach ($nav as $key => $site) {
        if ($site['pos'] == $pos) {
            if ($site['icon'] != null) {
                $icon = "<span class=\"glyphicon " . $site['icon'] . "\"></span> ";
            }
            echo "<li><a href=\"?s=" . $key . "\">" . $icon . $site['title'] . "</a></li>";
        }
    }
}
