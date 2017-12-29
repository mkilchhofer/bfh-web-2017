<?php

require_once('model/SaleModel.php');
require_once('view/MarketplaceView.php');

class MarketplaceController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new SaleModel();
        $this->view = new MarketplaceView($this->model);
    }

    public function showList() {
        $this->view->renderList();
    }

    public function showDetail($id) {

        $this->view->renderDetailView($id);
    }
}
