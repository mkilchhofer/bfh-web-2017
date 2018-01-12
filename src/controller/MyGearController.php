<?php

require_once('model/GearModel.php');
require_once('model/AttachmentModel.php');
require_once('view/MyGearView.php');
require_once('view/ErrorView.php');

class MyGearController
{
    private $model;
    private $view;
    private $errorView;

    public function __construct() {
        $this->model = new GearModel();
        $this->view = new MyGearView($this->model);
        $this->errorView = new ErrorView();
    }

    public function showList() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gearList = $this->model->getGearByOwner($userId);
        $this->view->renderGearList($gearList);
    }

    public function showDetail($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $attachmentModel = new AttachmentModel();

        $gear = $this->model->getGearById($userId, $id);
        $attachments = $attachmentModel->getAttachmentsByGearId($id);
        if(isset($gear)) {
            $this->view->renderDetailView($gear, $attachments);
        } else {
            $this->errorView->render("no permission or gear not found");
        }
    }

    public function add() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $lang;

        $categories = $this->model->getCategories();
        $this->view->renderGearForm($lang['addNewDevice'], $userId, $categories, new Gear(),'store');
    }

    public function store(){
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $cleanPOST = array_map('strip_tags', $_POST);

        if($cleanPOST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }

        $gear = new Gear();
        $gear->name = $cleanPOST['name'];
        $gear->currentOwnerId = $cleanPOST['userId'];
        $gear->categoryId = $cleanPOST['categoryId'];
        $gear->purchasePrice = $cleanPOST['purchasePrice'];
        $gear->purchaseDate = $cleanPOST['purchaseDate'];
        $gear->purchasePlace = $cleanPOST['purchasedPlace'];
        $gear->warranty = $cleanPOST['warranty'];

        $result = $this->model->addGear($userId, $gear);

        if(isset($result)) {
            header("location:/$language/MyGear/showDetail/$result");
        }
    }

    public function edit($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $lang;

        $categories = $this->model->getCategories();
        $gear = $this->model->getGearById($userId, $id);
        if(isset($gear)) {
            $this->view->renderGearForm($lang['editDevice'], $userId, $categories, $gear,'../update');
        } else {
            echo "Nothing to edit...";
        }
    }

    public function delete($id) {
        global $language;
        if(empty($id)){
            echo "id not set";
            exit;
        }
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gear = $this->model->getGearById($userId, $id);

        if($gear->currentOwnerId != $userId){
            echo "permission denied";
            exit;
        }

        $result = $this->model->deleteGearById($userId, $id);

        if($result){
            header("location:/$language/MyGear/showList");
        } else {
            echo "error on delete";
        }

    }

    public function update() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $cleanPOST = array_map('strip_tags', $_POST);

        if($cleanPOST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }

        $gear = new Gear();
        $gear->name = $cleanPOST['name'];
        $gear->id = (int)$cleanPOST['gearId'];
        $gear->categoryId = (int)$cleanPOST['categoryId'];
        $gear->purchasePrice = (double)$cleanPOST['purchasePrice'];
        $gear->purchaseDate = $cleanPOST['purchaseDate'];
        $gear->purchasePlace = $cleanPOST['purchasedPlace'];
        $gear->warranty = $cleanPOST['warranty'];

        $result = $this->model->updateGear($gear);

        if(isset($result)) {
            header("location:/$language/MyGear/showDetail/$gear->id");
        }
    }
}
