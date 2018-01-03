<?php

require_once('view/ErrorView.php');

class ErrorController
{
    private $view;

    public function __construct() {
        $this->view = new ErrorView($this->model);
    }

    public function show($errorMsg) {
        $this->view->render($errorMsg);
    }
}
