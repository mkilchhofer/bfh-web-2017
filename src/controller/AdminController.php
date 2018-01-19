<?php

require_once('model/UserModel.php');
require_once('view/AdminView.php');

class AdminController
{
    private $model;
    private $view;

    public function __construct() {
        $this->model = new UserModel();
        $this->view = new AdminView($this->model);
    }

    public function showUsers() {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];

        if($_SESSION['isAdmin']){
            $this->view->renderList($userId);
        } else {
            $errorView = new ErrorView();
            $errorView->render('no permissinons');
        }
    }

    public function deleteUser($id) {
        require_once('core/authentication.inc.php');
        $userId = $_SESSION['userId'];
        global $language;

        if($_SESSION['isAdmin'] and $id != $userId){
            $this->model->delete($id);
            header("Location: /$language/Admin/showUsers");
        } else {
            $errorView = new ErrorView();
            $errorView->render('no permissinons to delete user');
        }
    }
}
