<?php

require_once('model/GearModel.php');
require_once('view/MyGearView.php');

class MyGearController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new GearModel();
        $this->view = new MyGearView($this->model);
    }

    public function showList() {
        $this->view->renderGearList();
    }

    public function showDetail($id) {

        $this->view->renderDetailView($id);
    }

    public function add() {
        $this->view->renderGearAdd();
    }

    public function store(){
        $this->view->renderGearStore();
    }

    public function delete() {

    }
}
