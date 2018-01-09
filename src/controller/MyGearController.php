<?php

require_once('model/GearModel.php');
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

        $gear = $this->model->getGearById($userId, $id);
        if(isset($gear)) {
            $this->view->renderDetailView($gear);
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

        if($_POST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }

        $gear = new Gear();
        $gear->name = $_POST['name'];
        $gear->currentOwnerId = $_POST['userId'];
        $gear->categoryId = $_POST['categoryId'];
        $gear->purchasePrice = $_POST['purchasePrice'];
        $gear->purchaseDate = $_POST['purchaseDate'];
        $gear->purchasePlace = $_POST['purchasedPlace'];
        $gear->warranty = $_POST['warranty'];

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

        if($_POST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }
        $gearId = (int)$_POST['gearId'];

        $gear = new Gear();
        $gear->name = $_POST['name'];
        $gear->categoryId = (int)$_POST['categoryId'];
        $gear->purchasePrice = (double)$_POST['purchasePrice'];
        $gear->purchaseDate = $_POST['purchaseDate'];
        $gear->purchasePlace = $_POST['purchasedPlace'];
        $gear->warranty = $_POST['warranty'];

        $result = $this->model->updateGear($gearId, $gear);

        if(isset($result)) {
            header("location:/$language/MyGear/showDetail/$gearId");
        }
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

    public function addPicture($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gear = $this->model->getGearById($userId, $id);

        if(isset($gear)){
            $this->view->renderGearUploadPicture($userId, $id);
        } else {
            $this->errorView->render("no permission or gear not found");
        }
    }

    public function uploadPicture() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $MAX_PICTURES = 5;

        if($_POST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }
        $gearId = (int)$_POST['gearId'];
        $description = $_POST['imageDescription'];
        $imagePath = $_FILES['myImage']['tmp_name'];
        $mimeType = $_FILES['myImage']['type'];
        $attachmentData = file_get_contents($imagePath);

        $gear = $this->model->getGearById($userId, $gearId);

        if(isset($gear)){
            if(count($gear->pictureIds) < $MAX_PICTURES) {
                $result = $this->model->uploadPicture($gearId, $description, $attachmentData, $mimeType);
            } else {
                $this->errorView->render("Max allowed pictures: $MAX_PICTURES");
                exit;
            }


            if($result){
                header("Location: /$language/MyGear/showDetail/$gearId");
            } else {
                $this->errorView->render("Insert to DB failed");
                exit;
            }
        }

    }
}
