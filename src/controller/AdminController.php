<?php

require_once('model/UserModel.php');
require_once('view/AdminView.php');

class AdminController
{
    private $userModel;
    private $gearModel;
    private $view;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->gearModel = new GearModel();
        $this->view = new AdminView($this->userModel);
    }

    public function manageUsers() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        if($_SESSION['isAdmin']){
            $this->view->renderList($userId);
        } else {
            $this->view->showError('no permissinons');
        }
    }

    public function deleteUser($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;

        if($_SESSION['isAdmin'] and $id != $userId){
            $this->userModel->delete($id);
            header("Location: /$language/Admin/manageUsers");
        } else {
            $this->view->showError('no permissinons to delete user');
        }
    }

    public function manageGear() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        $gearItems = $this->gearModel->getGears();

        if($_SESSION['isAdmin']){
            $this->view->renderGearList($gearItems);
        } else {
            $this->view->showError('no permissinons to delete user');
        }
    }

    public function deleteGear($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;

        if ($_SESSION['isAdmin'] and $id != $userId) {
            $this->gearModel->deleteGearById($id);
            header("Location: /$language/Admin/manageGear");
        } else {
            $this->view->showError('no permissinons to delete gear');
        }
    }
}
