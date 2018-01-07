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
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gearList = $this->model->getGearByOwner($userId);
        $this->view->renderGearList($gearList);
    }

    public function showDetail($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gear = $this->model->getGearById($userId, $id);
        $this->view->renderDetailView($gear);
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

        if($_POST['userId'] != $userId){
            echo "something went wrong";
            exit;
        }

        $gear = new Gear();
        $gear->name = $_POST['name'];
        $gear->currentOwnerId = $_POST['userId'];
        $gear->categoryId = $_POST['categoryId'];
        $gear->purchasePrice = $_POST['purchasePrice'];
        $gear->purchaseDate = $_POST['purchaseDate'];
        $gear->purchasePlace = $_POST['purchasedPlace'];

        $result = $this->model->addGear($userId, $gear);

        $this->view->renderGearFormResult($result);
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

        var_dump($_POST);
    }

    public function showReceipt($id) {
        $attachment = $this->model->getAttachment('Receipt', $id);
        $this->view->renderAttachment($attachment);
    }

    public function showPicture($id) {
        $attachment = $this->model->getAttachment('Picture', $id);
        $this->view->renderAttachment($attachment);
    }
    public function showPictureResized($id) {
        $attachment = $this->model->getAttachment('Picture', $id);
        $this->view->renderAttachmentResized($attachment ,200);
    }
}
