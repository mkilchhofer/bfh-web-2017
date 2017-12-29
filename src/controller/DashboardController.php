<?php

require_once('model/SaleModel.php');
require_once('view/DashboardView.php');

class DashboardController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SaleModel();
        $this->view = new DashboardView($this->model);
    }

    public function show() {
        $this->view->renderList();
    }
}
