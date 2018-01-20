<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class ViewBase
{

    public function showError($errorMessage)
    {
        global $lang;

        TemplateHelper::renderHeader();
        echo "<h3>Error</h3>";
        echo "Es sind Fehler augetreten:<br />$errorMessage<br />";
        echo '<a href="javascript:history.back()">Go Back</a>';
        TemplateHelper::renderFooter();
    }
}
