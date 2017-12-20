<?php
require_once ('constants.php');

echo <<< NAV1
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">MyGear.</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
NAV1;

foreach ($sites as $key => $site) {
    if($site['loginRequired'] == isset($_SESSION[userId])) {
        echo "<li class=\"nav-item\"><a class=\"nav-link\" href=" . $site['targetUrl'] . ">"  . $site['title'] . "</a></li>";
    }
}

echo <<< NAV2
        </ul>
    </div>

</nav>
NAV2;
