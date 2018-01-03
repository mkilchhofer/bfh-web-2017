<?php
require_once(__DIR__ . '/../TemplateHelper.php');

class ErrorView
{

    public function render($errorMsg)
    {
        global $lang;

        TemplateHelper::renderHeader();
        echo "<h3>Error</h3>";
        echo "Es sind Fehler augetreten:<br />$errorMsg";
        if(!empty(getenv('OPENSHIFT_BUILD_COMMIT'))){
            echo "Version auf GitHub: ".substr(getenv('OPENSHIFT_BUILD_COMMIT'),0,7);
        }
        TemplateHelper::renderFooter();
    }
}
