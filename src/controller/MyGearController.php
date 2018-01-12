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
        $attachments = $this->model->getAttachmentsByGearId($id);
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


    /** =============================================================================
     * Attachments
     */


    public function showAttachment($id) {
        $attachment = $this->model->getAttachment($id);
        $this->view->renderAttachment($attachment);
    }
    public function showAttachmentPreview($id) {
        $attachment = $this->model->getAttachment($id);
        $this->view->renderAttachmentResized($attachment ,200);
    }

    public function uploadAttachment($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gear = $this->model->getGearById($userId, $id);
        $attachmentTypes= $this->model->getAttachmentTypes();

        if(isset($gear)){
            $this->view->renderGearUploadAttachment($userId, $id, $attachmentTypes);
        } else {
            $this->errorView->render("no permission or gear not found");
        }
    }

    public function processAttachment() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;
        $cleanPOST = array_map('strip_tags', $_POST);

        if($cleanPOST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }

        $imagePath = $_FILES['attachmentData']['tmp_name'];
        $fileinfo = finfo_open(FILEINFO_MIME_TYPE);

        $attachment = new Attachment();
        $attachment->typeId = (int)$cleanPOST['typeId'];
        $attachment->gearId = (int)$cleanPOST['gearId'];
        $attachment->description = $cleanPOST['attachmentDescription'];
        $attachment->mimeType = finfo_file($fileinfo, $imagePath);
        $attachment->data = file_get_contents($imagePath);

        if ($attachment->typeId == 1){
            //Picture
            $allowed = array("image/jpeg", "image/gif", "image/png");
        } else {
            $allowed = array("image/jpeg", "image/gif", "image/png", "application/pdf");
        }

        if(!in_array($attachment->mimeType, $allowed)) {
            $this->errorView->render('Only jpg, gif and png files are allowed.');
            exit;
        }
        $gear = $this->model->getGearById($userId, $attachment->gearId);
        if(isset($gear)){
            echo "okay";
            $result = $this->model->addAttachment($attachment);

            if($result){
                header("Location: /$language/MyGear/showDetail/$attachment->gearId");
            } else {
                $this->errorView->render("Insert to DB failed");
                exit;
            }
        }
    }

    public function deleteAttachment($id) {
        global $language;
        if(empty($id)){
            echo "id not set";
            exit;
        }
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $attachment = $this->model->getAttachment($id);
        $gear = $this->model->getGearById($userId, $attachment->gearId);

        if($gear->currentOwnerId != $userId){
            echo "permission denied";
            exit;
        }

        $result = $this->model->deleteAttachment('Picture', $id, $attachment->gearId);

        if($result){
            header("Location: /$language/MyGear/showDetail/$attachment->gearId");
        } else {
            echo "error on delete";
        }

    }
}
