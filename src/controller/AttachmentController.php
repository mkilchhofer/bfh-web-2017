<?php
require_once('model/AttachmentModel.php');
require_once('model/GearModel.php');
require_once('view/AttachmentView.php');
require_once('view/ErrorView.php');

class AttachmentController
{
    private $model;
    private $view;
    private $errorView;

    public function __construct() {
        $this->model = new AttachmentModel();
        $this->view = new AttachmentView($this->model);
        $this->errorView = new ErrorView();
    }

    public function show($id) {
        $attachment = $this->model->getAttachment($id);
        $this->view->renderAttachment($attachment);
    }
    public function preview($id) {
        $attachment = $this->model->getAttachment($id);
        $this->view->renderAttachmentResized($attachment ,200);
    }

    public function upload($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        $gearModel = new GearModel();

        $gear = $gearModel->getGearById($userId, $id);
        $attachmentTypes= $this->model->getAttachmentTypes();

        if(isset($gear)){
            $this->view->renderGearUploadAttachment($userId, $id, $attachmentTypes);
        } else {
            $this->errorView->render("no permission or gear not found");
        }
    }

    public function process() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        $gearModel = new GearModel();
        global $language;
        $cleanPOST = array_map('strip_tags', $_POST);

        if($cleanPOST['userId'] != $userId){
            $this->errorView->render("something went wrong");
            exit;
        }

        if($_FILES['attachmentData']['size'] > 1048576) { // 1*1024*1024
            $this->errorView->render("size too big");
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
        $gear = $gearModel->getGearById($userId, $attachment->gearId);
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

    public function delete($id) {
        global $language;
        $gearModel = new GearModel();
        if(empty($id)){
            echo "id not set";
            exit;
        }
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $attachment = $this->model->getAttachment($id);
        $gear = $gearModel->getGearById($userId, $attachment->gearId);

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
