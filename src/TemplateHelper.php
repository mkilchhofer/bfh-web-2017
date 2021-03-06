<?php

class TemplateHelper {

    public static function renderHeader($title = null) {
        echo <<< HEAD
<!DOCTYPE html>
<html lang="en">
<head>
    <title>MyGear. {$title}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <link href="/css/custom.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/4574efd0ac.js"></script>
    <link rel="stylesheet" href="/modules/blueimp-gallery/css/blueimp-gallery.min.css">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16" />
</head>
<body>
<script src="/modules/blueimp-gallery/js/blueimp-gallery.min.js"></script>

<!-- The Gallery as lightbox dialog, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
HEAD;

        require_once('core/nav.php');

        echo <<< EOF
<main role="main" class="container">
<div class="container">
EOF;
    }

    public static function renderFooter() {
        global $mygearVersion;
        $githubVersion = "<a target=\"_blank\" href=\"https://github.com/mkilchhofer/bfh-web-2017/commit/$mygearVersion\">GitHub $mygearVersion</a>";
        $contributors = "<a target=\"_blank\" href=\"https://github.com/mkilchhofer/\">mkilchhofer</a> and
                         <a target=\"_blank\" href=\"https://github.com/mschmutz/\">mschmutz</a>";
        echo <<< EOF
</div>
    </main>
    <footer class="footer">
      <div class="container">
        <span class="text-muted">MyGear. {$githubVersion} - Created with ♡ by {$contributors}</span>
      </div>
    </footer>
</body>
</html>
EOF;
    }
}
