<?php

require_once('model/GearModel.php');
require_once('view/DashboardView.php');

class DashboardController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new GearModel();
        $this->view = new DashboardView($this->model);
    }

    public function show() {
        $this->view->renderList();
    }
}
