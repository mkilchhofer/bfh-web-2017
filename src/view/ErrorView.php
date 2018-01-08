<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class ErrorView
{

    public function render($errorMsg)
    {
        global $lang;

        TemplateHelper::renderHeader();
        echo "<h3>Error</h3>";
        echo "Es sind Fehler augetreten:<br />$errorMsg<br />";
        echo '<a href="javascript:history.back()">Go Back</a>';
        TemplateHelper::renderFooter();
    }
}
